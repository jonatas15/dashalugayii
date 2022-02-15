<?php

use yii\helpers\Html;
// use yii\bootstrap\Modal;
use yii\bootstrap\Collapse;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LocatarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pesquisar Locatários';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="locatario-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php 
    // Modal::begin([
    //     'id' => 'abre_pesquisa',
    //     'header' => '<h4>Pesquisa por Locatários</h4>',
    //     'toggleButton' => [
    //         'label' => ' Pesquisa avançada',
    //         'class' => 'btn btn-primary glyphicon glyphicon-eye-open btn2',
    //         'alt' => 'Mais Informações',
    //         'title' => 'Mais Informações',
    // ]]);
    ?>
    <!-- <div id ="modalContentCreate"> -->
    <!-- </div> -->
    <?php //Modal::end(); ?>
    <div class="col-lg-4">
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <div class="col-lg-8">
    <p>
        <?= Html::a('Cadastrar Novo Locatario', ['create'], ['class' => 'btn btn-success','style'=>'float:right;margin-bottom:12px']) ?>
    </p>
    <hr>
    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'class'=>'kartik\grid\ExpandRowColumn',
                    'width'=>'50px',
                    'value'=>function ($model, $key, $index, $column) {
                        return GridView::ROW_COLLAPSED;
                    },
                    'detail'=>function ($model, $key, $index, $column) {
                        return Yii::$app->controller->renderPartial('detalhes', ['model'=>$model]);
                    },
                    'headerOptions'=>['class'=>'kartik-sheet-style'] ,
                    'expandOneOnly'=>true
                ],
                // 'id',
                'nome',
                'contato',
                'codigo_do_imovel',
                'logradouro',
                // 'numero_do_box',
                // 'inicio_da_locacao',
                // 'mais_informacoes:ntext',
                // 'proprietario_id',
                // 'proprietario_mes_referencia_id',
                
                ['class' => 'yii\grid\ActionColumn'],
            ],
            'exportConfig' => [
                GridView::CSV => [
                ],
            ],
        ]); ?>
    </div>
</div>
