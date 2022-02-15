<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CybercomentarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cyber Comentarios');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cyber-comentario-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Cyber Comentario'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idcyber_comentario',
            'usuario_id',
            'cyber_topico_idtopico',
            'cyber_idcyber',
            'comentario:ntext',
            // 'datetime',
            // 'imagem',
            // 'documento',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
