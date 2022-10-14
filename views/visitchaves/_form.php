<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use kartik\widgets\DateTimePicker;
// use kartik\widgets\DatePicker;
// use kartik\widgets\TimePicker;

use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Visitchaves */
/* @var $form yii\widgets\ActiveForm */
$datahora_atual = date("Y-m-d H:i:s");
?>
<style>
    .control-label {
        font-size: 14px !important;
        line-height: 1 !important;
        margin-bottom: 15px !important;
        position: relative !important;
        top: 0 !important;
    }
    .bmd-label-static {
        line-height: 1 !important;
        position: relative !important;
        top: 0 !important;
    }
    select.form-control {
        height: calc(3.4rem + 2px) !important;
    }
    /* .col-md-6 {
        border: 1px solid red !important;
        margin: -1px !important;
    } */
    /* .col-md-8, .col-md-4 {
        padding: 3% !important;
    } */
</style>
<div class="visitchaves-form col-md-12">

    <?php $form = ActiveForm::begin([
        'action' => ['create'],
        'options' => [
        ]
    ]); ?>
    <div class="col-md-6 hidden">    
        <?= $form->field($model, 'usuario_id')->textInput([
            'value' => Yii::$app->user->identity->id,
            'maxlength' => true
        ]) ?>
    </div>    
    <div class="col-md-6">    
        <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">    
        <?= $form->field($model, 'nome_cliente')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">    
        <?= $form->field($model, 'tipovisitante')->dropDownList([ 'Corretor' => 'Corretor', 'Corretor externo' => 'Corretor externo', 'Cliente' => 'Cliente', ], ['prompt' => '']) ?>
    </div>
    <div class="col-md-6">    
        <?= $form->field($model, 'codigo_imovel')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6 hidden">    
        <?= 
            $form->field($model, 'dthr_retirada')->textInput([
                'value' => $datahora_atual
            ]);
            // $form->field($model, 'dthr_retirada')->widget(DateTimePicker::classname(), [
            //     'options' => [
            //         'placeholder' => 'Data e Hora da retirada...'
            //     ],
            //     'pluginOptions' => [
            //         'autoclose' => true,
            //         'format' => 'dd/mm/yyyy hh:ii:ss',
            //         'language' => 'fr',
            //     ]
            // ]);
        ?>
    </div>
    <div class="col-md-6 hidden">    
        <?= $form->field($model, 'dthr_entrega')->textInput() ?>
    </div>
    <div class="col-md-6">    
        <?= 
            // $form->field($model, 'data_visita')->textInput() 
            // $form->field($model, 'data_visita')->widget(DatePicker::classname(), [
            //     'options' => [
            //         'placeholder' => 'Data e Hora da retirada...'
            //     ],
            //     'pluginOptions' => [
            //         'autoclose' => true,
            //         'format' => 'dd/mm/yyyy',
            //         'language' => 'pt_BR',
            //     ]
            // ]);
            $form->field($model, 'data_visita')->widget(MaskedInput::className(), [
                'clientOptions' => ['alias' =>  'date']
            ]) ;
        ?>
    </div>
    <div class="col-md-6">    
        <?= //$form->field($model, 'hora_visita')->textInput() 
            // $form->field($model, 'hora_visita')->widget(TimePicker::classname(), [
                //     'options' => [
                    //         'placeholder' => 'Data e Hora da retirada...'
                    //     ],
                    //     'pluginOptions' => [
                        //         'autoclose' => true,
                        //         'format' => 'hh:ii',
                        //         'language' => 'pt_BR',
                        //         'showSeconds' => false,
                        //         'showMeridian' => false,
                        //     ]
                        // ]);
            $form->field($model, 'hora_visita')->widget(MaskedInput::className(), [
                'mask' => '99:99',
                'clientOptions' => [
                ]
            ]);
        ?>
    </div>
    <div class="col-md-6 hidden">    
        <?= $form->field($model, 'feedbacks')->textarea(['rows' => 6]) ?>
    </div>
    <div class="col-md-6 hidden">    
        <?= $form->field($model, 'mensagem')->textarea(['rows' => 6]) ?>
    </div>
    <div class="col-md-6 hidden">    
        <?= $form->field($model, 'num_disparo')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6 hidden">    
        <?= $form->field($model, 'convertido_venda')->textInput() ?>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
