<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
// use kartik\widgets\DateRangePicker;
use kartik\daterange\DateRangePicker;
use yii\bootstrap\Collapse;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

use app\models\Corretor;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VisitaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $addon = <<< HTML
// <span class="input-group-addon">
//     <i class="glyphicon glyphicon-calendar"></i>
// </span>
// HTML;

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

    <h3><img src="<?=Yii::$app->homeUrl.'icones/visita.png'?>" alt="" height="50" /><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
    $categorias = [];
    $corretores = [];
    $series = [];
    // echo '<pre>';

    $meses0 = [];

    foreach ($dataProvider->getModels() as $value) {
      $diames_numero = date('m', strtotime($value->attributes['data_visita']));
      array_push($meses0,$diames_numero);
    }
    $meses = array_unique($meses0);
    $meses = array_values($meses);
    # Caso queira inverter a ordem, apenas descomente abaixo
    // $meses = array_reverse($meses);


    // print_r($meses);
    $nova_serie = [];
    $dados_filtrados = [];
    // foreach ($meses as $value) {
    // echo $value;
    $i = 0;
    foreach ($dataProvider->getModels() as $row) {
      $diames_numero2 = date('m', strtotime($row->attributes['data_visita']));
      // if($diames_numero2 == $value){
      $dados_filtrados[$i] = [
          'mes' => $diames_numero2,
          'id_corretor' => $row->attributes['id_corretor'],
          'data_visita' => $row->attributes['data_visita'],
      ];
      $i++;
    }
    $nova_serie = $dados_filtrados;

    $conta_corretores_cadastrados = Corretor::find()->count();
    // $conta_corretores_com_visita = Corretor

    foreach ($nova_serie as $key => $val) {
      $corretor = Corretor::find()->where(['idcorretor'=>$val['id_corretor']])->one();

      // if(in_array($val[mes], $meses)){

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
          array_push($por_mes2, (int)app\models\Visita::find()->where([
            'id_corretor' => $val['id_corretor'],
            ' MONTH(data_visita)' => $mes
            ])->count('id_corretor'));
            
            $soma = count($series);
            if ($soma == 0) {
              $soma = 1;
            }
            $soma = $soma/2;
            // echo "<pre>";
            // print_r($por_mes2);
            // echo "</pre>";

            $media_do_mes = (int)app\models\Visita::find()->where([
              ' MONTH(data_visita)' => $mes
              ])->count()/$conta_corretores_cadastrados;

            $media_do_mes = number_format($media_do_mes,2,".",",");
            $media_do_mes = (float)$media_do_mes;
            // echo "anterior ".$media_do_mes.'<br>';
            // echo "agora ".$media_do_mes.'<br>';

            array_push($por_mes, $media_do_mes);



            array_push($pizza, [
                'name' => $mes_nome,
                'y' => (int)app\models\Visita::find()->where([
                  // 'id_corretor' => $val['id_corretor'],
                  ' MONTH(data_visita)' => $mes
                  ])->count(),
                'color' => new JsExpression('Highcharts.getOptions().colors['.$m.']'),
              ]);
              $m++;
            // ->groupby(['MONTH(data_visita)'])
        }
        
        array_push($series, [
              'type' => 'column',
              // 'mes'  => $val[mes],
              'name' => $corretor->nome,
              'data' => $por_mes2,
              'color' => $corretor->cor
        ]);
    }

    // usort($series, function($a, $b) {
    //     return $a['data'] >= $b['data'];
    // });

    // echo "<pre>";
    // print_r($series);
    // echo "</pre>";

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
    // $series = array_flip($series);
    $series = unique_multidim_array($series,'name');
    $series = array_values($series);

    // echo "<pre>";
    // print_r($pizza);
    // echo "</pre>";

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
        'center' => [580, 20],
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
    echo "<div class='col-md-2'></div>";
    echo "<div class='col-md-8'>";

    echo Collapse::widget([
      'items' => [
        [
          'label'   => 'Gráficos e Métricas',
          'content' => Highcharts::widget([
              'scripts' => [
                  'modules/exporting',
                  'themes/grid-light',
              ],
              'options' => [
                  'title' => [
                      'text' => 'Visitas dos Corretores por Mês',
                  ],
                  'xAxis' => [
                      'categories' => $meses2,
                  ],
                  'chart' => [
                        'height' => 300,
                        'zoomType' => 'x',
                  ],
                  'labels' => [
                      'items' => [
                          [
                              'html' => '<i>Total de visitas por mês</i>',
                              'style' => [
                                  'left' => '460px',
                                  'top' => '18px',
                                  'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                              ],
                          ],
                      ],
                  ],
                  'series' => $series
              ]
          ]),
          'contentOptions' => ['class' => 'in']
        ]
      ]
    ]);

    echo "</div>";
    echo "<div class='col-md-2'></div>";
    echo "</div>";

    //Select busca por $meses
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

    <p>
      <?= Html::a(Yii::t('app', 'Cadastrar nova Visita'), ['create'], ['class' => 'btn btn-success']) ?>
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
        //     if(!empty($data->idCorretor->cor)){
        //         $hex = $data->idCorretor->cor;
        //         list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
        //         $cor = "rgb($r, $g, $b, 0.1)";
        //         return ['style' => 'background-color: '.$cor];
        //     }
          return ['style' => 'height:10px'];
        },
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            // [
            //   'attribute'=>'idvisita',
            //   'headerOptions' => ['style' => 'width:5%'],
            // ],
            [
              'attribute'=>'data_visita',
              // 'headerOptions' => ['style' => 'width:10%'],
              'filter' => '<div class="input-group drp-container">'.DateRangePicker::widget([
                'language'=>'pt',
                'name' => 'VisitaSearch[data_visita]',
                // 'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                // 'type' => DatePicker::TYPE_BUTTON,
                'value'=> empty($_REQUEST['VisitaSearch']['data_visita'])?'':$_REQUEST['VisitaSearch']['data_visita'],

                // 'useWithAddon'=>true,
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
                // $diasemana = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabado');
                // $diasemana_numero = date('w', strtotime($data->data_visita));
                // $ds =  $diasemana[$diasemana_numero];
                return date('d/m/Y', strtotime($data->data_visita));
              }
            ],
            // [
            //   'attribute' => 'mes',
            //   'headerOptions' => ['style' => 'width:10%'],
            //   'filter' => $arr_meses,
            //   'value' => function($data){
            //     // return date('m', strtotime($data->data_visita));
            //     $arr_meses_2 = array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
            //     $mes_bd = (int)date('m', strtotime($data->data_visita));
            //     $mes_registro =  $arr_meses_2[$mes_bd-1];
            //     return $mes_registro;
            //   }
            // ],
            [
              'attribute'=>'id_corretor',
              'headerOptions' => ['style' => 'width:15%'],
              'filter'=> ArrayHelper::map(Corretor::find()->asArray()->all(), 'idcorretor','nome'),
              'format'=>'raw',
              'contentOptions' => ['style'=>'vertical-align: middle;white-space: nowrap;'],
              'value'=>function($data){
                $retorna = Html::a('<span class="glyphicon glyphicon-edit"></span>', ['corretor/update?id='.$data->id_corretor], ['target'=>'_blank','class'=>'btn', 'title'=>'Editar Corretor']);
                return '<strong style="color: '.$data->idCorretor->cor.';">'.$data->idCorretor->nome.' '.$retorna.'</strong>';
              }
            ],
            [
              'attribute'=> 'codigo_imovel',
              'contentOptions' => ['style'=>'vertical-align: middle;white-space: nowrap;'],
            ],
            [
              'attribute'=> 'nome_cliente',
              'contentOptions' => ['style'=>'vertical-align: middle;white-space: nowrap;'],
            ],
            [
              'attribute'=> 'imobiliaria_parceria',
              'contentOptions' => ['style'=>'vertical-align: middle;white-space: nowrap;'],
            ],
            [
              'headerOptions' => ['style' => 'width:25%'],
              'attribute'=>'observacoes',
              'format'=>'raw',
              'contentOptions' => ['style'=>'vertical-align: middle;white-space: nowrap;cursor:pointer;'],
              'value'=>function($data){
                return '<span  title="'.$data->observacoes.'">'.substr($data->observacoes, 0, 30).' (...)</span>';
                //.'</span><span style="cursor:pointer; float: right" title="'.$data->observacoes.'" class="glyphicon glyphicon-eye-open"></span>';
              }
            ],
            [
                'contentOptions' => ['style'=>'vertical-align: middle;white-space: nowrap;'],
                'class' => 'yii\grid\ActionColumn','template'=>'{update} {delete}'],
        ],
    ]); ?>
</div>
