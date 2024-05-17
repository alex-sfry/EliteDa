<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%modules_price_list}}`.
 */
class m240517_005037_create_modules_price_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%modules_price_list}}', [
            'symbol' => $this->string(255)->notNull(),
            'price' => $this->integer(),
        ]);

        $this->addPrimaryKey('pk_modules_price_list', '{{%modules_price_list}}', 'symbol');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%modules_price_list}}');
    }
}
