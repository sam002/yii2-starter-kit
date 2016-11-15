<?php

use yii\db\Migration;
use \sam002\otp\Otp;

class m160204_204720_otp_auth extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        return $this->addColumn('{{%user}}', 'secret' ,$this->string(Otp::SECRET_LENGTH_MAX)->defaultValue(null), $tableOptions);
    }

    public function down()
    {
        return $this->dropColumn('{{%user}}', 'secret');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
