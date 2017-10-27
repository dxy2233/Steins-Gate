<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 15:12
 */
namespace common\models;

use yii\base\UserException;
use yii\db\ActiveRecord;
use yii\db\Query;

class ShopRecord extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%shop_record}}';
    }

    public function rules()
    {
        return [  ];
    }
    static public function getlist($post = array('add_time_begin'=>'','add_time_end'=>'','request_status'=>'','name'=>'','region_code'=>''),$isexport = false){
        $query = new Query();
        $query->select('sr.*,s.shop_name,s.merchant_mobile,a.user_name')->from(static::tableName() . 'sr');
        $query->leftJoin(Shop::tableName() . 's', 's.shop_id = sr.shop_id');
        $query->leftJoin(Admin::tableName() . 'a', 'sr.approve_id = a.user_id');
        if($post['name']){
            $query->andWhere("s.shop_name like :shop_name", [
                ':shop_name' => '%' . $post['name'] . '%'
            ]);
        }
        if($post['request_status']){ 
            $post['request_status'] = $post['request_status']-1;
            $query->andWhere([
                'sr.request_status' => $post['request_status']
            ]);
        }
        if($post['add_time_begin']){
            $add_time_begin = strtotime($post['add_time_begin']);
            $query->andwhere('sr.request_time >= :add_time_begin', [
                ':add_time_begin' => $add_time_begin
            ]);
        }
        if($post['add_time_end']){
            $add_time_end = strtotime($post['add_time_end']);
            $query->andwhere('sr.request_time <= :add_time_end', [
                    ':add_time_end' => $add_time_end
                ]);
        }
        $query->orderBy('sr.request_time desc');
        $result = $query->all();
        if ($isexport) {
            return $result;
        }
        return fenye($result);
    }
    
    //修改
    static public function record_update($id='',$data=array()){
        $list = array(
            'content'=>$data['content'],
            'request_status'=>$data['request_status'],
            'update_time'=>$data['update_time'],
            'approve_id'=>$data['approve_id'],
        );
        $carousel = static::updateAll($list,array('request_id' => $id));
        return $carousel;
    }
    //读取单条数据
    static public function getone($id=''){
        $result = static::find()->where('request_id='.$id)->one();
    return $result;
    }
}