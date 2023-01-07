<?php

use yii\db\Schema;
use yii\db\Migration;

class m150202_030704_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%simpleinvoice_invoice}}', [
            'id' => Schema::TYPE_STRING.'(20) NOT NULL',
            'currency' => Schema::TYPE_STRING.'(5) NOT NULL',

            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'contact' => Schema::TYPE_STRING . '(50) NOT NULL',

            'sold_to' => Schema::TYPE_TEXT . ' NOT NULL',
            'ship_to' => Schema::TYPE_TEXT . ' NOT NULL', // ship to

            'payment_methods' => Schema::TYPE_STRING,
            'payment_status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'payment_date' => Schema::TYPE_INTEGER . ' NULL DEFAULT NULL',

            'shipping_carrier' => Schema::TYPE_STRING,
            'shipping_status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'shipping_date' => Schema::TYPE_INTEGER . ' NULL DEFAULT NULL',

            'proof_of_shipment'=>'longblob NULL DEFAULT NULL',
            'invoice_pdf'=>'longblob NULL DEFAULT NULL',

            'details' => Schema::TYPE_TEXT . ' NOT NULL', // json
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',

            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);

        $this->addPrimaryKey('pk', '{{%simpleinvoice_invoice}}', 'id');

    }

    public function down()
    {
        $this->dropTable('{{%simpleinvoice_invoice}}');
    }
}
