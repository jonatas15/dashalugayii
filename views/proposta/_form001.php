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

<div class="slo-proposta-form">
    <div class="">
        <?php $form = ActiveForm::begin(); ?>
        <h4 class="titulo">1 - Informações Pessoais <sup><span class="badge badge-primary"> 1/2 </span></sup>
        <?php if(!empty($model->nome)): ?>
            <br><sub title="<?= $dados_anteriores ?>"> <strong>Pretendente:</strong> <?=$model->nome?></sub>
        <?php endif; ?>
        </h4>
        <hr>
        <div class="col-md-4 hidden">
            <?= $form->field($model, 'pretendente_id')->textInput(['value'=>$pretendente_id]) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'cpf')->widget(MaskedInput::className(), [
                'mask' => '999.999.999-99',
                'options'=>[
                    // 'onfocus'=> '$(this).key',
                    // 'pattern'=> "[0-9]*",
                    'inputmode'=>"numeric",
                    'class'=>"form-control"
                ]
            ]) ?>
        </div>
        
        <?php /*
        <div class="col-md-12">
            <?php //= $form->field($model, 'data_nascimento')->textInput(['value'=>'2000-12-11']) ?>
            <div class="form-group field-visita-id_corretor has-success">
                <?php
                  echo '<label class="control-label">Data</label>';
                  echo DatePicker::widget([
                    'language'=>'pt',
                    'name' => 'Proposta[data_nascimento]',
                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                    'value' => '',
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'dd-mm-yyyy'
                    ],
                    'options' => [
                        'style'=> 'border-left: 0px'
                    ],
                  ]);
                ?>
                <div class="help-block"></div>
            </div>
        </div>
        */ ?>
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
                    'value'=> $model->data_nascimento !='' ? date('d/m/Y',strtotime($model->data_nascimento)):'',
                ]
            ]) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'fone_residencial')->widget(
                MaskedInput::className(), [
                    'mask' => '(99) 9999-9999',
                    'options'=>[
                        // 'onfocus'=> '$(this).key',
                        // 'pattern'=>"[0-9]*",
                        'inputmode'=>"numeric",
                        'class'=>"form-control"
                    ]
            ]) ?>
            <?php 
            // use kartik\number\NumberControl;

            // // Normal decimal
            // echo NumberControl::widget([
            //     'name' => 'normal-decimal',
            //     'value' => 43829.39,
            //     'htmlOptions'=>['type' => 'tel']
            // ]);

            ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'celular')->widget(MaskedInput::className(), [
                'mask' => '(99) 9 9999-9999',
                'options'=>[
                    // 'onfocus'=> '$(this).key',
                    // 'pattern'=>"[0-9]*",
                    'inputmode'=>"numeric",
                    'class'=>"form-control"
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
                <?= Html::submitButton('CONTINUAR  <i class="fas fa-angle-double-right"></i>', [
                    'class' => 'btn btn-primary btn-destaque', 
                    'style'=>'font-weight: bolder'
                ]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
