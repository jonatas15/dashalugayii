<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ExtratoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="extrato-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'mes') ?>

    <?= $form->field($model, 'data_aplicacao') ?>

    <?= $form->field($model, 'data_vencimento') ?>

    <?= $form->field($model, 'receita_locacao') ?>

    <?php // echo $form->field($model, 'receitas_subtotal') ?>

    <?php // echo $form->field($model, 'iptu') ?>

    <?php // echo $form->field($model, 'iptu_apt_garag') ?>

    <?php // echo $form->field($model, 'condominio') ?>

    <?php // echo $form->field($model, 'taxa_condominio') ?>

    <?php // echo $form->field($model, 'outros') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'nosso_numero') ?>

    <?php // echo $form->field($model, 'numero_nota') ?>

    <?php // echo $form->field($model, 'honorarios_porcentagem') ?>

    <?php // echo $form->field($model, 'honorarios_valor') ?>

    <?php // echo $form->field($model, 'honorarios_admin') ?>

    <?php // echo $form->field($model, 'descontos_subtotal') ?>

    <?php // echo $form->field($model, 'total_depositado') ?>

    <?php // echo $form->field($model, 'descricao_descontos') ?>

    <?php // echo $form->field($model, 'valor_pago_ao_proprietario') ?>

    <?php // echo $form->field($model, 'data_pagamento') ?>

    <?php // echo $form->field($model, 'locatario_id') ?>

    <?php // echo $form->field($model, 'proprietario_id') ?>

    <?php // echo $form->field($model, 'base_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
