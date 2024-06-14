<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%rings}}`.
 */
class m240614_145604_add_xyz_columns_to_rings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('rings', 'x', $this->float()->after('system_name'));
        $this->addColumn('rings', 'y', $this->float()->after('x'));
        $this->addColumn('rings', 'z', $this->float()->after('y'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('rings', 'x');
        $this->dropColumn('rings', 'y');
        $this->dropColumn('rings', 'z');
    }
}
