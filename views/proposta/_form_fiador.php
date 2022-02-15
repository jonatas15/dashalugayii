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
      salario = $("#salario_'.$model->id.'");
      if(salario.val()=="") {
          salario.val("0");
      }
      salario2 = parseFloat(salario.val().replace(/\D/g,""));

      outrosrendimentos = $("#outros_rendimentos_'.$model->id.'");
      if(outrosrendimentos.val()=="") {
          outrosrendimentos.val("0");
      }
      outrosrendimentos2 = parseFloat(outrosrendimentos.val().replace(/\D/g,""));

      valor_total = $("#total_rendimentos_'.$model->id.'");
      valor_total.val(salario2+outrosrendimentos2);
  ';

  # PESSOAIS Retornar valores das Informações Pessoais
  $model->nome = $model->sloInfospessoais->nome;
  $model->data_nascimento = $model->sloInfospessoais->data_nascimento;
  $model->cpf = $model->sloInfospessoais->cpf;
  $model->emancipado = $model->sloInfospessoais->emancipado;
  $model->fone_residencial = $model->sloInfospessoais->fone_residencial;
  $model->celular = $model->sloInfospessoais->celular;
  $model->possui_renda = $model->sloInfospessoais->possui_renda;
  $model->vai_morar = $model->sloInfospessoais->vai_morar;
  $model->estado_civil = $model->sloInfospessoais->estado_civil;
  $model->genero = $model->sloInfospessoais->genero;
  $model->nacionalidade = $model->sloInfospessoais->nacionalidade;
  $model->extrangeiro_temponopais =  $model->sloInfospessoais->extrangeiro_temponopais;
  $model->numero_dependentes =  $model->sloInfospessoais->numero_dependentes;
  $model->nome_pai =  $model->sloInfospessoais->nome_pai;
  $model->nome_mae =  $model->sloInfospessoais->nome_mae;
  $model->email =  $model->sloInfospessoais->email;

  # PROFISSIONAIS
  $model->empresa = $model->sloInfosprofissionais->empresa;
  $model->fone = $model->sloInfosprofissionais->fone;
  $model->data_admissao = $model->sloInfosprofissionais->data_admissao;
  $model->profissao = $model->sloInfosprofissionais->profissao;
  $model->vinculo_empregaticio = $model->sloInfosprofissionais->vinculo_empregaticio;
  $model->salario = $model->sloInfosprofissionais->salario;
  $model->outros_rendimentos = $model->sloInfosprofissionais->outros_rendimentos;
  $model->total_rendimentos = $model->sloInfosprofissionais->total_rendimentos;

  # PESSOAIS Cônjuge do FIADOR
  $model->cj_nome = $model->sloFiadorconjuges->sloInfospessoais->nome;
  $model->cj_data_nascimento = $model->sloFiadorconjuges->sloInfospessoais->data_nascimento;
  $model->cj_cpf = $model->sloFiadorconjuges->sloInfospessoais->cpf;
  $model->cj_emancipado = $model->sloFiadorconjuges->sloInfospessoais->emancipado;
  $model->cj_fone_residencial = $model->sloFiadorconjuges->sloInfospessoais->fone_residencial;
  $model->cj_celular = $model->sloFiadorconjuges->sloInfospessoais->celular;
  $model->cj_possui_renda = $model->sloFiadorconjuges->sloInfospessoais->possui_renda;
  $model->cj_vai_morar = $model->sloFiadorconjuges->sloInfospessoais->vai_morar;
  $model->cj_estado_civil = $model->sloFiadorconjuges->sloInfospessoais->estado_civil;
  $model->cj_genero = $model->sloFiadorconjuges->sloInfospessoais->genero;
  $model->cj_nacionalidade = $model->sloFiadorconjuges->sloInfospessoais->nacionalidade;
  $model->cj_extrangeiro_temponopais =  $model->sloFiadorconjuges->sloInfospessoais->extrangeiro_temponopais;
  $model->cj_numero_dependentes =  $model->sloFiadorconjuges->sloInfospessoais->numero_dependentes;
  $model->cj_nome_pai =  $model->sloFiadorconjuges->sloInfospessoais->nome_pai;
  $model->cj_nome_mae =  $model->sloFiadorconjuges->sloInfospessoais->nome_mae;
  $model->cj_email =  $model->sloFiadorconjuges->sloInfospessoais->email;

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

        <div style="text-align: left">
            <?php $form = ActiveForm::begin([
              'action'=>'editfiador?id='.$model->id,
            ]); ?>
            <div class="col-md-12">
                <div class="col-md-4 hidden">
                    <?= $form->field($model, 'pretendente_id')->textInput(['value'=>$pretendente_id]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'tipo_fiador')->dropDownList([ 'Fiador' => 'Fiador', 'Seguro-Fiança' => 'Seguro-Fiança' ], ['prompt' => '']) ?>
                </div>
                <div class="col-md-12">
                  <h4>Informações Pessoais</h4>
                  <hr>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                  <?php
                      echo '<div class="form-group highlight-addon field-sloocupante-cpf has-success">';
                      echo '<label class="control-label has-star" for="">Data de Nascimento:</label>';
                      echo MaskedInput::widget([
                          'name'  => 'data_nascimento_'.$model->id,
                          'clientOptions' => [
                              'alias' =>  'dd/mm/yyyy',
                              'placeholder' => 'dd/mm/aaaa',
                          ],
                          'value' => date('d/m/Y',strtotime($model->data_nascimento)),
                          'options'=>[
                              'inputmode'=>"numeric",
                              'class'=>"form-control",
                          ]
                      ]);
                      echo '<div class="help-block"></div>';
                      echo "</div>";
                  ?>
                </div>
                <div class="col-md-3">
                  <?= $form->field($model, 'genero')->dropDownList([ 'M' => 'Masculino', 'F' => 'Feminino', ], ['prompt' => '']) ?>
                </div>
                <div class="col-md-3">
                  <?php
                      echo '<div class="form-group highlight-addon field-sloocupante-cpf has-success">';
                      echo '<label class="control-label has-star" for="">CPF:</label>';
                      echo MaskedInput::widget([
                          'name'  => 'cpf_'.$model->id,
                          'mask'  => '999.999.999-99',
                          'value' => $model->cpf,
                          'options'=>[
                              'inputmode'=>"numeric",
                              'class'=>"form-control",
                          ]
                      ]);
                      echo '<div class="help-block"></div>';
                      echo "</div>";
                  ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                  <?php
                      echo '<div class="form-group highlight-addon field-sloocupante-cpf has-success">';
                      echo '<label class="control-label has-star" for="">Telefone Residencial:</label>';
                      echo MaskedInput::widget([
                          'name'  => 'fone_residencial_'.$model->id,
                          'mask'  => '(99) 9999-9999',
                          'value' => $model->fone_residencial,
                          'options'=>[
                              'inputmode'=>"numeric",
                              'class'=>"form-control",
                          ]
                      ]);
                      echo '<div class="help-block"></div>';
                      echo "</div>";
                  ?>
                </div>
                <div class="col-md-3">
                  <?php
                      echo '<div class="form-group highlight-addon field-sloocupante-cpf has-success">';
                      echo '<label class="control-label has-star" for="">Celular:</label>';
                      echo MaskedInput::widget([
                          'name'  => 'celular_'.$model->id,
                          'mask'  => '(99) 9 9999-9999',
                          'value' => $model->celular,
                          'options'=>[
                              'inputmode'=>"numeric",
                              'class'=>"form-control",
                          ]
                      ]);
                      echo '<div class="help-block"></div>';
                      echo "</div>";
                  ?>
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
                    <?php
                        echo '<div class="form-group highlight-addon field-sloocupante-cpf has-success">';
                        echo '<label class="control-label has-star" for="">Data de Expedição:</label>';
                        echo MaskedInput::widget([
                            'name'  => 'data_expedicao_'.$model->id,
                            'clientOptions' => [
                                'alias' =>  'dd/mm/yyyy',
                                'placeholder' => 'dd/mm/aaaa',
                            ],
                            'value' => date('d/m/Y',strtotime($model->data_expedicao)),
                            'options'=>[
                                'inputmode'=>"numeric",
                                'class'=>"form-control",
                            ]
                        ]);
                        echo '<div class="help-block"></div>';
                        echo "</div>";
                    ?>
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
                    <?php
                        echo '<div class="form-group highlight-addon field-sloocupante-cpf has-success">';
                        echo '<label class="control-label has-star" for="">Telefone da Empresa:</label>';
                        echo MaskedInput::widget([
                            'name'  => 'fone_'.$model->id,
                            'mask'  => '(99) 9999-9999',
                            'value' => $model->fone,
                            'options'=>[
                                'inputmode'=>"numeric",
                                'class'=>"form-control",
                            ]
                        ]);
                        echo '<div class="help-block"></div>';
                        echo "</div>";
                    ?>
                </div>
                <div class="col-md-4">

                    <?php
                        echo '<div class="form-group highlight-addon field-sloocupante-cpf has-success">';
                        echo '<label class="control-label has-star" for="">Data de Admissão:</label>';
                        echo MaskedInput::widget([
                            'name'  => 'data_admissao_'.$model->id,
                            'clientOptions' => [
                                'alias' =>  'dd/mm/yyyy',
                                'placeholder' => 'dd/mm/aaaa',
                            ],
                            'value' => date('d/m/Y',strtotime($model->data_admissao)),
                            'options'=>[
                                'inputmode'=>"numeric",
                                'class'=>"form-control",
                            ]
                        ]);
                        echo '<div class="help-block"></div>';
                        echo "</div>";
                    ?>
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

                    <?= $form->field($model, 'salario',['addon' => ['prepend' => ['content'=>'R$']]])->textInput([
                                 'type' => 'number',
                                 'id' => 'salario_'.$model->id,
                                 'name' => 'salario_'.$model->id,
                                 'value' => $model->salario,
                    ]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'outros_rendimentos',['addon' => ['prepend' => ['content'=>'R$']]])->textInput([
                                 'type' => 'number',
                                 'id' => 'outros_rendimentos_'.$model->id,
                                 'name' => 'outros_rendimentos_'.$model->id,
                                 'value' => $model->outros_rendimentos,
                    ]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'total_rendimentos',['addon' => ['prepend' => ['content'=>'R$']]])->textInput([
                                 'type' => 'number',
                                 'id' => 'total_rendimentos_'.$model->id,
                                 'name' => 'total_rendimentos_'.$model->id,
                                 'value' => $model->total_rendimentos,
                    ]) ?>
                </div>
            </div>
            <div class="col-md-12" id="div-fiador-conjuge" style="">
                <div class="col-md-12">
                  <h4>Cônjuge do Fiador Informações Pessoais</h4>
                  <hr>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'cj_nome')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?php
                        echo '<div class="form-group highlight-addon field-sloocupante-cpf has-success">';
                        echo '<label class="control-label has-star" for="">Data de Nascimento:</label>';
                        echo MaskedInput::widget([
                            'name'  => 'cj_data_nascimento_'.$model->id,
                            'clientOptions' => [
                                'alias' =>  'dd/mm/yyyy',
                                'placeholder' => 'dd/mm/aaaa',
                            ],
                            'value' => date('d/m/Y',strtotime($model->data_nascimento)),
                            'options'=>[
                                'inputmode'=>"numeric",
                                'class'=>"form-control",
                            ]
                        ]);
                        echo '<div class="help-block"></div>';
                        echo "</div>";
                    ?>
                </div>
                <div class="col-md-3">
                  <?= $form->field($model, 'cj_genero')->dropDownList([ 'M' => 'Masculino', 'F' => 'Feminino', ], ['prompt' => '']) ?>
                </div>
                <div class="col-md-3">
                    <?php
                        echo '<div class="form-group highlight-addon field-sloocupante-cpf has-success">';
                        echo '<label class="control-label has-star" for="">CPF:</label>';
                        echo MaskedInput::widget([
                            'name'  => 'cj_cpf_'.$model->id,
                            'mask'  => '999.999.999-99',
                            'value' => $model->cpf,
                            'options'=>[
                                'inputmode'=>"numeric",
                                'class'=>"form-control",
                            ]
                        ]);
                        echo '<div class="help-block"></div>';
                        echo "</div>";
                    ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'cj_email')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                  <?php
                      echo '<div class="form-group highlight-addon field-sloocupante-cpf has-success">';
                      echo '<label class="control-label has-star" for="">Telefone Residencial:</label>';
                      echo MaskedInput::widget([
                          'name'  => 'cj_fone_residencial_'.$model->id,
                          'mask'  => '(99) 9999-9999',
                          'value' => $model->fone_residencial,
                          'options'=>[
                              'inputmode'=>"numeric",
                              'class'=>"form-control",
                          ]
                      ]);
                      echo '<div class="help-block"></div>';
                      echo "</div>";
                  ?>
                </div>
                <div class="col-md-3">
                  <?php
                      echo '<div class="form-group highlight-addon field-sloocupante-cpf has-success">';
                      echo '<label class="control-label has-star" for="">Celular:</label>';
                      echo MaskedInput::widget([
                          'name'  => 'cj_celular_'.$model->id,
                          'mask'  => '(99) 9 9999-9999',
                          'value' => $model->celular,
                          'options'=>[
                              'inputmode'=>"numeric",
                              'class'=>"form-control",
                          ]
                      ]);
                      echo '<div class="help-block"></div>';
                      echo "</div>";
                  ?>
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
    </div>
    <hr>
</div>
