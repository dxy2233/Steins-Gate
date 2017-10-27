<?php
namespace app\modules\index\filters;
use app\modules\login\models\LoginDo;
use yii\base\ActionFilter;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/28
 * Time: 10:50
 */
class PermissionFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        date_default_timezone_set('PRC');
        $res=LoginDo::Islogin();
        $rbs=LoginDo::Istimeout();
        $cookie = \Yii::$app->request->cookies;
//        var_dump($cookie->getValue('admin_name'));die();
        if(!$res)
        {
            $model = new Controller('','', $config = []);
            if($rbs)
            {
                return $model->redirect('/login/login/overdue');
            }
            return $model->redirect('/login/login/login');
//
//            return $this->goBack('index');
//            header("location:".Url::to('/login/login/login',true));

        }

        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

}