<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CyberComentario */

$this->title = $model->idcyber_comentario;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cyber Comentarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cyber-comentario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->idcyber_comentario], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->idcyber_comentario], [
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
            'idcyber_comentario',
            'usuario_id',
            'cyber_topico_idtopico',
            'cyber_idcyber',
            'comentario:ntext',
            'datetime',
            'imagem',
            'documento',
        ],
    ]) ?>

</div>
