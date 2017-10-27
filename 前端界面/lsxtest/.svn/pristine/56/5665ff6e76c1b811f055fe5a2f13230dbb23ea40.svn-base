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

class ShopBanquet extends ActiveRecord{

    public static function tableName()
    {
        return '{{%shop_banquet}}';
    }

    public function rules()
    {
        return [];
    }

    /*
     * 获取热门流水席
     * 排序规则：按照流⽔席累计成交的席单数由多到少排序。
     * 若订单数相同（包括都为0），则按流⽔席的创建时间排序，最新创建的显示在最前面
     * @return array params
     */
     static public function getHotlsx ()
     {
         $params = [];

         $query = new Query();
         $query->select('s.* ,sh.shop_name ,sh.region_code ,sh.shop_lng ,sh.shop_lat')->from(ShopBanquet::tableName().'s');
//         $query->leftJoin(BanquetOrder::tableName().'b','b.banquet_id = s.banquet_id');
         $query->leftJoin(Shop::tableName().'sh','sh.shop_id = s.shop_id');
//         $query->orderBy('count(b.order_id) desc');
         $query->orderBy('s.create_time desc');
         $query->where(array('s.banquet_status'=>1));
         $result = $query->all();

         foreach ($result as $item=>&$value)
         {
             $value['score'] = substr($value['service_score'],0,1);
             $value['banfen'] = substr($value['service_score'], strpos($value['service_score'], '.')+1,1);
             $count = BanquetOrder::find()->select('count(order_id) as total')->where(['banquet_id'=>$value['banquet_id']])->groupBy('banquet_id')->asArray()->all();
//             var_dump($count);die;
             if(empty($count)){
                 $value['count'] = 0;
             }else{
                 $value['count'] = $count[0]['total'];
             }
         }

         $flag = array();
         foreach($result as $v){
             $flag[] = $v['count'];
         }
         array_multisort($flag, SORT_DESC, $result);

         $params = $result;
         return $params;
     }

     /*
      * 获取流水席详情页面的相关信息
      * @id banquet_id shop_id
      * return array
      */
     static public function geyLsxinfo($banquet_id = '',$shop_id = '')
     {
         $query = new Query();
         $query->select('sb.* ,s.shop_name ,s.merchant_telphone ,s.address ,s.shop_lng ,s.shop_lat ,s.opening_hour ,s.closing_hour')->from(ShopBanquet::tableName().'sb');
         $query->leftJoin(Shop::tableName().'s','s.shop_id = sb.shop_id');
         $query->where(array('sb.banquet_id'=>$banquet_id , 'sb.shop_id'=>$shop_id));
         $result = $query->one();
         $result['score'] = substr($result['service_score'],0,1);
         $result['banfen'] = substr($result['service_score'], strpos($result['service_score'], '.')+1,1);

         $location = \Yii::$app->getSession()->get('location','');
         if(!empty($location)){
             $lat = $location['lat'];
             $lng = $location['lng'];
         }else{
             $lat = 0;
             $lng = 0;
         }
         $result['distance'] = getDistance($result['shop_lat'], $result['shop_lng'],$lat ,$lng);

         return $result;
     }

     static public function getsells($banquet_id)
     {
         $res = BanquetOrder::find()->select('count(order_id) as sell')->where(array('banquet_id'=>$banquet_id,'order_status'=>3))->groupBy('banquet_id')->asArray()->all();
//         var_dump($res[0]['sell']);die;
         return empty($res) ? 0 : $res[0]['sell'];
      }

    /**
     * 根据流水席id号获取商家及流水席的信息
     * @param $banquet_id
     * @return array|bool
     */
    static public function getShopbanquetById($banquet_id)
    {
        $query = new Query();
        $query->select('sb.* ,s.shop_name ,s.address ,s.shop_lng ,s.shop_lat')->from(ShopBanquet::tableName().'sb');
        $query->leftJoin(Shop::tableName().'s','s.shop_id = sb.shop_id');
        $query->where(array('sb.banquet_id'=>$banquet_id));
        $result = $query->one();
        return $result;
    }
    /**
     * 根据商家id号关闭所有流水席
     * @param $banquet_id
     * @return array|bool
     */
    static public function closeShopbanquet($shop_id)
    {
        $query=new Query();
        $query->from([
            static::tableName()
        ]);
        $query->where(['shop_id'=>$shop_id]);
        $data=$query->all();
        foreach ($data as $key=>$value)
        {
            //$model=static::find()->where(['banquet_id'=>$value['banquet_id']])->one();
            //$model->banquet_status=0;
            //$model->update();
            ShopBanquet::updateAll([
                        'banquet_status' => 0
                    ], [
                        'banquet_id' => $value['banquet_id']
                    ]);
            $user_orders = UserOrder::find()->where(array('banquet_id'=>$value['banquet_id'],'order_status'=>0))->asArray()->all();
            foreach ($user_orders as $user_order)
            {
                BackOrder::toRefund($user_order['record_id']);
            }
        }

    }
}