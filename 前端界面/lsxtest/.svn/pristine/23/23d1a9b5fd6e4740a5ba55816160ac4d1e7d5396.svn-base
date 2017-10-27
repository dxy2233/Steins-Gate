<?php
/**
 * Created by PhpStorm.
 * User: Ysl
 * Date: 2017/9/14
 * 个人中心控制器
 */
namespace app\modules\user\controllers;

use common\models\TicketDetail;
use common\models\User;
use frontend\controllers\DefaultController;
use yii\base\UserException;
use yii\web\Controller;

header("Content-type:text/html;charset=utf-8");

class TicketController extends DefaultController{

//    public $layout = 'main.tpl';

    /*
     * 饭票首页
     */
    public function actionIndex()
    {
        $user_id = \Yii::$app->getSession()->get('user_id');
        if(!$user_id)
        {
            throw new UserException('用户不存在！');
        }
        $params = [];
        $params['user_info'] = User::getUserInfo($user_id);
        $params['ticket'] = TicketDetail::getTicketList($user_id);
//        $params['ticket_total'] =
        foreach ($params['ticket'] as &$item)
        {
            $item['caeate_time'] = date('m-d H:i',$item['caeate_time']);
        }
//        var_dump($params);die;
        return $this->render('ticket_list.tpl',$params);
    }

}