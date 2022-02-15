<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ExtratoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Extratos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="extrato-index">

    <h1><?= Html::encode($this->title) ?>
    <?= Html::a(Yii::t('app', 'Novo Extrato'), ['create'], ['class' => 'btn btn-success','style'=>'float: right;']) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'mes',
            // 'data_aplicacao',
            [
                'attribute' => 'data_aplicacao',
                'format' => 'html',
                'value' => function($data){
                    return Yii::$app->formatter->asDate($data->data_aplicacao,'dd/M/Y');
                }
            ],
            // 'data_vencimento',
            [
                'attribute' => 'data_vencimento',
                'format' => 'html',
                'value' => function($data){
                    return Yii::$app->formatter->asDate($data->data_vencimento,'dd/M/Y');
                }
            ],
            // 'receita_locacao',
            [
                // 'header' => 'Valor Locação',
                'attribute'=>'receita_locacao',
                // 'filter'=>ArrayHelper::map(Locatario::find()->asArray()->all(), 'id', 'nome'),
                'value'=> function($data){
                    return 'R$ ' . number_format($data->receita_locacao, 2, ',', '.');
                }
            ],
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
                'attribute'=>'iptu_apt_garag',
                // 'filter'=>ArrayHelper::map(Locatario::find()->asArray()->all(), 'id', 'nome'),
                'value'=> function($data){
                    return 'R$ ' . number_format($data->iptu_apt_garag, 2, ',', '.');
                }
            ],
            // [
            //     // 'header' => 'Valor Locação',
            //     'attribute'=>'condominio',
            //     // 'filter'=>ArrayHelper::map(Locatario::find()->asArray()->all(), 'id', 'nome'),
            //     'value'=> function($data){
            //         return 'R$ ' . number_format($data->condominio, 2, ',', '.');
            //     }
            // ],
            [
                // 'header' => 'Valor Locação',
                'attribute'=>'total',
                // 'filter'=>ArrayHelper::map(Locatario::find()->asArray()->all(), 'id', 'nome'),
                'value'=> function($data){
                    return 'R$ ' . number_format($data->total, 2, ',', '.');
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
            [
                'attribute' => 'data_pagamento',
                'format' => 'html',
                'value' => function($data){
                    return Yii::$app->formatter->asDate($data->data_pagamento,'dd/M/Y');
                }
            ],
            // 'locatario_id',
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
        // 'bordered'=>$bordered,
        // 'striped'=>$striped,
        // 'condensed'=>$condensed,
        // 'responsive'=>$responsive,
        // 'hover'=>$hover,
        // 'showPageSummary'=>$pageSummary,
        'panel'=>[
            // 'type'=>GridView::TYPE_PRIMARY,
            'heading'=>$heading,
        ],
        // 'persistResize'=>false,
        'toggleDataOptions'=>['minCount'=>10],
        // 'exportConfig'=>$exportConfig,
    ]); ?>
<?php Pjax::end(); ?></div>
