<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ImovelPermuta */

$this->title = Yii::t('app', 'Atualizar {modelClass}: ', [
    'modelClass' => 'Imovel Permuta',
]) . $model->codigo;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Imovel Permutas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->codigo, 'url' => ['view', 'id' => $model->idimovel_permuta]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="imovel-permuta-update">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
