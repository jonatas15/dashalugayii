<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Visitchaves */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Visitchaves', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="visitchaves-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'usuario_id',
            'nome',
            'nome_cliente',
            'tipovisitante',
            'codigo_imovel',
            'dthr_retirada',
            'dthr_entrega',
            'data_visita',
            'hora_visita',
            'feedbacks:ntext',
            'mensagem:ntext',
            'num_disparo',
            'convertido_venda',
        ],
    ]) ?>

</div>
