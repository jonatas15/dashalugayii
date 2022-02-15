<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\Usuario;
use kartik\daterange\DateRangePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PropostaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Propostas';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .table a .glyphicon {
        color: white;
        background-color: darkblue;
        font-size: 15px;
        padding: 10px;
        margin: 1px;
        border-radius: 20px;
    }
</style>
<div class="slo-proposta-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Cadastrar Nova Proposta', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Limpar Filtros', ['index'], ['class' => 'btn btn-warning float-right']) ?>
    </p>
<?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nome',
            [
                'attribute'=> 'usuario_id',
                'filter'=> ArrayHelper::map(Usuario::find()->all(),'id','nome'),
                'value' => function($data){
                    return $data->usuario->nome;
                }
            ],
            [
                'attribute' => 'tipo',
                'filter' => ['Express'=>'Express','Personalizada'=>'Personalizada',],
            ],
            'codigo_imovel',
            [
                'attribute' => 'prazo_responder',
                'filter' => '<div class="input-group drp-container">'.DateRangePicker::widget([
                    'language'=>'pt',
                    'name' => 'PropostaSearch[prazo_responder]',
                    'value'=> empty($_REQUEST['PropostaSearch']['prazo_responder'])?'':$_REQUEST['PropostaSearch']['prazo_responder'],
                    'convertFormat'=>true,
                    'startAttribute' => 'from_date',
                    'endAttribute' => 'to_date',
                    'hideInput'=> true,
                    'pluginOptions'=>[
                        'locale'=>['format' => 'Y-m-d'],
                    ]
                ]).'</div>',
                'format' => 'raw',
                'value'=>function($data){
                    $data_hoje = date('Y-m-d');
                    $data_prazo = date('Y-m-d', strtotime($data->prazo_responder)); 
                    $dataFinal = (strtotime($data_prazo) - strtotime($data_hoje))/86400;
                    $contar = 'Faltam';
                    if($dataFinal < 0) {
                        $dataFinal = $dataFinal * -1;
                        $contar = "Passaram";
                    }

                    return date('d/m/Y',strtotime($data_prazo))." | $contar: ".$dataFinal.' dias';
                }
            ],
            'proprietario',
            [
                'attribute' => 'opcoes',
                'filter' => [ 'aceitas essas condições' => 'Aceitas essas condições', 'fazer contraproposta' => 'Fazer contraproposta', 'desistir da negociação' => 'Desistir da negociação', ],

            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width:13%'],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
