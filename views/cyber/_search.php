<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CyberSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cyber-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idcyber') ?>

    <?= $form->field($model, 'usuario_id') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'descricao') ?>

    <?= $form->field($model, 'cor') ?>

    <?php // echo $form->field($model, 'palavraschaves') ?>

    <?php // echo $form->field($model, 'cybercol') ?>

    <?php // echo $form->field($model, 'datetime') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
