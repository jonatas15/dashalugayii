<?php
    use app\models\SloPretendente as Pretendente;
    use app\models\Checklist;
    use miloschuman\highcharts\Highcharts;
    use yii\web\JsExpression;


    $pretendente = Pretendente::findOne(['pret_user' => Yii::$app->user->identity->id]);
    $pret_nome = $pretendente->sloInfospessoais->nome;

    $preenchido = 0;
    $total = 5;


    $check_preenchido = 0;
    $check_total = 13;

    if ($pretendente->sloInfospessoais->nome != '') { $preenchido+=1; }
    if ($pretendente->sloContratodocumentos->numero != '') {  $preenchido+=1; }
    if ($pretendente->sloInfosprofissionais->empresa != '') { $preenchido+=1; }
    if ($pretendente->sloRefbancarias->nome_banco != '') {  $preenchido+=1; }
    if ($pretendente->sloMoratuals->endereco != '') { $preenchido+=1; }

    $porcent_form = ($preenchido*100)/$total;


?>
<style media="screen">
    .uppercase{
        text-transform: uppercase;
    }
    #ul-checks  {
        list-style: none;
    }
    #ul-checks li:before {
        content: "\f111"; /* FontAwesome Unicode */
        font-family: FontAwesome;
        display: inline-block;
        margin-left: -1.3em; /* same as padding-left set on li */
        width: 1.3em; /* same as padding-left set on li */
        font-size: 10px;
    }
    #ul-checks li.ativo:before {
        content: "\f00c"; /* FontAwesome Unicode */
        font-family: FontAwesome;
        display: inline-block;
        margin-left: -1.3em; /* same as padding-left set on li */
        width: 1.3em; /* same as padding-left set on li */
    }
    #ul-checks li.ativo {
        color: blue;
        text-decoration: underline;
        font-weight: bolder;
    }
    .barra-meio {
        border-left: 1px solid lightgray;
    }
</style>
<?= "<h4>Bem Vindo ao Sistema Café Inteligência Imobiliária, <strong class='uppercase'>$pret_nome</strong></h4>"; ?>
<hr>
<?php
    $link_cadastro = Yii::$app->homeUrl.'proposta/pretendente001?id='.$pretendente->sloInfospessoais->id
    .'&form=001&pretendente_id='.$pretendente->id.'&proposta_id='.$pretendente->proposta_id;
?>
<br>
<div class="col-md-12">
  <div class="col-md-5">
      <?= Highcharts::widget([
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
              'title' => ['text' => 'Preenchimento de seus Dados'],
              'subtitle' => [
                'text'=> round($porcent_form,2).' %',
                'align'=> 'center',
                'verticalAlign'=> 'middle',
                'style'=> ["fontSize" => "22px" ],
                'y'=> 15
              ],
              'chart' => [
                    'height' => 350,
                    'zoomType' => 'x',
              ],
              'series' => [
                [
                    'name' => 'Relação de Visitas Convertidas em Locação',
                    'data' => [
                      ['name'=>'Campos Preenchidos ','y'=>$preenchido,'color'=>'green'],
                      ['name'=>'Campos faltantes ','y'=>$total - $preenchido,'color'=>'lightgray'],
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
      <hr>
      <a href="<?=$link_cadastro;?>" class="btn btn-primary" target="_blank">Verificar/Continuar seus Registros</a>
  </div>
  <div class="col-md-7 barra-meio">
    <?php
        $checklist = Checklist::findOne(['pretendente_id'=>$pretendente->id]);
        if (count($checklist) > 0){
          $cont_check = '';
          $cont_check .= '<h3><strong>';
          $cont_check .= '1ª Etapa';
          $cont_check .= '</strong></h3>';
          $cont_check .= '<ul id="ul-checks">';
          $i = 0;
          foreach ($checklist->chtopicos as $key => $val) {
              if ($val->checked == 1) {
                  $ativo = 'ativo';
                  $check_preenchido+=1;
              }else{
                 $ativo = '';
              }
              $cont_check .= '<li class="'.$ativo.'">';
              $cont_check .= $val->conteudo;
              $cont_check .= '</li>';

              if ($i == 8) {
                  $cont_check .= '</ul>';
                  $cont_check .= '<h3><strong>';
                  $cont_check .= '2ª Etapa';
                  $cont_check .= '</strong></h3>';
                  $cont_check .= '<ul id="ul-checks">';
              }

              if ($i == 10) {
                  $cont_check .= '</ul>';
                  $cont_check .= '<h3><strong>';
                  $cont_check .= '3ª Etapa';
                  $cont_check .= '</strong></h3>';
                  $cont_check .= '<ul id="ul-checks">';
              }

              $i++;
          }

          $percent_progress = ($check_preenchido * 100)/$check_total;

          $cont_check .= '</ul>';
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
                  'title' => ['text' => 'Progresso de sua Locação'],
                  'subtitle' => [
                    'text'=> round($percent_progress,2).' %',
                    'align'=> 'center',
                    'verticalAlign'=> 'middle',
                    'style'=> ["fontSize" => "22px" ],
                    'y'=> 15
                  ],
                  'chart' => [
                        'height' => 350,
                        'zoomType' => 'x',
                  ],
                  'series' => [
                    [
                        'name' => 'Progresso de sua Locação',
                        'data' => [
                          ['name'=>'Campos Preenchidos ','y'=>$check_preenchido,'color'=>'blue'],
                          ['name'=>'Campos faltantes ','y'=>$check_total - $check_preenchido,'color'=>'lightgray'],
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
          echo "<hr>";
          echo $cont_check;
        }
    ?>
  </div>
</div>
