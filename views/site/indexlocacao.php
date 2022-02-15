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

// use rmrevin\yii\fontawesome\FA;

$this->title = 'Café Inteligência Imobiliária';

?>
<style type="text/css">
    #acoisatoda{
      /* background-color: #dcdcdc !important; */
      padding: 30px;
      width: 100%;
    }
    #acoisatoda .col-md-2{
        margin-top: 25px;
    }
    #acoisatoda .glyphicon, #acoisatoda .fa, #acoisatoda .fas{
        color: gray !important;
    }
    /* #acoisatoda img {
        filter: brightness(0.0) opacity(40%);
    } */
    /* #acoisatoda .btn, .btn-info {
        color: black !important;
        background-color: lightgray;
        border: gray;
    }
    #acoisatoda .btn-info:hover {
        background-color: darkgray;
    } */
    #acoisatoda .badge {
        right: -2% !important;
    }
    /*Propostas*/
    .btn-proposta{
        width: 100%;
        background-color: gray !important;
        /*margin: 2%;*/
    }
    .btn-proposta img{
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 1px solid #fff;
        float: left;
        background-color: white;
    }
    /*Agendas*/
    .btn-agenda{
        background-color: lightyellow !important;
        padding: 5%;
        margin-bottom: 5%;
        width: 100%;
        text-align: center;
        box-shadow: 5px 5px lightgray;
    }
    #acoisatoda .titulo-item {
        width: 100%;
        background-color: cadetblue;
        text-align: center;
        text-transform: uppercase;
        margin-top: 0px;
        margin-bottom: 20px;
        height: 50px;
        padding: 15px;
        color: lightblue;
        font-weight: bold;
    }
    #acoisatoda .item {
      border: 1px solid lightgray;
      /* border-radius: 10px; */
      /* box-shadow: gray 5px 5px; */
      padding: 1%;
      /* background: linear-gradient(180deg, rgba(248,248,255,1) 10%, rgba(220,220,220,1) 0%); */
      /* margin: 1%; */
      /* height: auto */
      background-color: aliceblue !important;
    }
    #btn-copia {
      border-radius: 0px !important;
      float: left; width:100%;
    }
    .btn-title-add{
        position: absolute;
        right: 5%;
        top: 2.3%;
        /* font-size: 30px; */
        /* padding: 10px; */
        /* border-radius: 50%; */
        /* margin-top: -25px; */
        /* margin-bottom: 10px; */
        /* width: 55px; */
    }
    .dashbord .icon-section i {
        margin-top: -9px !important;
        border: 4px solid white;
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
    echo $this->render('avisos',[
        'idreferencia' => ''
    ]);
    
    ?>
    <hr>
    <div class="col-md-12" id="acoisatoda">
    <?php if(!Yii::$app->user->isGuest): ?>

        <div class="col-md-5">
            <div class="item" style="background-color: white">
                <h4 class="titulo-item">
                    Pendências
                </h4>
                <?php
                    $Alerta = new Alerta();
                    Modal::begin([
                        'header' => '<h2>Novo Alerta</h2>',
                        'size' => 'modal-lg',
                        'options' => ['tabindex' => false ],
                        'toggleButton' => [
                            'label' => "<i class='fa fa-plus'></i>",
                            'class' => 'float-right btn btn-info btn-title-add'
                        ],
                    ]);
                ?>
                <?= $this->render('/alerta/_form', [
                    'model' => $Alerta,
                    'modo' => 'create'
                ]) ?>
                <?php Modal::end(); ?>
                <?php /*
                <div class="col-md-12">
                    <?php if (Yii::$app->user->can('administrador') || Yii::$app->user->can('locacao')): ?>
                        <div class="col-md-6" style="text-align:center">
                            <a href="<?=Yii::$app->homeUrl.'proposta'?>" class="btn btn-default" style="width: 135px;">
                                <label class="badge" style="position: absolute;top: -6%;">
                                    <?= number_format(app\models\SloProposta::find()->count(),0,",",".") ?>
                                </label>
                                <i class="fas fa-comments-dollar" style="font-size:70px; height:80px;"></i>
                                <hr style="margin-top:5px;margin-bottom:5px">
                                Registro de<br>Propostas
                            </a>
                        </div>

                    <?php endif; ?>

                    <div class="col-md-6" style="text-align:center">
                        <a href="<?=Yii::$app->homeUrl.'sloagenda'?>" class="btn btn-default" style="width: 135px;">
                            <?php if (Yii::$app->user->can('administrador')): ?>
                                <label class="badge" style="position: absolute;top: -6%;">
                                    <?= number_format(app\models\SloAgenda::find()->count(),0,",",".") ?>
                                </label>
                            <?php endif; ?>
                            <img src="<?=Yii::$app->homeUrl.'icones/visita_blue.png'?>" alt="" height="80" style="-moz-transform: scaleX(-1);-o-transform: scaleX(-1);-webkit-transform: scaleX(-1);transform: scaleX(-1);">
                            <hr style="margin-top:5px;margin-bottom:5px">
                            Agenda de <br>Visitas
                        </a>
                    </div>
                
                </div>
                */?>
                <?php 
                    $alertasdousuario = \app\models\SaAlertausuarios::findAll(['usuario_id'=>Yii::$app->user->identity->id]);
                    $ids_alertas = [];
                    foreach ($alertasdousuario as $key => $value) {
                        $ids_alertas[$value['sa_alerta_id']] = $value['sa_alerta_id'];
                    }
                    $alertas = \app\models\SaAlerta::find()->where(['id'=>$ids_alertas])->orWhere(['or',
                       ['usuario_id'=>Yii::$app->user->identity->id],
                    ])->limit(5)->orderBy([
                        'data_limite' => SORT_DESC
                    ])->all();
                    foreach ($alertas as $key => $alert) {
                        // echo '<!-- Alerta -->'.
                        // "<div class='col-md-8 dashbord dashbord-green'>
                        //     <div class='icon-section'>
                        //         <i class='fa fa-bell' aria-hidden='false'></i>
                        //         <h3><strong>{$alert->titulo}</strong></h3>
                        //         <p>{$alert->descricao}</p>
                        //     </div>
                        // </div>";
                        $nome_pretendente = ($alert->pretendente?"<br><hr style='margin:10px;border-color:lightgray'><span style='color: cadetblue'>Proponente: <b>{$alert->slopretendente->sloInfospessoais->nome}</b></span>":'');
                        $foto_usuario = $alert->usuario->foto ? $alert->usuario->foto : '1211811759.png';
                        echo '<!-- Alerta -->'.
                        "";
                        $valido = 'Válido';
                        $cormodal = 'green';
                        if(date('Y-m-d',strtotime($alert->data_limite)) > date('Y-m-d')) {
                            $cormodal = 'lightblue';
                            $coritem = 'dashbord-lightblue';
                            $valido = 'Válido';
                            $estilotitulomodal = [
                                'background-color' => 'lightblue',
                                'color' => 'darkblue',
                                'font-weight' => 'bold',
                                'font-size' => '20px',
                                'text-align'=> 'center'
                            ];
                        } else {
                            $cormodal = 'bisque';
                            $coritem = 'dashbord-red';
                            $valido = 'Vencido';
                            $estilotitulomodal = [
                                'background-color' => 'bisque',
                                'color' => 'darkred',
                                'font-weight' => 'bold',
                                'font-size' => '20px',
                                'text-align'=> 'center'
                            ];
                        }
                        Modal::begin([
                            'header' => 'Prazo: '.$valido,//$alert->titulo,
                            // 'size' => 'modal-lg',
                            'bodyOptions' => [
                                'style' => [
                                    'background-color' => $cormodal,
                                    'padding' => '10px'
                                ]
                            ],
                            'headerOptions' => [
                                'style' => $estilotitulomodal,
                            ],
                            'footerOptions' => [
                                'style' => $estilotitulomodal,
                            ],
                            'toggleButton' => [
                                'label' => "<div class='col-md-12'>
                                    <div class='dashbord $coritem' style='margin-top:5px;margin-bottom:-5px; width: 100%;'>
                                        <div class='icon-section'>
                                        <img src='".Yii::$app->homeUrl.'usuarios/'.$foto_usuario."' class='float-right imagem-icone'/>
                                        <h4 style='padding: 10px;text-align: left;'>
                                            <span class='fa fa-bell' style='color: gray !important;margin:3px;'></span> ".date('d/m/Y', strtotime($alert->data_criacao))."
                                            <strong>{$alert->titulo}</strong>
                                            $nome_pretendente
                                        </h4> 
                                        </div>
                                    </div>
                                </div>",
                                // 'class' => 'btn btn-success',
                                'style' => 'margin: 0px; width: 100%;background: transparent;border:0px !important'
                            ],
                            'footer' => Html::a('Excluir', ['/alerta/delete', 'id' => $alert->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                            ])
                        ]);
                        
                        // $model2 = Alerta::findOne($alert->id);
                        // echo $this->render('/alerta/view', [
                        //     'model' => $model2,
                        //     'ativo' => false
                        // ]);
                        // echo $alert->descricao;
                        ?>
                        <h2><strong><?= $alert->titulo ?></strong></h2>
                        <h4>Validade: <strong><?= date('d/m/Y', strtotime($alert->data_criacao)) . ' - '.date('d/m/Y', strtotime($alert->data_limite)).' <br>' ?></strong></h4>
                        <h4>Categoria: <?=$alert->categoria?></h4>
                        <h4>Pretendente: <?=$alert->pretendente?$alert->slopretendente->sloInfospessoais->nome:'não informado'?></h4>
                        <strong>Observações</strong><br>
                        <p><?= $alert->descricao ?></p>
                        <?php
                        Modal::end();
                    }            
                ?>
            <div class='clearfix'></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="item">
                <h4 class="titulo-item">Negócios Fechados</h4>
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
                        echo '<!-- Alerta -->'.
                        "<div class='col-md-12'>
                            <div class='dashbord dashbord-lightblue' style='margin-top: 1px;margin-bottom: 1px; width: 100%'>
                                <div class='icon-section'>
                                <img src='".($imagem_do_imovel?$imagem_do_imovel:Yii::$app->homeUrl.'icones/logo_site.png')."' class='float-left imagem-icone-imovel'/>
                                <img src='".Yii::$app->homeUrl.'usuarios/'.$foto_usuario."' class='float-left imagem-icone' style='margin-left: -45px;margin-top: 40px;'/>
                                <h4 style='padding: 10px;text-align: left;'>
                                    <span class='fa fa-calendar' style='color: gray !important;margin:3px;'></span> ".date('d/m/Y', strtotime($visit->data_visita))."
                                    <br><strong style='margin-left: 15px'>{$visit->idCorretor->nome} - PIN {$visit->codigo_imovel}</strong>
                                    <br><strong style='margin-left: 15px'>{$valor_locacao}</strong>
                                    <br><label class='badge' style='margin: 10px; background-color: green; padding:5px'>Alugado!</label>                         
                                </h4> 
                                </div>
                            </div>
                        </div>";

                        // echo '<pre>';
                        // print_r($this->context->get_imovel($visit->codigo_imovel));
                        // echo '</pre>';
                    }
                ?>
            <div class='clearfix'></div>
            </div>
        </div>
        <div class="col-md-3"><div class="item">
          <h4 class="titulo-item">Visitas de Locação</h4>
          <?php
            $visitas_grafico = Visita::find()->where(['contrato'=>'Locação'])->orderBy([
                'data_visita' => SORT_DESC
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
            echo Highcharts::widget([
                 'options' => [
                   'scripts' => [
                       'highcharts-pie',
                   ],
                   'plotOptions' => [ // it is important here is code for change depth and use pie as donut
                      'pie' => [
                          'allowPointSelect' => true,
                          'cursor' => 'pointer',
                          'innerSize' => 100,
                          'depth' => 45,
                          'showInLegend' => true,
                      ]
                  ],
                  'type' => 'pie',
                    'title' => [
                        'text' => 'Relação de Visitas Convertidas'
                    ],
                    'subtitle' => [
                        'text'=> 'Visitas',
                        'align'=> 'center',
                        'verticalAlign'=> 'middle',
                        'style'=> [
                            'fontSize' => '22px',
                            'background-color' => 'red'
                        ],
                        'y' => 15
                    ],
                    'chart' => [
                          'height' => 350,
                          'zoomType' => 'x',
                    ],
                    'series' => [
                      [
                          'name' => 'Relação de Visitas Convertidas em Locação',
                          'data' => [
                            ['name'=>'Convertidas ','y'=>$visitas_sim,'color'=>'green'],
                            ['name'=>'Não Convertidas ','y'=>$visitas_nao,'color'=>'lightgray'],
                            // ['name'=>'Aguardando ','y'=>40,'color'=>'yellow'],
                          ],
                          'type' => 'pie',
                          'showInLegend' => true,
                          'dataLabels' => [
                              'enabled' => false,
                          ],
                      ],
                    ]
                 ]
              ]);
           ?>
        </div></div>
        

    </div>
    <div class="clearfix col-md-12"><br></div>


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
                    
                    if(!in_array($data->proponente->id, $ids_naovistos) and
                    in_array($data->proponente->id, $ids_naovistos2)){
                        return ['class' => 'danger'];
                    } elseif (in_array($data->proponente->id, $ids_naovistos2)) {
                        return ['class' => 'danger'];
                    }
                },
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute'=>'id',
                        'format' => 'raw',
                        'header' => '<i class="fa fa-bell"></i>',
                        'value' => function($data) {
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
                            if(!in_array($data->proponente->id, $ids_naovistos) and
                                in_array($data->proponente->id, $ids_naovistos2)
                            ){
                                return '<i style="color: red" class="fa fa-bell" title="'.$hh->descricao.'"></i>';
                            } elseif (in_array($data->proponente->id, $ids_naovistos2)) {
                                return '<i style="color: red" class="fa fa-bell" title="'.$hh->descricao.'"></i>';
                            } else {
                                return '<i style="color: green" class="fa fa-check"></i>';
                            }
                        }
                    ],
                    [
                        'attribute'=>'id',
                        'headerOptions'=>[
                            'style' => 'width: 5%',
                        ],
                        'header' => 'Id'
                    ],
                    [
                        'attribute' => 'imovel_info',
                        'header' => 'Imóvel'
                    ],
                    [
                        'header'=>'Proponente Principal',
                        'format'=>'raw',
                        'value'=> function($data){
                            if ($data->proponente) {
                                $link = Yii::$app->homeUrl."proposta/update?id={$data->id}";
                                return "<a href='{$link}'>".$data->proponente->sloInfospessoais->nome."</a>";
                            }else{
                                return Html::a('<i class="fas fa-external-link-square-alt"></i> Add Proponente</a>', [
                                    'proposta/pretendente001',
                                    'proposta_id' => $data->id,
                                    'pretendente_id' => 'novo',
                                ], [
                                    'target'=>'_blank'
                                ]);
                            }
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
<?php
/**
 * - Afazeres
    ==============================================================================================
    A fazer: _____________________________________________________________________________________

        => No módulo:
        - Cliente envia Dados - Mostrar alertas a partir da tela inicial
            - e envio por whats e email dos alertas p/ Aluga Digital!
            - com mais detalhes na proposta
            
        
        => A posteriore:
        - Integração: Superlógica
        - Integração com sistema de assinatura eletrônica

    ==============================================================================================    
    Feitos: ______________________________________________________________________________________
        
        ________________________________________________________________ Sistema/
        - Precisa de fatura => pendenciado
        - Ajuste no carregamento da Index-Locação 
            (erros eventuais aconteciam após cache de login)
        - Botão "não há pendências" vai automático pra fase 3.
        - voltar a ativar botões whats e emails quando mudam as Opções na Etapa 2
        - Ajustes visuais: melhorando Menu
        - Registrar envio de Documentos no Histórico da Proposta
        - Ajustes nas mensagens disparadas (textos)
        - botão de clique que copia dados dados do cliente.
        - Cliente enviando dados de Seguro-Fiança: tbm vai pro email de locação da Café!
        - Gerar PDF com as Informações
        - Ajustes visuais: melhorar tela Inicial de Locação

        ________________________________________________________________ /Sistema

        ________________________________________________________________ site/
        - Subir campo CEP p/cima dos de endereço
        - campo telefone celular campo no site (icone do whats)
        ________________________________________________________________ /site
 */
?>