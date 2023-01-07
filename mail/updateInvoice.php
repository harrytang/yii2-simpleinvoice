<?php
use harrytang\simpleinvoice\SimpleinvoiceModule;

/* @var $invoice \harrytang\simpleinvoice\models\Invoice */

?>
<?= SimpleinvoiceModule::t("Hi {CONTACT},", ['CONTACT'=>$invoice->contact]) ?>
<br/>
<br/>
<?= SimpleinvoiceModule::t("To help you keep track of your order, we're sending you this order update.") ?>
<br/><br/>
<?= $changes ?>
<br/>
<br/>
<b><?= SimpleinvoiceModule::t("Shipping Status:") ?></b>
<br/>
<?php foreach ($invoice->getItems() as $i => $item): ?>
- <?= SimpleinvoiceModule::t('{Q}kg {ITEM}: {S}kg shipped', ['Q'=>Yii::$app->formatter->asDecimal($item['quantity']), 'ITEM'=>$item['product'], 'S'=>Yii::$app->formatter->asDecimal($item['shipped'])]) ?><br/>
<?php endforeach;?>
<br/>
<br/>
<?= SimpleinvoiceModule::t("You can also view the latest order updates and details here: {INVOICE_URL}.", ['INVOICE_URL'=>$invoice->getUrl()]) ?>
<br/>
<br/>
<?= SimpleinvoiceModule::t("Thank you for choosing our product.") ?>
<br/>
<br/>
<?= SimpleinvoiceModule::t("Best regards,") ?>
<br/>
Harry Tang<br/>
www.vietplastic.com