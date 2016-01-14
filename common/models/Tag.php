<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tag}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $frequency
 *
 * @property PostTagAssn[] $postTagAssns
 * @property Article[] $posts
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'name' => Yii::t('common', 'Name'),
            'frequency' => Yii::t('common', 'Frequency'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Article::className(), ['id' => 'post_id'])->viaTable('{{%post_tag_assn}}', ['tag_id' => 'id']);
    }
}
