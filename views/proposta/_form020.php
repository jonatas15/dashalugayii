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
<style media="screen">
  h4 {
    font-weight: bolder;
  }
</style>
<?php
  $script_campos_valores = '
      salario = $("#slofiador-salario");
      if(salario.val()=="") {
          salario.val("0");
      }
      salario2 = parseFloat(salario.val().replace(/\D/g,""));

      outrosrendimentos = $("#slofiador-outros_rendimentos");
      if(outrosrendimentos.val()=="") {
          outrosrendimentos.val("0");
      }
      outrosrendimentos2 = parseFloat(outrosrendimentos.val().replace(/\D/g,""));

      valor_total = $("#slofiador-total_rendimentos");
      valor_total.val(salario2+outrosrendimentos2);
  ';
?>
<div class="slo-proposta-form">
    <?php if ($model->id == ''):?>
        <a class="btn btn-primary btn-destaque" href="<?= Yii::$app->homeUrl.'proposta/pretendente001?form=0016&id='.$model2->id.'&iddoc='.$model->id .'&pretendente_id='.$pretendente_id.'&proposta_id='.$proposta_id ?>"><i class="fas fa-angle-double-left"></i> Voltar</a>
        <h4 class="titulo">Cadastro de Fiadores/Proponentes do Imóvel <sup><span class="badge badge-primary"> 1/1 </span></sup>
            <br><sub title=""> <strong>Pretendente:</strong> <?=$model2->nome?></sub>
        </h4>
        <hr>
    <?php endif;?>
    <div style = 'text-align: center'>

        <p>Você precisa cadastrar dados básicos de todos os fiadores/proponentes de sua proposta</p>
        <?php $form_prev = ActiveForm::begin(); ?>
        <?php
        $data_gar = [
          'Fiador' => 'Fiador',
          'Seguro-Fiança' => 'Seguro-Fiança',
          'CredPago' => 'CredPago',
          'Título de Capitalização' => 'Título de Capitalização',
        ];

        echo $form_prev->field($model2->pretendente, 'tipo_fiador')->radioButtonGroup($data_gar,[
          'id' => 'tipofiador',
          'name' => 'tipofiador',
          'onChange'=>'
              var valore = $("input[name=\'tipofiador\']:checked").val();
              console.log(valore);
              if (valore == "Seguro-Fiança" || valore == "Fiador"){
                  $("#bota-novo-fiador-modal").show();

                  $("#slofiador-tipo_fiador").val(valore);
                  if(valore == "Seguro-Fiança"){
                    a_ser_cadastrado = "Proponente";
                  }else{
                    a_ser_cadastrado = "Fiador";
                  }
                  $("#botao-do-fiador").html(" Cadastrar novo "+a_ser_cadastrado)
              } else {
                  $("#bota-novo-fiador-modal").hide();
              }
          ',
        ])->label("Processo de Locação?");
        ?>
        <?php ActiveForm::end(); ?>
        <?php

            yii\bootstrap\Modal::begin([
                'header' => '<h3>Cadastrar Novo Fiador/Proponente</h3>',
                'size' => 'modal-lg',
                'toggleButton' => [
                    'label' => '<i class="fas fa-plus"></i> <span id="botao-do-fiador"> Cadastrar Novo Fiador/Proponente</span>',
                    'class' => 'btn btn-primary',
                    'id' => 'bota-novo-fiador-modal',
                    'style' => 'display: none'
                ],
            ]);
        ?>
        <div style="text-align: left">
            <?php $form = ActiveForm::begin(); ?>
            <div class="col-md-12">
                <div class="col-md-4 hidden">
                    <?= $form->field($model, 'pretendente_id')->textInput(['value'=>$pretendente_id]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'tipo_fiador')->textInput() ?>
                    <?php //= $form->field($model, 'tipo_fiador')->dropDownList([ 'Fiador' => 'Fiador', 'Seguro-Fiança' => 'Seguro-Fiança' ], ['prompt' => '']) ?>
                </div>
                <div class="col-md-12">
                  <h4>Informações Pessoais</h4>
                  <hr>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
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
                        ]
                    ]) ?>
                </div>
                <div class="col-md-3">
                  <?= $form->field($model, 'genero')->dropDownList([ 'M' => 'Masculino', 'F' => 'Feminino', ], ['prompt' => '']) ?>
                </div>
                <div class="col-md-3">
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
                <div class="col-md-3">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
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
                </div>
                <div class="col-md-3">
                  <?= $form->field($model, 'celular')->widget(
                      MaskedInput::className(), [
                          'mask' => '(99) 9 9999-9999',
                          'options'=>[
                              // 'onfocus'=> '$(this).key',
                              // 'pattern'=>"[0-9]*",
                              'inputmode'=>"numeric",
                              'class'=>"form-control"
                          ]
                  ]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'estado_civil')->dropDownList([
                        'solteiro' => 'Solteiro',
                        'casado' => 'Casado',
                        // 'desquitado' => 'Desquitado',
                        'divorciado' => 'Divorciado',
                        // 'separado' => 'Separado',
                        // 'amasiado' => 'Amasiado',
                        'viúvo' => 'Viúvo',
                        'união estável' => 'União Estável'
                    ],
                    [
                        'prompt' => '',
                        'onChange'=> 'if ($(this).val() == "casado") {
                            $("#div-fiador-conjuge").show();
                        } else {
                            $("#div-fiador-conjuge").hide();
                        }'
                    ]) ?>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                  <h4>Documentação do Fiador (add Arquivos na etapa "Comprovantes")</h4>
                  <hr>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'tipo_documento')->dropDownList([ 'RG' => 'RG', 'RNE' => 'RNE', 'CNH' => 'CNH', 'Doc de Classe' => 'Doc de Classe', ], ['prompt' => '']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'numero')->textInput(['maxlength' => true,'type'=>'number']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'data_expedicao')->widget(MaskedInput::className(), [
                        'clientOptions' => [
                            'alias' =>  'dd/mm/yyyy',
                            'placeholder' => 'dd/mm/aaaa',
                        ],
                        'options'=>[
                            // 'onfocus'=> '$(this).key',
                            // 'pattern'=>"[0-9]*",
                            'inputmode'=>"numeric",
                            'class'=>"form-control",
                        ]
                    ]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'orgao_expedidor')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-12">
                  <h4>Informações Profissionais</h4>
                  <hr>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'empresa')->textInput(['maxlength' => true]) ?>
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
                <div class="col-md-7">
                    <?= $form->field($model, 'profissao')->textInput(); ?>
                </div>
                <div class="col-md-5">
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
            </div>
            <div class="col-md-12" id="div-fiador-conjuge" style="display: none">
                <div class="col-md-12">
                  <h4>Cônjuge do Fiador Informações Pessoais</h4>
                  <hr>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'cj_nome')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'cj_data_nascimento')->widget(MaskedInput::className(), [
                        'clientOptions' => [
                            'alias' =>  'dd/mm/yyyy',
                            'placeholder' => 'dd/mm/aaaa',
                        ],
                        'options'=>[
                            // 'onfocus'=> '$(this).key',
                            // 'pattern'=>"[0-9]*",
                            'inputmode'=>"numeric",
                            'class'=>"form-control",
                        ]
                    ]) ?>
                </div>
                <div class="col-md-3">
                  <?= $form->field($model, 'cj_genero')->dropDownList([ 'M' => 'Masculino', 'F' => 'Feminino', ], ['prompt' => '']) ?>
                </div>
                <div class="col-md-3">
                  <?= $form->field($model, 'cj_cpf')->widget(MaskedInput::className(), [
                    'mask' => '999.999.999-99',
                    'options'=>[
                      // 'onfocus'=> '$(this).key',
                      // 'pattern'=>"[0-9]*",
                      'inputmode'=>"numeric",
                      'class'=>"form-control",
                    ]
                    ]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'cj_email')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                  <?= $form->field($model, 'cj_fone_residencial')->widget(
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
                <div class="col-md-3">
                  <?= $form->field($model, 'cj_celular')->widget(
                      MaskedInput::className(), [
                          'mask' => '(99) 9 9999-9999',
                          'options'=>[
                              // 'onfocus'=> '$(this).key',
                              // 'pattern'=>"[0-9]*",
                              'inputmode'=>"numeric",
                              'class'=>"form-control"
                          ]
                  ]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'cj_estado_civil')->dropDownList([
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
            </div>

            <img src="" alt="">
            <div class="col-md-12">
                <div class="form-group float-right">
                    <?= Html::submitButton('<i class="fas fa-plus"></i> Adicionar Fiador/Proponente', ['class' => 'btn btn-primary btn-destaque', 'style'=>'font-weight: bolder']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="clearfix"></div>

        <?php yii\bootstrap\Modal::end(); ?>
    </div>
    <hr>
</div>
