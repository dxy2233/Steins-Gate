<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 15:12
 */
namespace common\models;

use yii\base\UserException;
use yii\db\ActiveRecord;
use yii\db\Query;

class ShopMenu extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%shop_menu}}';
    }

    public function rules()
    {
        return [  ];
    }


}