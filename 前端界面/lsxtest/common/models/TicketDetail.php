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

class TicketDetail extends ActiveRecord{

    public static function tableName()
    {
        return '{{%ticket_detail}}';
    }

    /*
     * 获取用户饭票明细
     * @user_id int 用户id
     * @return array params
     */
    static public function getTicketList($user_id = '')
    {
        $params = [];
        if(empty($user_id))
        {
            return $params;
        }
        $query = new Query();
        $query->select('td.*')->from(TicketDetail::tableName().'td');
        $query->where(array('user_id'=>$user_id));
        $query->orderBy('td.ticket_id desc');
        $result = $query->all();

        $params = $result;
        return $params;
    }

}