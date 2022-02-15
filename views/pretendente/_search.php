<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PretendenteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slo-pretendente-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'proposta_id') ?>

    <?= $form->field($model, 'morar_com_quem') ?>

    <?= $form->field($model, 'animais_extimacao') ?>

    <?= $form->field($model, 'apresentacao') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
