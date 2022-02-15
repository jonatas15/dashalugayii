<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Base */

$this->title = Yii::t('app', 'Atualizar Imóvel: ', [
    'modelClass' => 'Base',
]) .'PIN - '. $model->codigo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Imóveis'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'PIN - '.$model->codigo, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Atualizar');
?>
<div class="base-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
