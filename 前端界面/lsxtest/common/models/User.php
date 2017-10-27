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

class User extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [  ];
    }

    /*
     * 获取用户信息
     * @user_id
     * return array params
     */
    static public function getUserInfo($user_id = '')
    {
        if(!$user_id){
            throw new UserException('未知错误！');
        }
        $query = new Query();
        $query->select('u.* ,ua.meal_balance')->from(User::tableName().'u');
        $query->leftJoin(UserAccount::tableName().'ua','ua.user_id = u.user_id');
        $query->where('u.user_id=:user_id', array(':user_id'=>$user_id));
        $params = $query->one();
        return $params;

    }

    /*
     * 获取饭友列表
     * @user_id int
     * return array params
     */
    static public function getfriends($user_id = '' ,$page = 1)
    {
        $params = [];
        if(empty($user_id)){
            return $params;
        }

        $query1 = new Query();
        $query1->select('uo.order_id')->from(UserOrder::tableName().'uo');
        $query1->groupBy('uo.order_id');
        $query1->where(array('uo.user_id'=>$user_id ,'uo.order_status' => 3));
        $arr = $query1->all();
        $array = [];
        foreach ($arr as $item)
        {
            array_push($array,$item['order_id']);;
        }

        $query = new Query();
        $query->select('count(distinct uo.order_id) as times,u.user_name ,u.image_path ,u.user_id')->from(UserOrder::tableName().'uo');
        $query->leftJoin(User::tableName().'u','u.user_id = uo.user_id');
        $query->leftJoin(BanquetOrder::tableName().'bo','bo.order_id = uo.order_id');
        $query->groupBy('uo.user_id');
        $query->where(array('uo.order_status'=>3,'bo.order_status'=>3));
        $query->andWhere(['in','bo.order_id',$array]);
        $query->andWhere(['!=','u.user_id',$user_id]);
        $query->orderBy('count(uo.record_id) desc');
        $query->limit(10)->offset($page*10-10);
        $result = $query->all();
        if (empty($result)) {
            return $params;
        }

        $params = $result;
        return $params;
    }

    /**
     * @param $openid
     * @return mixed
     * 根据openid获取用户的昵称
     */
    static public function getNicknameByOpenid($openid)
    {
        $result=User::find()->select('nickname')->where(['openid'=>$openid])->one();
        return $result->nickname;
    }

    /**
     * @param $openid
     * @return array|null|ActiveRecord
     * 检查用户是否已经注册过
     * 有则返回用户详细信息
     * 没有则返回null
     */
    static public function checkIsByOpenid($openid)
    {
        $result=User::find()->where(['openid'=>$openid])->one();
        return $result;
    }

    /**
     * @return mixed
     * 获取当前登录用户的id
     */
    static public function getUserId()
    {
        return \Yii::$app->session->get('user_id','');
    }

    /**
     * @return mixed
     * 获取当前登录用户的openid
     */
    static public function getUserOpenid()
    {
        return \Yii::$app->session->get('openid','');
    }
}