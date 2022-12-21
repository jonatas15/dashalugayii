<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LeadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lead-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <p>
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </p>
    <br />
    <div class="clearfix"></div>
    <br />
    <p>
        <?php //= Html::a('Create Lead', ['create'], ['class' => 'btn btn-success']) ?>
        <?php 
            Modal::begin([
                'header' => '<h4>Novo Lead</h4>',
                'toggleButton' => [
                    'label' => 'Novo Lead',
                    'class' => 'btn btn-success'
                ],
                'options' => [
                    'style' => [
                        'z-index' => '99999999999 !important'
                    ]
                ]
            ]);
            $modellead = new \app\models\Lead();
            echo $this->render('_form', [
                'model' => $modellead,
            ]);
            
            Modal::end();
        ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            // 'titulo',
            [
                'attribute' => 'titulo',
                'format' => 'raw',
                'value' => function ($data) {
                    return $this->context->imprime_campo_editavel('12', 'Lead', 'titulo', '', $data->titulo, $data->id);
                }
            ],
            [
                'attribute' => 'descricao',
                'format' => 'raw',
                'value' => function ($data) {
                    return $this->context->imprime_campo_editavel('12', 'Lead', 'descricao', '', $data->descricao, $data->id);
                }
            ],
            // 'descricao:ntext',
            'data',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}'
            ],
        ],
    ]); ?>


</div>
