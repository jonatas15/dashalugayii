<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CybercomentarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cyber-comentario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idcyber_comentario') ?>

    <?= $form->field($model, 'usuario_id') ?>

    <?= $form->field($model, 'cyber_topico_idtopico') ?>

    <?= $form->field($model, 'cyber_idcyber') ?>

    <?= $form->field($model, 'comentario') ?>

    <?php // echo $form->field($model, 'datetime') ?>

    <?php // echo $form->field($model, 'imagem') ?>

    <?php // echo $form->field($model, 'documento') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
