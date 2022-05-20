<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Sloavisos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sloavisos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'etapa')->textInput() ?>

    <?= $form->field($model, 'situacao')->textInput() ?>

    <?= $form->field($model, 'whats')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'email')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'outro')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
