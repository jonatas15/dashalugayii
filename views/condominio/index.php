<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use app\models\Imobiliarias;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CondominioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Condomínio';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="condominio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // = Html::a(Yii::t('app', 'Create Condominio'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <hr>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'nome',
            'slug',
            'url:url',
            // 'observacoes:ntext',
            // 'id_imobiliarias',
            [
                'attribute' => 'id_imobiliarias',
                'filter' => ArrayHelper::map(Imobiliarias::find()->asArray()->all(), 'id','nome'),
                'value' => function($data){
                    return $data->idImobiliarias->nome;
                }
            ],
            [
                'header' => '<center><span class="glyphicon glyphicon-home"></span></center>',
                'format'=>'raw',
                'value'=>function($data){
                    return  '<div style="white-space: nowrap;">'.Html::a('<span class="glyphicon glyphicon-home"></span> '.count($data->idImoveis), ['/imoveisexternos/index?ImoveisexternosSearch%5Bcodigo%5D=&ImoveisexternosSearch%5Bimobiliarias_id%5D=&ImoveisexternosSearch%5Bcontrato%5D=&ImoveisexternosSearch%5Bvaloresdevenda%5D=5%2C1000000&ImoveisexternosSearch%5Bvaloresdelocacao%5D=5%2C20000&ImoveisexternosSearch%5Barea_privativa%5D=0&ImoveisexternosSearch%5Btipo%5D=&ImoveisexternosSearch%5Bcondominio%5D=&ImoveisexternosSearch%5Bcondominio%5D%5B%5D='.$data->nome.'&ImoveisexternosSearch%5Barr_dormitorios%5D=&ImoveisexternosSearch%5Bgaragens%5D=&ImoveisexternosSearch%5Bendereco_bairro%5D='], ['target'=>'_blank','class'=>'', 'title'=>'Ver Imóveis']).'</div>';
                }
            ],

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
