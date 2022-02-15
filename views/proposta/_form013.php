<?php

use yii\helpers\Html;
use yii\widgets\MaskedInput;
use kartik\form\ActiveForm;
// use kartik\widgets\DatePicker;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\SloProposta */
/* @var $form yii\widgets\ActiveForm */
$script_campos_valores = '
    salario = $("#sloinfosprofissionais-salario");
    if(salario.val()=="") { 
        salario.val("0"); 
    }
    salario2 = parseFloat(salario.val().replace(/\D/g,""));

    outrosrendimentos = $("#sloinfosprofissionais-outros_rendimentos");
    if(outrosrendimentos.val()=="") { 
        outrosrendimentos.val("0"); 
    }
    outrosrendimentos2 = parseFloat(outrosrendimentos.val().replace(/\D/g,""));
    
    valor_total = $("#sloinfosprofissionais-total_rendimentos");                        
    valor_total.val(salario2+outrosrendimentos2);
';
?>
<?php

    $dats = str_split($model2->cpf,3);
    $dados_anteriores .= 'Cpf: '.$dats[0].'.'.$dats[1].'.'.$dats[2].'-'.$dats[3]."\n";
    $dados_anteriores .= 'Data de Nacimento: ' . date('d/m/Y', strtotime($model2->data_nascimento))."\n";
    $dados_anteriores .= 'Email: ' . $model2->email."\n";

    $dats = str_split($conjuge->cpf,3);
    $dados_conjuje .= 'Cpf: '.$dats[0].'.'.$dats[1].'.'.$dats[2].'-'.$dats[3]."\n";
    $dados_conjuje .= 'Data de Nacimento: ' . date('d/m/Y', strtotime($conjuge->data_nascimento))."\n";
    $dados_conjuje .= 'Email: ' . $conjuge->email."\n";
?>
<div class="slo-proposta-form">
    <a class="btn btn-primary btn-destaque" href="<?= Yii::$app->homeUrl.'proposta/pretendente001?form=001&id='.$model2->id .'&pretendente_id='.$pretendente_id.'&proposta_id='.$proposta_id ?>"><i class="fas fa-angle-double-left"></i> Voltar ao Início</a>
    <h4 class="titulo">5 - Cônjuge: Dados Profissionais <sup><span class="badge badge-primary"> 1/1 </span></sup>
        <br><sub title="<?=$dados_anteriores?>"> <strong>Pretendente:</strong> <?=$model2->nome?></sub>
        <br class="aparece-mobile"><sub title="<?=$dados_conjuje?>"> <strong>Cônjuje:</strong> <?=$conjuge->nome?></sub>
    </h4>
    <hr>
    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-4 hidden">
        <?= $form->field($model, 'pretendente_id')->textInput(['value'=>$pretendente_id]) ?>
    </div>
    <div class="col-md-8">
        <?= $form->field($model, 'empresa')->textInput(); ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'fone')->widget(MaskedInput::className(), [
            'mask' => '(99) 9999-9999',
            'options'=>[
                // 'onfocus'=> '$(this).key',
                // 'pattern'=>"[0-9]*",
                'inputmode'=>"numeric",
                'class'=>"form-control",
            ]
        ]) ?>
    </div>
    <div class="col-md-8">
        <?= $form->field($model, 'profissao')->textInput(); ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'data_admissao')->widget(MaskedInput::className(), [
            'clientOptions' => [
                'alias' =>  'dd/mm/yyyy',
                'placeholder' => 'dd/mm/aaaa',
            ],
            'options'=>[
                // 'onfocus'=> '$(this).key',
                // 'pattern'=>"[0-9]*",
                'onmouseover' => '$(this).attr("placeholder","dd/mm/aaaa")',
                'inputmode'=>"numeric",
                'class'=>"form-control",
                'value'=> $model->data_admissao ? date('d/m/Y',strtotime($model->data_admissao)):'',
            ]
        ]) ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'vinculo_empregaticio')->dropDownList([ 'Aposentado / Pensionista' => 'Aposentado / Pensionista', 'Funcionário com Registro CLT' => 'Funcionário com Registro CLT', 'Autônomo' => 'Autônomo', 'Empresário' => 'Empresário', 'Profissional Liberal' => 'Profissional Liberal', 'Estudante' => 'Estudante', 'Funcionário Público' => 'Funcionário Público', 'Renda Proveniente de Aluguéis' => 'Renda Proveniente de Aluguéis', ], ['prompt' => '']) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'salario',['addon' => ['prepend' => ['content'=>'R$']]])->widget(MaskedInput::className(), [
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
                'onblur'=> $script_campos_valores,
                'onkeyup'=> $script_campos_valores,
            ]
        ]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'outros_rendimentos',['addon' => ['prepend' => ['content'=>'R$']]])->widget(MaskedInput::className(), [
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
                    'onblur'=> $script_campos_valores,
                    'onkeyup'=> $script_campos_valores,
                ]
            ]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'total_rendimentos', ['addon' => ['prepend' => ['content'=>'R$']]])->widget(MaskedInput::className(), [
                'clientOptions' => [
                    'alias' =>  'integer',
                    'autoGroup' => true,
                    'groupSeparator' => ".",
                ],
                'options'=>[
                    // 'pattern'=>"[0-9]*",
                    'inputmode'=>"numeric",
                    'class'=>"form-control",
                ],
            ]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'possui_renda')->widget(SwitchInput::classname(), [
          'pluginOptions' => [
            'onText' => 'SIM',
            'offText' => 'Não',
            'onColor' => 'success',
            'offColor' => 'warning',
          ],
        ]); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'compoe_renda')->widget(SwitchInput::classname(), [
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
