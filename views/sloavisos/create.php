<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sloavisos */

$this->title = 'Create Sloavisos';
$this->params['breadcrumbs'][] = ['label' => 'Sloavisos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sloavisos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
