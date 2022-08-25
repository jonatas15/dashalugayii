<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Proprietario */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .control-label {
        font-size: 14px !important;
        /* line-height: 1 !important; */
        /* margin-bottom: 15px !important; */
        position: relative !important;
        top: 0 !important;
    }
    .bmd-label-static {
        line-height: 1 !important;
        position: relative !important;
        top: 0 !important;
    }
    select.form-control {
        height: calc(3rem + 2px) !important;
    }
    /* .col-md-6 {
        border: 1px solid red !important;
        margin: -1px !important;
    } */
    /* .col-md-8, .col-md-4 {
        padding: 3% !important;
    } */
</style>
<div class="proprietario-form">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin([
            'action' => ['proprietario/create'],
            'options' => [
                'id' => 'formulario-pra-proposta-tal'
            ]
        ]); ?>
        <!-- Principais Informações -->
        <div class="col-md-12">
            <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?php $model->sexo = 'M'; ?>
            <?= $form->field($model, 'sexo')->dropDownList([ 'M' => 'Masculino', 'F' => 'Feminino', 'I' => 'Indefinido', ], ['prompt' => '']) ?>
        </div>
        <div class="col-md-4">
            <?php $model->estado_civil = 'Solteiro'; ?>
            <?= $form->field($model, 'estado_civil')->dropDownList([
                'Solteiro' => 'Solteiro',
                'Casado' => 'Casado',
                'Divorciado' => 'Divorciado', 
                'Viúvo' => 'Viúvo', 
                'Separado' => 'Separado', 
                'União estável' => 'União estável'
            ], ['prompt' => '']);
            ?>
        </div>
        <div class="col-md-4">
            <?php $model->documento_tipo = 'Identidade'; ?>
            <?= $form->field($model, 'documento_tipo')->dropDownList([
                'Identidade' => 'Identidade',
                'CNH' => 'CNH',
                'Carteira profissional' => 'Carteira profissional', 
            ], 
            ['prompt' => '']);
            ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'documento_numero')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'cpf_cnpj')->widget(MaskedInput::className(), [
                'mask' => ['999.999.999-99', '99.999.999/9999-99']
            ]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'celular')->widget(MaskedInput::className(), [
                'mask' => '(99) 99999-9999',
            ]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'data_nascimento')->widget(MaskedInput::className(), [
                'clientOptions' => ['alias' =>  'date']
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'nacionalidade')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'logradouro')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'endereco')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'bairro')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'cidade')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'estado')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'codigo_imovel')->textInput(['maxlength' => true, 'value' => $codigo]) ?>
        </div>
        <div class="hidden">
            <?= $form->field($model, 'cpf')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'usuario_id')->textInput(['value' => Yii::$app->user->identity->id]) ?>
            <?= $form->field($model, 'superlogica')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'nome_fantasia')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'inicio_locacao')->textInput() ?>
            <?= $form->field($model, 'mais_informacoes')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'telefone')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'rg')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'orgao')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'cep')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'complemento')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'proposta_id')->textInput() ?>
            <?= $form->field($model, 'foto_rg')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'foto_cpf')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'cnj_num_dependentes')->textInput(['maxlength' => true]) ?>
        </div>
        <!-- Dados Bancários -->
        <div class="col-md-6">
            <?= $form->field($model, 'conta_deposito')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'banco')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'agencia')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'operacao')->dropDownList([
                'Corrente' => 'Corrente',
                'Poupança' => 'Poupança'
            ], 
            ['prompt' => '']); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'nome_titular')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'cpf_titular')->widget(MaskedInput::className(), [
                'mask' => '999.999.999-99'
            ]) ?>
        </div>
        <!-- Dados Imovel -->
        <div class="col-md-6">
            <?= $form->field($model, 'iptu')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'condominio')->textInput() ?>
        </div>
        <!-- Cônjuge -->
        <div class="hidden">
            <?= $form->field($model, 'cnj_nome')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'cnj_email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'cnj_cpf')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'cnj_documento_numero')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'cnj_nacionalidade')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'cnj_data_nascimento')->textInput() ?>
            <?= $form->field($model, 'cnj_telefone_celular')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'cnj_profissao')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'cnj_foto_rg')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'cnj_foto_cpf')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'cnj_documento_tipo')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
