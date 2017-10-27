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

class BanquetType extends ActiveRecord{

    public static function tableName()
    {
        return '{{%banquet_type}}';
    }

    public function rules()
    {
        return [ ];
    }

    /*
     *获取流水席所有分类，按照排序顺序返回
     * @returrn string params
     */
    static public function getAllCategory()
    {
        $params = [];
        $query = new Query();
        $query->select('b.*')->from(Category::tableName().'b');
        $query->orderBy('category_sort asc');
        $result = $query->all();
        $params = $result;
        return $params;
    }
    /*
        *获取流水席所有分类，按照排序顺序返回
        * @returrn string params
        */
    static public function getAllType()
    {
        $params = [];
        $query = new Query();
        $query->select('b.*')->from(static::tableName().'b');
        $query->orderBy('type_sort asc');
        $result = $query->all();
        $params = $result;
        return $params;
    }
    /*
     * 根据流水席分类获取对应的流水席
     * @cat_id 流水席分类
     * @params return array
     */
     static public function getLsxFromCate($cat_id = '')
     {
         $params = [];
         if(empty($cat_id)){
             return $params;
         }
         $query = new Query();
         $query->select('s.* ,t.type_name ,a.shop_lng ,a.shop_lat ,a.shop_name' )->from(ShopBanquet::tableName().'s');
         $query->leftJoin(static::tableName() . ' t', 's.type_id = t.type_id');
         $query->leftJoin(Shop::tableName() . ' a', 'a.shop_id = s.shop_id');
//         $query->leftJoin(BanquetOrder::tableName().'bo','bo.banquet_id = s.banquet_id');
         $query->where(array('s.type_id'=>$cat_id,'s.banquet_status'=>1,'a.shop_status'=>1));
//         $query->groupBy('s.banquet_id');
         $result = $query->all();
         foreach ($result as $item=>&$value)
         {
             $value['score'] = substr($value['service_score'],0,1);
             $value['banfen'] = substr($value['service_score'], strpos($value['service_score'], '.')+1,1);
//             $sells = ShopBanquet::getsells($value['banquet_id']);
             $value['sell'] = ShopBanquet::getsells($value['banquet_id']);
         }
         $params = $result;
         return $params;
     }
    //修改
    static public function banquet_update($id='',$data=array()){
        $list = array(
            'type_name'=>$data['type_name'],
            'type_sort'=>$data['type_sort'],
            'type_path'=>$data['type_path'],
            'type_url'=>$data['type_url'],
        );
        $carousel = static::updateAll($list,array('type_id' => $id));
        return $carousel;
    }
    //读取单条数据
    static public function getone($id=''){
        $result = static::find()->where('type_id='.$id)->one();
    return $result;
    }
}