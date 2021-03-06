<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuariopermutas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuariopermutas-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-6">

    <?= $form->field($model, 'permuta')->textInput() ?>

    <?= $form->field($model, 'usuario')->textInput() ?>
    </div>
    <div class="col-md-6">

    <?= $form->field($model, 'observacoes')->textarea(['rows' => 6]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
