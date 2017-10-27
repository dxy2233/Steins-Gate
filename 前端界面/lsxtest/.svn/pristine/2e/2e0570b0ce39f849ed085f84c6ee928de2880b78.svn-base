<?php
namespace seller\controllers;

use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SellerController extends Controller
{
     /**
     * @inheritdoc
     */
    //public function behaviors()
    //{
    //    return [
    //        'access' => [
    //            'class' => AccessControl::className(),
    //            'rules' => [
    //                //[
    //                //    'actions' => ['login', 'error'],
    //                //    'allow' => true,
    //                //],
    //                [
    //                    'actions' => ['index', 'index'],
    //                    'allow' => true,
    //                    'roles' => ['@'],
    //                ],
    //            ],
    //        ],
    //        'verbs' => [
    //            'class' => VerbFilter::className(),
    //            'actions' => [
    //                'logout' => ['post'],
    //            ],
    //        ],
    //    ];
    //}

    public function actionIndex()
    {

        var_dump(111);die;
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
