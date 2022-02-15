<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TopicoupdatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Atualizações nos Tópicos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topicoupdates-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <hr>
    <?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'headerOptions' => ['style' => 'width:10%'],
                'attribute' => 'usuario_id',
                'filter' => ArrayHelper::map(app\models\Usuario::find()->asArray()->all(), 'id','nome'),
                'value' => function($data){
                    return $data->usuario->nome;
                }
            ],[
                'headerOptions' => ['style' => 'width:16%'],
                'attribute' => 'topico_id',
                'filter' => ArrayHelper::map(app\models\CyberTopico::find()->asArray()->all(), 'idtopico','titulo'),
                'value' => function($data){
                    return $data->topico->titulo;
                }
            ],
            [
                'headerOptions' => ['style' => 'width:10%'],
                'attribute' => 'datetime'
            ],
            [
                'headerOptions' => ['style' => 'width:10%'],
                'attribute' => 'antigo_campo'
            ],
            'antigo:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
