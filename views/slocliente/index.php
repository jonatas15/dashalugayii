<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SloclienteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clientes cadastrados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slo-cliente-index">

    <h3 style="">
        <strong style="float:left">Clientes cadastrados</strong>
        <?= Html::a('Novo  <i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'btn btn-success', 'style'=>'float:right;margin-bottom:10px']) ?>
    </h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <br>
    <br>
    <hr>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            'nome',
            'observacoes:ntext',
            // 'data_nascimento',
            [
                'attribute' => 'data_nascimento',
                'filter' => '',
                'value' => function($data){
                    return date('d/m', strtotime($data->data_nascimento));
                }
            ],
            // 'slo_clientecol',
            // 'usuario_id',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
