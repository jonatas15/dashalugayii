<?php

use yii\helpers\Html;
use yii\widgets\MaskedInput;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
// use kartik\widgets\DatePicker;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\SloProposta */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="col-md-12">
    <?php $form = ActiveForm::begin([
        'action'=> Yii::$app->homeUrl . 'pretendente/novotopico',
    ]); ?>
    <div class="col-md-4 hidden">
        <?= $form->field($model, 'checklist_id')->textInput(['value'=>$checklist_id]) ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'conteudo')->textArea() ?>
    </div>
    <div class="col-md-12">
        <?php //= $form->field($model, 'etapa')->textInput(['maxlength' => true]) 
            $arr_etapas = [
                '1ª Etapa' => '1ª Etapa',
                '2ª Etapa' => '2ª Etapa',
                '3ª Etapa' => '3ª Etapa',
            ];
        ?>
        <?= $form->field($model, 'etapa')->widget(Select2::classname(), [
              'data' => $arr_etapas,
              'language' => 'pt',
              'options' => [
                  'placeholder' => 'Selecione',
                  'multiple' => false
              ],
              'pluginOptions' => [
                'tags'=>false,
                'allowClear' => false,
                'maximumInputLength' => 100
              ],
          ]); ?>
    </div>
    


    
    <img src="" alt="">
    <div class="col-md-12">
        <div class="form-group float-right">
            <?= Html::submitButton('SALVAR  <i class="fas fa-angle-double-right"></i>', ['class' => 'btn btn-primary', 'style'=>'font-weight: bolder']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<div class="clearfix"></div>