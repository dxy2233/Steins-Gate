<?php
namespace app\modules\count\models;
use common\models\BanquetOrder;
use common\models\Shop;
use common\models\ShopAccount;
use common\models\User;
use yii\base\Model;
use yii\db\Query;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/18
 * Time: 13:21
 */
class CountDo extends Model
{
    public static function PageCount()
    {
        $arr=[];

        $query=new Query();
        $query->from(BanquetOrder::tableName());
        $query->andWhere([
            'order_status'=>3
        ]);
        $arr['commission_amount']=$query->sum('commission_amount');
        $data=$query->all();
        $arr['sales_amount']=0;
        //遍历算总额才是最骚的
        foreach ($data as $key=>$value)
        {
            $arr['sales_amount']= $arr['sales_amount']+$value['joined_peoples']*$value['order_price'];
        }

//        $arr['commission_amount']=$query->sum('platform_amount');
        $query=new Query();
        $query->from(User::tableName());
        $arr['user_amount']=$query->count('user_id');
        $query=new Query();
        $query->from(Shop::tableName());
        $arr['shop_amount']=$query->count('shop_id');


        return $arr;

    }
    public static function PageList()
    {
        $data=[];

        $query=new Query();
        $query->from(BanquetOrder::tableName());
        $query->andWhere([
            'order_status'=>3
        ]);
        if(!empty(posts('begin_time'))||!empty(gets('begin_time')))
        {
            $add_time_begin = posts('begin_time') ? strtotime(posts('begin_time')) : strtotime(gets('begin_time'));
            $query->andwhere('create_time >= :add_time_begin', [
                ':add_time_begin' => $add_time_begin
            ]);
        }
        if(!empty(posts('end_time'))||!empty(gets('end_time')))
        {
            $add_time_end = posts('end_time') ? strtotime(posts('end_time')) : strtotime(gets('end_time'));
            $query->andwhere('create_time <= :add_time_end', [
                ':add_time_end' => $add_time_end
            ]);
        }
        $data['sales_amount']=$query->sum('order_price*joined_peoples');
        $data['sales_amount']=round($data['sales_amount'], 2);
        $data['commission_amount']=$query->sum('commission_amount');
        $data['order_amount']=$query->count('order_id');

        $query=new Query();
        $query->from(User::tableName());
        if(!empty(posts('begin_time'))||!empty(gets('begin_time')))
        {
            $add_time_begin = posts('begin_time') ? strtotime(posts('begin_time')) : strtotime(gets('begin_time'));
            $query->andwhere('reg_time >= :add_time_begin', [
                ':add_time_begin' => $add_time_begin
            ]);
        }
        if(!empty(posts('end_time'))||!empty(gets('end_time')))
        {
            $add_time_end = posts('end_time') ? strtotime(posts('end_time')) : strtotime(gets('end_time'));
            $query->andwhere('reg_time <= :add_time_end', [
                ':add_time_end' => $add_time_end
            ]);
        }
        $data['user_amount']=$query->count('user_id');

        $query=new Query();
        $query->from(Shop::tableName());
        if(!empty(posts('begin_time'))||!empty(gets('begin_time')))
        {
            $add_time_begin = posts('begin_time') ? strtotime(posts('begin_time')) : strtotime(gets('begin_time'));
            $query->andwhere('create_time >= :add_time_begin', [
                ':add_time_begin' => $add_time_begin
            ]);
        }
        if(!empty(posts('end_time'))||!empty(gets('end_time')))
        {
            $add_time_end = posts('end_time') ? strtotime(posts('end_time')) : strtotime(gets('end_time'));
            $query->andwhere('create_time <= :add_time_end', [
                ':add_time_end' => $add_time_end
            ]);
        }
        $data['shop_amount']=$query->count('shop_id');



        return $data;
    }

}