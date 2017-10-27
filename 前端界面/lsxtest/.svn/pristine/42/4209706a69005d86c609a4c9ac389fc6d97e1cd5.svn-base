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

class Region extends ActiveRecord{

    public static function tableName()
    {
        return '{{%region}}';
    }
    static public function getlist($where=''){
        $result = static::find()->where(array('level'=>$where))->asArray()->all();
        return $result;
    }
    static public function get_parent_code($where=''){
        $result = static::find()->where(array('parent_code'=>$where))->asArray()->all();
        return $result;
    }
    static public function get_region_code($where=''){
        $result = static::find()->where(array('region_code'=>$where))->asArray()->all();
        return $result;
    }
    static public function get_region_id($where=''){
        $result = static::find()->where(array('region_id'=>$where))->one();
        return $result;
    }
    //处理传回来的城市信息，并返回最深层级
    public static function city($post=null)
    {
        if(!empty($post['s_county']))
        {
            $region_code=$post['s_county'];
            return $region_code;
        }
        if(!empty($post['s_city']))
        {
            $region_code=$post['s_city'];
            return $region_code;
        }
        if(!empty($post['s_province']))
        {
            $region_code=$post['s_province'];
            return $region_code;
        }
        return null;

    }
    //逆向处理城市信息
    public static function recity($region_code)
    {
        $post=[
            's_province'=>'',
            's_city'=>'',
            's_county'=>''
        ];
        $model=Region::find()->where(['region_code'=>$region_code])->asArray()->one();
        $level=$model['level'];
        if ($level==1)
        {
          $post['s_province']=$model['region_code'];
          return $post;
        }
        if($level==2)
        {
            $post['s_province']=$model['parent_code'];
            $post['s_city']=$model['region_code'];
            return $post;
        }
        if($level==3)
        {
            $post['s_province']=strstr($model['region_code'],',',true);
            $post['s_city']=$model['parent_code'];
            $post['s_county']=$model['region_code'];
            return $post;
        }
    }
}