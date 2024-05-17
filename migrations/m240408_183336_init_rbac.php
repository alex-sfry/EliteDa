<?php

use yii\db\Migration;

/**
 * Class m240408_183336_init_rbac
 */
class m240408_183336_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $auth = Yii::$app->authManager;

        $accessAddtodb = $auth->createPermission('accessAddtodb');
        $accessAddtodb->description = 'Access to AddToDb page';
        $auth->add($accessAddtodb);

        $accessSandbox = $auth->createPermission('accessSandbox');
        $accessSandbox->description = 'Access to Sandbox page';
        $auth->add($accessSandbox);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $accessAddtodb);
        $auth->addChild($admin, $accessSandbox);

        $auth->assign($admin, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }
    */

    public function down()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}
