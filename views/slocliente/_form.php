<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\SloCliente */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slo-cliente-form col-md-12">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-6">
        <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
        <?php //= $form->field($model, 'data_nascimento')->textInput() ?>
        <div class="form-group field-visita-id_corretor has-success">
          <?php //= $form->field($model, 'data_visita')->textInput()
            echo '<label class="control-label">Aniversário</label>';
            echo DatePicker::widget([
              'language'=>'pt',
              'name' => 'SloCliente[data_nascimento]',
              'type' => DatePicker::TYPE_COMPONENT_PREPEND,
              'value' => $model->isNewRecord ? '':date('d-m-Y', strtotime($model->data_nascimento)),
              'pluginOptions' => [
                  'autoclose'=>true,
                  'format' => 'dd-mm-yyyy'
              ]
            ]);
          ?>
          <div class="help-block"></div>
        </div>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'observacoes')->textarea(['rows' => 6]) ?>
    </div>
    <div style="display: none;">
        <?= $form->field($model, 'slo_clientecol')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'usuario_id')->textInput(['value' => Yii::$app->user->identity->id]) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Cadastrar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'float: right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
