<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SloPretendente */

$this->title = 'Update Slo Pretendente: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Slo Pretendentes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="slo-pretendente-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
