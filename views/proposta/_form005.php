<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
// use kartik\widgets\DatePicker;
use kartik\widgets\SwitchInput;
use yii\widgets\MaskedInput;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\SloProposta */
/* @var $form yii\widgets\ActiveForm */
if (empty($model->frente_documento) or empty($model->verso_documento))
  $modelproposta->ativo = true;
?>
<?php

    $dats = str_split($model2->cpf,3);
    $dados_anteriores .= 'Cpf: '.$dats[0].'.'.$dats[1].'.'.$dats[2].'-'.$dats[3]."\n";
    $dados_anteriores .= 'Data de Nacimento: ' . date('d/m/Y', strtotime($model2->data_nascimento))."\n";
    $dados_anteriores .= 'Email: ' . $model2->email."\n";
    

?>
<div class="slo-proposta-form">
    <div class="">
        <a class="btn btn-primary btn-destaque" href="<?= Yii::$app->homeUrl.'proposta/pretendente001?form=001&id='.$model2->id.'&pretendente_id='.$pretendente_id.'&proposta_id='.$proposta_id ?>"><i class="fas fa-angle-double-left"></i> Voltar para as informações Pessoais</a>
        <h4 class="titulo">2 - Documentação <sup><span class="badge badge-primary"> 1/2 </span></sup>
            <br><sub title="<?= $dados_anteriores ?>"> <strong>Pretendente:</strong> <?=$model2->nome?></sub>
        </h4>
        <hr>

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="col-md-4 hidden">
            <?= $form->field($model, 'slo_pretendente_id')->textInput(['value'=>$pretendente_id]) ?>
        </div>
        
        <div class="col-md-12 clearfix"><br></div>
        <div class="col-md-6">
          <?= $form->field($model, 'tipo_documento')->dropDownList([
            'RG' => 'RG',
            'RNE' => 'RNE',
            'CNH' => 'CNH',
            'Doc de Classe' => 'Doc de Classe',
          ], ['prompt' => '']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'numero')->textInput(['maxlength' => true,'type' => 'number']) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'orgao_expedidor')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'data_expedicao')->widget(MaskedInput::className(), [
                'clientOptions' => [
                    'alias' =>  'dd/mm/yyyy',
                    'placeholder' => 'dd/mm/aaaa',
                ],
                'options'=>[
                    // 'onfocus'=> '$(this).key',
                    // 'pattern'=>"[0-9]*",
                    'inputmode'=>"numeric",
                    'class'=>"form-control",
                    'value'=> $model->data_expedicao ? date('d/m/Y',strtotime($model->data_expedicao)):'',
                ]
            ]) ?>
        </div>

        <div class="col-md-12">
            <hr>
        </div>
         <div class="col-md-12">
            <label style="color: orange; text-align: right;float: right;">
                *Apenas arquivos de Imagem ou Pdf
            </label>
        </div>
        <div class="col-md-4 hidden">
            <?= $form->field($model, 'slo_pretendente_id')->textInput(['value'=>$pretendente_id]) ?>
        </div>
        <br />
        <br />
        <br />
        <?php
            $pluginOptions = [
                'showUpload' => false,
                'showPreview' => false,
                'showCaption' => false,
                'showRemove' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' =>  'Selecionar <strong>Frente</strong> do Documento<span id="file-name-1"></span>'
            ];
            if(!empty($model->frente_documento)){
                $pluginOptions = [
                    'initialPreview'=>[
                        '<embed style="width:100%;height:100%" type="" src="'.Yii::$app->homeUrl.'uploads/propostasdocs/'.$model->id.'_frentdoc_'.$model->frente_documento.'"></embed>',
                    ],
                    'initialPreviewAsData'=>false,
                    'showUpload' => false,
                    'showCaption' => false,
                    'showRemove' => false,
                    'browseClass' => 'btn btn-primary btn-block',
                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                    'browseLabel' =>  'Selecionar <strong>Frente</strong> do Documento<span id="file-name-1"></span>'
                ];
            }
          ?>
        <div class="col-md-6">
          <?= $form->field($modelproposta, 'file1')->widget(FileInput::classname(), [
            'language'=>'pt',
            'options' => [
                'accept' => '.gif, .png, .jpg, .jpeg, .pdf',
            ],
            'pluginOptions' => $pluginOptions
          ])->label(false); ?>
        </div>
        <?php
            $pluginOptions2 = [
                'showUpload' => false,
                'showPreview' => false,
                'showCaption' => false,
                'showRemove' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' =>  'Selecionar <strong>Verso</strong> do Documento<span id="file-name-2"></span>'
            ];
            if(!empty($model->verso_documento)){
                $pluginOptions2 = [
                    'initialPreview'=>[
                        '<embed style="width:100%;height:100%" type="" src="'.Yii::$app->homeUrl.'uploads/propostasdocs/'.$model->id.'_versodoc_'.$model->verso_documento.'"></embed>',
                    ],
                    'initialPreviewAsData'=>false,
                    'showUpload' => false,
                    'showCaption' => false,
                    'showRemove' => false,
                    'browseClass' => 'btn btn-primary btn-block',
                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                    'browseLabel' =>  'Selecionar <strong>Verso</strong> do Documento<span id="file-name-2"></span>'
                ];
            }
        ?>
        <div class="col-md-6">
          <?= $form->field($modelproposta, 'file2')->widget(FileInput::classname(), [
            'language'=>'pt',
            'options' => [
                'accept' => '.gif, .png, .jpg, .jpeg, .pdf',
            ],
            'pluginOptions' => $pluginOptions2
          ])->label(false); ?>
        </div>
        <!-- INÍCIO DA Selfie com o Documento !!!!  -->
        <?php
            $pluginOptions3 = [
                'showUpload' => false,
            ];
            if(!empty($model->selfie_com_documento)){
                $pluginOptions3 = [
                    'initialPreview'=>[
                        '<embed style="width:100%;height:100%" type="" src="'.Yii::$app->homeUrl.'uploads/propostasdocs/'.$model->id.'_selfidoc_'.$model->selfie_com_documento.'"></embed>',
                    ],
                    'initialPreviewAsData'=>false,
                    'showUpload' => false,
                ];
            }
        ?>
        <div class="col-md-12" style="display: none !important">
          <?= $form->field($modelproposta, 'file3')->widget(FileInput::classname(), [
            'language'=>'pt',
            'options' => [
                'accept' => 'image/*',
            ],
            'pluginOptions' => $pluginOptions3
          ])->label('Selfie com o Documento ('.$model->tipo_documento.'):'); ?>
        </div>
        <!-- FIM DA Selfie com o Documento !!!!  -->

        <div class="col-md-12">
            <div class="form-group float-right">
                <?= Html::submitButton('CONTINUAR  <i class="fas fa-angle-double-right"></i>', ['class' => 'btn btn-primary btn-destaque', 'style'=>'font-weight: bolder']) ?>
            </div>
        </div>


        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php 
$this->registerJS("
    var input = $('#sloproposta-file1'),
    fileName = $('#file-name-1');
    input.on('change', function(){
        fileName.html('<br><i class=\"far fa-check-square\"></i> - '+$(this).val());
        $(this).addClass('inputfile-selecionado');
    });
    var input2 = $('#sloproposta-file2'),
    fileName2 = $('#file-name-2');
    input2.on('change', function(){
        fileName2.html('<br><i class=\"far fa-check-square\"></i> - '+$(this).val());
        $(this).addClass('inputfile-selecionado');
    });
    var input4 = $('#sloproposta-imagefiles'),
    fileName4 = $('#file-name-4');
    input4.on('change', function(){
        var files = $(this).prop(\"files\");
        var names = $.map(files, function(val) { return val.name; });
        fileName4.html('<br><i class=\"far fa-check-square\"></i> - '+names);
        $(this).addClass('inputfile-selecionado');
    });
");
?>