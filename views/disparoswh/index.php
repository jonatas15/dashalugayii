<?php

use yii\helpers\Html;
use yii\grid\GridView;

use yii\bootstrap\Modal;
use kartik\select2\Select2;
use kartik\form\ActiveForm;
use kartik\editable\Editable;
use yii\widgets\MaskedInput;

function dispares($numero) {
    $pessoa = \app\models\SloInfospessoais::find()->where([
        'celular' => $numero
    ])->one();
    return $pessoa->nome;
}
function scriptenvia($telefone, $id) {
    return "
    var textoenvio = $('#textoarea-$id').val();
    $('#textoarea-$id').on('keyup', function(){
        settings_$telefone.data.message_body = $('#textoarea-$id').val();
        // console.log(textoenvio);
    });
    var settings_$telefone = {
        'url': 'https://app.whatsgw.com.br/api/WhatsGw/Send',
        'method': 'POST',
        'timeout': 0,
        'headers': {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        'data': {
            'apikey': 'cfdab196-e034-4b76-a543-cef032285dff',
            'phone_number': '555581250745',
            'contact_phone_number': '55$telefone',
            'message_custom_id': 'mysoftwareid',
            'message_type': 'text',
            'message_body': textoenvio
        }
    };
    ";
}
function scriptproajax($telefone) {
    return "
        $.ajax(settings_$telefone).done(function (response) {
            console.log(response);
        });\n
    ";
}

/* @var $this yii\web\View */
/* @var $searchModel app\models\DisparoswhSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Locação: Disparo de mensagem em massa';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .div-card {
        padding: 5%;
        margin: 1%;
        border: 1px solid lightgray;
    }
    .xxtable, .xxth, .xxtd {
        border: 1px solid black;
        padding: 5px;
    }
</style>
<div class="disparoswh-index">

    <h2 style="text-align: center"><?= Html::encode($this->title) ?></h2>
    <hr>
    <p>
    <?php
        // echo Html::a('Novo Grupo de Disparo', ['create'], ['class' => 'btn btn-success']);
        Modal::begin([
            'header' => '<h3 style="text-align: center">Novo Grupo de Disparo</h3>',
            'size' => 'modal-md',
            'toggleButton' => [
                'id' => 'md1',
                'label' => '<strong><i class="fa fa-users"></i> <i class="fa fa-whatsapp"></i> NOVO GRUPO DE DISPARO</strong>',
                'title' => 'Novo Grupo de Disparo ',
                'alt' => 'Novo Grupo de Disparo',
                'class' => 'btn btn-primary',
            ]
        ]);
        //Clientes e seus números
        $pretendentes = \app\models\SloProposta::find()->all();
        $data = [];
        foreach ($pretendentes as $k => $v) {
            $data[$v->proponente->sloInfospessoais->celular] = $v->proponente->sloInfospessoais->nome.': '.$this->context->format_telefone($v->proponente->sloInfospessoais->celular);
        }
        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';

        $novogrupo = new \app\models\Disparoswh();

        $form = ActiveForm::begin([
            'options' => [
            ],
            'action' => [
                'create'
            ]
        ]);
        echo $form->field($novogrupo, 'titulo')->textInput(['maxlength' => true]);
        echo $form->field($novogrupo, 'usuario_id')->hiddenInput([
            'value' => Yii::$app->user->identity->id
        ])->label(false);

        echo $form->field($novogrupo, 'numeros')->widget(Select2::classname(), [
            'data' => $data,
            'maintainOrder' => true,
            'options' => [
                'placeholder' => 'Selecione', 
                'multiple' => true
            ],
            'pluginOptions' => [
                'tags' => false,
                'maximumInputLength' => 100
            ],
        ]);
        echo '<br>';
        echo Html::submitButton('Enviar  <i class="fas fa-angle-double-right"></i>', [
            'class' => 'btn btn-primary btn-destaque', 
            'style' => 'font-weight: bolder'
        ]);
        ActiveForm::end();
        echo '<div class="clearfix"></div>';
        Modal::end();
    ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <?php /*= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'titulo',
            'numeros:ntext',
            'usuario_id',
            'disparos_feitos:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ])
    */ ?>
    <?php 
        // $this->registerJs("
            // $('#botao-whats').on('click', function() {
            //     $.ajax(settings).done(function (response) {
            //         console.log(response);
            //     });
            // });
        // ");
    ?>
    <div class="col-md-12">    
    <?php foreach ($dataProvider->models as $key => $v): ?>
        <?php
            echo '<div class="col-md-6">';
            echo '<div class="div-card">';    
            echo "<h4 style='font-weight: bold; text-transform: uppercase'>{$v->titulo}";
            Modal::begin([
                'header' => '<h3 style="text-align: center"><i class="fa fa-whatsapp"></i> Disparar Mensagem</h3>',
                'size' => 'modal-md',
                'headerOptions' => [
                    'style' => 'background-color: #075E54; color: white; text-transform: uppercase',
                ],
                'bodyOptions' => [
                    'style' => 'background-color: #128C7E; padding: 5%',
                ],
                'toggleButton' => [
                    'id' => 'md_'.$v->id,
                    'label' => '<strong><i class="fa fa-whatsapp"></i> DISPARAR</strong>',
                    'title' => 'Novo Grupo de Disparo ',
                    'alt' => 'Novo Grupo de Disparo',
                    'class' => 'btn btn-success',
                    'style' => 'float: right'
                ]
            ]);
                echo "<textarea id='textoarea-$v->id' cols='50' rows='6' style='width: 100%; border: 1px solid lightgray; border-radius: 10px;'></textarea>";
                echo '<br>';
                echo '<br>';
                echo "<button class='btn btn-success float-right' id='botao-whats-$v->id' style='border-radius: 10px !important; text-transform: uppercase; font-weight: bold'>Disparar em Massa <i class='fa fa-send'></i></button>";
                echo '<br>';
                echo '<div class="clearfix"></div>';
            Modal::end();
            echo "</h4>";
            echo "<hr>";
            // echo $v->numeros;
            
            $numeros = explode(';', $v->numeros);
            $i = 1;
            $script_interno_disparo = "";
            foreach ($numeros as $n) {
                if($n != '') {

                    $nome_paraver = 'Contato '.$i;
                    if(dispares($n) != "") {
                        $nome_paraver = dispares($n);
                    }
                    $arr_preposicoes = ["de", "da", "do", "DE", "DA", "DO", "De", "Da", "Do"];
                    $nomesarr = explode(" ", $nome_paraver);
                    echo '<div class="col-md-6"><label>'.$nomesarr[0].' '.(in_array($nomesarr[1], $arr_preposicoes) ? $nomesarr[1].' '.$nomesarr[2] : $nomesarr[1]).'</label></div><div class="col-md-4">'.$this->context->format_telefone($n).'</div>';
                    echo '<div class="col-md-2"><a class="" href="'.Yii::$app->homeUrl.'disparoswh/excluinumero?'."id={$v->id}&numero={$n}".'"><i class="fa fa-trash"></i></a></div>';
                    echo '<div class="col-md-12"><hr style="margin:5px;"></div>';
                    $this->registerJs(scriptenvia($n,$v->id));
                    $script_interno_disparo .= scriptproajax($n);
                    $i++;
                }
            }
            // Fazer tabela pra guardar historico de disparos multiplos!!!!!
            $this->registerJs("
                $('#botao-whats-".$v->id."').on('click', function() {
                    textoenvio = $('#textoarea-$v->id').val();
                    $.ajax({
                        'url': '".Yii::$app->homeUrl."disparoswh/gravahistorico',
                        'method': 'POST',
                        'data': {
                            'disparo_id': '{$v->id}',
                            'numeros': '{$v->numeros}',
                            'mensagem': textoenvio,
                            'usuario': ".Yii::$app->user->identity->id."
                        }
                    });
                    $script_interno_disparo
                    alert('Mensagem Enviada com Sucesso!');
                    window.location.reload(true);
                });
            ");
            echo '<br>';
            echo '<br>';
            echo '<br>';
            echo '<br>';
            // echo '<label>Adicionar novo Número</label><br>';
            // echo Editable::widget([
            //     'name'=>'celular_'.$v->id, 
            //     'asPopover' => true,
            //     // 'value' => 'Adicionar',
            //     'displayValue' => 'Add',
            //     'header' => 'Name',
            //     'size'=>'md',
            //     'options' => [
            //         'class' => 'form-control',
            //         'mask' => ['(99)9999-9999','(99)99999-9999']
            //     ],
            //     'inputType' => Editable::INPUT_WIDGET,
            //     'widgetClass' => MaskedInput::className(),
            //     'formOptions' => [
            //         'action' => [
            //             'addcelular',
            //             'id' => $v->id
            //         ]
            //     ],
            // ]);
            // echo '<br>';
            // echo '<br>';
            echo '<label>Adicionar novos Números (separe-os por ";" [ponto-e-vírgula])</label><br>';
            echo Editable::widget([
                'name'=>'celulares_'.$v->id, 
                'asPopover' => true,
                'displayValue' => 'Add Números',
                'submitOnEnter' => false,
                'size'=>'lg',
                'class' => 'info',
                // 'value' => 'Adicionar',
                'header' => 'Adicionar Números',
                // 'size'=>'md',
                'options' => [
                    'class' => 'form-control',
                    'rows' => 10,
                    // 'mask' => ['9']
                ],
                'inputType' => Editable::INPUT_TEXTAREA,
                // 'widgetClass' => MaskedInput::className(),
                'formOptions' => [
                    'action' => [
                        'addcelulares',
                        'id' => $v->id
                    ]
                ],
            ]);
            // echo Select2::widget([
            //     'name'=>'celular_'.$v->id,
            //     'options' => ['placeholder' => 'Select a color ...', 'multiple' => true],
            //     'pluginOptions' => [
            //         'tags' => true,
            //         'tokenSeparators' => [',', ' '],
            //         'maximumInputLength' => 10
            //     ],
            // ]);

            echo '<br>';
            echo '<br>';
            echo '<center>';
            Modal::begin([
                'header' => '<h3>Histórico de Disparos</h3>',
                'toggleButton' => [
                    'label' => '<i class="fa fa-clock"></i> Histórico de Disparos',
                    'class' => 'btn btn-link',
                    'style' => 'align: center; text-transform: uppercase'
                ],
            ]);
            
            $historico = \app\models\Histdispmulti::find()->where([
                'disparos_id' => $v->id
            ])->all();
            echo '<table class="xxtable">';
            echo '<tr class="xxtr">';
            echo '<th class="xxth">Autor</th>';
            echo '<th class="xxth">Disparo</th>';
            echo '<th class="xxth">Números</th>';
            echo '<th class="xxth">Mensagem</th>';
            echo '</tr>';
            foreach($historico as $h) {
                echo '<tr class="xxtr">';
                echo '<td class="xxtd">'.$h->usuario->nome.'</td>';
                echo '<td class="xxtd">'.date('d/m/Y H:i:s', strtotime($h->data)).'</td>';
                $numeros = explode(';', $h->numeros);
                $numeros_string_formatados = "";
                foreach ($numeros as $nm) {
                    if ($nm !== '') {
                        $numeros_string_formatados .= '<span style="white-space: nowrap;">'.$this->context->format_telefone($nm).'</span><br>';
                    }
                }
                echo '<td class="xxtd">'.$numeros_string_formatados.'</td>';
                echo '<td class="xxtd">'.$h->mensagem.'</td>';
                echo '</tr>';
            }
            echo '</table>';

            Modal::end();
            echo '</center>';
            echo '<hr>';
            if (Yii::$app->user->can('administrador')):
                echo Html::a('<i class="fa fa-remove"></i> Eliminar Grupo', ['delete', 'id' => $v->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Ma-ma-maas você está certo disso?',
                        'method' => 'post',
                    ]
                ]);
            endif;   
            echo '</div>'; 
            echo '</div>';    
        ?>
    <?php endforeach; ?>
    </div>
</div>
