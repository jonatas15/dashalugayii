<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\bootstrap\Alert;

use app\models\Imobiliarias;
use app\models\Condominio;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ImoveisexternosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Imóveis Externos';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.img_imovel{
    cursor:zoom-in
}
</style>

<div class="imoveisexternos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <?= $this->render('_search', [
        'model' => $searchModel,
        // 'valoresdevenda'=>$model->valoresdevenda
    ]); ?>
    </p>
    
        <hr>
       <div class="clearfix"></div>
        <?php 
        	echo Alert::widget([
			    'options' => [
			        'class' => 'alert-info',
			    ],
			    'body' => 'Última Atualização: 11/08/2019, 18:30',
			]);
        ?>
        <hr>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'id',
                'header'=>'Imagem',
                'format' => 'html',
                'value'=>function($data){
                    if ($data->url_imagem != 'imagem não encontrada'){
                        return '<img src="'.$data->url_imagem.'" width="150" class="img_imovel" title="'.$data->imobiliarias->nome.': '.$data->codigo.'" />';

                    }else{
                        return 'Sem imagem';
                    }
                }
            ],
            // 'id',
            // 'imobiliarias_id',
            [
                'attribute' => 'imobiliarias_id',
                // 'format' => 'url',
                'filter' => '',//ArrayHelper::map(Imobiliarias::find()->asArray()->all(), 'id','nome'),
                'value' => function($data){
                    return $data->imobiliarias->nome;
                }
            ],
            // 'url_imovel:url',
            [
                'attribute' => 'codigo',
                'format' => 'html',
                'filter' => '',
                'value' => function($data){
                    $retorno = '<a href="'.$data->url_imovel.'" target="_blank" 
                    alt="'.$data->url_imovel.'" 
                    title="'.$data->url_imovel.'" >'.$data->codigo.'</a>';
                    $retorno .= '<ul>';
                    $retorno .= '<li><strong>'.$data->tipo.' - '.$data->contrato.'</strong></li>';
                    $retorno .= '<li><strong>Bairro:</strong> '.$data->endereco_bairro.'</li>';
                    $retorno .= ($data->banheiros != 0) ? '<li><strong>Banheiros:</strong> '.$data->banheiros.'</li>' : '' ;
                    $retorno .= ($data->condominio != 'Sem condomínio') ? '<li><strong>Condomínio:</strong> '.$data->condominio.'</li>' : '' ;
                    $retorno .= (!empty($data->comodidades)) ? '<li><strong>Comodidades:</strong> '.$data->comodidades.'</li>' : '' ;
                    $retorno .= '</ul>';
                    return $retorno;
                }
            ],
            // 'codigo',
            
            // 'tipo',
            // [
            //     'attribute'=>'tipo'
            // ],
            // [
            //     'attribute'=>'contrato',
            //     'filter'=>['Venda'=>'Venda','Locação'=>'Locação','Venda/Locação'=>'Venda/Locação']
            // ],
            // 'valor_venda',
            [
                'attribute' => 'valor_venda',
                // 'format' => 'money',
                'value'=>function($data){
                    if ($data->valor_venda > 0){
                        return 'R$ '.number_format($data->valor_venda, 2, ',', '.');
                    }else{
                        return 'Consulte';
                    }
                }
            ],
            [
                'attribute' => 'dormitorios',
                'filter' => ['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10']
            ],
            [
                'attribute' => 'garagens',
                'filter' => ['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10']
            ],
            [
                'attribute' => 'area_privativa',
                // 'format' => 'money',
                'value'=>function($data){
                    $medida = 'm²';
                    $ha = strpos($data->url_imovel, 'hectare');
                    if($ha or $data->area_privativa < 10){
                        $medida = 'ha';
                    }
                    if($data->area_privativa > 10000){
                        $data->area_privativa = $data->area_privativa/10000;
                        $medida = 'ha';
                    }
                    if ($data->area_privativa > 0){
                        return number_format($data->area_privativa, 2, ',', '.')." $medida";
                    }else{
                        return 'Consulte';
                    }
                }
            ],
            [
                'attribute'=>'id',
                'header'=>'<span class="glyphicon glyphicon-cog"></span>',
                'format'=>'raw',
                'value'=> function($data){
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['view', 'id' => $data->id], [
                    'class' => 'btn btn-success',
                    'style' => 'margin:1px',
                    ]).'<br>'.Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $data->id], [
                    'class' => 'btn btn-danger',
                    'style' => 'margin:1px',
                    'data' => [
                        'confirm' => 'Deseja realmente excluir esse registro?',
                        'method' => 'post',
                    ]]);
                }
            ]
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<?php
$this->registerJs("$(function() {
    $('.img_imovel').click(function(e) {
      e.preventDefault();
      $('#modal').modal('show').find('.modal-body').html('<img src=\"'+$(this).attr('src')+'\" style=\"width:100%\">');
      $('#modal').modal('show').find('.modal-header h2').html($(this).attr('title'));
    });
 });");
?>
<?php
    yii\bootstrap\Modal::begin(['id' =>'modal','header' => '<h2>Imagem Principal</h2>','options'=>['style'=>'z-index:100000']]);
    yii\bootstrap\Modal::end();
?>
<script type='text/javascript'>
    function addCommas(nStr) {
            nStr += '';
            var x = nStr.split('.');
            var x1 = x[0];
            var x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + '.' + '$2');
            }
            return x1 + x2;
        }
</script>
