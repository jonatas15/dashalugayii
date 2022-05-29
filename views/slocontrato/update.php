<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Slocontrato */

$this->title = 'Update Slocontrato: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Slocontratos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'proposta_id' => $model->proposta_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="slocontrato-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
