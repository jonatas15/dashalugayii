<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VisitchavesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="visitchaves-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'usuario_id') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'nome_cliente') ?>

    <?= $form->field($model, 'tipovisitante') ?>

    <?php // echo $form->field($model, 'codigo_imovel') ?>

    <?php // echo $form->field($model, 'dthr_retirada') ?>

    <?php // echo $form->field($model, 'dthr_entrega') ?>

    <?php // echo $form->field($model, 'data_visita') ?>

    <?php // echo $form->field($model, 'hora_visita') ?>

    <?php // echo $form->field($model, 'feedbacks') ?>

    <?php // echo $form->field($model, 'mensagem') ?>

    <?php // echo $form->field($model, 'num_disparo') ?>

    <?php // echo $form->field($model, 'convertido_venda') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
