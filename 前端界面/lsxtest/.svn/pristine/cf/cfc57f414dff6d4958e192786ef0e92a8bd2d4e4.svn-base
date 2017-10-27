<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 9:27
 * 菜品管理
 */
namespace app\modules\shop\controllers;


use common\models\ShopMenu;
use common\models\ShopAccount;
use common\models\BanquetMenu;
use common\models\ShopBanquet;
use yii\db\Query;
use yii\web\Controller;

class VarietyController extends Controller
    {
    public function init ()
    {
        $init_class = new \seller\controllers\InitController();
        $init_class->actionClassName();
    }
    public $enableCsrfValidation = false;
  
    //菜品列表
    public function actionIndex (){
        $session = \Yii::$app->session;
        $shop_usermsg = $session->get('seller_msg');
        if($shop_usermsg['shop_id']){
            $variety_list = ShopMenu::find()->where('shop_id='.$shop_usermsg['shop_id'].'')->orderBy('create_time desc')->asArray()->all();
        }
        // \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $params['variety_list']=$variety_list;
        return $this->render('index.tpl',$params);
    }
    //添加菜品
    public function actionAdd (){
        $session = \Yii::$app->session;
        $shop_usermsg = $session->get('seller_msg');
        if($shop_usermsg['shop_id']&&\Yii::$app->request->isPost){
            $shop_menu = $_POST;
           foreach ($shop_menu['dish_name'] as $key => $value) {
                $model = new ShopMenu();
                $model->dish_name = $shop_menu['dish_name'][$key];
                $model->dish_price = $shop_menu['dish_price'][$key];
                $model->create_time = time();
                $model->shop_id = $shop_usermsg['shop_id'];
                $result = $model->insert(false);
           }
            if( $result){
                $count = ShopMenu::find()->where('shop_id='.$shop_usermsg['shop_id'].'')->count();
                ShopAccount::updateAll([
                        'foods' =>  $count
                    ], [
                        'shop_id' => $shop_usermsg['shop_id']
                    ]);
                \Yii::$app->getSession()->setFlash('success', '保存成功');
            }else{
                \Yii::$app->getSession()->setFlash('error', '保存失败');
            }
            return $this->redirect(['index']);
            // $variety_one = ShopMenu::find()->where('shop_id='.$shop_usermsg['shop_id'].' and menu_id='.$_GET['menu_id'].'')->asArray()->one();
        }
        return $this->render('add.tpl');
    }

    //编辑菜品
    public function actionUpdate (){
        $session = \Yii::$app->session;
        $shop_usermsg = $session->get('seller_msg');
        if($shop_usermsg['shop_id']&&$_GET['dish_id']){
            $variety_one = ShopMenu::find()->where('shop_id='.$shop_usermsg['shop_id'].' and dish_id='.$_GET['dish_id'].'')->asArray()->one();
        }
        if (\Yii::$app->request->isPost&&$shop_usermsg['shop_id']) {
            //$is_menu = BanquetMenu::find()->where('shop_id='.$shop_usermsg['shop_id'].' and menu_id='.$_GET['dish_id'].'')->count();
            //if($is_menu) {
            //    var_dump('该菜品还有流水席在使用不能删除');die;
            //}
            $result = ShopMenu::updateAll([
                        'dish_price' =>  $_POST['dish_price'], 
                        'dish_name' => $_POST['dish_name'],
                        'update_time' => gmtime(),
                    ], [
                        'dish_id' => $_POST['dish_id'],
                        'shop_id' => $shop_usermsg['shop_id']
                    ]);
            if($result){
                    BanquetMenu::updateAll([
                        'menu_price' =>  $_POST['dish_price'], 
                        'menu_name' => $_POST['dish_name'],
                        'update_time' => gmtime(),
                    ], [
                        'dish_id' => $_POST['dish_id'],
                        'shop_id' => $shop_usermsg['shop_id']
                    ]);
                $banquet_id_arr = BanquetMenu::find()->select('banquet_id')->where('shop_id='.$shop_usermsg['shop_id'].' and dish_id='.$_POST['dish_id'].'')->all();
                foreach ($banquet_id_arr as $value) {
                    $menu_money = BanquetMenu::find()->select('menu_quantity,menu_price')->where('shop_id='.$shop_usermsg['shop_id'].' and banquet_id='.$value['banquet_id'].'')->asArray()->all();
                        $banquet_amount=0;
                        if (is_array($menu_money)) {
                            foreach ($menu_money as $vm) {
                                $banquet_amount+=$vm['menu_quantity']*$vm['menu_price'];
                            }
                        }
                        
                        ShopBanquet::updateAll(['banquet_amount'=>$banquet_amount]
                                    , [
                                        'banquet_id' => $value['banquet_id'],
                                        'shop_id' => $shop_usermsg['shop_id']
                                    ]);
                }
                \Yii::$app->getSession()->setFlash('success', '保存成功');
            }else{
                \Yii::$app->getSession()->setFlash('error', '保存失败');
            }
            return $this->redirect(['index']);
        }
        $params['variety_one'] = $variety_one;
        return $this->render('update.tpl',$params);
    }

    //删除菜品
    public function actionDelete (){
        $session = \Yii::$app->session;
        $shop_usermsg = $session->get('seller_msg');
        if (\Yii::$app->request->isAjax&&$shop_usermsg['shop_id']&&$_POST['dish_id']) {
            //$is_menu = BanquetMenu::find()->where('shop_id='.$shop_usermsg['shop_id'].' and menu_id='.$_POST['dish_id'].'')->count();
            //if($is_menu) {
            //    return ['status'=>0,'msg'=>'该菜品还有流水席在使用不能删除'];
            //}
            $banquet_id_arr = BanquetMenu::find()->select('banquet_id')->where('shop_id='.$shop_usermsg['shop_id'].' and dish_id='.$_POST['dish_id'].'')->all();
            foreach ($banquet_id_arr as $kid => $vid) {
                if (BanquetMenu::find()->where('shop_id='.$shop_usermsg['shop_id'].' and banquet_id='.$vid['banquet_id'].'')->count()<2) {
                    $banquet_one = ShopBanquet::find()->where('banquet_serial,banquet_name')->where('shop_id='.$shop_usermsg['shop_id'].' and banquet_id='.$vid['banquet_id'].'')->asArray()->one();
                    return ['status'=>0,'msg'=>'流水席标题:'.$banquet_one['banquet_name'].'-流水席编号:'.$banquet_one['banquet_serial'].'的菜品不足2个，不能删除！流水席至少要有一个菜品.'];
                }
            }
            $result = ShopMenu::deleteAll([
                'dish_id' => $_POST['dish_id'],
                'shop_id' => $shop_usermsg['shop_id']
            ]);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if($result){
                $count = ShopMenu::find()->where('shop_id='.$shop_usermsg['shop_id'].'')->count();
                ShopAccount::updateAll([
                        'foods' =>  $count
                    ], [
                        'shop_id' => $shop_usermsg['shop_id']
                    ]);
                BanquetMenu::deleteAll([
                'dish_id' => $_POST['dish_id'],
                'shop_id' => $shop_usermsg['shop_id']
                ]);
                foreach ($banquet_id_arr as $value) {
                    $menu_money = BanquetMenu::find()->select('menu_quantity,menu_price')->where('shop_id='.$shop_usermsg['shop_id'].' and banquet_id='.$value['banquet_id'].'')->asArray()->all();
                        $banquet_amount=0;
                        if (is_array($menu_money)) {
                            foreach ($menu_money as $vm) {
                                $banquet_amount+=$vm['menu_quantity']*$vm['menu_price'];
                            }
                        }
                        
                        ShopBanquet::updateAll(['banquet_amount'=>$banquet_amount]
                                    , [
                                        'banquet_id' => $value['banquet_id'],
                                        'shop_id' => $shop_usermsg['shop_id']
                                    ]);
                }

                $res=['status'=>1,'msg'=>'删除成功'];
            }else{
                $res=['status'=>0,'msg'=>'删除失败'];
            }
            return $res;
        }else{
            $res=['status'=>0,'msg'=>'数据异常'];
        }
        $params['variety_one'] = $variety_one;
        //return $this->render('update.tpl',$params);
    }

}