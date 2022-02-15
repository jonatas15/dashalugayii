<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Proprietario;

/* @var $this yii\web\View */
/* @var $model app\models\Locatario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="locatario-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-lg-6">
    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'contato')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'inicio_da_locacao')->textInput() ?>
    
    </div>
    <div class="col-lg-6">
    <?= $form->field($model, 'logradouro')->textInput(['maxlength' => true]) ?>
    </div>
    
    <div class="col-lg-2">
        <?= $form->field($model, 'codigo_do_imovel')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-2">
        <?= $form->field($model, 'numero_do_apartamento')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-2">
        <?= $form->field($model, 'numero_do_box')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-lg-6">
    <?= $form->field($model, 'cpf')->textInput() ?>
    </div>
    <div class="col-lg-6" style="display:none">
    <?= $form->field($model, 'usuario_id')->textInput() ?>
    </div>
    <div class="col-lg-12">
    <?= $form->field($model, 'mais_informacoes')->textarea(['rows' => 6]) ?>
    </div>

    <?php //= $form->field($model, 'proprietario_id')->textInput() ?>

    <div class="col-md-12">
        <hr>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Salvar') : Yii::t('app', 'Atualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','style'=>'float:right']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
