<?php

/* @var $this yii\web\View */

use app\models\Chtopico;
use yii\web\Response;
use app\models\LoginForm;
use yii\helpers\Html;

use app\models\Usuariopermutas as UP;
use app\models\ImovelPermuta as IP;
use app\models\SloProposta as Proposta;
use app\models\SloAgenda as Agenda;
use app\models\SloProposta as Prop;
use app\models\SaAlerta as Alerta;
use app\models\Visita;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

use yii\helpers\ArrayHelper;

use yii\bootstrap\Modal;
use kartik\grid\GridView;
use yii\bootstrap\Alert;

use deyraka\materialdashboard\widgets\CardStats;
use deyraka\materialdashboard\widgets\CardProduct;
use deyraka\materialdashboard\widgets\CardChart;
use deyraka\materialdashboard\widgets\Card;
use deyraka\materialdashboard\widgets\Progress;
use yii\helpers\Url;

// use rmrevin\yii\fontawesome\FA;

$this->title = 'Aluga Digital';
$visitas_grafico = Visita::find()->where([
    'contrato'=>'Locação',
    'YEAR(data_visita)' => "2022"
])->all();
$visitas_sim = 0;
$visitas_nao = 0;
foreach ($visitas_grafico as $key => $val) {
    if ($val->convertido == 1) {
        $visitas_sim += 1;
    }else{
        $visitas_nao += 1;
    }
}
// $visitas_semana = Visita::find()->where([
//     'contrato'=>'Locação',
//     'YEAR(data_visita)' => "2022",

// ])->orderBy([
//     'data_visita' => SORT_DESC
// ])->all();
// $visitas_sim = 0;
// $visitas_nao = 0;
// foreach ($visitas_grafico as $key => $val) {
//     if ($val->convertido == 1) {
//         $visitas_sim += 1;
//     }else{
//         $visitas_nao += 1;
//     }
// }
// echo '<br>'.$visitas_sim;
// echo '<br>'.$visitas_nao;
?>
<style>
    .imagem-icone-imovel {
        width: auto !important;
        max-width: 100% !important;
        height: 100px !important;
        border-radius: 3px !important;
        /* background-color: black; */
    }
    .imagem-icone-imovel img {
        max-width: 100% !important;
        height: auto;
        max-height: 100px !important;
        border-radius: 3px !important;
        /* background-color: black; */
        -webkit-filter: drop-shadow(1px 2px 1px #000);
        filter: drop-shadow(1px 2px 1px #000);
    }
    .ct-chart .ct-label {
        color: white !important;
        font-size: 11px !important;
        font-weight: 900 !important;
    }
</style>
<div class="site-index">
    <h5>Bem vindo, <?=Yii::$app->user->identity->nome?></h5>
    <?php 
    
    /**
     * 
        ->where([
            'atividade' => 'Atualização do Cliente'
        ])
    
        echo '<pre>';
        print_r($javisto);
        echo '</pre>';
    */
    // echo $this->render('avisos',[
    //     'idreferencia' => ''
    // ]);
    
    ?>
    <hr>
    <div class="body-content">
    <?php if(!Yii::$app->user->isGuest): ?>

        <!-- <div class="col-md-5"> -->
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <?= CardChart::widget([
                        "idchart" => 'saleschart',
                        "color" => CardChart::COLOR_WARNING,
                        "url" => Url::to(['/site/contact']),
                        "title" => "<strong style='font-weight:bold;font-size:15px'>Visitas da Semana</strong>",
                        "description" => "Atualizações",
                        "footerTextLeft" => "Pólo de Atividade",
                        "footerTextRight" => "Santa Maria",
                        "footerTextType" => CardChart::TYPE_INFO,
                        "hiddenText" => "Mais Informações",
                        "hiddenTooltip" => "Conferir o Módulo",
                    ]);
                    ?>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <?= CardChart::widget([
                        "idchart" => 'daychart',
                        "color" => CardChart::COLOR_SUCCESS,
                        "url" => Url::to(['/site/contact']),
                        "title" => "<strong style='font-weight:bold;font-size:15px'>Histórico de Locações</strong>",
                        "description" => "Relação desde 2018",
                        "footerTextLeft" => "Polo de atividades",
                        "footerTextRight" => "Santa Maria",
                        "footerTextType" => CardChart::TYPE_INFO,
                        "hiddenText" => "Mais Informações",
                        "hiddenTooltip" => "Conferir o Módulo",
                    ]);
                    ?>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <?= CardChart::widget([
                        "idchart" => 'yourchart',
                        "color" => CardChart::COLOR_PRIMARY,
                        "url" => Url::to(['/visita']),
                        "title" => "<strong style='font-weight:bold;font-size:15px'>Relação de Visitas e Conversões</strong>",
                        "description" => "Relação de 2022, Visitas não convertidas/Convertidas",
                        "footerTextLeft" => "Polo de atividades",
                        "footerTextRight" => "Santa Maria",
                        "footerTextType" => CardChart::TYPE_INFO,
                        "hiddenText" => "Mais Informações",
                        "hiddenTooltip" => "Conferir o Módulo",
                    ]);
                    ?>
                </div>
            </div>
        <!-- </div> -->
        <div class="col-md-12">
            <h3><strong>Negócios Fechados</strong></h3>
                <?php $visitas_convertidas = Visita::find()->where(['contrato'=>'Locação','convertido'=>1])->limit(3)->orderBy([
                    'data_visita' => SORT_DESC
                ])->all(); ?>
                <?php 
                    

                    foreach ($visitas_convertidas as $key => $visit) {
                        # code...
                        $imovel = $this->context->get_imovel($visit->codigo_imovel);
                        $imovel = (array)$imovel;
                        // echo "<pre>";
                        // print_r($imovel);
                        // echo "</pre>";
                        // exit();
                        $img_imovel = '';
                        $imagem_do_imovel = '';
                        $valor_locacao = 'Consulte!';

                        if(isset($imovel['imagens'])){
                            $img_imovel = $imovel['imagens'][0];
                            $imagem_do_imovel = $img_imovel->link_thumb; 
                        }
                        if(isset($imovel['valor_locacao'])){
                            $valor_locacao = 'R$ ' . number_format($imovel['valor_locacao'], 2, ',', '.');
                        }
                        
                        $foto_usuario = $visit->usuario->foto?$visit->usuario->foto:'1211811759.png';
                        // echo '<!-- Alerta -->'.
                        // "<div class='col-md-12'>
                        //     <div class='dashbord dashbord-lightblue' style='margin-top: 1px;margin-bottom: 1px; width: 100%'>
                        //         <div class='icon-section'>
                        //         <img src='".($imagem_do_imovel?$imagem_do_imovel:Yii::$app->homeUrl.'icones/logo_site.png')."' class='float-left imagem-icone-imovel'/>
                        //         <img src='".Yii::$app->homeUrl.'usuarios/'.$foto_usuario."' class='float-left imagem-icone' style='margin-left: -45px;margin-top: 40px;'/>
                        //         <h4 style='padding: 10px;text-align: left;'>
                        //             <span class='fa fa-calendar' style='color: gray !important;margin:3px;'></span> ".date('d/m/Y', strtotime($visit->data_visita))."
                        //             <br><strong style='margin-left: 15px'>{$visit->idCorretor->nome} - PIN {$visit->codigo_imovel}</strong>
                        //             <br><strong style='margin-left: 15px'>{$valor_locacao}</strong>
                        //             <br><label class='badge' style='margin: 10px; background-color: green; padding:5px'>Alugado!</label>                         
                        //         </h4> 
                        //         </div>
                        //     </div>
                        // </div>";

                        // echo '<pre>';
                        // print_r($this->context->get_imovel($visit->codigo_imovel));
                        // echo '</pre>';
                        ?>
                        <div class="col-lg-4">
                            <?php
                                Card::begin([  
                                    'id' => 'card_'.$visit->idvisita, 
                                    'color' => Card::COLOR_SUCCESS, 
                                    'headerIcon' => "<img src='".Yii::$app->homeUrl.'usuarios/'.$foto_usuario."' class='float-left imagem-icone' style='width:100%;'/>", 
                                    'collapsable' => false,
                                    'title' => '<strong>'.$visit->idCorretor->nome.'</strong>', 
                                    'titleTextType' => Card::TYPE_SUCCESS, 
                                    'showFooter' => true,
                                    'footerContent' => 'Visita feita em '.date('d/m/Y', strtotime($visit->data_visita)),
                                ])
                            ?>
                            <!-- START your <body> content of the Card below this line  -->
                            <span class='col-md-6'><div class='float-left imagem-icone-imovel'><?="<img src='".($imagem_do_imovel?$imagem_do_imovel:Yii::$app->homeUrl.'icones/logo_site.png')."'/>"?></div></span>
                            <div class='col-md-6' style="box-shadow: 0 1px 4px 0 rgb(0 0 0 / 14%);background-color:ghostwhite">
                                <h3>
                                    <strong style="font-weight: bolder;"><i class="material-icons">key</i> <?=" PIN {$visit->codigo_imovel}"?></strong>                
                                </h3>
                                <p>
                                    <strong>Cliente: </strong>
                                    <?=$visit->nome_cliente?>
                                </p>
                            </div>
                            <!-- END your <body> content of the Card above this line, right before "Card::end()"  -->                
                            <?php Card::end(); ?>
                        </div>
                        <?php
                    }
                ?>
            <div class='clearfix'></div>
        </div>
        

    </div>
    <div class="clearfix col-md-12"><br></div>

    <div class="col-lg-12">
        <?php
            echo Progress::widget([
                'title' => 'Desenvolvimento DO SISTEMA',
                'value' => 80,
                'color' => Progress::COLOR_SUCCESS,
                'isBarStrip' => true,
                'isBarAnimated' => true,
                'titleTextType' => Progress::TYPE_SUCCESS
            ]);
            ?>
    </div>
    <div class="row">
    <!-- <div class="col-lg-3 col-md-6 col-sm-6">
        <?php //=
        // CardStats::widget(
        //     [
        //         "color" => Cardstats::COLOR_PRIMARY,
        //         "headerIcon" => "weekend",
        //         "title" => "Today's sale",
        //         "subtitle" => "184",
        //         "footerIcon" => "warning",
        //         "footerText" => "Check this out",
        //         "footerUrl" => Url::to(['site/login']),
        //         "footerTextType" => Cardstats::TYPE_INFO,
        //     ]
        // )
        ?>
    </div>
</div> -->
    <div class="clearfix col-md-12">
    <hr style="padding: 0 1px;">
    </div>
    <div class="col-md-12">
        <h3>PROPOSTAS</h3>
        <?php
            $searchModel = new \app\models\PropostaSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            
        ?>
        <?php
            // $historicos = app\models\Userhistvisto::find()->where([
            //     'usuario_id' => Yii::$app->user->identity->id,
            // ])->all();
            // $ids_naovistos = [];
            // foreach ($historicos as $e) {
            //     array_push($ids_naovistos, $e->historico->id_referencia);
            // }
            // $h = app\models\Historico::find()->where([
            //     'atividade' => 'Atualização do Cliente'
            // ])->all();
            // $ids_naovistos2 = [];
            // foreach ($h as $hh) {
            //     array_push($ids_naovistos2, $hh->id_referencia);
            // }
            // echo '<pre>';
            // print_r($ids_naovistos);
            // print_r($ids_naovistos2);
            // echo '</pre>';
        ?>
        <?= GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'rowOptions' => function($data){
                    $historicos = app\models\Userhistvisto::find()->where([
                        'usuario_id' => Yii::$app->user->identity->id,
                    ])->all();
                    $ids_naovistos = [];
                    $ids_naovistos2 = [];
                    foreach ($historicos as $e) {
                        array_push($ids_naovistos, $e->historico->id_referencia);
                    }

                    $h = app\models\Historico::find()->where([
                        'atividade' => 'Atualização do Cliente'
                    ])->all();

                    foreach ($h as $hh) {
                        array_push($ids_naovistos2, $hh->id_referencia);
                    }
                    
                    // if(!in_array($data->proponente->id, $ids_naovistos) and
                    // in_array($data->proponente->id, $ids_naovistos2)){
                    //     return ['class' => 'danger'];
                    // } elseif (in_array($data->proponente->id, $ids_naovistos2)) {
                    //     return ['class' => 'danger'];
                    // }
                },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    // [
                    //     'attribute'=>'id',
                    //     'format' => 'raw',
                    //     'header' => '<i class="fa fa-bell"></i>',
                    //     'value' => function($data) {
                    //         $historicos = app\models\Userhistvisto::find()->where([
                    //             'usuario_id' => Yii::$app->user->identity->id,
                    //         ])->all();
                    //         $ids_naovistos = [];
                    //         $ids_naovistos2 = [];
                    //         foreach ($historicos as $e) {
                    //             array_push($ids_naovistos, $e->historico->id_referencia);
                    //         }
        
                    //         $h = app\models\Historico::find()->where([
                    //             'atividade' => 'Atualização do Cliente'
                    //         ])->all();
        
                    //         foreach ($h as $hh) {
                    //             array_push($ids_naovistos2, $hh->id_referencia);
                    //         }
                    //         if(!in_array($data->proponente->id, $ids_naovistos) and
                    //             in_array($data->proponente->id, $ids_naovistos2)
                    //         ){
                    //             return '<i style="color: red" class="fa fa-bell" title="'.$hh->descricao.'"></i>';
                    //         } elseif (in_array($data->proponente->id, $ids_naovistos2)) {
                    //             return '<i style="color: red" class="fa fa-bell" title="'.$hh->descricao.'"></i>';
                    //         } else {
                    //             return '<i style="color: green" class="fa fa-check"></i>';
                    //         }
                    //     }
                    // ],
                    [
                        'attribute'=> 'id',
                        'headerOptions'=> [
                            'style' => 'width: 5%',
                        ],
                        'header' => 'Id'
                    ],
                    [
                        'attribute' => 'codigo_imovel',
                        'header' => 'Imóvel',
                        'format'=>'raw',
                        'value' => function($data) {
                            if (!empty($data->codigo_imovel)) {
                                return '<a href="https://www.alugadigital.com.br/imovel/'.$data->codigo_imovel.'" target="blanck">PIN-'.$data->codigo_imovel."&nbsp;&nbsp;<i class='fa fa-home'></i>".'</a>';
                            } else {
                                return 'Indefinido';
                            }
                        }
                    ],
                    [
                        'header'=>'Proponente Principal',
                        'format'=>'raw',
                        'value'=> function($data){
                            $link = Yii::$app->homeUrl."proposta/update?id={$data->id}";
                            return "<a href='{$link}'>".$data->nome."&nbsp;&nbsp;<i class='fa fa-arrow-right'></i></a>";
                        }
                    ],
                    'tipo',
                    [
                        'header' =>'Início',
                        'attribute' => 'data_inicio',
                        'value' => function($data) {
                            return date('d/m/Y H:i:s', strtotime($data->data_inicio));
                        }
                    ],
                    [
                        'header' =>'Tempo',
                        'attribute' => 'data_inicio',
                        'value' => function($data) {
                            $now = time();
                            $your_date = strtotime($data->data_inicio);
                            $datediff = $now - $your_date;
                            $retorno = round(($datediff / (60 * 60 * 24)));
                            if($retorno == 1){
                                return 'Hoje!';
                            }
                            else if ($retorno == 0) {
                                return 'Hoje!';
                            }
                            else {
                                $retorno = $retorno -1;
                                if ($retorno > 1) return $retorno.' dias';
                                else return $retorno.' dia';
                            }
                        }
                    ],
                    [
                        'header'=>'Estágio',
                        'format' => 'raw',
                        'value'=> function($data){
                            $checklist = [];
                            if (isset($data->proponente->checklists)) {
                                $checklist = $data->proponente->checklists;
                            }
                            $return = '<strong style="color: red">Sem Pretendente</strong>';
                            
                            if ($data->tipo == 'Credpago') {
                                switch ($data->etapa_andamento) {
                                    case 1: $return = 'Cadastro'; break;
                                    case 2: $return = 'Análise'; break;
                                    case 3: $return = 'Aprovação'; break;
                                    case 4: $return = 'Resultado'; break;
                                    case 5: $return = 'Assinatura de Contrato'; break;
                                    case 6: $return = 'Vistoria e Entrega de Chaves'; break;
                                }
                            } else {
                                switch ($data->etapa_andamento) {
                                    case 1: $return = 'Cadastro'; break;
                                    case 2: $return = 'Análise'; break;
                                    case 3: $return = 'Aprovação'; break;
                                    case 4: $return = 'Assinatura de Contrato'; break;
                                    case 5: $return = 'Vistoria e Entrega de Chaves'; break;
                                }
                            }
                            

                            $return.= '<br>';

                            if ($checklist) {
                                foreach ($checklist as $key => $check) {
                                    $ultimo_topico = Chtopico::find()->where([
                                        'checklist_id' => $check,
                                        'checked' => 1
                                    ])->orderBy(['id'=>SORT_DESC])->one();
                                    if($ultimo_topico){
                                        $return.= $ultimo_topico->conteudo;
                                    }
                                }
                            }
                            return $return;
                        }
                    ],
                    /*
                    [
                        'attribute' => 'id',
                        'header' => 'Gerenciar',
                        'headerOptions' => [
                            'style' => 'text-align: center',
                        ],
                        'format' => 'raw',
                        'value' => function($data) {
                            return  '<div class="col-md-12">'.
                                    '<a title="Acessar" class="btn btn-primary col-md-6" href="'.Yii::$app->homeUrl.'proposta/update?id='.$data->id.'"><i class="fas fa-external-link-square-alt"></i></a>'.
                                    // '<div class="col-md-1"></div>'.
                                    ( Yii::$app->user->can('administrador') ?
                                    Html::a('<i class="fa fa-remove"></i> Excluir', ['proposta/delete', 'id' => $data->id], [
                                        'class' => 'btn btn-link col-md-4',
                                        'style' => 'color: red',
                                        'title' => 'Excluir Proposta',
                                        'data' => [
                                            'confirm' => "<h3>Tens certeza que deseja excluir esse registro?</h3>
                                            Cliente: <strong>{$data->proponente->sloInfospessoais->nome}</strong>
                                                <p style='color: red'>
                                                <strong>!!! Atenção !!!</strong><br>
                                                Todos os Proponentes e Documentos relacionados à essa proposta
                                                também serão excluídos.
                                                </p>
                                            ",
                                            'method' => 'post',
                                        ],
                                    ])
                                    : '').
                                    '</div>';
                        }
                    ],
                    */
                    // 'prazo_responder',
                    // 'proprietario',
                    // 'proprietario_info:ntext',
                    // 'codigo_imovel',
                    // 'imovel_valores',
                    // 'tipo_imovel',
                    // 'motivo_locacao',
                    // 'endereco',
                    // 'complemento',
                    // 'bairro',
                    // 'cidade',
                    // 'estado',
                    // 'cep',
                    // 'dormitorios',
                    // 'aluguel',
                    // 'iptu',
                    // 'condominio',
                    // 'agua',
                    // 'luz',
                    // 'gas_encanado',
                    // 'total',
                    // 'numero',
                    // 'opcoes',
                    // 'usuario_id',
                    // 'atvc_empresa',
                    // 'atvc_cnpj',
                    // 'atvc_nome_fantasia',
                    // 'atvc_atividade',
                    // 'atvc_data_constituicao',
                    // 'atvc_contato',
                    // 'atvc_telefone',
                    // ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        <?php 
        
        
        /*
          <?php $propostas = Prop::find()->all();?>
          <?php foreach ($propostas as $row) {
            echo "<div class='clearfix'></div>";
            echo "<br>";
            echo '<div class="col-md-6" style="padding-left: 0px;">';
            echo Html::a('PROPOSTA - Pin-'.$row->codigo_imovel, [
                    'proposta/view',
                    'id' => $row->id,
                ], [
                    'class' => 'btn btn-success',
                    'style' => 'float: left; width: 100%; font-weight: bolder;',
                    'target'=>'_blank'
            ]);
            echo "</div>";
            echo '<div class="col-md-6" style="padding: 0px;">';
            echo Html::a('NOVO PRETENDENTE', [
                    'proposta/pretendente001',
                    'proposta_id' => $row->id,
                    'pretendente_id' => 'novo'
                ], [
                    'class' => 'btn btn-primary',
                    'style' => 'float: rigth; width: 100%',
                    'target'=>'_blank'
            ]);
            echo "</div>";
            echo "<div class='clearfix'></div>";
            echo "<br>";
            echo "<div class='col-md-8' style='padding: 0px'>";
            echo '<input style="background-color: lightgray; height: 35px; width: 100%" type="text" value="https:://www.cafeinteligencia.com.br'.Yii::$app->homeUrl.'proposta/pretendente001?proposta_id='.$row->id.'&pretendente_id=novo" id="myInput">';
            echo "</div>";

            echo '<div class="col-md-4" style="margin-top: 0px !important;padding-right: 0px;padding-left: 0px;">';
            echo '<button id="btn-copia" class="btn btn-info" alt="Copiar Link!" title="Copiar Link!">
                  <i class="far fa-copy"></i> Copiar Link</button>';
            echo "</div>";
            echo "<div class='clearfix'></div>";
            echo "<br>";
            echo "<label>Número de Pretendentes: <b>12</b></label>";
            // echo "</div>";
            echo '<div class="clearfix"></div>';
            echo '<hr>';

            $this->registerJs('$("#btn-copia").on("click", function() {
                var copyText = document.getElementById("myInput");
                copyText.select();
                copyText.setSelectionRange(0, 99999);

                document.execCommand("copy");
                console.log("Copied the text: " + copyText.value);
              });');
          } ?> 
    */  ?>
    </div>
    <?php /*
    <div class="clearfix col-md-12">
    <hr style="padding: 0 1px;">
    </div>
    <?php if (!Yii::$app->user->can('cliente')): ?>
        <div class="col-md-6">
            <h3>Suas Permutas</h3>
            <hr>
            <?php
                $permutas = UP::find()->where(['usuario'=>Yii::$app->user->identity->id])->all();
                foreach ($permutas as $row) {
                    $permuta = IP::find()->where(['idimovel_permuta'=>$row->permuta])->one();
                    echo '<div class="col-md-6">';
                    // echo '<div class="col-md-6">';
                    echo '<a href="'.Yii::$app->homeUrl.'imovelpermuta/view?id='.$permuta['idimovel_permuta'].'" target="blanck" class="btn btn-info" style="margin-bottom:4%;width:100%">';
                    echo '<div class="col-md-12">';
                    echo 'Código: PIN - '.$permuta['codigo'].'<br>';
                    echo 'Tipo: '.substr($permuta['tipo'],0,18).'(...)<br>';
                    echo 'Valor: '.'R$ ' . number_format($permuta['valor_maximo'], 2, ',', '.').'<br>';
                    echo '<label alt="dormitórios" title="dormitórios" style="padding:3px"><span class="glyphicon glyphicon-bed"></span> '.$permuta['dormitorios'].'</label>';
                    echo '<label alt="garagens" title="garagens" style="padding:3px"><span class="glyphicon glyphicon-th"></span> '.$permuta['garagens'].'</label>';
                    if ($permuta['elevador'] != 0) {
                        echo '<label alt="elevador" title="elevador" style="padding:3px"><span class="glyphicon glyphicon-collapse-up"></span></label>';
                    }
                    if ($permuta['sacada'] != 0) {
                        echo '<label alt="sacada" title="sacada" style="padding:3px"><span class="glyphicon glyphicon-modal-window"></span></label>';
                    }
                    echo '</div>';
                    echo '<div class="col-md-12" style="">';
                    echo '<label alt="área privativa" title="área privativa" style="">
                        <span class="glyphicon glyphicon-fullscreen"></span> Área Privativa: '.number_format($permuta['area_privativa'], 2, ',', '.').' m²</label>';
                    echo '<br>';
                    echo '<label alt="área total" title="área total" style="">
                        <span class="glyphicon glyphicon-fullscreen"></span> Área Total: '.number_format($permuta['area_total'], 2, ',', '.').' m²</label>';
                    echo '</div>';
                    echo '<div class="col-md-12">';
                    // echo 'Bairro: '.$row['bairros'].'<br>';
                    echo '</div>';
                    echo '</a>';
                    // echo '</div>';
                    // echo '<div class="col-md-6">';
                    // echo '<h4>Permutas compatíveis</h4>';

                    // echo '</div>';
                    echo '</div>';
                }
            ?>
        </div>

        <div class="col-md-6" style="border-left: 1px solid #eee">
            <h3>Seus tópicos favoritos</h3>
            <hr>
            <?php

                $favoritos = app\models\TopicoMembros::find()->where([
                    'usuario_id' => Yii::$app->user->identity->id,
                    'favorito' => 1
                ])->all();
                $idstopicos = [];
                foreach ($favoritos as $value) {
                    # code...
                    array_push($idstopicos,$value->topico_idtopico);
                }

                $topicos = app\models\CyberTopico::find()->where(['idtopico'=>$idstopicos])->all();

                foreach ($topicos as $row) {
                    // echo $row->titulo.',<br>';
                    echo Html::a('<h4><i class="fas fa-star"></i> '.$row->titulo.'</h4>
                        <hr style="margin: 0 2%">
                        <p>'.
                        nl2br($row->descricao)
                        .'</p>',
                    [
                        '/cybertopico/view',
                        'idtopico' => $row->idtopico,
                        'cyber_idcyber' => $row->cyber_idcyber,
                    ], [
                        'class' => 'btn col-md-12',
                        'style' => 'white-space: pre-line;border:1px solid #eee;color:gray;'
                    ]);
                    echo "<div class='col-md-12 clearfix'><br /></div>";
                }
            ?>
        </div>
    <?php else: ?>
        <!-- Aqui a área de resumos e avisos do Cliente! -->
        <?php
            echo '<div class="col-md-12">';
            echo "<h3>Visitas Marcadas para você:</h3><br>";
            $cliente = app\models\SloCliente::find()->where(['nome'=>Yii::$app->user->identity->nome])->one();
            $agendas = Agenda::find()->where(['slo_cliente_id' => $cliente->id])->all();
            foreach ($agendas as $row) {
                # code...
                echo "<div class='col-md-3'>";
                // echo "<a class='btn btn-primary btn-proposta' href='#'>";
                    echo "<div class='btn-agenda'>";
                        echo '<h3><i class="far fa-clock"></i></h3>';
                        echo "<label>Proposta: PIN-".$row->sloProposta->codigo_imovel.'</label><br>';
                        echo "<label>Data:</label> ".date('d/m/Y',strtotime($row->data)).'<br>';
                        echo "<label>Hora:</label> ".$row->hora.' ('.$row->turno.')'.'<br>';
                        echo "<label>Com o Corretor:</label> ".$row->corretorIdcorretor->nome.'<br>';
                    echo "</div>";
                // echo "</a>";
                echo "</div>";
            }
            echo "</div>";
            echo '<div class="col-md-12 clearfix">';
            echo "<hr>";
            echo "</div>";
            echo '<div class="col-md-12"><h3>Propostas disponíveis:</h3><br>';
            $propostas = Proposta::find()->all();
            foreach ($propostas as $row) {
                # code...
                echo "<div class='col-md-4'>";
                    echo "<a class='btn btn-primary btn-proposta' href='".Yii::$app->homeUrl.'proposta/'."'>";
                        echo "<div class='col-md-4'>";
                            echo "<img src='https://cafeinteligencia27-mrwru33hbcqg1251.netdna-ssl.com/assets/images/logo_site.png'/>";
                        echo "</div>";
                        echo "<div class='col-md-8'>";
                            echo '<h4><b>PIN-'.$row->codigo_imovel.'</b></h4>';
                            echo '<label>Prazo/responder:</label><br>'.date('d/m/Y',strtotime($row->prazo_responder)).'<br>';
                            echo '<label>Valores do Imóvel:</label><br>'.$row->imovel_valores.'<br>';
                        echo "</div>";
                    echo "</a>";
                echo "</div>";
            }
            echo "</div>";


        ?>
    <?php endif; ?>
    */ ?>
</div>
<?php
//Seta permissão
/*

$auth = \Yii::$app->authManager;
//Add um NOVO
//$novo_tipo_usuario  = $auth->createRole('cliente');
//Selecionar UM
$novo_tipo_usuario  = $auth->getRole('cliente');
//Cria Permissão
$permissao = $auth->createPermission('cliente-indexa');
//Add Items
//$auth->add($novo_tipo_usuario);
$auth->add($permissao);

//$perm = $auth->getPermission('cliente-indexa');

$auth->addChild($novo_tipo_usuario, $permissao);

// $auth->assign($novo_tipo_usuario,16);
*/
// Mover "*/" para cima junto de "/*" Para redefinir/definir permissões
?>
<?php else:
    // if (!Yii::$app->user->isGuest) {
        // return $this->goHome();
    // }
    // $model = new LoginForm();
    // if ($model->load(Yii::$app->request->post()) && $model->login()) {
    //     return $this->render('indexlocacao');
    // }
    // echo $this->render('login', [
    //     'model' => $model,
    // ]);
    return $this->context->redirect('index');
?>

<?php endif; ?>
<script>
        //SCRIPT FOR LINE AND BAR CHART
        var data = {
            // A labels array that can contain any sort of values
            labels: ['S', 'T', 'Q', 'Q', 'S', 'S'],
            // Our series array that contains series objects or in this case series data arrays
            series: [
                [3, 2, 9, 5, 4, 3],
            ]
        };
        var dataAnos = {
            // A labels array that can contain any sort of values
            labels: ['2018', '2019', '2020', '2021', '2022'],
            // Our series array that contains series objects or in this case series data arrays
            series: [
                [5, 2, 4, 2, 4, 3],
                [3, 2, 9, 5, 4, 5],
            ]
        };
        // We are setting a few options for our chart and override the defaults
        var options = {
            // Don't draw the line chart points
            showPoint: true,
            // Disable line smoothing
            lineSmooth: false,
            // X-Axis specific configuration
            axisX: {
                // We can disable the grid for this axis
                showGrid: true,
                // and also don't show the label
                showLabel: true
            },
            // Y-Axis specific configuration
            axisY: {
                // Lets offset the chart a bit from the labels
                offset: 60,
                // The label interpolation function enables you to modify the values
                // used for the labels on each axis. Here we are converting the
                // values into million pound.
                labelInterpolationFnc: function(value) {
                    // return 'Rp ' + value + 'jt';
                    return value;
                }
            }
        };

        // Create a new line chart object where as first parameter we pass in a selector
        // that is resolving to our chart container element. The Second parameter
        // is the actual data object.
        // new Chartist.Bar('.ct-chart', data, options);
        new Chartist.Bar('#saleschart', data, options);
        new Chartist.Line('#daychart', dataAnos, options);
        new Chartist.Pie('#yourchart', data, options);
        // new Chartist.Bar('#herchart', data, options);

        //SCRIPT FOR PIE CHART
        var data2 = {
            labels: ['Bananas', 'Apples', 'Grapes'],
            series: [20, 15, 40]
        };

        var options2 = {
        labelInterpolationFnc: function(value) {
            return value[0]
        }
        };

        var responsiveOptions = [
            ['screen and (min-width: 640px)', {
                chartPadding: 30,
                labelOffset: 100,
                labelDirection: 'explode',
                labelInterpolationFnc: function(value) {
                return value;
                }
            }],
            ['screen and (min-width: 1024px)', {
                labelOffset: 80,
                chartPadding: 20
            }]
        ];

        new Chartist.Pie('#herchart', data2, options2, responsiveOptions);

        new Chartist.Pie('#yourchart', {
            series: [<?=$visitas_nao?>, <?=$visitas_sim?>],
            labels: ['Não Convertidas', 'Convertidas']
            }, {
            donut: true,
            donutWidth: 20,
            donutSolid: true,
            startAngle: 270,
            showLabel: true,
            showLegend: true,
        });
    </script>