<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Proprietario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proprietario-form col-md-12">

    <?php $form = ActiveForm::begin([
        'action' => ['proprietario/'.$action],
        'options' => [
        ]
    ]); ?>
    <div class="col-md-8">
        <div class="col-md-12"><?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-6"><?= $form->field($model, 'celular')->widget(MaskedInput::className(), [
            'mask' => '(99) 99999-9999',
            'options'=>[
                // 'onfocus'=> '$(this).key',
                // 'pattern'=>"[0-9]*",
                'inputmode'=>"numeric",
                'class'=>"form-control"
            ]
        ]) ?></div>
        <div class="col-md-6"><?= $form->field($model, 'telefone')->widget(MaskedInput::className(), [
            'mask' => '(99) 9999-9999',
            'options'=>[
                // 'onfocus'=> '$(this).key',
                // 'pattern'=>"[0-9]*",
                'inputmode'=>"numeric",
                'class'=>"form-control"
            ]
        ]) ?></div>
        <div class="col-md-12"><?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-6"><?= $form->field($model, 'cpf_cnpj')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-6"><?= $form->field($model, 'conta_deposito')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-12"><?= $form->field($model, 'usuario_id')->hiddenInput(['value'=>Yii::$app->user->identity->id])->label(false) ?></div>
        <div class="col-md-12"><?= $form->field($model, 'orgao')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-6"><?= $form->field($model, 'rg')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-6"><?= $form->field($model, 'sexo')->dropDownList([ 'M' => 'Masculino', 'F' => 'Feminino', 'I' => 'Outros', ], ['prompt' => '']) ?></div>
        <div class="col-md-6"><?= $form->field($model, 'data_nascimento')->widget(MaskedInput::className(), [
            'clientOptions' => [
                'alias' =>  'dd/mm/yyyy',
                'placeholder' => 'dd/mm/aaaa',
            ],
            'options'=>[
                // 'onfocus'=> '$(this).key',
                // 'pattern'=>"[0-9]*",
                'inputmode'=>"numeric",
                'class'=>"form-control",
                'value'=> $model->data_nascimento !='' ? date('d/m/Y',strtotime($model->data_nascimento)):'',
            ]
        ]) ?></div>
        <div class="col-md-6"><?= $form->field($model, 'nacionalidade')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-12">
            <?= $form->field($model, 'mais_informacoes')->textarea(['rows' => 6]) ?>
        </div>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'codigo_imovel',['addon' => ['prepend' => ['content'=>'PIN']]])->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'inicio_locacao')->widget(MaskedInput::className(), [
            'clientOptions' => [
                'alias' =>  'dd/mm/yyyy',
                'placeholder' => 'dd/mm/aaaa',
            ],
            'options'=>[
                // 'onfocus'=> '$(this).key',
                // 'pattern'=>"[0-9]*",
                'inputmode'=>"numeric",
                'class'=>"form-control",
                'value'=> $model->inicio_locacao !='' ? date('d/m/Y',strtotime($model->inicio_locacao)):'',
            ]
        ]) ?>
        <?= $form->field($model, 'endereco')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'logradouro')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'complemento')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'cep')->widget(MaskedInput::className(), [
            'mask' => '99999-999',
            'options' => [
                // 'onfocus'=> '$(this).key',
                // 'pattern'=>"[0-9]*",
                'inputmode'=>"numeric",
                'class'=>"form-control"
            ]
        ]) ?>
        <?= $form->field($model, 'bairro')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'cidade')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'estado')->textInput(['maxlength' => true]) ?>
    </div>
    





    <?= $form->field($model, 'proposta_id')->hiddenInput([
        'value' => $proposta
    ])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar Informações', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<div class="clearfix"></div>
