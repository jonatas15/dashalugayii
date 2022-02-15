<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HistoricodedisparosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="historicodedisparos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'data') ?>

    <?= $form->field($model, 'mensagem') ?>

    <?= $form->field($model, 'proposta_id') ?>

    <?= $form->field($model, 'usuario_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
