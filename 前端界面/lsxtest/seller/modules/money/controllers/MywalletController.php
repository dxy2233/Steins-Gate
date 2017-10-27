<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 9:27
 * 商家资金管理控制器
 */
namespace app\modules\money\controllers;


use common\models\ShopAccount;
use common\models\ShopBank;
use common\models\ShopRecord;
use common\models\ShopAccountDetail;
use yii\db\Query;
use yii\web\Controller;

class MywalletController extends Controller
    {
    //获取初始用户信息
    public $shop_usermsg;
    public function init ()
    {
        $init_class = new \seller\controllers\InitController();
        $init_class->actionClassName();
        $session = \Yii::$app->session;
        $this->shop_usermsg = $session->get('seller_msg');
    }

    public $enableCsrfValidation = false;

    //商家资金管理首页
    public function actionIndex (){
        if($this->shop_usermsg['shop_id']) {
            $msg = ShopAccount::find()->select('total_balnce')->where('shop_id='.$this->shop_usermsg['shop_id'].'')->asArray()->one();
        }
        $params['msg'] = $msg?$msg:'';
        return $this->render('index.tpl',$params);
    }
    //绑定银行卡
    public function actionBondcard (){
        $bank_list = ShopBank::find()->select('*')->where('shop_id='.$this->shop_usermsg['shop_id'].'')->asArray()->all();
        if ($bank_list) {
            foreach ($bank_list as $key => $value) {
                $num_back = strlen($bank_list[$key]['bank_account']);
                $bank_list[$key]['bank_account'] = substr($bank_list[$key]['bank_account'],0,$num_back-9)."****".substr($bank_list[$key]['bank_account'],$num_back-5,$num_back);
            }
        }
        
        $params['bank_list'] = $bank_list;
        return $this->render('bondcard.tpl',$params);
    }
    //添加绑定的银行卡
    public function actionAddbond (){
        if(\Yii::$app->request->isPost&&$_POST['withdraw_name']&&$_POST['bank_account']&&$_POST['withdraw_bank']){
            $model = new ShopBank();
            $model->withdraw_name = $_POST['withdraw_name'];
            $model->bank_account = $_POST['bank_account'];
            $model->withdraw_bank = $_POST['withdraw_bank'];
            $model->shop_id = $this->shop_usermsg['shop_id'];
            $model->create_time = time();
            $model->update_time = time();
            $result = $model->insert(false);
            if($result) {
                return $this->redirect(array('/money/mywallet/bondcard'));
            }
            //else{
            //    return $this->redirect(array('/shop/center/index'));
            //}
        }
        return $this->render('addbond.tpl');
    }
    //删除绑定的银行卡
    public function actionDelete (){
        if(\Yii::$app->request->isAjax&&$_POST['bank_id']){
           $result = ShopBank::deleteAll([
                                'bank_id' => $_POST['bank_id']
                            ]);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if($result) {
                $msg = ['status'=>1];
            }else{
                $msg = ['status'=>0];
            }
            return $msg;
        }
        return $this->render('addbond.tpl');
    }

    //银行卡提现
    public function actionApply (){
        if ($_GET) {
            ShopBank::updateAll([
                        'update_time' => time()
                    ], [
                        'bank_id' => $_GET['bank_id']
                    ]);
        }
        if (\Yii::$app->request->isPost&&$_POST['bank_id']) {
            // bank_id
            $msg = ShopAccount::find()->select('total_balnce,request_blance')->where('shop_id='.$this->shop_usermsg['shop_id'].'')->asArray()->one();
            $money = $msg['total_balnce']-$_POST['request_amount'];
            if ($money<0) {
                echo "<script>alert('提现申请失败,余额不足');window.location.href='apply';</script>";
                die();
            }

            $total_get_money = ShopRecord::find()->select('sum(request_amount) as total_get_money')->where('shop_id='.$this->shop_usermsg['shop_id'].' and request_status=0')->asArray()->one();
            if(($total_get_money['total_get_money']+$_POST['request_amount'])>$msg['total_balnce']) {
                echo "<script>alert('提现申请失败,提现申请审核中的金额加上当前提现金额大于商家余额！');window.location.href='apply';</script>";
                die();
            }
            $bank_list = ShopBank::find()->select('*')->where('shop_id='.$this->shop_usermsg['shop_id'].' and bank_id='.$_POST['bank_id'].'')->asArray()->one();
            $model = new ShopRecord();
            $model->request_amount = $_POST['request_amount']; 
            $model->withdraw_name = $bank_list['withdraw_name'];
            $model->withdraw_bank = $bank_list['withdraw_bank'];
            $model->bank_account = $bank_list['bank_account'];
            $model->shop_id = $this->shop_usermsg['shop_id'];
            $model->request_time = time();
            $model->update_time = time();
            $model->request_status = 0;
            $result = $model->insert(false);
            //if($result) {
                // $account = ShopAccount::updateAll([
                //         'total_balnc6t6e' => $money,
                //         'request_blance' => $msg['request_blance']+$_POST['request_amount'],
                //         'update_time' => time()
                //     ], [
                //         'shop_id' => $this->shop_usermsg['shop_id']
                //     ]);
                //$modeldetail = new ShopAccountDetail();
                //$modeldetail->account_status = 2;
                //$modeldetail->acount_amount = $_POST['request_amount'];
                //$modeldetail->account_order = $model['request_id'];
                //$modeldetail->shop_id = $this->shop_usermsg['shop_id'];
                //$modeldetail->caeate_time = time();
                //$result = $modeldetail->insert(false);
                //return $this->redirect(array('/money/mywallet/result'));
            //}
        }
        $total_balnce = ShopAccount::find()->select('total_balnce')->where('shop_id='.$this->shop_usermsg['shop_id'].'')->orderBy('update_time desc')->asArray()->one();
        $bank_list = ShopBank::find()->select('*')->where('shop_id='.$this->shop_usermsg['shop_id'].'')->orderBy('update_time desc')->asArray()->one();
        if (!$bank_list) {
                echo "<script>alert('请先绑定银行卡,再进行提现操作');window.location.href='addbond';</script>";
                die();
            //var_dump('请先绑定银行卡');
        }
        $num_back = strlen($bank_list['bank_account']);
        $bank_list['bank_account'] = substr($bank_list['bank_account'],0,$num_back-9)."****".substr($bank_list['bank_account'],$num_back-5,$num_back);
        $params['bank_list'] = $bank_list;
        $params['total_balnce'] = $total_balnce['total_balnce'];
        return $this->render('apply.tpl',$params);
    }

    //悬着选择默认提现银行卡
    public function actionSelectcard (){
       $bank_list = ShopBank::find()->select('*')->where('shop_id='.$this->shop_usermsg['shop_id'].'')->asArray()->all();
        $params['bank_list'] = $bank_list;
        return $this->render('selectcard.tpl',$params);
    }
    //商家提现记录
    public function actionResult (){
        if(\Yii::$app->request->isAjax&&$this->shop_usermsg['shop_id']) 
            {
                $query = new Query();
                $query->select('sr.*');
                $query->from(ShopRecord::tableName() . ' sr');
                $query->where([
                    'sr.shop_id' => $this->shop_usermsg['shop_id']
                ]);
                $page_first = $_POST['page']*10;
                $page_lase = $page_first+10;
                $query->limit($page_lase)->offset($page_first);
                $sr_list = $query->orderBy('sr.update_time desc')->all();
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                 if ($sr_list) {
                    foreach ($sr_list as $key=>$value) {
                        $sr_list[$key]['request_time'] = date('Y-m-d H:i:s',$value['request_time']);
                    }
                    $result=['status'=>1,'sr_list'=>$sr_list];
                    
                }else{
                    $result=['status'=>0];
                }
                return $result;
            }
        return $this->render('result.tpl');
    }
    //商家账户明细
    public function actionDetailed (){
        $accountdetail = ShopAccountDetail::find()->where('shop_id='.$this->shop_usermsg['shop_id'].'')->orderBy('caeate_time desc')->asArray()->all();
        $params['accountdetail'] = $accountdetail;

        if(\Yii::$app->request->isAjax&&$this->shop_usermsg['shop_id']) 
            {
                $query = new Query();
                $query->select('sad.*');
                $query->from(ShopAccountDetail::tableName() . ' sad');
                $query->where([
                    'sad.shop_id' => $this->shop_usermsg['shop_id']
                ]);
                $page_first = $_POST['page']*10;
                $page_lase = $page_first+10;
                $query->limit($page_lase)->offset($page_first);
                $sad_list = $query->orderBy('caeate_time desc')->all();
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                 if ($sad_list) {
                    foreach ($sad_list as $key=>$value) {
                        $sad_list[$key]['caeate_time'] = date('m-d H:i',$value['caeate_time']);
                    }
                    $result=['status'=>1,'sad_list'=>$sad_list];
                    
                }else{
                    $result=['status'=>0];
                }
                return $result;
            }
        return $this->render('detailed.tpl');
    }

}