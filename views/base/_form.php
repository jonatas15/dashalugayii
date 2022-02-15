<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Base */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="base-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-4">
    <?= $form->field($model, 'codigo',['addon' => ['prepend' => ['content'=>'PIN - ']]])->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'valor',['addon' => ['prepend' => ['content'=>'R$']]])->textInput(['type' => 'number','step'=>"0.01"]) ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'logradouro')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'numero_apartamento')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'numero_box')->textInput(['maxlength' => true]) ?>
    </div>

    <?php //= $form->field($model, 'proprietario_id')->textInput() ?>

    <div class="col-md-12">
    <div class="form-group">
    <hr>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Salvar') : Yii::t('app', 'Atualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
