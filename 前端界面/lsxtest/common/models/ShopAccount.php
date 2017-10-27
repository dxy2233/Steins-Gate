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
class ShopAccount extends ActiveRecord{

    public static function tableName()
    {
        return '{{%shop_account}}';
    }
    static public function getlist($post = array('add_time_begin'=>'','add_time_end'=>'','ticket_status'=>'','name'=>'','region_code'=>'','leve'=>3)){
        $query = new Query();
        $query->select('sa.*,s.shop_name,r.region_name,c.commission_rate')->from(static::tableName() . 'sa');
        $query->leftJoin(Shop::tableName() . 's', 's.shop_id = sa.shop_id');
        $query->leftJoin(Commission::tableName() . 'c', 'c.shop_id = s.shop_id');
        $query->leftJoin(Region::tableName() . 'r', 'r.region_code = s.region_code');
        $query->andWhere([
            's.shop_status' => 1
        ]);
        if($post['name']){
            $query->andWhere("s.shop_name like :shop_name", [
                ':shop_name' => '%' . $post['name'] . '%'
            ]);
        }
        if($post['region_code']){
            if ($post['leve'] == 3) {
                $query->andWhere([
                    's.region_code' => $post['region_code']
                ]);
            }elseif ($post['leve'] == 2) {
                $query->andWhere([
                    '(select parent_code from '.Region::tableName().' where region_code = s.region_code)' => $post['region_code']
                ]);
            }elseif ($post['leve'] == 1) {
                $query->andWhere([
                    '(select parent_code from '.Region::tableName().' where region_code = (select parent_code from '.Region::tableName().' where region_code = s.region_code))' => $post['region_code']
                ]);
            }
        }
        if($post['add_time_begin']){
            $add_time_begin = strtotime($post['add_time_begin']);
            $query->andwhere('sa.create_time >= :add_time_begin', [
                ':add_time_begin' => $add_time_begin
            ]);
        }
        if($post['add_time_end']){
            $add_time_end = strtotime($post['add_time_end']);
            $query->andwhere('sa.create_time <= :add_time_end', [
                    ':add_time_end' => $add_time_end
                ]);
        }
        $query->orderBy('s.shop_status desc');
//                $commandQuery = clone $query;
//var_dump($commandQuery->createCommand()->getRawSql());die;
        $result['list'] = $query->all();
        $result['banquet_orders'] = $query->sum('banquet_orders');//席单总数
        $result['sales_amount'] = $query->sum('sales_amount');//销售额汇总
        $result['total_balnce'] = $query->sum('total_balnce');//账户余额汇总
        $result['withdraw_amount'] = $query->sum('withdraw_amount');//已提现汇总
        $result['platform_amount'] = $query->sum('platform_amount');//平台佣金汇总
        return $result;
    }
}