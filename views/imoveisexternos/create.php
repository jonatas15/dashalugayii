<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Imoveisexternos */

$this->title = Yii::t('app', 'Create Imoveisexternos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Imoveisexternos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="imoveisexternos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
