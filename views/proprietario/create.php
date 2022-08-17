<?php

// use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Proprietario */


use yii\bootstrap\Modal;
use yii\helpers\Html;
Modal::begin([
    'header' => '',
    'size' => 'modal-lg',
    'toggleButton' => [
        'label' => "Cadastrar novo Proprietário",
        'class' => "btn btn-primary"
    ],
    'options' => [
        'tabindex' => true
    ],
]);
?>
    <?= $this->render('_form', [
        'model' => $model,
        'codigo' => $codigo
    ]) ?>

<?php Modal::end(); ?>