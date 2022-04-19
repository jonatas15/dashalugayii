<?php 

################################################################################################
######################################## TOME NOTA!!! ##########################################
/**
 * ATUALIZAR DADOS DO IMÓVEL PELO CÓDIGO NO PRIMEIRO ACESSO, CONFERINDO IMOVEL_INFO CASO VAZIO
 * AJUSTAR TABELA DA HOME
 * ADD ABA, OU ÁREA AQUI EM IMÓVEL, PARA RECEBER DADOS DO PROPRIETÁRIO
 * CRIAR FORMULÁRIO DO PROPRIETÁRIO PELO SITE ALUGA
 * REPLICAR O QUE PUDER PARA O CREDPAGO...
 * AJUSTAR DASH PROPRIETARIOS - VERSÃO 1
 # ######################################## FALTA ##############################################
 * ADD ENVIO AO SUPERLÓGICA, SEI QUE TEM COMO, SÓ VER ESSE COMO E JÁ ERAS
 * ADD CAMPO PARA O CÓDIGO DO D4SIGN
 * AJUSTAR DASH PROPRIETARIOS - VERSÃO COMPLETA
 * Completar CREDPAGO (formulários)
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
</style>
<div class="col-md-12">
    <br />
    <?= Alert::widget() ?>
    <br />
    <div class="col-md-6">
        <!-- <div class="row"> -->
        <?php
            Card::begin([  
                'id' => 'cardproprietario', 
                'color' => Card::COLOR_PRIMARY, 
                'headerIcon' => 'person', 
                'collapsable' => true, 
                'title' => '<strong style="font-size: 20px">Proprietário</strong>', 
                'titleTextType' => Card::TYPE_PRIMARY, 
                'showFooter' => true,
                'footerContent' => 'Dados atualizados <sup>Março</sup> 2022',
            ])
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
                echo 'Cadastre um novo proprietário no site com o código '.$model->codigo_imovel;
            }
        ?>
        <?php Card::end(); ?>
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
    <div class="col-md-6">
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

                            $("#infoimovel_numero").text(response.numero);
                            $("#infoimovel_bairro").text(response.bairro);
                            $("#infoimovel_cidade").text(response.cidade);
                            $("#infoimovel_estado").text(response.estado);
                            $("#infoimovel_cep").text(response.cep);
                            $("#infoimovel_dormitorios").text(response.dormitorios);
                            $("#infoimovel_aluguel").text(response.aluguel);
                            $("#infoimovel_iptu").text(response.iptu);
                            $("#infoimovel_condominio").text(response.condominio);
                            $("#infoimovel_codigo").text(response.codigo);

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
            </div>
            <table class="kv-grid-table table table-bordered table-striped kv-table-wrap">
                <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Código:</td><td id="infoimovel_codigo"><?=$model_infoimovel['codigo']?></td></tr>
                <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Tipo:</td><td id="infoimovel_tipo"><?=$model_infoimovel['subtipo']?></td></tr>
                <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Endereço:</td><td id="infoimovel_endereco"><?=$model_infoimovel['endereco']?></td></tr>
                <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Número:</td><td id="infoimovel_numero"><?=$model_infoimovel['numero']?></td></tr>
                <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Bairro:</td><td id="infoimovel_bairro"><?=$model_infoimovel['bairro']?></td></tr>
                <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Cidade:</td><td id="infoimovel_cidade"><?=$model_infoimovel['cidade']?></td></tr>
                <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Estado:</td><td id="infoimovel_estado"><?=$model_infoimovel['estado']?></td></tr>
                <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Cep:</td><td id="infoimovel_cep"><?=$model_infoimovel['cep']?></td></tr>
                <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Dormitorios:</td><td id="infoimovel_dormitorios"><?=$model_infoimovel['dormitorios']?></td></tr>
                <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Aluguel:</td><td id="infoimovel_aluguel"><?=$model_infoimovel['aluguel']?></td></tr>
                <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Iptu:</td><td id="infoimovel_iptu"><?=$model_infoimovel['iptu']?></td></tr>
                <tr style="font-size: 15px !important;"><td style="font-weight: bolder !important">Condominio:</td><td id="infoimovel_condominio"><?=$model_infoimovel['condominio']?></td></tr>
            </table>

            <?php Card::end(); ?>
            
            <!-- </div> -->
        <!-- </div> -->
    </div>
    <div class="col-md-6" style="text-align: center">
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