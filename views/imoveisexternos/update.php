<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Imoveisexternos */

$this->title = 'Atualizar Imóvel Externo: ' . $model->codigo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Imoveisexternos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="imoveisexternos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
