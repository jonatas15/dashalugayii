<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ChecklistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Checklists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="checklist-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Checklist', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'titulo',
            'subtitulo',
            'pretendente_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
