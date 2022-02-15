<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Registrocampanhas */

$this->title = 'Create Registrocampanhas';
$this->params['breadcrumbs'][] = ['label' => 'Registrocampanhas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registrocampanhas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
