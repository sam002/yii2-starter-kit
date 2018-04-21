<?php

use lav45\translate\models\Lang;
use yii\db\Migration;

/**
 * Class m180421_200614_locales
 */
class m180421_200614_locales extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%lang}}', [
            'id' => $this->string(2)->notNull(),
            'locale' => $this->string(8)->notNull(),
            'name' => $this->string(32)->notNull(),
            'status' => $this->smallInteger(),
            'PRIMARY KEY (id)',
        ], $tableOptions);

        $this->createIndex('lang_name_idx', '{{%lang}}', 'name', true);
        $this->createIndex('lang_status_idx', '{{%lang}}', 'status');

        $locales = [
            [
                'id' => 'en',
                'locale' => 'en-US',
                'name' => 'English',
                'status' => Lang::STATUS_ACTIVE
            ],
            [
                'id' => 'ru',
                'locale' => 'ru-RU',
                'name' => 'Русский',
                'status' => Lang::STATUS_ACTIVE
            ],
            [
                'id' => 'uk',
                'locale' => 'uk-UA',
                'name' => 'Українська',
                'status' => Lang::STATUS_ACTIVE
            ],
            [
                'id' => 'es',
                'locale' => 'es-ES',
                'name' => 'Español',
                'status' => Lang::STATUS_ACTIVE
            ],
            [
                'id' => 'vi',
                'locale' => 'vi-VN',
                'name' => 'Tiếng Việt',
                'status' => Lang::STATUS_ACTIVE
            ],
            [
                'id' => 'zh',
                'locale' => 'zh-CN',
                'name' => '简体中文',
                'status' => Lang::STATUS_ACTIVE
            ],
            [
                'id' => 'pl',
                'locale' => 'pl-PL',
                'name' => 'Polski',
                'status' => Lang::STATUS_ACTIVE
            ],
            [
                'id' => 'fr',
                'locale' => 'fr-FR',
                'name' => 'Français',
                'status' => Lang::STATUS_DISABLE
            ],
            [
                'id' => 'pt',
                'locale' => 'pt-PT',
                'name' => 'Portuguesa',
                'status' => Lang::STATUS_DISABLE
            ],
            [
                'id' => 'de',
                'locale' => 'de-De',
                'name' => 'Deutsch',
                'status' => Lang::STATUS_DISABLE
            ]
        ];

        foreach ($locales as $locale) {
            $this->insert('{{%lang}}', $locale);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%lang}}');
    }
}
