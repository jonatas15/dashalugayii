<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LeadSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="lead-search col-md-6">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'class' => ""
    ]); ?>

        <?php //= $form->field($model, 'id') ?>
        <div class="col-md-6">
            <?= $form->field($model, 'titulo') ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'descricao') ?>
            <?php //= $form->field($model, 'data') ?>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?= Html::submitButton('Pesquisar', ['class' => 'btn btn-primary']) ?>
                <?php //= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

    </div>
</div>
