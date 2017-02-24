<?php

use yii\db\Migration;

class m161016_174954_fix_article_creator_updater extends Migration
{
    public function safeUp()
    {

        $this->dropForeignKey('fk_article_author', '{{%article}}');
        $this->dropForeignKey('fk_article_updater', '{{%article}}');

        $this->renameColumn('{{%article}}', 'author_id', 'created_by');
        $this->renameColumn('{{%article}}', 'updater_id', 'updated_by');

        $this->addForeignKey('fk_article_created', '{{%article}}', 'created_by', '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_article_updated', '{{%article}}', 'updated_by', '{{%user}}', 'id', 'set null', 'cascade');
        $this->createIndex('idx_article_slug', '{{%article}}', 'slug(255)', true);
        $this->createIndex('idx_article_category_slug', '{{%article_category}}', 'slug(255)', true);

    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_article_created', '{{%article}}');
        $this->dropForeignKey('fk_article_updated', '{{%article}}');

        $this->renameColumn('{{%article}}', 'created_by', 'author_id');
        $this->renameColumn('{{%article}}', 'updated_by', 'updater_id');

        $this->addForeignKey('fk_article_author', '{{%article}}', 'author_id', '{{%user}}', 'id', 'cascade', 'cascade');
        $this->addForeignKey('fk_article_updater', '{{%article}}', 'updater_id', '{{%user}}', 'id', 'set null', 'cascade');
        $this->dropIndex('idx_article_slug', '{{%article}}');
        $this->dropIndex('idx_article_category_slug', '{{%article_category}}');
    }
}
