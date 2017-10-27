<?php

namespace common\models;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;
class Banner extends ActiveRecord
{
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
    static public function getInfo($where = '')
    {
        $query = new Query();
        $query->select('*')->from(Banner::tableName());
        $query->where($where);
        $query->orderBy('create_time desc');
        $data = $query->all();
        
        return $data;
    }
}