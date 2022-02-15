<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ImobiliariasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="imobiliarias-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'sitemap') ?>

    <?= $form->field($model, 'data_cadastro') ?>

    <?php // echo $form->field($model, 'data_alteracao') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
