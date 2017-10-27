<?php
namespace app\modules\user\models;
use common\models\TicketDetail;
use common\models\User;
use common\models\UserAccount;
use common\models\UserOrder;
use yii\base\Model;
use yii\db\Query;


/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/19
 * Time: 11:07
 */
class UserDo extends Model
{
   public static function UserList($post=null)
   {
     $query=new Query();
       $query->select([
           'u.*'
       ]);
       $query->from([
           'u' => User::tableName()
       ]);
       //用户名
       if(!empty($post['user_name']))
       {
           $query->andWhere([
               'like',
               'u.user_name',
               $post['user_name']
           ]);
       }
       //用户状态
       if(!empty($post['user_status']))
       {
           $user_status=$post['user_status']-1;
           $query->andWhere([
               'u.user_status' => $user_status
           ]);
       }
       //手机号
       if(!empty($post['mobile']))
       {
           $query->andWhere([
               'u.mobile' => $post['mobile']
           ]);
       }
       //创建日期
       if(!empty($post['create_time_start']))
       {
           $create_time_start=strtotime($post['create_time_start']);
           $query->andwhere('u.reg_time >= :create_time_begin', [
               ':create_time_begin' => $create_time_start
           ]);
       }
       if(!empty($post['create_time_end']))
       {
           $create_time_end=strtotime($post['create_time_end']);
           $query->andwhere('u.reg_time <= :create_time_end', [
               ':create_time_end' => $create_time_end
           ]);
       }
       //地区检索
       if(!empty($post['region_code']))
       {
           $query->andWhere("u.region_code like :region_code", [
               ':region_code' => $post['region_code'] . '%'
           ]);
       }
       $data=$query->all();
       $data=fenye($data);
       return $data;

   }
   public static function UserInfo($id='')
   {
       //用户详情
       $query=new Query();
       $query->select('u.*,uo.*')->from(User::tableName().'u');
       $query->leftJoin(UserAccount::tableName().'uo','uo.user_id = u.user_id');
       $query->where(['u.user_id'=>$id]);
       $result = $query->one();
//       $query=new Query();
//       $data=$query->select('u.*')->from(['u'=>User::tableName()])->where(['user_id'=>$id])->one();
       $query=new Query();
       $query->select('uo.*')->from(['uo'=>UserOrder::tableName()])->where(['user_id'=>$id,'order_status'=>3]);
       //成交订单
       $result['total_orders']=$query->count('record_id');
       //消费金额
       $result['total_amount']=$query->sum('pay_amount')+$query->sum('pay_meal_ticket');
       $query=new Query();
       $query->select('td.*')->from(['td'=>TicketDetail::tableName()])->where(['ticket_status'=>1,'user_id'=>$id]);
       //饭票总额
       $result['meal_ticket']=$query->sum('ticket_amount');
       //饭票余额
//       $query=new Query();
//       $query->select('ua.meal_balance,ua.recommend_users')->from(['ua'=>UserAccount::tableName()])->where(['user_id'=>$id]);
//       $arr=$query->all();
//       $data['meal_balance']=$arr[0]['meal_balance'];
//       $data['recommend_users']=$arr[0]['recommend_users'];
//       $query->select([
//           'u.*',
//           'ua.*'
//       ]);
//
//       $query->from([
//           'u' => User::tableName()
//       ]);
//       $query->leftJoin([
//           'ua' => UserAccount::tableName()
//       ], 'u.user_id = ua.user_id');
//       $query->andWhere([
//           'u.user_id' => $id
//       ]);
//       $data=$query->one();
       return $result;
   }
   public static function UserEdit($data)
   {
       $model =User::findOne($data['user_id']);
       $model->user_status=$data['user_status'];
       $res=$model->update();
       return $res;
   }
   public static function birthday($birthday)
   {
       list($year,$month,$day) = explode("-",$birthday);
       $year_diff = date("Y") - $year;
       $month_diff = date("m") - $month;
       $day_diff  = date("d") - $day;
       if ($day_diff < 0 || $month_diff < 0)
           $year_diff--;
       return $year_diff;
   }
}