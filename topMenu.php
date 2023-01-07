<?php
/**
 * @author: Harry Tang (giaduy@gmail.com)
 * @link: http://www.greyneuron.com
 * @copyright: Grey Neuron
 */

use harrytang\core\Core;
use harrytang\simpleinvoice\SimpleinvoiceModule;
use yii\helpers\Html;


if (Yii::$app->user->isGuest) {
    return [
        'left' => [],
        'user' => [],
        'right' => [
        ],
    ];
} else { // member
    return [
        'left' => [],
        'right' => [
        ],
        'user' => [
            //['label' => SimpleinvoiceModule::t('My Invoices'), 'url' => ['/simpleinvoice/invoice/manage'],  'active'=>Core::checkMCA('simpleinvoice', 'invoice', 'manage')],
            ['label' => SimpleinvoiceModule::t('All Invoices'), 'url' => ['/simpleinvoice/invoice/index'],  'active'=>Core::checkMCA('simpleinvoice', 'invoice', 'index'), 'visible'=>Yii::$app->user->can('staff')],
        ],
    ];
}
