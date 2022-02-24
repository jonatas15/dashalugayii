<?php
// $this->beginContent('@app/views/layouts/main_old.php');
use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\select2\Select2;
use app\models\SloProposta;
use yii\bootstrap\Collapse;

use kartik\number\NumberControl; 
use yii\bootstrap\Modal;
use yii\widgets\MaskedInput;
//=====================================
$dispOptions = ['class' => 'form-control kv-monospace'];
$saveOptions = [
    'class' => 'kv-saved',
    'readonly' => true,
    'tabindex' => 1000
];
$saveCont = ['class' => 'kv-saved-cont'];
$maskedInputOptions = [
    'groupSeparator' => '.',
    'radixPoint' => ',',
    'allowMinus' => false
];

// ======================================================================

/* @var $this yii\web\View */
/* @var $model app\models\SloProposta */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="slo-proposta-form">
    <div class="col-md-12">
      <?php $form = ActiveForm::begin(); ?>
          <?= $form->field($model, 'usuario_id')->hiddenInput(['value'=>($model->isNewRecord ? Yii::$app->user->identity->id:$model->usuario_id)])->label(false) ?>
          <div class="col-md-12">
              <div class="col-md-2 hidden">
                  <?= $form->field($model, 'id_slogica')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-md-2">
                <img src="<?=Yii::$app->homeUrl.'icones/logo-g.png'?>" style="width:100%"/>
              </div>
              <div class="col-md-6">
                <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-md-4">
                <h3><strong><?=$model->tipo?></strong></h3>
                </div>
              <div class="col-md-4 hidden">
                  <?= $form->field($model, 'tipo')->dropDownList([ 
                    // 'express' => 'Express', 
                    'personalizada' => 'Personalizada', 
                    'Credpago' => 'Credpago',
                    'Seguro Fiança' => 'Seguro-Fiança'

                  ], ['prompt' => '']) ?>
              </div>
              <div class="col-md-3 hidden">
                  <div class="form-group field-visita-id_corretor has-success">
                    <?php 
                      // echo '<label class="control-label">Prazo para responder</label>';
                      // echo DatePicker::widget([
                      //   'language'=>'pt',
                      //   'name' => 'SloProposta[prazo_responder]',
                      //   'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                      //   'value' => $model->isNewRecord ? '':date('d-m-Y', strtotime($model->prazo_responder)),
                      //   'pluginOptions' => [
                      //       'autoclose'=>true,
                      //       'format' => 'dd-mm-yyyy'
                      //   ]
                      // ]);
                      echo $form->field($model, 'prazo_responder')->hiddenInput()->label(false);
                    ?>
                    <div class="help-block"></div>
                  </div>
              </div>
              <div class="col-md-2 hidden">
                  <?php //= $form->field($model, 'etapa_andamento')->textInput(['maxlength' => true,'type'=>'number']) ?>
                  <?php 
                    // use kartik\slider\Slider;
                    // echo $form->field($model, 'etapa_andamento')->widget(Slider::classname(), [
                    //     'sliderColor' => Slider::TYPE_PRIMARY,
                    //     'handleColor' => Slider::TYPE_PRIMARY,
                    //     'pluginOptions' => [
                    //         'orientation' => 'horizontal',
                    //         'handle' => 'round',
                    //         'min' => 1,
                    //         'max' => 6,
                    //         'step' => 1,
                    //         'tooltip'=>'always',
                    //     ],
                    // ])->label('Etapa');
                    echo $form->field($model, 'etapa_andamento')->hiddenInput()->label(false);
                  ?>
              </div>
              <div class="col-md-4 hidden">
                  <?= $form->field($model, 'proprietario')->textInput(['maxlength' => true]) ?>
              </div>
          </div>
          <div class="col-md-12 hidden">
              <div class="col-md-4">
                  <?= $form->field($model, 'proprietario_info')->textarea(['rows' => 9]) ?>
              </div>
              <div class="col-md-4">
                  <?= $form->field($model, 'imovel_info')->textarea(['rows' => 9]) ?>
              </div>
              <div class="col-md-4">
                  <?= $form->field($model, 'codigo_imovel')->textInput() ?>
              </div>
              <div class="col-md-4">
                  <?= $form->field($model, 'imovel_valores')->textInput(['maxlength' => true]) ?>
              </div>
              <div class="col-md-4">
                  <?php //= //$form->field($model, 'opcoes')->dropDownList([ 'aceitas essas condições' => 'Aceitas essas condições', 'fazer contraproposta' => 'Fazer contraproposta', 'desistir da negociação' => 'Desistir da negociação', ], ['prompt' => '']) ?>
              </div>
          </div>
          <div class="col-md-12">
            <h3>Informações do Imóvel - para o documento</h3>
            <hr>
            <br />
            <br />
            <div class="col-md-2">
              <?php 
                

                // echo $form->field($model, 'imoveis_jet')->dropDownList($codigos, [
                //   'prompt' => 'Selecione!',
                //   'onchange' => 'alert($(this).val());'
                // ])->label('Carregar do Jetimob');
                $imoveis = $this->context->retorna_imoveis();
                

                echo $form->field($model, 'imoveis_jet')->widget(Select2::classname(), [
                    'data' => $imoveis,
                    'language' => 'pt',
                    'options' => [
                        'placeholder' => 'Selecione',
                        'multiple' => false,
                        'onchange' => '$.ajax({
                          method: "POST",
                          url: "'.Yii::$app->homeUrl.'proposta/retornaimovel",
                          data: {
                            codigo: $(this).val(),
                          },
                      }).done(function(data) {
                          var response = $.parseJSON(data);

                          console.log(response);
                          
                          $("#sloproposta-tipo_imovel").val(response.subtipo);
                          $("#sloproposta-endereco").val(response.endereco);
                          $("#sloproposta-complemento").val(response.complemento);
                          $("#sloproposta-numero").val(response.numero);
                          $("#sloproposta-bairro").val(response.bairro);
                          $("#sloproposta-cidade").val(response.cidade);
                          $("#sloproposta-estado").val(response.estado);
                          $("#sloproposta-cep").val(response.cep);
                          $("#sloproposta-dormitorios").val(response.dormitorios);
                          $("#sloproposta-aluguel-disp").val(response.aluguel);
                          $("#sloproposta-iptu").val(response.iptu);
                          $("#sloproposta-condominio").val(response.condominio);
                          $("#sloproposta-codigo_imovel").val(response.codigo);

                          console.log(response.aluguel);

                      });'
                    ],
                    'pluginOptions' => [
                      'tags'=>false,
                      'allowClear' => false,
                      'maximumInputLength' => 100
                    ],
                ])->label('Carregar do Jetimob');

              ?>
            </div>
            <div class="col-md-2">
              <?= $form->field($model, 'tipo_imovel')->textInput(['maxlength' => true]); // dropDownList([
                // 'Apartamento' => 'Apartamento', 
                // 'Casa' => 'Casa', 
                // 'Condomínio Fechado' => 'Condomínio Fechado', 
                // 'Comercial' => 'Comercial', ], ['prompt' => '']) 
              ?>
            </div>
            <div class="col-md-8">
              <?= $form->field($model, 'motivo_locacao')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4"><?= $form->field($model, 'endereco')->textInput(['maxlength' => true]) ?></div>
            <div class="col-md-2"><?= $form->field($model, 'complemento')->textInput(['maxlength' => true]) ?></div>
            <div class="col-md-2"><?= $form->field($model, 'numero')->textInput(['type' => 'number','step'=>"1",'min'=>"0"]) ?></div>
            <div class="col-md-4"><?= $form->field($model, 'bairro')->textInput(['maxlength' => true]) ?></div>
            <div class="col-md-2"><?= $form->field($model, 'cidade')->textInput(['maxlength' => true]) ?></div>
            <div class="col-md-2"><?= $form->field($model, 'estado')->textInput(['maxlength' => true]) ?></div>
            <div class="col-md-2"><?= $form->field($model, 'cep')->textInput(['maxlength' => true]) ?></div>
            <div class="col-md-2"><?= $form->field($model, 'dormitorios')->textInput(['type' => 'number','step'=>"1",'min'=>"0"]) ?></div>
            <div class="col-md-12"><br /><br /></div>
            <div class="col-md-2">
              <?= $form->field($model, 'aluguel',['addon' => ['prepend' => ['content'=>'R$']]])->widget(
                  NumberControl::classname(), [
                  'maskedInputOptions' => $maskedInputOptions,
                  'options' => $saveOptions,
                  'displayOptions' => $dispOptions,
                  // 'saveInputContainer' => $saveCont
              ]) ?>
            </div>
            <div class="col-md-2">
              <?= $form->field($model, 'iptu',['addon' => ['prepend' => ['content'=>'R$']]])->widget(
                  NumberControl::classname(), [
                  'maskedInputOptions' => $maskedInputOptions,
                  'options' => $saveOptions,
                  'displayOptions' => $dispOptions,
                  // 'saveInputContainer' => $saveCont
              ]) ?>
            </div>
            <div class="col-md-2">
              <?= $form->field($model, 'condominio',['addon' => ['prepend' => ['content'=>'R$']]])->widget(
                  NumberControl::classname(), [
                  'maskedInputOptions' => $maskedInputOptions,
                  'options' => $saveOptions,
                  'displayOptions' => $dispOptions,
                  // 'saveInputContainer' => $saveCont
              ]) ?>
            </div>
            <div class="col-md-2">
              <?= $form->field($model, 'agua',['addon' => ['prepend' => ['content'=>'R$']]])->widget(
                  NumberControl::classname(), [
                  'maskedInputOptions' => $maskedInputOptions,
                  'options' => $saveOptions,
                  'displayOptions' => $dispOptions,
                  // 'saveInputContainer' => $saveCont
              ]) ?>
            </div>
            <div class="col-md-2">
              <?= $form->field($model, 'luz',['addon' => ['prepend' => ['content'=>'R$']]])->widget(
                  NumberControl::classname(), [
                  'maskedInputOptions' => $maskedInputOptions,
                  'options' => $saveOptions,
                  'displayOptions' => $dispOptions,
                  // 'saveInputContainer' => $saveCont
              ]) ?>
            </div>
            <div class="col-md-2">
              <?= $form->field($model, 'gas_encanado',['addon' => ['prepend' => ['content'=>'R$']]])->widget(
                  NumberControl::classname(), [
                  'maskedInputOptions' => $maskedInputOptions,
                  'options' => $saveOptions,
                  'displayOptions' => $dispOptions,
                  // 'saveInputContainer' => $saveCont
              ]) ?>
            </div>
            <div class="col-md-2">
              <?= $form->field($model, 'total',['addon' => ['prepend' => ['content'=>'R$']]])->widget(
                  NumberControl::classname(), [
                  'maskedInputOptions' => $maskedInputOptions,
                  'options' => $saveOptions,
                  'displayOptions' => $dispOptions,
                  // 'saveInputContainer' => $saveCont
              ]) ?>
            </div>
            <div class="clearfix"></div>
            <hr>
            <?php $conteudo_comercial = 
            '<div class="col-md-4">'.$form->field($model, 'atvc_empresa')->textInput(['maxlength' => true]).'</div>'.
            '<div class="col-md-2">'.$form->field($model, 'atvc_cnpj')->textInput(['maxlength' => true]).'</div>'.
            '<div class="col-md-4">'.$form->field($model, 'atvc_nome_fantasia')->textInput(['maxlength' => true]).'</div>'.
            '<div class="col-md-2">'.$form->field($model, 'atvc_atividade')->textInput(['maxlength' => true]).'</div>'.
            '<div class="col-md-3">'.
                  $form->field($model, 'atvc_data_constituicao')->widget(MaskedInput::className(), [
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
                  ]).
            '</div>'.
            '<div class="col-md-4">'.$form->field($model, 'atvc_contato')->textInput(['maxlength' => true]) .'</div>'.
            '<div class="col-md-2">'.$form->field($model, 'atvc_telefone')->textInput(['maxlength' => true]).'</div>';
          ?>
          <?php 
              echo Collapse::widget([
                'items' => [
                    [
                        'label' => "Atividade Comercial no Imóvel Alugado",
                          'content' => $conteudo_comercial,
                      ],
                  ]
              ]);
            ?>
          </div>
          <div class="col-md-12">
            <div class="col-md-3">
              <!-- <div class="form-group"> -->
                <?= Html::submitButton($model->isNewRecord ? 'Salvar' : '<i class="fa fa-home"></i> Atualizar o Imóvel', [
                  'style' => 'width:100%;font-size:20px', 
                  'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
                ]) ?>
              <!-- </div> -->
            </div>
          </div>
      <?php ActiveForm::end(); ?>
      <div class="clearfix"></div>
      <br>
      
      <div class="col-md-12"><hr>
        <h4>
          <strong>
            Superlógica
          </strong>
        </h4>
        <br>
        <div class="col-md-3">
          <?php 
            Modal::begin([
              'header' => 'Cadastre o Proprietário => Envie p/ o Superlógica',
              'size' => 'modal-lg',
              'toggleButton' => [
                'label' => '<i class="fa fa-key"></i> Enviar p/ SuperLógica',
                'class' => 'btn btn-success',
                'style' => 'font-weight: bolder; width:100%;font-size:20px',
              ]
            ]);
            $proprietario = new \app\models\Proprietario;
            echo $this->render('/proprietario/_form', [
              'model' => $proprietario,
              'proposta' => $model->id,
              'action' => 'create'
            ]);
            Modal::end();
          ?>
        </div>
      </div>
  </div>
</div>
<div class="clearfix"></div>
<br />
<br />
<?php //$this->endContent(); ?>
<style>
  .input-group-addon, .input-group-btn {
    width: 30%;
    /* background-color: #9c27b0 !important; */
    border-radius: 0px !important;
    /* border: 2px solid #9c27b0 !important; */
    border-top: 0px !important;
    padding-top: 8% !important;
    color: #9c27b0 !important;
  }
  .bmd-label-static {
    font-size: 13px !important;
    top: -15px !important;
  }
</style>