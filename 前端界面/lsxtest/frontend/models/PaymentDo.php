<?php
namespace frontend\models;

use common\models\BackOrder;
use common\models\BanquetOrder;
use common\models\ShopBanquet;
use common\models\TicketDetail;
use common\models\UserAccount;
use common\models\UserOrder;
use Yii;
use yii\base\Model;

class PaymentDo extends Model
{
    public $enableCsrfValidation = FALSE;

    /* 整理后，所需要的参数 */
    public $params = [
        "record_sn" => '',       // 操作订单sn
        "pay_serianlno" => '',   // 第三方的流水号
        "success" => 0,     // 处理状态
        "total_fee" => 0,        // 处理金额 (分)
        "attach" => ''       //哥的数据包
    ];

    public function payment ()
    {
        if(empty($this->params['record_sn']) || empty($this->params['pay_serianlno']))
        {
            return false;
        }
        if(empty($this->params['success']))
        {
            return false;
        }
        $user_order_info = json_decode($this->params['attach'] ,true);
        $xxx = UserOrder::find()->select('*')->where(['record_sn'=>$this->params['record_sn']])->asArray()->one();
        if(!empty($xxx)){
            return false;
        }
//        var_dump($user_order_info);die;
        $tr = \Yii::$app->db->beginTransaction();
        //生成一个用户订单
        $UserInfoModel = new UserOrder();
        $UserInfoModel->order_id = $user_order_info['order_id'];   //
        $UserInfoModel->banquet_id = $user_order_info['banquet_id'];//
        $banquet = ShopBanquet::findOne($user_order_info['banquet_id']);
        $UserInfoModel->shop_id = $banquet->shop_id;
        $UserInfoModel->record_sn = $this->params['record_sn'];
        $UserInfoModel->buy_seats = $user_order_info['number'];
        $UserInfoModel->buy_price = $user_order_info['price'];
//        $UserInfoModel->pay_amount = $user_order_info['number'] * $user_order_info['price'] - $user_order_info['surplus'];
        $UserInfoModel->pay_amount = $this->params['total_fee'];
        $UserInfoModel->pay_serianlno = $this->params['pay_serianlno'];
        $UserInfoModel->pay_meal_ticket = empty($user_order_info['surplus']) ? 0 : $user_order_info['surplus'];
        $UserInfoModel->buy_number = UserOrder::getBuyNumber(6);
        $UserInfoModel->is_check = 0;
        $UserInfoModel->user_id = $user_order_info['user_id'];
        $UserInfoModel->meal_ticket = 0;
        $UserInfoModel->pay_status = 1;
        $UserInfoModel->order_status = 0;
        $UserInfoModel->pay_time = gmtime();
        $UserInfoModel->is_comment = 0;
//        $UserInfoModel->comment_time = $user_order_info['order_id'];
        if(!$UserInfoModel->insert())
        {
             $tr->rollBack();
            return false;
        }
        //席单中已加入人数+1
        $BanquetOrderModel = BanquetOrder::findOne($user_order_info['order_id']);
        $BanquetOrderModel->joined_peoples += $user_order_info['number'];
        if(!$BanquetOrderModel->update(false,[
            'joined_peoples'
        ])){
            $tr->rollBack();
            return false;
        }

        //扣除用户资金账户
        $UserAccountModel = UserAccount::find()->where(['user_id'=>$user_order_info['user_id']])->one();
        $UserAccountModel->total_orders = $UserAccountModel->total_orders + 1;
        $UserAccountModel->meal_balance = $UserAccountModel->meal_balance - $user_order_info['surplus'];
        $UserAccountModel->total_amount = $UserAccountModel->total_amount + $user_order_info['number'] * $user_order_info['price'];
        $UserAccountModel->update_time = gmtime();
        if(!$UserAccountModel->save()){
            $tr->rollBack();
            return false;
        }
        //如果饭票抵押大于0，则记录一条饭票消费明细
        if($user_order_info['surplus'] > 0)
        {
            $TicketDetailModel = new TicketDetail();
            $TicketDetailModel->ticket_status = 0;
            $TicketDetailModel->ticket_amount = -$user_order_info['surplus'];
            $TicketDetailModel->ticket_order = $UserInfoModel->record_id;
            $TicketDetailModel->shop_id = $UserInfoModel->shop_id;
            $TicketDetailModel->user_id = $user_order_info['user_id'];
            $TicketDetailModel->caeate_time = gmtime();
            if(!$TicketDetailModel->insert())
            {
                $tr->rollBack();
                return false;
            }
        }

        if($BanquetOrderModel->total_peoples < $BanquetOrderModel->joined_peoples)
        {
            $tr->commit();
            BackOrder::toRefund($UserInfoModel->record_id);
            return true;
        }
        $tr->commit();
        return true;
    }

}
