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
<style type="text/css">
    .caso_locacao{
        display: none;
    }
</style>
<div class="slo-proposta-form">
    <a class="btn btn-primary btn-destaque" href="<?= Yii::$app->homeUrl.'proposta/pretendente001?form=001&id='.$model2->id .'&pretendente_id='.$pretendente_id.'&proposta_id='.$proposta_id ?>"><i class="fas fa-angle-double-left"></i> Voltar ao Início</a>
    <h4 class="titulo"><?= 5 + $se_casado ?> - Residência Atual <sup><span class="badge badge-primary"> 1/1 </span></sup>
        <br><sub title="<?=$dados_anteriores?>"> <strong>Pretendente:</strong> <?=$model2->nome?></sub>
    </h4>
    <hr>
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-4 hidden">
        <?= $form->field($model, 'slo_pretendente_id')->textInput(['value'=>$pretendente_id]) ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'endereco')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'numero')->textInput(['maxlength' => true,'type' => 'number']) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'complemento')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'cep')->widget(MaskedInput::className(), [
            'mask' => '99999-999',
            'options'=>[
                // 'onfocus'=> '$(this).key',
                // 'pattern'=>"[0-9]*",
                'inputmode'=>"numeric",
                'class'=>"form-control",
            ]
        ]) ?>
    </div>
    <div class="col-md-7">
        <?= $form->field($model, 'bairro')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'cidade')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'uf')->textInput(['maxlength' => true])->label('Estado') ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'residencia_atual')->dropDownList([ 
                'Alugada' => 'Alugada', 
                'Financiada' => 'Financiada', 
                'Hotel ou Flat' => 'Hotel ou Flat', 
                'Própria' => 'Própria', 
            ], 
            [
                'prompt' => '',
                'onChange' => 'if($(this).val() == "Alugada"){
                    $(".caso_locacao").show();
                }else{
                    $(".caso_locacao").hide();
                }'
            ]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'em_nome_de')->dropDownList([ 
                'Amigos' => 'Amigos', 
                'Pretendente' => 'Pretendente', 
                'Familiares' => 'Familiares', 
                'da Empresa' => 'Da Empresa', 
            ], 
            ['prompt' => '']
        )->label('Em nome de:') ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'tempo_residencia')->dropDownList([ 
            'menos de 1 ano' => 'Menos de 1 ano', 
            '1 a 2 anos' => '1 a 2 anos', 
            '3 a 4 anos' => '3 a 4 anos', 
            '5 a 6 anos' => '5 a 6 anos', 
            '7 a 9 anos' => '7 a 9 anos', 
            'Acima de 10 anos' => 'Acima de 10 anos', 
        ], ['prompt' => '']) ?>
    </div>
    <div class="col-md-8 caso_locacao">
        <?= $form->field($model, 'locador_nome')->textInput() ?>
    </div>
    <div class="col-md-4 caso_locacao">
        <?= $form->field($model, 'locador_fone')->widget(
                MaskedInput::className(), [
                    'mask' => '(99) 9999-9999',
                    'options'=>[
                        // 'onfocus'=> '$(this).key',
                        // 'pattern'=>"[0-9]*",
                        'inputmode'=>"numeric",
                        'class'=>"form-control"
                    ]
            ]) ?>
    </div>
    <div class="col-md-12">
        <?php
        /*= $form->field($model, 'paga_aluguel')->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'onText' => 'SIM',
                'offText' => 'Não',
                'onColor' => 'success',
                'offColor' => 'warning',
            ],
          ])->label('Arca com Aluguel?');*/ 
        ?>
    </div>
    <div class="col-md-12"><hr></div>
    <h4 class="col-md-12">Gastos Residenciais</h4>
    <div class="col-md-12"><hr></div>
    <div class="col-md-4">
        <?php $model->gastoatual_agua = (int)$model->gastoatual_agua; ?>
        <?= $form->field($model, 'gastoatual_agua',['addon' => ['prepend' => ['content'=>'R$']]])->widget(MaskedInput::className(), [
          'clientOptions' => [
              'alias' =>  'integer',
              'autoGroup' => true,
              'groupSeparator' => ".",
          ],
          'options'=>[
              // 'onfocus'=> '$(this).key',
              // 'pattern'=>"[0-9]*",
              'inputmode'=>"numeric",
              'class'=>"form-control",
          ]
        ]) ?>
    </div>
    <div class="col-md-4">
        <?php $model->gastoatual_luz = (int)$model->gastoatual_luz; ?>
        <?= $form->field($model, 'gastoatual_luz',['addon' => ['prepend' => ['content'=>'R$']]])->widget(MaskedInput::className(), [
          'clientOptions' => [
              'alias' =>  'integer',
              'autoGroup' => true,
              'groupSeparator' => ".",
          ],
          'options'=>[
              // 'onfocus'=> '$(this).key',
              // 'pattern'=>"[0-9]*",
              'inputmode'=>"numeric",
              'class'=>"form-control",
          ]
        ]) ?>
    </div>
    <div class="col-md-4">
        <?php $model->gastoatual_gas = (int)$model->gastoatual_gas; ?>
        <?= $form->field($model, 'gastoatual_gas',['addon' => ['prepend' => ['content'=>'R$']]])->widget(MaskedInput::className(), [
          'clientOptions' => [
              'alias' =>  'integer',
              'autoGroup' => true,
              'groupSeparator' => ".",
          ],
          'options'=>[
              // 'onfocus'=> '$(this).key',
              // 'pattern'=>"[0-9]*",
              'inputmode'=>"numeric",
              'class'=>"form-control",
          ]
        ]) ?>
    </div>
    

    <div class="col-md-4">
        <?= $form->field($model, 'outros_imoveis_alugados')->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'onText' => 'SIM',
                'offText' => 'Não',
                'onColor' => 'success',
                'offColor' => 'warning',
            ],
          ]); ?>
    </div>
    <div class="col-md-8">
        <?= $form->field($model, 'outros_ia_aluguel_encargos')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-12"></div>
    <div class="col-md-4">
        <?= $form->field($model, 'bens_financiados_emprestimos')->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'onText' => 'SIM',
                'offText' => 'Não',
                'onColor' => 'success',
                'offColor' => 'warning',
            ],
          ]); ?>
    </div>
    <div class="col-md-8">
        <?= $form->field($model, 'bens_fe_nome_valor')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-12"></div>
    <div class="col-md-4">
        <?= $form->field($model, 'dependente_com_doenca')->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'onText' => 'SIM',
                'offText' => 'Não',
                'onColor' => 'success',
                'offColor' => 'warning',
            ],
        ]); ?>
    </div>
    <div class="col-md-8">
        <?= $form->field($model, 'dependente_doente_infos')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-12"></div>
    <div class="col-md-4">
        <?= $form->field($model, 'dependentes_estudantes')->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'onText' => 'SIM',
                'offText' => 'Não',
                'onColor' => 'success',
                'offColor' => 'warning',
            ],
        ]); ?>
    </div>
    <div class="col-md-8">
        <?= $form->field($model, 'dependentes_estudantes_info')->textInput(['maxlength' => true]) ?>
    </div>
    
    <img src="" alt="">


    
    <div class="col-md-12">
        <div class="form-group float-right">
            <?= Html::submitButton('CONTINUAR  <i class="fas fa-angle-double-right"></i>', ['class' => 'btn btn-primary btn-destaque', 'style'=>'font-weight: bolder']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    <?php $this->registerJs("$('#sloinfosprofissionais-salario').css('text-align','left')"); ?>
</div>
