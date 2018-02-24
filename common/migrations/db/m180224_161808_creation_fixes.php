<?php

use yii\db\Migration;

/**
 * Class m180224_161808_creation_fixes
 */
class m180224_161808_creation_fixes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("{{%widget_carousel_item}}", 'asset_url',  $this->string(1024));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("{{%widget_carousel_item}}", 'asset_url');
    }
}
