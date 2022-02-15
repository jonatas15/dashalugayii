<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SloagendaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slo-agenda-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'usuario_id') ?>

    <?= $form->field($model, 'slo_cliente_id') ?>

    <?= $form->field($model, 'corretor_idcorretor') ?>

    <?= $form->field($model, 'data') ?>

    <?php // echo $form->field($model, 'turno') ?>

    <?php // echo $form->field($model, 'hora') ?>

    <?php // echo $form->field($model, 'mais_informacoes') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
