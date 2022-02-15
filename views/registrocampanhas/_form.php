<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Registrocampanhas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="registrocampanhas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fonte')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'utm_medium')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'utm_source')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'utm_campaign')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data')->textInput() ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'obs')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'formulario')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
