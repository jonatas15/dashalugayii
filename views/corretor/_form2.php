<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\widgets\ColorInput;
use yii\widgets\MaskedInput;
/* @var $this yii\web\View */
/* @var $model app\models\Corretor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="corretor-form col-md-12">

    <?php $form = ActiveForm::begin([
      'action' => ['create']
    ]); ?>
    <div class="col-md-6">
      <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
      <?= $form->field($model, 'telefone')->widget(MaskedInput::className(), [
        'mask'  => '(99) 99999-9999',
        'options'=>[
            'inputmode'=>"numeric",
            'class'=>"form-control",
        ]
      ]) ?>
      <?php //= $form->field($model, 'foto')->textInput(['maxlength' => true]) ?>
      <?php //= $form->field($model, 'cor')->textInput(['maxlength' => true])
      echo $form->field($model, 'cor')->widget(ColorInput::classname(), [
        'options' => ['placeholder' => 'Select color ...'],
      ]);
      ?>
    </div>
    <div class="col-md-6">
      <?= $form->field($model, 'observacoes')->textarea(['rows' => 6]) ?>
    </div>
    <div class="form-group col-md-12">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Salvar') : Yii::t('app', 'Atualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style'=>'float: right']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
  </div>
  <div class="clearfix"></div>
