<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;


// use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\widgets\FileInput;
// use kartik\widgets\DatePicker;
// use kartik\widgets\SwitchInput;
// use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\SloProposta */
/* @var $form yii\widgets\ActiveForm */
?>
<style media="screen">
   /*:root {
    --cor-bg-fundo: #cceeff;
    --cor-bg-elementos: #66ccff;
    --fundo-com-transparencia: rgba(102, 204, 255, 0.1);
  }*/
  .control-label{
    font-weight: bolder !important;
    font-size: 18px;
  }
  .input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group {
    z-index: 2;
    margin-left: -1px;
    border: 1px solid  var(--cor-bg-elementos);
    border-bottom: 2px solid  var(--cor-bg-elementos);
  }
  .file-preview {
    border: 1px solid  var(--cor-bg-elementos) !important;
    border-bottom-left-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
    border-bottom: 0 !important;
    border-right: 0 !important;
    border-left: 0 !important;
    border-top-left-radius: 0 !important;
    border-top-right-radius: 0 !important;
    margin-bottom: 0 !important;
    border-top: 0 !important;
  }
  .close {
    color: var(--cor-bg-elementos) !important;
    margin: 8px;
  }
  .close:hover, .close:focus {
    color:  var(--cor-bg-elementos) !important;
    margin: 8px;
  }
  .file-drop-zone {
    border: 1px dashed  var(--cor-bg-elementos);
  }
  .file-drop-zone-title {
    color:  var(--cor-bg-elementos);
    opacity: 0.5;
    padding: 0 !important;
  }

  input::placeholder {
    color: var(--cor-bg-elementos);
  }
  .inputfile-selecionado{
    background-color: red;
  }

</style>
<div class="slo-proposta-form">
    <div class="">
        <a class="btn btn-primary btn-destaque" href="<?= Yii::$app->homeUrl.'proposta/pretendente001?form=005&id='.$model2->id .'&iddoc=' .$model->id.'&pretendente_id='.$pretendente_id.'&proposta_id='.$proposta_id ?>"><i class="fas fa-angle-double-left"></i> Voltar</a>
        <h4 class="titulo">2 - DOCUMENTAÇÃO: Comprovante de renda e outros<sup><span class="badge badge-primary"> 2/2 </span></sup>
            <br><sub title=""> <strong>Pretendente:</strong> <?=$model2->nome?></sub>
        </h4>
        <hr>

        <?php $form = ActiveForm::begin(['options' => ['id'=>'form__','enctype' => 'multipart/form-data']]); ?>
        <div class="col-md-4 hidden">
            <?= $form->field($model, 'slo_pretendente_id')->textInput(['value'=>$pretendente_id]) ?>
        </div>
        <?php
            $pluginOptions4 = [
                'showUpload' => false,
                'showPreview' => true,
                'showCaption' => false,
                'showRemove' => false,
                // 'showBrowse' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                'browseLabel' =>  'Selecionar comprovantes<span id="file-name-4"></span>',
                'uploadLabel' =>  'Selecionar comprovantes<span id="file-name-4"></span>',
                // 'browseOnZoneClick' => true,
            ];
        ?>
        <div class="col-md-12">
          <?= $form->field($modelproposta, 'imageFiles[]')->widget(FileInput::classname(), [
            'language'=>'pt',
            'options' => [
                'accept' => '.gif, .png, .jpg, .jpeg, .pdf',
                'multiple'=>true,
                'onChange'=>'$("#loading_aparada").removeClass("hidden");$("#form__").submit();'
            ],
            'pluginOptions' => $pluginOptions4
          ])->label(false); ?>
        </div>
        <?php /*
        <div class="col-md-12">
            <div class="form-group float-right">
                <?= Html::submitButton('Subir as Imagens  <i class="fas fa-upload"></i>', [
                    'class' => 'btn btn-primary btn-destaque', 
                    'style'=>'font-weight: bolder',
                    'onClick' => '$("#loading_aparada").removeClass("hidden")'
                ]) ?>
            </div>
        </div>
        */ ?>
            <div class="col-md-12 hidden" id="loading_aparada" style="text-align: center">
                <img width="150" src="<?=Yii::$app->homeUrl.'icones/load.gif' ?>">
            </div>
        <?php ActiveForm::end(); ?>
    </div>
    <?php
            if(!empty($model->outros_comprovantes)){
                $outros_comprovantes = explode(';', $model->outros_comprovantes);
                $pasta = Yii::$app->homeUrl.'uploads/propostasdocs/'.$model->id.'_outroscomprovantes_';
                // $links_outroscomprovantes = "'".$pasta.$outros_comprovantes[0]."','".$pasta.$outros_comprovantes[1]."','".$pasta.$outros_comprovantes[2]."'";
                
                // //$arr = [$pasta.$outros_comprovantes[0],$pasta.$outros_comprovantes[1],$pasta.$outros_comprovantes[2]];
                // $arr = [
                //     '<embed style="width:100%;height:100%" type="" src="'.$pasta.$outros_comprovantes[0].'"></embed>',
                //     '<embed style="width:100%;height:100%" type="" src="'.$pasta.$outros_comprovantes[1].'"></embed>',
                //     '<embed style="width:100%;height:100%" type="" src="'.$pasta.$outros_comprovantes[2].'"></embed>'
                // ];
                echo "<div class='col-md-12 clearfix'><hr></div>";
                echo "<h4>Comprovantes já enviados:</h4>";
                foreach ($outros_comprovantes as $row) {
                    # code...
                    $row = trim($row);
                    if(!empty($row)) {

                        $ext = substr($row, -3);
                        $pdf_estilo = '';
                        if ($ext == 'pdf' or $ext == 'doc' or $ext == 'ocx') {
                            $label_bt = '<i class="fas fa-file-pdf" style="font-size: 50px"></i>';
                            $pdf_estilo = 'width: 100%;height:500px;';
                        }else{
                            $label_bt = '<embed style="max-width:100%;height:100%" type="" src="'.$pasta.$row.'"></embed>';
                        }
                        echo "<div class='col-md-2' style='padding: 2px;'>";
                        yii\bootstrap\Modal::begin([
                            'header' => '<h3>'.$row.'</h3>',
                            // 'size' => 'modal-lg',
                            'toggleButton' => [
                                'label' => $label_bt,
                                'class' => 'btn btn-primary btn-imagem-info',
                                'style' => 'height: 70px; width: 100%; margin: 5%;',
                            ],
                            'footer' => Html::a('<i class="fas fa-remove"></i> Excluir Comprovante', [
                                    'deletar_comprovante', 
                                    'id' => $model->id,
                                    'comprovante' => $row,
                                ], 
                                [
                                    'class' => 'btn btn-warning float-left',
                                    'style' => '',
                                    'data' => [
                                        'confirm' => "Tens certeza que deseja excluir esse Comprovante?",
                                        'method' => 'post',
                                    ],
                                ]),
                        ]);
                        if ($ext == 'doc' or $ext == 'ocx') {
                            echo "<a href='".Yii::$app->basePath.'/web/uploads/propostasdocs/'.$row."' download='$row'>$row</a>";//$pasta.$row;
                        }else{
                            echo '<embed style="max-width:100%;max-height:500px;'.$pdf_estilo.'" type="" src="'.$pasta.$row.'"></embed>';
                        }
                        
                        echo "<div class='col-md-12 clearfix'></div>";
                        yii\bootstrap\Modal::end();
                        echo "</div>";
                    }
                 } 

                // $pluginOptions4 = [
                //     //'initialPreview'=> $arr,
                //     'initialPreviewAsData'=>false,
                //     'showUpload' => true,
                //     'showPreview' => true,
                //     'showCaption' => true,
                //     'showRemove' => true,
                //     'browseClass' => 'btn btn-primary btn-block',
                //     'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                //     'browseLabel' =>  'Selecionar outros Comprovantes<span id="file-name-4"></span>'
                // ];
            }

        ?>
        
        <div class="col-md-12 clearfix"><hr></div>
        <?= Html::a('CONTINUAR  <i class="fas fa-angle-double-right"></i>', [
            'pretendente001',
            'id' => $_REQUEST['id'],
            'iddoc' => $_REQUEST['iddoc'],
            'form' => '007',
            'pretendente_id' => $pretendente_id,
            'proposta_id' => $proposta_id,
        ],
        [
            'class' => 'btn btn-primary btn-destaque float-right', 
            'style'=>'font-weight: bolder',
            'link' => 'xxx.com'
        ]) ?>
            
        <?php
            // return $this->redirect(['pretendente001',
                        // 'id' => $_REQUEST['id'],
                        // 'iddoc' => $_REQUEST['iddoc'],
                        // 'form' => '007',
                        // 'pretendente_id' => $pretendente_id,
                        // 'proposta_id' => $proposta_id,
                      // ]);
        ?>
</div>
<?php 
// $this->registerJS("
//     var input = $('#sloproposta-file1'),
//     fileName = $('#file-name-1');
//     input.on('change', function(){
//         fileName.html('<br><i class=\"far fa-check-square\"></i> - '+$(this).val());
//         $(this).addClass('inputfile-selecionado');
//     });
//     var input2 = $('#sloproposta-file2'),
//     fileName2 = $('#file-name-2');
//     input2.on('change', function(){
//         fileName2.html('<br><i class=\"far fa-check-square\"></i> - '+$(this).val());
//         $(this).addClass('inputfile-selecionado');
//     });
//     var input4 = $('#sloproposta-imagefiles'),
//     fileName4 = $('#file-name-4');
//     input4.on('change', function(){
//         var files = $(this).prop(\"files\");
//         var names = $.map(files, function(val) { return val.name; });
//         fileName4.html('<br><i class=\"far fa-check-square\"></i> - '+names);
//         $(this).addClass('inputfile-selecionado');
//     });
// ");
/*
    A fazer:
    primeiro acesso:
        - Formulário: Campo Upload vazio - Enviar Imagem.
        - Botão submit pra action, que faz upload e atualiza o campo documentacao->outros_comprovantes,
            depois volta pro mesmo form 006, pra outro upload.
        - Botão continuar passa a ser apenas um link (não mais submit) pro próximo formulario.
    retorno do primeiro submit:
        - Formulário: Campo Upload vazio - Enviar Imagem.
        - Botão submit pra action, que faz upload e atualiza o campo documentacao->outros_comprovantes,
            depois volta pro mesmo form 006, pra outro upload.
        -incluir botão "limpar", que deleta os arquivos e limpa o campo no banco de dados,
            documentacao->outros_comprovantes, 
        - Botão continuar passa a ser apenas um link (não mais submit) pro próximo formulario.    
    (...)
*/
    $this->registerJS("
        $('.file-drop-zone-title').html('Solte os arquivos aqui ou<br> selecione no botão abaixo');
    ");
?>