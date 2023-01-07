<?php

use harrytang\simpleinvoice\models\Invoice;
use harrytang\simpleinvoice\SimpleinvoiceModule;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $sum [] */
/* @var $items [] */
/* @var $model harrytang\simpleinvoice\models\Invoice */

$this->title = SimpleinvoiceModule::t('Invoice-{ID}', ['ID'=>$model->getIdWithSeparator()]);
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex, nofollow, nosnippet, noodp, noarchive, noimageindex']);

?>
<div class="simpleinvoice-invoice-view">

    <div class="vp-brand visible-print-block"><span class="brand">V</span>iet<span class="brand">P</span>lastic</div>
    <div style="font-size: 1.6em"><?= SimpleinvoiceModule::t('Invoice Receipt') ?></div>

    <div>
        <hr/>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <div><b><?= SimpleinvoiceModule::t('Order Number') ?>:</b></div>
            <div><?= $model->getIdWithSeparator() ?></div>
        </div>
        <div class="col-xs-6">
            <div><b><?= SimpleinvoiceModule::t('Order Date') ?>:</b></div>
            <div><?= Yii::$app->formatter->asDate($model->created_at) ?></div>
        </div>
    </div>

    <div><br/></div>

    <div class="row">
        <div class="col-xs-6">
            <div><b><?= $model->getAttributeLabel('sold_to') ?>:</b></div>
            <div><?= Yii::$app->formatter->asNtext($model->sold_to) ?></div>
            <?php if(Yii::$app->user->can('staff')):?>
            <div class="hidden-print"><?= Yii::$app->formatter->asNtext($model->email) ?></div>
            <?php endif;?>
        </div>
        <div class="col-xs-6">
            <div><b><?= $model->getAttributeLabel('ship_to') ?>:</b></div>
            <div><?= Yii::$app->formatter->asNtext($model->ship_to) ?></div>
        </div>
    </div>

    <div><br/></div>

    <div class="row">
        <div class="col-xs-6">
            <div><b><?= $model->getAttributeLabel('payment_status') ?>:</b></div>
            <div>
                <?= $model->getPaymentStatusText() ?>
                <?php if ($model->payment_status== Invoice::PAYMENT_STATUS_PAID && !empty($model->payment_date)): ?>
                    &nbsp;(<?= Yii::$app->formatter->asDate($model->payment_date) ?>)
                <?php endif; ?>
            </div>
        </div>
        <div class="col-xs-6">
            <div><b><?= $model->getAttributeLabel('shipping_carrier') ?>:</b></div>
            <div>
                <?php if ($model->shipping_status== Invoice::SHIPPING_STATUS_SHIPPED): ?>
                    <?= SimpleinvoiceModule::t('Shipped to ') ?>
                <?php endif; ?>
                <?= $model->shipping_carrier ?>
                <?php if ($model->shipping_status== Invoice::SHIPPING_STATUS_SHIPPED && !empty($model->shipping_date)): ?>
                    <?= SimpleinvoiceModule::t(' on {DATE}', ['DATE'=>Yii::$app->formatter->asDate($model->shipping_date)]) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div><br/></div>

    <div><b><?= SimpleinvoiceModule::t('Order Details') ?>:</b></div>
    <div class="bg-white table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <td>#</td>
                <td><?= SimpleinvoiceModule::t('Product') ?></td>
                <td><?= SimpleinvoiceModule::t('Price') ?></td>
                <td><?= SimpleinvoiceModule::t('Quantity Ordered') ?></td>
                <td><?= SimpleinvoiceModule::t('Quantity Shipped') ?></td>
                <td><?= SimpleinvoiceModule::t('Extended Price') ?></td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $i => $item): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $item['product'] ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($item['price'], $model->currency) ?></td>
                    <td><?= Yii::$app->formatter->asDecimal($item['quantity']) ?></td>
                    <td><?= Yii::$app->formatter->asDecimal($item['shipped']) ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($item['extended_price'], $model->currency) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="5" class="text-right">
                    <?= SimpleinvoiceModule::t('Subtotal') ?><br/>
                    <?= SimpleinvoiceModule::t('Sales Tax') ?><br/>
                    <b><?= SimpleinvoiceModule::t('Total') ?></b>
                </td>
                <td colspan="1" class="">
                    <?= Yii::$app->formatter->asCurrency($sum['subtotal'], $model->currency) ?><br/>
                    <?= Yii::$app->formatter->asCurrency($sum['tax'], $model->currency) ?><br/>
                    <b><?= Yii::$app->formatter->asCurrency($sum['total'], $model->currency) ?></b>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
  
    <div><p><?= SimpleinvoiceModule::t('Please arrange payment to this phone number: <b>0903 806 123</b>, thank you!') ?></p></div>

    <?php if (Yii::$app->user->can('staff')): ?>
        <div class="hidden-print margin-top-lg">
            <?= Html::a(SimpleinvoiceModule::t('Update'), Yii::$app->urlManager->createUrl(['simpleinvoice/invoice/update', 'id'=>$model->id]), ['class' => 'btn btn-primary']) ?>
            <?= Html::a(SimpleinvoiceModule::t('Email'), Yii::$app->urlManager->createUrl(['simpleinvoice/invoice/email', 'id'=>$model->id]), ['class' => 'btn btn-success', 'data-confirm'=>'Sending email?']) ?>
        </div>
    <?php endif; ?>

</div>
