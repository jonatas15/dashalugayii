<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
    ],
    'action' => Yii::$app->homeUrl.'clientes/upload'
]);
echo $form->field($model, 'imageFile')->fileInput()->label('Escolher Arquivo');
echo Html::submitButton('Subir Aquivo', ['class' => 'btn btn-success']);
$form->end();