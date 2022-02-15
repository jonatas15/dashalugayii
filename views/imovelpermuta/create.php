<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ImovelPermuta */

$this->title = Yii::t('app', 'Nova Permuta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Imovel Permutas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="imovel-permuta-create">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
