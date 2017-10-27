<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 9:27
 * 用户设置控制器
 */
namespace app\modules\system\controllers;


use common\models\ShopUser;
use yii\db\Query;
use yii\web\Controller;

class ShopsetController extends Controller
    {
    //获取初始用户信息
    public $shop_usermsg;
    public function init ()
    {
        $init_class = new \seller\controllers\InitController();
        $init_class->actionClassName();
        $session = \Yii::$app->session;
        $this->shop_usermsg = $session->get('seller_msg');
    }
    public $enableCsrfValidation = false;
    //首页
    public function actionIndex (){
        
        $params[] = '';
        return $this->render('index.tpl',$params);
    }
    //修改密码
    public function actionUpdate_pwd (){
        
        if(\Yii::$app->request->isPost&&$_POST['new_password1']&&$_POST['old_password']) {
            $shop_user_msg = ShopUser::find()->where('seller_id="'.$this->shop_usermsg['seller_id'].'" and user_status=1')->asArray()->one();
            if(!$shop_user_msg) {
                echo "<script>alert('该用户不存在或已被禁用');window.location.href='update_pwd';</script>";
                die();
                //var_dump('该用户不存在或已被禁用');die();
            }
            if (getpassword($_POST['old_password'],$shop_user_msg['password'])) {
                $result = ShopUser::updateAll([
                                    'password' => setpassword($_POST['new_password1'])
                                ], [
                                    'shop_id' => $this->shop_usermsg['shop_id']
                                ]);
                if ($result) {
                    return $this->redirect(array('/shop/center/index'));
                }else{
                echo "<script>alert('密码修改失败');window.location.href='update_pwd';</script>";
                die();
                    //var_dump('密码修改失败');die();
                }
            }else{
                echo "<script>alert('旧密码错误');window.location.href='update_pwd';</script>";
                die();
                //var_dump('旧密码错误');die();
            }
            // $sure_is = ShopUser::find()->where('shop_id='.$this->shop_usermsg['shop_id'].'')->asArray()->one();
            
        }
        // ,$params
        return $this->render('update_pwd.tpl');
    }
    
    //退出登录
    public function actionLoginout (){
        $session = \Yii::$app->session;
        $session->set('seller_id','');
        $session->set('seller_msg','');
        return $this->redirect(array('/user/login/index'));
    }

}