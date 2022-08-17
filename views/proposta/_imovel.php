<?php 

################################################################################################
######################################## TOME NOTA!!! ##########################################
/**
 * 
 # ######################################## FALTA ##############################################
 * 
 */
################################################################################################
################################################################################################
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
use deyraka\materialdashboard\widgets\Card;
use dmstr\widgets\Alert;
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
$imoveis = $this->context->retorna_imoveis();
?>
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
  .alert-success {
    font-size: 17px !important;
    text-align: center !important;
    font-weight: bold;
  }
  .disabled {
      background-color: lightgray !important;
  }
  #imagem-imovel-aqui {
    border-radius: 50% !important;
  }
</style>
<div class="col-md-12">
    <br />
    <?= Alert::widget() ?>
    <br />
    <div class="col-md-7">
        <div class="col-md-12">
            <div class="col-md-12 estilo-card-caixa">
            <!-- <div class="row"> -->
                <h3>
                <strong style="font-size: 20px">Proprietário, Imóvel <?= $model->codigo_imovel ?></strong>
                </h3>
            <?php
                // Card::begin([  
                //     'id' => 'cardproprietario', 
                //     'color' => Card::COLOR_PRIMARY, 
                //     'headerIcon' => 'person', 
                //     'collapsable' => true, 
                //     'title' => '<strong style="font-size: 20px">Proprietário; Imóvel '.$model->codigo_imovel.'</strong>', 
                //     'titleTextType' => Card::TYPE_PRIMARY, 
                //     'showFooter' => true,
                //     'footerContent' => 'Dados atualizados <sup>Março</sup> 2022',
                //     'options' => [
                //         'style' => 'z-index: 1400 !important'
                //     ]
                // ])
            ?>
            <?php
                $proprietario = \app\models\Proprietario::find()->where([
                    'codigo_imovel' => $model->codigo_imovel
                ])->one();
                if ($proprietario) {
                    echo $this->render('/proprietario/_resumo', [
                        'model' => $proprietario,
                        'proposta' => $model->id,
                        'action' => 'update'
                    ]);
                } else {
                    echo '<div class="col-md-6">';
                    echo '<h4>Cadastre um novo Proprietário pra esse Imóvel</h4>';
                    echo '<br />';
                    $proprietario = new \app\models\Proprietario();
                    echo $this->render('/proprietario/create', [
                        'proposta' => $model->id,
                        'codigo' => $model->codigo_imovel,
                        'action' => 'create',
                        'model' => $proprietario
                    ]);
                    echo '</div>';
                    echo '<div class="col-md-6">';
                    echo '<h4>Ou selecione um existente</h4>';
                    echo $this->render('/proprietario/_novo', [
                        'proposta' => $model->id,
                        'codigo' => $model->codigo_imovel,
                        'model' => $model
                    ]);
                    echo '</div>';
                }
                echo '<br>';
            ?>
            <?php //Card::end(); ?>
            </div>
        </div>
        <div class="col-md-12">
            <?php
                $model_infoimovel = json_decode($model->imovel_info,true);
            ?>
            <?php
                // echo '<pre>';
                // print_r($model_infoimovel);
                // echo '</pre>';
            ?>
            <!-- <div class="row"> -->
            <!-- <div class="col-md-4"> -->
                <?php
                    Card::begin([  
                        'id' => 'cardimovel', 
                        'color' => Card::COLOR_INFO, 
                        'headerIcon' => 'info', 
                        'collapsable' => true, 
                        'title' => '<strong style="font-size: 20px">Informações do Imóvel (Jetimob)</strong>', 
                        'titleTextType' => Card::TYPE_INFO, 
                        'showFooter' => true,
                        'footerContent' => 'Dados atualizados <sup>Março</sup> 2022',
                    ])
                ?>
                <div class="">
                    <hr>
                    <?= 'Superlógica Id-Imóvel: '.$model->superlogica_imovel ?>
                    <hr>
                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'imoveis_jet')->widget(Select2::classname(), [
                        'data' => $imoveis,
                        'language' => 'pt',
                        'options' => [
                            'placeholder' => 'Selecione o Código',
                            'multiple' => false,
                            'onchange' => '$.ajax({
                                method: "POST",
                                url: "'.Yii::$app->homeUrl.'proposta/retornaimovel",
                                data: {
                                    codigo: $(this).val(),
                                    id: '.$model->id.'
                                },
                            }).done(function(data) {
                                var response = $.parseJSON(data);

                                // console.log(response);
                                
                                $.ajax({
                                    method: "POST",
                                    url: "'.Yii::$app->homeUrl.'proposta/imovelinfo",
                                    data: {
                                        id: '.$model->id.',
                                        campo: data
                                    },
                                });

                                $("#td_infoimovel_numero").text(response.numero);
                                $("#td_infoimovel_bairro").text(response.bairro);
                                $("#td_infoimovel_cidade").text(response.cidade);
                                $("#td_infoimovel_estado").text(response.estado);
                                $("#td_infoimovel_cep").text(response.cep);
                                $("#td_infoimovel_dormitorios").text(response.dormitorios);
                                $("#td_infoimovel_aluguel").text(response.aluguel);
                                $("#td_infoimovel_iptu").text(response.iptu);
                                $("#td_infoimovel_condominio").text(response.condominio);
                                $("#td_infoimovel_codigo").text(response.codigo);
                                $("#imagem-imovel-aqui").attr("src",response.imagem);
                                $("#mostrador-imovel-codigo span").text(response.codigo);
                                $("#mostrador-imovel-endereco span").text(response.endereco);
                                $("#mostrador-imovel-aluguel span").text(response.aluguel);
                                $("#mostrador-imovel-dormitorios span").text(response.dormitorios);

                                document.location.reload(true);

                                // console.log(response.aluguel);

                            });'
                        ],
                        'pluginOptions' => [
                            'tags'=>false,
                            'allowClear' => false,
                            'maximumInputLength' => 100
                        ],
                    ])->label('Adicionar ou Atualizar Imóvel: Dados do Jetimob');
                    ?>
                    <?php ActiveForm::end(); ?>    
                </div>
                <table class="kv-grid-table table table-bordered table-striped kv-table-wrap">
                    <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Código:</td><td id="td_infoimovel_codigo"><?=$model_infoimovel['codigo']?></td></tr>
                    <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Tipo:</td><td id="td_infoimovel_tipo"><?=$model_infoimovel['subtipo']?></td></tr>
                    <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Endereço:</td><td id="td_infoimovel_endereco"><?=$model_infoimovel['endereco']?></td></tr>
                    <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Número:</td><td id="td_infoimovel_numero"><?=$model_infoimovel['numero']?></td></tr>
                    <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Bairro:</td><td id="td_infoimovel_bairro"><?=$model_infoimovel['bairro']?></td></tr>
                    <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Cidade:</td><td id="td_infoimovel_cidade"><?=$model_infoimovel['cidade']?></td></tr>
                    <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Estado:</td><td id="td_infoimovel_estado"><?=$model_infoimovel['estado']?></td></tr>
                    <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Cep:</td><td id="td_infoimovel_cep"><?=$model_infoimovel['cep']?></td></tr>
                    <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Dormitorios:</td><td id="td_infoimovel_dormitorios"><?=$model_infoimovel['dormitorios']?></td></tr>
                    <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Aluguel:</td><td id="td_infoimovel_aluguel"><?=$model_infoimovel['aluguel']?></td></tr>
                    <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Iptu:</td><td id="td_infoimovel_iptu"><?=$model_infoimovel['iptu']?></td></tr>
                    <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Condominio:</td><td id="td_infoimovel_condominio"><?=$model_infoimovel['condominio']?></td></tr>
                    <tr style="font-size: 15px !important;display:none !important;"><td style="font-weight: bolder !important">Imagem:</td><td id="td_infoimovel_imagem"><?=$model_infoimovel['imagem']?></td></tr>
                </table>

                <?php Card::end(); ?>
            
                <!-- </div> -->
            <!-- </div> -->
        </div>
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(); ?>
                <div class="hidden">
                    <?= $form->field($model, 'usuario_id')->hiddenInput([
                        'value'=> ($model->isNewRecord ? Yii::$app->user->identity->id:$model->usuario_id)
                    ])->label(false) ?>
                </div>
                <?php
                Card::begin([  
                    'id' => 'cardimovel_outros_dados', 
                    'color' => Card::COLOR_SUCCESS, 
                    'headerIcon' => 'list', 
                    'collapsable' => true, 
                    'title' => '<strong style="font-size: 20px">Atividade Comercial no Imóvel?</strong>', 
                    'titleTextType' => Card::TYPE_SUCCESS, 
                    'showFooter' => true,
                    'footerContent' => 'Dados atualizados <sup>Março</sup> 2022',
                ]); 
                ?>
                <!-- 
                    editableoptions = [
                        'class' => 'form-control',
                        'mask' => ['(99)9999-9999','(99)99999-9999']
                    ]
                -->
                <?php $conteudo_comercial = '<br>'.
                    '<div class="col-md-6">'.$form->field($model, 'atvc_empresa')->textInput(['maxlength' => true]).'</div>'.
                    '<div class="col-md-6">'.$form->field($model, 'atvc_cnpj')->textInput(['maxlength' => true]).'</div>'.
                    '<div class="col-md-6">'.$form->field($model, 'atvc_nome_fantasia')->textInput(['maxlength' => true]).'</div>'.
                    '<div class="col-md-6">'.$form->field($model, 'atvc_atividade')->textInput(['maxlength' => true]).'</div>'.
                    '<div class="col-md-6">'.
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
                                'value'=> $model->atvc_data_constituicao !='' ? date('d/m/Y',strtotime($model->atvc_data_constituicao)):'',
                            ]
                            ]).
                    '</div>'.
                    '<div class="col-md-6">'.$form->field($model, 'atvc_contato')->textInput(['maxlength' => true]) .'</div>'.
                    '<div class="col-md-6">'.$form->field($model, 'atvc_telefone')->widget(MaskedInput::className(), [
                        'clientOptions' => [
                            'alias' =>  ['(99)9999-9999','(99)99999-9999'],
                            // 'placeholder' => 'dd/mm/aaaa',
                        ],
                    ]).'</div>';
                ?>
                <br />
                <div class="col-md-12">
                <?= $conteudo_comercial;?>
                </div>
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <?= Html::submitButton($model->isNewRecord ? 'Salvar' : '<i class="fa fa-home"></i> Atualizar', [
                        'style' => 'width:100%;font-size:20px', 
                        'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success'
                    ]) ?>
                </div>
                <?php Card::end(); ?>
            <?php ActiveForm::end(); ?>
            <!-- </div> -->
        </div>
    </div>
    <div class="col-md-5">
        <center>
        <?php 
            if ($model_infoimovel['imagem']) {
                echo '<img src="'.$model_infoimovel['imagem'].'" id="imagem-imovel-aqui">';
            }
        ?>
        <h3 id="mostrador-imovel-codigo"><strong>Código: <span><?=$model_infoimovel['codigo']?></span></strong></h3>
        <h4 id="mostrador-imovel-endereco"><strong>Endereço: <span><?=$model_infoimovel['endereco'].' - '.$model_infoimovel['numero']?></span></strong></h4>
        <h4 id="mostrador-imovel-aluguel"><strong>Valor de Locação: R$<span><?=number_format($model_infoimovel['aluguel'],2,",",".")?></span></strong></h4>
        <h4 id="mostrador-imovel-dormitorios"><strong>Dormitórios: <span><?=$model_infoimovel['dormitorios']?></span></strong></h4>
        </center>
    </div>
    <div class="col-md-6 hidden" style="text-align: center">
        <?=Html::a('SUPERLÓGICA: Proprietário e Imóvel',  ['proposta/addtosuperlogica', 'id' => $model->id], [
            'class' => 'btn btn-primary',
            'onClick' => '
                $("body").css("cursor", "wait");
                $(this).css("cursor", "wait");
                $("#progressando").show();
                // $(this).addAttribute(\'disabled\');
                $(this).addClass(\'disabled\');
            '
        ]);?>
        <br />
        <br />
        <div id="progressando" style="display: none">
            <?php
                use kartik\spinner\Spinner;
                echo '<div class="">';
                    echo Spinner::widget(['preset' => 'large', 'align' => 'center']);
                    echo '<div class="clearfix"></div>';
                echo '</div>';
            ?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>