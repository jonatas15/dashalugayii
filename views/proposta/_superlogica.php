<?php 

################################################################################################
######################################## TOME NOTA!!! ##########################################
/**
 * ...
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
$proprietarios_model = \app\models\Proprietario::find()->all();
$proprietarios = [];
foreach ($proprietarios_model as $row) {
    $proprietarios[$row->id] = $row->nome; 
}

$proprietario_ativo = \app\models\Proprietario::find()->where([
    'codigo_imovel' => $model->codigo_imovel
])->one();

// exit();
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
  .botao-ativo-agora {
      border: 3px solid black !important;
      border-radius: 5px !important;
  }
  #progressando {
    display: none; 
    position: absolute; 
    left: 0; 
    right: 0; 
    margin-left: auto; 
    margin-right: auto;
    top: 50px;
  }
</style>
<div class="col-md-12">
    <div class="clearfix"></div>
    <div id="progressando" style="">
        <?php
            use kartik\spinner\Spinner;
            echo '<div class="">';
                echo Spinner::widget(['preset' => 'large', 'align' => 'center']);
                echo '<div class="clearfix"></div>';
            echo '</div>';
        ?>
    </div>
    <div class="col-md-12">
        <!-- <div class="row"> -->
        
        <?php
            // $proprietario = \app\models\Proprietario::find()->where([
            //     'codigo_imovel' => $model->codigo_imovel
            // ])->one();
            // if ($proprietario) {
            //     echo $this->render('/proprietario/_resumo', [
            //         'model' => $proprietario,
            //         'proposta' => $model->id,
            //         'action' => 'update'
            //     ]);
            // } else {
            //     echo '<h3><strong><i style="color: red;">';
            //     echo 'Cadastre um novo propriet??rio no site com o c??digo '.$model->codigo_imovel;
            //     echo '</i></strong></h3>';
            // }
        ?>
    <!-- </div> -->
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
            <?php $form = ActiveForm::begin([
                'action' => ['proposta/superlogicacompleto'],
                'options' => [
                    'id' => 'formulario-pro-superlogica'
                ]
            ]); ?>
            <input type="hidden" name="proposta_id" value="<?=$model->id?>">
            <div class="col-md-12 divs-proprietario">
                <h3><strong>Dados do Propriet??rio</strong></h3><hr style="margin-top:0px;margin-bottom:0px !important;">
                <?= $form->field($model, 'proprietario')->widget(Select2::classname(), [
                    'data' => $proprietarios,
                    'language' => 'pt',
                    'options' => [
                        'placeholder' => 'Para preencher automaticamente, selecione o nome do Propriet??rio',
                        'multiple' => false,
                        'onchange' => '
                            $("body").css("cursor", "wait");
                            $(this).css("cursor", "wait");
                            $("#progressando").show();
                            $.ajax({
                                method: "POST",
                                url: "'.Yii::$app->homeUrl.'proposta/retornaproprietario",
                                data: {
                                    id: $(this).val()
                                },
                            }).done(function(data) {
                                var response = $.parseJSON(data);
                                $("#proprietario_nome").val(response.nome);
                                $("#proprietario_nomefantasia").val(response.proprietario_nomefantasia);
                                $("#proprietario_cnpj").val(response.proprietario_cnpj);
                                $("#proprietario_celular").val(response.proprietario_celular);
                                $("#proprietario_telefone").val(response.proprietario_telefone);
                                $("#proprietario_email").val(response.proprietario_email);
                                $("#proprietario_rg").val(response.proprietario_rg);
                                $("#proprietario_orgao").val(response.proprietario_orgao);
                                $("#proprietario_sexo").val(response.proprietario_sexo);
                                $("#proprietario_datanascimento").val(response.proprietario_datanascimento);
                                $("#proprietario_nacionalidade").val(response.proprietario_nacionalidade);
                                $("#proprietario_cep").val(response.proprietario_cep);
                                $("#proprietario_endereco").val(response.proprietario_endereco);
                                $("#proprietario_numero").val(response.proprietario_numero);
                                $("#proprietario_complemento").val(response.proprietario_complemento);
                                $("#proprietario_bairro").val(response.proprietario_bairro);
                                $("#proprietario_cidade").val(response.proprietario_cidade);
                                $("#proprietario_estado").val(response.proprietario_estado);
                            });
                            $("body").css("cursor", "default");
                            $(this).css("cursor", "default");
                            $("#progressando").hide();
                        '
                    ],
                    'pluginOptions' => [
                        'tags'=>false,
                        'allowClear' => false,
                        'maximumInputLength' => 100
                    ],
                ])->label(''); ?>
            </div>
            <div class="col-md-6 divs-proprietario">
                <!-- <hr> -->
                <table class="kv-grid-table table table-bordered table-striped kv-table-wrap">
                    <?= $this->context->linhatabela('text','Nome', 'proprietario_nome', 'prop1', $proprietario_ativo->nome); ?>
                    <?= $this->context->linhatabela('text','Nome Fantasia', 'proprietario_nomefantasia', 'prop1', $proprietario_ativo->nome_fantasia); ?>
                    <?= $this->context->linhatabela('cnpf','CPF/CNPJ', 'proprietario_cnpj', 'prop1', $proprietario_ativo->cpf_cnpj); ?>
                    <?= $this->context->linhatabela('cell','Celular', 'proprietario_celular', 'prop1', $proprietario_ativo->celular); ?>
                    <?= $this->context->linhatabela('tell','Telefone', 'proprietario_telefone', 'prop1', $proprietario_ativo->telefone); ?>
                    <?= $this->context->linhatabela('text','Email', 'proprietario_email', 'prop1', $proprietario_ativo->email); ?>
                    <?= $this->context->linhatabela('text','RG', 'proprietario_rg', 'prop1', $proprietario_ativo->rg); ?>
                    <?= $this->context->linhatabela('text','??rg??o Emissor', 'proprietario_orgao', 'prop1', $proprietario_ativo->orgao); ?>
                    <?= $this->context->linhatabela('select','Sexo', 'proprietario_sexo', 'prop1', $proprietario_ativo->sexo, [
                        'M' => 'Masculino',
                        'F' => 'Feminino',
                        'I' => 'Indefinido',
                    ]); ?>
                </table>
            </div>
            <div class="col-md-6 divs-proprietario">
                <table class="kv-grid-table table table-bordered table-striped kv-table-wrap">
                    <?= $this->context->linhatabela('data','Data de Nascimento', 'proprietario_datanascimento', 'prop1', $proprietario_ativo->data_nascimento); ?>
                    <?= $this->context->linhatabela('text','Nacionalidade', 'proprietario_nacionalidade', 'prop1', $proprietario_ativo->nacionalidade); ?>
                    <?= $this->context->linhatabela('cepp','Cep', 'proprietario_cep', 'prop1', $proprietario_ativo->cep); ?>
                    <?= $this->context->linhatabela('text','Endere??o', 'proprietario_endereco', 'prop1', $proprietario_ativo->endereco); ?>
                    <?= $this->context->linhatabela('text','N??mero', 'proprietario_numero', 'prop1', $proprietario_ativo->numero); ?>
                    <?= $this->context->linhatabela('text','Complemento', 'proprietario_complemento', 'prop1', $proprietario_ativo->complemento); ?>
                    <?= $this->context->linhatabela('text','Bairro', 'proprietario_bairro', 'prop1', $proprietario_ativo->bairro); ?>
                    <?= $this->context->linhatabela('text','Cidade', 'proprietario_cidade', 'prop1', $proprietario_ativo->cidade); ?>
                    <?= $this->context->linhatabela('select','Estado', 'proprietario_estado', 'prop1', $proprietario_ativo->estado, $this->context->estadosBrasileiros); ?>
                </table>
            </div>
            <div class="col-md-12 divs-imovel">
                <h3><strong>Dados do Im??vel</strong></h3><hr style="margin-top:0px;margin-bottom:0px !important;">
                <?= $form->field($model, 'imoveis_jet')->widget(Select2::classname(), [
                    'data' => $imoveis,
                    'language' => 'pt',
                    'options' => [
                        'placeholder' => 'Para preencher automaticamente, selecione o c??digo do Im??vel',
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

                            $("#infoimovel_numero").val(response.numero);
                            $("#infoimovel_bairro").val(response.bairro);
                            $("#infoimovel_cidade").val(response.cidade);
                            $("#infoimovel_estado").val(response.estado);
                            $("#infoimovel_cep").val(response.cep);
                            $("#infoimovel_dormitorios").val(response.dormitorios);
                            $("#infoimovel_aluguel").val(response.aluguel);
                            $("#infoimovel_iptu").val(response.iptu);
                            $("#infoimovel_condominio").val(response.condominio);
                            $("#infoimovel_codigo").val(response.codigo);

                            // console.log(response.aluguel);

                        });'
                    ],
                    'pluginOptions' => [
                        'tags'=>false,
                        'allowClear' => false,
                        'maximumInputLength' => 100
                    ],
                ])->label('');
                ?>
            </div>
            <div class="col-md-6 divs-imovel">
                <table class="kv-grid-table table table-bordered table-striped kv-table-wrap">
                    <?= $this->context->linhatabela('text','C??digo', 'infoimovel_codigo', 'imovelinfo', $model_infoimovel['codigo']); ?>
                    <?= $this->context->linhatabela('text','Tipo', 'infoimovel_subtipo', 'imovelinfo', $model_infoimovel['subtipo']); ?>
                    <?= $this->context->linhatabela('text','Endere??o', 'infoimovel_endereco', 'imovelinfo', $model_infoimovel['endereco']); ?>
                    <?= $this->context->linhatabela('text','N??mero', 'infoimovel_numero', 'imovelinfo', $model_infoimovel['numero']); ?>
                    <?= $this->context->linhatabela('text','Bairro', 'infoimovel_bairro', 'imovelinfo', $model_infoimovel['bairro']); ?>
                    <?= $this->context->linhatabela('text','Cidade', 'infoimovel_cidade', 'imovelinfo', $model_infoimovel['cidade']); ?>
                </table>
            </div>
            <div class="col-md-6 divs-imovel">
                <table class="kv-grid-table table table-bordered table-striped kv-table-wrap">
                    <?= $this->context->linhatabela('select','Estado', 'infoimovel_estado', 'imovelinfo',  $this->context->returnEstado($model_infoimovel['estado'], 'sigla'), $this->context->estadosBrasileiros); ?>
                    <?= $this->context->linhatabela('cepp','Cep', 'infoimovel_cep', 'imovelinfo', $model_infoimovel['cep']); ?>
                    <?= $this->context->linhatabela('text','Dormitorios', 'infoimovel_dormitorios', 'imovelinfo', $model_infoimovel['dormitorios']); ?>
                    <?= $this->context->linhatabela('text','Aluguel', 'infoimovel_aluguel', 'imovelinfo', $model_infoimovel['aluguel']); ?>
                    <?= $this->context->linhatabela('text','Iptu', 'infoimovel_iptu', 'imovelinfo', $model_infoimovel['iptu']); ?>
                    <?= $this->context->linhatabela('text','Condominio', 'infoimovel_condominio', 'imovelinfo', $model_infoimovel['condominio']); ?>
                </table>
            </div>
            <div class="col-md-12 divs-contrato">
                <h3><strong>Informa????es do Contrato</strong></h3><hr style="">
            </div>
            <div class="col-md-6 divs-contrato">
                <table class="kv-grid-table table table-bordered table-striped kv-table-wrap">
                    <?= $this->context->linhatabela('select','Id Tipo de Contrato', 'id_tipo_con', 'slocontrato', null, [
                        1 => 'Residencial',
                        2 => 'N??o residencial',
                        3 => 'Comercial',
                        4 => 'Ind??stria',
                        5 => 'Temporada',
                        6 => 'Por encomenda',
                        7 => 'Mista',
                    ]); ?>
                    <?= $this->context->linhatabela('data','Data de In??cio', 'dt_inicio_con', 'slocontrato'); ?>
                    <?= $this->context->linhatabela('data','Data de Fim', 'dt_fim_con', 'slocontrato'); ?>
                    <?= $this->context->linhatabela('text','Valor do Aluguel', 'vl_aluguel_con', 'slocontrato'); ?>
                    <?= $this->context->linhatabela('text','Taxa Adm', 'tx_adm_con', 'slocontrato'); ?>
                    <?= $this->context->linhatabela('text','Taxa Adm (valor fixo)', 'fl_txadmvalorfixo_con', 'slocontrato'); ?>
                    <?= $this->context->linhatabela('text','Dia do Vencimento', 'nm_diavencimento_con', 'slocontrato'); ?>
                    <?= $this->context->linhatabela('text','Taxa de Loca????o', 'tx_locacao_con', 'slocontrato'); ?>
                    <?= $this->context->linhatabela('text','??ndice de reajuste', 'id_indicereajuste_con', 'slocontrato'); ?>
                    <?= $this->context->linhatabela('text','NM M??s de reajuste', 'nm_mesreajuste_con', 'slocontrato'); ?>
                    <?= $this->context->linhatabela('data','??ltimo reajuste', 'dt_ultimoreajuste_con', 'slocontrato'); ?>
                    <?= $this->context->linhatabela('text','FL M??s fechado', 'fl_mesfechado_con', 'slocontrato'); ?>
                </table>
            </div>
            <div class="col-md-6 divs-contrato">
                <table class="kv-grid-table table table-bordered table-striped kv-table-wrap">
                    <?= $this->context->linhatabela('text','Id Conta Banco', 'id_contabanco_cb', 'slocontrato'); ?>
                    <?= $this->context->linhatabela('select','Dia fixo do repasse', 'fl_diafixorepasse_con', 'slocontrato', "0", [
                        "0" => "Dias ??teis ap??s pagamento do aluguel",
                        "1" => "Dia fixo",
                        "2" => "Dias corridos ap??s pagamento do aluguel"
                    ]); ?>
                    <?= $this->context->linhatabela('text','Dia do repasse', 'nm_diarepasse_con', 'slocontrato'); ?>
                    <?= $this->context->linhatabela('select','FL M??s vencido', 'fl_mesvencido_con', 'slocontrato', "0", [
                        "0" => "M??s vencido",
                        "1" => "M??s a vencer"
                    ]); ?>
                    <?= $this->context->linhatabela('text','FL Dimob', 'fl_dimob_con', 'slocontrato'); ?>
                    <?= $this->context->linhatabela('text','ID Filial', 'id_filial_fil', 'slocontrato'); ?>
                    <?= $this->context->linhatabela('text','ST Observa????o', 'st_observacao_con', 'slocontrato', 'Contrato adicionado via API'); ?>
                    <?= $this->context->linhatabela('select','NM Repasse Garantido', 'nm_repassegarantido_con', 'slocontrato', "0", [
                        "-1" => "Garantido por todo o contrato",
                        "0" => "Sem repasse garantido",
                        "1" => "1 M??s",
                        "2" => "2 Meses",
                        "3" => "3 Meses",
                        "4" => "4 Meses",
                        "5" => "5 Meses",
                        "6" => "6 Meses",
                        "7" => "7 Meses",
                        "8" => "8 Meses",
                        "9" => "9 Meses",
                        "10" => "10 Meses",
                        "11" => "11 Meses",
                        "12" => "12 Meses"
                    ]); ?>
                    <?= $this->context->linhatabela('select','FL Garantia', 'fl_garantia_con', 'slocontrato', "0", [
                        "0" => "N??o possui garantia",
                        "1" => "Possui garantia"
                    ]); ?>
                    <?= $this->context->linhatabela('select','FL Seguro-Inc??ndio', 'fl_seguroincendio_con', 'slocontrato', "0", [
                        "0" => "N??o possui seguro-inc??ndio",
                        "1" => "Possui seguro-inc??ndio"
                    ]); ?>
                    <?= $this->context->linhatabela('select','FL Endere??o de Cobran??a', 'fl_endcobranca_con', 'slocontrato', "1", [
                        "1" => "Usar endere??o do im??vel locado",
                        "2" => "Usar endere??o do locat??rio"
                    ]); ?>
                </table>
            </div>
            <div class="col-md-12 divs-pretendente">
                <h3><strong>Informa????es do Pretendente</strong></h3><hr style="">
            </div>
            <div class="col-md-6 divs-pretendente">
                <table class="kv-grid-table table table-bordered table-striped kv-table-wrap">
                    <?= $this->context->linhatabela('text','Nome', 'nome', 'pretendente', $model->nome); ?>
                    <?= $this->context->linhatabela('text','Nome Fantasia', 'nome_fantasia', 'pretendente', $model->nome); ?>
                    <?= $this->context->linhatabela('cnpf','CPF/CNPJ', 'cnpj', 'pretendente', $model->cnpj); ?>
                    <?= $this->context->linhatabela('cell','Celular', 'celular', 'pretendente', $model->telefone_celular); ?>
                    <?= $this->context->linhatabela('tell','Telefone', 'telefone', 'pretendente', $model->telefone); ?>
                    <?= $this->context->linhatabela('text','Email', 'email', 'pretendente', $model->email); ?>
                    <?= $this->context->linhatabela('text','RG', 'rg', 'pretendente', $model->documento_numero); ?>
                    <?= $this->context->linhatabela('text','??rg??o Emissor', 'orgao', 'pretendente', $model->documento_orgao_emissor); ?>
                    <?= $this->context->linhatabela('select','Sexo', 'sexo', 'pretendente', $model->sexo, [
                        'M' => 'Masculino',
                        'F' => 'Feminino',
                        'I' => 'Indefinido',
                    ]); ?>
                </table>
            </div>
            <div class="col-md-6 divs-pretendente">
                <table class="kv-grid-table table table-bordered table-striped kv-table-wrap">
                    <?= $this->context->linhatabela('data','Data de nascimento', 'data_nascimento', 'pretendente', $model->data_nascimento); ?>
                    <?= $this->context->linhatabela('text','Nacionalidade', 'nacionalidade', 'pretendente', $model->nacionalidade); ?>
                    <?= $this->context->linhatabela('cepp','Cep', 'cep', 'pretendente', $model->cep); ?>
                    <?= $this->context->linhatabela('text','Endere??o', 'endereco', 'pretendente', $model->endereco); ?>
                    <?= $this->context->linhatabela('text','N??mero', 'numero', 'pretendente', $model->numero); ?>
                    <?= $this->context->linhatabela('text','Complemento', 'complemento', 'pretendente', $model->complemento); ?>
                    <?= $this->context->linhatabela('text','Bairro', 'bairro', 'pretendente', $model->bairro); ?>
                    <?= $this->context->linhatabela('text','Cidade', 'cidade', 'pretendente', $model->cidade); ?>
                    <?= $this->context->linhatabela('select','Estado', 'estado', 'pretendente', $model->estado, $this->context->estadosBrasileiros); ?>
                </table>
            </div>
            <div class="col-md-12">
                <hr>
                <a id="div-prop-id" class="btn btn-navlocal btn-primary" style="color: white">Propriet??rio</a>
                <a id="div-imov-id" class="btn btn-navlocal" style="color: white">Im??vel</a>
                <a id="div-pret-id" class="btn btn-navlocal" style="color: white">Pretendente</a>
                <a id="div-cont-id" class="btn btn-navlocal" style="color: white">Contrato</a>
            </div>
            <div class="col-md-12">
                <hr>
                <?= Html::submitButton('Enviar Dados', ['class' => 'btn btn-success', 'id' => 'enviaraosuperlogica']) ?>
            </div>
            <?php ActiveForm::end(); ?>
            
            <!-- </div> -->
        <!-- </div> -->
    </div>
    <div class="col-md-6 hidden" style="text-align: center">
        <?=Html::a('SUPERL??GICA: Propriet??rio e Im??vel',  ['proposta/addtosuperlogica', 'id' => $model->id], [
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
    </div>
</div>
<?php
    $this->registerJs("
        $('.divs-proprietario').show();
        $('.divs-imovel').hide();
        $('.divs-contrato').hide();
        $('.divs-pretendente').hide();

        $('#enviaraosuperlogica').prop('disabled', true);

        valida_prop = false;
        valida_imov = false;
        valida_pretd = false;
        valida_cntr = false;

        $('#div-prop-id').on('click', function(){
            $('.divs-proprietario').show();
            $('.divs-imovel').hide();
            $('.divs-contrato').hide();
            $('.divs-pretendente').hide();
            $('.btn-navlocal').removeClass('btn-primary botao-ativo-agora');
            $(this).addClass('btn-primary');
            var conta_campos = 0;
            var conta_campos_cheios = 0;
            var tacheio = '(Falta dados)';
            $( \".divs-proprietario input\" ).each(function( index ) {
                // console.log( index + \": \" + $( this ).val() );
                conta_campos++;
                if ($( this ).val() != '') {
                    conta_campos_cheios++;
                }
            });
            if (conta_campos == conta_campos_cheios) {
                tacheio = '(Completo)';
                $(this).addClass('btn-success');
                valida_prop = true;
            } else {
                $(this).removeClass('btn-success');
            }
            $(this).text('Propriet??rio' + ' ' + conta_campos_cheios + '/' + conta_campos);
            $(this).attr('title', tacheio);
            $(this).addClass('botao-ativo-agora');
        });
        $('#div-imov-id').on('click', function(){
            $('.divs-proprietario').hide();
            $('.divs-imovel').show();
            $('.divs-contrato').hide();
            $('.divs-pretendente').hide();
            $('.btn-navlocal').removeClass('btn-primary botao-ativo-agora');
            $(this).addClass('btn-primary');
            var conta_campos_2 = 0;
            var conta_campos_cheios_2 = 0;
            var tacheio_2 = '(Falta dados)';
            $( \".divs-imovel input\" ).each(function( index ) {
                // console.log( index + \": \" + $( this ).val() );
                conta_campos_2++;
                if ($( this ).val() != '') {
                    conta_campos_cheios_2++;
                }
            });
            if (conta_campos_2 == conta_campos_cheios_2) {
                tacheio_2 = '(Completo)';
                $(this).addClass('btn-success');
                valida_imov = true;
            } else {
                $(this).removeClass('btn-success');
            }
            $(this).text('Im??vel' + ' ' + conta_campos_cheios_2 + '/' + conta_campos_2);
            $(this).attr('title', tacheio_2);
            $(this).addClass('botao-ativo-agora');
        });
        $('#div-cont-id').on('click', function(){
            $('.divs-proprietario').hide();
            $('.divs-imovel').hide();
            $('.divs-contrato').show();
            $('.divs-pretendente').hide();
            $('.btn-navlocal').removeClass('btn-primary botao-ativo-agora');
            $(this).addClass('btn-primary');
            var conta_campos_3 = 0;
            var conta_campos_cheios_3 = 0;
            var tacheio_3 = '(Falta dados)';
            $( \".divs-contrato input\" ).each(function( index ) {
                // console.log( index + \": \" + $( this ).val() );
                conta_campos_3++;
                if ($( this ).val() != '') {
                    conta_campos_cheios_3++;
                }
            });
            $( \".divs-contrato select\" ).each(function( index ) {
                // console.log( index + \": \" + $( this ).val() );
                conta_campos_3++;
                if ($( this ).val() != '') {
                    conta_campos_cheios_3++;
                }
            });
            if (conta_campos_3 == conta_campos_cheios_3) {
                tacheio_3 = '(Completo)';
                $(this).addClass('btn-success');
                valida_cntr = true;
            } else {
                $(this).removeClass('btn-success');
            }
            $(this).text('Contrato' + ' ' + conta_campos_cheios_3 + '/' + conta_campos_3);
            $(this).attr('title', tacheio_3);
            $(this).addClass('botao-ativo-agora');
        });
        $('#div-pret-id').on('click', function(){
            $('.divs-proprietario').hide();
            $('.divs-imovel').hide();
            $('.divs-contrato').hide();
            $('.divs-pretendente').show();
            $('.btn-navlocal').removeClass('btn-primary botao-ativo-agora');
            $(this).addClass('btn-primary');
            var conta_campos_4 = 0;
            var conta_campos_cheios_4 = 0;
            var tacheio_4 = '(Falta dados)';
            $( \".divs-pretendente input\" ).each(function( index ) {
                // console.log( index + \": \" + $( this ).val() );
                conta_campos_4++;
                if ($( this ).val() != '') {
                    conta_campos_cheios_4++;
                }
            });
            if (conta_campos_4 == conta_campos_cheios_4) {
                tacheio_4 = '(Completo)';
                $(this).addClass('btn-success');
                valida_pretd = true;
            } else {
                $(this).removeClass('btn-success');
            }
            $(this).text('Pretendente' + ' ' + conta_campos_cheios_4 + '/' + conta_campos_4);
            $(this).attr('title', tacheio_4);
            $(this).addClass('botao-ativo-agora');
        });
        // $('#div-pret-id').on('click', function(){});
        
        $('#formulario-pro-superlogica').on('mouseover', function() {
            if (valida_prop == true && valida_imov == true && valida_pretd == true && valida_cntr == true) {
                $('#enviaraosuperlogica').prop('disabled', false);
            } else {
                $('#enviaraosuperlogica').prop('disabled', true);
            }
        });
    ");
?>
