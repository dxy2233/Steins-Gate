<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 9:27
 */
namespace app\modules\checkout\controllers;

use common\models\BackOrder;
use common\models\BanquetOrder;
use common\models\ShopBanquet;
use common\models\TicketDetail;
use common\models\User;
use common\models\UserAccount;
use common\models\UserOrder;
use frontend\controllers\DefaultController;
use yii\base\UserException;
use yii\web\Controller;

class CheckoutController extends DefaultController{

    public $layout = false;
    public $enableCsrfValidation=false;

    public function __construct ($id, $module, $config = [])
    {
        $module = \Yii::$app->getModule('checkout');
        parent::__construct($id, $module, $config);
    }

    /*
     * 开席
     */
    public function actionKaixi ()
    {
        $params = [];
        $banquet_id = \Yii::$app->request->get('banquet_id','');
        $is_today = \Yii::$app->request->get('is_today','0');
        $user_id = \Yii::$app->getSession()->get('user_id');
        //检验手机
        $data =homeurl('/checkout/checkout/kaixi?banquet_id='.$banquet_id);
        $this->isMobilevalidated($user_id,$data);

        $banquet_info = ShopBanquet::findOne($banquet_id);
        $shop_id = $banquet_info->shop_id;

        $userinfo = UserAccount::find()->select('meal_balance')->where(array('user_id'=>$user_id))->one();

        $params['lsx_info'] =  ShopBanquet::geyLsxinfo($banquet_id,$shop_id);        //流水席相关信息
        $params['meal_balance'] = $userinfo->meal_balance;
        $params['is_today'] = $is_today;

        return $this->render('kaixi.tpl',$params);
    }

    /*
     * 入席
     */
    public function actionJoin ()
    {
        $params = [];
        $order_id = \Yii::$app->request->get('order_id','');
        $banquet_id = \Yii::$app->request->get('banquet_id','');
        $user_id = \Yii::$app->getSession()->get('user_id');
        //检验手机
        $data =homeurl('/checkout/checkout/join?order_id='.$order_id.'&banquet_id='.$banquet_id);
        $this->isMobilevalidated($user_id,$data);

        $banquet_info = ShopBanquet::findOne($banquet_id);
        $shop_id = $banquet_info->shop_id;
        $params['lsx_info'] =  ShopBanquet::geyLsxinfo($banquet_id,$shop_id);        //流水席相关信息
        $params['order_info'] = BanquetOrder::getOneorder($order_id,$banquet_id);     //当前席单信息
        if ($params['order_info']['order_status'] !=0) {
            if ($params['order_info']['joined_peoples'] == $params['order_info']['total_peoples']) {
                throw new UserException('席桌已满！请尝试加入其他桌');
            }
            throw new UserException('非法操作!');
        }
        if ($params['order_info']['is_display'] == 0) {
            $sign =\Yii::$app->request->get('sign','');
            $is_user =$params['order_info']['reservation_people'];
            if (makeSignature(['is_user' =>$is_user],'cqzgkjlsx') !== $sign) {
                throw new UserException('非法操作！');
            }
        }
        $userinfo = UserAccount::find()->select('meal_balance')->where(array('user_id'=>$user_id))->one();
//        var_dump($userinfo);die;
        $params['meal_balance'] = $userinfo->meal_balance;
//        var_dump(\Yii::$app->getSession()->get);die;
        return $this->render('join.tpl',$params);
    }

    public function actionSubmit ()
    {
        $response = \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $user_order_info = \Yii::$app->request->post();
        $user_order_info['user_id'] = \Yii::$app->getSession()->get('user_id');
        $info = json_encode($user_order_info);
        if($user_order_info['surplus'] == $user_order_info['number']*$user_order_info['price'])  //全部由饭票支付
        {
            //生成一个用户订单
            $UserInfoModel = new UserOrder();
            $UserInfoModel->order_id = $user_order_info['order_id'];
            $UserInfoModel->banquet_id = $user_order_info['banquet_id'];
            $banquet = ShopBanquet::findOne($user_order_info['banquet_id']);
            $UserInfoModel->shop_id = $banquet->shop_id;
            $UserInfoModel->record_sn = UserOrder::getRecordsn();
            $UserInfoModel->buy_seats = $user_order_info['number'];
            $UserInfoModel->buy_price = $user_order_info['price'];
            $UserInfoModel->pay_amount = 0;
            $UserInfoModel->pay_serianlno = '';
            $UserInfoModel->pay_meal_ticket = $user_order_info['surplus'];
            $UserInfoModel->buy_number = UserOrder::getBuyNumber(6);
            $UserInfoModel->is_check = 0;
            $UserInfoModel->user_id = $user_order_info['user_id'];
            $UserInfoModel->meal_ticket = 0;
            $UserInfoModel->pay_status = 1;
            $UserInfoModel->order_status = 0;
            $UserInfoModel->pay_time = time();
            $UserInfoModel->is_comment = 0;
//        $UserInfoModel->comment_time = $user_order_info['order_id'];
            $UserInfoModel->insert();

            //席单中已加入人数+1
            $BanquetOrderModel = BanquetOrder::findOne($user_order_info['order_id']);
            $BanquetOrderModel->joined_peoples += $user_order_info['number'];
            $BanquetOrderModel->update(false,[
                'joined_peoples'
            ]);

            //扣除用户资金账户
            $UserAccountModel = UserAccount::find()->where(['user_id'=>$user_order_info['user_id']])->one();
            $UserAccountModel->total_orders = $UserAccountModel->total_orders + 1;
            $UserAccountModel->meal_balance = $UserAccountModel->meal_balance - $user_order_info['surplus'];
            $UserAccountModel->total_amount = $UserAccountModel->total_amount + $user_order_info['number'] * $user_order_info['price'];
            $UserAccountModel->update_time = time();
            $UserAccountModel->save();

            //如果饭票抵押大于0，则记录一条饭票消费明细
            if($user_order_info['surplus'] > 0)
            {
                $TicketDetailModel = new TicketDetail();
                $TicketDetailModel->ticket_status = 0;
                $TicketDetailModel->ticket_amount = -$user_order_info['surplus'];
                $TicketDetailModel->ticket_order = $UserInfoModel->record_id;
                $TicketDetailModel->user_id = $user_order_info['user_id'];
                $TicketDetailModel->caeate_time = time();
                $TicketDetailModel->insert();

            }

            if($BanquetOrderModel->total_peoples < $BanquetOrderModel->joined_peoples)
            {
                BackOrder::toRefund($UserInfoModel->record_id);
            }
            return [
                'code' => 1,
                'url' => '/payment/payment/result',
            ];
        }

        return [
            'code' => 1,
            'url' => '/payment/payment/pay?info='.urlencode($info),
        ];
    }

    public function actionSubmit2 ()
    {
        $response = \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//        var_dump(\Yii::$app->request->post());
        //生成一个席单
        $time1 = \Yii::$app->request->post('time1');
        $time2 = \Yii::$app->request->post('time2');
        $time3 = \Yii::$app->request->post('time3');
        $restime = $this->checktime($time1,$time2,$time3);
        if(!$restime)
        {
            return [
                'code' => 0,
                'message' => '时间有误',
            ];
        }
        if(\Yii::$app->request->post('today') == 0){
            $time3 = explode(':',$time3);
            $t3 = mktime($time3[0],$time3[1],0,date('m',gmtime()),date('d',gmtime()),date('Y',gmtime()));
            if($t3<gmtime()+1800)
            {
                return [
                'code' => 0,
                'message' => '时间不能小于当前时间后半小时',
            ];

            }
        }
        $BanquetOrderModel = new BanquetOrder();
        $time = \Yii::$app->request->post('banquet_time');
        $time = explode(':',$time);
        $banquet_info = ShopBanquet::findOne(\Yii::$app->request->post('banquet_id'));
        $BanquetOrderModel->banquet_id = \Yii::$app->request->post('banquet_id');
        $BanquetOrderModel->type_id = $banquet_info->type_id;
        $BanquetOrderModel->reservation_people = \Yii::$app->getSession()->get('user_id');
        $BanquetOrderModel->banquet_name = $banquet_info->banquet_name;
        $BanquetOrderModel->banquet_title = \Yii::$app->request->post('banquet_title');
        $BanquetOrderModel->banquet_sn = BanquetOrder::getBanquetsn();
        //获取今天的上一个座位顺序号
        $lastorder = BanquetOrder::find()->select('*')->where(['banquet_id'=>\Yii::$app->request->post('banquet_id')])->orderBy('banquet_time desc')->asArray()->all();
        $banquet_number  = 1;
        foreach ($lastorder as  $order)
        {
            if(date('Ymd',$order['banquet_time']) == date('Ymd',gmtime()+24*60*60*\Yii::$app->request->post('today'))){
                $banquet_number = $order['banquet_number'] + 1;
                break;
            }
        }
        $BanquetOrderModel->banquet_number = $banquet_number;   //座位顺序号
        $BanquetOrderModel->order_status = 0;
        $BanquetOrderModel->total_peoples = $banquet_info->total_peoples;
        $BanquetOrderModel->joined_peoples = 0;
        $BanquetOrderModel->order_amount = $banquet_info->banquet_amount;
        $BanquetOrderModel->order_price = $banquet_info->price;
        $BanquetOrderModel->payed_amount = 0;
        $BanquetOrderModel->commission_amount = 0;
        $BanquetOrderModel->shop_id = $banquet_info->shop_id;
        $BanquetOrderModel->banquet_time = mktime($time[0],$time[1],0,date('m',gmtime()),date('d',gmtime()),date('Y',gmtime()))+24*60*60*\Yii::$app->request->post('today');
        $BanquetOrderModel->is_display = \Yii::$app->request->post('is_display');
        $BanquetOrderModel->create_time = gmtime();
        $BanquetOrderModel->insert();

        $user_order_info = [];

        $user_order_info['user_id'] = \Yii::$app->getSession()->get('user_id');
        $user_order_info['order_id'] = $BanquetOrderModel->order_id;
        $user_order_info['banquet_id'] = \Yii::$app->request->post('banquet_id');
        $user_order_info['price'] = \Yii::$app->request->post('price');
        $user_order_info['number'] = \Yii::$app->request->post('number');
        $user_order_info['surplus'] = \Yii::$app->request->post('surplus');
        $info = json_encode($user_order_info);

        if($user_order_info['surplus'] == $user_order_info['number']*$user_order_info['price'])  //全部由饭票支付
        {
            //生成一个用户订单
            $UserInfoModel = new UserOrder();
            $UserInfoModel->order_id = $user_order_info['order_id'];
            $UserInfoModel->banquet_id = $user_order_info['banquet_id'];
            $banquet = ShopBanquet::findOne($user_order_info['banquet_id']);
            $UserInfoModel->shop_id = $banquet->shop_id;
            $UserInfoModel->record_sn = UserOrder::getRecordsn();
            $UserInfoModel->buy_seats = $user_order_info['number'];
            $UserInfoModel->buy_price = $user_order_info['price'];
            $UserInfoModel->pay_amount = 0;
            $UserInfoModel->pay_serianlno = '';
            $UserInfoModel->pay_meal_ticket = $user_order_info['surplus'];
            $UserInfoModel->buy_number = UserOrder::getBuyNumber(6);
            $UserInfoModel->is_check = 0;
            $UserInfoModel->user_id = $user_order_info['user_id'];
            $UserInfoModel->meal_ticket = 0;
            $UserInfoModel->pay_status = 1;
            $UserInfoModel->order_status = 0;
            $UserInfoModel->pay_time = time();
            $UserInfoModel->is_comment = 0;
//        $UserInfoModel->comment_time = $user_order_info['order_id'];
            $UserInfoModel->insert();

            //席单中已加入人数+1
            $BanquetOrderModel = BanquetOrder::findOne($user_order_info['order_id']);
            $BanquetOrderModel->joined_peoples += $user_order_info['number'];
            $BanquetOrderModel->update(false,[
                'joined_peoples'
            ]);

            //扣除用户资金账户
            $UserAccountModel = UserAccount::find()->where(['user_id'=>$user_order_info['user_id']])->one();
            $UserAccountModel->total_orders = $UserAccountModel->total_orders + 1;
            $UserAccountModel->meal_balance = $UserAccountModel->meal_balance - $user_order_info['surplus'];
            $UserAccountModel->total_amount = $UserAccountModel->total_amount + $user_order_info['number'] * $user_order_info['price'];
            $UserAccountModel->update_time = time();
            $UserAccountModel->save();

            //如果饭票抵押大于0，则记录一条饭票消费明细
            if($user_order_info['surplus'] > 0)
            {
                $TicketDetailModel = new TicketDetail();
                $TicketDetailModel->ticket_status = 0;
                $TicketDetailModel->ticket_amount = -$user_order_info['surplus'];
                $TicketDetailModel->ticket_order = $UserInfoModel->record_id;
                $TicketDetailModel->user_id = $user_order_info['user_id'];
                $TicketDetailModel->shop_id = $UserInfoModel->shop_id;
                $TicketDetailModel->caeate_time = time();
                $TicketDetailModel->insert();

            }

            if($BanquetOrderModel->total_peoples < $BanquetOrderModel->joined_peoples)
            {
                BackOrder::toRefund($UserInfoModel->record_id);
            }
            return [
                'code' => 1,
                'url' => '/payment/payment/result',
            ];
        }
        return [
            'code' => 1,
            'url' => '/payment/payment/pay?info='.urlencode($info),
        ];
    }

    public function checktime ($time1,$time2,$time3)
    {
            $time1 = explode(':',$time1);
            $time2 = explode(':',$time2);
            $time3 = explode(':',$time3);

            $t1 = mktime($time1[0],$time1[1],0,date('m',gmtime()),date('d',gmtime()),date('Y',gmtime()));
            $t2 = mktime($time2[0],$time2[1],0,date('m',gmtime()),date('d',gmtime()),date('Y',gmtime()));
            $t3 = mktime($time3[0],$time3[1],0,date('m',gmtime()),date('d',gmtime()),date('Y',gmtime()));

            if($t3<=$t2 && $t3>=$t1){
               return true;
            }else{
                return false;
            }
    }

    public function isMobilevalidated($user_id,$data)
    {
        $result = User::find()->select('mobile_validated')->where(['user_id'=>$user_id])->one();
        if (!empty($result)) {
            if (!$result->mobile_validated) {
                return $this->redirect('/user/center/bind-mobile?data='.urlencode($data));
            }
        }
    }

    public function actionCheck ()
    {
        if(\Yii::$app->request->isAjax)
        {
            $response = \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $banquet_id = \Yii::$app->request->post('banquet_id');
            $shop_id = \Yii::$app->request->post('shop_id');
            $params = [];
            $params['lsx_info'] = ShopBanquet::geyLsxinfo($banquet_id,$shop_id);        //流水席相关信息
            $params['order_info'] = BanquetOrder::getOrderinfo($banquet_id ,$shop_id);   //席单相关信息，未排序
            //区分今天和明天的席单
            $count_today = 0;
            $count_tomorrow = 0;
            foreach ($params['order_info'] as $order_info)
            {
                if(date('Ymd',gmtime()) == date('Ymd',$order_info['banquet_time'])){  //今天的订单
                    $count_today ++ ;
                }else{
                    $count_tomorrow ++ ;
                }
            }
            $yiwanchen = BanquetOrder::find()->where('banquet_id ='.$banquet_id.' and (order_status = 1 or order_status = 3)')->asArray()->all();
            foreach ($yiwanchen as $val)
            {
                if(date('Ymd',$val['banquet_time']) == date('Ymd',gmtime()))
                {
                    $count_today ++;
                }
            }
            $params['lsx_info']['left_number'] = $params['lsx_info']['banquet_number'] - $count_today;
            $params['lsx_info']['left_number_2'] = $params['lsx_info']['banquet_number'] - $count_tomorrow;
//            $params['lsx_info']['banquet_status'] = 0;
            if($params['lsx_info']['banquet_status'] == 0){
                return [
                    'code' => 101
                ];
            }
            if($params['lsx_info']['left_number'] == 0 && $params['lsx_info']['left_number_2'] > 0){
                return [
                    'code' => 102
                ];
            }
            if($params['lsx_info']['left_number'] == 0 && $params['lsx_info']['left_number_2'] == 0){
                return [
                    'code' => 103
                ];
            }
            if($params['lsx_info']['left_number'] > 0 && $params['lsx_info']['left_number_2'] == 0){
                return [
                    'code' => 104
                ];
            }
            return [
                'code' => 0
            ];
        }

    }
}