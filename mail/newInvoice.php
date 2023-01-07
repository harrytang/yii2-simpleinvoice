<?php
use harrytang\simpleinvoice\SimpleinvoiceModule;
use \yii\helpers\Html;

/* @var $invoice \harrytang\simpleinvoice\models\Invoice */
$total=0;
$pageCount=1;
$size=5000;
$days=0;

?>
<b><?= SimpleinvoiceModule::t("You've received an invoice.") ?></b>
<br/><br/>
<?= SimpleinvoiceModule::t("Hello {CONTACT},", ['CONTACT' => $invoice->contact]) ?>
<br/><br/>
<?= SimpleinvoiceModule::t("We just sent you an invoice for your order.") ?>
<br/><br/>
<?= SimpleinvoiceModule::t("To view the invoice, click {INVOICE_URL}", [
    'INVOICE_URL' => Html::a('here', $invoice->getUrl())
]) ?>
<br/>
<?= SimpleinvoiceModule::t("or visit {INVOICE_URL}", [
    'INVOICE_URL' => $invoice->getUrl()
]) ?>
<br/>
<br/>
<b><?= SimpleinvoiceModule::t("Delivery estimate:") ?></b>
<br/>
<?php foreach ($invoice->getItems() as $i => $item): ?>
    <?php
        $total=$item['quantity'];
        $pageCount=ceil($item['quantity']/$size);
        $quantity=$item['quantity'];
    ?>
    <?php for($i=0;$i<$pageCount;$i++):?>
        <?php
            $quantity=$quantity<=$size?$quantity:$size;
            $days+=ceil($quantity/715);
        ?>
- <?= $quantity ?>kg <?= $item['product'] ?>: <?= Yii::$app->formatter->asDate(mktime(12, 12, 12, date('m', $invoice->created_at), date('d', $invoice->created_at)+$days, date('Y', $invoice->created_at))) ?><br/>
        <?php $quantity=$item['quantity']-$quantity; ?>
    <?php endfor;?>
<?php endforeach;?>
<br/>
<br/>
<?= SimpleinvoiceModule::t("If you need more information please feel free to contact us. Thank you!") ?>
<br/>
<br/>
<?= SimpleinvoiceModule::t("Best regards,") ?>
<br/>
Harry Tang
<br />
www.vietplastic.com