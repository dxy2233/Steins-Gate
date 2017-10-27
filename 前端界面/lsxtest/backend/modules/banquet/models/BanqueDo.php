<?php
namespace app\modules\banquet\models;
use common\models\BanquetOrder;
use common\models\BanquetType;
use common\models\Shop;
use common\models\User;
use common\models\UserOrder;
use yii\base\Model;
use yii\db\Query;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/19
 * Time: 11:07
 */
class BanqueDo extends Model
{
    public static function BanquetList($post=null)
    {
        $list=[];
        $page=[];

        $query=new Query();
        $query->select([
          'b.*',
          's.shop_name',
          'bt.type_name'
        ]);
        $query->from([
            'b' => BanquetOrder::tableName()
        ]);
        $query->leftJoin([
            's' => Shop::tableName()
        ], 's.shop_id = b.shop_id');
        $query->leftJoin([
            'bt' => BanquetType::tableName()
        ], 'bt.type_id = b.type_id');
        $query->andWhere([
            '>',
            'joined_peoples',
            0
        ]);

        $query->orderBy('b.create_time desc');
         //席单号
        if(!empty($post['banquet_sn']))
        {
            $query->andWhere([
                'b.banquet_sn' => $post['banquet_sn']
            ]);
        }
        //订单号
        if(!empty($post['record_sn']))
        {
            $order = UserOrder::find()->where(['record_sn' => $post['record_sn']])->asArray()->one();
            $order_id=$order['order_id'];
            $query->andWhere([
                'b.order_id' => $order_id
            ]);
        }
        //商铺名字
        if(!empty($post['shop_name']))
        {
            $query->andWhere([
                'like',
                's.shop_name',
                $post['shop_name']
            ]);
        }
        //类型
        if(!empty($post['order_status']))
        {
            $order_status=$post['order_status']-1;
            $query->andWhere([
                'b.order_status' => $order_status
            ]);
        }
        //开席时间
        if(!empty($post['banquet_time_start']))
        {
            $banquet_time_start=strtotime($post['banquet_time_start']);
            $query->andwhere('b.banquet_time >= :add_time_begin', [
                ':add_time_begin' => $banquet_time_start
            ]);
        }
        if(!empty($post['banquet_time_end']))
        {
            $banquet_time_end=strtotime($post['banquet_time_end']);
            $query->andwhere('b.banquet_time <= :add_time_end', [
                ':add_time_end' => $banquet_time_end
            ]);
        }
        //创建时间
        if(!empty($post['create_time_start']))
        {
            $create_time_start=strtotime($post['create_time_start']);
            $query->andwhere('b.create_time >= :create_time_begin', [
                ':create_time_begin' => $create_time_start
            ]);
        }
        if(!empty($post['create_time_end']))
        {
            $create_time_end=strtotime($post['create_time_end']);
            $query->andwhere('b.create_time <= :create_time_end', [
                ':create_time_end' => $create_time_end
            ]);
        }
//        if(posts())
//        {
//            $data=$query->createCommand()->getRawSql();
//            return $data;
//        }

        $data=$query->all();
//        $data=page($query);
        $page=gets('page');
        if(empty($page))
        {
            $page=1;
        }
        $data=fenye($data,$page);
        $data['post']=$post;
        return $data;


    }
    public static function BanqueInfo($id)
    {
        $query=new Query();
        $query->select([
            'b.*',
            's.shop_name','s.address','s.merchant_telphone',
            'bt.type_name'
        ]);
        $query->from([
            'b' => BanquetOrder::tableName()
        ]);
        $query->leftJoin([
            's' => Shop::tableName()
        ], 's.shop_id = b.shop_id');
        $query->leftJoin([
            'bt' => BanquetType::tableName()
        ], 'bt.type_id = b.type_id');
        $query->andWhere(
            [
                'order_id'=>$id
            ]
        );
        $data=$query->one();

        return $data;
    }
    public static function UserOrderInfo($id)
    {
        $query=new Query();
        $query->select([
            'uo.*',
            'u.*'
        ]);
        $query->from([
            'uo' => UserOrder::tableName()
        ]);
        $query->leftJoin([
            'u' => User::tableName()
        ], 'uo.user_id = u.user_id');

        $query->andWhere(
            [
                'order_id'=>$id
            ]
        );
        $data=$query->all();
        $i=1;
        foreach ($data as $key=>$value)
        {
            $data[$key]['key']=$i;
            $i++;
        }
        $page=gets('page');
        if(empty($page))
        {
            $page=1;
        }
        $rows=fenye($data,$page);
        return $rows;

    }

}