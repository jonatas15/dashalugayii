<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CorretorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="corretor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idcorretor') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'observacoes') ?>

    <?= $form->field($model, 'foto') ?>

    <?= $form->field($model, 'cor') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
