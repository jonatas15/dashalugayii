<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Disparoswh */

$this->title = 'Create Disparoswh';
$this->params['breadcrumbs'][] = ['label' => 'Disparoswhs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disparoswh-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
