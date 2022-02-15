<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RegistrocampanhasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Registro de Leads das Campanhas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registrocampanhas-index">

    <h3 style="text-align: center; text-transform: uppercase;"><?= Html::encode($this->title) ?></h3>
    <hr>
    <p>
        <?php //= Html::a('Create Registrocampanhas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'formulario',
            'utm_medium',
            'utm_source',
            'utm_campaign',
            'data',
            'ip',
            //'obs:ntext',
            // 'fonte:ntext',
            [
                'attribute' => 'fonte',
                'format' => 'raw',
                'value' => function($data) {
                    $codigo = explode('/', $data->fonte);
                    return "<a href='{$data->fonte}'>Registro {$codigo[4]}</a>";
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
