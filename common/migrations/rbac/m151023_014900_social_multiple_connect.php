<?php

use yii\db\Schema;
use yii\db\Migration;

class m151023_014900_social_multiple_connect extends Migration
{
    public function up()
    {
        $this->createTable('{{%user_oauth}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'provider' => Schema::TYPE_STRING . ' NOT NULL',
            'client_id' => Schema::TYPE_STRING . ' NOT NULL',
            'properties' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER,
        ]);
        $this->addForeignKey(
            'fk_user_oauth_user',
            '{{%user_oauth}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
        $this->createIndex('user_oauth', '{{%user_oauth}}', ['provider', 'client_id'], true);
        $this->db->createCommand('INSERT INTO {{%user_oauth}} (user_id, provider, client_id, created_at)' .
                ' SELECT id AS user_id, oauth_client AS provider, oauth_client_user_id AS client_id, created_at' .
                ' FROM {{%user}} WHERE oauth_client_user_id IS NOT NULL;')->query();

        $this->dropColumn('{{%user}}', 'oauth_client');
        $this->dropColumn('{{%user}}', 'oauth_client_user_id');
    }

    /**
     * @throws \yii\base\NotSupportedException
     */
    public function down()
    {
        $this->addColumn('{{%user}}', 'oauth_client', Schema::TYPE_STRING);
        $this->addColumn('{{%user}}', 'oauth_client_user_id', Schema::TYPE_STRING);

        if ( in_array( $this->db->driverName, ['mysql','mysqli','sqlite2', 'sqlite'])) {
            //TODO test, please!
            $this->db->createCommand('UPDATE {{%user}}, {{%user_oauth}}'
                . 'SET oauth_client = {{%user_oauth}}.provider,'
                . ' oauth_client_user_id = {{%user_oauth}}.client_id '
                . 'WHERE {{%user}}.id = {{%user_oauth}}.user_id;')->query();
        } elseif ($this->db->driverName === 'pgsql') {
            $this->db->createCommand('UPDATE {{%user}} '
                . 'SET oauth_client = {{%user_oauth}}.provider, oauth_client_user_id = {{%user_oauth}}.client_id '
                . ' FROM {{%user_oauth}}'
                . ' WHERE {{%user}}.id = {{%user_oauth}}.user_id;')->query();
        } else {
            //TODO test, please! (sqlsrv, mssql, dblib, cubrid)
            //If conform to SQL standard...
            $this->db->createCommand('UPDATE {{%user}} SET (oauth_client, oauth_client_user_id)'
                . ' ( SELECT provider as oauth_client, client_id AS oauth_client_user_id FROM {{%user_oauth}}'
                . ' WHERE {{%user_oauth}}.user_id = {{%user}}.id );')->query();
        }

        $this->dropForeignKey(
            'fk_user_oauth_user',
            '{{%user_oauth}}'
        );

        $this->dropTable('{{%user_oauth}}');
    }
}
