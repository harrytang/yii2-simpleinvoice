<?php

use harrytang\simpleinvoice\models\Invoice;
use harrytang\simpleinvoice\SimpleinvoiceModule;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel harrytang\simpleinvoice\models\search\Invoice */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = SimpleinvoiceModule::t('Invoices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="simpleinvoice-invoice-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div><hr /></div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('simpleinvoice', 'Create {modelClass}', [
    'modelClass' => 'Invoice',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="bg-white">
    <?php Pjax::begin() ?>
    <?= GridView::widget([
        'options'=>['class'=>'grid-view table-responsive'],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'email:email',
            //'contact',
            'sold_to:ntext',
            //'ship_to:ntext',
            //'created_at:date',
            //'payment_methods',
            ['attribute'=>'payment_status', 'value'=>function($model){return $model->getPaymentStatusText();}, 'filter'=> Invoice::getPaymentStatusOption()],
            ['attribute'=>'shipping_status', 'value'=>function($model){return $model->getShippingStatusText();}, 'filter'=> Invoice::getShippingStatusOption()],
            ['label'=>'Total', 'value'=>function($model){return $model->getTotal();}, 'filter'=> null, 'format'=>'currency'],
            ['attribute'=>'created_at', 'value'=>'created_at', 'filter'=> false, 'format'=>'date'],
            //'payment_status',
            // 'shipping_carrier',
            // 'shipping_status',
            // 'details:ntext',
            // 'status',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
    </div>
</div>
