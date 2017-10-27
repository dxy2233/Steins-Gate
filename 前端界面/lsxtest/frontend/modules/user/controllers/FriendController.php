<?php
/**
 * Created by PhpStorm.
 * User: Ysl
 * Date: 2017/9/14
 * 个人中心控制器
 */
namespace app\modules\user\controllers;

use common\models\User;
use frontend\controllers\DefaultController;
use yii\base\UserException;
use yii\web\Controller;

header("Content-type:text/html;charset=utf-8");

class FriendController extends DefaultController{

    /*
     *我的饭友首页
     */
    public function actionList ()
    {
        $user_id = \Yii::$app->getSession()->get('user_id');
        if(!$user_id)
        {
            throw new UserException('用户不存在！');
        }
        $params = [];

        $params['friend_list'] = User::getfriends($user_id ,1);
        $params['page'] = 1;
        if(\Yii::$app->request->isAjax)
        {
            $current_page =  \Yii::$app->request->post('page',0);
            $next_page = intval($current_page) + 1;
            $append_list = User::getfriends($user_id ,$next_page);
            $response = \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'list' => $append_list
            ];
        }

        return $this->render('list.tpl',$params);
    }

}