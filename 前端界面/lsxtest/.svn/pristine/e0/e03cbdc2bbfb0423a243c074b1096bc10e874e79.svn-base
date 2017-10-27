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
class Menu extends ActiveRecord{

    public static function tableName()
    {
        return '{{%menu}}';
    }
        static public function getList()
    {
        $query = new Query();
        $query->select('m.*')->from(static::tableName().'m');
        $list = $query->all();

        return $list;

    }
}