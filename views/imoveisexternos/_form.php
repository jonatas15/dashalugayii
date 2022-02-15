<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\SwitchInput;

use app\models\Imobiliarias;

/* @var $this yii\web\View */
/* @var $model app\models\Imoveisexternos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="imoveisexternos-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-12">
        <div class="col-md-3">
        <?= $form->field($model, 'imobiliarias_id')->dropDownList(ArrayHelper::map(Imobiliarias::find()->asArray()->all(), 'id','nome')) ?>
        </div>
        <div class="col-md-9">
        <?= $form->field($model, 'url_imovel')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'tipo')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'contrato')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
        <?= $form->field($model, 'valor_venda')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
        <?= $form->field($model, 'valor_locacao')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-5">
        <?= $form->field($model, 'endereco_estado')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-7">
        <?= $form->field($model, 'endereco_cidade')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
        <?= $form->field($model, 'endereco_bairro')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
        <?= $form->field($model, 'endereco_logradouro')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'dormitorios')->textInput() ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'banheiros')->textInput() ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'garagens')->textInput() ?>
        </div>
        <div class="col-md-3">
            <div class="col-md-6">
            <?php //= $form->field($model, 'elevador')->textInput() ?>
            <?= $form->field($model, 'elevador')->widget(SwitchInput::classname(), ['pluginOptions' => ['onText' => 'Sim','offText' => 'Não',]]) ?>
            </div>
            <div class="col-md-6">
            <?= $form->field($model, 'sacada')->widget(SwitchInput::classname(), ['pluginOptions' => ['onText' => 'Sim','offText' => 'Não',]]) ?>
            </div>
        </div>
        <div class="col-md-3">
        <?= $form->field($model, 'area_privativa')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
        <?= $form->field($model, 'area_total')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
        <?= $form->field($model, 'comodidades')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-6">
        <?= $form->field($model, 'condominio')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'financiavel')->textInput() ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'negociavel')->textInput() ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'aceita_permuta')->textInput() ?>
        </div>
        <div class="col-md-12">
        <?= $form->field($model, 'observacoes')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'data_cadastro')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'data_alteracao')->hiddenInput()->label(false) ?>
        </div>
    </div>
    <div class="form-group col-md-12">
        <hr>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
