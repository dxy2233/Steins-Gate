<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 9:27
 */
namespace app\modules\index\controllers;

use common\models\BanquetType;
use common\models\Carousel;
use common\models\Category;
use common\models\ShopBanquet;
use common\website\JSSDK;
use frontend\controllers\DefaultController;
use yii\web\Controller;
use yii\helpers\Url;

header("Content-type:text/html;charset=utf-8");

class IndexController extends DefaultController{

//    public $layout = 'main.tpl';

    public function __construct ($id, $module, $config = [])
    {
        $module = \Yii::$app->getModule('index');
        parent::__construct($id, $module, $config);
    }

    /*
     * 用户端首页
     * 几张轮播图，分类信息，热门流水席，底部，头部地理位置（市）
     */
    public function actionIndex ()
    {
        $params = [];
        $location = \Yii::$app->getSession()->get('location','');
        if(!empty($location)){
            $lat = $location['lat'];
            $lng = $location['lng'];
        }else{
            $lat = 0;
            $lng = 0;
        }

        $params['area'] = '重庆市';
        $params['carousel'] = Carousel::getLb2();
        $params['last'] = end($params['carousel']);
        $params['category'] = BanquetType::getAllCategory();
        $params['hotlsx'] = ShopBanquet::getHotlsx();
        foreach($params['hotlsx'] as &$lsx)
        {
            $lsx['tothere'] = getDistance($lsx['shop_lat'], $lsx['shop_lng'],$lat ,$lng);
        }

        $weixinconfig['appid'] = \Yii::$app->params['UserWechat']['app_id'];
        $weixinconfig['appsecret'] = \Yii::$app->params['UserWechat']['secret'];
        $jssdk = new JSSDK($weixinconfig['appid'], $weixinconfig['appsecret']);
        $params['signPackage'] = $jssdk->GetSignPackage();

//        $params['is_obtain_coordinate'] = empty(\Yii::$app->session->get('location','')) ? 1 : 0;
//       var_dump($params);die;
        return $this->render('index.tpl',$params);
    }

    public function actionBuy (){
        var_dump(homeurl('index/index/index'));
    }

}