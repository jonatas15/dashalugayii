<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Corretor */

$this->title = 'Novo Corretor';
$this->params['breadcrumbs'][] = ['label' => 'Corretores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="corretor-create">

    <h3><img src="<?=Yii::$app->homeUrl.'icones/corretor_b.png'?>" alt="" height="50" /><?= Html::encode($this->title) ?></h3>
    <hr>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
