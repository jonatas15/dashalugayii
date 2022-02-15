<?php 
use yii\helpers\Html;
use yii\bootstrap\Modal;
use app\models\Checklist;
use app\models\Chtopico;
use kartik\editable\Editable;
use yii\bootstrap\Collapse;
use kartik\checkbox\CheckboxX;

use app\models\Historico;

$pessoais = $model->sloInfospessoais;
?>
<style media="screen">
    #ul-checks, #ul-checks ul {list-style-type: none;}
    #ul-checks .help-block {margin: 0px !important}
    #ul-checks input[type="checkbox"] {width: 17px; height: 17px;margin-top: 0px;}
    #ul-checks label {margin-top: 10px;}
</style>
<div class="col-md-12">
    <?php
        // Modal::begin([
        //     'header' => '<h2>Processos da Locação</h2>',
        //     'toggleButton' => [
        //         'label' => 'Processos da Locação',
        //         'class' => 'btn'
        //     ],
        // ]);
        //
        // $novo_ocupante = new app\models\SloOcupante;
        //
        // echo $this->render('_form_novo_ocupante', [
        //     'model' => $novo_ocupante,
        //     'pretendente_id' => $model->id,
        //     'proposta_id' => $model->proposta->id,
        // ]);
        //
        // Modal::end();
        $checklist = Checklist::findOne(['pretendente_id'=>$model->id]);
        if (count($checklist) > 0){

        }else {
            $checklist = new Checklist();
            $checklist->titulo = 'Processo de Locação do Pretendente '.$pessoais->nome;
            $checklist->pretendente_id = $model->id;
            $checklist->save();

            // 1ª Etapa
            $this->context->addtopicoch($checklist->id,'Enviar ao cliente "lista" de documentos e "fichas" para cadastro.', '1ª Etapa');
            $this->context->addtopicoch($checklist->id,'Criar pastas no Drive e colocar os documentos enviados.', '1ª Etapa');
            $this->context->addtopicoch($checklist->id,'Criar "card" no Pipefy, para solicitar análise e contrato (definir prazo).', '1ª Etapa');
            $this->context->addtopicoch($checklist->id,'Encaminhar contratos para assinatura eletrônica (se for o caso).', '1ª Etapa');
            $this->context->addtopicoch($checklist->id,'Solicitar orçamento do "seguro incêndio" junto ao MK seguros.', '1ª Etapa');
            $this->context->addtopicoch($checklist->id,'Realizar vistoria de entrada do imóvel.', '1ª Etapa');
            $this->context->addtopicoch($checklist->id,'Entregar as "chaves", "contrato", "vistoria" e "cartão de vantagens".', '1ª Etapa');
            $this->context->addtopicoch($checklist->id,'Digitalizar <b>todos</b> documentos assinados, contratos e subir pro DRIVE.', '1ª Etapa');

            // 2ª Etapa
            $this->context->addtopicoch($checklist->id,'Registrar no jetimob em "negociações" e "oportunidades".', '2ª Etapa');
            $this->context->addtopicoch($checklist->id,'Registrar novo contrato no Superlógica.', '2ª Etapa');

            // 3ª Etapa
            $this->context->addtopicoch($checklist->id,'Se <b>Credpago</b>, anexar no sistema: "contrato", "vistoria com as fotos" e "apólice de seguro".', '3ª Etapa');
            $this->context->addtopicoch($checklist->id,'Se <b>Segurança-fiança</b>, encaminhar a seguradora: "contrato", "procuração" e "vistoria".', '3ª Etapa');
            $this->context->addtopicoch($checklist->id,'Após 1 semana do contrato assinado, realizar o "Pós-Venda".', '3ª Etapa');

            // Outras etapas
            // $this->context->addtopicoch($checklist->id,'.');

        }
        // echo $checklist->titulo;
        // echo "<pre>";
        // print_r($checklist->chtopicos);
        // echo "</pre>";
    // $form = ActiveForm::begin([
    //       'id' => 'active-form',
    //       'options' => [
    //   		'class' => 'form-horizontal',
    //   		'enctype' => 'multipart/form-data'
    //   	],
    // ]);
    $cont_check = '';
    $primeira_etapa = '';
    $segunda_etapa = '';
    $terceira_etapa = '';

    $i = 0;
    foreach ($checklist->chtopicos as $key => $val) {

        $item_em_questao = '<li>'. CheckboxX::widget([
                        
            'name' => 'topico['.$val->id.']',
            'value' => $val->checked,
            'initInputType' => CheckboxX::INPUT_CHECKBOX,
            // 'autoLabel' => true, //Esse campo gera o problema do Ajax duplicado!
            'pluginOptions' => [
                'threeState'=>false
            ],
            'pluginEvents' => [
                'change' => 'function() {
                    console.log("checkbox changed");
                    $.ajax({
                        method: "POST",
                        url: "'.Yii::$app->homeUrl.'pretendente/processodelocacao",
                        data: {
                            id: '.$val->id.',
                            val: $(this).prop(\'checked\'),
                            pretendente_id: '.$pretendente_id.',
                        },
                    });
                }'
            ],
            'labelSettings' => [
                'label' => '',
                'position' => CheckboxX::LABEL_LEFT
            ],
            
        ]).' '.Editable::widget([
            'name'=>'province', 
            'asPopover' => true,
            'header' => 'Tópico',
            'format' => Editable::FORMAT_BUTTON,
            'inputType' => Editable::INPUT_TEXTAREA,
                // any list of values
            'value'=>$val->conteudo,
            'options' => [
                'class'=>'',
                'style'=>'float:left',
                
            ],
            'formOptions' => [ 'action' => [
                'pretendente/editregistro',
                'id'=>$val->id
            ] ],
        ]).Html::a('<i class="glyphicon glyphicon-trash"></i>', ['deletetopico', 'id' => $val->id], [
            'class' => 'btn btn-default',
            'style' => 'border-radius: 50%;margin-right: 5px;width: 34px;padding: 5px;',
            'data' => [
                'confirm' => 'Deseja mesmo excluir esse Tópico?',
                'method' => 'post',
            ],
        ]).Html::a('<i class="glyphicon glyphicon-bell"></i>'.($val->alerta_id!=null?' Alerta Ativo':''), ['tornaralerta', 'id' => $val->id], [
            'class' => 'btn btn-'.($val->alerta_id!=null?'info':'default'),
            'style' => 'margin-right: 5px;width: auto;padding: 5px;',
            'data' => [
                'confirm' => ($val->alerta_id==null?'Deseja tornar esse tópico um Alerta?':'Deseja excluir esse Alerta'),
                'method' => 'post',
            ],
        ]).'<hr style="margin: 6px !important;">';

        if ($val->etapa == '1ª Etapa') {
            $primeira_etapa .= $item_em_questao;
        }
        if ($val->etapa == '2ª Etapa') {
            $segunda_etapa .= $item_em_questao;
        }
        if ($val->etapa == '3ª Etapa') {
            $terceira_etapa .= $item_em_questao;
        }
        $i++;
    }
    $cont_check .= '<h3><strong>';
    $cont_check .= '1ª Etapa';
    $cont_check .= '</strong></h3>';
    $cont_check .= '<ul id="ul-checks">';
    $cont_check .= $primeira_etapa;
    $cont_check .= '</ul>';
    $cont_check .= '</ul>';

    $cont_check .= '<h3><strong>';
    $cont_check .= '2ª Etapa';
    $cont_check .= '</strong></h3>';
    $cont_check .= '<ul id="ul-checks">';
    $cont_check .= $segunda_etapa;
    $cont_check .= '</ul>';
    
    
    $cont_check .= '<h3><strong>';
    $cont_check .= '3ª Etapa';
    $cont_check .= '</strong></h3>';
    $cont_check .= '<ul id="ul-checks">';
    $cont_check .= $terceira_etapa;
    $cont_check .= '</ul>';


    echo Collapse::widget([
        'items' => [
            [
                'label' => "PROCESSOS DE LOCAÇÃO DO PROPONENTE PRINCIPAL ({$pessoais->nome})",
                'content' => $cont_check,
                'contentOptions' => ['class' => 'off'],
            ],
        ]
    ]);

    //   ActiveForm::end();
    ?>
    <?php
        Modal::begin([
            'header' => '<h2>Novo Tópico</h2>',
            'toggleButton' => [
                'label' => 'Cadastratar novo Tópico',
                'class' => 'btn'
            ],
        ]);

        $novo_topico = new Chtopico;

        echo $this->render('_form_novo_topico', [
            'model' => $novo_topico,
            'checklist_id' => $checklist->id,
        ]);

        Modal::end();
    ?>
    <?php /*
    <a href="<?= Yii::$app->homeUrl.'pretendente/view?id='.$pretendente_id ?>" class="btn btn-primary">Mais Detalhes do Pretendente</a>
    */ ?>
</div>
<div class="clearfix"></div>