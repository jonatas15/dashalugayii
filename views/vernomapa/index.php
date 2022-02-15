<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Alert;
use kartik\number\NumberControl;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VernomapaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Clicks no endereço do imóvel no Site';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vernomapa-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <hr>
    <?php // echo $this->render('_search', ['model' => $searchModel]);
    use miloschuman\highcharts\Highcharts;


    ?>

    <p></p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'thumb',
                'header'=>'Imagem',
                'filter'=>'',
                'format'=>'html',
                'value'=>function($data){
                    return Html::img($data->thumb, ['width' => '75']);
                }
            ],
            [
                'attribute'=>'codigo',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Pesquisar por Código',
                    'alt' => 'Pesquisar por Código',
                    'title' => 'Pesquisar por Código'
                ],
                'format'=>'html',
                'value'=>function($data){
                    $_0 = '';
					if(strlen($data->codigo) == 3){
						$_0 = '0';
					}
                    return "<a href='https://www.cafeinteligencia.com.br/imovel/$_0$data->codigo'>PIN - $_0$data->codigo</a>";
                }
            ],
            [
                'attribute'=>'logradouro',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Pesquisar por logradouro',
                    'alt' => 'Pesquisar por logradouro',
                    'title' => 'Pesquisar por logradouro'
                ],
                'format'=>'html',
                'filter'=>ArrayHelper::map(app\models\Vernomapa::find()->asArray()->all(), 'logradouro', 'logradouro'),
            ],
            [
                'attribute'=>'bairro',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Pesquisar por bairro',
                    'alt' => 'Pesquisar por bairro',
                    'title' => 'Pesquisar por bairro'
                ],
                'format'=>'html',
                'filter'=>ArrayHelper::map(app\models\Vernomapa::find()->asArray()->all(), 'bairro', 'bairro'),
            ],
            [
                'attribute'=>'cidade',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Pesquisar por cidade',
                    'alt' => 'Pesquisar por cidade',
                    'title' => 'Pesquisar por cidade'
                ],
                'format'=>'html',
                'filter'=>ArrayHelper::map(app\models\Vernomapa::find()->asArray()->all(), 'cidade', 'cidade'),
            ],
            [
                'attribute'=>'contrato',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Pesquisar por contrato',
                    'alt' => 'Pesquisar por contrato',
                    'title' => 'Pesquisar por contrato'
                ],
                'filter'=>['Compra'=>'Venda','Locação'=>'Locação'],
                'format'=>'html',
            ],
            [
                'attribute'=>'valor_venda',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Pesquisar pelo valor de venda',
                    'alt' => 'Pesquisar pelo valor de venda',
                    'title' => 'Pesquisar pelo valor de venda'
                ],
                'format'=>'html',
            ],
            [
                'attribute'=>'valor_locacao',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Pesquisar pelo valor de locação',
                    'alt' => 'Pesquisar pelo valor de locação',
                    'title' => 'Pesquisar pelo valor de locação'
                ],
                'format'=>'html',
            ],
            // [
            //     'attribute'=>'valor_venda',
            //     'format'=>'html',
            //     'filter'=>  NumberControl::widget([
            //         'name'=>'VernomapaSearch[valor_venda]',
            //         'maskedInputOptions' => [
            //             'prefix' => 'R$ ',
            //             'groupSeparator' => '.',
            //             'radixPoint' => ',',
            //             'allowMinus' => false,
            //             'unmaskAsNumber'=>false
            //         ],
            //     ])
            // ],
            // [
            //     'attribute'=>'valor_locacao',
            //     'format'=>'html',
            //     'filter'=>  NumberControl::widget([
            //         'model'=>$searchModel,
            //         'attribute'=>'valor_locacao',
            //         'maskedInputOptions' => [
            //             // 'prefix' => 'R$ ',
            //             'groupSeparator' => '.',
            //             'radixPoint' => ',',
            //             'allowMinus' => false,
            //             'unmaskAsNumber'=>false
            //         ],
            //     ])
            // ],
            // 'valor_locacao',
            [
                'attribute'=>'data',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Formato: 00-00 ou 00:00',
                    'alt' => 'Formato: 00-00 ou 00:00',
                    'title' => 'Formato: 00-00 ou 00:00'
                ],
                // 'filter'=>ArrayHelper::map(app\models\Vernomapa::find()->asArray()->all(), 'data', 'data'),
            ],
            [
                'attribute'=>'ip',
                'filterInputOptions' => [
                    'class'       => 'form-control',
                    'placeholder' => 'Pesquisar pelo endereço IP',
                    'alt' => 'Pesquisar pelo IP',
                    'title' => 'Pesquisar pelo IP'
                ],
                'format'=>'html',
                'filter'=>ArrayHelper::map(app\models\Vernomapa::find()->asArray()->all(), 'ip', 'ip'),
            ],
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php

    echo Alert::widget([
        'options' => [
            'class' => 'alert-info',
        ],
        'body' => '<h4>(Sugestão: opções de gráficos) Se optarem pela opção, favor ajudar a definir como devem ser, funciamento, lógica, eixos, o que mostrar... etc.'.
        '</h4><hr>'.
        Highcharts::widget([
         'options' => [
            'title' => ['text' => '(Sugestão: opções de gráficos)'],
            'xAxis' => [
               'categories' => ['Santa Maria', 'Itaara', 'São Pedro do Sul']
            ],
            'yAxis' => [
               'title' => ['text' => 'Clicks no endereço do imóvel']
            ],
            'series' => [
               ['name' => 'Janeiro', 'data' => [1, 0, 4]],
               ['name' => 'Fevereiro', 'data' => [5, 7, 3]]
            ]
         ]
      ])
    ]);

    ?>
</div>
