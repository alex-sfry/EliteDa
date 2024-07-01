<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rings}}`.
 */
class m240613_153351_create_rings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rings}}', [
            'name' => $this->string(255),
            'type' => $this->string(50),
            'system_name' => $this->string(255),
            'distance_to_arrival' => $this->integer(),
            'body_name' => $this->string(255),
            'reserve' => $this->string(50),
            'timestamp' => $this->string(50),
        ]);

        $this->addPrimaryKey('pk_rings', '{{%rings}}', 'name');
        $this->createIndex('idx_system_name', '{{%rings}}', 'system_name');
        $this->createIndex('idx_ring_type', '{{%rings}}', 'type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rings}}');
    }
}
