<?php
/**
 * Created by PhpStorm.
 * User: ysl
 * Date: 2017/9/14
 * Time: 14:17
 */
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;
class Shop extends ActiveRecord{

    public static function tableName()
    {
        return '{{%shop}}';
    }
    static public function getlist($post = array('add_time_begin'=>'','add_time_end'=>'','ticket_status'=>'','name'=>'')){
        $query = new Query();
        $query->select('t.*,u.user_name,u.mobile,u.address_now')->from(static::tableName() . 's');
        $query->leftJoin(BanquetOrder::tableName() . 'b', 'b.shop_id = s.shop_id');
        if($post['ticket_status'] == 1 || $post['ticket_status'] == 2){
            $query->leftJoin(UserOrder::tableName() . 'uo', 'uo.order_id = b.order_id');
            $query->leftJoin(TicketDetail::tableName() . 't', 't.ticket_order = uo.record_id');
        }
        if($post['ticket_status'] == 3){
            $query->leftJoin(BackOrder::tableName() . 'bo', 'bo.order_id = b.order_id');
            $query->leftJoin(TicketDetail::tableName() . 't', 't.ticket_order = bo.return_id');
        }
        $query->leftJoin(User::tableName() . ' u', 't.user_id = u.user_id');
        if($post['name']){
            $query->andWhere("s.shop_name like :shop_name", [
                ':shop_name' => '%' . $post['name'] . '%'
            ]);
        }
        if($post['add_time_begin']){
            $add_time_begin = strtotime($post['add_time_begin']);
            $query->andwhere('t.caeate_time >= :add_time_begin', [
                ':add_time_begin' => $add_time_begin
            ]);
        }
        if($post['add_time_end']){
            $add_time_end = strtotime($post['add_time_end']);
            $query->andwhere('t.caeate_time <= :add_time_end', [
                    ':add_time_end' => $add_time_end
                ]);
        }
        if($post['ticket_status']){
            $query->andWhere(array('t.ticket_status' =>$post['ticket_status']-1));
        }
        $query->orderBy('t.ticket_id desc');
//                $commandQuery = clone $query;
//var_dump($commandQuery->createCommand()->getRawSql());die;
        $result=page($query);
        return $result;
    }
    static public function Marketing_ticket_amount($key='',$post = array('add_time_begin'=>'','add_time_end'=>'','ticket_status'=>'','name'=>'')){
        $query = new Query();
        $query->select('t.*,u.user_name,u.mobile,u.address_now')->from(static::tableName() . 's');
        $query->leftJoin(BanquetOrder::tableName() . 'b', 'b.shop_id = s.shop_id');
        if($post['ticket_status'] == 1 || $post['ticket_status'] == 2){
            $query->leftJoin(UserOrder::tableName() . 'uo', 'uo.order_id = b.order_id');
            $query->leftJoin(TicketDetail::tableName() . 't', 't.ticket_order = uo.record_id');
        }
        if($post['ticket_status'] == 3){
            $query->leftJoin(BackOrder::tableName() . 'bo', 'bo.order_id = b.order_id');
            $query->leftJoin(TicketDetail::tableName() . 't', 't.ticket_order = bo.return_id');
        }
        $query->leftJoin(User::tableName() . ' u', 't.user_id = u.user_id');
        if($post['name']){
            $query->andWhere("s.shop_name like :shop_name", [
                ':shop_name' => '%' . $post['name'] . '%'
            ]);
        }
        if($post['add_time_begin']){
            $add_time_begin = strtotime($post['add_time_begin']);
            $query->andwhere('t.caeate_time >= :add_time_begin', [
                ':add_time_begin' => $add_time_begin
            ]);
        }
        if($post['add_time_end']){
            $add_time_end = strtotime($post['add_time_end']);
            $query->andwhere('t.caeate_time <= :add_time_end', [
                    ':add_time_end' => $add_time_end
                ]);
        }
        if($post['ticket_status']){
            $query->andWhere(array('t.ticket_status' =>$post['ticket_status']-1));
        }
        if($key == 'amount'){//计算退饭票总额
            $ticket_amount=$query;
            $value=$ticket_amount->sum("ticket_amount");
        }
        return $value;
    }
    public static function shopname($shop_name)
    {

        $shop_name=static::find()->where(['shop_name'=>$shop_name])->asArray()->one();
        return $shop_name;

    }
}