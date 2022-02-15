<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\slider\Slider;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;

use app\models\Imobiliarias;
use app\models\Condominio;

use yii\bootstrap\Collapse;

$todas_comodidades = $this->context->get_content('http://www.jetimob.com/services/tZuuHuri8Q3ohAf7cvmMm8hTmWrXKJoEdes8ViSi/comodidades/',864000);
$todas_comodidades = json_decode($todas_comodidades);

$arr_comodidades = [];
foreach ($todas_comodidades as $row) {
    // array_push($arr_comodidades,$row->descricao);
    $arr_comodidades[$row->descricao] = $row->descricao;
}

/* @var $this yii\web\View */
/* @var $model app\models\ImoveisexternosSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
    .tooltip{
        z-index: 10;
    }
</style>

<div class="imoveisexternos-search col-lg-12">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
        <div class="col-lg-1">
            <?php echo $form->field($model, 'codigo'); ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'imobiliarias_id')->dropDownList(ArrayHelper::map(Imobiliarias::find()->orderBy(['nome'=>SORT_ASC])->asArray()->all(), 'id','nome'),['prompt'=>'Selecione']) ?>        
        </div>
        <div class="col-lg-2">
        <?= $form->field($model, 'contrato')->dropDownList(
            ['Venda/Locação'=>'Venda/Locação','Venda'=>'Venda','Locação'=>'Locação'],
            [
                'prompt' => 'Selecione',
                'onchange' => 'if ($(this).val() == "Locação") {
                    $("#intervalo_venda").hide();
                    $("#intervalo_locacao").show();
                } else {
                    $("#intervalo_venda").show();
                    $("#intervalo_locacao").hide();
                }'
            ]
        ) ?>
        </div>
        <div class="col-lg-3" style="text-align:center;<?=$model->contrato=='Locação'?'display:none':''?>" id="intervalo_venda">
            <br><br>
            <?php  
                echo $form->field($model, 'valoresdevenda')->widget(Slider::classname(), [
                    // 'model'=>$model,
                    // 'attribute'=>'valoresdevenda',
                    // 'value'=>'0,1000000',
                    'sliderColor'=>'orange',
                    'pluginOptions'=>[
                        'min'=>0,
                        'max'=>1000000,
                        'step'=>100,
                        'range'=>true,
                        'tooltip'=>'always',
                        'handle'=>'square',
                        'formatter'=> new JsExpression("
                        function(val) { 
                            val = String(val);
                            var val2 = val.split(',');
                            var vare1 = 'R$ '+addCommas(val2[0]);
                            var vare2 = ' : R$ '+addCommas(val2[1]);
                            
                            if (val2[0] == '5') {
                                vare1 = 'R$ 0';
                            }
                            if (val2[1] == '1000000') {
                                vare2 = ' : Indefinido';
                            }

                            return 'Venda '+vare1+vare2;
                        }")
                    ],
                ])->label('');
            ?>
        </div>
        <div class="col-lg-3" style="text-align:center;<?=$model->contrato=='Locação'?'':'display:none'?>" id="intervalo_locacao">
            <br><br>
            <?php  
                echo $form->field($model, 'valoresdelocacao')->widget(Slider::classname(), [

                    // 'name'=>'valoresdelocacao',
                    // 'value'=>'100,50000',
                    'sliderColor'=>'orange',
                    'pluginOptions'=>[
                        'min'=>0,
                        'max'=>20000,
                        'step'=>100,
                        'range'=>true,
                        'tooltip'=>'always',
                        'handle'=>'square',
                        'formatter'=> new JsExpression("
                        function(val) { 
                            val = String(val);
                            var val2 = val.split(',');
                            var vare1 = 'R$ '+addCommas(val2[0]);
                            var vare2 = ' : R$ '+addCommas(val2[1]);
                            
                            if (val2[0] == '5') {
                                vare1 = 'R$ 0';
                            }
                            if (val2[1] == '20000') {
                                vare2 = ' : Indefinido';
                            }
                            return 'Locação '+vare1+vare2;
                        }")
                    ],
                ])->label('');
            ?>
        </div>
        <div class="col-lg-3" style="text-align:center">
            <br>
            <br>
            <?php  
                echo $form->field($model, 'area_privativa')->widget(Slider::classname(), [

                    // 'name'=>'valoresdelocacao',
                    // 'value'=>'100,50000',
                    'sliderColor'=>'orange',
                    'pluginOptions'=>[
                        
                        'min'=>0,
                        'max'=>1000,
                        'step'=>5,
                        // 'range'=>true,
                        'tooltip'=>'always',
                        'handle'=>'square',
                        'formatter'=> new JsExpression("
                            function(val) { 
                                val = String(val);
                                var val2 = addCommas(val);
                                if (val2 == '5') {
                                    val2 = '0';
                                }
                                return 'Área Privativa: '+val2+' m²';
                            }")
                    ],
                ])->label('');
            ?>
        </div>
        <!-- <div class="col-lg-6"> -->
            
        <div class="col-lg-2" id="div-tipo">
            <?php
                echo $form->field($model, 'tipo')->widget(Select2::classname(), [
                    'data' => $model->tipos,
                    // 'value' => ['red', 'green'],
                    'language' => 'pt',
                    'options' => [
                        'placeholder' => 'Selecione o Tipo',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        // 'tags' => true,
                        'maximumInputLength' => 10
                    ],
                ]);
            ?>
        </div>

        <div class="col-lg-4" id="div-condominios">
            <?php
                $condominios = array();
                foreach(Condominio::find()->asArray()->all() as $c){
                    // array_push($condominios,$c['nome']);
                    $condominios[$c['nome']] = $c['nome'];
                }
                // echo '<pre>';
                // print_r($condominios);
                // echo '</pre>';
                echo $form->field($model, 'condominio')->widget(Select2::classname(), [
                    'data' => $condominios,
                    // 'value' => ['red', 'green'],
                    'language' => 'pt',
                    'options' => [
                        'placeholder' => 'Selecione o Condominio',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        // 'tags' => true,
                        'maximumInputLength' => 10
                    ],
                ]);
            ?>
        </div>
        <!-- </div> -->
        <!-- <div class="col-lg-6"> -->
            <div class="col-lg-6">
                <?php
                    $data_dorm = [1=>'1', 2=>'2', 3=>'3', 4=>'4', 5=>'5', 6=>'6', 7=>'7', 8=>'8', 9=>'9', 10=>'10', 11=>'<span class="glyphicon glyphicon-plus" style="width:10px"></span>'];
                    $data_gar = [0=>'0+', 1=>'1+', 2=>'2+', 3=>'3+', 4=>'4+', 5=>'5+', 6=>'6+', 7=>'7+', 8=>'8+', 9=>'9+'];
                    $data_ban = [1=>'1+', 2=>'2+', 3=>'3+', 4=>'4+', 5=>'5+', 6=>'6+', 7=>'7+', 8=>'8+', 9=>'9+'];
                echo $form->field($model, 'arr_dormitorios')->checkboxButtonGroup($data_dorm);
                //= $form->field($model, 'dormitorios',['addon' => ['prepend' => ['content'=>'PIN - ']]])->textInput(['type' => 'number','step'=>"1",'min'=>"0"]) ?>
            </div>
            <div class="col-lg-6">
                <?php
                echo $form->field($model, 'garagens')->radioButtonGroup($data_gar);
                ?>
                <?php //= $form->field($model, 'garagens')->textInput(['type' => 'number','step'=>"1",'min'=>"0"]) ?>
            </div><div class="col-lg-6">
                <?php
                echo $form->field($model, 'banheiros')->radioButtonGroup($data_ban);
                ?>
                <?php //= $form->field($model, 'garagens')->textInput(['type' => 'number','step'=>"1",'min'=>"0"]) ?>
            </div>
        <!-- </div> -->
        

        <div class="col-lg-12" id="div-dos-bairros">
            <!-- Deus tá vendo você usar CSS inline -->
            <style type="text/css">
                @media (min-width: 480px) {
                    #div-dos-bairros .btn-default {
                        width: 25%
                    }
                }
                #div-dos-bairros .active:before{
                    content: "»";
                }
            </style>
            <?php 
            // use dosamigos\multiselect\MultiSelectListBox;
            // use dosamigos\multiselect\MultiSelect;
            /*
                echo $form->field($model, 'endereco_bairro')->widget(Select2::classname(), [
                    'data' => $model->bairros,
                    // 'value' => ['red', 'green'],
                    'language' => 'pt',
                    'options' => [
                        'placeholder' => 'Selecione os Bairros',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        // 'tags' => true,
                        'maximumInputLength' => 10
                    ],
                ]);
                echo $form->field($model, 'endereco_bairro[]')            
                 ->dropDownList($model->bairros,
                 [
                  'multiple'=>'multiple',
                  'class'=>'chosen-select input-md required',              
                 ]             
                )->label("Add Categories"); 

                echo $form->field($model, 'endereco_bairro')->widget(MultiSelectListBox::className(),[
                    'data' => $model->bairros,
                    "options" => [
                        'multiple'=>"multiple"
                    ],
                    "clientOptions" => [
                        'language' => 'pt_BR',
                        "includeSelectAllOption" => true,
                        'numberDisplayed' => 5
                    ], 
                ]);
                
                echo $form->field($model, 'endereco_bairro')->widget(MultiSelect::className(),[
                    'data' => $model->bairros,
                    "options" => [
                        'columns'=>2,
                        'multiple'=>"multiple",
                    ],
                    "clientOptions" => [
                        'columns'=>2,
                        'language' => 'pt_BR',
                        "includeSelectAllOption" => true,
                        'numberDisplayed' => 5
                    ], 
                ]);
            */


            // echo "<h4>Bairros de Santa Maria</h4>";
            $conteudo_bairros = Html::checkbox(null, count($model->endereco_bairro) == 72?true:false, [
                'label' => 'Selecionar Todos',
                'class' => 'check-all',
            ]);

            $conteudo_bairros .= $form->field($model, 'endereco_bairro')->checkboxButtonGroup($model->bairros,["clientOptions" => [
                    'columns'=>2,
                    'language' => 'pt_BR',
                    "includeSelectAllOption" => true,
                    'numberDisplayed' => 5
                ]])->label(false);


            echo Collapse::widget([
            'items' => [
                // equivalent to the above
                [
                    'label' => 'Bairros de Santa Maria ('.count($model->endereco_bairro).' selecionados)',
                    'encodeLabels'=>false,
                    'content' => $conteudo_bairros,
                ],
            ]]);

            ?>
        </div>


        <div class="col-lg-12" id="div-das-comodidades">
            <!-- Deus tá vendo você usar CSS inline -->
            <style type="text/css">
                @media (min-width: 480px) {
                    #div-das-comodidades .btn-default {
                        width: 25%
                    }
                }
                #div-das-comodidades .active:before{
                    content: "»";
                }
            </style>
            <?php 
            
            // echo "<h4>Bairros de Santa Maria</h4>";
            $conteudo_comodidades = Html::checkbox(null, count($model->comodidades) == 72?true:false, [
                'label' => 'Selecionar Todos',
                'class' => 'check-all',
            ]);

            $conteudo_comodidades .= $form->field($model, 'comodidades')->checkboxButtonGroup($arr_comodidades,["clientOptions" => [
                    'columns'=>2,
                    'language' => 'pt_BR',
                    "includeSelectAllOption" => true,
                    'numberDisplayed' => 5
                ]])->label(false);


            echo Collapse::widget([
            'items' => [
                // equivalent to the above
                [
                    'label' => 'Comodidades ('.count($model->comodidades).' selecionados)',
                    'encodeLabels'=>false,
                    'content' => $conteudo_comodidades,
                ],
            ]]);

            ?>
        </div>
        
        
        
        
        
        
        
    <hr>
    <div class="form-group col-lg-12" style="border-top: 1px solid lightgray;text-align: center;padding: 5px;">
        <?= Html::submitButton('Pesquisar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Limpar', ['class' => 'btn btn-default','id'=>'form-reset-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php
    $conta_bairros = count($model->endereco_bairro);
    if ($conta_bairros == 1 && empty($_REQUEST['ImoveisexternosSearch']['endereco_bairro'])) {
        $conta_bairros = 0;
    }
    $conta_comodidades = count($model->comodidades);
    if ($conta_comodidades == 1 && empty($_REQUEST['ImoveisexternosSearch']['comodidades'])) {
        $conta_comodidades = 0;
    }
    $this->registerJS('
        $("#form-reset-button").click(function(){
            location.href = "'.Yii::$app->urlManager->createUrl("imoveisexternos/index").'";
        });
        $(".check-all").click(function() {
            var selector = $(this).is(":checked") ? ":not(:checked)" : ":checked";

            $("#div-dos-bairros input[type=\'checkbox\']" + selector).each(function() {
                $(this).trigger("click");
            });
        });
        $(document).ready(function () {
            $(\'#div-dos-bairros a[data-toggle="collapse"]\').html("<span class=\'glyphicon glyphicon-globe\'></span> Bairros de Santa Maria ('.$conta_bairros.' pesquisados) <span class=\'toggle-icon glyphicon glyphicon-menu-down\'></span>");
            $(\'#div-dos-bairros a[data-toggle="collapse"]\').click(function () {
                $(this).find(\'span.toggle-icon\').toggleClass(\'glyphicon-menu-up glyphicon-menu-down\'); 
            });
            $(\'#div-das-comodidades a[data-toggle="collapse"]\').html("<span class=\'glyphicon glyphicon-home\'></span> Comodidades ('.$conta_comodidades.' pesquisados) <span class=\'toggle-icon glyphicon glyphicon-menu-down\'></span>");
            $(\'#div-das-comodidades a[data-toggle="collapse"]\').click(function () {
                $(this).find(\'span.toggle-icon\').toggleClass(\'glyphicon-menu-up glyphicon-menu-down\'); 
            });
        });
        ');
    ?>
</div>
