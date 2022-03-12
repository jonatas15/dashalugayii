<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Proprietario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proprietario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

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

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
