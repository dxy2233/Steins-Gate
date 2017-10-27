<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;

class MealTicket extends ActiveRecord{

    public static function tableName()
    {
        return '{{%meal_ticket}}';
    }

    public function rules()
    {
        return [ ];
    }
    static public function getList()
    {
        $query = new Query();
        $query->select('m.*,a.user_name')->from(static::tableName() . 'm');
        $query->leftJoin(Admin::tableName() . 'a', 'a.user_id = m.operator_id');
        $query->orderBy('m.ticket_id desc');
        $result = $query->all();
        return fenye($result);
    }

}