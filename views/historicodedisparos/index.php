<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HistoricodedisparosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Historicodedisparos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="historicodedisparos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Historicodedisparos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'data',
            // 'mensagem:html',
            [
                'attribute' => 'mensagem',
                'format' => 'html',
                'value' => function($data) {
                    return utf8_decode($data->mensagem);
                }
            ],
            // 'proposta_id',
            // 'usuario_id',
            'etapa',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
