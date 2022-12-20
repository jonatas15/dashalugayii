<?php

use yii\helpers\Html;
use yii\grid\GridView;

use yii\bootstrap\Modal;
use kartik\select2\Select2;
use kartik\form\ActiveForm;
use kartik\editable\Editable;
use yii\widgets\MaskedInput;

function dispares($numero) {
    $pessoa = \app\models\Corretor::find()->where([
        'telefone' => $numero
    ])->one();
    return $pessoa->nome;
}
function scriptenvia($telefone, $id, $data) {
    return "
    var textoenvio = $('#textoarea-$id').val();
    $('#textoarea-$id').on('keyup', function(){
        settings_$telefone.data.message_body = $('#textoarea-$id').val();
        // console.log(textoenvio);
    });
    var settings_$telefone = ".'{
        type: "GET",
        url: "'.Yii::$app->homeUrl.'/disparoswh/retornabot?id='.$id.'",
        data: {
            id: '.$id.',
            telefone: "'.$telefone.'"
        }, 
        success: function(result) {
            console.log("sucesso, subscrito: ");
            console.log(result);
            $.ajax({
                type: "GET",
                url: "'.Yii::$app->homeUrl.'/disparoswh/botmensagem?id='.$id.'",
                data: {
                    idboot: result,
                    mensagem: textoenvio
                }, 
                success: function(result) {
                    console.log("mensagem enviada");
                }
            });
        }
    }';
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

$this->title = 'Disparo de mensagem em massa';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .div-card {
        padding: 5%;
        margin: 1%;
        border: 1px solid lightgray;
        border-radius: 5px;
        box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
    }
    /* .xxtable, .xxth, .xxtd {
        border: 1px solid black;
        padding: 5px;
    } */
</style>
<div class="disparoswh-index">

    <!-- <h2 style="text-align: center"><?php //= Html::encode($this->title) ?></h2> -->
    <br>
    <br>
    <div class="col-md-12">
        <?php 
            $corretores_tel = \app\models\Corretor::find()->where([
                'not', ['telefone' => null]
            ])->all();
            foreach ($corretores_tel as $corretor):
                echo '<div class="col-md-3" ><div class="card-corretor">';
                if ($corretor->usuario->foto and file_exists(Yii::$app->basePath.'/web/usuarios/'.$corretor->usuario->foto)) {
                    echo Html::img(Yii::$app->homeUrl.'usuarios/'.$corretor->usuario->foto, ['width' => '50', 'style' => [
                        'border-color' => ($corretor->cor ? $corretor->cor : 'lightgray'),
                        'background-color' => ($corretor->cor ? $corretor->cor : 'lightgray'),
                    ]]);
                } else {
                    echo Html::img(Yii::$app->homeUrl.'usuarios/1211811759.png', ['width' => '50', 'style' => [
                        'border-color' => ($corretor->cor ? $corretor->cor : 'lightgray'),
                        'background-color' => ($corretor->cor ? $corretor->cor : 'lightgray'),
                    ]]);
                }
                echo '<h3><strong>'.$corretor->nome.'</strong>';
                echo '<br><sub>';
                echo $this->context->format_telefone($corretor->telefone);
                echo '</sub>';
                echo '</h3>';
                echo '<div class="col-md-12">';
                Modal::begin([
                    'header' => '<h4 style="text-align: center"><i class="fa fa-whatsapp"></i> Mensagem p/ '.$corretor->nome.'</h4>',
                    'size' => 'modal-md',
                    'options' => [
                        'style' => [
                            'z-index' => '9999999999 !important'
                        ]
                    ],
                    'headerOptions' => [
                        'style' => 'background-color: #075E54; color: white; text-transform: uppercase',
                    ],
                    'bodyOptions' => [
                        'style' => 'background-color: #128C7E; padding: 5%',
                    ],
                    'toggleButton' => [
                        'id' => 'md_corretor_'.$corretor->idcorretor,
                        'label' => '<strong><i class="fa fa-whatsapp"></i> MENSAGEM</strong>',
                        'title' => 'Novo Grupo de Disparo ',
                        'alt' => 'Novo Grupo de Disparo',
                        'class' => 'btn btn-link',
                        'style' => [
                            'float' => 'left',
                            'padding' => '0 5px !important'
                        ],
                    ]
                ]);
                    if ($corretor->usuario->foto and file_exists(Yii::$app->basePath.'/web/usuarios/'.$corretor->usuario->foto)) {
                        echo Html::img(Yii::$app->homeUrl.'usuarios/'.$corretor->usuario->foto, ['width' => '50', 'style' => [
                            'border-color' => ($corretor->cor ? $corretor->cor : 'lightgray')
                        ]]);
                    } else {
                        echo Html::img(Yii::$app->homeUrl.'usuarios/1211811759.png', ['width' => '50', 'style' => [
                            'border-color' => ($corretor->cor ? $corretor->cor : 'lightgray')
                        ]]);
                    }
                    $leads = \app\models\Lead::find()->all();
                    echo '<div class="col-md-12 lista-leads">';
                    echo '<h4><strong>Leads cadastrados</strong></h4>';
                    foreach ($leads as $k => $lead) {
                        echo "<button id='' class='lead-corretor-{$corretor->idcorretor} btn btn-link' title='$lead->descricao'><i class=\"fa fa-ticket\"></i> ";
                        echo $lead->titulo;
                        echo '</button>';
                    }
                    echo '</div>';
                    echo "<textarea id='textoarea-corretor-$corretor->idcorretor' cols='50' rows='6' style='width: 100%; border: 1px solid lightgray; border-radius: 10px;padding:5%;resize: none'></textarea>";
                    echo '<br>';
                    echo '<br>';
                    echo "<button class='btn btn-success float-right' id='botao-whats-corretor-$corretor->idcorretor' style='border-radius: 10px !important; text-transform: uppercase; font-weight: bold'>Enviar <i class='fa fa-send'></i></button>";
                    echo '<br>';
                    $this->registerJs("
                        $('#botao-whats-corretor-".$corretor->idcorretor."').on('click', function() {
                            textoenvio_corretor = $('#textoarea-corretor-$corretor->idcorretor').val();
                            $.ajax({
                                'url': '".Yii::$app->homeUrl."disparoswh/corretorhistorico',
                                'method': 'POST',
                                'data': {
                                    'id': ".$corretor->idcorretor.",
                                    'mensagem': textoenvio_corretor
                                }
                            });
                            // script_interno_disparo
                            $.ajax(
                                {
                                    type: 'GET',
                                    url: '".Yii::$app->homeUrl.'/disparoswh/retornabot?id='.$corretor->idcorretor."',
                                    data: {
                                        id: $corretor->idcorretor,
                                        telefone: '".$corretor->telefone."'
                                    }, 
                                    success: function(result) {
                                        console.log('sucesso, subscrito: ');
                                        console.log(result);
                                        $.ajax({
                                            type: 'GET', 
                                            url: '".Yii::$app->homeUrl.'/disparoswh/botmensagem?id='.$corretor->idcorretor."',
                                            data: {
                                                idboot: result,
                                                mensagem: $('#textoarea-corretor-".$corretor->idcorretor."').val()
                                            }, 
                                            success: function(result) {
                                                console.log('mensagem enviada');
                                            }
                                        });
                                    }
                                }
                            ).done(function (response) {
                                console.log(response);
                            });\n
                            alert('Mensagem Enviada com Sucesso p/ {$corretor->nome}!');
                            window.location.reload(true);
                        });
                        $('.lead-corretor-{$corretor->idcorretor}').on('click', function() {
                            $('#textoarea-corretor-".$corretor->idcorretor."').val($(this).attr('title'))
                        });
                    ");
                    echo '<div class="clearfix"></div>';
                    Modal::end();
                    // echo '<div class="clearfix"></div>';
                    # Botão que Dispara o Lead para o CORRETOR
                    # ==================================================================================================================================
                    echo '
                    <button id="aviso-de-lead-corretor-'.$corretor->idcorretor.'" class="btn btn-link" style="float: right;padding: 0 5px !important;">
                    <strong>Lead <i class="fa fa-bell"></i></strong>
                    </button>';
                    
                /**
                 * 
                 *
                    Olá! Você acaba de receber uma nova oportunidade no Jetimob.

                    Faça contato o mais breve possível 😉

                    Boas vendas! Sucesso! ☕🚀🥇 
                 */
                $this->registerJs("
                    $('#aviso-de-lead-corretor-".$corretor->idcorretor."').on('click', function() {
                        lead_texto_".$corretor->idcorretor." = '' +
                            '🛎️ Olá! Você acaba de receber uma *nova oportunidade* no Jetimob. \\n \\n' +
                            'Faça contato o mais breve possível 😉' +
                            '\\n \\n *Boas vendas! Sucesso!* ☕🚀🥇 📢' +
                        '';
                        $.ajax({
                            'url': '".Yii::$app->homeUrl."disparoswh/corretorhistorico',
                            'method': 'POST',
                            'data': {
                                'id': ".$corretor->idcorretor.",
                                'mensagem': 'Aviso  de LEAD'
                            }
                        });
                        // script_interno_disparo
                        $.ajax(
                            {
                                type: 'GET',
                                url: '".Yii::$app->homeUrl.'/disparoswh/retornabot?id='.$corretor->idcorretor."',
                                data: {
                                    id: $corretor->idcorretor,
                                    telefone: '".$corretor->telefone."'
                                }, 
                                success: function(result) {
                                    console.log('sucesso, subscrito: ');
                                    console.log(result);
                                    $.ajax({
                                        type: 'GET', 
                                        url: '".Yii::$app->homeUrl.'/disparoswh/botmensagem?id='.$corretor->idcorretor."',
                                        data: {
                                            idboot: result,
                                            mensagem: lead_texto_".$corretor->idcorretor."
                                        }, 
                                        success: function(result) {
                                            console.log('mensagem enviada');
                                        }
                                    });
                                }
                            }
                        ).done(function (response) {
                            console.log(response);
                        });\n
                        alert('Mensagem Enviada com Sucesso p/ {$corretor->nome}!');
                        window.location.reload(true);
                    });
                ");
                echo '</div>';
                echo '<div class="clearfix"></div>';
            # Botão que Dispara o Lead para o CORRETOR
            # ==================================================================================================================================
            Modal::begin([
                'header' => '<h3>Histórico de Mensagens p/ '.$corretor->nome.'</h3>',
                'size' => 'modal-lg',
                'options' => [
                    'style' => [
                        'z-index' => '9999999999 !important'
                    ]
                ],
                'toggleButton' => [
                    'label' => '🕗',
                    'class' => 'btn btn-link',
                    'style' => 'align: center; text-transform: uppercase;font-size:30px;top:1px;right: 1px;position: absolute'
                ],
            ]);
                $arr = '{
                    "valores": ['.substr($corretor->historico, 0, -1).']}';
                // $arr = '{data:"",mensagem:"teste de envio individual"},{data:"2022-12-07 14:53:26",mensagem:"Imóvel tal: https://www.cafeimobiliaria.com.br/imovel/2804/venda-casa-4-dormitorios-3-vagas-camobi-santa-maria-rs-destaque"}';
                $arr = json_decode($arr, true);
                echo '<table class="styled-table">';
                foreach ($arr["valores"] as $key => $hist) {
                    echo "<tr>";
                    echo "<td>";
                    echo date('d/m/Y H:i:s', strtotime($hist['data']));
                    echo "</td>";
                    echo "<td>";
                    echo $hist['mensagem'];
                    echo "</td>";
                    echo "</tr>";
                }
                echo '</table>';
            Modal::end();
            echo '</div>';
            echo '</div>';
        endforeach;
        ?>
    </div>
    <div class="clearfix"></div>
    <hr style="border 1px solid gray">
    <div class="col-md-12">
        <h2 style="text-align: center;font-weight: bolder">
            Grupos de Disparos
        </h2>
        <p>
        <?php
            // echo Html::a('Novo Grupo de Disparo', ['create'], ['class' => 'btn btn-success']);
            Modal::begin([
                'header' => '<h3 style="text-align: center">Novo Grupo de Disparo</h3>',
                'size' => 'modal-md',
                'options' => [
                    // 'style' => [
                    //     'z-index' => '2 !important'
                    // ],
                    // 'tabindex' => false
                ],
                'toggleButton' => [
                    'id' => 'md1',
                    'label' => '<strong><i class="fa fa-users"></i> <i class="fa fa-whatsapp"></i> NOVO GRUPO DE DISPARO</strong>',
                    'title' => 'Novo Grupo de Disparo ',
                    'alt' => 'Novo Grupo de Disparo',
                    'class' => 'btn btn-primary',
                ],
            ]);
            //Clientes e seus números
            // $pretendentes = \app\models\SloProposta::find()->all();
            // $data = [];
            // foreach ($pretendentes as $k => $v) {
            //     $data[$v->proponente->sloInfospessoais->celular] = $v->proponente->sloInfospessoais->nome.': '.$this->context->format_telefone($v->proponente->sloInfospessoais->celular);
            // }
            // echo '<pre>';
            // print_r($data);
            // echo '</pre>';

            $corretores = \app\models\Corretor::find()->all();
            $data = [];
            foreach ($corretores as $k => $v) {
                if($v->telefone) {
                    $data[$v->telefone] = $v->nome.': '.$this->context->format_telefone($v->telefone);
                }
            }

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
                    'multiple' => true,
                    'style' => 'z-index:99999999999999 !important'
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
        <?php foreach ($dataProvider->models as $key => $v): ?>
            <?php
                echo '<div class="col-md-6">';
                echo '<div class="div-card">';    
                echo "<h4 style='font-weight: bold; text-transform: uppercase'>{$v->titulo}";
                Modal::begin([
                    'header' => '<h3 style="text-align: center"><i class="fa fa-whatsapp"></i> Disparar Mensagem</h3>',
                    'size' => 'modal-md',
                    'options' => [
                        'style' => [
                            'z-index' => '9999999999 !important'
                        ]
                    ],
                    'headerOptions' => [
                        'style' => 'background-color: #075E54; color: white; text-transform: uppercase',
                    ],
                    'bodyOptions' => [
                        'style' => 'background-color: #128C7E; padding: 5%',
                    ],
                    'toggleButton' => [
                        'id' => 'md_'.$v->id,
                        'label' => '<strong><i class="fa fa-whatsapp"></i> MENSAGEM</strong>',
                        'title' => 'Novo Grupo de Disparo ',
                        'alt' => 'Novo Grupo de Disparo',
                        'class' => 'btn btn-success',
                        'style' => 'float: right;margin-bottom: 20px'
                    ]
                ]);
                    $leads = \app\models\Lead::find()->all();
                    echo '<div class="col-md-12 lista-leads">';
                    echo '<h4><strong>Leads cadastrados</strong></h4>';
                    foreach ($leads as $k => $lead) {
                        echo "<button id='' class='lead-grupo-{$v->id} btn btn-link' title='$lead->descricao'><i class=\"fa fa-ticket\"></i> ";
                        echo $lead->titulo;
                        echo '</button>';
                    }
                    echo '</div>';
                    echo "<textarea id='textoarea-$v->id' cols='50' rows='6' style='width: 100%; border: 1px solid lightgray; border-radius: 10px;padding:5%;resize: none'></textarea>";
                    echo '<br>';
                    echo '<br>';
                    echo "<button class='btn btn-success float-right' id='botao-whats-$v->id' style='border-radius: 10px !important; text-transform: uppercase; font-weight: bold'>Disparar em Massa <i class='fa fa-send'></i></button>";
                    echo '<br>';
                    echo '<div class="clearfix"></div>';
                Modal::end();
                echo "</h4>";
                echo "<br>";
                echo "<br>";
                echo "<br>";
                echo "<br>";
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
                        echo '<div class="col-md-12"><hr style="margin:5px;border-color: lightgray"></div>';
                        // echo '<pre>';
                        // print_r($data);
                        // echo '</pre>';
                        $this->registerJs(scriptenvia($n, $v->id, $data));
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
                    $('.lead-grupo-{$v->id}').on('click', function() {
                        $('#textoarea-".$v->id."').val($(this).attr('title'))
                    });
                ");
                echo '<br>';
                echo '<br>';
                echo '<br>';
                echo '<br>';
                
                echo '<label>Adicionar novos Números (separe-os por ";" [ponto-e-vírgula])</label><br>';
                echo Editable::widget([
                    'name'=>'celulares_'.$v->id, 
                    'asPopover' => false,
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
                        'cols' => 50,
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
                    'size' => 'modal-lg',
                    'options' => [
                        'style' => [
                            'z-index' => '9999999999 !important'
                        ]
                    ],
                    'toggleButton' => [
                        'label' => '🕗 Histórico de Disparos',
                        'class' => 'btn btn-link',
                        'style' => 'align: center; text-transform: uppercase'
                    ],
                ]);
                
                $historico = \app\models\Histdispmulti::find()->where([
                    'disparos_id' => $v->id
                ])->all();
                echo '<table class="styled-table">';
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
                echo '<hr style="border-color: lightgray">';
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
<style>
    .card-corretor {
        padding: 1% !important;
        border: 1px solid lightgray;
        border-radius: 5px;
        box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
        margin-bottom: 30px;
        text-align: center;
    }
    .card-corretor img {
        border-radius: 50%;
        border: 3px solid lightgray;
        box-shadow: 2px 2px 2px 1px rgba(0, 0, 0, 0.2);
        width: 50px;
        height: 50px;
        position: absolute;
        top: -20px;
        left: -8px;
        background-color: white;
    }
    .lista-leads {
        border-radius: 10px;
        border: 2px solid lightgray;
        margin-bottom: 10px;
        padding: 5px;
        text-align: center !important;
    }
    .lista-leads button {
        color: lime !important;
    } 
    .lista-leads h4 {
        color: lime !important;
    }
    .styled-table {
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9em;
        font-family: sans-serif;
        min-width: 400px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    }
    .styled-table thead tr {
        background-color: #009879;
        color: #ffffff;
        text-align: left;
    }
    .styled-table th, .styled-table td {
        padding: 12px 15px;
    }
    .styled-table tbody tr {
        border-bottom: 1px solid #dddddd;
    }

    .styled-table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .styled-table tbody tr:last-of-type {
        border-bottom: 2px solid #009879;
    }

    .styled-table tbody tr.active-row {
        font-weight: bold;
        color: #009879;
    }
    .close {
        float: left !important;
        position: absolute !important;
    }
</style>
