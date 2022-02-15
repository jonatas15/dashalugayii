<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PretendenteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pretendentes';
$this->params['breadcrumbs'][] = [
    'label' => 'Proposta PIN-'.$searchModel->proposta->codigo_imovel, 
    'url' => ['proposta/view?id='.$searchModel->proposta->id
]];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .table a .glyphicon {
        color: white;
        background-color: darkblue;
        font-size: 15px;
        padding: 10px;
        margin: 1px;
        border-radius: 20px;
    }
</style>
<div class="slo-pretendente-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <h4>
        <a href="<?=Yii::$app->homeUrl.'proposta/view?id='.$searchModel->proposta->id ?>">
        <?='Proposta pelo Imóvel PIN-'.$searchModel->proposta->codigo_imovel ?>
        </a>
    </h4>
    <p>
        <?= Html::a('Cadastrar Novo Pretendente', [
                'proposta/'.'pretendente001', 
                'proposta_id' => $searchModel->proposta->id,
                'pretendente_id' => 'novo'
            ], [
                'class' => 'btn btn-primary',
                'target'=>'_blank',
        ]) ?>

    </p>
    <hr>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //= Html::a('Create Slo Pretendente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                // 'id',
                // 'proposta_id',
                // 'morar_com_quem',
                // 'animais_extimacao',
                // 'apresentacao:ntext',

                [
                    'attribute' => 'infopessoal',
                    //'filter' => ArrayHelper::map(app\models\SloInfospessoais::find()->all(),'id','nome'),
                    'format' => 'raw',
                    'value' => function($data){
                        $pessoal = app\models\SloInfospessoais::find()->where([
                            'pretendente_id'=>$data->id
                        ])->one();
                        return '<a href="view?id='.$data->id.'" style="text-transform: capitalize; font-weight: bolder">'.$pessoal->nome.'</a>';
                    }
                ],
                [
                    'attribute' => 'infoprofissional',
                    //'filter' => ArrayHelper::map(app\models\SloInfosprofissionais::find()->all(),'id','empresa'),
                    'format' => 'raw',
                    'value' => function($data){
                        $profissional = app\models\SloInfosprofissionais::find()->where([
                            'pretendente_id'=>$data->id
                        ])->one();
                        return '<span style="text-transform: capitalize">'.$profissional->empresa.'</span>';
                    }
                ],
                [
                    'header' => 'Cônjuge',
                    'filter' => false,
                    'format' => 'raw',
                    'value' => function($data){
                        $conjuge = app\models\SloConjuje::find()->where([
                            'pretendente_id'=>$data->id
                        ])->one();
                        return '<span style="text-transform: capitalize">'.$conjuge->pessoa->nome.'</span>';
                    }
                ],
                // [
                //     'header' => 'Ver Mais',
                //     'format' => 'raw',
                //     'value' => function($data){
                //         return '<a href="view?id='.$data->id.'" class="btn"><i class="fas fa-eye"></i> Visualizar</a>';
                //     }
                // ],
                [
                    'header' => 'Nº Ocupantes',
                    'filter' => false,
                    'value' => function($data){
                        return count($data->sloOcupantes);
                    }
                ],
                // 'data',
                [
                    'attribute' => 'data',
                    'filter' => null,
                    'value' => function($data){
                        return date('d/m/Y', strtotime($data->data));
                    }
                ],
                [
                    'header' => 'Gerenciar',
                    'class' => 'yii\grid\ActionColumn',
                    'template'=>'{view} {delete}'
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
