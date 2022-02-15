<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use app\models\Locatario;
use app\models\Proprietario;

/* @var $this yii\web\View */
/* @var $model app\models\Locatario */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Locatários', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="locatario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="col-lg-6">
    <h3>Locatário</h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'nome',
            'contato',
            'codigo_do_imovel',
            'logradouro',
            'numero_do_apartamento',
            'numero_do_box',
            [
                'attribute'=>'inicio_da_locacao',
                'value'=> Yii::$app->formatter->asDate($model->inicio_da_locacao,'dd/MM/Y'),
            ],
            'mais_informacoes:ntext',
            // 'proprietario.nome',
            // 'proprietario_mes_referencia_id',
        ],
        ]) ?>
    </div>
    <?php /*
    <div class="col-lg-6">
        <h3>Propprietário</h3>
    <?= DetailView::widget([
        'model' => $model->proprietario,
        'attributes' => [
            // 'id',
            'nome',
            // 'locatario_id',
            'conta_deposito',
            'codigo_imovel',
            'logradouro',
            'inicio_locacao',
            'mais_informacoes:ntext',
            // 'mes_referencia_id',
            'contato',
            'recebe',
        ],
        ]) ?>
    </div>
    */ ?>
    <div class="col-lg-12">
        <h3>Extratos: Faturas e Movimentações</h3>
        <?php
        use yii \ widgets \ ListView ;
        use yii \ data \ ActiveDataProvider ;
        
        $dataProvider = new ActiveDataProvider([
            'query' => app\models\Extrato::find()->where(['locatario_id'=>$model->id]),
            'pagination' => [
                'pageSize' => 20 ,
            ],
        ]);
        //  echo ListView::widget([
        //      'dataProvider' => $dataProvider ,
        //      'itemView' => '_post' ,
        //  ]);
        ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            // 'filterModel' => app\models\FaturasLocacaoSearch::search($model->faturasLocacaos),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                // 'id',
                // [
                //     'attribute'=>'locatario_id',
                //     'filter'=>ArrayHelper::map(Locatario::find()->asArray()->all(), 'id', 'nome'),
                //     'value'=>'locatario.nome'
                // ],
                // 'data_aplicacao',
                // 'data_vencimento',
                [
                    'attribute'=>'data_aplicacao',
                    'value'=> function($data){
                        return Yii::$app->formatter->asDate($data->data_aplicacao,'dd/MM/Y');
                    }
                ],
                [
                    'attribute'=>'data_vencimento',
                    'value'=> function($data){
                        return Yii::$app->formatter->asDate($data->data_vencimento,'dd/MM/Y');
                    }
                ],
                // 'iptu_apt_garag',
                // 'condominio',
                // 'total',
                [
                    'attribute'=>'iptu_apt_garag',
                    // 'filter'=>ArrayHelper::map(Locatario::find()->asArray()->all(), 'id', 'nome'),
                    'value'=> function($data){
                        return 'R$ ' . number_format($data->iptu_apt_garag, 2, ',', '.');
                    }
                ],
                [
                    'attribute'=>'condominio',
                    // 'filter'=>ArrayHelper::map(Locatario::find()->asArray()->all(), 'id', 'nome'),
                    'value'=> function($data){
                        return 'R$ ' . number_format($data->condominio, 2, ',', '.');
                    }
                ],
                [
                    'attribute'=>'total',
                    // 'filter'=>ArrayHelper::map(Locatario::find()->asArray()->all(), 'id', 'nome'),
                    'value'=> function($data){
                        return 'R$ ' . number_format($data->total, 2, ',', '.');
                    }
                ],
                // 'locatario_id',
                // ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>

</div>
