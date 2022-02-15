<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ImovelPermuta */

$this->title = $model->idimovel_permuta;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Imovel Permutas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="imovel-permuta-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->idimovel_permuta], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->idimovel_permuta], [
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
            'idimovel_permuta',
            'codigo',
            'dormitorios',
            'garagens',
            'area_privativa',
            'area_total',
            'bairros:ntext',
            'elevador',
            'sacada',
            'valor_maximo',
            'valor_minimo',
            'tipo_imovel',
            'tipo:ntext',
        ],
    ]) ?>

</div>
