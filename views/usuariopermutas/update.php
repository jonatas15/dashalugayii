<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Usuariopermutas */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Usuariopermutas',
]) . $model->permuta;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usuariopermutas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->permuta, 'url' => ['view', 'permuta' => $model->permuta, 'usuario' => $model->usuario]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="usuariopermutas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
