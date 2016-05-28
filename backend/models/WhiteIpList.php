<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "white_ip_list".
 *
 * @property string $ip
 * @property string $username
 */
class WhiteIpList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'white_ip_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip'], 'required'],
            [['ip'], 'ip'],
            [['ip', 'username'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ip' => 'Ip',
            'username' => 'Username',
        ];
    }

    /**
     * @inheritdoc
     * @return WhiteIpListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WhiteIpListQuery(get_called_class());
    }
}
