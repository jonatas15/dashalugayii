<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Extrato */

$this->title = Yii::t('app', 'Atualizar {modelClass}: ', [
    'modelClass' => 'Extrato',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Extratos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Atualizar');
?>
<div class="extrato-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
