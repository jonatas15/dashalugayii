<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use app\models\TipoImovel;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\SwitchInput;
use kartik\number\NumberControl; //=====================================
$dispOptions = ['class' => 'form-control kv-monospace'];
$saveOptions = [
    'class' => 'kv-saved',
    'readonly' => true, 
    'tabindex' => 1000
];
$saveCont = ['class' => 'kv-saved-cont'];
// ======================================================================

/* @var $this yii\web\View */
/* @var $model app\models\ImovelpermutaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="imovel-permuta-search">
    <h3>Pesquisa</h3>
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php //= $form->field($model, 'idimovel_permuta') ?>

    <?php //= $form->field($model, 'codigo') ?>
    <?php 
    echo $form->field($model, 'codigo',['addon' => ['prepend' => ['content'=>'PIN']]])->widget(Select2::classname(), [
        'data' => $codigos,
        // 'value' => ['red', 'green'],
        'language' => 'pt',
        'options' => [
            'placeholder' => 'Selecione o Código do imóvel',
            // 'multiple' => true
        ],
        'pluginOptions' => [
            'tags' => true,
            'maximumInputLength' => 10,
            'allowClear' => true
        ],
    ]);
    ?>

    <?php
            
        $campos_tipo = ['Apartamento'=>'Apartamento','Casa'=>'Casa','Kitnet'=>'Kitnet','Chácara'=>'Chácara'];
        // $model->tipo = explode(';',$model->tipo);

        echo $form->field($model, 'tipo')->widget(Select2::classname(), [
            'data' => $tipos,
            // 'value' => ['red', 'green'],
            'language' => 'pt',
            'options' => [
                'placeholder' => 'Selecione o Tipo',
                'multiple' => true
            ],
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10
            ],
        ]);
    ?>
    <div class="col-md-6" style="padding:1px">
    <?= $form->field($model, 'dormitorios')->textInput(['type' => 'number','step'=>"1",'min'=>"0"]) ?>
    </div>
    <div class="col-md-6" style="padding:1px">
    <?= $form->field($model, 'garagens')->textInput(['type' => 'number','step'=>"1",'min'=>"0"]) ?>
    </div>
    <div class="col-md-6" style="padding:1px">
    <?= $form->field($model, 'area_privativa',['addon' => ['append' => ['content'=>'m²']]])->textInput(['type' => 'number','step'=>"10",'min'=>"0"]) ?>
    </div>
    <div class="col-md-6" style="padding:1px">
    <?= $form->field($model, 'area_total',['addon' => ['append' => ['content'=>'m²']]])->textInput(['type' => 'number','step'=>"10",'min'=>"0"]) ?>
    </div>
    <div class="col-md-6" style="padding:1px">
    <?= $form->field($model, 'elevador')
        ->dropDownList(
            [
                1=>'Sim',
                0=>'Não',
            ],           // Flat array ('id'=>'label')
            ['prompt'=>'Selecione']    // options
        ); ?>
    </div>
    <div class="col-md-6" style="padding:1px">
    <?= $form->field($model, 'sacada')
        ->dropDownList(
            [
                1=>'Sim',
                0=>'Não',
            ],           // Flat array ('id'=>'label')
            ['prompt'=>'Selecione']    // options
        ); ?>
    </div>

    <?php
        
        $campos_bairros = [
            'Nossa Senhora Medianeira'=>'Nossa Senhora Medianeira',
            'Camobi'=>'Camobi',
            'Boi Morto'=>'Boi Morto',
            'Santa Marta'=>'Santa Marta'
        ];
        // $model->bairros = explode(';',$model->bairros);

        echo $form->field($model, 'bairros')->widget(Select2::classname(), [
            'data' => $bairros,
            // 'value' => ['red', 'green'],
            'language' => 'pt',
            'options' => [
                'placeholder' => 'Selecione os Bairros',
                'multiple' => true
            ],
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10
            ],
        ]);
    ?>
    <?php //= $form->field($model, 'valor_maximo',['addon' => ['prepend' => ['content'=>'R$']]])->textInput(['maxlength' => true,'type' => 'number','step'=>"100",'min'=>"100"]) ?>
    <?php //= $form->field($model, 'valor_minimo',['addon' => ['prepend' => ['content'=>'R$']]])->textInput(['maxlength' => true,'type' => 'number','step'=>"100",'min'=>"100"]) ?>
    <?= $form->field($model, 'valor_minimo',['addon' => ['prepend' => ['content'=>'R$']]])->widget(
            NumberControl::classname(), [
            'maskedInputOptions' => [
                'groupSeparator' => '.',
                'radixPoint' => ',',
                'allowMinus' => false
            ],
            'options' => $saveOptions,
            'displayOptions' => $dispOptions,
            'saveInputContainer' => $saveCont
    ]) ?>
    <?= $form->field($model, 'valor_maximo',['addon' => ['prepend' => ['content'=>'R$']]])->widget(
            NumberControl::classname(), [
            'maskedInputOptions' => [
                'groupSeparator' => '.',
                'radixPoint' => ',',
                'allowMinus' => false
            ],
            'options' => $saveOptions,
            'displayOptions' => $dispOptions,
            'saveInputContainer' => $saveCont
    ]) ?>

    <?php // echo $form->field($model, 'area_total') ?>

    <?php // echo $form->field($model, 'bairros') ?>

    <?php // echo $form->field($model, 'elevador') ?>

    <?php // echo $form->field($model, 'sacada') ?>

    <?php // echo $form->field($model, 'valor_maximo') ?>

    <?php // echo $form->field($model, 'valor_minimo') ?>

    <?php // echo $form->field($model, 'tipo_imovel') ?>

    <?php // echo $form->field($model, 'tipo') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Limpar Filtros', ['class' => 'btn btn-info','id'=>'form-reset-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php
    $this->registerJS('
        $("#form-reset-button").click(function(){
            location.href = "'.Yii::$app->urlManager->createUrl("imovelpermuta/index").'";
        });');
    ?>
</div>
