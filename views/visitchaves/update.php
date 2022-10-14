<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Visitchaves */

$this->title = 'Update Visitchaves: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Visitchaves', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="visitchaves-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
