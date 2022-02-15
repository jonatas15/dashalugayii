<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SaAlerta */

$this->title = 'Create Sa Alerta';
$this->params['breadcrumbs'][] = ['label' => 'Sa Alertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sa-alerta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
