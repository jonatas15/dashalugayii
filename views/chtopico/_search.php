<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ChtopicoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chtopico-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'conteudo') ?>

    <?= $form->field($model, 'checked') ?>

    <?= $form->field($model, 'checklist_id') ?>

    <?= $form->field($model, 'topico_pai') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
