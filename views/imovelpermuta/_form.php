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
use dosamigos\ckeditor\CKEditor;

// use kartik\money\MaskMoney;

/* @var $this yii\web\View */
/* @var $model app\models\ImovelPermuta */
/* @var $form yii\widgets\ActiveForm */
$json_imoveis = $this->context->get_content('http://www.jetimob.com/services/tZuuHuri8Q3ohAf7cvmMm8hTmWrXKJoEdes8ViSi/imoveis/',864000);

$imoveis = json_decode($json_imoveis);
$i = 1;
$codigos = array();

foreach ($imoveis as $e):
    $pos = strripos($e->observacoes, 'Permuta');
    if (!$pos === false) {
        $i++;
        $codigos[$e->codigo] = $e->codigo;
    }
    $bairros_imoveis[$e->endereco_bairro] = $e->endereco_bairro;
    $tipos_imoveis[$e->tipo] = $e->tipo;
    $tipos_imoveis[$e->subtipo] = $e->subtipo;
endforeach;

/* ===================================================================================================================================== */
$bairros_imoveis = array_filter(array_unique($bairros_imoveis));
asort($bairros_imoveis);
$tipos_imoveis = array_filter(array_unique($tipos_imoveis));
asort($tipos_imoveis);

/* ===================================================================================================================================== */
?>


<div class="imovel-permuta-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-2">
        <?php //= $form->field($model, 'codigo',['addon' => ['prepend' => ['content'=>'PIN - ']]])->textInput(['maxlength' => true]) ?>
        <?php
            if(!$model->isNewRecord) {
                $codigos[$model->codigo] = $model->codigo;
            }
            // $model->codigo = '0547';
            echo $form->field($model, 'codigo',['addon' => ['prepend' => ['content'=>'PIN']]])->widget(Select2::classname(), [
                'data' => $codigos,
                'language' => 'pt',
                'options' => [
                    'placeholder' => 'Selecione o Código do imóvel',
                ],
                'pluginOptions' => [
                    'tags' => true,
                    'maximumInputLength' => 10
                ],
            ]);
        ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'dormitorios')->textInput(['type' => 'number','step'=>"1",'min'=>"0"]) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'garagens')->textInput(['type' => 'number','step'=>"1",'min'=>"0"]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'area_privativa',['addon' => ['append' => ['content'=>'m²']]])->textInput(['type' => 'number','step'=>"1",'min'=>"0"]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'area_total',['addon' => ['append' => ['content'=>'m²']]])->textInput(['type' => 'number','step'=>"1",'min'=>"0"]) ?>
    </div>
    <div class="col-md-8">
        <?php //= $form->field($model, 'tipo_imovel')->textInput() ?>
        <?php
            // $nivel=TipoImovel::find()->all();
            // $listData=ArrayHelper::map($nivel,'idtipo_imovel','tipo');
            // echo $form->field($model, 'tipo_imovel')->dropDownList($listData, ['prompt'=>'Selecione']);
        ?>
        <?php

            $campos_tipo = ['Apartamento'=>'Apartamento','Casa'=>'Casa','Kitnet'=>'Kitnet','Chácara'=>'Chácara'];
            $model->tipo = explode(';',$model->tipo);

            echo $form->field($model, 'tipo')->widget(Select2::classname(), [
                'data' => $tipos_imoveis,
                'language' => 'pt',
                'options' => [
                    'placeholder' => 'Selecione o Tipo',
                    'multiple' => true
                ],
                'pluginOptions' => [
                    // 'tags' => true,
                    'allowClear' => true,
                    // 'tags' => true,
                    // 'maximumInputLength' => 10
                ],
            ]);
        ?>
    </div>
    <div class="col-md-2">
        <?php //= $form->field($model, 'elevador')->textInput() ?>
        <?= $form->field($model, 'elevador')->widget(SwitchInput::classname(), ['pluginOptions' => ['onText' => 'Sim','offText' => 'Não',]]) ?>
    </div>
    <div class="col-md-2">
        <?php //= $form->field($model, 'sacada')->textInput() ?>
        <?= $form->field($model, 'sacada')->widget(SwitchInput::classname(), ['pluginOptions' => ['onText' => 'Sim','offText' => 'Não',]]) ?>
    </div>
    <div class="col-md-8">
        <?php //= $form->field($model, 'bairros')->textInput() ?>
        <?php

            $model->bairros = explode(';',$model->bairros);

            echo $form->field($model, 'bairros')->widget(Select2::classname(), [
                'data' => $bairros_imoveis,
                'language' => 'pt',
                'options' => [
                    'placeholder' => 'Selecione os Bairros',
                    'multiple' => true
                ],
                'pluginOptions' => [
                    // 'tags' => true,
                    'allowClear' => true,
                    // 'maximumInputLength' => 10
                ],
            ]);
        ?>
    </div>
    <?php /*
    <div class="col-md-2">
        <?= $form->field($model, 'valor_maximo',['addon' => ['prepend' => ['content'=>'R$']]])->textInput(['maxlength' => true,'type' => 'number','step'=>"100",'min'=>"100"]) ?>
    </div>
    */ ?>
    <div class="col-md-2">
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
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'valor_minimo',['addon' => ['prepend' => ['content'=>'R$']]])->widget(
            NumberControl::classname(), [
            'maskedInputOptions' => [
                // 'prefix' => '$ ',
                // 'suffix' => ' ¢',
                'groupSeparator' => '.',
                'radixPoint' => ',',
                'allowMinus' => false
            ],
            'options' => $saveOptions,
            'displayOptions' => $dispOptions,
            'saveInputContainer' => $saveCont
        ]) ?>
    </div>
    <div class="col-md-12">
    <?php //= $form->field($model, 'observacoes')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'observacoes')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'full'
            ]);
    ?>
    </div>


    <div class="col-md-12">
    <hr>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Salvar') : Yii::t('app', 'Atualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
