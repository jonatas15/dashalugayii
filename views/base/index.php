<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Imóveis');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Novo Imóvel'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'codigo',
            'nome',
            [
                'attribute'=>'valor',
                // 'filter'=>ArrayHelper::map(Locatario::find()->asArray()->all(), 'id', 'nome'),
                'value'=> function($data){
                    return 'R$ ' . number_format($data->valor, 2, ',', '.');
                }
            ],
            'logradouro',
            // 'numero_apartamento',
            // 'numero_box',
            // 'proprietario_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
<?php

// $json_condominios = get_content('http://www.jetimob.com/services/tZuuHuri8Q3ohAf7cvmMm8hTmWrXKJoEdes8ViSi/condominios/',864000);

// $imoveis = json_decode($json_imoveis);
// $i = 1;
// foreach ($imoveis as $e):
//     // if ($e->aceita_permuta) {
//     //     echo $e->codigo;
//     //     echo '<br>';
//     // }
//     $pos = strripos($e->observacoes, 'Permuta');
//     if ($pos === false) {
        
//     } else {
//         echo $e->codigo;
//         echo ' | ';
//         $i++;
//     }
// endforeach;
// echo '<hr>';
// echo 'Imóveis que aceitam permuta: '.$i;
// echo '<pre>';
// print_r($imoveis);
// echo '</pre>';