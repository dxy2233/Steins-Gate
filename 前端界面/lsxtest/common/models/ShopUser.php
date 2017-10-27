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

class ShopUser extends ActiveRecord{

    public static function tableName()
    {
        return '{{%shop_user}}';
    }
    public static function ShopUser($shop_user)
    {
        $shop_user=ShopUser::find()->where(['shop_user'=>$shop_user])->asArray()->one();
        return $shop_user;
    }

}