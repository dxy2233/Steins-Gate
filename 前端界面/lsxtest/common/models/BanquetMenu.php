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

class BanquetMenu extends ActiveRecord{

    public static function tableName()
    {
        return '{{%banquet_menu}}';
    }

    /*
     * 获取流水席的菜单
     * @banquet_id 流水席id
     */
    static public function getMenu ($banquet_id = '')
    {
         $result = BanquetMenu::find()->select('*')->where(array('banquet_id'=>$banquet_id))->orderBy('update_time desc')->asArray()->all();
         return $result;
    }
}