<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuários';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'btn btn-success', 'style'=>"float:right;margin:10px"]) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            [
                'attribute'=>'foto',
                'filter'=>'',
                'format'=>'html',
                'value'=>function($data){
                    return Html::img(Yii::$app->homeUrl.'usuarios/'.$data->foto, ['width' => '50']);
                }
            ],
            'nome',
            'tipo',
            'username',
            'email',
            //'password',
            'mais_informacoes:ntext',
            // 'foto',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
