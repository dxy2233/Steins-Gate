<?php
/**
 * Created by PhpStorm.
 * User: ysl
 * Date: 2017/9/14
 * Time: 14:17
 */
namespace common\models;
error_reporting(0);
use Yii;
use yii\db\ActiveRecord;

class BackOrder extends ActiveRecord{

    public static function tableName()
    {
        return '{{%back_order}}';
    }

    /*
     * 退款方法ysl
     * @record_id 用户的订单id
     * 暂时只支持微信全额退款
     * @return bool
     */
    static public function toRefund($record_id = '')
    {
        file_put_contents('/tmp/weixin.log','333',FILE_APPEND);
        //通过record_id查询出用户的付款金额，调用微信退款接口即可，同时将饭票的钱退回。
        $user_order  = UserOrder::findOne($record_id);
        if($user_order->order_status == 2)
        {
            return false;
        }
        //生成一个退款定单
        $BackOrderModel = new BackOrder();
        $BackOrderModel->record_id = $record_id;
        $BackOrderModel->order_id = $user_order->order_id;
        $BackOrderModel->return_sn = static::getBackorderSn();
//        $BackOrderModel->return_sn = gmtime();
        $BackOrderModel->buy_seats = $user_order->buy_seats;
        $BackOrderModel->buy_price = $user_order->buy_price;
        $BackOrderModel->return_amount = $user_order->pay_amount;
        $BackOrderModel->pay_meal_ticket = $user_order->pay_meal_ticket;
        $BackOrderModel->user_id = $user_order->user_id;
        $BackOrderModel->meal_ticket = 0;
        $BackOrderModel->pay_status = 0;
        $BackOrderModel->create_time = time();

        $res = $BackOrderModel->insert();
//        file_put_contents('/tmp/weixin.log','444',FILE_APPEND);
        if($user_order->pay_amount > 0)
        {
            $weixin = new \service\payment\weixin\WeixinPay();
            $params = array('transaction_id' => $user_order->pay_serianlno, 'out_refund_no' => $BackOrderModel->return_sn, 'total_fee' => $user_order->pay_amount * 100, 'refund_fee' => $user_order->pay_amount * 100);
            $result = $weixin->goRefund($params);      //微信返还成功
        }else{
            $result = true;
        }


        if($result === true)
        {
            $BackOrderModel2 = BackOrder::findOne($BackOrderModel->return_id);
            $BackOrderModel2->pay_status = 1;
            $BackOrderModel2->update([
                'pay_status'
            ]);

            $UserOrderModel = UserOrder::findOne($record_id);
            $UserOrderModel->order_status = 2;
            $UserOrderModel->update([
                'order_status'
            ]);

            $BanquetOrderModel = BanquetOrder::findOne($user_order->order_id);
            $BanquetOrderModel->joined_peoples -= $BackOrderModel2->buy_seats;
            $BanquetOrderModel->update([
                'joined_peoples'
            ]);

            if($BanquetOrderModel->joined_peoples == 0)
            {
                $BanquetOrderModel2 = BanquetOrder::findOne($user_order->order_id);
                $BanquetOrderModel2->order_status = 2;
                $BanquetOrderModel2->update([
                    'order_status'
                ]);
            }

            $UserAccountModel = UserAccount::find()->where(['user_id'=>$user_order->user_id])->one();
            $UserAccountModel->meal_balance += $user_order->pay_meal_ticket;
            $UserAccountModel->update([
                'meal_balance'
            ]);

            if($user_order->pay_meal_ticket > 0)
            {
                $TicketDetailModel = new TicketDetail();
                $TicketDetailModel->ticket_status = 2;
                $TicketDetailModel->ticket_amount = $user_order->pay_meal_ticket;
                $TicketDetailModel->ticket_order = $BackOrderModel->return_id;
                $TicketDetailModel->shop_id = $user_order->shop_id;
                $TicketDetailModel->user_id = $user_order->user_id;
                $TicketDetailModel->caeate_time = time();
                $TicketDetailModel->insert();
            }

            return true;
        }

        return false;
    }

    /*
     *获取退款订单号
     *@return order_sn string
     */
//    static public function getBackorderSn()
//    {
//        $lastbackorder =  file_get_contents("../backorder_sn.txt");
//        $now = date('Ymd',gmtime());
//        if($now != substr($lastbackorder,0,8))
//        {
//            $order_sn = date('Ymd',gmtime()).'00001';
//            file_put_contents("../backorder_sn.txt",date('Ymd',gmtime()).'00001');
//        }else{
//            $tradeno = file_get_contents("../backorder_sn.txt");
//            $tradeno += 1;
//            $order_sn = $tradeno;
//            file_put_contents("../backorder_sn.txt",$tradeno);
//        }
//        $order_sn .= 'B';
//        return $order_sn;
//    }
    static public function getBackorderSn($pay_type = NULL)
    {
        $lastorder =  file_get_contents("backorder_sn.txt");
        $now = date('Ymd',time());
        if($now != substr($lastorder,0,8))
        {
            $record_sn = 'R'.date('YmdHi',time()).'001';
            file_put_contents("backorder_sn.txt",date('Ymd',time()).'001');
        }else{
            $tradeno = file_get_contents("backorder_sn.txt");
            $tradeno += 1;
            //$tradeno = str_pad($tradeno, 5, '0', STR_PAD_LEFT);
//            $record_sn = $tradeno;
            $liushuihao = substr($tradeno,8,3);
            $record_sn = 'R'.date('YmdHi',time()).str_pad($liushuihao, 3, '0', STR_PAD_LEFT);
            file_put_contents("backorder_sn.txt",$tradeno);
        }
//        $record_sn .= 3;
        return $record_sn;
    }


}