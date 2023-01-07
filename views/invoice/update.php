<?php

use harrytang\simpleinvoice\SimpleinvoiceModule;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model harrytang\simpleinvoice\models\Invoice */

$this->title = Yii::t('simpleinvoice', 'Update {modelClass}: ', [
    'modelClass' => 'Invoice',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => SimpleinvoiceModule::t('Invoices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getIdWithSeparator(), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = SimpleinvoiceModule::t('Update')
?>
<div class="simpleinvoice-invoice-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <div><hr /></div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
