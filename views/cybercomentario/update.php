<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CyberComentario */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Cyber Comentario',
]) . $model->idcyber_comentario;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cyber Comentarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idcyber_comentario, 'url' => ['view', 'id' => $model->idcyber_comentario]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="cyber-comentario-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
