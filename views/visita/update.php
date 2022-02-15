<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Visita */

$this->title = 'Editar Visita Id: ' . $model->idvisita;
$this->params['breadcrumbs'][] = ['label' => 'Visitas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="visita-update">

    <h3><img src="<?=Yii::$app->homeUrl.'icones/visita.png'?>" alt="" height="50" /><?= Html::encode($this->title) ?></h3>
    <hr>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
