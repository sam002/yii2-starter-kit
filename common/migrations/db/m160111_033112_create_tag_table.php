<?php

use yii\db\Schema;
use yii\db\Migration;

class m160111_033112_create_tag_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%tag}}', [
            'id' =>  $this->primaryKey(),
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'frequency' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
        ]);

        $this->createTable('{{%post_tag_assn}}', [
            'post_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'tag_id' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->addPrimaryKey('post_tag_assn_pk', '{{%post_tag_assn}}', ['post_id', 'tag_id']);

        $this->addForeignKey('fk_post_tag_assn_tag', '{{%post_tag_assn}}', 'tag_id', '{{%tag}}', 'id', 'cascade', 'restrict');
        $this->addForeignKey('fk_post_tag_assn_article', '{{%post_tag_assn}}', 'post_id', '{{%article}}', 'id', 'cascade', 'restrict');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_post_tag_assn_tag', '{{%post_tag_assn}}');
        $this->dropForeignKey('fk_post_tag_assn_article', '{{%post_tag_assn}}');
        $this->dropTable('{{%post_tag_assn}}');
        $this->dropTable('{{%tag}}');
    }

}
