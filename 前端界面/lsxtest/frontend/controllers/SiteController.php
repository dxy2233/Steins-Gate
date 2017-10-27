<?php
namespace frontend\controllers;

use common\models\UserAccount;
use common\website\JSSDK;
use Flc\Alidayu\App;
use Flc\Alidayu\Client;
use Flc\Alidayu\Requests\AlibabaAliqinFcSmsNumSend;
use Yii;
use yii\base\InvalidParamException;
use yii\base\UserException;
use yii\db\Exception;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\website\MobileWeixin;
use yii\db\Query;
use common\models\User;
use common\website\Cls_http;
use yii\web\Cookie;

error_reporting(0);

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $session;

    public $app_key = 'wxb6548c05943dc4a3';

    public $app_secret = '424d140e70e7b4288e7d8af696c524dd';

    public $accessToken;

    public $expires_in;

    public $type = 'weixin';

    public $website;

    public $layout=false;

    public function init ()
    {
        $this->session = \Yii::$app->getSession();
//        $this->type = Filter::request('type');
//        $this->website = new MobileWeixin($this->app_key, $this->app_secret);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    public function actionIndex()
    {
        $params['bbb'] = 'aaa';
        Yii::$app->session->set('user_id',1);
        Yii::$app->session->set('openid','oRRXY04bdFf0qUQftq6OXK490DIQ');
        return $this->render('index.tpl',$params);
    }

    public function actionLogin ()
    {
        $redirectUrl = Yii::$app->getSession()->getFlash('redirectUrl','');
        if (empty($redirectUrl)) {
            $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->app_key.'&redirect_uri='.urlencode(homeurl('site/act-login')).'&response_type=code&scope=snsapi_userinfo#wechat_redirect';
        }else{
            $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->app_key.'&redirect_uri='.urlencode(homeurl('site/act-login')).'&response_type=code&scope=snsapi_userinfo&state='.$redirectUrl.'#wechat_redirect';
        }
        return $this->redirect($url);
    }

    /*
     * 微信登录页面回调地址
     */
    public function actionActLogin ()
    {
        $accessToken = $this->getAccessToken();
        if(empty($accessToken)){
            throw new Exception('未知错误');
        }
        // 获取登录者信息
        $user_info = $this->getMessage($accessToken);

        //检查是否存在用户
        $isRegs=User::checkIsByOpenid($user_info['openid']);
        if (empty($isRegs)) {
            $tr=Yii::$app->db->beginTransaction();
            $userModel=new User();
            $userModel->user_name = $user_info['nickname'];
            $userModel->openid = $user_info['openid'];
            $userModel->nickname = $user_info['nickname'];
            $userModel->sex = $user_info['sex'];
            $userModel->image_path = $user_info['headimgurl'];
            $userModel->reg_ip = real_ip();
            $userModel->last_time = gmtime();
            $userModel->last_ip = real_ip();
            $userModel->visit_count = 1;
            $userModel->acess_token = $this->accessToken;
            $userModel->expire_in = $this->expires_in;
            $userModel->user_status = 1;
            if ($userModel->insert(true) ===false) {
                $tr->rollBack();
            }
            $userAccountModel = new UserAccount();
            $userAccountModel->user_id = $userModel->user_id;
            $userAccountModel->create_time = gmtime();
            if ($userAccountModel->insert(true) ===false) {
                $tr->rollBack();
            }
            $tr->commit();
        }else{
            $userModel=$isRegs;
            if ($userModel->user_status == 0) {
                throw new UserException('你的账号已被禁用');
            }
            $userModel->reg_ip = real_ip();
            $userModel->last_time = gmtime();
            $userModel->last_ip = real_ip();
            $userModel->visit_count = $userModel->visit_count +1;
            $userModel->acess_token = $this->accessToken;
            $userModel->expire_in = $this->expires_in;
            $userModel->save(false);
        }
        $userInfo=$userModel->attributes;
        $sign=makeSignature(['openid' => $user_info['openid'],'user_id' => $userInfo['user_id'],'sign' => 'cqzgkjlsx'],'cqzgkjlsx');
        Yii::$app->session->set($user_info['openid'].'lsx',$sign);
        Yii::$app->session->set('user_id',$userInfo['user_id']);
        Yii::$app->session->set('openid',$user_info['openid']);
        if (!empty(Yii::$app->session->get('location',''))) {
            Yii::$app->session->remove('location');
        }
        $state = Yii::$app->request->get('state','');
        if (empty($state)) {
            $this->redirect(homeurl('index'));
        }else{
            $this->redirect(homeurl($state));
        }
    }

    /**
     * 获取授权token
     *
     * @param string $code 通过get_authorize_url获取到的code
     */
    public function getAccessToken($Wopenid='')
    {
//        https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code
        if (!empty($Wopenid)) {
            $userInfo=User::checkIsByOpenid($Wopenid);
            if ($userInfo->expire_in <=gmtime() && !empty($userInfo->acess_token)) {
                return $userInfo->acess_token;
            }else{
                return $this->redirect(homeurl('site/login'));
            }
        }
        $code = (!Yii::$app->request->get('code','') ? '' : Yii::$app->request->get('code'));
        $url = sprintf('https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code', $this->app_key, $this->app_secret, $code);
        $clshttp = new Cls_http();
        $result = $clshttp->http($url);
        $result_arr = json_decode($result, true);
        $access_token = $result_arr['access_token'];
        $this->expires_in = $result_arr['expires_in'] + gmtime();
        $openid = $result_arr['openid'];
        $_SESSION['openid'] = $openid;
        return $access_token;
    }

    /**
     * 获取授权后的微信用户信息
     *
     * @param string $access_token
     * @param string $open_id
     */
    public function getMessage($accessToken)
    {
        $url = sprintf('https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s', $accessToken, $_SESSION['openid']);
        $clshttp = new Cls_http();
        $result = $clshttp->http($url);
        $result_arr = json_decode($result, true);
        return $result_arr;
    }

    /**
     * 传入手机号码。发送短信，60秒内只能获取一次
     * $mobile  传入的手机号码
     * $openid  获取用户微信的openid
     */
    public function actionCheckMobile()
    {
        if (!Yii::$app->request->isAjax) {
            echo json_encode(array('code'=>0,'message'=>'非法请求!'));
            exit;
        }
        $mobile=Yii::$app->request->get('mobile');
        $mobilereg='/^[1][3,5,7,8]\d{9}$/';
        if (!preg_match($mobilereg,$mobile)) {
            echo json_encode(array('code'=>0,'message'=>'手机号码格式错误'));
            exit;
        }
        $issetMobile = User::find()->where(['mobile' => $mobile])->one();
        if (!empty($issetMobile)) {
            echo json_encode(array('code'=>0,'message'=>'该手机号已经存在!'));
            exit;
        }
        $session=Yii::$app->session;
        $mobilecode=$session->get($mobile.'code');
        if (!empty($mobilecode)) {
            if ($session->get($mobile.'Expiration') > gmtime()) {
                echo json_encode(array('code'=>0,'message'=>'60秒内不能重复获取'));
                exit;
            }
        }
        $code=rand(100000 , 999999);
        $openid=$session->get('openid');
        if (empty($openid)) {
            echo json_encode(array('code'=>0,'message'=>'缺少必须参数'));
            exit;
        }
        $nickname=User::getNicknameByOpenid($openid);
        $result=$this->SendTextMessages($mobile ,$code ,$nickname);
        if (isset($result->result) || $result->result->success) {
            $session->set($mobile.'code',$code);
            $session->set($mobile.'Expiration',gmtime()+60);
            echo json_encode(array('code'=>1,'message'=>'验证码发送成功'));
            exit;
        }else{
            echo json_encode(array('code'=>0,'message'=>'发送失败,'.$result->sub_msg));
            exit;
        }
    }

    /**
     * @param $mobile
     * @param $code
     * @param $username
     * @return false|object
     * 异步用户传入手机号码，验证码，用户昵称发送短信
     */
    public function SendTextMessages ($mobile  ,$code ,$nickname)
    {
        // 配置信息
        $config = Yii::$app->params['AliSms'];
        $client =new Client(new App($config));
        $req = new AlibabaAliqinFcSmsNumSend();
        $req->setRecNum($mobile)->setSmsParam(['code' => $code , 'product' => $nickname])->setSmsFreeSignName('流水席')->setSmsTemplateCode('SMS_62555410');
        return $client->execute($req);
        // 返回结果
    }

    /**
     * @return string
     * 获取需要的参数无用
     */
//    public function actionGetJssdkOption()
//    {
//        if (!Yii::$app->request->isAjax) {
//            echo json_encode(array('code'=>0,'message'=>'非法请求!'));
//            exit;
//        }
//        $weixinconfig['appid'] = \Yii::$app->params['UserWechat']['app_id'];
//        $weixinconfig['appsecret'] = \Yii::$app->params['UserWechat']['secret'];
//        $jssdk = new JSSDK($weixinconfig['appid'], $weixinconfig['appsecret']);
//        $signPackage = $jssdk->GetSignPackage();
//        echo  json_encode($signPackage);
//    }

    /**
     * 将获取到的地址保存到session中
     */
    public function actionSetLocation()
    {
        if (!Yii::$app->request->isAjax) {
            echo json_encode(array('code'=>0,'message'=>'非法请求!'));
            exit;
        }
        $lng =Yii::$app->request->get('lng','');//经度
        $lat =Yii::$app->request->get('lat','');//维度
        $session = Yii::$app->session;
        $session->set('location',['lng'=>$lng ,'lat'=>$lat]);
        $location=$session->get('location');
        if (!empty($location)) {
            echo json_encode(['code'=>1]);exit();
        }
        echo json_encode(['code'=>-1]);exit();
    }

    /**
     * 设置微信菜单
     */
    public function actionSetWxMenu () {
        $ci = curl_init();
        curl_setopt($ci, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->app_key."&secret=".$this->app_secret);
        curl_setopt($ci, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ci, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ci, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ci);
        if (curl_errno($ci)) {
            return curl_error($ci);
        }
        curl_close($ci);
        $tmpInfo = json_decode($tmpInfo,true);

        //菜单数组
        $data=[
            "button" => [
                ["type" => "view",
                "name" => "进入流水席首页",
                "url" => "http://lsx.earthwa.com/index"
                ]
            ]
        ];
        $data = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$tmpInfo['access_token']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfos = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }

        curl_close($ch);
        return json_decode($tmpInfos,true);
    }
}
