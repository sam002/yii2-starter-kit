<?php

use yii\db\Migration;

/**
 * Handles adding about to table `user_profile`.
 */
class m161128_134948_add_about_column_to_user_profile_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user_profile', 'about', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user_profile', 'about');
    }
}
