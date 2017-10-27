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

class UserOrder extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%user_order}}';
    }

    public function rules()
    {
        return [];
    }

    /*
     * 根据订单状态获取对应订单
     * @status 订单状态
     * @user_id 用户ID
     * @rreturn array params
     */
    static public function getList($status = '',$user_id = '' ,$page = 1)
    {
        $query = new Query();
        $query->select('uo.* , sb.banquet_name ,sb.banquet_url,s.shop_name ,bo.banquet_time ,sb.banquet_url')->from(UserOrder::tableName().'uo');
        $query->leftJoin(ShopBanquet::tableName().'sb','uo.banquet_id = sb.banquet_id');
        $query->leftJoin(Shop::tableName().'s','s.shop_id = uo.shop_id');
        $query->leftJoin(BanquetOrder::tableName().'bo','bo.order_id = uo.order_id');
        if($status == 'seats')
        {
            $query->where('uo.order_status = 0');
        }elseif($status == 'success')
        {
            $query->where('uo.order_status = 1');
        }elseif($status == 'completed')
        {
            $query->where('uo.order_status = 3');
        }elseif($status == 'refunded')
        {
            $query->where('uo.order_status = 2');
        }
        $query->andWhere(array('uo.user_id'=>$user_id));

        $query->orderBy('uo.record_id desc');

        $query->limit(10)->offset($page*10-10);

        $params = $query->all();
        foreach ($params as &$val)
        {
            $val['banquet_url'] = imageurl($val['banquet_url']);
        }
        return $params;
    }


    /*
     * 生成用户订单号方法
     * 8位时间+5位流水号+1位类型（2）
     * return 14位订单号
     */
    static public function getRecordsn($pay_type = NULL)
    {
        $lastorder =  file_get_contents("record_sn.txt");
        $now = date('Ymd',gmtime());
        if($now != substr($lastorder,0,8)){
            $record_sn = 'U'.date('YmdHi',gmtime()).'001';
            file_put_contents("record_sn.txt",date('Ymd',gmtime()).'001');
        }else{
            $tradeno = file_get_contents("record_sn.txt");
            $tradeno += 1;
            //$tradeno = str_pad($tradeno, 5, '0', STR_PAD_LEFT);
            $liushuihao = substr($tradeno,8,3);
            $record_sn = 'U'.date('YmdHi',gmtime()).str_pad($liushuihao, 3, '0', STR_PAD_LEFT);
//            $record_sn = $tradeno;
            file_put_contents("record_sn.txt",$tradeno);
        }
//        $record_sn .= 2;
        return $record_sn;
    }

    /*
     * 用户购买号码
     * return 6位随机码
     * @return password string
     */
    static public function getBuyNumber ($length)
    {
      // 密码字符集，可任意添加你需要的字符
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $password = '';
            for ( $i = 0; $i < $length; $i++ )
            {
                $password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
            }
            return $password;
    }

    /*
     * 验证用户购买号码是否与正在与拼席中个拼席成功的验证码相同
     * @password sting
     * @return bool
     */
    static public function checkpass($string = '')
    {
          $query = new Query();
          $query->select('uo.buy_number')->from(UserOrder::tableName().'uo');
          $query->where('order_status=0 or order_status=1');
          $result = $query->all();

          $is_same = true;
          if(!empty($result)){
              foreach ($result as $item){
                  if($item['buy_number'] == $string){
                      $is_same = false;
                      break;
                  }
              }
          }
          return $is_same;
    }

    /**
     * 根据席单号、获取该桌已下订单的用户
     * @param $order_id
     * @return array
     */
    static public function getUserByOrder($order_id)
    {
        $query = new Query();
        $query->select('u.*,uo.buy_seats')->from(UserOrder::tableName().'uo');
        $query->leftJoin(User::tableName().'u','uo.user_id=u.user_id');
        $query->where(['uo.order_id'=>$order_id]);
        $query->andWhere('uo.order_status <> 2');
        $UserAggregate=$query->all();

        return $UserAggregate;
    }

    /**
     * @param $record_id
     * @return array|bool
     * 根据用户订单id获取订单详情页的数据
     */
    static public function getUserOrderInfo($record_id){
        $query = new Query();
        $query->select('uo.* ,s.* ,sb.* ,bo.banquet_sn ,bo.banquet_title ,bo.banquet_time ,bo.is_display ,bo.total_peoples ,bo.joined_peoples ,bo.order_status as bo_status ,bo.order_price ,bo.banquet_number ,bo.reservation_people')->from(UserOrder::tableName().'uo');
        $query->leftJoin(BanquetOrder::tableName().'bo','bo.order_id = uo.order_id');
        $query->leftJoin(ShopBanquet::tableName().'sb','sb.banquet_id = uo.banquet_id');
        $query->leftJoin(Shop::tableName().'s','s.shop_id = sb.shop_id');
        $query->where(['record_id' => $record_id]);
        return $query->one();
    }
}