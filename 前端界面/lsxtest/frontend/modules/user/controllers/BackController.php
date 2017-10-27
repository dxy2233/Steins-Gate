<?php
/**
 * Created by PhpStorm.
 * User: Ysl
 * Date: 2017/9/14
 * 订单退款 控制器
 */
namespace app\modules\user\controllers;

use common\models\BackOrder;
use frontend\controllers\DefaultController;
use yii\web\Controller;
error_reporting(0);

class BackController extends DefaultController {

//    public $layout = 'main.tpl';

    public $enableCsrfValidation=false;

    public function actionIndex()
    {
        $record_id = \Yii::$app->request->get('record_id','');
        if(\Yii::$app->request->isAjax)
        {
            $response = \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $result = BackOrder::toRefund(\Yii::$app->request->post('record_id',''));
            if($result){
                return [
                    'code' => 1,
                    'message' => '提交成功'
                ];
            }else{
                return [
                    'code' => 0,
                    'message' => '提交失败'
                ];
            }

        }
        return $this->render('reason.tpl',[
            'record_id'=>$record_id
        ]);
//        BackOrder::toRefund($record_id);

    }

}