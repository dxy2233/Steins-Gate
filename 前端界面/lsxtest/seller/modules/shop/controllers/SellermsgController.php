<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 9:27
 * 商家信息管理
 */
namespace app\modules\shop\controllers;


use common\models\Shop;
use common\models\Region;
use yii\db\Query;
use yii\web\Controller;

class SellermsgController extends Controller
    {
    public $enableCsrfValidation = false;
    public function init ()
    {
        $init_class = new \seller\controllers\InitController();
        $init_class->actionClassName();
    }
    //商家信息详情
    public function actionIndex (){
        $session = \Yii::$app->session;
        $shop_usermsg = $session->get('seller_msg');
        if($shop_usermsg['shop_id']){
            if(\Yii::$app->request->isPost) {
                $num_msg = Shop::updateAll([
                                    'merchant_telphone' => $_POST['merchant_telphone'],
                                    'merchant_area' => $_POST['merchant_area'],
                                    'merchant_seats' => $_POST['merchant_seats'],
                                    'merchant_name' => $_POST['merchant_name'],
                                    'merchant_mobile' => $_POST['merchant_mobile'],
                                    'opening_hour' => $_POST['opening_hour'],
                                    'closing_hour' => $_POST['closing_hour'],
                                    'update_time' => time()
                                ], [
                                    'shop_id' => $shop_usermsg['shop_id']
                                ]);
                    if($num_msg){
                        return $this->redirect(array('/shop/center/index'));
                    }else{
                        echo "<script>alert('修改失败');window.location.href='index';</script>";
                        die();
                        //var_dump('修改是失败');die;
                    }
            }
            $shop_msg = Shop::find()->where('shop_id='.$shop_usermsg['shop_id'].'')->asArray()->one();
            if($shop_msg['region_code']) {
                $area = Region::find()->select('parent_code,region_name')->where('region_code="'.$shop_msg['region_code'].'"')->asArray()->one();
                if($area['parent_code']) {
                    $city = Region::find()->select('parent_code,region_name')->where('region_code="'.$area['parent_code'].'"')->asArray()->one();
                    $province = Region::find()->select('region_name')->where('region_code="'.$city['parent_code'].'"')->asArray()->one();
                    if($province['region_name']!=$city['region_name']) {
                        $shop_msg['region_code']=$province['region_name'].'、'.$city['region_name'].'、'.$area['region_name'];
                    }else{
                        $shop_msg['region_code']=$province['region_name'].'、'.$area['region_name'];
                    }
                    
                }
            }
        }
       
        $params['shop_msg']= $shop_msg;
        return $this->render('index.tpl',$params);
    }

}