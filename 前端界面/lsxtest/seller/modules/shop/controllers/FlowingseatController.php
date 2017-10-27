<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 9:27
 *流水席管理
 */
namespace app\modules\shop\controllers;


use common\models\Shop;
use common\models\BanquetType;
use common\models\BanquetMenu;
use common\models\BanquetOrder;
use common\models\ShopMenu;
use common\models\ShopBanquet;
use common\models\BackOrder;
use common\models\UserOrder;
use common\web\Upload;
use yii\db\Query;
use yii\web\Controller;
use yii\web\UploadedFile;
class FlowingseatController extends Controller
    {
    //获取初始用户信息
    public $shop_usermsg;
    public function init ()
    {
        $init_class = new \seller\controllers\InitController();
        $init_class::className();
        $session = \Yii::$app->session;
        $this->shop_usermsg = $session->get('seller_msg');
    }

    public $enableCsrfValidation = false;
    //流水席管理列表
    public function actionIndex (){
         
         if($this->shop_usermsg['shop_id']) {
             //$list = ShopBanquet::find()->where('shop_id='.$this->shop_usermsg['shop_id'].'')->orderBy('create_time desc')->asArray()->all();
             $query = new Query();
            $query->select('sb.*');
            $query->from(ShopBanquet::tableName() . ' sb');
            //$query->leftJoin(BanquetType::tableName() . ' bt', 'sb.type_id = bt.type_id');
             // $query->leftJoin(BanquetMenu::tableName() . ' bm', 'sb.banquet_id = bm.banquet_id');

            $query->where([
                'sb.shop_id' => $this->shop_usermsg['shop_id']
            ]);

            $list = $query->orderBy('sb.create_time desc')->groupBy('banquet_id')->all();
            // if (is_array($list)) {
            //     foreach ($list as $key => $value) {
            //         $list[$key]['menu_price'] = $value['menu_price']*$value['menu_quantity'];
            //     }
            // }
             $params['list'] = $list;
         }
        return $this->render('index.tpl',$params);
    }
    //添加流水席菜品
    public function actionAdd (){
        if($this->shop_usermsg['shop_id']) {
            if(\Yii::$app->request->isPost&&$_POST['dish_id']&&$_POST['banquet_id']) {
                if (is_array($_POST['dish_id'])) {
                    $result=0;
                    foreach ($_POST['dish_id'] as $key => $value) {
                        $menu_msg = ShopMenu::find()->where('shop_id='.$this->shop_usermsg['shop_id'].' and dish_id='.$value.'')->asArray()->one(); 
                        if ($menu_msg&&!BanquetMenu::find()->where('shop_id='.$this->shop_usermsg['shop_id'].' and dish_id='.$value.' and banquet_id='.$_POST['banquet_id'].'')->count()) {
                            $model = new BanquetMenu();
                            $model->dish_id = $menu_msg['dish_id'];
                            $model->menu_name = $menu_msg['dish_name'];
                            $model->menu_price = $menu_msg['dish_price'];
                            $model->menu_quantity = 1;
                            $model->create_time = time();
                            $model->banquet_id = $_POST['banquet_id'];
                            $model->shop_id = $this->shop_usermsg['shop_id'];
                            $model->update_time = time();
                            $result_sta = $model->insert(false);
                            if ($result_sta) {
                                $result = $result_sta;
                            }
                        }
                        
                    }
                    if ($result) {
                        $menu_money = BanquetMenu::find()->select('menu_quantity,menu_price')->where('shop_id='.$this->shop_usermsg['shop_id'].' and banquet_id='.$_POST['banquet_id'].'')->all();
                        $banquet_amount=0;
                        if (is_array($menu_money)) {
                            foreach ($menu_money as $value) {
                                $banquet_amount+=$value['menu_quantity']*$value['menu_price'];
                            }
                        }
                        
                        ShopBanquet::updateAll(['banquet_amount'=>$banquet_amount]
                                    , [
                                        'banquet_id' => $_POST['banquet_id'],
                                        'shop_id' => $this->shop_usermsg['shop_id']
                                    ]);
                    }
                }

                return $this->redirect(array('/shop/flowingseat/update?banquet_id='.$_POST['banquet_id'].''));
            }
            $Menu_id_list = BanquetMenu::find()->select('dish_id')->where('shop_id='.$this->shop_usermsg['shop_id'].' and banquet_id='.$_GET['banquet_id'].'')->asArray()->all();
            $Menu_id_array = array();
            foreach ($Menu_id_list as  $mil) {
                $Menu_id_array[] = $mil['dish_id'];
            }
            $list = ShopMenu::find()->where('shop_id='.$this->shop_usermsg['shop_id'].'')->orderBy('create_time desc')->asArray()->all();

            $params['list'] = $list;
            $params['banquet_id'] = $_GET['banquet_id'];
            $params['Menu_id_array'] = $Menu_id_array;
            return $this->render('add.tpl',$params);
        }
    }
    //添加流水席
     public function actionAddmain (){
         if(\Yii::$app->request->isPost){
            $shop_time = Shop::find()->select('opening_hour,closing_hour')->where('shop_id='.$this->shop_usermsg['shop_id'].'')->asArray()->one();
            if (date($_POST['begin_time'])<date($shop_time['opening_hour'])||date($_POST['end_time'])>date($shop_time['closing_hour'])) {
                echo "<script>alert('流水席开席时间不能小于开始营业时间，结束时间不能大于歇业时间');window.location.href='addmain';</script>";
                die();
                // var_dump('流水席开席时间不能小于开始营业时间，结束时间不能大于歇业时间');die();
            }
            $model = new ShopBanquet();
            $img = Upload::UploadPhoto($model,'uploads/shop_header/','file');
            $img = str_replace('uploads/','',$img);
            $model->banquet_name = $_POST['banquet_name'];
            $model->type_id = $_POST['type_id'];
            $model->banquet_serial = 'F'.date('YmdHi').rand(100,999);
            $model->price = $_POST['price'];
            $model->total_peoples = $_POST['total_peoples'];
            $model->shop_id = $this->shop_usermsg['shop_id'];
            $model->banquet_amount = $_POST['banquet_amount'];
            $model->banquet_status = 1;
            $model->banquet_number = $_POST['banquet_number'];
            $model->banquet_url = $img;
            $model->begin_time = $_POST['begin_time'];
            $model->end_time = $_POST['end_time'];
            $model->create_time = time();
            $model->update_time = time();
            $result = $model->insert(false);
            if ($_POST['menu_quantity']&&$_POST['dish_id']&&$result&&$model['banquet_id']) {
                foreach ($_POST['menu_quantity'] as $key => $value) {
                    $model_menu = new BanquetMenu();
                    $shop_menu_msg = ShopMenu::find()->select('dish_name,dish_price')->where('dish_id='.$_POST['dish_id'][$key].' and shop_id='.$this->shop_usermsg['shop_id'].'')->asArray()->one();
                    $model_menu->dish_id = $_POST['dish_id'][$key];
                    $model_menu->menu_name = $shop_menu_msg['dish_name'];
                    $model_menu->menu_price = $shop_menu_msg['dish_price'];
                    $model_menu->menu_quantity = $_POST['menu_quantity'][$key];
                    $model_menu->shop_id = $this->shop_usermsg['shop_id'];
                    $model_menu->banquet_id = $model['banquet_id'];
                    $model_menu->create_time = time();
                    $model_menu->update_time = time();
                    $model_menu = $model_menu->insert(false);
                }
            }
            if ($result) {
                 return $this->redirect(array('/shop/flowingseat/index'));
            }else{
                echo "<script>alert('添加失败');window.location.href='addmain';</script>";
                die();
            }

         }
        $type_list = BanquetType::find()->where('1=1')->asArray()->all();
        $Menu_id_list = ShopMenu::find()->where('shop_id='.$this->shop_usermsg['shop_id'].'')->asArray()->all();
        $shop_time = Shop::find()->select('opening_hour,closing_hour')->where('shop_id='.$this->shop_usermsg['shop_id'].'')->asArray()->one();
        //if (!$type_list) {
        //    echo "<script>alert('请先添加流水席类型');window.location.href='addmain'</script>";
        //    die();
        //}
        if (!$Menu_id_list) {
            echo "<script>alert('请先添加菜品');window.location.href='/shop/variety/index';</script>";
            die();
        }
        if (!$shop_time) {
            echo "<script>alert('请先添加营业时间');window.location.href='/shop/sellermsg/index';</script>";
            die();
        }
        $params['type_list'] = $type_list;
        $params['Menu_id_list'] = $Menu_id_list;
        $params['list'] = '';
        $params['shop_time'] = $shop_time;
        return $this->render('addmain.tpl',$params);
    }
    //删除流水席
    public function actionDelete_bquet (){
        if ($_GET['banquet_id']&&$this->shop_usermsg['shop_id']) {
            $order_status = BanquetOrder::find()->where('(order_status=0 or order_status=1) and banquet_id='.$_GET['banquet_id'].'')->count();
            if ($order_status) {
                echo "<script>alert('删除失败,该流水席还有未完成订单');window.location.href='/shop/flowingseat/update?banquet_id=".$_GET['banquet_id']."';</script>";
                die();
                // var_dump('删除失败,该流水席还有未完成订单');die;
            }
            $num = ShopBanquet::deleteAll([
                                'shop_id' => $this->shop_usermsg['shop_id'],
                                'banquet_id' => $_GET['banquet_id']
                            ]);
            BanquetMenu::deleteAll([
                                'shop_id' => $this->shop_usermsg['shop_id'],
                                'banquet_id' => $_GET['banquet_id']
                            ]);
            if ($num) {
                return $this->redirect(array('/shop/flowingseat/index'));
            }else{
                echo "<script>alert('删除失败');window.location.href='/shop/flowingseat/update?banquet_id=".$_GET['banquet_id']."';</script>";
                die();
            }
        }
        // }
    }
    //删除流水席菜品 流水席id banquet_id  流水席菜品id menu_id
    public function actionDelete (){
        if($this->shop_usermsg['shop_id']) {
            if(\Yii::$app->request->isAjax&&$_POST['banquet_id']&&$_POST['menu_id']){
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $sb_msg =  ShopBanquet::find()->select('banquet_status')->where('shop_id='.$this->shop_usermsg['shop_id'].' and banquet_id='.$_POST['banquet_id'].'')->asArray()->one();
                if ($sb_msg['banquet_status']==1){
                    return ['status'=>0,'msg'=>'该流水席使用中，要停止流水席才能删除'];
                }
                $menu_num = BanquetMenu::find()->where('shop_id='.$this->shop_usermsg['shop_id'].' and banquet_id='.$_POST['banquet_id'].'')->count();
                if ($menu_num<2){
                    return ['status'=>0,'msg'=>'该流水席至少保留一个菜品！'];
                }
                $result = BanquetMenu::deleteAll([
                    'menu_id' => $_POST['menu_id']
                ]);
                if ($result) {
                    $menu_money = BanquetMenu::find()->select('menu_quantity,menu_price')->where('shop_id='.$this->shop_usermsg['shop_id'].' and banquet_id='.$_POST['banquet_id'].'')->all();
                    $banquet_amount=0;
                    if (is_array($menu_money)) {
                        foreach ($menu_money as $value) {
                            $banquet_amount+=$value['menu_quantity']*$value['menu_price'];
                        }
                    }
                    
                    ShopBanquet::updateAll(['banquet_amount'=>$banquet_amount]
                                , [
                                    'banquet_id' => $_POST['banquet_id'],
                                    'shop_id' => $this->shop_usermsg['shop_id']
                                ]);
                    return ['status'=>1,'msg'=>'删除成功'];
                }else{
                    return ['status'=>0,'msg'=>'删除失败'];
                }
                
            }
            if(\Yii::$app->request->isPost&&$_POST['banquet_id']&&$_POST['menu_id']){
                if (is_array($_POST['menu_id'])) {
                    $re_msg=0;
                    foreach ($_POST['menu_id'] as $key => $value) {
                        if (BanquetMenu::find()->where('shop_id='.$this->shop_usermsg['shop_id'].' and  banquet_id='.$_POST['banquet_id'].'')->count()>count($_POST['menu_id'])) {
                            $re_sta = BanquetMenu::deleteAll([
                                'menu_id' => $value
                            ]);
                            if ($re_sta) {
                                $re_msg=$re_sta;
                            }

                        }else{
                            echo "<script>alert('该流水席的菜品至少要比删除的菜品数量大1，不能删除！流水席至少要保留一个菜品.');window.location.href='/shop/flowingseat/delete?banquet_id=".$_POST['banquet_id']."';</script>";
                            die();
                        }
                        
                    }
                    if ($re_msg) {
                        $menu_money = BanquetMenu::find()->select('menu_quantity,menu_price')->where('shop_id='.$this->shop_usermsg['shop_id'].' and banquet_id='.$_POST['banquet_id'].'')->all();
                        $banquet_amount=0;
                        if (is_array($menu_money)) {
                            foreach ($menu_money as $value) {
                                $banquet_amount+=$value['menu_quantity']*$value['menu_price'];
                            }
                        }
                        
                        ShopBanquet::updateAll(['banquet_amount'=>$banquet_amount]
                                    , [
                                        'banquet_id' => $_POST['banquet_id'],
                                        'shop_id' => $this->shop_usermsg['shop_id']
                                    ]);
                    }
                }
                return $this->redirect(array('/shop/flowingseat/update?banquet_id='.$_POST['banquet_id'].''));
            }
            $list = BanquetMenu::find()->where('shop_id='.$this->shop_usermsg['shop_id'].' and banquet_id='.$_GET['banquet_id'].'')->asArray()->all();
            $params['list'] = $list;
            $params['banquet_id'] = $_GET['banquet_id'];
            return $this->render('delete.tpl',$params);
        }
    }
    //修改流水席
    public function actionUpdate (){
         if(\Yii::$app->request->isAjax&&$_POST['banquet_id']){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            // $status_shop = ShopBanquet::find()->select('banquet_status')->where('shop_id='.$this->shop_usermsg['shop_id'].' and banquet_id='.$_POST['banquet_id'].'')->asArray()->one();
            // if ($status_shop['banquet_status']) {
            //     return ['status'=>-1,'msg'=>'流水席开席中，要停席才能修改信息'];
            //     var_dump('流水席开席中，要停席才能修改信息');die;
            // }
            $_POST['num']<1?$num=0:$num=1;
            $num_msg = ShopBanquet::updateAll([
                                    'banquet_status' => $num
                                ], [
                                    'banquet_id' => $_POST['banquet_id'],
                                    'shop_id' => $this->shop_usermsg['shop_id']
                                ]);
            if ($num_msg) {
                if (!$num) {
                    $user_order = UserOrder::find()->select('record_id')->where('order_status=0 and pay_status=1 and banquet_id='.$_POST['banquet_id'].' and shop_id='.$this->shop_usermsg['shop_id'].'')->asArray()->all();
                    foreach ($user_order as $vuo) {
                        BackOrder::toRefund($vuo['record_id']);
                    }
                    BanquetOrder::updateAll([
                                    'order_status' => 2
                                ], [
                                    'banquet_id' => $_POST['banquet_id'],
                                    'order_status' => 0
                                ]);
                }
                $result=['status'=>1];
            }else{
                $result=['status'=>0];
            }
            return $result;
         }
         if($this->shop_usermsg['shop_id']&&$_GET['banquet_id']) {
            $query = new Query();
            $query->select('sb.banquet_id,sb.banquet_status,sb.banquet_url,sb.banquet_name,sb.price,sb.total_peoples,sb.banquet_amount,sb.banquet_number,sb.begin_time,sb.end_time,bt.type_name,sb.type_id');
            $query->from(ShopBanquet::tableName() . ' sb');
            $query->leftJoin(BanquetType::tableName() . ' bt', 'sb.type_id = bt.type_id');
            // $query->leftJoin(BanquetMenu::tableName() . ' bm', 'sb.shop_id = bm.shop_id');

            $query->where([
                'sb.banquet_id' => $_GET['banquet_id'],
                'sb.shop_id' => $this->shop_usermsg['shop_id']
            ]);

            $list_msg = $query->one();

            $menu_list = BanquetMenu::find()->where('shop_id='.$this->shop_usermsg['shop_id'].' and banquet_id='.$_GET['banquet_id'].'')->asArray()->all();
             
         }
         $shop_time = Shop::find()->select('opening_hour,closing_hour')->where('shop_id='.$this->shop_usermsg['shop_id'].'')->asArray()->one();
        $params['list_msg'] = $list_msg;
        $params['menu_list'] = $menu_list;
        $params['banquet_id'] = $_GET['banquet_id'];
        $params['shop_time'] = $shop_time;
        return $this->render('update.tpl',$params);
    }

    //保存修改流水席的数据
     public function actionSave_main (){
         if(\Yii::$app->request->isPost){
            $look_status = 0;
            $is_have = BanquetOrder::find()->where('banquet_id='.$_POST['banquet_id'].' and  (order_status=0 or order_status=1)')->count();
            if ($is_have) {
                echo "<script>alert('该流水席还有待完成的订单，暂无法修改');window.location.href='/shop/flowingseat/update?banquet_id=".$_POST['banquet_id']."';</script>";
                die();
                // var_dump('该流水席还有待完成的订单，暂无法修改');die;
            }
            $shop_time = Shop::find()->select('opening_hour,closing_hour')->where('shop_id='.$this->shop_usermsg['shop_id'].'')->asArray()->one();
            if (date($_POST['begin_time'])<date($shop_time['opening_hour'])||date($_POST['end_time'])>date($shop_time['closing_hour'])) {
                echo "<script>alert('流水席开席时间不能小于开始营业时间，结束时间不能大于歇业时间');window.location.href='/shop/flowingseat/update?banquet_id=".$_POST['banquet_id']."';</script>";
                die();
                // var_dump('流水席开席时间不能小于开始营业时间，结束时间不能大于歇业时间');die();
            }
            if ($_POST['menu_quantity']&&$_POST['menu_id']) {

                foreach ($_POST['menu_quantity'] as $key => $value) {
                    $status_msg = BanquetMenu::updateAll([
                                    'menu_quantity' => $value
                                ], [
                                    'menu_id' =>$_POST['menu_id'][$key]
                                ]);
                    if ($status_msg) {
                        $look_status = 1;
                    }
                }
            }
            $banquet_amount=0;
            $bm_list = BanquetMenu::find()->select('menu_quantity,menu_price')->where('shop_id='.$this->shop_usermsg['shop_id'].' and banquet_id='.$_POST['banquet_id'].'')->asArray()->all();
            if ($bm_list) {
                foreach ($bm_list as $vb) {
                    $banquet_amount+=$vb['menu_quantity']*$vb['menu_price'];
                }
            }   
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             // file
            $array_msg = ['banquet_name' => $_POST['banquet_name'],
                                    'price' => $_POST['price'],
                                    'total_peoples' => $_POST['total_peoples'],
                                    'banquet_amount' => $banquet_amount?$banquet_amount:0,
                                    'banquet_number' => $_POST['banquet_number'],
                                    'begin_time' => $_POST['begin_time'],
                                    'end_time' => $_POST['end_time'],
                                    'update_time' => time()];
            $files = UploadedFile::getInstanceByName('file');
            if ($files) {
                $model = new ShopBanquet();
                $img = Upload::UploadPhoto($model,'uploads/shop_header/','file');
                $img = str_replace('uploads/','',$img);
                $array_msg['banquet_url']= $img;
            }
            $num_msg = ShopBanquet::updateAll($array_msg
                                , [
                                    'banquet_id' => $_POST['banquet_id'],
                                    'shop_id' => $this->shop_usermsg['shop_id']
                                ]);
            if ($num_msg||$look_status) {
                return $this->redirect(array('/shop/flowingseat/index'));
            }else{
                echo "<script>alert('修改失败');window.location.href='/shop/flowingseat/update?banquet_id=".$_POST['banquet_id']."';</script>";
                die();
            }
        }
    }
    //查看流水席详情
    public function actionDetail (){
         if($this->shop_usermsg['shop_id']&&$_GET['banquet_id']) {
            $query = new Query();
            $query->select('sb.banquet_id,sb.banquet_status,sb.banquet_url,sb.banquet_name,sb.price,sb.total_peoples,sb.banquet_amount,sb.banquet_number,sb.begin_time,sb.end_time,bt.type_name,sb.type_id');
            $query->from(ShopBanquet::tableName() . ' sb');
            $query->leftJoin(BanquetType::tableName() . ' bt', 'sb.type_id = bt.type_id');

            $query->where([
                'sb.banquet_id' => $_GET['banquet_id'],
                'sb.shop_id' => $this->shop_usermsg['shop_id']
            ]);

            $list_msg = $query->one();
            $menu_list = BanquetMenu::find()->where('shop_id='.$this->shop_usermsg['shop_id'].' and banquet_id='.$_GET['banquet_id'].'')->asArray()->all();
             
         }
        $params['list_msg'] = $list_msg;
        $params['menu_list'] = $menu_list;
        return $this->render('detail.tpl',$params);
    }
    //流水席选择分类
    public function actionClass (){

        if(\Yii::$app->request->isPost) 
        {
            if($_POST['banquet_id']&&$_POST['type']&& $this->shop_usermsg['shop_id']) {
                $result = ShopBanquet::updateAll([
                                    'type_id' => $_POST['type']
                                ], [
                                    'banquet_id' => $_POST['banquet_id'],
                                    'shop_id' => $this->shop_usermsg['shop_id']
                                ]);
                return $this->redirect(array('/shop/flowingseat/update?banquet_id='.$_POST['banquet_id'].''));
            }
        }
        $type_list = BanquetType::find()->where('1=1')->asArray()->all();
        $params['type_list'] = $type_list;
        $params['type_msg'] = $_GET['type_id'];
        $params['banquet_id'] = $_GET['banquet_id'];

        return $this->render('class.tpl',$params);
    }

}