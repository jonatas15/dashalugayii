<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\ImovelPermuta as Permuta;

/* @var $this yii\web\View */
/* @var $model app\models\ImovelPermuta */

$this->title = 'Permuta do imóvel PIN - '.$model->codigo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Imovel Permutas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

/* Imóveis Jetimob - JSON */
$json_imoveis = $this->context->get_content('http://www.jetimob.com/services/tZuuHuri8Q3ohAf7cvmMm8hTmWrXKJoEdes8ViSi/imoveis/',864000);

$imoveis = json_decode($json_imoveis);
$j = 0;
$codigos = array();
$bairros_imoveis = array();
$tipos_imoveis = array();
$imoveis_compativeis = array();
$imagem_local = array();
$imagem_local2 = '';

$tem_elevador = 0;
$tem_sacada = 0;
$bairros_permuta = '';
$bairros_permuta = explode(';',$model->bairros);
$tipos_permuta = explode(';',$model->tipo);

foreach ($imoveis as $e):
    $pos = strripos($e->observacoes, 'Negociável');
    if (!$pos === false) {    
        $pos_elevador = strripos($e->imovel_comodidades, 'Elevador');
        $pos_sacada = strripos($e->imovel_comodidades, 'Sacada');

        $tem_elevador = 0;
        $tem_sacada = 0;

        if (!$pos_elevador === false and $model->elevador == 1) {
            $tem_elevador = 1;
        }
        if (!$pos_sacada === false and $model->sacada == 1) {
            $tem_sacada = 1;
        }

        if(
            (in_array($e->endereco_bairro, $bairros_permuta) or empty($bairros_permuta[0]))
            and (
                in_array($e->tipo, $tipos_permuta)
                or in_array($e->subtipo, $tipos_permuta)
            )
            and $e->valor_venda <= $model->valor_maximo+$model->valor_maximo*0.2
            and $e->valor_venda >= $model->valor_minimo-$model->valor_minimo*0.2
            and (
                $e->area_total >= $model->area_total
                or $e->area_privativa >= $model->area_privativa
            )
            and $e->dormitorios >= $model->dormitorios
            and $e->garagens >= $model->garagens
            and $tem_elevador == $model->elevador
            and $tem_sacada == $model->sacada
        ) {
            $codigos[$e->codigo]['codigo'] = $e->codigo;
            $codigos[$e->codigo]['bairro'] = $e->endereco_bairro;
            $codigos[$e->codigo]['tipo'] = $e->subtipo != ''?$e->subtipo:$e->tipo;
            $codigos[$e->codigo]['valor'] = $e->valor_venda;
            $codigos[$e->codigo]['area_total'] = number_format($e->area_total, 2, ',', '.').' m²';
            $codigos[$e->codigo]['area_privativa'] = number_format($e->area_privativa, 2, ',', '.').' m²';
            $codigos[$e->codigo]['dormitorios'] = $e->dormitorios;
            $codigos[$e->codigo]['garagens'] = $e->garagens;
            $codigos[$e->codigo]['comididades'] = $e->imovel_comodidades;
            $imagens = (array)$e->imagens[0];
            $codigos[$e->codigo]['imagem'] = $imagens['link_thumb'];
            $codigos[$e->codigo]['elevador'] = $pos_elevador;
            $codigos[$e->codigo]['sacada'] = $pos_sacada;
            $j++;
        }
        if ($e->codigo == $model->codigo) {
            $imagem_local = (array)$e->imagens[0];
            $imagem_local2 = $imagem_local['link_thumb'];
        }
    }
endforeach;

// echo '<pre>';
// print_r($codigos);
// echo '</pre>';
// echo '<br>';
// echo 'itens: '.$j;

?>
<?= Html::a(Yii::t('app', '<span class="glyphicon glyphicon-search"></span> Voltar às Permutas'), ['index'], [
    'class' => 'btn btn-primary',
    'style'=>'float:right'
]) ?>

<div class="imovel-permuta-view">

    <h2><?= Html::encode($this->title) ?>
            <h4>
        <a href="https://www.cafeinteligencia.com.br/imovel/<?=$model->codigo ?>" class="" target="_blanck">
            Ver Imóvel no Site
            <i class="glyphicon glyphicon-home" aria-hidden="true"></i>
        </a>
            </h4>
    </h2>
    
</div>
<div class="col-md-2">
<?php if($imagem_local2!=''): ?>
<img src="<?=$imagem_local2?>" style="width:100%;height:auto;padding:2%;border-radius:112px" />
<?php else: ?>
<img src="https://cafeinteligencia27-mrwru33hbcqg1251.netdna-ssl.com/assets/images/logo_site.png" style="width:100%;height:auto;padding:2%;" />
<?php endif; ?>
</div>
<div class="col-md-5">
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        // [
        //     'attribute'=>'codigo',
        //     'value'=> function($data){
        //         return 'PIN - '.$data->codigo;
        //     }
        // ],
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
<div class="col-md-5">
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
<div class="col-md-12">
    <p>
        <?= Html::a(Yii::t('app', 'Atualizar'), ['update', 'id' => $model->idimovel_permuta], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Excluir'), ['delete', 'id' => $model->idimovel_permuta], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        
    </p>
</div>
<div class="col-md-12">
    <?php
    
    // Para os bairros
    $bairros_registro = $model->bairros;
    $bairros = explode(';',$bairros_registro);
    $ors = [
        'or',
        ['like', 'bairros', $model->bairros],
    ];
    if(!empty($bairros_registro))
    foreach ($bairros as $b):
        array_push($ors,['like', 'bairros', $b]);
    endforeach;
    // Para os tipos de imóveis
    $tipo_registro = $model->tipo;
    $tipos = explode(';',$tipo_registro);
    $ors2 = [
        'or',
        ['like', 'tipo', $model->tipo],
    ];
    if(!empty($tipo_registro))
    foreach ($tipos as $t):
        array_push($ors2,['like', 'tipo', $t]);
    endforeach;

    $permutas = Permuta::find()->distinct()->where([
        'elevador' => $model->elevador,
        'sacada' => $model->sacada,
    ])->andFilterWhere($ors)->andFilterWhere($ors2)
    ->andFilterWhere(['<>', 'codigo',  $model->codigo])
    ->andFilterWhere(['>=', 'valor_minimo',  $model->valor_minimo])
    ->andFilterWhere(['<=', 'valor_maximo',  $model->valor_maximo])
    ->andFilterWhere(['>=', 'area_total',    $model->area_total])
    ->andFilterWhere(['>=', 'area_privativa',$model->area_privativa])
    ->andFilterWhere(['>=', 'garagens',      $model->garagens])
    ->andFilterWhere(['>=', 'dormitorios',   $model->dormitorios])->all();
    ?>
    <?php if (count($permutas) > 0): ?>
    <h3>Permutas compatíveis (<?=count($permutas)?> ítens)</h3>
    <br>
    <?php
    
    
    foreach ($permutas as $row) {
        echo '<div class="col-md-3">';
        echo '<a href="'.Yii::$app->homeUrl.'imovelpermuta/view?id='.$row['idimovel_permuta'].'" target="blanck" class="btn btn-info" style="margin-bottom:4%;width:100%">';
        echo '<div class="col-md-6">';
        // echo '<img src="'.$row['imagem'].'" style="width:100%;height:auto;padding:2%;border-radius:112px" />';
        echo '</div>';
        echo '<div class="col-md-12">';
        echo 'Código: PIN - '.$row['codigo'].'<br>';
        echo 'Tipo: '.substr($row['tipo'],0,25).'<br>';
        
        echo 'Valor: '.'R$ ' . number_format($row['valor_maximo'], 2, ',', '.').'<br>';
        echo '<label alt="dormitórios" title="dormitórios" style="padding:3px"><span class="glyphicon glyphicon-bed"></span> '.$row['dormitorios'].'</label>';
        echo '<label alt="garagens" title="garagens" style="padding:3px"><span class="glyphicon glyphicon-th"></span> '.$row['garagens'].'</label>';
        if ($row['elevador'] != 0) {
            echo '<label alt="elevador" title="elevador" style="padding:3px"><span class="glyphicon glyphicon-collapse-up"></span></label>';
        }
        if ($row['sacada'] != 0) {
            echo '<label alt="sacada" title="sacada" style="padding:3px"><span class="glyphicon glyphicon-modal-window"></span></label>';
        }
        echo '</div>';
         echo '<div class="col-md-12" style="">';
        echo '<label alt="área privativa" title="área privativa" style="">
            <span class="glyphicon glyphicon-fullscreen"></span> Área Privativa: '.number_format($row['area_privativa'], 2, ',', '.').' m²</label>';
        echo '<br>';
        echo '<label alt="área total" title="área total" style="">
            <span class="glyphicon glyphicon-fullscreen"></span> Área Total: '.number_format($row['area_total'], 2, ',', '.').' m²</label>';
        echo '</div>';
        echo '<div class="col-md-12">';
        // echo 'Bairro: '.$row['bairros'].'<br>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
    }

    ?>
    <br>
<?php endif; ?>
</div>
<?php if ($j > 0): ?>
<div class="col-md-12">
    <h3>Imóveis negociáveis compatíveis (Jetimob) (<?=$j?> ítens)</h3>
    <br>
    <?php

    foreach ($codigos as $row) {
        echo '<div class="col-md-4">';
        echo '<a href="https://cafeinteligencia.com.br/imovel/'.$row['codigo'].'" target="blanck" class="btn btn-info" style="margin-bottom:4%">';
        echo '<div class="col-md-6">';
        echo '<img src="'.$row['imagem'].'" style="width:100%;height:auto;padding:2%;border-radius:112px" />';
        echo '</div>';
        echo '<div class="col-md-6">';
        echo 'Código: PIN - '.$row['codigo'].'<br>';
        echo 'Tipo: '.$row['tipo'].'<br>';
        
        echo 'Valor: '.'R$ ' . number_format($row['valor'], 2, ',', '.').'<br>';
        echo '<label alt="dormitórios" title="dormitórios" style="padding:3px"><span class="glyphicon glyphicon-bed"></span> '.$row['dormitorios'].'</label>';
        echo '<label alt="garagens" title="garagens" style="padding:3px"><span class="glyphicon glyphicon-th"></span> '.$row['garagens'].'</label>';
        if ($row['elevador'] != 0) {
            echo '<label alt="elevador" title="elevador" style="padding:3px"><span class="glyphicon glyphicon-collapse-up"></span></label>';
        }
        if ($row['sacada'] != 0) {
            echo '<label alt="sacada" title="sacada" style="padding:3px"><span class="glyphicon glyphicon-modal-window"></span></label>';
        }
        echo '<br>';
        echo '</div>';
        echo '<div class="col-md-12" style="text-align:left">';
        echo '<br>';
        echo '<label><span class="glyphicon glyphicon-fullscreen"></span> Área: </label>';
        echo '<label alt="área privativa" title="área privativa" style="padding:3px">Privativa: '.$row['area_privativa'].'</label>';
        echo '|';
        echo '<label alt="área total" title="área total" style="padding:3px">Total: '.$row['area_total'].'</label>';
        echo '</div>';
        echo '<div class="col-md-12" style="text-align:left">';
        echo '<label>Bairro: '.$row['bairro'].'</label><br>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
    }
    ?>
    <br>
    
</div>
<?php endif; ?>
</div>