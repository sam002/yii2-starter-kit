<?php

namespace frontend\modules\user\models;

use common\models\User;
use yii\base\Model;
use Yii;
use yii\web\JsExpression;
use kartik\password\StrengthValidator;

/**
 * Account form
 */
class AccountForm extends Model
{
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $password;
    /**
     * @var string
     */
    public $password_confirm;
    /**
     * @var string
     */
    public $password_current;

    /** @var  User */
    private $user;

    /**
     * @param $user
     */
    public function setUser($user)
    {
        $this->user = $user;
        $this->email = $user->email;
        $this->username = $user->username;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique',
                'targetClass' => User::class,
                'message' => Yii::t('frontend', 'This username has already been taken.'),
                'filter' => function ($query) {
                    $query->andWhere(['not', ['id' => Yii::$app->user->getId()]]);
                }
            ],
            ['username', 'string', 'min' => 1, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass' => User::class,
                'message' => Yii::t('frontend', 'This email has already been taken.'),
                'filter' => function ($query) {
                    $query->andWhere(['not', ['id' => Yii::$app->user->getId()]]);
                }
            ],
            ['password', 'string'],
            ['password', StrengthValidator::className(), 'digit' => 0, 'preset'=>'normal', 'userAttribute'=>'username'],
            [
                ['password_confirm', 'password_current'],
                'required',
                'when' => function ($model) {
                    return !empty($model->password);
                },
                'whenClient' => new JsExpression("function (attribute, value) {
                    return $('#accountform-password').val().length > 0;
                }")
            ],
            ['password_confirm', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false],
            ['password_current', 'validatePassword']
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            if (!$this->user || !$this->user->validatePassword($this->password_current)) {
                $this->addError('password_current', Yii::t('frontend', 'Incorrect password.'));
            }
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('frontend', 'Username'),
            'email' => Yii::t('frontend', 'Email'),
            'password' => Yii::t('frontend', 'Password'),
            'password_confirm' => Yii::t('frontend', 'Confirm Password'),
            'password_current' => Yii::t('frontend', 'Current Password')
        ];
    }

    /**
     * @return bool
     */
    public function save()
    {
        $this->user->username = $this->username;
        $this->user->email = $this->email;
        if ($this->password) {
            $this->user->setPassword($this->password);
        }
        return $this->user->save();
    }
}
