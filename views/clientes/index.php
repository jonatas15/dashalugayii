<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\bootstrap\Modal;

// $objPHPExcel = \PHPExcel_IOFactory::load(Yii::$app->basePath.'/web/planilias/serverxls.xlsx');
// $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
// echo '<pre>';
// print_r($sheetData);
// echo '</pre>';

/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clientes-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php 
        if (Yii::$app->user->can('administrador')) {
            Modal::begin([
                'header' => '<h4>Cadastrar Novo Cliente</h4>',
                'toggleButton' => [
                  'label' => '<i class="glyphicon glyphicon-plus"></i> Novo Cliente',
                  'class'=>"btn btn-info",
                  'title'=>'Cadastrar Novo Cliente',
                  'style'=>''
                ],
                'options' => ['tabindex' => false],
            ]);
            $model = new app\models\Clientes;
            echo $this->render('_form', ['model' => $model, 'modo' => 'create']);
            Modal::end();
            Modal::begin([
                'header' => '<h4>Enviar Planília ao Sistema</h4>',
                'toggleButton' => [
                  'label' => '<i class="fas fa-file-excel"></i> Subir Planília',
                  'class'=>"btn btn-info",
                  'title'=>'Subir Planília',
                  'style'=>''
                ],
                'options' => ['tabindex' => false],
            ]);
            // $model = new app\models\Clientes;
            
            echo $this->render('_formexcel', ['model' => $model]);
            Modal::end();
        }
    ?>
    <hr>

    <!-- <p>
        <?php //= Html::a('Create Clientes', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'export'=>[
            'showConfirmAlert'=>false,
            'target'=>GridView::TARGET_BLANK
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'setor',
            'cargo',
            // 'cpf',
            [
                'attribute' => 'cpf',
                'value' => function($data) {
                    $partes = str_split($data->cpf, 3);
                    return $partes[0].'.'.$partes[1].'.'.$partes[2].'-'.$partes[3];
                }
            ],
            'nome',
            'email:email',
            'proventos',
            // 'fone1',
            // 'fone2',
            [
                'attribute' => 'fone1',
                'value' => function($data) {
                    return $this->context->format_telefone($data->fone1);
                }
            ],
            [
                'attribute' => 'fone2',
                'value' => function($data) {
                    return $this->context->format_telefone($data->fone2);
                }
            ],
            // 'clientescol',
            // 'corretor',
            [
                'class' => 'kartik\grid\EditableColumn',
                'header' => 'Candidatar',
                'filter' => false, //'0'=>'Não','1'=>'Sim'],
                'attribute' => 'status',
                'value' => function($data) {
                    if ($data->corretor != null) {
                        $data->status = 1;
                        return $data->status;
                    }
                },
                'editableOptions' => function ($data) {
                    return [
                        'asPopover' => false,
                        'inputType' => Editable::INPUT_CHECKBOX_X,
                        'options' => [
                            'pluginOptions'=>[
                                'threeState'=>false,
                            ]
                        ],
                        'displayValue' => $data->corretor ? $data->corretor0->nome:'Canditar-me',
                        'formOptions' => [ 'action' => [ 'editregistro'] ],
                        // 'displayValueConfig'=> [
                        //     '0' => '<div style="color:red"><i class="glyphicon glyphicon-thumbs-down"></i> Não</div>',
                        //     '1' => '<div style="color:green"><i class="glyphicon glyphicon-thumbs-up"></i> Sim</div>',
                        // ],
                    ];
                },
                'visible' => Yii::$app->user->can('corretor')
            ],
            [
                'attribute' => 'corretor',
                'visible' => Yii::$app->user->can('administrador'),
                'value' => function($data) {
                    if ($data->corretor)
                        return $data->corretor0->nome;
                    else
                        return 'Não escolhido';
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'pjax'=>true,
        // 'showPageSummary'=>true,
        'panel'=>[
            'type'=>'info',
            'heading'=>'Clientes'
        ]
    ]); ?>


</div>
