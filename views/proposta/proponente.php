<?php 

use yii\bootstrap\Modal;
use kartik\editable\Editable;
use yii\widgets\MaskedInput;

    $pessoa = $model;
    $docmto = $model;
    $profis = $model;
    $propos = $model;
    $arques = $model->maisarquivos;
    
    function imprime_campo($tabela, $campo, $title, $valor, $id, $conj = null) {
        $input = Editable::INPUT_TEXT;
        $editableoptions = [
                'class'=>'form-control',
        ];
        $widgetClass = '';

        if (in_array($campo,['data', 'data_nascimento', 'data_expedicao', 'documento_data_emissao', 'data_admissao'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '99/99/9999'
            ];
            $widgetClass = MaskedInput::className();
        }
        if (in_array($campo,['cpf', 'conj_cpf'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '999.999.999-99',
                'value' => $valor
            ];
            $widgetClass = MaskedInput::className();
        }
        if (in_array($campo,['cep', 'end_cep'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '99.999-999'
            ];
            $widgetClass = MaskedInput::className();
        }
        if (in_array($campo,['celular', 'telefone_celular', 'whatsapp', 'telefone', 'fone', 'telefone_residencial','fone_residencial', 'fone_celular'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => ['(99)9999-9999','(99)99999-9999']
            ];
            $widgetClass = MaskedInput::className();
        }

        $retorno = '<label>'.$title.'</label><br />';
        $retorno .= Editable::widget([
            'language' => 'pt_BR',
            'name'=> $campo, 
            'asPopover' => false,
            'value' => $valor,
            'displayValue' => $valor,
            'header' => 'Name',
            'size'=>'md',
            'options' => $editableoptions,
            'inputType' => $input,
            'widgetClass' => $widgetClass,
            'id' => ($conj?'conjuge_':'').$tabela.'_invisivel_'.$campo,
            'formOptions' => [
                'action' => [
                    'editcampo',
                    'id' => $id,
                    'tabela' => $tabela,
                    'campo' => $campo
                ]
            ],
            'valueIfNull' => 'valor alterado'
        ]);
        $retorno .= "<br>";
        $retorno .= "<br>";
        $retorno .= "<br>";
        return $retorno;
    }
?>
<style>
    .item-campo {
        height: 85px !important;
    }
    .item-interno-proposta {
        margin: 5px !important;
    }
    .item-campo input:focus {
        border: none !important;
        outline: none !important;
        /* background-color: yellow !important; */
    }
    .card {
        z-index: 4 !important;
    }
    .kv-editable-value {
        font-size: 14px !important;
        font-weight: bold !important;
    }
</style>
<div class="clearfix"><br /></div>
<div class="col-md-12" style="background-color: white !important;">
    <!-- <div class="col-md-6">
    <div class="item-interno-proposta"> -->
        <!-- <h3 class="titulo text-center uppercase">Informações Pessoais</h3>
        <hr> -->
        <?php 
            $arr_campos_retirados = [
                'id',
                'tipo',
                'prazo_responder',
                'proprietario',
                'proprietario_info',
                'codigo_imovel',
                'imovel_info',
                'imovel_valores',
                'opcoes',
                'usuario_id',
                'tipo_imovel',
                'motivo_locacao',
                'endereco',
                'complemento',
                'bairro',
                'cidade',
                'estado',
                'cep',
                'dormitorios',
                'aluguel',
                'iptu',
                'condominio',
                'agua',
                'luz',
                'gas_encanado',
                'total',
                'numero',
                'atvc_empresa',
                'atvc_cnpj',
                'atvc_nome_fantasia',
                'atvc_atividade',
                'atvc_data_constituicao',
                'atvc_contato',
                'atvc_telefone',
                'data_inicio',
                'id_slogica',
                'etapa_andamento',
                'codigo',
                'conj_nome',
                'conj_email',
                'conj_cpf',
                'conj_documento_tipo',
                'conj_documento_numero',
                'conj_nacionalidade',
                'conj_data_nascimento',
                'conj_telefone_celular',
                'conj_profissao',
                'conj_renda',
                'conj_num_dependentes',
                'conj_frente',
                'conj_verso',
                'frente',
                'verso',
                'proponentes',
                'naoLocalizado',
                'condicao_do_imovel',
                'telefone'
            ];
            switch ($model->tipo) {
                case 'credpago': array_push($arr_campos_retirados,'idsapo');
            }
            //Seção 1 --------------------------------------------------------------------
            echo '<div class="col-md-6">
            <div class="item-interno-proposta col-md-12">';
            $i = 1;
            foreach ($pessoa as $key => $value) {
                if (!in_array($key,$arr_campos_retirados)):
                    switch ($key) {
                        case 'end_cep': $valor = $this->context->format_doc($value,'cep'); break;
                        case 'cep': $valor = $this->context->format_doc($value,'cep'); break;
                        case 'cpf': $valor = $this->context->format_doc($value,'cpf'); break;
                        case 'telefone': $valor = $this->context->format_telefone($value); break;
                        case 'celular': $valor = $this->context->format_telefone($value); break;
                        case 'fone_residencial': $valor = $this->context->format_telefone($value); break;
                        case 'data_nascimento': $valor = date('d/m/Y',strtotime($value)); break;
                        case 'documento_data_emissao': $valor = date('d/m/Y',strtotime($value)); break;
                        case 'data_admissao': $valor = date('d/m/Y',strtotime($value)); break;
                        case 'genero': $valor = $value=='M'?'Masculino':'Feminino'; break;
                        default: $valor = $value; break;
                    }
                    echo '<div class="item-campo col-md-10">';
                    // echo "<= $key =><br>";
                    echo imprime_campo('SloProposta', $key, $pessoa->getAttributeLabel($key),$valor, $pessoa->id);
                    echo '</div>';
                    echo '<div class="item-campo col-md-2">';
                    // echo '<button class="urlx btn btn-info" value="sapos pulam muito">';
                    // echo 'Copiar  ';
                    // // echo '<input class="inputcopiado" type="text" id="url" value="'.$valor.'" style="border: 0px; color: white; background-color: #00c0ef; cursor: pointer"  />';
                    // echo '<br><span style="color: white; font-size: 16px; font-weight: bold"></span>';
                    // echo '</button>';
                    // echo '<p id="invisivel_'.$key.'" style="display: none">'.$valor.'</p>';
                    echo '<br><button title="Copiar" alt="Copiar" class="btn btn-primary" style="color: white !important; padding: 5px 15px" onClick="copyToClipboard(\'#SloProposta_invisivel_'.$key.'-targ\')"><span class="glyphicon glyphicon-copy"></span></button>';
                    echo '</div>';
                    if ($i%4==0 and $i < 16) {
                        echo '</div></div><div class="col-md-6"><div class="item-interno-proposta col-md-12">';
                    }
                    $total++;
                    $i++;
                endif;
            }
            echo '</div></div>';
            echo '<div class="clearfix"></div>';
            //Seção 2 --------------------------------------------------------------------
            if ($docmto->estado_civil == "Casado"):
                echo '<div class="col-md-12"><hr>
                <h3><center><strong>Cônjuge:</strong></center></h3>
                </div>';
                echo '<div class="col-md-4">
                <div class="item-interno-proposta col-md-12">';
                $i = 1;
                $arr_campos_conjuge = [
                    'conj_nome',
                    'conj_email',
                    'conj_cpf',
                    'conj_documento_tipo',
                    'conj_documento_numero',
                    'conj_nacionalidade',
                    'conj_data_nascimento',
                    'conj_telefone_celular',
                    'conj_profissao',
                    'conj_renda',
                    'conj_num_dependentes',
                ];
                foreach ($pessoa as $key => $value) {
                    if (in_array($key,$arr_campos_conjuge)):
                        switch ($key) {
                            case 'end_cep': $valor = $this->context->format_doc($value,'cep'); break;
                            case 'cep': $valor = $this->context->format_doc($value,'cep'); break;
                            case 'conj_cpf': $valor = $this->context->format_doc($value,'cpf'); break;
                            case 'telefone': $valor = $this->context->format_telefone($value); break;
                            case 'conj_telefone_celular': $valor = $this->context->format_telefone($value); break;
                            case 'fone_residencial': $valor = $this->context->format_telefone($value); break;
                            case 'conj_data_nascimento': $valor = date('d/m/Y',strtotime($value)); break;
                            case 'genero': $valor = $value=='M'?'Masculino':'Feminino'; break;
                            default: $valor = $value; break;
                        }
                        echo '<div class="item-campo col-md-9">';
                        echo imprime_campo('SloProposta', $key, $pessoa->getAttributeLabel($key),$valor, $pessoa->id);
                        echo '</div>';
                        echo '<div class="item-campo col-md-2">';
                        echo '<br><button title="Copiar" alt="Copiar" class="btn btn-primary" style="color: white !important; padding: 5px 15px" onClick="copyToClipboard(\'#SloProposta_invisivel_'.$key.'-targ\')"><span class="glyphicon glyphicon-copy"></span></button>';
                        echo '</div>';
                        if ($i%4==0)
                            echo '</div></div><div class="col-md-4"><div class="item-interno-proposta col-md-12">';
                        $i++;
                    endif;
                }
                echo '</div></div>';
                echo '<div class="clearfix"></div>';
            endif;
            //Seção 3 PROPONENTES --------------------------------------------------------------------
            if ($model->proponentes) {
                $modelproponentes = json_decode($model->proponentes);
                // echo '<pre>';
                // print_r(json_decode($model->proponentes));
                // echo '</pre>';
                echo '<div class="col-md-12"><hr>
                <h3><center><strong>Proponentes:</strong></center></h3>
                </div>';
                echo '<div class="col-md-4">
                <div class="item-interno-proposta col-md-12">';
                
                foreach ($modelproponentes as $v) {
                    echo('<b>Nome: </b>'.$v->nome.'<br>');
                    echo('<b>CPF: </b>'.$v->cpf.'<br>');
                    echo('<b>Telefone Fixo: </b>'.$v->telefone_fixo.'<br>');
                    echo('<b>Celular: </b>'.$v->telefone_celular.'<br>');
                    echo('<b>Email: </b>'.$v->email.'<br>');
                    echo('<b>Renda: </b>'.$v->renda.'<br>');
                    echo('<b>Estado Civil: </b>'.$v->estado_civil.'<br>');
                    echo('<b>Vínculo Empregatício: </b>'.$v->vinculo_empregaticio.'<br>');
                    echo '</div></div><div class="col-md-4"><div class="item-interno-proposta col-md-12">';
                }
                echo '</div></div>';
                echo '<div class="clearfix"></div>';
            }
            //Seção 5 --------------------------------------------------------------------

            $prefixo_nome_arquivo = $this->context->clean($model->cpf);
            
            if (count($docmto) > 0){
                $frente_doc = Yii::$app->homeUrl.'/uploads/_frente_'.$prefixo_nome_arquivo.'_'.$docmto->frente;
                $verso_doc = Yii::$app->homeUrl.'/uploads/_verso_'.$prefixo_nome_arquivo.'_'.$docmto->verso;
                echo '<h4><strong>Arquivos da Documentação</strong></h4> <hr>';
                
                echo '<div class="col-md-3">';
                    Modal::begin([
                        'header' => '',
                        'toggleButton' => [
                            'label' => (pathinfo($frente_doc, PATHINFO_EXTENSION) == 'pdf' ? '<i class="fas fa-file-pdf" style="font-size: 25px"></i>' : '<img src="'.$frente_doc.'" style="width: auto;max-width: 100%;max-height: 120px;">').'<hr>'."<strong>Frente do Documento</strong>",
                            'class' => 'btn',
                            'style' => 'margin-bottom: 12px;width:100%;height:180px;'
                        ],
                    ]);
                        if (pathinfo($frente_doc, PATHINFO_EXTENSION) == 'pdf'){
                            echo '<div>
                                    <object data="'.$frente_doc.'" type="application/pdf" width="550" height="500">
                                        alt : <a href="'.$frente_doc.'">test.pdf</a>
                                    </object>
                                </div>';
                        } else {
                            echo '<img src="'.$frente_doc.'" style="width: 100%;">';
                        }
                    Modal::end();
                echo '</div>';
                echo '<div class="col-md-3">';
                    Modal::begin([
                        'header' => '',
                        'toggleButton' => [
                            'label' => (pathinfo($verso_doc, PATHINFO_EXTENSION) == 'pdf' ? '<i class="fas fa-file-pdf" style="font-size: 25px"></i>' : '<img src="'.$verso_doc.'" style="width: auto;max-width: 100%;max-height: 120px;">').'<hr>'."<strong>Verso do Documento</strong>",
                            'class' => 'btn',
                            'style' => 'margin-bottom: 12px;width:100%;height:180px;'
                        ],
                    ]);
                    if (pathinfo($verso_doc, PATHINFO_EXTENSION) == 'pdf'){
                        echo '<div>
                                <object data="'.$verso_doc.'" type="application/pdf" width="550" height="500">
                                    alt : <a href="'.$verso_doc.'">test.pdf</a>
                                </object>
                            </div>';
                    } else {
                        echo '<img src="'.$verso_doc.'" style="width: 100%;">';
                    }
                    Modal::end();
                echo '</div>';
                if ($docmto->estado_civil == "Casado") {

                    $conj_frente_doc = Yii::$app->homeUrl.'/uploads/_conj_frente_'.$prefixo_nome_arquivo.'_'.$docmto->conj_frente;
                    $conj_verso_doc = Yii::$app->homeUrl.'/uploads/_conj_verso_'.$prefixo_nome_arquivo.'_'.$docmto->conj_verso;

                    echo '<div class="col-md-3">';
                    Modal::begin([
                        'header' => '',
                        'toggleButton' => [
                            'label' => (pathinfo($conj_frente_doc, PATHINFO_EXTENSION) == 'pdf' ? '<i class="fas fa-file-pdf" style="font-size: 25px"></i>' : '<img src="'.$conj_frente_doc.'" style="width: auto;max-height: 120px;">').'<hr>'."<strong>Cônjuge: Frente do Documento</strong>",
                            'class' => 'btn',
                            'style' => 'margin-bottom: 12px;width:100%'
                        ],
                        ]);
                        if (pathinfo($conj_frente_doc, PATHINFO_EXTENSION) == 'pdf'){
                            echo '<div>
                                    <object data="'.$conj_frente_doc.'" type="application/pdf" width="550" height="500">
                                        alt : <a href="'.$conj_frente_doc.'">test.pdf</a>
                                    </object>
                                </div>';
                        } else {
                            echo '<img src="'.$conj_frente_doc.'" style="width: 100%;">';
                        }
                    Modal::end();
                    echo '</div>';
                
                    echo '<div class="col-md-3">';
                    Modal::begin([
                        'header' => '',
                        'toggleButton' => [
                            'label' => (pathinfo($conj_verso_doc, PATHINFO_EXTENSION) == 'pdf' ? '<i class="fas fa-file-pdf" style="font-size: 25px"></i>' : '<img src="'.$conj_verso_doc.'" style="width: auto;max-height: 120px;">').'<hr>'."<strong>Cônjuge: Verso do Documento</strong>",
                            'class' => 'btn',
                            'style' => 'margin-bottom: 12px;width:100%'
                        ],
                    ]);
                    if (pathinfo($conj_verso_doc, PATHINFO_EXTENSION) == 'pdf'){
                        echo '<div>
                                <object data="'.$conj_verso_doc.'" type="application/pdf" width="550" height="500">
                                    alt : <a href="'.$conj_verso_doc.'">test.pdf</a>
                                </object>
                            </div>';
                    } else {
                        echo '<img src="'.$conj_verso_doc.'" style="width: 100%;">';
                    }
                    Modal::end();
                    echo '</div>';

                }
            }
            //Seção 5 --------------------------------------------------------------------
            echo '<div class="clearfix"></div><br><br>';
            //Seção 6 --------------------------------------------------------------------
            if (count($arques) > 0){
                echo '<h4><strong>Mais Documentos</strong></h4> <hr>';
                
                foreach ($arques as $key => $value) {
                    if (!in_array($key,['id','pretendente_id']) and $value != null) {
                        echo '<div class="col-md-3">';
                        Modal::begin([
                            'header' => '<h3>'.$arques->getAttributeLabel($key).'</h3>',
                            'toggleButton' => [
                                'label' => (pathinfo($value, PATHINFO_EXTENSION) == 'pdf' ? '<i class="fas fa-file-pdf" style="font-size: 118px"></i>'.'<hr>'."<strong>".$arques->getAttributeLabel($key)."</strong>" : '<img src="/'.$value.'" style="width: auto;max-height: 120px;"><hr>'."<strong>".$arques->getAttributeLabel($key)."</strong>"),
                                'class' => 'btn',
                                'style' => 'margin-bottom: 12px; width: 100%'
                            ],
                        ]);
                        if (pathinfo($value, PATHINFO_EXTENSION) == 'pdf'){
                            echo '<div>
                                    <object data="/'.$value.'" type="application/pdf" width="550" height="500">
                                        alt : <a href="/'.$value.'">test.pdf</a>
                                    </object>
                                </div>';
                        } else {
                            echo '<img src="/'.$value.'" style="width: 100%">';
                        }

                        Modal::end();
                        echo '</div>';
                    }
                }
            }
            //Seção 6 --------------------------------------------------------------------
            // echo "<pre>";
            // print_r($docmto->conjuge);
            // echo "</pre>";
            
            
        ?>
    <!-- </div>
    </div> -->
    <?= '<div class="clearfix"></div>'; ?>
</div>
<?php 
    $this->registerJs('
        $(".urlx").click(function(){
            $(this).find("input").select();
            document.execCommand(\'copy\');
            $(this).find("span").html("<br>Valor copiado com Sucesso!");
        });
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
        }
    ');
?>
<script>
    function copyToClipboard(element) {
        // alert("sap")
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
        createAutoClosingAlert('Copiado para a área de transferência!', 2000);
        // let myGreeting = setTimeout(function sayHi() {
        //     alert('Hello, Mr. Universe!');
        // }, 2000);
    }
    // function createAutoClosingAlert(selector, delay) {
    //     alert("viu?????");
    //     var alert = $(selector).alert();
    //     window.setTimeout(function() { alert.alert('close') }, delay);
    // }
    function createAutoClosingAlert (msg,duration) {
        var el = document.createElement("div");
        el.setAttribute("style","position:fixed;top:40%;left:45%;background-color:rgba(255,0,255, 0.7);font-size:14px;color:white;font-weight: bold;padding:20px;border-radius:20px;");
        el.innerHTML = msg;
        setTimeout(function(){
        el.parentNode.removeChild(el);
        },duration);
        document.body.appendChild(el);
    }
</script>