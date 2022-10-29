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
$url = Yii::$app->homeUrl.'jsons/props.json';
$url1 = Yii::$app->homeUrl.'jsons/props_copy.json';
$url2 = Yii::$app->basePath.'/web/jsons/props_copy.json';
 
// The widget
use kartik\select2\Select2; // or kartik\select2\Select2
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
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
        <?php  //= $form->field($model, 'nome_cliente')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">    
        <?= $form->field($model, 'tipovisitante')->dropDownList([ 'Corretor' => 'Corretor', 'Corretor externo' => 'Corretor externo', 'Cliente' => 'Cliente', ], ['prompt' => '']) ?>
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
    <div class="col-md-12">
        <?php
            $dataList = \app\models\VisitChaves::find()->all();
            $content = file_get_contents($url2);
            $json = json_decode($content, true);
            $instArray = ArrayHelper::map($json,'nome','nome');
            // echo '<pre>';
            // echo $url2;
            // // print_r($instArray);
            // echo '</pre>';
            echo $form->field($model, 'nome_cliente')->widget(Select2::classname(), [
                'data' => $instArray,
                'options' => [
                    'placeholder' => 'Selecione o proprietário ...'
                ],
                'pluginOptions' => [
                    // 'allowClear' => true,
                    'dropdownParent' => '#kartik-modal',
                    'minimumInputLength' => 3,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Erro...'; }"),
                    ]
                ],
                "pluginEvents" => [
                    "change" => 
                    // [
                    //     'ajax' => [
                    //         'url' => $url,
                    //         'dataType' => 'json',
                    //         'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                    //         'success' => new JsExpression('function(data) { console.log(data); }')
                    //     ],
                    // ]
                    "function() { 
                        $.ajax({
                            url: '".Yii::$app->homeUrl."/visitchaves/filtradados',
                            dataType: 'json',
                            data: {
                                nome: $(this).val()
                            }, 
                            success: function(result){
                                console.log(result);
                                console.log(result.codigo);
                                $('#visitchaves-codigo_imovel').val(result.codigo);
                                $('#visitchaves-num_disparo').val(result.telefones[0].telefone);
                            }
                        });
                    }",

                ]
            ]);
        ?>
    </div>
    <div class="col-md-6">    
        <?= $form->field($model, 'codigo_imovel')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">    
        <?= $form->field($model, 'num_disparo')->widget(MaskedInput::className(), [
            'mask' => '(99) 99999-9999',
            'clientOptions' => [
            ]
        ])->label("Número (Whatsapp)"); ?>
    </div>
    <div class="col-md-6 hidden">    
        <?= $form->field($model, 'feedbacks')->textarea(['rows' => 6]) ?>
    </div>
    <div class="col-md-6 hidden">    
        <?= $form->field($model, 'mensagem')->textarea(['rows' => 6]) ?>
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
