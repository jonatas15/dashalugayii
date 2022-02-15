<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SaPendencia */

$this->title = 'Create Sa Pendencia';
$this->params['breadcrumbs'][] = ['label' => 'Sa Pendencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sa-pendencia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
