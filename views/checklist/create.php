<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Checklist */

$this->title = 'Create Checklist';
$this->params['breadcrumbs'][] = ['label' => 'Checklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="checklist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
