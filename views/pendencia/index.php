<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PendenciaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sa Pendencias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sa-pendencia-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sa Pendencia', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'titulo',
            'descricao:ntext',
            'usuario_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
