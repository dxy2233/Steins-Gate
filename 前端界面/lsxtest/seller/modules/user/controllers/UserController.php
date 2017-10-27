<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 9:27
 *我的会员
 */
namespace app\modules\user\controllers;


use common\models\User;
use common\models\UserOrder;
use yii\db\Query;
use yii\web\Controller;

class UserController extends Controller
    {
    public function init ()
    {
        $init_class = new \seller\controllers\InitController();
        $init_class->actionClassName();
    }
    //商家会员列表
    public function actionIndex (){
            $session = \Yii::$app->session;
            $shop_usermsg = $session->get('seller_msg');
            if ($shop_usermsg['shop_id']) {
                 $query = new Query();
                $query->select('sum(uo.pay_amount+uo.pay_meal_ticket) as total_money,count(uo.record_id) as total_once,u.user_name,u.nickname,u.image_path,u.reg_time');
                $query->from(UserOrder::tableName() . ' uo');
                $query->leftJoin(User::tableName() . ' u', 'uo.user_id = u.user_id');
                $query->where([
                    'uo.order_status' => 3,
                    'uo.shop_id' => $shop_usermsg['shop_id']
                ]);

            $user_msg = $query->orderby('u.reg_time desc')->groupBy('banquet_id')->groupBy('uo.user_id')->all();
            }
            $date['user_msg'] = $user_msg;
      
        return $this->render('index.tpl',$date);
    }

}