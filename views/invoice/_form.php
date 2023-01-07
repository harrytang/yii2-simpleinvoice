<?php

use harrytang\simpleinvoice\models\Invoice;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model harrytang\simpleinvoice\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-form">

    <?php $form = ActiveForm::begin([
        'options'=>['enctype'=>'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'currency')->dropDownList(['VND'=>'VND']) ?>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'sold_to')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ship_to')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'payment_methods')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'payment_status')->dropDownList(Invoice::getPaymentStatusOption(), ['prompt'=>'']) ?>

    <?= $form->field($model, 'shipping_carrier')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'shipping_status')->dropDownList(Invoice::getShippingStatusOption(), ['prompt'=>'']) ?>

    <?= $form->field($model, 'details')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList(Invoice::getStatusOption()) ?>

    <div class="row">
        <div class="col-sm-2">
            <?php if($model->invoice_pdf!=null):?>
                <div><span class="label label-success">Invoice-<?= $model->getIdWithSeparator() ?>.pdf</span></div>
            <?php endif;?>
            <?= $form->field($model, 'invoice_pdf_file')->fileInput() ?>
        </div>
        <div class="col-sm-2">
                <?php if($model->proof_of_shipment!=null):?>
                    <div><?= Html::img('data:image/jpeg;base64,'.base64_encode($model->proof_of_shipment), ['title'=>'Proof of shipment', 'class'=>'img-responsive']) ?></div>
                <?php endif;?>
            <?= $form->field($model, 'proof_of_shipment_file')->fileInput() ?>
        </div>
        <div class="col-sm-8">
            <div class="row">
                <div class="col-sm-4">
                    <?php if($model->img_1!=null):?>
                        <div><?= Html::img('data:image/jpeg;base64,'.base64_encode($model->img_1), ['title'=>'Picture 1', 'class'=>'img-responsive']) ?></div>
                    <?php endif;?>
                    <?= $form->field($model, 'img_1_file')->fileInput() ?>
                </div>
                <div class="col-sm-4">
                    <?php if($model->img_2!=null):?>
                        <div><?= Html::img('data:image/jpeg;base64,'.base64_encode($model->img_2), ['title'=>'Picture 2', 'class'=>'img-responsive']) ?></div>
                    <?php endif;?>
                    <?= $form->field($model, 'img_2_file')->fileInput() ?>
                </div>
                <div class="col-sm-4">
                    <?php if($model->img_3!=null):?>
                        <div><?= Html::img('data:image/jpeg;base64,'.base64_encode($model->img_3), ['title'=>'Picture 3', 'class'=>'img-responsive']) ?></div>
                    <?php endif;?>
                    <?= $form->field($model, 'img_3_file')->fileInput() ?>
                </div>
            </div>
        </div>
    </div>




    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('simpleinvoice', 'Create') : Yii::t('simpleinvoice', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
