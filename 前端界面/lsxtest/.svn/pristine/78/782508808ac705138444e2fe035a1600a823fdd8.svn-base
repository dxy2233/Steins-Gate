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

class Category extends ActiveRecord{

    public static function tableName()
    {
        return '{{%category}}';
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
        $query->select('c.*')->from(Category::tableName().'c');
        $query->orderBy('category_sort asc');
        $result = $query->all();
        $params = $result;
        return $params;
    }

    /*
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
         $query->select();
         return $params;
     }
     //读取单条数据
    static public function getlist($id=''){
        $result = static::find()->where('category_id='.$id)->one();
        return $result;
    }
    //修改
    static public function Category_update($id='',$data=array()){
        $list = array(
            'category_name'=>$data['category_name'],
            'category_url'=>$data['category_url'],
            'category_path'=>$data['category_path'],
            'category_sort'=>$data['category_sort'],
        );
        $carousel = static::updateAll($list,array('category_id' => $id));
        return $carousel;
    }
    //删除
    static public function Category_delete($id=''){
        $carousel = static::deleteAll(array('category_id' => $id));
        return $carousel;
    }
    static public function getAllpage(){
        $query = new Query();
        $query->select('c.*')->from(Category::tableName().'c');
        $query->orderBy('category_sort asc');
        $result = $query->all();
        $result=page($query);
        return $result;
    }
}