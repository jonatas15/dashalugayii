<?php

use yii\helpers\Html;
use yii\widgets\MaskedInput;
use kartik\form\ActiveForm;
// use kartik\widgets\DatePicker;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\SloProposta */
/* @var $form yii\widgets\ActiveForm */
?>
<?php

    $dats = str_split($model2->cpf,3);
    $dados_anteriores .= 'Cpf: '.$dats[0].'.'.$dats[1].'.'.$dats[2].'-'.$dats[3]."\n";
    $dados_anteriores .= 'Data de Nacimento: ' . date('d/m/Y', strtotime($model2->data_nascimento))."\n";
    $dados_anteriores .= 'Email: ' . $model2->email."\n";
?>
<div class="slo-proposta-form">
    <a class="btn btn-primary btn-destaque" href="<?= Yii::$app->homeUrl.'proposta/pretendente001?form=001&id='.$model2->id.'&pretendente_id='.$pretendente_id.'&proposta_id='.$proposta_id ?>"><i class="fas fa-angle-double-left"></i> Voltar ao Início</a>
    <h4 class="titulo">4 - Cônjuge: Dados Pessoais <sup><span class="badge badge-primary"> 1/2 </span></sup>
        <br><sub title="<?=$dados_anteriores?>"> <strong>Pretendente:</strong> <?=$model2->nome?></sub>
    </h4>
    <hr>
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-4 hidden">
        <?= $form->field($model, 'pretendente_id')->textInput(['value'=>$pretendente_id]) ?>
        <?= $form->field($model, 'conjuje_id')->textInput() ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'cpf')->widget(MaskedInput::className(), [
            'mask' => '999.999.999-99',
            'options'=>[
                // 'onfocus'=> '$(this).key',
                // 'pattern'=>"[0-9]*",
                'inputmode'=>"numeric",
                'class'=>"form-control",
            ]
        ]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'data_nascimento')->widget(MaskedInput::className(), [
            'clientOptions' => [
                'alias' =>  'dd/mm/yyyy',
                'placeholder' => 'dd/mm/aaaa',
            ],
            'options'=>[
                    // 'onfocus'=> '$(this).key',
                    // 'pattern'=>"[0-9]*",
                    'inputmode'=>"numeric",
                    'class'=>"form-control",
                    'value'=> $model->data_nascimento ? date('d/m/Y',strtotime($model->data_nascimento)):'',
                ]
        ]) ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'fone_residencial')->widget(MaskedInput::className(), [
            'mask' => '(99) 9999-9999',
            'options'=>[
                // 'onfocus'=> '$(this).key',
                // 'pattern'=>"[0-9]*",
                'inputmode'=>"numeric",
                'class'=>"form-control",
            ]
        ]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'celular')->widget(MaskedInput::className(), [
            'mask' => '(99) 9 9999-9999',
            'options'=>[
                    // 'onfocus'=> '$(this).key',
                    // 'pattern'=>"[0-9]*",
                    'inputmode'=>"numeric",
                    'class'=>"form-control",
                ]
        ]) ?>
    </div>
    <div class="col-md-4">
      <?= $form->field($model, 'genero')->dropDownList([ 'M' => 'Masculino', 'F' => 'Feminino', ], ['prompt' => '']) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'estado_civil')->dropDownList([
                'solteiro' => 'Solteiro', 
                'casado' => 'Casado', 
                // 'desquitado' => 'Desquitado', 
                'divorciado' => 'Divorciado', 
                // 'separado' => 'Separado', 
                // 'amasiado' => 'Amasiado', 
                'viúvo' => 'Viúvo',
                'união estável' => 'União Estável' 
            ], ['prompt' => '']) ?>
    </div>
    <div class="col-md-4">
      <?= $form->field($model, 'emancipado')->widget(SwitchInput::classname(), [
            'pluginOptions' => [
              'onText' => 'SIM',
              'offText' => 'Não',
              'onColor' => 'success',
              'offColor' => 'warning',
            ],
          ]); ?>
    </div>
    <div class="col-md-12">
        <div class="form-group float-right">
            <?= Html::submitButton('CONTINUAR  <i class="fas fa-angle-double-right"></i>', ['class' => 'btn btn-primary btn-destaque', 'style'=>'font-weight: bolder']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
