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
class Role extends ActiveRecord{

    public static function tableName()
    {
        return '{{%role}}';
    }
        static public function getList()
    {
        $query = new Query();
        $query->select('r.*')->from(static::tableName().'r');
        $list = $query->all();
        return $list;
    }
    //新增角色
    public static function addrole($post)
    {
        $model=new static();
        $model->role_name=$post['role_name'];
        $model->role_desc=$post['role_desc'];
        $model->create_time=gmtime();
        $model->role_type=1;
        $res=$model->save();
        return $model->role_id;
    }
    //查询角色是否重复
    public static function selectrole($role_name)
    {
      $res=static::find()->where(['role_name'=>$role_name])->one();
      if(!empty($res))
      {
          return false;
      }
      return true;
    }

}