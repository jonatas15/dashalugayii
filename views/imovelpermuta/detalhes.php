<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
// use app\models\ImovelPermuta;
//===========================================================================================================================


//===========================================================================================================================
?>
<div class="col-md-12">
    <label for="">
        <a href="https://www.cafeinteligencia.com.br/imovel/<?=$model->codigo ?>" class="btn btn-info" target="_blanck">
            <i class="glyphicon glyphicon-home" aria-hidden="true"></i>
            Imóvel no site
        </a>
    </label>
    <br>
</div>
<div class="col-md-6">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute'=>'codigo',
            'value'=> function($data){
                return 'PIN - '.$data->codigo;
            }
        ],
        [
            'attribute'=>'valor_maximo',
            'value'=> function($data){
                return 'R$ ' . number_format($data->valor_maximo, 2, ',', '.');
            }
        ],
        [
            'attribute'=>'valor_minimo',
            'value'=> function($data){
                return 'R$ ' . number_format($data->valor_minimo, 2, ',', '.');
            }
        ],
        [
            'attribute'=>'area_privativa',
            'value'=> function($data){
                return number_format($data->area_privativa, 2, ',', '.').' m²';
            }
        ],
        [
            'attribute'=>'area_total',
            'value'=> function($data){
                return number_format($data->area_total, 2, ',', '.').' m²';
            }
        ],
    ],
]); ?>
</div>
<div class="col-md-6">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'dormitorios',
        'garagens',
        [
            'attribute'=>'elevador',
            'value'=> function($data){
                return $data->elevador==1?'Sim':'Não';
            }
        ],
        [
            'attribute'=>'sacada',
            'value'=> function($data){
                return $data->sacada==1?'Sim':'Não';
            }
        ],
    ],
]); ?>
</div>
<div class="col-md-12">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'tipo:ntext',
        'bairros:ntext',
        'observacoes:html',
    ],
]); ?>
</div>