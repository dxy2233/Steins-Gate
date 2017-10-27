<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 9:27
 */
namespace app\modules\payment\controllers;
error_reporting(0);
use common\models\BanquetOrder;
use common\models\Shop;
use common\models\ShopBanquet;
use common\models\UserOrder;
use frontend\controllers\DefaultController;
use yii\web\Controller;
use service\payment\weixin\WeixinPay;
use common\website\JSSDK;

class PaymentController extends DefaultController{


    public $layout = false;

    public function __construct ($id, $module, $config = [])
    {
        $module = \Yii::$app->getModule('payment');
        parent::__construct($id, $module, $config);
    }

    public function actionPay (){
        $params = [];
        $info = \Yii::$app->request->get('info');
        $info2 = json_decode(urldecode($info),true);
//        var_dump($info);die;
        $total_fee = $info2['number']*$info2['price']-$info2['surplus'];
        $out_trade_no = UserOrder::getRecordsn();
        $payobj = new WeixinPay();
        $params = [
            'out_trade_no' => $out_trade_no,
            'subject' => '贞观流水席',
            'total_fee' => $total_fee,
            'body' => '订单支付',
            'txnAmt' => $total_fee * 100,
            'attach' => $info
//            'pay_log_id' => $log_id
        ];
        $pay_info = $payobj->goPay($params);
//        var_dump($pay_info);die;
        return $this->render('weixin_pay.tpl',[
            'pay_info' => $pay_info
        ]);
    }

    public function actionResult ()
    {
        $user_id = \Yii::$app->getSession()->get('user_id');
        $user_order = UserOrder::find()->where(['user_id'=>$user_id])->orderBy('record_id desc')->asArray()->one();
        $banquet_order = BanquetOrder::find()->where(['order_id'=>$user_order['order_id']])->asArray()->one();
        $banquet_order['banquet_time'] = date('Y-m-d H:i',$banquet_order['banquet_time']);
        $shop_info = Shop::findOne($user_order['shop_id']);
        $shop_banquet = ShopBanquet::findOne($user_order['banquet_id']);
        /*微信分享代码块*/
        $weixinconfig['appid'] = \Yii::$app->params['UserWechat']['app_id'];
        $weixinconfig['appsecret'] = \Yii::$app->params['UserWechat']['secret'];
        $jssdk = new JSSDK($weixinconfig['appid'], $weixinconfig['appsecret']);
        $signPackage = $jssdk->GetSignPackage();
        $is_user = $banquet_order['reservation_people'];
        $sign =makeSignature(['is_user'=>$is_user],'cqzgkjlsx');
        $share = homeurl()."/goods/goods/info?id={$shop_banquet['banquet_id']}&shop_id={$shop_info['shop_id']}&order_id={$banquet_order['order_id']}&sign={$sign}&type=share";

//        $params['signPackage'] = $signPackage;
//        var_dump(1111);die;
        return $this->render('result.tpl',[
            'user_order' => $user_order,
            'banquet_order' => $banquet_order,
            'shop_info' => $shop_info,
            'shop_banquet' => $shop_banquet,
            'signPackage' => $signPackage,
            'share' => $share
        ]);
    }

    public function actionWeixin()
    {
//        $res = file_get_contents("php://input");
//        file_put_contents('/tmp/weixin.log',$res);
//        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
//        $xml = json_encode($xml);
//        var_dump(1);die;
        file_put_contents('/tmp/weixin.log','bbbbb');
        $wxpay = new WeixinPay();
        $wxpay->respond();
    }


}