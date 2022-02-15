<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ChtopicoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chtopicos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chtopico-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Chtopico', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'conteudo:ntext',
            'checked',
            'checklist_id',
            'topico_pai',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
