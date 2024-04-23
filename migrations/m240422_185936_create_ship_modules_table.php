<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ship_modules}}`.
 */
class m240422_185936_create_ship_modules_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ship_modules}}', [
            'id' => $this->integer()->notNull(),
            'symbol' => $this->string(255)->notNull()->unique(),
            'name' => $this->string(255)->notNull(),
            'mount' => $this->string(50),
            'category' => $this->string(50),
            'guidance' => $this->string(50),
            'ship' => $this->string(100),
            'class' => $this->integer()->notNull(),
            'rating' => $this->string(8)->notNull(),
            'entitlement' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ship_modules}}');
    }
}
