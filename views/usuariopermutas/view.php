<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuariopermutas */

$this->title = $model->permuta;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usuariopermutas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuariopermutas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'permuta' => $model->permuta, 'usuario' => $model->usuario], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'permuta' => $model->permuta, 'usuario' => $model->usuario], [
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
            'permuta',
            'usuario',
            'observacoes:ntext',
        ],
    ]) ?>

</div>
