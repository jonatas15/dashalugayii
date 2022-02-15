<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TipoImovel */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Tipo Imovel',
]) . $model->idtipo_imovel;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tipo Imovels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idtipo_imovel, 'url' => ['view', 'id' => $model->idtipo_imovel]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tipo-imovel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
