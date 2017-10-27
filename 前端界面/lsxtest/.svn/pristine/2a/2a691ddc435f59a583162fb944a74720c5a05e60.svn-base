<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 9:27
 */
namespace app\modules\goods\controllers;

use common\models\BanquetMenu;
use common\models\BanquetOrder;
use common\models\LeaveMessage;
use common\models\ShopBanquet;
use common\models\User;
use common\website\JSSDK;
use frontend\controllers\DefaultController;
use yii\base\UserException;
use yii\web\Controller;

class GoodsController extends DefaultController{

    public $layout = 'main.tpl';

    public function __construct ($id, $module, $config = [])
    {
        $module = \Yii::$app->getModule('goods');
        parent::__construct($id, $module, $config);
    }

    public function actionIndex (){
        var_dump(getDistance(129,125,128,122));
    }

    /*
     *流水席详情页面
     * @id banquet_id
     * @shop_id shop_id
     */
    public function actionInfo ()
    {
        $banquet_id = \Yii::$app->request->get('id','');
        $shop_id = \Yii::$app->request->get('shop_id','');

        /**
         * 分享入席的相关功能
         */
        $type = \Yii::$app->request->get('type','');
        if (!empty($type) && $type = 'share') {
            $sign = \Yii::$app->request->get('sign','');
            if (empty($sign)) {
                throw new UserException('非法操作！');
            }
            $params = [];
            $order_id = \Yii::$app->request->get('order_id','');
            $params['seat_details'] = BanquetOrder::getOneorder2($order_id,$banquet_id);//取得当前分享的席单信息
            if ($params['seat_details']['joined_peoples'] <=0) {
                throw new UserException('该席桌已关闭！');
            }

            $is_user =$params['seat_details']['reservation_people'];
            if (makeSignature(['is_user' =>$is_user],'cqzgkjlsx') !== $sign) {
                throw new UserException('非法操作！');
            }
            if (empty($order_id) || empty($banquet_id) || empty($shop_id)) {
                throw new UserException('非法操作！');
            }

            $params['lsx_info'] = ShopBanquet::geyLsxinfo($banquet_id,$shop_id);        //流水席相关信息
            $params['order_info'] = BanquetOrder::getOrderinfo($banquet_id ,$shop_id);   //席单相关信息，未排序
            //区分今天和明天的席单
            $count_today = 0;
            $count_tomorrow = 0;
            foreach ($params['order_info'] as $order_info)
            {
                if(date('Ymd',gmtime()) == date('Ymd',$order_info['banquet_time'])){  //今天的订单
                    $count_today ++ ;
                }else{
                    $count_tomorrow ++ ;
                }
            }
            //处理已完成的订单
            $yiwanchen = BanquetOrder::find()->where('banquet_id ='.$banquet_id.' and (order_status = 1 or order_status = 3)')->asArray()->all();
            foreach ($yiwanchen as $val)
            {
                if(date('Ymd',$val['banquet_time']) == date('Ymd',gmtime()))
                {
                    $count_today ++;
                }
            }

            $params['lsx_info']['left_number'] = $params['lsx_info']['banquet_number'] - $count_today;
            $params['lsx_info']['left_number_2'] = $params['lsx_info']['banquet_number'] - $count_tomorrow;
            $params['banquet_menu'] = BanquetMenu::getMenu($banquet_id);

            /*微信分享代码块*/
            $weixinconfig['appid'] = \Yii::$app->params['UserWechat']['app_id'];
            $weixinconfig['appsecret'] = \Yii::$app->params['UserWechat']['secret'];
            $jssdk = new JSSDK($weixinconfig['appid'], $weixinconfig['appsecret']);
            $signPackage = $jssdk->GetSignPackage();
            $params['signPackage'] = $signPackage;
            if ($params['seat_details']['is_display'] == 0) {
                $params['sign'] = $sign;
            }
            return $this->render('lsx_info_share.tpl',$params);
        }
        /**
         * 分享结束
         */

        if(empty($banquet_id) || empty($shop_id)){
            throw new UserException('参数错误！');
        }
        $params = [];
        $params['lsx_info'] = ShopBanquet::geyLsxinfo($banquet_id,$shop_id);        //流水席相关信息
        $params['order_info'] = BanquetOrder::getOrderinfo($banquet_id ,$shop_id);   //席单相关信息，未排序
//        var_dump($params['order_info']);die;
        //区分今天和明天的席单
        $count_today = 0;
        $count_tomorrow = 0;
        foreach ($params['order_info'] as $order_info)
        {
            if(date('Ymd',gmtime()) == date('Ymd',$order_info['banquet_time'])){  //今天的订单
                $count_today ++ ;
            }else{
                $count_tomorrow ++ ;
            }
        }
        $yiwanchen = BanquetOrder::find()->where('banquet_id ='.$banquet_id.' and (order_status = 1 or order_status = 3)')->asArray()->all();
        foreach ($yiwanchen as $val)
        {
            if(date('Ymd',$val['banquet_time']) == date('Ymd',gmtime()))
            {
                $count_today ++;
            }
        }
//        $count_today += count($yiwanchen);
        $params['lsx_info']['left_number'] = $params['lsx_info']['banquet_number'] - $count_today;
        $params['lsx_info']['left_number_2'] = $params['lsx_info']['banquet_number'] - $count_tomorrow;
        $params['banquet_menu'] = BanquetMenu::getMenu($banquet_id);

        /*微信分享代码块*/
        $weixinconfig['appid'] = \Yii::$app->params['UserWechat']['app_id'];
        $weixinconfig['appsecret'] = \Yii::$app->params['UserWechat']['secret'];
        $jssdk = new JSSDK($weixinconfig['appid'], $weixinconfig['appsecret']);
        $signPackage = $jssdk->GetSignPackage();
        $params['signPackage'] = $signPackage;
        return $this->render('lsx_info.tpl',$params);
    }

    public function actionBuy (){

    }

    /**
     * @return string
     * @throws UserException
     * 流水席评价
     */
    public function actionComment ()
    {
        $banquet_id = \Yii::$app->request->get('banquet_id','');
        if (empty($banquet_id)) {
            throw new UserException('非法操作！');
        }
        if (\Yii::$app->request->isAjax) {
            $banquet_id = \Yii::$app->request->get('banquet_id','');
            $page = \Yii::$app->request->get('page','');
            if (empty($banquet_id)) {
                echo json_encode([
                    'code' => 0,
                    'message' => '评论加载失败'
                ]);exit();
            }
            $commentInfo = LeaveMessage::getComment($banquet_id,$page);
            echo json_encode([
                'code' => 1,
                'data' => $commentInfo
            ]);exit();
        }
        $params['commentInfo'] = LeaveMessage::getComment($banquet_id);
//        var_dump($params['commentInfo']);die();
        $params['count'] = LeaveMessage::getCountNumber($banquet_id);
        $params['banquet_id'] = $banquet_id;
        return $this->render('lsx_comment.tpl',$params);
    }
}