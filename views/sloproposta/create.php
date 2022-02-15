<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SloProposta */

$this->title = 'Create Slo Proposta';
$this->params['breadcrumbs'][] = ['label' => 'Slo Propostas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slo-proposta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
