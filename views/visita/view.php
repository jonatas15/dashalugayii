<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Visita */

$this->title = $model->idvisita;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Visitas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visita-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->idvisita], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->idvisita], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idvisita',
            'usuario_id',
            'data_registro',
            'data_visita',
            'hora_visita',
            'id_corretor',
            'codigo_imovel',
            'nome_cliente',
            'imobiliaria_parceria',
            'observacoes:ntext',
        ],
    ]) ?>

</div>
