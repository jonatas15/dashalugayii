<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Chtopico */

$this->title = 'Create Chtopico';
$this->params['breadcrumbs'][] = ['label' => 'Chtopicos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chtopico-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
