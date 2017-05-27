<?php

namespace app\controllers;

use app\models\ArtSearch;
use app\models\ContactForm;
use app\models\LoginForm;
use app\models\Calendar;
use app\models\Art;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\models\User;

/**
 * 后台操作
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'art', 'cal', 'logout'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['login'],
                        'roles'   => ['?'],
                    ],
                    [
                        'actions' => ['index', 'art', 'cal', 'logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     *
     * 日历管理
     */
    public function actionIndex()
    {

        $cal_infos = $name = "";
        if (Yii::$app->request->isPost) {
            $name = trim(Yii::$app->request->post('name'));
            if (!empty($name)) {
                $query = Calendar::find()->where(['>=','status',0]);
                $query->andFilterWhere(['like', 'name', $name]);
                $cal_infos = $query->joinWith("member")->asArray()->all();
                if (!empty($cal_infos)) {
                    $cal_infos = array_map(function ($item) {
                        $item['relation_userinfo'] = json_decode($item['relation_userinfo'], true);
                        return $item;
                    }, $cal_infos);
                }
            }
        }
        return $this->render('cal', [
            'name' => $name,
            'cal_infos' => $cal_infos,
        ]);
    }

    /**
     * 演出管理
     *
 */
    public function actionArt()
    {
        $art_infos = $name = "";
        if (Yii::$app->request->isPost) {
            $name = trim(Yii::$app->request->post('name'));
            if (!empty($name)) {
                $query = Art::find()->where(['>=','status',0]);
                $query->andFilterWhere(['like', 'name', $name]);
                $art_infos = $query->joinWith("member")->asArray()->all();
            }
        }
        return $this->render('art', [
            'name' => $name,
            'art_infos' => $art_infos,
        ]);
    }

    public function actionOpt()
    {

        $request = Yii::$app->request;
        $id  = $request->post('id', 0);
        $type  = $request->post('type', 0);

        if (empty($id) || empty($type)) {
            echo json_encode(['code'=>-1,'msg'=>'非法请求']);exit;
        }

        //日历
        if (1 == $type) {
            $query = Calendar::findOne($id);
            $query->status = -1;
            $res           = $query->save();
        } elseif(2 == $type) {
            $query = Art::findOne($id);
            $query->status = -1;
            $res           = $query->save();
        } else {
            $res = false;
        }
        
        if ($res) {
            echo json_encode(['code'=>1,'msg'=>'操作成功']);exit;
        } else {
            echo json_encode(['code'=>-2,'msg'=>'操作失败，请稍后重试']);exit;
        }
    }

    public function actionUpdViewCount()
    {
        $request = Yii::$app->request;
        $id   = $request->post('id', 0);
        $view_count   = $request->post('view_count', 0);

        if (empty($id) || empty($view_count)) {
            return $this->response(CodeEnum::$paramError);
        }

        $query = Calendar::findOne($id);
        $query->view_count = $view_count;
        $res = $query->save();

        if ($res) {
            echo json_encode(['code'=>1,'msg'=>'操作成功']);exit;
        } else {
            echo json_encode(['code'=>-2,'msg'=>'操作失败，请稍后重试']);exit;
        }
    }
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    
    private function actionSignup()
    {
        $user = new User();
        $user->username = 'test';
        $user->email = 'test@test.com';
        $user->setPassword('test');
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }

}
