<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\widgets\FileInput;
// use kartik\widgets\DatePicker;
// use kartik\widgets\SwitchInput;
use yii\widgets\MaskedInput;
use kartik\widgets\SwitchInput;
use yii\bootstrap\Collapse;

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

?>
<style type="text/css">
    .list-group-item{
        height: 90px !important;
    }
    /* .collapse-toggle:after{
        content: '(Clique para ver mais) \f078';
        font-family: FontAwesome;
        font-style: normal;
        font-weight: normal;
        text-decoration: inherit;
        margin-left:5px;
        color:black;
    } */
</style>
<div class="slo-proposta-form">
    <div class="">
        <a class="btn btn-primary btn-destaque" href="<?= Yii::$app->homeUrl.'proposta/pretendente001?form=001&id='.$model2->id.'&pretendente_id='.$pretendente_id.'&proposta_id='.$proposta_id ?>"><i class="fas fa-angle-double-left"></i>  Voltar para as informações Pessoais</a>
        <h4 class="titulo">3 - Informações Profissionais <sup><span class="badge badge-primary"> 1/1 </span></sup>
            <br><sub title="<?=$dados_anteriores?>"> <strong>Pretendente:</strong> <?=$model2->nome?></sub>
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
                    'inputmode'=>"numeric",
                    'class'=>"form-control",
                    'value'=> $model->data_admissao ? date('d/m/Y',strtotime($model->data_admissao)):'',
                ]
            ]) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'vinculo_empregaticio')->dropDownList([
                'Aposentado / Pensionista' => 'Aposentado / Pensionista',
                'Funcionário com Registro CLT' => 'Funcionário com Registro CLT',
                'Autônomo' => 'Autônomo',
                'Empresário' => 'Empresário',
                'Profissional Liberal' => 'Profissional Liberal',
                'Estudante' => 'Estudante',
                'Funcionário Público' => 'Funcionário Público',
                'Renda Proveniente de Aluguéis' => 'Renda Proveniente de Aluguéis',
            ], [
                'prompt' => '',
                'onChange' => 'if($(this).val() == "Empresário"){
                    $("#empresario_div").show();
                }else{
                     $("#empresario_div").hide();
                }',
            ]) ?>
        </div>
        <div class="col-md-12" id="empresario_div" style="display: none">
            <?= $form->field($model, 'cnpj')->widget(MaskedInput::className(), [
                //'mask' => '999.999.999-99',
                'mask' => '99.999.999/9999-99',
                'options'=>[
                    // 'onfocus'=> '$(this).key',
                    // 'pattern'=> "[0-9]*",
                    'inputmode'=>"numeric",
                    'class'=>"form-control"
                ]
            ]) ?>
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
            <?= $form->field($model, 'total_rendimentos',['addon' => ['prepend' => ['content'=>'R$']]])->widget(MaskedInput::className(), [
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
        <div class="clearfix"></div>
        <hr>
        <h4>Emprego Anterior:</h4>
        <div class="emprego_anterior">

            <?php
            echo '<div class="col-md-8">'.$form->field($model, 'empganterior_empresa')->textInput().'</div>'.
                                '<div class="col-md-4">'.$form->field($model, 'empganterior_fone')->widget(MaskedInput::className(), [
                                    'mask' => '(99) 9999-9999',
                                    'options'=>[
                                        'inputmode'=>"numeric",
                                        'class'=>"form-control",
                                    ]
                                ]).'</div>'.
                                '<div class="col-md-12 clearfix"><br></div>',
                                //segunda linha
                                '<div class="col-md-9">'.$form->field($model, 'empganterior_endereco')->textInput().'</div>'.
                                '<div class="col-md-3">'.$form->field($model, 'empganterior_end_numero')->textInput().'</div>',
                                //terceira linha
                                '<div class="col-md-4">'.$form->field($model, 'empganterior_end_complemento')->textInput().'</div>'.
                                '<div class="col-md-8">'.$form->field($model, 'empganterior_end_bairro')->textInput().'</div>',
                                //quarta linha
                                '<div class="col-md-6">'.$form->field($model, 'empganterior_end_cidade')->textInput().'</div>'.
                                '<div class="col-md-2">'.$form->field($model, 'empganterior_end_estado')->textInput().'</div>'.
                                '<div class="col-md-4">'.$form->field($model, 'empganterior_end_cep')->widget(MaskedInput::className(), [
                                    'mask' => '99999-999',
                                    'options'=>[
                                        // 'onfocus'=> '$(this).key',
                                        // 'pattern'=>"[0-9]*",
                                        'inputmode'=>"numeric",
                                        'class'=>"form-control",
                                    ]
                                ]).'</div>';
            /* Usando o Collapse
                echo Collapse::widget([
                    'items' => [
                        [
                            'label' => 'Emprego Anterior ',
                            'content' => [
                                //primeira linha
                                '<div class="col-md-8">'.$form->field($model, 'empganterior_empresa')->textInput().'</div>'.
                                '<div class="col-md-4">'.$form->field($model, 'empganterior_fone')->widget(MaskedInput::className(), [
                                    'mask' => '(99) 9999-9999',
                                    'options'=>[
                                        'inputmode'=>"numeric",
                                        'class'=>"form-control",
                                    ]
                                ]).'</div>'.
                                '<div class="col-md-12 clearfix"><br></div>',
                                //segunda linha
                                '<div class="col-md-9">'.$form->field($model, 'empganterior_endereco')->textInput().'</div>'.
                                '<div class="col-md-3">'.$form->field($model, 'empganterior_end_numero')->textInput().'</div>',
                                //terceira linha
                                '<div class="col-md-4">'.$form->field($model, 'empganterior_end_complemento')->textInput().'</div>'.
                                '<div class="col-md-8">'.$form->field($model, 'empganterior_end_bairro')->textInput().'</div>',
                                //quarta linha
                                '<div class="col-md-6">'.$form->field($model, 'empganterior_end_cidade')->textInput().'</div>'.
                                '<div class="col-md-2">'.$form->field($model, 'empganterior_end_estado')->textInput().'</div>'.
                                '<div class="col-md-4">'.$form->field($model, 'empganterior_end_cep')->widget(MaskedInput::className(), [
                                    'mask' => '99999-999',
                                    'options'=>[
                                        // 'onfocus'=> '$(this).key',
                                        // 'pattern'=>"[0-9]*",
                                        'inputmode'=>"numeric",
                                        'class'=>"form-control",
                                    ]
                                ]).'</div>',
                            ],
                            'contentOptions' => ['class'=>'off'],
                            'options' => [],
                            //'footer' => 'Footer' // the footer label in list-group
                        ],
                    ]
                ]);
            */
            ?>
        </div>

        <div class="col-md-12">
            <div class="form-group float-right">
                <?= Html::submitButton('CONTINUAR  <i class="fas fa-angle-double-right"></i>', ['class' => 'btn btn-primary btn-destaque', 'style'=>'font-weight: bolder']) ?>
            </div>
        </div>


        <?php ActiveForm::end(); ?>
    </div>
</div>
