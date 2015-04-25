<?php

namespace frontend\modules\user\controllers;

use common\models\Oauth;
use common\models\User;
use frontend\modules\user\models\LoginForm;
use frontend\modules\user\models\PasswordResetRequestForm;
use frontend\modules\user\models\ResetPasswordForm;
use frontend\modules\user\models\SignupForm;
use Yii;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SignInController extends \yii\web\Controller
{

    public function actions()
    {
        return [
            'oauth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successOAuthCallback']
            ]
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['signup', 'login', 'request-password-reset', 'reset-password', 'oauth'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['signup', 'login', 'request-password-reset', 'reset-password', 'oauth'],
                        'allow' => false,
                        'roles' => ['@'],
                        'denyCallback' => function() {
                            return Yii::$app->controller->redirect(['/user/default/profile']);
                        }
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post']
                ]
            ]
        ];
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if (Yii::$app->request->isAjax) {
            $model->load($_POST);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            $user = $model->signup();
            if ($user && Yii::$app->getUser()->login($user)) {
                return $this->goHome();
            }
        }

        return $this->render('signup', [
            'model' => $model
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('alert', [
                    'body'=>Yii::t('frontend', 'Check your email for further instructions.'),
                    'options'=>['class'=>'alert-success']
                ]);

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('alert', [
                    'body'=>Yii::t('frontend', 'Sorry, we are unable to reset password for email provided.'),
                    'options'=>['class'=>'alert-danger']
                ]);
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('alert', [
                'body'=> Yii::t('frontend', 'New password was saved.'),
                'options'=>['class'=>'alert-success']
            ]);
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * @param $client \yii\authclient\BaseClient
     * @return bool
     * @throws Exception
     */
    public function successOAuthCallback($client)
    {
        // use BaseClient::normalizeUserAttributeMap to provide consistency for user attribute`s names
        $attributes = $client->getUserAttributes();
        $auth = Oauth::find()->where([
                'provider'=>$client->getName(),
                'client_id'=>ArrayHelper::getValue($attributes, 'id')
            ])
            ->one();
        if (Yii::$app->user->isGuest) {
            if ($auth) { // login
                $user = $auth->user;
                if (Yii::$app->user->login($user, 3600 * 24 * 30)) {
                    return true;
                } else {
                    throw new Exception('OAuth error');
                }
            } else { // signup
                if (isset($attributes['email']) && User::find()->where(['email' => $attributes['email']])->exists()) {
                    Yii::$app->getSession()->setFlash('alert',
                        [
                            'options'=>['class'=>'alert-danger'],
                            'body'=>Yii::t('frontend', 'We already have a user with email {email}. Login using email first to link it.', [
                                'email' => $attributes['email']
                            ]),
                    ]);
                } else {
                    //Ckeck user name. generate new if user with same mail exist)
                    $loginDuplicate = NULL;
                    if (isset($attributes['login']) && User::find()->where(['username' => $attributes['login']])->exists()) {
                        $loginDuplicate = $attributes['login'];
                        $attributes['login'] .= '_' . time();
                    }

                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
                        'username' => $attributes['login'],
                        'email' => $attributes['email'],
                        'password' => $password,
                    ]);

                    //$user->generateAuthKey();
                    $user->generatePasswordResetToken();
                    //print_r($user); die();
                    $transaction = $user->getDb()->beginTransaction();
                    if ($user->save()) {
                        $auth = new Oauth([
                            'user_id' => $user->id,
                            'provider' => $client->getName(),
                            'client_id' => (string)$attributes['id'],
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->user->login($user);
                            $user->afterSignup();
                            $sentSuccess = Yii::$app->mailer->compose('oauth_welcome', ['user'=>$user, 'password'=>$password])
                                ->setSubject(Yii::t('frontend', '{app-name} | Your login information', [
                                    'app-name'=>Yii::$app->name
                                ]))
                                ->setTo($user->email)
                                ->send();
                            if ($sentSuccess) {
                                Yii::$app->session->setFlash( 'alert',
                                    [
                                        'options'=>['class'=>'alert-success'],
                                        'body'=>Yii::t('frontend', 'Welcome to {app-name}. Email with your login information was sent to your email.', [
                                            'app-name'=>Yii::$app->name
                                        ])
                                    ]);
                                //TODO Fix hiding
                                if(!empty($loginDuplicate)){
                                    Yii::$app->getSession()->addFlash( 'alert',
                                        [
                                            'body'=>Yii::t('frontend', 'We already have a user with name {login}. You can login using email to link {provider} account.', [
                                                'login' => $loginDuplicate,
                                                'provider' => $client->getName()
                                            ]),
                                        ]);
                                }
                            }
                        } else {
                            throw new Exception('OAuth error');
                        }

                    } else {
                        throw new Exception('OAuth error');
                    }
                }
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider
                $auth = new Oauth([
                    'user_id' => YII::$app->user->id,
                    'provider' => $client->getName(),
                    'client_id' => (string)$attributes['id']
                ]);
                $auth->save();
                return true;
            } elseif (isset($attributes['login']) && User::find()->where(['username' => $attributes['login']])->exists()) {
                $auth->user = Yii::$app->user;
                if ($auth->save()) {
                    Yii::$app->session->setFlash('alert',
                        [
                            'options' => ['class' => 'alert-success'],
                            'body' => Yii::t('frontend', 'You have successfully linked {{provider}} account with your account.', [
                                'provider' => $client->getName()
                            ])
                        ]);
                    return true;
                } else {
                    throw new Exception('OAuth error');
                }
            }
        }
    }
}
