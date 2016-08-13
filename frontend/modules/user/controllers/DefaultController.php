<?php

namespace frontend\modules\user\controllers;

use common\base\MultiModel;
use frontend\modules\user\models\AccountForm;
use Intervention\Image\ImageManagerStatic;
use trntv\filekit\actions\DeleteAction;
use trntv\filekit\actions\UploadAction;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class DefaultController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'avatar-upload' => [
                'class' => UploadAction::className(),
                'deleteRoute' => 'avatar-delete',
                'on afterSave' => function ($event) {
                    /* @var $file \League\Flysystem\File */
                    $file = $event->file;
                    $img = ImageManagerStatic::make($file->read())->fit(215, 215);
                    $file->put($img->encode());
                }
            ],
            'avatar-delete' => [
                'class' => DeleteAction::className()
            ]
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        $accountModel = new AccountForm();
        $accountModel->setUser(Yii::$app->user->identity);

        if ($accountModel->load(Yii::$app->request->post())) {
            if($accountModel->validate() && $accountModel->save()) {
                    Yii::$app->session->setFlash('alert', [
                        'options' => ['class' => 'alert-success'],
                        'body' => Yii::t('frontend', 'Your account has been successfully saved')
                    ]);
            } else {
                Yii::$app->session->setFlash('alert', [
                    'options' => ['class' => 'alert-danger'],
                    'body' => Yii::t('frontend', 'Ups... Your account don\'t saved')
                ]);
            }
            return $this->refresh();
        } else {
            $model = new MultiModel([
                'models' => [
                    'oauth' => Yii::$app->user->identity->oauth,
                    'account' => $accountModel,
                    'profile' => Yii::$app->user->identity->userProfile
                ]
            ]);
        }
        return $this->render('index', ['model' => $model]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionProfile()
    {
        $modelProfile = Yii::$app->user->identity->userProfile;

        if ($modelProfile->load(Yii::$app->request->post()) && $modelProfile->save()) {
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => Yii::t('frontend', 'Your profile has been successfully saved')
            ]);

        }
        $accountModel = new AccountForm();
        $accountModel->setUser(Yii::$app->user->identity);
        $model = new MultiModel([
            'models' => [
                'oauth' => Yii::$app->user->identity->oauth,
                'account' => $accountModel,
                'profile' => Yii::$app->user->identity->userProfile
            ]
        ]);
        return $this->render('index', ['model' => $model]);
    }
}
