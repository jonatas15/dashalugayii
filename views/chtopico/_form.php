<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Chtopico */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chtopico-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'conteudo')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'checked')->textInput() ?>

    <?= $form->field($model, 'checklist_id')->textInput() ?>

    <?= $form->field($model, 'topico_pai')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
