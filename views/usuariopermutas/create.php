<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Usuariopermutas */

$this->title = Yii::t('app', 'Create Usuariopermutas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usuariopermutas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuariopermutas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
