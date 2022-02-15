<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BaseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="base-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'codigo') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'valor') ?>

    <?= $form->field($model, 'logradouro') ?>

    <?php // echo $form->field($model, 'numero_apartamento') ?>

    <?php // echo $form->field($model, 'numero_box') ?>

    <?php // echo $form->field($model, 'proprietario_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
