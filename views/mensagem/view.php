<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Mensagem */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mensagems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mensagem-view">

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
            'texto:ntext',
            'data',
            'ip',
            'slo_pretendente_id',
            'usuario_id',
            'imagem',
        ],
    ]) ?>

</div>
