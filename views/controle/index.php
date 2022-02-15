<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\ImovelPermuta;
use app\models\Usuario;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ControleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Controles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="controle-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'acao_feita',
            [
                'attribute'=>'detalhes_acao',
                'format' => 'html',
                'value'=> function($data){
                    $atributos = explode(',',$data->detalhes_acao);
                    return '<strong>Dados da Permuta:</strong>'."<br>".
                    '<strong>Código: </strong>PIN-'.$atributos[1]."<br>".
                    '<strong>Dormitórios: </strong>'.$atributos[2]."<br>".
                    '<strong>Garagens: </strong>'.$atributos[3]."<br>".
                    '<strong>Área Privativa: </strong>'.number_format($atributos[4].'.00', 2, ',', '.').' m²'."<br>".
                    '<strong>Área Total: </strong>'.number_format($atributos[5].'.00', 2, ',', '.').' m²'."<br>".
                    '<strong>Bairros: </strong>'.$atributos[6]."<br>".
                    '<strong>Elevador: </strong>'.$atributos[7]."<br>".
                    '<strong>Sacada: </strong>'.$atributos[8]."<br>".
                    '<strong>Valor Máximo: </strong>'.'R$ '.number_format($atributos[9].'.00', 2, ',', '.')."<br>".
                    '<strong>Valor Mínimo: </strong>'.'R$ '.number_format($atributos[10].'.00', 2, ',', '.')."<br>".
                    '<strong>Tipo: </strong>'.$atributos[12]."<br>";
                },
            ],
            [
                'attribute'=>'permuta_id',
                'filter' => ArrayHelper::map(ImovelPermuta::find()->all(),'idimovel_permuta','codigo'),
                'value'=> function($data){
                    if ($data->permuta_id)
                    return '<a href="'.Yii::$app->homeUrl.'/imovelpermuta/view?id='.$data->permuta_id.'" target="blanck">'.'Imóvel de código Pin-'.$data->permuta->codigo.'</a>';
                    else
                    return 'registro excluído';
                },
                'format' => 'html',
                'filterInputOptions' => ['prompt' => 'Imóvel PIN', 'class' => 'form-control', 'id' => null]
            ],
            [
                'attribute'=>'cadastrador',
                'format'=>'html',
                'filter' => ArrayHelper::map(Usuario::find()->all(),'id','nome'),
                'value'=> function($data){
                    return '<center>'.Html::img(Yii::$app->homeUrl.'usuarios/'.$data->cadastrador0->foto, ['width' => '25']).
                    '<br><strong>'.$data->cadastrador0->nome.'</strong></center>';
                },
            ],
            [
                'attribute'=>'data_cadastro',
                'value'=> function($data){
                    if ($data->data_cadastro)
                    return date('d/m/Y H:i:s',strtotime($data->data_cadastro));
                    else
                        return 'não definido';
                },
            ],
            [
                'attribute'=>'atualizador',
                'format'=>'html',
                'filter' => ArrayHelper::map(Usuario::find()->all(),'id','nome'),
                'value'=> function($data){
                    return '<center>'.Html::img(Yii::$app->homeUrl.'usuarios/'.$data->atualizador0->foto, ['width' => '25']).
                    '<br><strong>'.$data->atualizador0->nome.'</strong></center>';
                },
            ],
            [
                'attribute'=>'data_alteracao',
                'value'=> function($data){
                    if ($data->data_alteracao)
                        return date('d/m/Y H:i:s',strtotime($data->data_alteracao));
                    else
                        return 'não definido';
                },
            ],
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
