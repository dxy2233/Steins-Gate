<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 9:27
 * 统计中心
 */
namespace app\modules\Statistics\controllers;


use common\models\BanquetOrder;
use common\models\UserOrder;
use yii\db\Query;
use yii\web\Controller;

class StatisticscenterController extends Controller
    {
    public $enableCsrfValidation = false;
    //获取初始用户信息
    public $shop_usermsg;
    public function init ()
    {
        $init_class = new \seller\controllers\InitController();
        $init_class->actionClassName();
        $session = \Yii::$app->session;
        $this->shop_usermsg = $session->get('seller_msg');
    }
    //统计中心首页
    public function actionIndex (){
        if($this->shop_usermsg['shop_id']){
            $banquet_msg_list = BanquetOrder::find()->select('order_price,joined_peoples')->where('shop_id='.$this->shop_usermsg['shop_id'].' and order_status=3')->asArray()->groupBy('order_id')->all();
            $statistics[1] = UserOrder::find()->where('shop_id='.$this->shop_usermsg['shop_id'].' and order_status=3')->groupBy('user_id')->asArray()->groupBy('banquet_id')->count();

             $statistics[0]['total_moeny'] = 0;
             $statistics[0]['total_order'] = 0;
             if($banquet_msg_list) {
                foreach ($banquet_msg_list as $value) {
                    $statistics[0]['total_moeny']+=($value['order_price']*$value['joined_peoples']);
                }
                $statistics[0]['total_moeny'] = sprintf("%.2f", substr(sprintf("%.3f", floatval($statistics[0]['total_moeny'])), 0, -1));
                $statistics[0]['total_order'] = count($banquet_msg_list);
             }
        }
        $params['statistics'] = $statistics;
        return $this->render('index.tpl',$params);
    }
    //查询时间段内的统计数据
    public function actionFindmsg (){
        if(\Yii::$app->request->isPost&&$_POST['star_time']&&$_POST['end_time']&&$this->shop_usermsg['shop_id']) 
        {
            $star_time = strtotime($_POST['star_time']);
            $end_time = strtotime($_POST['end_time']);
            $banquet_msg_list = BanquetOrder::find()->select('order_price,joined_peoples')->where('shop_id='.$this->shop_usermsg['shop_id'].' and order_status=3 and create_time>'.$star_time.' and create_time<'.$end_time.'')->asArray()->groupBy('order_id')->all();
            $statistics[1] = UserOrder::find()->where('shop_id='.$this->shop_usermsg['shop_id'].' and order_status=3 and pay_time>'.$star_time.' and pay_time<'.$end_time.'')->groupBy('user_id')->asArray()->groupBy('banquet_id')->count();
            $statistics[0]['total_moeny'] = 0;
             $statistics[0]['total_order'] = 0;
             if($banquet_msg_list) {
                foreach ($banquet_msg_list as $value) {
                    $statistics[0]['total_moeny']+=$value['order_price']*$value['joined_peoples'];
                }
                $statistics[0]['total_moeny'] = sprintf("%.2f", substr(sprintf("%.3f", floatval($statistics[0]['total_moeny'])), 0, -1));
                $statistics[0]['total_order'] = count($banquet_msg_list);
             }
        }
        $params['statistics'] = $statistics;
        $params['star_time'] = $star_time;
        $params['end_time'] = $end_time;
        return $this->render('findmsg.tpl',$params);
    }

}