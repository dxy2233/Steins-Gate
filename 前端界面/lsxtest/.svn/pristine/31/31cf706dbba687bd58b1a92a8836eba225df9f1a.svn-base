<?php
/**
 * 第三方银行调用回调控制器
 */
namespace frontend\controllers;
error_reporting(0);
use yii\web\Controller;
use service\payment\PayResult;
use service\payment\weixin\AppWeixinPay;
use service\payment\weixin\WeixinPay;
use Yii;
use common\models\BackOrder;

class RespondController extends Controller
{
    /**
     * 微信支付后端修改地址
     */
    public $enableCsrfValidation=false;

    public function actionBackWeixin()
    {
        $xml = file_get_contents('php://input');
//        return $xml;
        $wxpay = new WeixinPay();
        $res = $wxpay->respond($xml);
        return $res;
    }

}