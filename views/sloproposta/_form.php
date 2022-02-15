<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SloProposta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slo-proposta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tipo')->dropDownList([ 'express' => 'Express', 'personalizada' => 'Personalizada', 'Credpago' => 'Credpago', 'Seguro Fiança' => 'Seguro Fiança', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'prazo_responder')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'proprietario')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'proprietario_info')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'codigo_imovel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imovel_info')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'imovel_valores')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'opcoes')->dropDownList([ '0', '1', '2', '3', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'usuario_id')->textInput() ?>

    <?= $form->field($model, 'tipo_imovel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'motivo_locacao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'endereco')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'complemento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bairro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cidade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cep')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dormitorios')->textInput() ?>

    <?= $form->field($model, 'aluguel')->textInput() ?>

    <?= $form->field($model, 'iptu')->textInput() ?>

    <?= $form->field($model, 'condominio')->textInput() ?>

    <?= $form->field($model, 'agua')->textInput() ?>

    <?= $form->field($model, 'luz')->textInput() ?>

    <?= $form->field($model, 'gas_encanado')->textInput() ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'numero')->textInput() ?>

    <?= $form->field($model, 'atvc_empresa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'atvc_cnpj')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'atvc_nome_fantasia')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'atvc_atividade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'atvc_data_constituicao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'atvc_contato')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'atvc_telefone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_inicio')->textInput() ?>

    <?= $form->field($model, 'id_slogica')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'etapa_andamento')->textInput() ?>

    <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_nascimento')->textInput() ?>

    <?= $form->field($model, 'cpf')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'documento_tipo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'documento_numero')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'documento_orgao_emissor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'documento_data_emissao')->textInput() ?>

    <?= $form->field($model, 'nacionalidade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefone_residencial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefone_celular')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'profissao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vinculo_empregaticio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_admissao')->textInput() ?>

    <?= $form->field($model, 'renda')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'naoLocalizado')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado_civil')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'condicao_do_imovel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'conj_nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'conj_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'conj_cpf')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'conj_documento_tipo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'conj_documento_numero')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'conj_nacionalidade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'conj_data_nascimento')->textInput() ?>

    <?= $form->field($model, 'conj_telefone_celular')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'conj_profissao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'conj_renda')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'conj_num_dependentes')->textInput() ?>

    <?= $form->field($model, 'conj_frente')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'conj_verso')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'frente')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'verso')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'proponentes')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
