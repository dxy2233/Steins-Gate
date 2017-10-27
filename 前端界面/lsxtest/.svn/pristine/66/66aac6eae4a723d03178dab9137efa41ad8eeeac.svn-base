<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 9:27
 */
namespace app\modules\order\controllers;

use common\base\UserException;
use common\models\BanquetOrder;
use common\models\LeaveMessage;
use common\models\ShopBanquet;
use common\models\User;
use common\models\UserOrder;
use common\website\JSSDK;
use frontend\controllers\DefaultController;
use yii\web\Controller;

class OrderController extends DefaultController{

//    public $layout = 'main.tpl';
    public $enableCsrfValidation=false;

    public function actionOrderList (){
        $status = \Yii::$app->request->get('status','');
        $user_id = \Yii::$app->getSession()->get('user_id');
        $params = [];
        $params['status'] = $status;
        $params['list'] = UserOrder::getList($status ,$user_id ,1);

        foreach($params['list'] as  &$item)
        {
            $item['banquet_time'] = date('m-d H:i:s', $item['banquet_time']);
        }
        $params['page'] = 1;

        if(\Yii::$app->request->isAjax){
            $current_page =  \Yii::$app->request->post('page',0);
            $next_page = intval($current_page) + 1;
            $append_list = UserOrder::getList($status ,$user_id ,$next_page);
            foreach($append_list as  &$item)
            {
                $item['banquet_time'] = date('m-d H:i:s', $item['banquet_time']);
            }
            $response = \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'list' => $append_list
            ];
        }
        return $this->render('order_list.tpl',$params);
    }

    /*
     * 订单详情
     */
    public function actionOrderInfo()
    {
        $this->layout = 'empty.tpl';
        $record_id=\Yii::$app->request->get('rid');
        if (empty($record_id)) {
            throw new UserException('非法操作!');
        }
        //获取订单详情的相关信息
        $userOrderInfo=UserOrder::getUserOrderInfo($record_id);
        if (empty($userOrderInfo)) {
            throw new UserException('没有相关席单信息!');
        }
        //获取所有拼席的用户信息
        $UserAggregate=UserOrder::getUserByOrder($userOrderInfo['order_id']);
        $params = [
            'userOrderInfo' => $userOrderInfo,
            'UserAggregate' => $UserAggregate,
        ];

        /*微信分享代码块*/
        $weixinconfig['appid'] = \Yii::$app->params['UserWechat']['app_id'];
        $weixinconfig['appsecret'] = \Yii::$app->params['UserWechat']['secret'];
        $jssdk = new JSSDK($weixinconfig['appid'], $weixinconfig['appsecret']);
        $signPackage = $jssdk->GetSignPackage();
        $params['signPackage'] = $signPackage;
        $is_user =$userOrderInfo['reservation_people'];
        $sign =makeSignature(['is_user'=>$is_user],'cqzgkjlsx');
        $share = homeurl()."/goods/goods/info?id={$userOrderInfo['banquet_id']}&shop_id={$userOrderInfo['shop_id']}&order_id={$userOrderInfo['order_id']}&sign={$sign}&type=share";
        $params['share'] = $share;
        $params['is_show_display'] = \Yii::$app->session->get('user_id') == $userOrderInfo['reservation_people'] ? 1 : 0;
        if ($userOrderInfo['is_display'] == 0) {
            $params['sign'] = $sign;
        }
        return $this->render('order_info.tpl',$params);
    }

    /**
     * @return string|\yii\web\Response
     * 评价添加
     *
     */
    public function actionOrderComment()
    {
        $this->layout = 'empty.tpl';
        if (!\Yii::$app->request->isGet) {
            if (!\Yii::$app->request->isAjax) {
                echo json_encode(array('code'=>0,'message'=>'非法请求!'));
                exit;
            }
            $tr = \Yii::$app->db->beginTransaction();
            $data=\Yii::$app->request->post();

            $userOrderInfo=UserOrder::find()->where(['record_id'=>$data['record_id']])->one();
            if ($userOrderInfo->is_comment == 1) {
                $tr->rollBack();
                return json_encode([
                    'code' => -1,
                    'message' => '订单已评价过！',
                ]);
            }

            $leaveMessageModel=new LeaveMessage();
            $leaveMessageModel->banquet_id=$userOrderInfo->banquet_id;
            $leaveMessageModel->order_id=$userOrderInfo->order_id;
            $leaveMessageModel->service_score=$data['service_score'];
            $leaveMessageModel->message_detail=$data['message_detail'];
            $leaveMessageModel->user_id=\Yii::$app->getSession()->get('user_id');
            $leaveMessageModel->message_time=gmtime();

            $userOrderInfo->is_comment=1;
            $userOrderInfo->comment_time=gmtime();

            $shopBanquetInfo = ShopBanquet::find()->where(['banquet_id' => $userOrderInfo->banquet_id])->one();
            $shopBanquetInfo->score_peoples +=1;
            $score = floatval(LeaveMessage::getCountScore($userOrderInfo->banquet_id)) + floatval($data['service_score']);
            $shopBanquetInfo->service_score =number_format($score/floatval($shopBanquetInfo->score_peoples),2);
            if ($leaveMessageModel->insert(true ) === false || $userOrderInfo->save(false)===false || $shopBanquetInfo->save(false) === false) {
                $tr->rollBack();
                return json_encode([
                    'code' => -1,
                    'message' => '评论失败，请重试！',
                    'data' =>$leaveMessageModel->getErrors()
                ]);
            }
            $tr->commit();
            return json_encode([
                'code' => 1,
                'message' => '评论成功！',
            ]);
        }
        $data=\Yii::$app->request->get();
        $userOrderInfo=UserOrder::find()->where(['record_id'=>$data['rid']])->one();
        if ($userOrderInfo->is_comment == 1) {
            return $this->redirect('/order/order/order-list');
        }
        return $this->render('order_comment.tpl',['record_id'=>$data['rid']]);
    }

    /**
     * @return string
     * 评价成功
     */
    public function actionCommentSuccess()
    {
        $this->layout = 'empty.tpl';
        return $this->render('comment_success.tpl');
    }

    /**
     * 更改私密公开
     */
    public function actionSetIsdisplay(){
        if (!\Yii::$app->request->isAjax) {
            echo json_encode(['code' => 0,'message' => '非法操作']);exit();
        }
        $order_id = \Yii::$app->request->get('order_id','');
        $is_display = \Yii::$app->request->get('is_display','');
        if (empty($order_id)) {
            echo json_encode(['code' => 0,'message' => '非法操作!']);exit();
        }
        $banquetOrderModel = BanquetOrder::find()->where(['order_id' => $order_id])->one();

        $banquetOrderModel->is_display = intval($is_display);
        if ($banquetOrderModel->save(false) === false) {
            echo json_encode(['code' => 0,'message' => '更新失败!']);exit();
        }
        echo json_encode(['code' => 1,'message' => '设置成功!']);exit();
    }

    public function actionSetIsShare () {
        if (!\Yii::$app->request->isAjax) {
            echo json_encode(['code' => 0,'message' => '非法操作']);exit();
        }
        $record_id = \Yii::$app->request->get('record_id','');
        if (empty($record_id)) {
            echo json_encode(['code' => 0,'message' => '缺少必须字段!']);exit();
        }
        $userOrderModel = UserOrder::find()->where(['record_id'=>$record_id])->one();
        if (empty($userOrderModel)) {
            echo json_encode(['code' => 0,'message' => '不存在该订单!']);exit();
        }
        if ($userOrderModel->is_share ==0) {
            $userOrderModel->is_share = 1;
            if ($userOrderModel->save(false) !== false) {
                echo json_encode(['code' => 1,'message' => '分享成功']);exit();
            }
        }
        echo json_encode(['code' => 0,'message' => '分享错误']);exit();
    }
}