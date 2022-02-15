<?php

use yii\helpers\Html;
use yii\grid\GridView;

// use app\models\Imoveisexternos as Imoveis;

$todosimoveis = 0;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ImobiliariasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Imobiliarias');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="imobiliarias-index">

    <h3><?= Html::encode($this->title) ?></h3>
    
    <hr>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //= Html::a(Yii::t('app', 'Create Imobiliarias'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'nome',
            // [
            //     'attribute'=>'nome',
            //     'format'=>'raw',
            //     'value'=>function($data){
            //         return  Html::a('<span class="glyphicon glyphicon-home"></span> '.$data->nome, ['/imoveisexternos?ImoveisexternosSearch%5Bcodigo%5D=&ImoveisexternosSearch%5Bimobiliarias_id%5D='.$data->id], ['target'=>'_blank','class'=>'', 'title'=>'Ver Imóveis']);
            //     },
            // ],
            [
                'header' => '<center><span class="glyphicon glyphicon-home"></span></center>',
                'format'=>'raw',
                'value'=>function($data){
                    return  '<div style="white-space: nowrap;">'.Html::a('<span class="glyphicon glyphicon-home"></span> '.count($data->imoveisexternos), ['/imoveisexternos?ImoveisexternosSearch%5Bcodigo%5D=&ImoveisexternosSearch%5Bimobiliarias_id%5D='.$data->id], ['target'=>'_blank','class'=>'', 'title'=>'Ver Imóveis']).'</div>';
                }
            ],
            [
                'header' => '<center><span class="glyphicon glyphicon-stats"></span></center>',
                'format'=>'raw',
                'value'=>function($data){
                    return  '<div style="white-space: nowrap;">'.Html::a('<span class="glyphicon glyphicon-stats"></span> '.count($data->condominio), ['/condominio?CondominioSearch%5Bid%5D=&CondominioSearch%5Bnome%5D=&CondominioSearch%5Bslug%5D=&CondominioSearch%5Burl%5D=&CondominioSearch%5Bobservacoes%5D=&CondominioSearch%5Bid_imobiliarias%5D=7&CondominioSearch%5Bimobiliarias_id%5D='.$data->id], ['target'=>'_blank','class'=>'', 'title'=>'Ver Condomínios']).'</div>';
                }
            ],
            'url:url',
            'sitemap:url',
            // 'data_cadastro',
            // 'data_alteracao',
            [
                'header'=>'Operação',
                'format'=>'raw',
                'value'=>function($data){
                	if ($data->id == 3) {
                		return '<strong>Sob revisão</strong>';
                	}else{
	                    // $retorna = '<a target="_blank" href="'.Yii::$app->homeUrl.'imobiliarias/'.$data->id.'">condominios</a>';
	                    $retorna = Html::a('<span class="glyphicon glyphicon-stats"></span><span class="glyphicon glyphicon-cloud-download"></span>', ['imobiliarias/addcondominios?id='.$data->id], ['target'=>'_blank','class'=>'btn btn-success', 'title'=>'Baixar Condomínios']);
	                    $retorna .= ' ';
	                    $retorna .= Html::a('<span class="glyphicon glyphicon-home"></span><span class="glyphicon glyphicon-cloud-download"></span>', ['imobiliarias/view?id='.$data->id], ['target'=>'_blank','class'=>'btn btn-primary', 'title'=>'Baixar Imóveis']);
	                    return '<div style="white-space: nowrap;">'.$retorna.'</div>';
	                }
                }
            ],
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
