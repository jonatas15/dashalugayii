<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchAgenda */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Agendas';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    i{
        color: #337ab7;
    }
</style>
<div class="slo-agenda-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
    <p><?= Html::a('Create Slo Agenda', ['create'], ['class' => 'btn btn-success']) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            'usuario.nome',
            // 'slo_cliente_id',
            'sloCliente.nome',
            // 'corretor_idcorretor',
            'corretorIdcorretor.nome',
            'sloProposta.codigo_imovel',
            [
                // 'attribute' => 'data',
                'header' => 'Período',
                'format' => 'raw',
                'value' => function($data){
                    return  '<label>Data:</label> '.'<i>'.date('d/m/Y',strtotime($data->data)).'</i>'.
                            '<br><label>Turno:</label> '.'<i>'.$data->turno.'</i>'.
                            '<br><label>Hora:</label> '.'<i>'.$data->hora.'</i>';
                }
            ],
            // 'imovel',
            'mais_informacoes:ntext',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
