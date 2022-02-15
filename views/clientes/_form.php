<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Clientes */
/* @var $form yii\widgets\ActiveForm */
$itens = [];
$tamanho = '4';
if ($modo == 'create') {
    $itens = [
        'action' => Yii::$app->homeUrl.'/clientes/create'
    ];
    $tamanho = '12';
}
?>

<div class="clientes-form col-md-12">
    <hr>
    <?php $form = ActiveForm::begin($itens); ?>
    <div class="col-md-<?=$tamanho?>">
    <?= $form->field($model, 'setor')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-<?=$tamanho?>">
    <?= $form->field($model, 'cargo')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-<?=$tamanho?>">
    <?= $form->field($model, 'cpf')->widget(MaskedInput::className(), [
        'mask'  => '999.999.999-99',
        'options'=>[
            'inputmode'=>"numeric",
            'class'=>"form-control",
        ]
    ]) ?>
    </div>
    <div class="col-md-<?=$tamanho?>">
    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-<?=$tamanho?>">
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-<?=$tamanho?>">
    <?= $form->field($model, 'proventos')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-<?=$tamanho?>">
    <?= $form->field($model, 'fone1')->widget(MaskedInput::className(), [
        'mask'  => '(99) 99999-9999',
        'options'=>[
            'inputmode'=>"numeric",
            'class'=>"form-control",
        ]
    ]) ?>
    </div>
    <div class="col-md-<?=$tamanho?>">
    <?= $form->field($model, 'fone2')->widget(MaskedInput::className(), [
        'mask'  => '(99) 99999-9999',
        'options'=>[
            'inputmode'=>"numeric",
            'class'=>"form-control",
        ]
    ]) ?>
    </div>
    <div class="col-md-<?=$tamanho?> hidden">
    <?= $form->field($model, 'clientescol')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-<?=$tamanho?> hidden">
    <?= $form->field($model, 'corretor')->textInput() ?>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Salvar Cliente', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<div class="clearfix"></div>
