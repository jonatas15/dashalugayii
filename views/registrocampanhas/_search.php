<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RegistrocampanhasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="registrocampanhas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fonte') ?>

    <?= $form->field($model, 'utm_medium') ?>

    <?= $form->field($model, 'utm_source') ?>

    <?= $form->field($model, 'utm_campaign') ?>

    <?php // echo $form->field($model, 'data') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'obs') ?>

    <?php // echo $form->field($model, 'formulario') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
