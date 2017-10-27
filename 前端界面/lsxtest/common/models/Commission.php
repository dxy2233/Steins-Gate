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

class Commission extends ActiveRecord{

    public static function tableName()
    {
        return '{{%commission}}';
    }

    public function rules()
    {
        return [ ];
    }
    //根据商家ID获取最新的分佣比例
    public static function GetCommissionRate($shop_id)
    {
        $arr=Commission::find()->where(['shop_id'=>$shop_id])->orderBy('create_time DESC')->one();
        return $arr['commission_rate'];

    }

}