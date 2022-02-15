<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TipoImovel */

$this->title = $model->idtipo_imovel;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tipo Imovels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-imovel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->idtipo_imovel], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->idtipo_imovel], [
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
            'idtipo_imovel',
            'tipo',
        ],
    ]) ?>

</div>
