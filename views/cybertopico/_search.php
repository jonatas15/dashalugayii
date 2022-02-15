<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CybertopicoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cyber-topico-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idtopico') ?>

    <?= $form->field($model, 'cyber_idcyber') ?>

    <?= $form->field($model, 'usuario_id') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'tipo') ?>

    <?php // echo $form->field($model, 'descricao') ?>

    <?php // echo $form->field($model, 'palavraschaves') ?>

    <?php // echo $form->field($model, 'imagem') ?>

    <?php // echo $form->field($model, 'documento') ?>

    <?php // echo $form->field($model, 'datetime') ?>

    <?php // echo $form->field($model, 'topico_pai') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
