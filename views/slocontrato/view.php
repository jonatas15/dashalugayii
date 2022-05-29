<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Slocontrato */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Slocontratos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="slocontrato-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'proposta_id' => $model->proposta_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'proposta_id' => $model->proposta_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'proposta_id',
            'id_imovel_imo',
            'id_tipo_con',
            'dt_inicio_con',
            'dt_fim_con',
            'vl_aluguel_con',
            'tx_adm_con',
            'fl_txadmvalorfixo_con',
            'nm_diavencimento_con',
            'tx_locacao_con',
            'id_indicereajuste_con',
            'nm_mesreajuste_con',
            'dt_ultimoreajuste_con',
            'fl_mesfechado_con',
            'id_contabanco_cb',
            'fl_diafixorepasse_con',
            'nm_diarepasse_con',
            'fl_mesvencido_con',
            'fl_dimob_con:ntext',
            'id_filial_fil',
            'st_observacao_con',
            'nm_repassegarantido_con',
            'fl_garantia_con',
            'fl_seguroincendio_con',
            'fl_endcobranca_con',
        ],
    ]) ?>

</div>
