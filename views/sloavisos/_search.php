<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SloavisosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sloavisos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'etapa') ?>

    <?= $form->field($model, 'situacao') ?>

    <?= $form->field($model, 'whats') ?>

    <?= $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'outro') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
