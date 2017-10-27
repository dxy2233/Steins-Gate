<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;

class Marketing extends ActiveRecord{

    public static function tableName()
    {
        return '{{%ticket_detail}}';
    }

    public function rules()
    {
        return [ ];
    }
    static public function getlist($post = array('add_time_begin'=>'','add_time_end'=>'','ticket_status'=>'','name'=>'')){
        $query = new Query();
        $query->select('t.*,u.user_name,u.mobile,u.address_now ,s.shop_name')->from(static::tableName() . ' t');
        $query->leftJoin(User::tableName() . ' u', 't.user_id = u.user_id');
        $query->leftJoin(Shop::tableName().'s','s.shop_id = t.shop_id');
        $query->orderBy('t.ticket_id desc');
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
        if($post['name']){
            $query->andWhere("s.shop_name like :shop_name", [
                ':shop_name' => '%' . $post['name'] . '%'
            ]);
        }
        $query->orderBy('t.ticket_id desc');
//        $commandQuery = clone $query;
//var_dump($commandQuery->createCommand()->getRawSql());
//        $result = $query->all();
        $result=$query->all();
        $result=fenye($result);

        return $result;
    }
    static public function Marketing_ticket_amount($key='',$post = array('add_time_begin'=>'','add_time_end'=>'','ticket_status'=>'','name'=>'')){
        $query = new Query();
        $query->select('t.*,u.user_name,u.mobile,u.address_now,s.shop_name')->from(static::tableName() . ' t');
        $query->leftJoin(User::tableName() . ' u', 't.user_id = u.user_id');
        $query->leftJoin(Shop::tableName() . ' s', 's.shop_id = t.shop_id');
        $query->orderBy('t.ticket_id desc');
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
        if($post['name']){
            $query->andWhere("s.shop_name like :shop_name", [
                ':shop_name' => '%' . $post['name'] . '%'
            ]);
        }
        $query->andWhere([
            't.ticket_status' => 1
        ]);
        if($key == 'amount'){//计算退饭票总额
            $ticket_amount=$query;
            $value=$ticket_amount->sum("ticket_amount");
        }
        return $value;
    }
}