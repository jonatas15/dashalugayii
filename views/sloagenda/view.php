<?php

use yii\helpers\Html;
// use yii\widgets\DetailView;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;

use app\models\SloCliente;
use app\models\SloProposta;
use app\models\Corretor;

/* @var $this yii\web\View */
/* @var $model app\models\SloAgenda */
/* @var $model app\models\Corretor */

?>
<div class="slo-agenda-view">

    <?php /*= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            // 'usuario_id',
            'sloCliente.nome',
            // 'corretor_idcorretor',
            'corretorIdcorretor.nome',
            // 'data',
            'imovel',
            [
                'attribute' => 'data',
                'value' => date('d/m/Y', strtotime($model->data))
            ],
            'turno',
            'hora',
            'mais_informacoes:ntext',
        ],
    ]) */ ?>
    <?= DetailView::widget([
                'model'=>$model,
                'condensed'=>true,
                'hover'=>true,
                'mode'=>DetailView::MODE_VIEW,
                'panel'=>[
                    'heading'=>'Código: ' . $model->id,
                    'type'=>DetailView::TYPE_INFO,
                ],
                'attributes'=>[
                    [
                        'attribute'=>'slo_cliente_id',
                        'format'=>'raw',
                        'value'=>$model->sloCliente->nome,
                        'type'=>DetailView::INPUT_SELECT2, 
                        'widgetOptions'=>[
                            'data'=>ArrayHelper::map(SloCliente::find()->orderBy('nome')->asArray()->all(), 'id', 'nome'),
                            'options' => ['placeholder' => 'Select ...','id' => 'cliente-'.$id,],
                            'pluginOptions' => ['allowClear'=>true, 'width'=>'100%'],
                        ]
                    ],
                    [
                        'attribute' => 'corretor_idcorretor',
                        'format' => 'raw',
                        'value'=> $model->corretorIdcorretor->nome,
                        'type' => DetailView::INPUT_SELECT2, 
                        'widgetOptions' => [
                            'data' => ArrayHelper::map(Corretor::find()->orderBy('nome')->asArray()->all(), 'idcorretor', 'nome'),
                            'options' => ['placeholder' => 'Select ...','id' => 'corretor-'.$id,],
                            'pluginOptions' => ['allowClear'=>true, 'width'=>'100%',],
                        ],
                        'visible' => Yii::$app->user->can('administrador'),
                    ],
                    // 'imovel',
                    [
                        'attribute'=>'slo_proposta_id',
                        'format'=>'raw',
                        'value'=>$model->sloProposta->codigo_imovel,
                        'type'=>DetailView::INPUT_SELECT2, 
                        'widgetOptions'=>[
                            'data'=>ArrayHelper::map(SloProposta::find()->orderBy('codigo_imovel')->asArray()->all(), 'id', 'codigo_imovel'),
                            'options' => ['placeholder' => 'Select ...','id' => 'proposta-'.$id,],
                            'pluginOptions' => ['allowClear'=>true, 'width'=>'100%'],
                        ]
                    ],
                    [
                        'attribute' => 'turno',
                        'format' => 'raw',
                        'value'=> $model->turno,
                        'type' => DetailView::INPUT_SELECT2, 
                        'widgetOptions' => [
                            'data' => ['manhã'=>'Manhã','tarde'=>'Tarde','noite'=>'Noite'],
                            'options' => ['placeholder' => 'Select ...','id' => 'turno-'.$id,],
                            'pluginOptions' => ['allowClear'=>true, 'width'=>'100%',],
                        ]
                    ],
                    [
                        'attribute' => 'hora',
                        'format' => 'raw',
                        'value'=> $model->hora,
                        'type' => DetailView::INPUT_TIME, 
                        'widgetOptions' => [
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'HH:ii',
                                'showSeconds' => true,
                                'showMeridian' => false,
                                'minuteStep' => 1,
                                'secondStep' => 5,
                            ],
                            'options' => ['id' => 'hora-'.$id,],
                        ]
                    ],
                    [
                        'attribute'=>'mais_informacoes', 
                        'type'=>DetailView::INPUT_TEXTAREA
                    ],

                ],
                'formOptions' => ['action' => ['update','id'=>$model->id]]
            ]); ?>
    <p>
        <?= Html::a('Excluir', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'style' => 'float:left',
            'data' => [
                'confirm' => 'Deseja realmente excluir esse Registro',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <br>
    <hr>
</div>
