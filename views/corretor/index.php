<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CorretorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Corretores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="corretor-index">

    <h3><img src="<?=Yii::$app->homeUrl.'icones/corretor_b.png'?>" alt="" height="50" /><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //= Html::a('Novo Corretor', ['create'], ['class' => 'btn btn-success']) 
        Modal::begin([
            'header' => '<h4>Novo Corretor</h4>',
            'toggleButton' => [
                'label' => 'Novo Corrretor',
                'class' => 'btn btn-success'
            ],
            'options' => [
                'style' => [
                    // 'z-index' => '99999999999 !important'
                ]
            ]
        ]);
        $modelcorretor = new \app\models\Corretor();
        echo $this->render('_form2', [
            'model' => $modelcorretor,
        ]);
        
        Modal::end();
        ?>
    </p>
    <br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'idcorretor',
            // 'nome',
            [
                'attribute' => 'nome',
                'format' => 'raw',
                'headerOptions' => ['style' => 'width:20%'],
                'value' => function ($data) {
                    return $this->context->imprime_campo_editavel('12', 'Corretor', 'nome', '', $data->nome, $data->idcorretor);
                }
            ],
            // 'cor',
            // 'telefone',
            [
                'attribute' => 'telefone',
                'format' => 'raw',
                'headerOptions' => ['style' => 'width:20%'],
                'value' => function ($data) {
                    return $this->context->imprime_campo_editavel('12', 'Corretor', 'telefone', '', $data->telefone, $data->idcorretor);
                }
            ],
            // 'observacoes:ntext',
            [
                'attribute' => 'observacoes',
                'format' => 'raw',
                'headerOptions' => ['style' => 'width:25%'],
                'value' => function ($data) {
                    return $this->context->imprime_campo_editavel('12', 'Corretor', 'observacoes', '', $data->observacoes, $data->idcorretor);
                }
            ],
            // 'foto',
            [
                'attribute' => 'usuario_id',
                'visible' => (Yii::$app->user->identity->id == 1 ? true : false),
                'format' => 'raw',
                'value' => function ($data) {
                    return $this->context->imprime_campo_editavel('12', 'Corretor', 'usuario_id', '', $data->usuario_id, $data->idcorretor);
                }
            ],
            [
                'attribute' => 'historico',
                'header' => "Última msg",
                'format' => 'raw',
                'value' => function ($data) {
                    $arr = '{
                        "valores": ['.substr($data->historico, 0, -1).']}';
                    // $arr = '{data:"",mensagem:"teste de envio individual"},{data:"2022-12-07 14:53:26",mensagem:"Imóvel tal: https://www.cafeimobiliaria.com.br/imovel/2804/venda-casa-4-dormitorios-3-vagas-camobi-santa-maria-rs-destaque"}';
                    $arr = json_decode($arr, true);
                    $ultimo = end($arr["valores"]);
                    return $ultimo["mensagem"];
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}'
            ],
        ],
    ]); ?>
</div>
<style>
    input, button, select, optgroup, textarea {
        margin: 0;
        font-family: inherit;
        font-size: large !important;
        line-height: inherit;
    }
</style>