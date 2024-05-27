<?php

use yii\db\Migration;

/**
 * Class m240527_042423_vw_stations_info_view
 */
class m240527_042423_vw_stations_info_view extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db->createCommand('
        CREATE OR REPLACE VIEW `vw_stations_info` AS
        SELECT 
            st.id,
            st.name AS station,
            st.type,
            st.distance_to_arrival,
            st.government,
            st.system_id,
            ec.economy_name,
            al.faction_name AS allegiance,
            sys.name AS system,
            sys.x,
            sys.y,
            sys.z
        FROM `stations` AS st
        INNER JOIN `systems` AS sys ON `st`.`system_id`=`sys`.`id`
        INNER JOIN `allegiance` AS al ON `st`.`allegiance_id`=`al`.`id`
        INNER JOIN `economies` AS ec ON `st`.`economy_id_1`=`ec`.`id`
        ')->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240527_042423_vw_stations_info_view cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240527_042423_vw_stations_info_view cannot be reverted.\n";

        return false;
    }
    */
}
