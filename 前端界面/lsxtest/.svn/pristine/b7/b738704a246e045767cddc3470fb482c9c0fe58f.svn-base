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

class BanquetOrder extends ActiveRecord{

    public static function tableName()
    {
        return '{{%banquet_order}}';
    }

    /*
     * 生成流水席席单号方法
     * 8位时间+2位随机数+3位流水号+1位类型（1）
     * return 14位席单号
     */
    static public function getBanquetsn($pay_type = NULL)
    {
        $lastorder =  file_get_contents("banquet_sn.txt");
        $now = date('Ymd',gmtime());
        if($now != substr($lastorder,0,8)){
            $banquet_sn = 'B'.date('YmdHi',gmtime()).'001';
            file_put_contents("banquet_sn.txt",date('Ymd',gmtime()).'001');
        }else{
            $tradeno = file_get_contents("banquet_sn.txt");
            $lsh = substr($tradeno,8,3);
            $lsh += 1;
            $tradeno += 1;
            //$tradeno = str_pad($tradeno, 5, '0', STR_PAD_LEFT);
            $banquet_sn = 'B'.date('YmdHi',gmtime()).str_pad($lsh, 3, '0', STR_PAD_LEFT);
            file_put_contents("banquet_sn.txt",$tradeno);
        }
//        $banquet_sn .= 1;

        return $banquet_sn;
    }

    /*
     * 相应的席单信息
     * @banquet_id   shop_id
     */
    static public function getOrderinfo ($banquet_id = '',$shop_id = '')
    {
        $query = new Query();
        $query->select('bo.*,(bo.total_peoples-bo.joined_peoples=0) as newstatus')->from(BanquetOrder::tableName().'bo');
        $query->where(array('bo.order_status'=>0,'bo.banquet_id'=>$banquet_id));
        $query->andWhere('bo.joined_peoples > 0');
        $query->orderBy('newstatus asc,bo.banquet_time asc');
        $result = $query->all();
        if(!empty($result)){
            foreach ($result as &$item){
                $query1 = new Query();
                $query1->select('u.image_path ,uo.record_id,uo.buy_seats')->from(UserOrder::tableName().'uo');
                $query1->leftJoin(User::tableName().'u','u.user_id = uo.user_id');
                $query1->leftJoin(BanquetOrder::tableName().'bo','bo.order_id = uo.order_id');
                $query1->where(array('bo.order_id'=>$item['order_id'],'uo.order_status'=>0));
                $res = $query1->all();
                $res2 = [];
                foreach ($res as $user)
                {
                    for($i=0;$i<$user['buy_seats'];$i++){
                        $res2[] = $user;
                    }
                }
                $item['user_info'] = $res2;
                $item['eat_time'] = date('H:i',$item['banquet_time']);
                if(date('Ymd',$item['banquet_time']) == date('Ymd',time())){
                    $item['eat_today'] = '今天';
                }else{
                    $item['eat_today'] = '明天';
                }
            }
        }
        return $result;
    }

    static public function getOneorder ($order_id = '' , $banquet_id = '')
    {
        $query = new Query();
        $query->select('bo.*')->from(BanquetOrder::tableName().'bo');
        $query->where(array('bo.banquet_id'=>$banquet_id,'order_id'=>$order_id));
        $result = $query->one();

        $query1 = new Query();
        $query1->select('u.image_path,uo.buy_seats')->from(UserOrder::tableName().'uo');
        $query1->leftJoin(User::tableName().'u','u.user_id = uo.user_id');
        $query1->leftJoin(BanquetOrder::tableName().'bo','bo.order_id = uo.order_id');
        $query1->where(array('bo.order_id'=>$result['order_id'],'uo.order_status'=>0));
        $res = $query1->all();
        $res2 = [];
        foreach ($res as $user)
        {
            for($i=0;$i<$user['buy_seats'];$i++){
                $res2[] = $user;
            }
        }
        $result['user_info'] = $res2;
        $result['eat_time'] = date('H:i',$result['banquet_time']);
        if(date('Ymd',$result['banquet_time']) == date('Ymd',time())){
            $result['eat_today'] = '今天';
        }else{
            $result['eat_today'] = '明天';
        }

        return $result;
    }

    /**
     * @param string $order_id
     * @param string $banquet_id
     * @return array|bool
     * 分享单独读取一个
     */
    static public function getOneorder2 ($order_id = '' , $banquet_id = '')
    {
        $query = new Query();
        $query->select('bo.*')->from(BanquetOrder::tableName().'bo');
        $query->where(array('bo.banquet_id'=>$banquet_id,'order_id'=>$order_id));
        $result = $query->one();

        $query1 = new Query();
        $query1->select('u.image_path,uo.buy_seats')->from(UserOrder::tableName().'uo');
        $query1->leftJoin(User::tableName().'u','u.user_id = uo.user_id');
        $query1->leftJoin(BanquetOrder::tableName().'bo','bo.order_id = uo.order_id');
        $query1->where(array('bo.order_id'=>$result['order_id'],'uo.order_status'=>[0,1,3]));
        $res = $query1->all();
        $res2 = [];
        foreach ($res as $user)
        {
            for($i=0;$i<$user['buy_seats'];$i++){
                $res2[] = $user;
            }
        }
        $result['user_info'] = $res2;
        $result['eat_time'] = date('H:i',$result['banquet_time']);
        if(date('Ymd',$result['banquet_time']) == date('Ymd',time())){
            $result['eat_today'] = '今天';
        }else{
            $result['eat_today'] = '明天';
        }

        return $result;
    }

}