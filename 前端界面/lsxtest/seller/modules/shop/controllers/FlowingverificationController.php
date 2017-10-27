<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 9:27
 *流水码验证
 */
namespace app\modules\shop\controllers;


use common\models\UserOrder;
use common\models\ShopBanquet;
use common\models\BanquetOrder;
use common\models\User;

use yii\db\Query;
use yii\web\Controller;

class FlowingverificationController extends Controller
    {
    //流水码验证首页
    public $enableCsrfValidation = false;
    public function init ()
    {
        $init_class = new \seller\controllers\InitController();
        $init_class->actionClassName();
    }
    public function actionIndex (){
        return $this->render('index.tpl');
    }
//流水码验证信息回调
    public function actionResult (){
        $session = \Yii::$app->session;
        $shop_usermsg = $session->get('seller_msg');
        if(\Yii::$app->request->isAjax && $shop_usermsg['shop_id']&&$_POST['buy_number']) {
            $result = UserOrder::find()->where('buy_number="'.$_POST['buy_number'].'" and shop_id='.$shop_usermsg['shop_id'].'')->asArray()->one();
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if($result) {
                if($result['is_check']) {
                    return ['status'=>0,'msg'=>'该流水码验证码已验证,请不要重复验证!'];
                }
                if($result['order_status']==2) {
                    return ['status'=>0,'msg'=>'该流水席的订单已退款,无法验证!'];
                }
                if($result['order_status']==3) {
                    return ['status'=>0,'msg'=>'该流水席已完成,验证码失效!'];
                }
                if($result['order_status']==0) {
                    return ['status'=>0,'msg'=>'该流水席正在拼席中,无法验证!'];
                }
                UserOrder::updateAll([
                        'is_check' => 1, 
                        'order_status' => 3, 
                        'check_time' => time()
                    ], [
                        'record_id' => $result['record_id']
                    ]);
                $query = new Query();
                $query->select('bo.order_id,bo.banquet_id,bo.banquet_sn,bo.banquet_number,sb.banquet_url,bo.banquet_name,bo.banquet_title,bo.order_amount,bo.banquet_time,bo.shop_id,u.user_name,uo.pay_amount,uo.buy_seats,uo.record_id,uo.buy_number,uo.is_check,uo.check_time');
                $query->from(UserOrder::tableName() . ' uo');
                $query->leftJoin(BanquetOrder::tableName() . ' bo','uo.order_id = bo.order_id');
                $query->leftJoin(ShopBanquet::tableName() . ' sb', 'bo.banquet_id = sb.banquet_id');
                $query->leftJoin(User::tableName() . ' u', 'uo.user_id = u.user_id');
                $query->where([
                    'uo.shop_id' => $shop_usermsg['shop_id'],
                    'uo.record_id' => $result['record_id']
                ]);
                $msg = $query->one();
                if ($msg) {
                    $msg['banquet_time'] = date('Y-m-d H:i:s',$msg['banquet_time']);
                    $msg['check_time'] = date('Y-m-d H:i:s',$msg['check_time']);
                    $msg['banquet_url'] = imageurl($msg['banquet_url']);
                }
                $res=['status'=>1,'msg'=>$msg];
            }else{
                $res=['status'=>0,'msg'=>'没有该流水码验证'];
            }
                return $res;
        }
    }
    //流水码验证历史记录
    public function actionHistory (){
        $session = \Yii::$app->session;
        $shop_usermsg = $session->get('seller_msg');
        if($shop_usermsg['shop_id']) {
            if(\Yii::$app->request->isAjax&&$shop_usermsg['shop_id']) 
            {
                $query = new Query();
                $query->select('bo.order_id,bo.banquet_id,bo.banquet_sn,bo.banquet_number,sb.banquet_url,bo.banquet_name,bo.banquet_title,bo.order_amount,bo.banquet_time,bo.shop_id,u.user_name,uo.pay_amount,uo.buy_seats,uo.record_id,uo.buy_number,uo.is_check,uo.check_time');
                $query->from(UserOrder::tableName() . ' uo');
                $query->leftJoin(BanquetOrder::tableName() . ' bo','uo.order_id = bo.order_id');
                $query->leftJoin(ShopBanquet::tableName() . ' sb', 'bo.banquet_id = sb.banquet_id');
                $query->leftJoin(User::tableName() . ' u', 'uo.user_id = u.user_id');
                $query->where([
                    'uo.shop_id' => $shop_usermsg['shop_id']
                ]);
                $page_first = $_POST['page']*10;
                $page_lase = $page_first+10;
                $query->limit($page_lase)->offset($page_first);
                $history = $query->orderBy('uo.check_time desc')->all();
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                 if ($history) {
                    foreach ($history as $key => $value) {
                        $history[$key]['banquet_time'] = date('Y-m-d H:i:s',$value['banquet_time']);
                        $history[$key]['check_time'] = date('Y-m-d H:i:s',$value['check_time']);
                        $history[$key]['banquet_url'] = imageurl($value['banquet_url']); 

                    }
                    $result=['status'=>1,'history'=>$history];
                    
                }else{
                    $result=['status'=>0];
                }
                return $result;
            }
            return $this->render('history.tpl');
        }
    }

}