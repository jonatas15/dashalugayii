<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

use app\models\Locatario;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ExtratoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Extratos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="extrato-index">

    <h1><?= Html::encode($this->title) ?><?= Html::a(Yii::t('app', 'Novo Extrato'), ['create'], ['class' => 'btn btn-success','style'=>'float: right;']) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'options' => [
        'orientation' => 'portrait',
    ],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        
            // 'id',
            [
                'attribute' => 'locatario_id',
                'filter'=>ArrayHelper::map(Locatario::find()->asArray()->all(), 'id', 'nome'),
                'value'=>'locatario.nome',
            ],
            'mes',
            // 'data_aplicacao',
            // 'data_vencimento',
            'receita_locacao',
            [
                // 'header' => 'Valor Locação',
                'attribute'=>'iptu',
                // 'filter'=>ArrayHelper::map(Locatario::find()->asArray()->all(), 'id', 'nome'),
                'value'=> function($data){
                    return 'R$ ' . number_format($data->iptu, 2, ',', '.');
                }
            ],
            [
                // 'header' => 'Valor Locação',
                'attribute'=>'receitas_subtotal',
                // 'filter'=>ArrayHelper::map(Locatario::find()->asArray()->all(), 'id', 'nome'),
                'value'=> function($data){
                    return 'R$ ' . number_format($data->receitas_subtotal, 2, ',', '.');
                }
            ],
            [
                // 'header' => 'Valor Locação',
                'attribute'=>'taxa_condominio',
                // 'filter'=>ArrayHelper::map(Locatario::find()->asArray()->all(), 'id', 'nome'),
                'value'=> function($data){
                    return 'R$ ' . number_format($data->taxa_condominio, 2, ',', '.');
                }
            ],
            [
                // 'header' => 'Valor Locação',
                'attribute'=>'outros',
                // 'filter'=>ArrayHelper::map(Locatario::find()->asArray()->all(), 'id', 'nome'),
                'value'=> function($data){
                    return 'R$ ' . number_format($data->outros, 2, ',', '.');
                }
            ],
            [
                // 'header' => 'Valor Locação',
                'attribute'=>'honorarios_admin',
                // 'filter'=>ArrayHelper::map(Locatario::find()->asArray()->all(), 'id', 'nome'),
                'value'=> function($data){
                    return 'R$ ' . number_format($data->honorarios_admin, 2, ',', '.');
                }
            ],
            [
                // 'header' => 'Valor Locação',
                'attribute'=>'descontos_subtotal',
                // 'filter'=>ArrayHelper::map(Locatario::find()->asArray()->all(), 'id', 'nome'),
                'value'=> function($data){
                    return 'R$ ' . number_format($data->descontos_subtotal, 2, ',', '.');
                }
            ],
            [
                // 'header' => 'Valor Locação',
                'attribute'=>'total_depositado',
                // 'filter'=>ArrayHelper::map(Locatario::find()->asArray()->all(), 'id', 'nome'),
                'value'=> function($data){
                    return 'R$ ' . number_format($data->total_depositado, 2, ',', '.');
                }
            ],
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
            // 'proprietario_id',
            // 'base_id',

            // ['class' => 'yii\grid\ActionColumn'],
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
        'showPageSummary'=>$pageSummary,
        'panel'=>[
            // 'type'=>GridView::TYPE_PRIMARY,
            'heading'=>$heading,
        ],
        'persistResize'=>false,
        'toggleDataOptions'=>['minCount'=>10],
        // 'exportConfig'=>$exportConfig,
    ]); ?>
<?php Pjax::end(); ?></div>
