<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 9:27
 */
namespace app\modules\goods\controllers;

use yii\web\Controller;

class GoodsController extends Controller{

    public $layout = 'main.tpl';

    public function __construct ($id, $module, $config = [])
    {
        $module = \Yii::$app->getModule('goods');
        parent::__construct($id, $module, $config);
    }

    public function actionIndex (){
        var_dump(1);die;
        $params = [
            'a'=>[
                '1'=>1,
                '2'=>2
            ],
            'b'=>'2'
        ];
        return $this->render('goods.tpl',$params);
    }

    public function actionBuy (){
        var_dump(111);
    }

}