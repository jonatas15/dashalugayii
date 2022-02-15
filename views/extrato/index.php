<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Collapse;
use kartik\grid\GridView;
use app\models\Locatario;
use app\models\Proprietario;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ExtratoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$data = '';

$this->title = Yii::t('app', 'Extratos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="extrato-index">

    <h1><?= Html::encode($this->title) ?><?= Html::a(Yii::t('app', 'Novo Extrato'), ['create'], ['class' => 'btn btn-success','style'=>'float: right;']) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        
    </p>
    <?php /*
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'mes',
            'data_aplicacao',
            'data_vencimento',
            'receita_locacao',
            // 'receitas_subtotal',
            // 'iptu',
            // 'iptu_apt_garag',
            // 'condominio',
            // 'taxa_condominio',
            // 'outros',
            // 'total',
            // 'nosso_numero',
            // 'numero_nota',
            // 'honorarios_porcentagem',
            // 'honorarios_valor',
            // 'honorarios_admin',
            // 'descontos_subtotal',
            // 'total_depositado',
            // 'descricao_descontos',
            // 'valor_pago_ao_proprietario',
            // 'data_pagamento',
            'locatario_id',
            'proprietario_id',
            // 'base_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
*/ ?>
<?php
echo GridView::widget([
    'id'=>'kv-grid-demo',
    'dataProvider'=>$dataProvider,
    'filterModel'=>$searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'class'=>'kartik\grid\ExpandRowColumn',
            'width'=>'50px',
            'value'=>function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail'=>function ($model) {
            // 'detail'=>function ($data, $model) {
                //$model = new \app\models\Extrato;
                return Yii::$app->controller->renderPartial('view', ['model'=>$model,'id'=>$data->id]);
            },
            'headerOptions'=>['class'=>'kartik-sheet-style'] ,
            'expandOneOnly'=>true
        ],
        // 'id',
        'mes',
        [
            'attribute' => 'proprietario_id',
            'filter'=>ArrayHelper::map(Proprietario::find()->asArray()->all(), 'id', 'nome'),
            'value'=>'proprietario.nome',
        ],
        [
            'attribute' => 'locatario_id',
            'filter'=>ArrayHelper::map(Locatario::find()->asArray()->all(), 'id', 'nome'),
            'value'=>'locatario.nome',
        ],
        [
            'attribute' => 'data_aplicacao',
            'format' => 'html',
            'value' => function($data){
                return Yii::$app->formatter->asDate($data->data_aplicacao,'dd/M/Y');
            }
        ],
        [
            'attribute' => 'data_vencimento',
            'format' => 'html',
            'value' => function($data){
                return Yii::$app->formatter->asDate($data->data_vencimento,'dd/M/Y');
            }
        ],
        [
            // 'header' => 'Valor Locação',
            'attribute'=>'receita_locacao',
            // 'filter'=>ArrayHelper::map(Locatario::find()->asArray()->all(), 'id', 'nome'),
            'value'=> function($data){
                return 'R$ ' . number_format($data->receita_locacao, 2, ',', '.');
            }
        ],
        ['class' => 'yii\grid\ActionColumn'],
    ],
    'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
    'headerRowOptions'=>['class'=>'kartik-sheet-style'],
    'filterRowOptions'=>['class'=>'kartik-sheet-style'],
    'pjax'=>true, // pjax is set to always true for this demo
    // set your toolbar
    'toolbar'=> [
        // ['content'=>
        //     Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>Yii::t('kvgrid', 'Add Book'), 'class'=>'btn btn-success', 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
        //     Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['grid-demo'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('kvgrid', 'Reset Grid')])
        // ],
        '{export}',
        '{toggleData}',
    ],
    // set export properties
    'export'=>[
        'fontAwesome'=>true
    ],
    // parameters from the demo form
    // 'bordered'=>$bordered,
    // 'striped'=>$striped,
    // 'condensed'=>$condensed,
    // 'responsive'=>$responsive,
    // 'hover'=>$hover,
    'showPageSummary'=>'',
    'panel'=>[
        // 'type'=>GridView::TYPE_PRIMARY,
        'heading'=>true,
    ],
    'persistResize'=>false,
    'toggleDataOptions'=>['minCount'=>10],
    // 'exportConfig'=>$exportConfig,
]);