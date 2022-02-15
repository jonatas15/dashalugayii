<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Base */

$this->title = $model->codigo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-view">

    <h1>PIN - <?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Editar'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Excluir'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="col-md-4">
        
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'codigo',
            'nome',
            'valor',
            'logradouro',
            'numero_apartamento',
            'numero_box',
            // 'proprietario_id',
        ],
    ]) ?>
    </div>

</div>
