<?php

use yii\db\Migration;
use \sam002\otp\Otp;

class m160204_204720_otp_auth extends Migration
{
    public function safeUp()
    {
        return $this->addColumn('{{%user}}', 'secret' ,$this->string(Otp::SECRET_LENGTH_MAX)->defaultValue(null));
    }

    public function safeDown()
    {
        return $this->dropColumn('{{%user}}', 'secret');
    }
}
