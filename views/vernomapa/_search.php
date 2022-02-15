<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VernomapaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vernomapa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'thumb') ?>

    <?= $form->field($model, 'codigo') ?>

    <?= $form->field($model, 'logradouro') ?>

    <?= $form->field($model, 'bairro') ?>

    <?php // echo $form->field($model, 'cidade') ?>

    <?php // echo $form->field($model, 'contrato') ?>

    <?php // echo $form->field($model, 'valor_venda') ?>

    <?php // echo $form->field($model, 'valor_locacao') ?>

    <?php // echo $form->field($model, 'data') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
