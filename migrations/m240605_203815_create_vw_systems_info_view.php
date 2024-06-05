<?php

use yii\db\Migration;

/**
 * Class m240605_203815_create_vw_systems_info_view
 */
class m240605_203815_create_vw_systems_info_view extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db->createCommand('
        CREATE OR REPLACE VIEW `vw_systems_info` AS
        SELECT 
            sys.id,
            sec.security_level AS security,
            ec.economy_name AS economy,
            al.faction_name AS allegiance,
            sys.name AS system,
            sys.population,
            sys.x,
            sys.y,
            sys.z
        FROM `systems` AS sys
        INNER JOIN `allegiance` AS al ON `sys`.`allegiance_id`=`al`.`id`
        INNER JOIN `economies` AS ec ON `sys`.`economy_id`=`ec`.`id`
        INNER JOIN `security` AS sec ON `sys`.`security_id`=`sec`.`id`
        ')->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240605_203815_create_vw_systems_info_view cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240605_203815_create_vw_systems_info_view cannot be reverted.\n";

        return false;
    }
    */
}
