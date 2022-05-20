<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sloavisos */

$this->title = 'Update Sloavisos: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sloavisos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sloavisos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
