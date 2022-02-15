<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\SloAgenda;
use app\models\SloCliente;
use kartik\daterange\DateRangePicker;
use kartik\form\ActiveForm;

use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SloagendaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// Vamos ver

$this->title = 'Agenda: registro de visitas';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    @media (min-width: 1200px) {
      .seven-cols .col-md-1,
      .seven-cols .col-sm-1,
      .seven-cols .col-lg-1 {
        width: 14.285714285714285714285714285714%;
        *width: 14.285714285714285714285714285714%;
      }
    }
    @media (max-width: 600px) {
      .seven-cols .col-md-1,
      .seven-cols .col-sm-1,
      .seven-cols .col-lg-1 {
        width: 100%;
        *width: 100%;
      }
    }
    .dia-registro {
        background-color: ghostwhite;
        border: 1px solid lightgray; 
        margin-bottom:5px;
        text-align:center;
        border-radius:5px;
        padding:5px;
        box-shadow: 5px 5px lightgray;
        background:  linear-gradient( lightblue 50px, ghostwhite 150px);
    }
    .dia-registro h5{
        font-weight: bolder;
    }
    .dia-registro:hover {
        box-shadow: 5px 5px gray;
    }
    .turno-registro{
        width: 30%;
        padding: 1px;
        opacity: 0.8;
    }
    .noite{
        background-color: purple;
        border-color: purple;
    }
    .noite:hover{
        background-color: black;
    }
    .noite:active{
        background-color: black;
    }
    .visualizar-registro {
        width: 100%;
        padding: 1px;
        margin-bottom: 4px;
        background-color: ghostwhite;
        color: black;
        border-color: lightblue;
        text-align: left;
        padding-left: 10px;    
        overflow: hidden;
        text-overflow: ellipsis;
        direction: ltr;
    }
    .visualizar-registro:hover {
        background-color: lightblue;
        border-color: lightblue;
    }
    .div-pesquisa .input-group-addon:last-child {
        padding: 1px;
        background-color: lightgray;
    }
    .div-pesquisa .btn{
        padding:3px 12px;
    }
    small{
        float: right;
        padding: 5%;
    }
    small.badge{
        padding: 2%;
        margin: 2%;
    }
</style>

<div class="slo-agenda-index">

    <h3 style="text-align: center"><?=$this->title?></h3>
    <?php
    echo "<div class='col-md-12 div-pesquisa'>";
    $model = new SloAgenda();
    $form = ActiveForm::begin([
        'method' => 'get',
        'id'=>'pesquisa_intervalo',
        // 'options' => []
    ]);
    echo "<div class='col-md-6'>";
    $model->data_intervalo = $_REQUEST['SloAgenda']['data_intervalo'];
    echo $form->field($model, 'data_intervalo', [
        'addon'=>[
            'prepend'=>[
                'content'=>'<i class="fas fa-calendar-alt"></i>'
            ],
            'append'=>[
                'content'=>'<button class="btn"><i class="fas fa-search"></i></button>',
            ],
        ],
        'options'=>[
            'class'=>'drp-container form-group',
            'onchange'=>'$("#pesquisa_intervalo").submit()'
        ]
    ])->widget(DateRangePicker::classname(), [
        'language' => 'pt',
        'useWithAddon'=>true,
        'options'=>[
            'autocomplete'=>"off",
            'class'=>'form-control',
        ],
        'pluginOptions'=>[
            'locale'=>[
                'format'=>'D/M/Y',
            ],
        ],

    ]);
    echo "</div>";
    echo "<div class='col-md-6'>";
    echo "<label>Selecionar Propostas: </label><br>";
    if($_REQUEST['SloAgenda']['slo_proposta_id'] != '')
        $model->slo_proposta_id = $_REQUEST['SloAgenda']['slo_proposta_id'];
    echo $form->field($model, 'slo_proposta_id')->checkboxButtonGroup(
        ArrayHelper::map(app\models\SloProposta::find()->all(), 'id', 'codigo_imovel')
    )->label(false);
    echo "</div>";
    echo "<div class='col-md-12'>";
    echo Html::submitButton('Pesquisar', ['class' => 'btn btn-search', 'style'=>'float:right']);
    echo "</div>";
    $form->end();
    echo "</div>";
    echo '<div class="col-md-12 clearfix"><hr></div>';
    echo "<div class='col-md-6'>";
    if ($model->data_intervalo != '') {
        echo '<h4 style="text-align: right"><i>Registros de '.str_replace('-', ' a ',$model->data_intervalo).'</i></h4>';
    }
    echo "</div>";
    ?>      
    <div class="col-md-12">
        <div class="row seven-cols">
            <?php
                if ($_REQUEST['SloAgenda']['data_intervalo']) {
                    $intervalo = $_REQUEST['SloAgenda']['data_intervalo'];
                } else {
                    $intervalo = date('d/m/Y',strtotime( "previous sunday" )).
                    ' - '.
                    date('d/m/Y',strtotime( "next saturday" ));
                }
                $datamento = explode('-', $intervalo);
                
                $datamento[0] = trim($datamento[0]);
                $datamento[1] = trim($datamento[1]);

                // echo "<pre>";
                // echo $datamento[0];
                // echo "<br>";
                // echo $datamento[1];
                // echo "</pre>";

                $data_inicio = date('Y-m-d', strtotime($datamento[0]));

                $arr_datainicio = explode('/', $datamento[0]);
                $arr_datafinal  = explode('/', $datamento[1]);
                $data_inicio = date('Y-m-d', strtotime($arr_datainicio[2].'-'.$arr_datainicio[1].'-'.$arr_datainicio[0]));
                $data_finale = date('Y-m-d', strtotime($arr_datafinal[2].'-'.$arr_datafinal[1].'-'.$arr_datafinal[0]));

                $data_inicio1 = $data_inicio;
                $data_finale1 = $data_finale;
                
                $data_inicio2 = new DateTime($data_inicio1);
                $data_finale2 = new DateTime($data_finale1);
                date_modify($data_finale2, '+1 day');
                
                $interval = $data_inicio2->diff($data_finale2);
                
                $interval = DateInterval::createFromDateString('1 day');
                $period = new DatePeriod($data_inicio2, $interval, $data_finale2);
                $i = 0;
                foreach ($period as $dt) {
                    if ($i%7==0){
                        echo '</div><div class="row seven-cols">';
                    }
                    $data_registro = $dt->format("w d/m/Y");

                    switch ($dt->format("w")) {
                        case '0': $diasemana = 'Domingo'; break;
                        case '1': $diasemana = 'Segunda-Feira'; break;
                        case '2': $diasemana = 'Terça-Feira'; break;
                        case '3': $diasemana = 'Quarta-Feira'; break;
                        case '4': $diasemana = 'Quinta-Feira'; break;
                        case '5': $diasemana = 'Sexta-Feira'; break;
                        case '6': $diasemana = 'Sábado'; break;
                    }
                    $diadata = $dt->format("d");
                    $diames = $dt->format("d/m/Y");

                    $dia_hoje = '';

                    if($dt->format("Y-m-d") == date('Y-m-d')){
                        $dia_hoje = 'background: linear-gradient(orange 50px, ghostwhite 150px);color:darkblue';
                    }
                    // echo "<pre>";
                    // echo $dt->format("Y-m-d").' = '.date('Y-m-d');
                    // echo "</pre>";

                    $data_registro = '<br>'.'<sub>'.$diasemana.': '.'<br>'.$diames.'</sub>';

                    echo "<div class='col-lg-1 col-md-3 col-sm-4 col-xs-6' style='padding: 10px'>";
                        echo "<div class='dia-registro' style='$dia_hoje'>";
                            echo "<h3><i class='fas fa-calendar'></i>  Dia ".$diadata.$data_registro."</h3>";
                            echo '<hr>';
                            
                            ################################################################################################################################################################
                            $turno_manha = SloAgenda::find()->where(['data'=>$dt->format('Y-m-d'),'turno'=>'manhã'])->andFilterWhere(['slo_proposta_id' => $_REQUEST['SloAgenda']['slo_proposta_id']])->all();
                            if (count($turno_manha)):
                                echo "<hr><sup style='float:right'>Manhã</sup><br>";
                                foreach ($turno_manha as $row) {

                                    $imovel_proposta = ' <span>(Pin-'.$row->sloProposta->codigo_imovel.')</span>';
                                    $bloqueado = false;

                                    if (Yii::$app->user->can('administrador')) {
                                        $bloqueado = false;
                                    } elseif (
                                        Yii::$app->user->can('corretor') and 
                                        Yii::$app->user->identity->id != $row->corretorIdcorretor->usuario_id) {
                                        $bloqueado = true;
                                    } else {
                                        $bloqueado = false;
                                    }

                                    $sou_cliente = false;
                                    $posso_agendar = false;

                                    if(Yii::$app->user->can('cliente') and (Yii::$app->user->identity->nome == $row->sloCliente->nome)){
                                        $sou_cliente = true;
                                    }elseif($row->sloCliente->nome == ''){
                                        $posso_agendar =true;
                                    }else{
                                        $bloqueado = true;
                                    }

                                    $cliente_logado = SloCliente::find()->where([
                                        'nome' => Yii::$app->user->identity->nome,
                                    ])->one();
                                    
                                    yii\bootstrap\Modal::begin([
                                        'header' => '<h4>'."<i class='fas fa-calendar'></i> Visita: PIN-".$row->sloProposta->codigo_imovel.'</h4>',
                                        'size'=>'modal-sm',
                                        'toggleButton' => [
                                            'label' => ($sou_cliente?
                                                '<i class="fas fa-stopwatch"></i> '.$row->hora.$imovel_proposta.' <br>Corretor: '.$row->corretorIdcorretor->nome.' <br><small class="badge" style="color:lime"><i>Marcado</i></small>'
                                                :'<i class="fas fa-clock"></i> '.$row->hora.$imovel_proposta.' <br>Corretor: '.$row->corretorIdcorretor->nome).
                                            ($posso_agendar?' <br><small  class="badge" style="color:blue"><i>Disponível</i></small>':'').
                                            ($bloqueado?'  <br><small class="badge" style="color:red"><i>Indisponível</i></small>':''),
                                            'class'=>"manha visualizar-registro btn btn-primary", 
                                            'title'=> 'Obs.: '.$row->mais_informacoes,
                                            'style' => 'font-weight: bolder; color: '.$row->corretorIdcorretor->cor,
                                            'disabled' => $bloqueado,
                                        ],
                                        'headerOptions' => [
                                            'style' => 'background-color:orange;color:white;'
                                        ],
                                        'options' => ['tabindex' => false],
                                    ]);

                                    if($sou_cliente){
                                        echo "<br><label>Data: </label> ".'<span>'.$diames.'</span>';
                                        echo "<br><label>Horário: </label> ".'<span>'.$row->hora.'</span>';
                                        echo "<br><label>Mais informações: </label>".'<br>'.
                                        '<span>'.$row->mais_informacoes.'</span>';
                                        echo "<hr>";
                                        echo Html::a('<i class="fas fa-stopwatch"></i> Desagendar', [
                                            'desagendar', 'id' => $row->id,
                                            'cliente'=> $cliente_logado->id,
                                        ], 
                                        [
                                            'class' => 'btn btn-warning',
                                            'style' => 'float:left',
                                            'data' => [
                                                'confirm' => 'Deseja realmente desagendar essa visita?',
                                                'method' => 'post',
                                            ],
                                        ]);
                                        echo "<div class='clearfix'></div>";
                                    }
                                    elseif ($posso_agendar) {
                                        echo "<br><label>Data: </label>".'<span>'.$diames.'</span>';
                                        echo "<br><label>Horário: </label>".'<span>'.$row->hora.'</span>';
                                        echo "<br><label>Mais informações: </label>".'<br>'.
                                        '<span>'.$row->mais_informacoes.'</span>';
                                        echo "<hr>";
                                        echo Html::a('<i class="fas fa-stopwatch"></i> Agendar', [
                                            'agendar', 'id' => $row->id,
                                            'cliente'=> $cliente_logado->id,
                                        ], 
                                        [
                                            'class' => 'btn btn-success',
                                            'style' => 'float:left',
                                            'data' => [
                                                'method' => 'post',
                                            ],
                                        ]);
                                        echo "<div class='clearfix'></div>";
                                    }
                                    else{
                                        echo "<label>"."Indisponível!"."</label>";
                                    }
                                    
                                    yii\bootstrap\Modal::end();

                                }
                            endif;
                            $turno_tarde = SloAgenda::find()->where(['data'=>$dt->format('Y-m-d'),'turno'=>'tarde'])->andFilterWhere(['slo_proposta_id' => $_REQUEST['SloAgenda']['slo_proposta_id']])->all();
                            if (count($turno_tarde)):
                                echo "<hr><sup style='float:right'>Tarde</sup><br>";
                                foreach ($turno_tarde as $row) {
                                    
                                    $imovel_proposta = ' <span>(Pin-'.$row->sloProposta->codigo_imovel.')</span>';
                                    $bloqueado = false;

                                    if (Yii::$app->user->can('administrador')) {
                                        $bloqueado = false;
                                    } elseif (
                                        Yii::$app->user->can('corretor') and 
                                        Yii::$app->user->identity->id != $row->corretorIdcorretor->usuario_id) {
                                        $bloqueado = true;
                                    } else {
                                        $bloqueado = false;
                                    }

                                    $sou_cliente = false;
                                    $posso_agendar = false;

                                    if(Yii::$app->user->can('cliente') and (Yii::$app->user->identity->nome == $row->sloCliente->nome)){
                                        $sou_cliente = true;
                                    }elseif($row->sloCliente->nome == ''){
                                        $posso_agendar =true;
                                    }else{
                                        $bloqueado = true;
                                    }

                                    yii\bootstrap\Modal::begin([
                                        'header' => '<h4>'."<i class='fas fa-calendar'></i> Visita: PIN-".$row->sloProposta->codigo_imovel.'</h4>',
                                        'size'=>'modal-sm',
                                        'toggleButton' => [
                                            'label' => ($sou_cliente?
                                                '<i class="fas fa-stopwatch"></i> '.$row->hora.$imovel_proposta.' <br>Corretor: '.$row->corretorIdcorretor->nome.' <br><small class="badge" style="color:lime"><i>Marcado</i></small>'
                                                :'<i class="fas fa-clock"></i> '.$row->hora.$imovel_proposta.' <br>Corretor: '.$row->corretorIdcorretor->nome).
                                            ($posso_agendar?' <br><small  class="badge" style="color:blue"><i>Disponível</i></small>':'').
                                            ($bloqueado?'  <br><small class="badge" style="color:red"><i>Indisponível</i></small>':''),
                                            'class'=>"manha visualizar-registro btn btn-primary", 
                                            'title'=> 'Obs.: '.$row->mais_informacoes,
                                            'style' => 'font-weight: bolder; color: '.$row->corretorIdcorretor->cor,
                                            'disabled' => $bloqueado,
                                        ],
                                        'headerOptions' => [
                                            'style' => 'background-color:#3c8dbc;color:white;'
                                        ],
                                        'options' => ['tabindex' => false],
                                    ]);
                                    if($sou_cliente){
                                        echo "<br><label>Data: </label> ".'<span>'.$diames.'</span>';
                                        echo "<br><label>Horário: </label> ".'<span>'.$row->hora.'</span>';
                                        echo "<br><label>Mais informações: </label>".'<br>'.
                                        '<span>'.$row->mais_informacoes.'</span>';
                                        echo "<hr>";
                                        echo Html::a('<i class="fas fa-stopwatch"></i> Desagendar', [
                                            'desagendar', 'id' => $row->id,
                                            'cliente'=> $cliente_logado->id,
                                        ], 
                                        [
                                            'class' => 'btn btn-warning',
                                            'style' => 'float:left',
                                            'data' => [
                                                'confirm' => 'Deseja realmente desagendar essa visita?',
                                                'method' => 'post',
                                            ],
                                        ]);
                                        echo "<div class='clearfix'></div>";
                                    }
                                    elseif ($posso_agendar) {
                                        echo "<br><label>Data: </label>".'<span>'.$diames.'</span>';
                                        echo "<br><label>Horário: </label>".'<span>'.$row->hora.'</span>';
                                        echo "<br><label>Mais informações: </label>".'<br>'.
                                        '<span>'.$row->mais_informacoes.'</span>';
                                        echo "<hr>";
                                        echo Html::a('<i class="fas fa-stopwatch"></i> Agendar', [
                                            'agendar', 'id' => $row->id,
                                            'cliente'=> $cliente_logado->id,
                                        ], 
                                        [
                                            'class' => 'btn btn-success',
                                            'style' => 'float:left',
                                            'data' => [
                                                'method' => 'post',
                                            ],
                                        ]);
                                        echo "<div class='clearfix'></div>";
                                    }
                                    else{
                                        echo "<label>"."Indisponível!"."</label>";
                                    }
                                    yii\bootstrap\Modal::end();

                                }
                                echo "<br>";
                            endif;
                            $turno_noite = SloAgenda::find()->where(['data'=>$dt->format('Y-m-d'),'turno'=>'noite'])->andFilterWhere(['slo_proposta_id' => $_REQUEST['SloAgenda']['slo_proposta_id']])->all();
                            if (count($turno_noite)):
                                echo "<hr><sup style='float:right'>Noite</sup><br>";
                                foreach ($turno_noite as $row) {
                                    
                                    $imovel_proposta = ' <span>(Pin-'.$row->sloProposta->codigo_imovel.')</span>';
                                    $bloqueado = false;

                                    if (Yii::$app->user->can('administrador')) {
                                        $bloqueado = false;
                                    } elseif (
                                        Yii::$app->user->can('corretor') and 
                                        Yii::$app->user->identity->id != $row->corretorIdcorretor->usuario_id) {
                                        $bloqueado = true;
                                    } else {
                                        $bloqueado = false;
                                    }

                                    $sou_cliente = false;
                                    $posso_agendar = false;

                                    if(Yii::$app->user->can('cliente') and (Yii::$app->user->identity->nome == $row->sloCliente->nome)){
                                        $sou_cliente = true;
                                    }elseif($row->sloCliente->nome == ''){
                                        $posso_agendar =true;
                                    }else{
                                        $bloqueado = true;
                                    }

                                    yii\bootstrap\Modal::begin([
                                        'header' => '<h4>'."<i class='fas fa-calendar'></i> Visita: PIN-".$row->sloProposta->codigo_imovel.'</h4>',
                                        'size'=>'modal-sm',
                                        'toggleButton' => [
                                            'label' => ($sou_cliente?
                                                '<i class="fas fa-stopwatch"></i> '.$row->hora.$imovel_proposta.' <br>Corretor: '.$row->corretorIdcorretor->nome.' <br><small class="badge" style="color:lime"><i>Marcado</i></small>'
                                                :'<i class="fas fa-clock"></i> '.$row->hora.$imovel_proposta.' <br>Corretor: '.$row->corretorIdcorretor->nome).
                                            ($posso_agendar?' <br><small  class="badge" style="color:blue"><i>Disponível</i></small>':'').
                                            ($bloqueado?'  <br><small class="badge" style="color:red"><i>Indisponível</i></small>':''),
                                            'class'=>"manha visualizar-registro btn btn-primary", 
                                            'title'=> 'Obs.: '.$row->mais_informacoes,
                                            'style' => 'font-weight: bolder; color: '.$row->corretorIdcorretor->cor,
                                            'disabled' => $bloqueado,
                                        ],
                                        'headerOptions' => [
                                            'style' => 'background-color:purple;color:white;'
                                        ],
                                        'options' => ['tabindex' => false],
                                    ]);
                                    if($sou_cliente){
                                        echo "<br><label>Data: </label> ".'<span>'.$diames.'</span>';
                                        echo "<br><label>Horário: </label> ".'<span>'.$row->hora.'</span>';
                                        echo "<br><label>Mais informações: </label>".'<br>'.
                                        '<span>'.$row->mais_informacoes.'</span>';
                                        echo "<hr>";
                                        echo Html::a('<i class="fas fa-stopwatch"></i> Desagendar', [
                                            'desagendar', 'id' => $row->id,
                                            'cliente'=> $cliente_logado->id,
                                        ], 
                                        [
                                            'class' => 'btn btn-warning',
                                            'style' => 'float:left',
                                            'data' => [
                                                'confirm' => 'Deseja realmente desagendar essa visita?',
                                                'method' => 'post',
                                            ],
                                        ]);
                                        echo "<div class='clearfix'></div>";
                                    }
                                    elseif ($posso_agendar) {
                                        echo "<br><label>Data: </label>".'<span>'.$diames.'</span>';
                                        echo "<br><label>Horário: </label>".'<span>'.$row->hora.'</span>';
                                        echo "<br><label>Mais informações: </label>".'<br>'.
                                        '<span>'.$row->mais_informacoes.'</span>';
                                        echo "<hr>";
                                        echo Html::a('<i class="fas fa-stopwatch"></i> Agendar', [
                                            'agendar', 'id' => $row->id,
                                            'cliente'=> $cliente_logado->id,
                                        ], 
                                        [
                                            'class' => 'btn btn-success',
                                            'style' => 'float:left',
                                            'data' => [
                                                'method' => 'post',
                                            ],
                                        ]);
                                        echo "<div class='clearfix'></div>";
                                    }
                                    else{
                                        echo "<label>"."Indisponível!"."</label>";
                                    }
                                    yii\bootstrap\Modal::end();

                                }
                                echo "<br>";
                            endif;

                        echo "</div>";
                    echo "</div>";
                    $i++;
                }
            ?>
        </div>
    </div>
    <div class="col-md-12">
    <?php /* echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'usuario_id',
            // 'slo_cliente_id',
            [
                'attribute' => 'slo_cliente_id',
                'value' => function($data){
                    return $data->sloCliente->nome;
                }
            ],
            // 'corretor_idcorretor',
            [
                'attribute' => 'corretor_idcorretor',
                'value' => function($data){
                    return $data->corretorIdcorretor->nome;
                }
            ],
            'data',
            'turno',
            'hora',
            // 'mais_informacoes:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); */ ?>
    </div>
</div>
