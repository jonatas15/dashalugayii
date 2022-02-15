<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SaPendencia */

$this->title = 'Update Sa Pendencia: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sa Pendencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sa-pendencia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
