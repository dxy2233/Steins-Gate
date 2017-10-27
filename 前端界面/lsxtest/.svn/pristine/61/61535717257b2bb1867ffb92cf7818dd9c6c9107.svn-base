<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/18
 * Time: 15:00
 */
namespace common\models;

use yii\base\UserException;
use yii\db\ActiveRecord;
use yii\db\Query;

class Admin extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%admin}}';
    }

    public function rules()
    {
        return [  ];
    }

    /*
     * 获取管理员信息
     * @user_id
     * return array params
     */
    static public function getList()
    {
        $query = new Query();
        $query->select('a.*')->from(Admin::tableName().'a');
        $list = $query->all();
        return $list;

    }

    public static function getInfo($where=null)
    {
        $query=new Query();
        $admin=Admin::find()->where($where)->asArray()->one();
        return $admin;
    }

    static public function getleftrole($post = array('user_name'=>'')){
        $query = new Query();
        $query->select('a.*,r.role_name')->from(static::tableName() . 'a');
        $query->leftJoin(Role::tableName() . 'r', 'r.role_id = a.role_id');
        if($post['user_name']){
            $query->andWhere("a.user_name like :user_name", [
                ':user_name' => '%' . $post['user_name'] . '%'
            ]);
        }
        $query->orderBy('a.user_id desc');
        $result=page($query);
        return $result;
    }
    static public function getone($id){
        $result = static::find()->where('user_id='.$id)->one();
        return $result;
    }
    static public function Admin_update($id='',$data=array()){
        $list = array(
            'user_name'=>$data['user_name'],
            'real_name'=>$data['real_name'],
            'mobile'=>$data['mobile'],
            'status'=>$data['status'],
            'role_id'=>$data['role_id'],
            'update_time'=>gmtime(),
        );
        $carousel = static::updateAll($list,array('user_id' => $id));
        return $carousel;
    }
    static public function Updatepassword($id,$password){
        $list = array(
            'password'=>$password,
            'update_time'=>gmtime(),
        );
        $carousel = static::updateAll($list,array('user_id' => $id));
        return $carousel;
    }

}