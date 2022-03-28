<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Proprietario */
/* @var $form yii\widgets\ActiveForm */

/**
 * Fotos do, RG e CPF,  matrícula do imóvel, Condomínio, IPTU e conta para depósito.
 */
?>

<div class="col-md-12 proprietario-form">

    <?php //$form = ActiveForm::begin(); ?>
    <!-- $tabela, $campo, $title, $valor, $id, $conj = null -->
    <!-- VAI na SUPERLÓGICA -->
    <h3>Campos que vão para o Superlógica</h3><hr>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'nome', 'Nome', $model->nome, $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'nome_fantasia', 'Nome Fantasia', $model->nome_fantasia, $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'cpf_cnpj', 'CPF/CNPJ', $model->cpf_cnpj, $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'celular', 'Celular', $model->celular, $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'telefone', 'Telefone Residencial', $model->telefone, $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'email', 'Email', $model->email, $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'rg', 'Identidade (RG)', $model->rg, $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'orgao', 'Órgão Expedidor', $model->orgao, $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'sexo', 'Sexo', $model->sexo, $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'data_nascimento', 'Data de Nascimento', date('d/m/Y',strtotime($model->data_nascimento)), $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'nacionalidade', 'Nacionalidade', $model->nacionalidade, $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'cep', 'Cep', $model->cep, $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'endereco', 'Endereço', $model->endereco, $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'bairro', 'Bairro', $model->bairro, $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'cidade', 'Cidade', $model->cidade, $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'estado', 'Estado', $model->estado, $model->id); ?>
    <?= $this->context->imprime_campo_editavel('12', 'Proprietario', 'mais_informacoes', 'Observações', $model->mais_informacoes, $model->id); ?>
    <!-- Não vai na SUPERLÓGICA -->
    <h3>Campos de Registro Local</h3><hr>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'codigo_imovel', 'Código do Imóvel', $model->codigo_imovel, $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'inicio_locacao', 'Início da Locação', date('d/m/Y',strtotime($model->inicio_locacao)), $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'condominio', 'Condomínio', $model->condominio, $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'iptu', 'IPTU', $model->iptu, $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'conta_deposito', 'Conta p/ depósito', $model->conta_deposito, $model->id); ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'cpf', 'CPF', $model->cpf, $model->id); ?>
    <?php /*
    <div class="hidden">
        <?= $form->field($model, 'conta_deposito')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'codigo_imovel')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'logradouro')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'inicio_locacao')->textInput() ?>

        <?= $form->field($model, 'mais_informacoes')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'celular')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'telefone')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'cpf_cnpj')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'usuario_id')->textInput() ?>

        <?= $form->field($model, 'rg')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'orgao')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'sexo')->dropDownList([ 'M' => 'M', 'F' => 'F', 'I' => 'I', ], ['prompt' => '']) ?>

        <?= $form->field($model, 'data_nascimento')->textInput() ?>

        <?= $form->field($model, 'nacionalidade')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'cep')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'endereco')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'complemento')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'bairro')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'cidade')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'estado')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'proposta_id')->textInput() ?>

        <?= $form->field($model, 'iptu')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'condominio')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'foto_rg')->textInput() ?>

        <?= $form->field($model, 'foto_cpf')->textInput() ?>
    </div>
    <div class="col-md-12">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>
    <?php */
    // echo 'Imagel: ';
    ?>
    <div class="clearfix"></div>
    <div class="col-md-6" style="text-align: center">
        <h4><strong>RG</strong></h4>
        <?= Html::img('@web/uploads/_file_rg_proprietario_'.$model->codigo_imovel.'_'.$model->foto_rg, [
            'alt' => 'RG',
            'style' => 'width: 100%; border: 1px solid lightgray;'
        ]); ?>
    </div>
    <div class="col-md-6" style="text-align: center">
        <h4><strong>CPF</strong></h4>
        <?= Html::img('@web/uploads/_file_cpf_proprietario_'.$model->codigo_imovel.'_'.$model->foto_cpf, [
            'alt' => 'RG',
            'style' => 'width: 100%; border: 1px solid lightgray;'
        ]); ?>
    </div>
    <?php //ActiveForm::end(); ?>

</div>
<div class="clearfix"></div>