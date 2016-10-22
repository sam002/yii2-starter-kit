<?php

use yii\db\Schema;
use yii\db\Migration;

class m151025_054151_article_private extends Migration
{
    public function up()
    {
        $this->addColumn('{{%article}}', 'private', Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('{{%article}}', 'private');
    }
}
