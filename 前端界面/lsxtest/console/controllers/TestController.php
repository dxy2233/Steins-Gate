<?php

namespace console\controllers;

use common\models\BackOrder;
use common\models\BanquetOrder;
use common\models\Commission;
use common\models\MealTicket;
use common\models\ShopAccount;
use common\models\ShopAccountDetail;
use common\models\TicketDetail;
use common\models\UserAccount;
use common\models\UserOrder;
use yii\console\Controller;

class TestController extends Controller {
    //定席时刻检查是否拼席成功
    public function actionCheck1()
    {
        //所有定席时刻在这之前的席单（拼席中）
//        file_put_contents('/tmp/weixin.log','111',FILE_APPEND);
        $time = time();
//        file_put_contents('/tmp/weixin.log',$time,FILE_APPEND);
        $banquet_order = BanquetOrder::find()->select('*')->where('order_status = 0 and (banquet_time - 30*60) <='.$time.' and joined_peoples > 0')->asArray()->all();
//        var_dump($banquet_order);
        foreach ($banquet_order as $order)
        {
            if($order['total_peoples'] == $order['joined_peoples'])   //拼席成功 ，所有对应的席单和订单变成拼席成功
            {
                   $BanquetOrderModel = BanquetOrder::findOne($order['order_id']);
                   $BanquetOrderModel->order_status = 1;
                   $BanquetOrderModel->update([
                       'order_status'
                   ]);
                $user_orders = UserOrder::find()->select('*')->where(array('order_status'=>0,'order_id'=>$order['order_id']))->asArray()->all();
                foreach ($user_orders as $user_order)
                {
                    $UserOrderModel = UserOrder::findOne($user_order['record_id']);
                    $UserOrderModel->order_status = 1;
                    $UserOrderModel->update([
                        'order_status'
                    ]);
                    //赠送饭票
                    if($user_order['is_share'] == 1)
                    {
                        $TicketDetailModel = new TicketDetail();
                        $TicketDetailModel->ticket_status = 1;
                        $meal_ticket = MealTicket::find()->orderBy('caeate_time desc')->asArray()->one();
                        $TicketDetailModel->ticket_amount = $meal_ticket['ticket_price'];
                        $TicketDetailModel->ticket_order = $user_order['record_id'];
                        $TicketDetailModel->shop_id = $user_order['shop_id'];
                        $TicketDetailModel->user_id = $user_order['user_id'];
                        $TicketDetailModel->caeate_time = time();
                        $TicketDetailModel->insert();

                       //用户资金账户
                        $UserAccountModel = UserAccount::find()->where(['user_id'=>$user_order['user_id']])->one();
//                        $UserAccountModel->total_orders = $UserAccountModel->total_orders + 1;
                        $UserAccountModel->meal_balance = $UserAccountModel->meal_balance + $meal_ticket['ticket_price'];
                        $UserAccountModel->total_amount = $UserAccountModel->total_amount + $meal_ticket['ticket_price'];
                        $UserAccountModel->update_time = time();
                        $UserAccountModel->save();
                    }
                }
            }elseif($order['total_peoples'] != $order['joined_peoples'])
            {
                //全部退款
                $BanquetOrderModel = BanquetOrder::findOne($order['order_id']);
                $BanquetOrderModel->order_status = 2;
                $BanquetOrderModel->update([
                    'order_status',
                    'commission_rate',
                    'commission_amount'
                ]);
                $user_orders = UserOrder::find()->select('*')->where(array('order_status'=>0,'order_id'=>$order['order_id']))->asArray()->all();
                foreach ($user_orders as $user_order)
                {
//                    $UserOrderModel = UserOrder::findOne($user_order['record_id']);
//                    $UserOrderModel->order_status = 2;
//                    $UserOrderModel->update([
//                        'order_status'
//                    ]);BackOrder::toRefund
                    file_put_contents('/tmp/weixin.log','111',FILE_APPEND);
                    BackOrder::toRefund($user_order['record_id']);

                }
            }
        }
    }

    //开席后半小时，将所有席单和订单状态改为已完成
    public function actionCheck2 ()
    {
        $time = time();
        $banquet_order = BanquetOrder::find()->select('*')->where('order_status = 1 and (banquet_time + 30*60) <='.$time)->asArray()->all();
        foreach ($banquet_order as $order)
        {
            $BanquetOrderModel = BanquetOrder::findOne($order['order_id']);
            $BanquetOrderModel->order_status = 3;
            $commision = Commission::find()->where(array('shop_id'=>$BanquetOrderModel->shop_id))->asArray()->one();
            $BanquetOrderModel->commission_rate = $commision['commission_rate'];
            $BanquetOrderModel->commission_amount = $BanquetOrderModel->order_price*$BanquetOrderModel->joined_peoples*($commision['commission_rate']/100);
            $BanquetOrderModel->update([
                'order_status'
            ]);
            $user_orders = UserOrder::find()->select('*')->where(array('order_status'=>1,'order_id'=>$order['order_id']))->asArray()->all();
            foreach ($user_orders as $user_order)
            {
                $UserOrderModel = UserOrder::findOne($user_order['record_id']);
                $UserOrderModel->order_status = 3;
                $UserOrderModel->update([
                    'order_status'
                ]);
            }
            //添加shop_account信息
            $res = ShopAccount::find()->where(array('shop_id'=>$order['shop_id']))->asArray()->one();
            if(!empty($res))
            {
                $ShopAccountModel = ShopAccount::findOne($res['account_id']);
                $ShopAccountModel->total_orders += count($user_orders);
                $ShopAccountModel->banquet_orders += 1;
                $ShopAccountModel->sales_amount += $order['joined_peoples']*$order['order_price'];
                $commission = Commission::find()->where(array('shop_id'=>$order['shop_id']))->orderBy('create_time desc')->asArray()->one();
                $rate = empty($commission) ? 0 : $commission['commission_rate'];
                $ShopAccountModel->total_balnce += $order['joined_peoples']*$order['order_price']*(1-$rate/100);
                $ShopAccountModel->platform_amount += $order['joined_peoples']*$order['order_price']*($rate/100);
//                $ShopAccountModel->total_balnce += $order['joined_peoples']*$order['order_price'];
                $ShopAccountModel->update_time = time();
                $ShopAccountModel->update([
                    'total_orders',
                    'banquet_orders',
                    'sales_amount',
                    'total_balnce',
                    'update_time',
                ]);
            }

            $ShopAccountDetailModel = new ShopAccountDetail();
            $ShopAccountDetailModel->account_status = 0;
            $ShopAccountDetailModel->acount_amount = $order['joined_peoples']*$order['order_price'];
            $ShopAccountDetailModel->account_order = $order['order_id'];
            $ShopAccountDetailModel->shop_id = $order['shop_id'];
            $ShopAccountDetailModel->caeate_time = time();
            $ShopAccountDetailModel->insert();

        }
    }
}