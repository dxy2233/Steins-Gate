<?php
namespace app\modules\login\models;
use common\models\Admin;
use yii\base\Model;
use yii\web\Cookie;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 11:24
 */
class LoginDo extends Model
{
         public static function Login($post)
         {
             if(empty($post['user_name'])||empty($post['password']))
             {
                 return false;
             }
             date_default_timezone_set('PRC');
             $model=Admin::find()->where(['user_name'=>$post['user_name']])->one();
             if(empty($model))
             {
                 return false;
             }
             $passwordhash=$model->password;
             $res=getpassword($post['password'],$passwordhash);
             if($res)
             {
                 $cookies= \YII::$app->response->cookies;
                 $data=[
                     'name'=>'admin_name',
                     'value'=>$model->user_name,
                     'expire'=>time()+3600
                 ];
                 $cookies->add(new Cookie($data));
                 //存储管理员id
//                 setcookie('admin_id',$model->user_id,time()+3600);
                 $data=[
                     'name'=>'ip',
                     'value'=>$model->last_ip,
                     'expire'=>time()+3600
                 ];
                 $cookies->add(new Cookie($data));
                 $data=[
                     'name'=>'last_time',
                     'value'=>$model->last_time,
                     'expire'=>time()+3600
                 ];
                 $cookies->add(new Cookie($data));
                 $data=[
                     'name'=>'role_id',
                     'value'=>$model->role_id,
                     'expire'=>time()+3600
                 ];
                 $cookies->add(new Cookie($data));
                 $data=[
                     'name'=>'user_id',
                     'value'=>$model->user_id,
                     'expire'=>time()+3600
                 ];
                 $cookies->add(new Cookie($data));
                 $data=[
                     'name'=>'time',
                     'value'=>'yes',
                     'expire'=>time()+28800
                 ];
                 $cookies->add(new Cookie($data));
                 $model->last_time=time();
                 $model->last_ip=\Yii::$app->request->userIP;
                 $model->visit_count=$model->visit_count+1;
                 $model->update();

             }
             return $res;

         }
         public static function Islogin()
         {
             $cookie = \Yii::$app->request->cookies;
             if (!empty($cookie->getValue('admin_name')))
             {
                  return true;
             }
             else
              {
                  return false;
              }

         }
         public static function Istimeout()
         {
             $cookie = \Yii::$app->request->cookies;
             if (!empty($cookie->getValue('time')))
             {
                 return true;
             }
             else
             {
                 return false;
             }
         }
}