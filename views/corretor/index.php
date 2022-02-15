<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CorretorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Corretores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="corretor-index">

    <h3><img src="<?=Yii::$app->homeUrl.'icones/corretor_b.png'?>" alt="" height="50" /><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p style="float: right">
        <?= Html::a('Novo Corretor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <hr>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idcorretor',
            'nome',
            'cor',
            'observacoes:ntext',
            // 'foto',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
