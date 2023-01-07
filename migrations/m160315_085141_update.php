<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m160315_085141_update
 */
class m160315_085141_update extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%simpleinvoice_invoice}}', 'img_1', 'longblob NULL DEFAULT NULL AFTER `invoice_pdf`');
        $this->addColumn('{{%simpleinvoice_invoice}}', 'img_2', 'longblob NULL DEFAULT NULL AFTER `img_1`');
        $this->addColumn('{{%simpleinvoice_invoice}}', 'img_3', 'longblob NULL DEFAULT NULL AFTER `img_2`');
    }

    /**
     * @inheritdoc
     * @return bool
     */
    public function down()
    {
        $this->dropColumn('{{%simpleinvoice_invoice}}', 'img_3');
        $this->dropColumn('{{%simpleinvoice_invoice}}', 'img_2');
        $this->dropColumn('{{%simpleinvoice_invoice}}', 'img_1');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}