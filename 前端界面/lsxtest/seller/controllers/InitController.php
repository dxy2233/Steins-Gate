<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 9:27
 */
namespace seller\controllers;


use common\models\User;
use common\models\ShopUser;
use common\models\Shop;
use yii\base\ActionFilter;
use yii\helpers\Url;
use yii\db\Query;
use yii\web\Controller;
header("Content-type:text/html;charset=utf-8");
class InitController extends Controller{
public function __construct ()
{
}
    //初始化登录信息
public function actionClassName ()
    {
        $session = \Yii::$app->session;
        if(!$session->get('seller_id')||!$session->get('seller_msg')) {
        return $this->redirect(array('/user/login/index'));
        }
        if($session->get('seller_id')) {
            $shop_usermsg = ShopUser::find()->where('seller_id=1')->asArray()->one();
            if($shop_usermsg) {
                if (!$shop_usermsg['user_status']) {
                    $session->set('seller_id','');
                    $session->set('seller_msg','');
                    echo ("<script> alert('该商家已被停用,退出登录！');window.location.href='/user/login/index';</script>");
                    die();
                }
                $shop_msg = Shop::find()->select('shop_status')->where('shop_id="'.$shop_usermsg['shop_id'].'"')->asArray()->one();
                if (!$shop_msg['shop_status']) {
                    echo ("<script> alert('该商家已被停用,退出登录！');window.location.href='/user/login/index';</script>");
                    $session->set('seller_id','');
                    $session->set('seller_msg','');
                    die();
                }
            }
        }
    }

}