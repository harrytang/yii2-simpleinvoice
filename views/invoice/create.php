<?php

use harrytang\simpleinvoice\SimpleinvoiceModule;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model harrytang\simpleinvoice\models\Invoice */

$this->title = SimpleinvoiceModule::t('New Invoice');
$this->params['breadcrumbs'][] = ['label' => SimpleinvoiceModule::t('Invoices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simpleinvoice-invoice-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <div><hr /></div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
