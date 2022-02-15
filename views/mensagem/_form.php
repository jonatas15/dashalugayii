<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Mensagem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mensagem-form">

    <?php $form = ActiveForm::begin([
        'action' => ['mensagem/ajax-comment','ativo'=>$ativo],
        'options' => [
            'class' => 'comment-form'
        ]
    ]); ?>

    <?= $form->field($model, 'texto')->textarea(['rows' => 5])->label('Nova Mensagem') ?>
    <div class="hidden">
        
    <?= $form->field($model, 'data')->textInput(['value'=>date('Y-m-d H:i:s')]) ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true, 'value' => $_SERVER['REMOTE_ADDR']]) ?>

    <?= $form->field($model, 'proposta_id')->textInput(['value'=>$proposta_id]) ?>

    <?= $form->field($model, 'usuario_id')->textInput(['value' => ($usuario_id)]) ?>

    <?= $form->field($model, 'imagem')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Enviar' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary','id'=>'bota-submit-nisso']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
