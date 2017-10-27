<?php
/**
 * Created by PhpStorm.
 * User: Ysl
 * Date: 2017/9/14
 * 个人中心控制器
 */
namespace app\modules\user\controllers;

use app\user\controllers\RecordController;
use common\models\BackOrder;
use common\models\BanquetOrder;
use common\models\User;
use common\models\UserOrder;
use common\website\JSSDK;
use frontend\controllers\DefaultController;
use yii\base\UserException;
use yii\web\Controller;

header("Content-type:text/html;charset=utf-8");

class CenterController extends DefaultController{

    public $enableCsrfValidation=false;
//    public $layout = 'main.tpl';

    /*
     * 个人中心首页
     */
    public function actionIndex()
    {
//        $time = time();
//        $banquet_order = BanquetOrder::find()->select('*')->where('order_status = 1 and (banquet_time + 30*60) <='.$time)->asArray()->all();
//        var_dump($banquet_order);die;
        $user_id = \Yii::$app->getSession()->get('user_id');
        if(!$user_id)
        {
            throw new UserException('用户不存在！');
        }
        $params = [];
        $params['user_info'] = User::getUserInfo($user_id);
        return $this->render('index.tpl',$params);
    }
    public function actionTestLogin()
    {
        \Yii::$app->session->set('openid','oRRXY02qaDVcj2XcjBWs7LUGTW2A');
        \Yii::$app->session->set('user_id',4);die();
    }

    /*
     * 个人中心详情页面，可做信息的修改
     */
    public function actionInfo()
    {
        $this->layout = 'user_main.tpl';
        $user_id = \Yii::$app->request->get('id');
        $params = [];
        //处理下年龄的信息
        $user_info = User::getUserInfo($user_id);
        if (!empty($user_info['birthday'])) {
            $user_info['age'] = date('Y',gmtime()) - substr($user_info['birthday'],0,4);
        }else{
            $user_info['age'] ='';
        }
        $params['user_info'] = $user_info;
        /*微信分享代码块*/
        $weixinconfig['appid'] = \Yii::$app->params['UserWechat']['app_id'];
        $weixinconfig['appsecret'] = \Yii::$app->params['UserWechat']['secret'];
        $jssdk = new JSSDK($weixinconfig['appid'], $weixinconfig['appsecret']);
        $signPackage = $jssdk->GetSignPackage();
        $params['signPackage'] = $signPackage;
        return $this->render('info.tpl',$params);
    }

    /*
     * 个人中心，信息修改页
     * @id int user_id
     * @type string 修改信息的类型
     */

    public function actionUpdate()
    {
        $this->layout = 'user_main.tpl';
        if(\Yii::$app->request->isAjax)
        {
            $response = \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $type = \Yii::$app->request->post('type');
            $user_id = \Yii::$app->request->post('user_id');
            $updateinfo = \Yii::$app->request->post($type);
            if( $type == 'birthday' ){
                if (strtotime($updateinfo) !==false) {
                    if (strtotime($updateinfo) >= gmtime()) {
                        return [
                            'code' => 0,
                            'message' => '年龄非法!'
                        ];
                    }
                }else{
                    return [
                        'code' => 0,
                        'message' => '年龄非法!'
                    ];
                }
            }
            $user = User::findOne($user_id);
            $user->$type = $updateinfo;
            $result = $user->update(false,[
                $type
            ]);
            if($result !== false){
                return [
                    'code' => 1,
                    'message' => '修改成功'
                ];
            }else{
                return [
                    'code' => 0,
                    'message' => '修改失败'
                ];
            }

        }
        $user_id = \Yii::$app->request->get('id');
        $type = \Yii::$app->request->get('type');

        if(empty($user_id) || empty($type)) {
            throw new UserException('参数丢失');
        }

        $user_info = User::getUserInfo($user_id);
        $params = [];
        $params['user_id'] = $user_info['user_id'];
        $params[$type] = $user_info[$type];

        return $this->render('update_'.$type.'.tpl',$params);
    }

    /*
     * 个人中心设置
     */
    public function actionSetting ()
    {
        $this->layout = 'user_main.tpl';
        $user = User::getUserId();
        $result = User::find()->select('mobile')->where(['user_id'=>$user])->one();
        return $this->render('setting.tpl',['mobile' => $result->mobile]);
    }

    public function actionBindMobile()
    {
        $this->layout = 'empty.tpl';
        if (!\Yii::$app->request->isGet) {
            $mobile = \Yii::$app->request->post('mobile');
            $verification = \Yii::$app->request->post('verification');
            $session=\Yii::$app->session;
            $mobilecode=$session->get($mobile.'code');
            $times = $session->get($mobile.'Expiration');
            if (isset($mobilecode) && isset($times)) {
                if ($times < gmtime()) {
                    echo json_encode(['code' => 0,'message' => '验证码失效，请重新获取验证!']);exit();
                }
                if ($mobilecode !=$verification) {
                    echo json_encode(['code' => 0,'message' => '短信验证码错误!']);exit();
                }
                $openid = User::getUserOpenid();
                if (empty($openid)) {
                    echo json_encode(['code' => 0,'message' => '参数错误!']);exit();
                }
                $mobileInfo = $this->getMobileInfo($mobile);
                $userModel= User::find()->where(['openid' => $openid])->one();
                $userModel->mobile_validated =1;
                $userModel->mobile =$mobile;
                $userModel->reg_time =gmtime();
                $userModel->mobile_supplier =$mobileInfo['isp'];
                $userModel->mobile_province =$mobileInfo['province'];
                $userModel->mobile_city =$mobileInfo['city'];
                if ($userModel->update() ===false) {
                    echo json_encode(['code' => 0,'message' => '绑定手机号码失败!']);exit();
                }
                echo json_encode(['code' => 1,'message' => '绑定手机号码成功!']);exit();
            }
            exit();
        }
        $openid = User::getUserOpenid();
        if (!empty($openid)) {
            $userModel= User::find()->where(['openid' => $openid])->one();
            if (!empty($userModel)) {
                if ($userModel->mobile_validated == 1) {
                    return $this->redirect('/index');
                }
            }
            $data = \Yii::$app->request->get('data');
            return $this->render('bind_mobile.tpl',['data' =>$data]);
        }
    }

    /**
     * 发送get请求
     * @param string $url
     * @return bool|mixed
     */
    function request_get($url = '')
    {
        if (empty($url)) {
            return false;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        $package = curl_exec($ch);
        //获取curl连接句柄的信息
        $httpInfo = curl_getinfo($ch);

        $info = array_merge(array($package), array($httpInfo));
        curl_close($ch);
        return $info;
    }

    /**
     * @param $mobile
     * 获取手机号码信息
     */
    public function getMobileInfo($mobile){
        //获取手机归属地
        header("content-type:text/html;charset=utf-8");             //设置utf8
        $url = "http://sj.apidata.cn/?mobile=".$mobile;                //api接口地址
//        $res = $this->request_get($url);
        $res = file_get_contents($url);
        $res_arr = json_decode($res,true);
        if($res_arr['status']=='1'){                                //如果成功获取数据
            $area['province'] = $res_arr['data']['province'];
            $area['city'] = $res_arr['data']['city'];
            $area['isp'] = $res_arr['data']['isp'];

        }
        return $area;
    }
    /**
     * 通过淘宝IP接口获取IP地理位置
     * @param string $ip
     * @return: string
     * USAGE: php -f taobao_ip.php 121.207.247.202
     **/
    public function getIpInfo($ip=''){
        if(empty($ip)) $ip=real_ip();  //get_client_ip()为tp自带函数，如没有，自己百度搜索。此处就不重复复制了
        $url='http://ip.taobao.com/service/getIpInfo.php?ip='.$ip;
        $result = file_get_contents($url);
        $result = json_decode($result,true);
        if($result['code']!==0 || !is_array($result['data'])) return false;
        return $result['data'];
    }

    /**
     * 绑定手机
     */
    public function actionCheckMobile(){
        if (\Yii::$app->request->isGet) {
            $user_id = User::getUserId();
            $result = User::find()->select('mobile_validated,mobile')->where(['user_id'=>$user_id])->one();
            if (!empty($result)) {
                if ($result->mobile_validated ==1 || !empty($result->mobile)) {
                    echo json_encode(['code' =>0,'message' =>'用户已经绑定手机号']);exit();
                }
            }
            $data =homeurl('user');
            $url ='/user/center/bind-mobile?data='.urlencode($data);
            echo json_encode(['code' =>1,'data' =>$url]);exit();
        }
    }


    //从微信服务器端下载图片到本地服务器
    public function actionWxDownImg() {
        $media_id =\Yii::$app->request->get('media_id');
        //调用多媒体文件下载接口
        $url = "https://api.weixin.qq.com/cgi-bin/media/get?access_token={$this->getAccessToken()}&media_id=$media_id";
        //用curl请求，返回文件资源和curl句柄的信息
        $filebody = file_get_contents($url);//通过接口获取图片流
        $filename = 'header_'.uniqid().'.jpg';            //定义图片名字及格式
        $upload_dir = substr(__DIR__,0,-34).'/uploads/header/'.date('Ymd');//保存路径，以时间作目录分层
        $mkpath = $upload_dir;
        if(!is_dir($mkpath)){
            if(!mkdir($mkpath)){
                echo json_encode(['code' => 0,'message' => '没有创建的权限']);exit();
            }
            if(!chmod($mkpath,0755)){//若服务器在阿里云上不建议使用0644
                echo json_encode(['code' => 0,'message' => '没有权限设置权限']);exit();
            }
        }
        $savepath = $upload_dir.'/'.$filename;
        if(@file_put_contents($savepath, $filebody)){//写入图片流生成图片
            $image_path = imageurl("header/".substr($upload_dir,-8).'/'.$filename);
            $user_id =User::getUserId();
            $userModel = User::find()->where(['user_id'=>$user_id])->one();
            $userModel->image_path =$image_path;
            if ($userModel->save(false) ===false) {
                echo json_encode(['code' => 0,'message' => '上传头像失败']);exit();
            }
            echo json_encode(['code' => 1,'message' => '上传头像成功']);exit();
        }else{
            echo json_encode(['code' => 0,'message' => '上传头像失败']);exit();
        }
    }

    private function getAccessToken() {
        $userInfo=User::checkIsByOpenid(User::getUserOpenid());
        if ($userInfo->expire_in <=gmtime() && !empty($userInfo->acess_token)) {
            return $userInfo->acess_token;
        }else{
            $appid = \Yii::$app->params['UserWechat']['app_id'];
            $appsecret = \Yii::$app->params['UserWechat']['secret'];
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
            $rurl = @file_get_contents($url);
            $rurl = json_decode($rurl,true);
            if(array_key_exists('errcode',$rurl)){
                return '';
            }else{
                $access_token = $rurl['access_token'];
                return $access_token;
            }
        }
    }
}