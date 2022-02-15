<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Base */

$this->title = Yii::t('app', 'Nova Base');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
