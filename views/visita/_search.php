<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VisitaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visita-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idvisita') ?>

    <?= $form->field($model, 'usuario_id') ?>

    <?= $form->field($model, 'data_registro') ?>

    <?= $form->field($model, 'data_visita') ?>

    <?= $form->field($model, 'hora_visita') ?>

    <?php // echo $form->field($model, 'id_corretor') ?>

    <?php // echo $form->field($model, 'codigo_imovel') ?>

    <?php // echo $form->field($model, 'nome_cliente') ?>

    <?php // echo $form->field($model, 'imobiliaria_parceria') ?>

    <?php // echo $form->field($model, 'observacoes') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
