<?php

namespace frontend\modules\user\controllers;

use common\commands\SendEmailCommand;
use common\models\User;
use common\models\UserToken;
use common\models\Oauth;
use frontend\modules\user\models\LoginForm;
use frontend\modules\user\models\PasswordResetRequestForm;
use frontend\modules\user\models\ResetPasswordForm;
use frontend\modules\user\models\SignupForm;
use Yii;
use yii\authclient\AuthAction;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class SignInController
 * @package frontend\modules\user\controllers
 * @author Eugene Terentev <eugene@terentev.net>
 */
class SignInController extends \yii\web\Controller
{

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'oauth' => [
                'class' => AuthAction::class,
                'successCallback' => [$this, 'successOAuthCallback']
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
                        'actions' => [
                            'signup', 'login', 'login-by-pass', 'request-password-reset', 'reset-password', 'oauth', 'activation'
                        ],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => [
                            'signup', 'login', 'request-password-reset', 'reset-password', 'activation'
                        ],
                        'allow' => false,
                        'roles' => ['@'],
                        'denyCallback' => function () {
                            return Yii::$app->controller->redirect(['/user/default/index']);
                        }
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['oauth'],
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

    /**
     * @return array|string|Response
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if (Yii::$app->request->isAjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model
        ]);
    }

    /**
     * @param $token
     * @return array|string|Response
     * @throws ForbiddenHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionLoginByPass($token)
    {
        if (!$this->module->enableLoginByPass) {
            throw new NotFoundHttpException();
        }

        $user = UserToken::use($token, UserToken::TYPE_LOGIN_PASS);

        if ($user === null) {
            throw new ForbiddenHttpException();
        }

        Yii::$app->user->login($user);
        return $this->goHome();
    }

    /**
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * @return string|Response
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            $user = $model->signup();
            if ($user) {
                if ($model->shouldBeActivated()) {
                    Yii::$app->getSession()->setFlash('alert', [
                        'body' => Yii::t(
                            'frontend',
                            'Your account has been successfully created. Check your email for further instructions.'
                        ),
                        'options' => ['class' => 'alert-success']
                    ]);
                } else {
                    Yii::$app->getUser()->login($user);
                }
                return $this->goHome();
            }
        }

        return $this->render('signup', [
            'model' => $model
        ]);
    }

    /**
     * @param $token
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionActivation($token)
    {
        $token = UserToken::find()
            ->byType(UserToken::TYPE_ACTIVATION)
            ->byToken($token)
            ->notExpired()
            ->one();

        if (!$token) {
            throw new BadRequestHttpException;
        }

        $user = $token->user;
        $user->updateAttributes([
            'status' => User::STATUS_ACTIVE
        ]);
        $token->delete();
        Yii::$app->getUser()->login($user);
        Yii::$app->getSession()->setFlash('alert', [
            'body' => Yii::t('frontend', 'Your account has been successfully activated.'),
            'options' => ['class' => 'alert-success']
        ]);

        return $this->goHome();
    }

    /**
     * @return string|Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => Yii::t('frontend', 'Check your email for further instructions.'),
                    'options' => ['class' => 'alert-success']
                ]);

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => Yii::t('frontend', 'Sorry, we are unable to reset password for email provided.'),
                    'options' => ['class' => 'alert-danger']
                ]);
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * @param $token
     * @return string|Response
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('alert', [
                'body' => Yii::t('frontend', 'New password was saved.'),
                'options' => ['class' => 'alert-success']
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
                'provider' => $client->getName(),
                'client_id' => ArrayHelper::getValue($attributes, 'id')
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
                            ])
                        ]
                    );
                } else {
                    //Ckeck user name. generate new if user with same mail exist)
                    $this->signupOauth($client);

                }
            }
        } else { // user already logged in
            $this->addProvider($client, $auth);
        }
    }

    /**
     * @param \yii\authclient\BaseClient $client
     * @throws Exception
     * @throws \yii\db\Exception
     */
    private function signupOauth($client)
    {
        $attributes = $client->getUserAttributes();
        $loginDuplicate = NULL;
        if (isset($attributes['login']) && User::find()->where(['username' => $attributes['login']])->exists()) {
            $loginDuplicate = $attributes['login'];
            $attributes['login'] .= '_' . time();
        }

        $user = new User();
        $user->scenario = 'oauth_create';
        $user->username = ArrayHelper::getValue($attributes, 'login');
        $user->email = ArrayHelper::getValue($attributes, 'email');
        $user->status = User::STATUS_ACTIVE;
        $password = Yii::$app->security->generateRandomString(8);
        $user->setPassword($password);

        $transaction = $user->getDb()->beginTransaction();
        if ($user->save()) {
            $auth = new Oauth([
                'user_id' => $user->id,
                'provider' => $client->getName(),
                'client_id' => (string)$attributes['id'],
                'properties' => json_encode($attributes)
            ]);
            if ($auth->save()) {
                $transaction->commit();
                Yii::$app->user->login($user);
                $profileData = [];
                if ($client->getName() === 'facebook') {
                    $profileData['firstname'] = ArrayHelper::getValue($attributes, 'first_name');
                    $profileData['lastname'] = ArrayHelper::getValue($attributes, 'last_name');
                }
                $user->afterSignup($profileData);
                $sentSuccess = Yii::$app->commandBus->handle(new SendEmailCommand([
                    'view' => 'oauth_welcome',
                    'params' => ['user' => $user, 'password' => $password],
                    'subject' => Yii::t('frontend', '{app-name} | Your login information', ['app-name' => Yii::$app->name]),
                    'to' => $user->email
                ]));
                if ($sentSuccess) {
                    Yii::$app->session->setFlash(
                        'alert',
                        [
                            'options' => ['class' => 'alert-success'],
                            'body' => Yii::t('frontend', 'Welcome to {app-name}. Email with your login information was sent to your email.', [
                                'app-name' => Yii::$app->name
                            ])
                        ]
                    );
                    //TODO Fix hiding
                    if (!empty($loginDuplicate)) {
                        Yii::$app->getSession()->addFlash('alert',
                            [
                                'body' => Yii::t('frontend', 'We already have a user with name {login}. You can login using email to link {provider} account.', [
                                    'login' => $loginDuplicate,
                                    'provider' => $client->getName()
                                ]),
                            ]);
                    }
                }
            } else {
                // We already have a user with this email. Do what you want in such case
                if ($user->email && User::find()->where(['email' => $user->email])->count()) {
                    Yii::$app->session->setFlash(
                        'alert',
                        [
                            'options' => ['class' => 'alert-danger'],
                            'body' => Yii::t('frontend', 'We already have a user with email {email}', [
                                'email' => $user->email
                            ])
                        ]
                    );
                } else {
                    Yii::$app->session->setFlash(
                        'alert',
                        [
                            'options' => ['class' => 'alert-danger'],
                            'body' => Yii::t('frontend', 'Error while oauth process.')
                        ]
                    );
                }
            }
        }
    }

    /**
     * @param \yii\authclient\BaseClient $client
     * @param Oauth $auth
     * @return bool
     * @throws Exception
     */
    private function addProvider($client, Oauth $auth = null)
    {
        $attributes = $client->getUserAttributes();
        if (!$auth) { // add auth provider
            $auth = new Oauth([
                'user_id' => YII::$app->user->id,
                'provider' => $client->getName(),
                'client_id' => (string)$attributes['id'],
                'properties' => json_encode($attributes)
            ]);
            if ($auth->save()) {
                Yii::$app->session->setFlash('alert',
                    [
                        'options' => ['class' => 'alert-success'],
                        'body' => Yii::t('frontend', 'You have successfully linked {provider} account with your profile.', [
                            'provider' => $client->getName()
                        ])
                    ]);
                return true;
            } else {
                throw new Exception('OAuth error');
            }
            return true;
        } elseif (isset($attributes['login']) && User::find()->where(['username' => $attributes['login']])->exists()) {
            //TODO check use case
            $auth->user = Yii::$app->user;
            if ($auth->save()) {
                Yii::$app->session->setFlash('alert',
                    [
                        'options' => ['class' => 'alert-success'],
                        'body' => Yii::t('frontend', 'You have successfully linked {provider} account with your profile.', [
                            'provider' => $client->getName()
                        ])
                    ]);
                return true;
            }
        }

        throw new Exception('OAuth error');
    }
}
