<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SloCliente */

$this->params['breadcrumbs'][] = ['label' => 'Clientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="slo-cliente-update">

    <h3>Atualizar Cliente <?=$model->nome?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
