<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Condominio */

$this->title = Yii::t('app', 'Create Condominio');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Condominios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="condominio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
