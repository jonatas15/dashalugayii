<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ClientesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clientes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'setor') ?>

    <?= $form->field($model, 'cargo') ?>

    <?= $form->field($model, 'cpf') ?>

    <?= $form->field($model, 'nome') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'proventos') ?>

    <?php // echo $form->field($model, 'fone1') ?>

    <?php // echo $form->field($model, 'fone2') ?>

    <?php // echo $form->field($model, 'clientescol') ?>

    <?php // echo $form->field($model, 'corretor') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
