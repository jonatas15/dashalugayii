<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ImovelpermutaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Imovel Permutas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="imovel-permuta-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Imovel Permuta'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'idimovel_permuta',
            // 'codigo',
            [
                'header' => 'Código',
                'attribute' => 'codigo',
                // 'filter'=>ArrayHelper::map(Proprietario::find()->asArray()->all(), 'id', 'nome'),
                // 'value'=>'proprietario.nome',
            ],
            'dormitorios',
            'garagens',
            'area_privativa',
            'area_total',
            'bairros:ntext',
            'elevador',
            'sacada',
            'valor_maximo',
            'valor_minimo',
            // 'tipo_imovel',
            'tipo:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
