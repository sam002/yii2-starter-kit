<?php

use yii\db\Migration;

class m160327_161054_create_white_ip_list extends Migration
{
    public function up()
    {
        $this->createTable('white_ip_list', [
            'ip' => $this->string(),
            'username' => $this->string(),
            'PRIMARY KEY(ip)',
        ]);
    }

    public function down()
    {
        $this->dropTable('white_ip_list');
    }
}
