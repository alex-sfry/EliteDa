<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%materials}}`.
 */
class m240409_004917_create_materials_table extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \ReflectionException
     */
    public function safeUp(): void
    {
        $this->createTable('{{%materials}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unique(),
            'category' => $this->string(100)->notNull(),
            'grade' => $this->string(50)->notNull(),
            'type' => $this->string(100)->notNull(),
            'location' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%materials}}');
    }
}
