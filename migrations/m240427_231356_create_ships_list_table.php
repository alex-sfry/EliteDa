<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ships_list}}`.
 */
class m240427_231356_create_ships_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ships_list}}', [
            'id' => $this->integer()->notNull(),
            'symbol' => $this->string(255)->notNull()->unique(),
            'name' => $this->string(255)->notNull()->unique(),
            'entitlement' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ships_list}}');
    }
}
