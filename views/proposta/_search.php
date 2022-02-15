<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PropostaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slo-proposta-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tipo') ?>

    <?= $form->field($model, 'prazo_responder') ?>

    <?= $form->field($model, 'proprietario') ?>

    <?= $form->field($model, 'proprietario_info') ?>

    <?php // echo $form->field($model, 'imovel_info') ?>

    <?php // echo $form->field($model, 'imovel_valores') ?>

    <?php // echo $form->field($model, 'opcoes') ?>

    <?php // echo $form->field($model, 'usuario_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
