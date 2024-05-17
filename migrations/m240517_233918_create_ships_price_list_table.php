<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ships_price_list}}`.
 */
class m240517_233918_create_ships_price_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ships_price_list}}', [
            'symbol' => $this->string(255)->notNull(),
            'price' => $this->integer(),
        ]);

        $this->addPrimaryKey('pk_ships_price_list', '{{%ships_price_list}}', 'symbol');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ships_price_list}}');
    }
}
