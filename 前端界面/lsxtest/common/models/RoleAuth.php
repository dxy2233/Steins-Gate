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
class RoleAuth extends ActiveRecord{

    public static function tableName()
    {
        return '{{%role_auth}}';
    }
    static public function getleftmenu($id){
        $query = new Query();
        $query->select('m.menu_name')->from(static::tableName() . 'r');
        $query->leftJoin(Menu::tableName() . 'm', 'm.menu_id = r.menu_id');
        $query->andWhere(array('r.role_id' =>$id));
        $query->orderBy('m.menu_id desc');
        $result = $query->all();
        return $result;
    }
    //添加角色权限
    public static function addroleauth($data)
    {
       $model=new RoleAuth();
        //child_id对应menu表的menu_id,parent_id对应menu表同名字段，这里我就先写死了，有类似的设计前端图出来后自己改。
       $model->child_id=1;
       $model->parent_id=0;
       $model->role_id=$data['role_id'];
       $model->menu_id=$data['menu_id'];
       $model->save();


    }
    //判定当前角色是否拥有某种权限
    public static function IsAuth($menu_id)
    {
        $cookie = \Yii::$app->request->cookies;
        $user_id = $cookie->getValue('user_id');
        if(empty($user_id))
        {
            return null;
        }
        $user= Admin::getone($user_id);
        $role_id =$user['role_id'];
        $query=new Query();
        $query->from(static::tableName());
        $query->where(['role_id'=>$role_id,'menu_id'=>$menu_id]);
        $res=$query->all();
        return $res;

    }
}