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

class Carousel extends ActiveRecord{

    public static function tableName()
    {
        return '{{%carousel}}';
    }

    public function rules()
    {
        return [
            ['carousel_path','class_sort','operator_id','create_time','required'],
            ['carousel_path', 'string', 'length' => [0,255]],
            ['class_sort', 'number', array('min' => 0, 'max' => 255)],
            ['operator_id','integer']
        ];
    }
    /*
     * 获取当前的轮播图
     */
    static public function getLb()
    {
//        $result = static::find()->orderBy('class_sort asc')->asArray()->all();
        $query = new Query();
        $query->select('c.*,a.user_name')->from(Carousel::tableName() . ' c');
        $query->leftJoin(Admin::tableName() . ' a', 'a.user_id = c.operator_id');
        $query->orderBy('c.class_sort asc');
        $result=page($query);
        return $result;

    }

    static public function getLb2()
    {
        $query = new Query();
        $query->select('c.*')->from(Carousel::tableName() . ' c');
//        $query->leftJoin(Admin::tableName() . ' a', 'a.user_id = c.operator_id');
        $query->orderBy('c.class_sort asc');
        $result=$query->all();
        return $result;
    }

    static public function getlist($id=''){
        $result = static::find()->where('carousel_id='.$id)->one();
        return $result;
    }
    static public function Carousel_update($id='',$data=array()){
        $list = array(
            'carousel_descprtion'=>$data['carousel_descprtion'],
            'class_sort'=>$data['class_sort'] ? $data['class_sort'] : 255,
            'carousel_url'=>$data['carousel_url'],
            'carousel_path'=>$data['carousel_path'],
            'is_display'=>$data['is_display'],
            'operator_id'=>$data['operator_id'],
            'update_time'=>gmtime(),
        );
        $carousel = static::updateAll($list,array('carousel_id' => $id));
        return $carousel;
    }
    static public function Carousel_delete($id=''){
        $carousel = static::deleteAll(array('carousel_id' => $id));
        return $carousel;
    }
}