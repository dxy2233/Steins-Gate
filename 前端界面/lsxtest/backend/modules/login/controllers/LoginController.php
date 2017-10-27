<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 9:27
 */
namespace app\modules\login\controllers;

use app\modules\login\models\LoginDo;
use common\models\Admin;
use yii\web\Controller;
use yii\web\Cookie;

class LoginController extends Controller{

    public $layout = false;

    public function __construct ($id, $module, $config = [])
    {
        $module = \Yii::$app->getModule('login');
        parent::__construct($id, $module, $config);
    }

    public function actionLogin (){
        if(posts())
        {
            $post=posts();
            $res=LoginDo::Login($post);
//            var_dump($res);die();
//            var_dump($res);
            if($res)
            {
//                echo '111';die();
                return $this->redirect('/index/index/index');
            }
        }
        $res=LoginDo::Islogin();
        $cookie = \Yii::$app->request->cookies;
//        var_dump($cookie->getValue('admin_name'));die();
        if($res)
        {
            return $this->redirect('/index/index/index');
        }
//        $model=new Admin();
//        $model->role_id=1;
//        $model->user_name='admin';
//        $model->password=setpassword('123456');
//        $model->status=1;
//        $model->last_time=time();
//        $model->create_time=time();
//        $model->last_ip=$_SERVER["REMOTE_ADDR"];
//        $model->save();



        return $this->render('login.tpl');

    }
    public function actionOverdue()
    {
        return $this->render('overdue.tpl');
    }


}