<?php

use yii\helpers\Html;
// use yii\grid\GridView;
  use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\daterange\DateRangePicker;
use yii\bootstrap\Collapse;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use kartik\editable\Editable;

use app\models\Corretor;


$this->title = 'Marcação de Visitas';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
  .range-value{
    display: none;
  }
  .drp-container{
    width: 100%
  }
</style>
<div class="visita-index">
    <?php
        $ano_ativo = $_REQUEST['ano']!=''?$_REQUEST['ano']:'2021';

    ?>
    <h3><img src="<?=Yii::$app->homeUrl.'icones/visita.png'?>" alt="" height="50" /><?= Html::encode($this->title) ?></h3>
    <div class="clearfix"></div>
    <div class="col-md-12" style="text-align: center;">
        <a href="?ano=2018" style="<?= ($ano_ativo == '2018'?'background-color: lightgray; color: #000; ':'color: gray; ') ?>border-radius: 0px !important; border: 1px solid lightgray;" class="btn btn-dafault col-md-3"><h4>2018</h4></a>
        <a href="?ano=2019" style="<?= ($ano_ativo == '2019'?'background-color: lightgray; color: #000; ':'color: gray; ') ?>border-radius: 0px !important; border: 1px solid lightgray;" class="btn btn-dafault col-md-3"><h4>2019</h4></a>
        <a href="?ano=2020" style="<?= ($ano_ativo == '2020'?'background-color: lightgray; color: #000; ':'color: gray; ') ?>border-radius: 0px !important; border: 1px solid lightgray;" class="btn btn-dafault col-md-3"><h4>2020</h4></a>
        <a href="?ano=2021" style="<?= ($ano_ativo == '2021'?'background-color: lightgray; color: #000; ':'color: gray; ') ?>border-radius: 0px !important; border: 1px solid lightgray;" class="btn btn-dafault col-md-3"><h4>2021</h4></a>
    </div>
    <br>
    <br>
    <br>
    <div class="clearfix"></div>
    <?php
    $categorias = [];
    $corretores = [];
    $series = [];
    $meses0 = [];
    $diames_numero = '';
    foreach ($dataProvider->getModels() as $value) {
      $diames_numero = date('m', strtotime($value->attributes['data_visita']));
      array_push($meses0,$diames_numero);
    }
    $meses = array_unique($meses0);
    $meses = array_values($meses);

    $meses = array_reverse($meses);

    $nova_serie = [];
    $dados_filtrados = [];

    $i = 0;
    $visitas_convertidas = 0;
    $visitas_nao_convertidas = 0;

    $visitas_venda = 0;
    $visitas_aluga = 0;
    $arr_corretores = [];
    foreach ($dataProvider->getModels() as $row) {

      $diames_numero2 = date('m', strtotime($row->attributes['data_visita']));
      $ano_da_parada2 = date('Y', strtotime($row->attributes['data_visita']));

      $dados_filtrados[$i] = [
          'mes' => $diames_numero2,
          'id_corretor' => $row->attributes['id_corretor'],
          'data_visita' => $row->attributes['data_visita'],
          'convertido' => $row->attributes['convertido'],
          'contrato' => $row->attributes['contrato'],
          'ano' => $ano_da_parada2
      ];



      if ($row->attributes['convertido'] == 1){
        $visitas_convertidas++;
      }else{
        $visitas_nao_convertidas++;
      }

      if ($row->attributes['contrato'] == 'Locação'){
        $visitas_aluga++;
      }else{
        $visitas_venda++;
      }

      $i++;
    }

    $nova_serie = $dados_filtrados;
    $conta_corretores_cadastrados = Corretor::find()->count();

    $titulo_grafico = '';
    if ($_REQUEST['VisitaSearch']['contrato']) {
      $titulo_grafico .= ': '.$_REQUEST['VisitaSearch']['contrato'];
    }
    if (!empty($_REQUEST['VisitaSearch']['convertido'])) {
      $titulo_grafico .= ' | Visitas ';
      switch ($_REQUEST['VisitaSearch']['convertido']) {
        case 0: $titulo_grafico .= 'não convertidas'; break;
        case 1: $titulo_grafico .= 'convertidas'; break;
      }
    }

    foreach ($nova_serie as $key => $val) {

    	$corretor = Corretor::find()->where(['idcorretor'=>$val['id_corretor']])->one();
        $por_mes = [];
        $por_mes2 = [];
        $pizza = [];
        $m = 10;


        foreach($meses as $mes){
          switch ($mes) {
            case '12': $mes_nome = 'dezembro'; break;
            case '11': $mes_nome = 'novembro'; break;
            case '10': $mes_nome = 'outubro'; break;
            case '09': $mes_nome = 'setembro'; break;
            case '08': $mes_nome = 'agosto'; break;
            case '07': $mes_nome = 'julho'; break;
            case '06': $mes_nome = 'junho'; break;
            case '05': $mes_nome = 'maio'; break;
            case '04': $mes_nome = 'abril'; break;
            case '03': $mes_nome = 'março'; break;
            case '02': $mes_nome = 'fevereiro'; break;
            case '01': $mes_nome = 'janeiro'; break;
            default:
              $mes = 'outros';
              break;
          }
          $arr_pesquisa = [
            'id_corretor' => $val['id_corretor'],
            'MONTH(data_visita)' => $mes,
            'YEAR(data_visita)' => $val['ano'],
          ];
          $arr_mesdata = [
              ' MONTH(data_visita)' => $mes,
              ' YEAR(data_visita)' => $val['ano'],
          ];



          if ($_REQUEST['VisitaSearch']['contrato']) {
            $arr_pesquisa['contrato'] = $val['contrato'];
            $arr_mesdata['contrato'] = $val['contrato'];
          }
          if ($_REQUEST['VisitaSearch']['convertido']) {
            $arr_pesquisa['convertido'] = $val['convertido'];
            $arr_mesdata['convertido'] = $val['convertido'];
          }

          array_push($por_mes2, (int)app\models\Visita::find()->where($arr_pesquisa)->count('id_corretor'));


            $soma = count($series);
            if ($soma == 0) {
              $soma = 1;
            }
            $soma = $soma/2;

            $media_do_mes = (int)app\models\Visita::find()->where($arr_mesdata)->count()/$conta_corretores_cadastrados;

            $media_do_mes = number_format($media_do_mes,2,".",",");
            $media_do_mes = (float)$media_do_mes;

            array_push($por_mes, $media_do_mes);

            array_push($pizza, [
                'name' => $mes_nome,
                'y' => (int)app\models\Visita::find()->where($arr_mesdata)->count(),
                'color' => new JsExpression('Highcharts.getOptions().colors['.$m.']'),
            ]);
            $m++;
        }

        //Array Soma Corretores

        // ['name'=>'Venda: '.$visitas_venda_porcento.' %','y'=>$visitas_venda,'color'=>'blue'],

        $arr_corretores[$corretor->nome] = [
          'visitas'=>(int)app\models\Visita::find()->where(['id_corretor' => $val['id_corretor']])->count('id_corretor'),
          'cor'=>$corretor->cor
        ];
        // $arr_corretores[$corretor->cor] = $corretor->cor;

        array_push($series, [
              'type' => 'column',
              'name' => $corretor->nome,
              'data' => $por_mes2,
              'color' => $corretor->cor
        ]);
    }
    // ['name'=>'Venda: '.$visitas_venda_porcento.' %','y'=>$visitas_venda,'color'=>'blue'],
    $arr_graf_corrretores = [];
    $legends = [];
    foreach ($arr_corretores as $key => $value) {
      array_push($arr_graf_corrretores,[
        'name' => $key,
        'y' => $value['visitas'],
        'color' => $value['cor'],
      ]);
      array_push($legends, $key);
    }

    function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    $series = unique_multidim_array($series,'name');
    $series = array_values($series);

    array_push($series,[
        'type' => 'spline',
        'name' => 'Média',
        'data' => $por_mes,
        'marker' => [
            'lineWidth' => 2,
            'lineColor' => new JsExpression('Highcharts.getOptions().colors[3]'),
            'fillColor' => 'white',
        ],
    ]);

    array_push($series, [
        'type' => 'pie',
        'name' => 'Total de visitas',
        'data' => $pizza,
        'center' => [680, 20],
        'size' => 50,
        'showInLegend' => false,
        'dataLabels' => [
            'enabled' => false,
        ],
    ]);

    $meses2 = [];
    foreach ($meses as $mes) {
      switch ($mes) {
        case '12': $mes = 'dezembro'; break;
        case '11': $mes = 'novembro'; break;
        case '10': $mes = 'outubro'; break;
        case '09': $mes = 'setembro'; break;
        case '08': $mes = 'agosto'; break;
        case '07': $mes = 'julho'; break;
        case '06': $mes = 'junho'; break;
        case '05': $mes = 'maio'; break;
        case '04': $mes = 'abril'; break;
        case '03': $mes = 'março'; break;
        case '02': $mes = 'fevereiro'; break;
        case '01': $mes = 'janeiro'; break;
        default:
          $mes = 'outros';
          break;
      }
      array_push($meses2, $mes);
    }

    echo "<div class='col-md-12'>";
    //Dados Gráfico de Visitas convertidas em Vendas
    $total_visitas = $visitas_convertidas + $visitas_nao_convertidas;
    if ($total_visitas == 0) {
      $total_visitas = 1;
    }
    $visitas_convertidas_porcento = ($visitas_convertidas*100) / $total_visitas;
    $visitas_nao_convertidas_porcento = ($visitas_nao_convertidas*100) / $total_visitas;

    //Dados de visitas em função do Contrato
    $total_contratos = $visitas_venda + $visitas_aluga;
    if ($total_contratos == 0) {
      $total_contratos = 1;
    }
    $visitas_venda_porcento = ($visitas_venda*100) / $total_contratos;
    $visitas_aluga_porcento = ($visitas_aluga*100) / $total_contratos;

    echo Collapse::widget([
      'items' => [
        [
          'label'   => 'Gráficos e Métricas',
          'content' => '<div class="col-md-12"><div class="col-md-9">'.Highcharts::widget([
              'scripts' => [
                  'modules/exporting',
                  'themes/grid-light',
              ],
              'options' => [
                  'title' => [
                      'text' => 'Visitas dos Corretores por Mês'.$titulo_grafico,
                  ],
                  'xAxis' => [
                      'categories' => $meses2,
                  ],
                  'chart' => [
                        'height' => 350,
                        'zoomType' => 'x',
                  ],
                  'labels' => [
                      'items' => [
                          [
                              'html' => '<i>Total de visitas por mês</i>',
                              'style' => [
                                  'left' => '560px',
                                  'top' => '18px',
                                  'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                              ],
                          ],
                      ],
                  ],
                  'series' => $series
              ]
          ]).'</div><div class="col-md-3">'.Highcharts::widget([
               'options' => [
                'type' => 'pie',
                  'title' => ['text' => 'Relação de Visitas Convertidas'],
                  'chart' => [
                        'height' => 350,
                        'zoomType' => 'x',
                  ],
                  'series' => [
                    [
                        'name' => 'Visitas Convertidas em Venda/Locação',
                        'data' => [
                          ['name'=>'Convertidas '.$visitas_convertidas_porcento.' %','y'=>$visitas_convertidas,'color'=>'lightgreen'],
                          ['name'=>'Não Convertidas '.$visitas_nao_convertidas_porcento.' %','y'=>$visitas_nao_convertidas,'color'=>'lightgray']
                        ],
                        'type' => 'pie',
                        'showInLegend' => true,
                        'dataLabels' => [
                            'enabled' => false,
                        ],
                    ],
                  ]
               ]
            ]).'</div></div>',
          'contentOptions' => ['class' => 'in']
        ],
        [
          'label'   => 'Gráficos Complementares',
          'content' =>
            '<div class="col-md-12"><div class="col-md-6">'.Highcharts::widget([
               'options' => [
                'type' => 'pie',
                  'title' => ['text' => 'Relação de Visitas por Contrato'],
                  'chart' => [
                        'height' => 300,
                        'zoomType' => 'x',
                  ],
                  'series' => [
                    [
                        'name' => 'Visitas por Contrato',
                        'data' => [
                          ['name'=>'Venda: '.$visitas_venda_porcento.' %','y'=>$visitas_venda,'color'=>'blue'],
                          ['name'=>'Locação: '.$visitas_aluga_porcento.' %','y'=>$visitas_aluga,'color'=>'orange']
                        ],
                        'type' => 'pie',
                        'showInLegend' => true,
                        'dataLabels' => [
                            'enabled' => false,
                        ],
                    ],
                  ]
               ]
            ]).'</div>'.
            '<div class="col-md-6">'.Highcharts::widget([
               'options' => [
                  'title' => ['text' => 'Relação de Visitas por Corretor'],
                  'chart' => [
                        'height' => 300,
                        'zoomType' => 'x',
                  ],
                  'legend' => [
                          'layout' => 'vertical',
                          'align' => 'right',
                  ],
                  'xAxis' => [
                      'categories' => $legends,
                  ],
                  'series' => [
                    [
                        'name' => 'Visitas por Corretor',
                        'data' => $arr_graf_corrretores,
                        'type' => 'bar',
                        'showInLegend' => false,
                        'dataLabels' => [
                            'enabled' => true,
                        ],
                    ],
                  ]
               ]
            ]).
            '</div>'.
            '</div>'
        ],
      ]
    ]);
    echo "</div>";

    $arr_meses = array(
      '01' => 'Janeiro',
      '02' => 'Fevereiro',
      '03' => 'Março',
      '04' => 'Abril',
      '05' => 'Maio',
      '06' => 'Junho',
      '07' => 'Julho',
      '08' => 'Agosto',
      '09' => 'Setembro',
      '10' => 'Outubro',
      '11' => 'Novembro',
      '12' => 'Dezembro'
   );
  ?>
    <div class="col-md-12">
      <?php
      yii\bootstrap\Modal::begin([
          'header' => '<h4>Nova Visita para Locação</h4>',
          'toggleButton' => [
            'label' => 'Novo registro rápido: Alugar <i class="glyphicon glyphicon-plus"></i>',
            'class'=>"btn btn-info",
            'title'=>'Cadastrar Novo Registro de Visita',
            'style'=>'float: left;margin-right: 5px;'
          ],
          'options' => ['tabindex' => false],
      ]);
      $cyber = new app\models\Visita;
      echo $this->render('novo', [
          'model' => $cyber,
          'contrato' => 'Locação',
          't' => '2'
      ]);

      yii\bootstrap\Modal::end();
      ?>
      <?php
      yii\bootstrap\Modal::begin([
          'header' => '<h4>Nova Visita para Venda</h4>',
          'toggleButton' => [
            'label' => 'Novo registro rápido: Venda <i class="glyphicon glyphicon-plus"></i>',
            'class'=>"btn btn-info",
            'title'=>'Cadastrar Novo Registro de Visita',
            'style'=>'float: left;margin-right: 5px;'
          ],
          'options' => ['tabindex' => false],
      ]);
      $cyber = new app\models\Visita;
      echo $this->render('novo', [
          'model' => $cyber,
          'contrato' => 'Venda',
          't' => '1'
      ]);

      yii\bootstrap\Modal::end();
      ?>
    <p>
      <?= Html::a(Yii::t('app', 'Cadastrar Visitas em Sequência: Alugar'), ['create',[
        'contrato' => 'Locação'
      ]], ['class' => 'btn btn-success',]) ?>

      <?= Html::a(Yii::t('app', 'Cadastrar Visitas em Sequência: Venda'), ['create',[
        'contrato' => 'Venda'
      ]], ['class' => 'btn btn-success',]) ?>

      <?= Html::a(Yii::t('app', 'Limpar Filtros'), ['index'], ['class' => 'btn btn-warning']) ?>
        <?php
        if ($_REQUEST['VisitaSearch']['data_visita'] and $_REQUEST['VisitaSearch']['data_visita'] != ''):
          $data = explode(' - ', $_REQUEST['VisitaSearch']['data_visita']);
        ?>
        <center><h4><strong>
          Visitas de <?=date('d/m/Y', strtotime($data[0]))?> a <?=date('d/m/Y', strtotime($data[1]))?>
        </strong></h4></center>
      <?php endif; ?>
    </p>
    <hr>
    </div>
    <style type="text/css">
      .table > tbody > tr > td{
        padding: 2px;
        padding-left: 10px;
        padding-right: 10px;
      }
    </style>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'=>function($data){
            return ['style' => 'height:10px'];
        },
        'columns' => [
            [
              'attribute'=>'data_visita',
              'filter' => '<div class="input-group drp-container">'.DateRangePicker::widget([
                'language'=>'pt',
                'name' => 'VisitaSearch[data_visita]',
                'value'=> empty($_REQUEST['VisitaSearch']['data_visita'])?'':$_REQUEST['VisitaSearch']['data_visita'],
                'convertFormat'=>true,
                'startAttribute' => 'from_date',
                'endAttribute' => 'to_date',
                'hideInput'=> true,
                'pluginOptions'=>[
                    'locale'=>['format' => 'Y-m-d'],
                ]
              ]).'</div>',
              'contentOptions' => ['style'=>'vertical-align: middle;height:10px'],
              'value'=>function($data){
                return date('d/m/Y', strtotime($data->data_visita));
              }
            ],
            [
              'attribute'=>'id_corretor',
              'headerOptions' => ['style' => 'width:10%'],
              'filter'=> ArrayHelper::map(Corretor::find()->asArray()->all(), 'idcorretor','nome'),
              'format'=>'raw',
              'contentOptions' => ['style'=>'vertical-align: middle;white-space: nowrap;'],
              'value'=>function($data){
                $retorna = Html::a('<span class="glyphicon glyphicon-edit"></span>', ['corretor/update?id='.$data->id_corretor], ['target'=>'_blank','class'=>'btn', 'title'=>'Editar Corretor']);
                return '<strong style="color: '.$data->idCorretor->cor.';">'.$data->idCorretor->nome.' '.$retorna.'</strong>';
              }
            ],
            [
              'headerOptions' => ['style' => 'width:10%'],
              'attribute' => 'contrato',
              'filter' => ['Venda'=>'Venda','Locação'=>'Locação']
            ],
            [
              'attribute'=> 'codigo_imovel',
              'contentOptions' => ['style'=>'vertical-align: middle;white-space: nowrap;'],
            ],
            [
              'attribute'=> 'nome_cliente',
              'contentOptions' => ['style'=>'vertical-align: middle;white-space: nowrap;'],
              'format' => 'raw',
              'value' => function($data){
                return '<span  title="'.$data->nome_cliente.'">'.substr($data->nome_cliente, 0, 20).' (...)</span>';
              }
            ],
            [
              'attribute'=> 'imobiliaria_parceria',
              'headerOptions' => ['style' => 'width:10% !important;'],
              'contentOptions' => ['style'=>'vertical-align: middle;/*white-space: nowrap;*/'],
            ],
            // [
            //   'attribute' => 'convertido',
            //   'format'=>'raw',
            //   'value' => function($data){
            //     // return $data->convertido == 0 ? 'Não' : 'Sim';
            //     return Editable::widget([
            //         'name'=>'status',
            //         'value' => $data->convertido == 0 ? 'Não' : 'Sim',
            //         'asPopover' => true,
            //         'header' => 'Negocio Feito?',
            //         'inputType' => Editable::INPUT_DROPDOWN_LIST,
            //         // 'editableKey' => $data->idvisita,
            //         'data' => [0 => 'Não', 1 => 'Sim'],
            //         'options' => ['class'=>'form-control'],
            //         'displayValueConfig'=> [
            //             '0' => '<i class="fas fa-thumbs-up"></i> Sim',
            //             '1' => '<i class="fas fa-thumbs-down"></i> Não',
            //         ],
            //     ]);
            //   }
            // ],
            [
                'class' => 'kartik\grid\EditableColumn',
                // 'header'=>'Vendido?',
                'filter'=> ['0'=>'Não','1'=>'Sim'],
                'attribute' => 'convertido',
                'editableOptions' => function ($data) {
                    return [
                      'inputType' => Editable::INPUT_SWITCH,
                      'options' => [
                        'pluginOptions' => [
                            'onText' => 'SIM',
                            'offText' => 'Não',
                        ],
                      ],
                      'formOptions' => [ 'action' => [ 'editregistro'] ],
                      'displayValueConfig'=> [
                        '0' => '<div style="color:red"><i class="glyphicon glyphicon-thumbs-down"></i> Não</div>',
                        '1' => '<div style="color:green"><i class="glyphicon glyphicon-thumbs-up"></i> Sim</div>',
                      ],
                    ];
                },
            ],
            [
              'headerOptions' => ['style' => 'width:20% !important;'],
              'attribute'=>'observacoes',
              'format'=>'raw',
              'contentOptions' => ['style'=>'vertical-align: middle;white-space: nowrap;cursor:pointer;'],
              'value'=>function($data){
                return '<span  title="'.$data->observacoes.'">'.substr($data->observacoes, 0, 30).' (...)</span>';
              }
            ],
            [
                'contentOptions' => ['style'=>'vertical-align: middle;white-space: nowrap;'],
                'class' => 'yii\grid\ActionColumn','template'=>'{update} {delete}'
            ],
        ],
    ]); ?>
</div>
