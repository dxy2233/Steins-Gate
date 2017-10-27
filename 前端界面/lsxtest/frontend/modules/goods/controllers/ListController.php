<?php
/**
 * Created by PhpStorm.
 * User: ysl
 * Date: 2017/9/12
 * 商品列表控制器
 */

namespace app\modules\goods\controllers;

use common\models\BanquetType;
use frontend\controllers\DefaultController;
use yii\db\Exception;
use yii\web\Controller;
use yii\base\UserException;
use common\models\Category;
header("Content-type:text/html;charset=utf-8");

class ListController extends DefaultController{

//    public $layout = 'main.tpl';
    public $enableCsrfValidation=false;

    public function __construct ($id, $module, $config = [])
    {
        $module = \Yii::$app->getModule('goods');
        parent::__construct($id, $module, $config);
    }

    /*
     * 流水席列表页
     */
    public function actionIndex (){

        $cat_id = \Yii::$app->request->get('cat_id','');
        $params = [];
        $location = \Yii::$app->getSession()->get('location','');
        if(!empty($location)){
            $lat = $location['lat'];
            $lng = $location['lng'];
        }else{
            $lat = 0;
            $lng = 0;
        }
        if(!empty($cat_id))
        {
             $lsx_info = BanquetType::getLsxFromCate($cat_id);
             if(!empty($lsx_info))
             {
                 foreach ($lsx_info as &$item)
                 {
                     $item['distance'] = getDistance($item['shop_lat'], $item['shop_lng'], $lat, $lng);
                 }
             }
        }

       //默认排序方式：距离最近 distance
        $flag = array();
        foreach($lsx_info as $v){
            $flag[] = $v['distance'];
        }
        array_multisort($flag, SORT_ASC, $lsx_info);

        $params['lsx_info'] = $lsx_info;
        $params['cat_id'] = $cat_id;
        $params['type'] = 'zhineng';
        $params['time'] = 'all';

        if(\Yii::$app->request->isAjax)
        {
            $response = \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $type = \Yii::$app->request->post('type');
            $time = \Yii::$app->request->post('time');
//            var_dump($time);
//            var_dump($type);die;
            if($time == 'moring') //查找早上的流水席9-12
            {
//                var_dump(1);die;
                $params['time'] = 'moring';
                foreach ($params['lsx_info'] as $key=>$v){
                    $beginTime1 = strtotime('2017-08-07 09:00');
                    $endTime1 = strtotime('2017-08-07 12:00');
                    $beginTime2 = strtotime('2017-08-07 '.$v['begin_time']);
                    $endTime2 = strtotime('2017-08-07 '.$v['end_time']);
                    if(!is_time_cross($beginTime1 , $endTime1 , $beginTime2 , $endTime2 )){
                        unset($params['lsx_info'][$key]);
//                        var_dump(1);
//                        var_dump($params['lsx_info']);die;
                    }
                }
//                $data = $this->render('list.tpl',$params);
            }elseif($time == 'noon') //查找早上的流水席9-12
            {
                $params['time'] = 'noon';
                foreach ($params['lsx_info'] as $key=>$v){
                    $beginTime1 = strtotime('2017-08-07 12:00');
                    $endTime1 = strtotime('2017-08-07 15:00');
                    $beginTime2 = strtotime('2017-08-07 '.$v['begin_time']);
                    $endTime2 = strtotime('2017-08-07 '.$v['end_time']);
                    if(!is_time_cross($beginTime1 , $endTime1 , $beginTime2 , $endTime2 )){
                        unset($params['lsx_info'][$key]);
                    }
                }
//                 $data = $this->render('list.tpl',$params);
            }
            elseif($time == 'afternoon') //查找早上的流水席9-12
            {
                $params['time'] = 'afternoon';
                foreach ($params['lsx_info'] as $key=>$v){
                    $beginTime1 = strtotime('2017-08-07 15:00');
                    $endTime1 = strtotime('2017-08-07 18:00');
                    $beginTime2 = strtotime('2017-08-07 '.$v['begin_time']);
                    $endTime2 = strtotime('2017-08-07 '.$v['end_time']);
                    if(!is_time_cross($beginTime1 , $endTime1 , $beginTime2 , $endTime2 )){
                        unset($params['lsx_info'][$key]);
                    }
                }
//                $data = $this->render('list.tpl',$params);
            }
//            var_dump($params['lsx_info']);die;
            if($type == 'zhineng'){
                $data = $this->render('list.tpl',$params);
            }elseif($type == 'distance'){
                $params['type'] = 'distance';
                $data = $this->render('list.tpl',$params);
            }elseif($type == 'pinglun'){
                $params['type'] = 'pinglun';
                $flag = array();
                foreach($params['lsx_info'] as $v){
                    $flag[] = $v['service_score'];
                }
                array_multisort($flag, SORT_DESC, $params['lsx_info']);
                $data = $this->render('list.tpl',$params);
            }elseif($type == 'sell'){
                $params['type'] = 'sell';
                $flag = array();
                foreach($params['lsx_info'] as $v){
                    $flag[] = $v['sell'];
                }
                array_multisort($flag, SORT_DESC, $params['lsx_info']);
                $data = $this->render('list.tpl',$params);
            }
//            var_dump($params['type']);
//            var_dump($params['time']);die;

            return [
                'data' => $data
            ];
        }
        return $this->render('list.tpl',$params);

    }

}