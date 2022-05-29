<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SlocontratoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Slocontratos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slocontrato-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Slocontrato', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'proposta_id',
            'id_imovel_imo',
            'id_tipo_con',
            'dt_inicio_con',
            //'dt_fim_con',
            //'vl_aluguel_con',
            //'tx_adm_con',
            //'fl_txadmvalorfixo_con',
            //'nm_diavencimento_con',
            //'tx_locacao_con',
            //'id_indicereajuste_con',
            //'nm_mesreajuste_con',
            //'dt_ultimoreajuste_con',
            //'fl_mesfechado_con',
            //'id_contabanco_cb',
            //'fl_diafixorepasse_con',
            //'nm_diarepasse_con',
            //'fl_mesvencido_con',
            //'fl_dimob_con:ntext',
            //'id_filial_fil',
            //'st_observacao_con',
            //'nm_repassegarantido_con',
            //'fl_garantia_con',
            //'fl_seguroincendio_con',
            //'fl_endcobranca_con',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
