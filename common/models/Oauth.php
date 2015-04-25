<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_oauth}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $provider
 * @property string $client_id
 * @property string $properties
 * @property integer $created_at
 *
 * @property User $user
 */
class Oauth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_oauth}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'provider', 'client_id'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['properties'], 'string'],
            [['provider', 'client_id'], 'string', 'max' => 255],
            [['provider', 'client_id'], 'unique', 'targetAttribute' => ['provider', 'client_id'], 'message' => 'The combination of Provider and Client ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'User ID'),
            'provider' => Yii::t('common', 'Provider'),
            'client_id' => Yii::t('common', 'Client ID'),
            'properties' => Yii::t('common', 'Properties'),
            'created_at' => Yii::t('common', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
