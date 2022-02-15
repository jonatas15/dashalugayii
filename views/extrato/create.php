<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Extrato */

$this->title = Yii::t('app', 'Novo Extrato');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Extratos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="extrato-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
