<?php

use yii\db\Migration;

class m161218_124548_insert_to_key_storage_item_table extends Migration
{
    public function up()
    {
        $this->insert('key_storage_item', [
            'key' => 'common.default-avatar',
            'value' => '{"path":"anonymous.jpg","name":"anonymous.jpg","base_url":"'.env('FRONTEND_URL').'\/img"}']);
    }

    public function down()
    {
        $this->delete('key_storage_item', ['key' => 'common.default-avatar']);
    }
}
