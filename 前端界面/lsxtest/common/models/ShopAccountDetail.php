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

class ShopAccountDetail extends ActiveRecord{

    public static function tableName()
    {
        return '{{%shop_account_detail}}';
    }

}