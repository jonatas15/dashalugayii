<?php 

use yii\bootstrap\Modal;
use kartik\editable\Editable;
use yii\widgets\MaskedInput;

    $pessoa = $model->sloInfospessoais;
    $docmto = $model->sloContratodocumentos;
    $profis = $model->sloInfosprofissionais;
    $propos = $model->maisproponentes;
    $arques = $model->maisarquivos;
    
    function imprime_campo($tabela, $campo, $title, $valor, $id, $conj = null) {
        $input = Editable::INPUT_TEXT;
        $editableoptions = [
                'class'=>'form-control',
        ];
        $widgetClass = '';

        if (in_array($campo,['data', 'data_nascimento', 'data_expedicao'])) {
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
</style>
<div class="clearfix"><br /></div>
<div class="col-md-12">
    <!-- <div class="col-md-6">
    <div class="item-interno-proposta"> -->
        <!-- <h3 class="titulo text-center uppercase">Informações Pessoais</h3>
        <hr> -->
        <?php 
            $arr_campos_retirados = [
                'id','pretendente_id','conjuje_id','slo_fiador_id','slo_fiadorconjuge_id',
                'extrangeiro_temponopais',
                'possui_renda','vai_morar','emancipado','numero_dependentes',
                'tipo_documento',
                'numero_documento',
                'orgao_emissor',
                'data_emissao',
                'profissao',
                'renda_mensal',
                'cep',
                'endereco_atual',
                'numero',
                'complemento',
                'bairro',
                'cidade',
                'estado',
                'condicao_imovel',
                'estado_civil',
                'fone_residencial',
                'nacionalidade',
                'nome_pai',
                'nome_mae',
                'genero'
            ];
            $arr_campos_retirados_docs = [
                'nome_conjuge',
                'id_conjuge_pretendente',
                'conj_nome',
                'conj_mail',
                'conj_cpf',
                'slo_pretendente_id',
                'id',
                'selfie_documento',
                'frente_documento',
                'verso_documento',
                'selfie_com_documento',
                'outros_comprovantes',
                'orgao_expedidor'
            ];
            $arr_campos_retirados_docs_conj = [
                'id_conjuge_pretendente',
                'slo_pretendente_id',
                'id',
                'selfie_documento',
                'endereco_atual',
                'endereco',
                'end_numero',
                'end_cidade',
                'end_cep',
                'end_complemento',
                'end_bairro',
                'end_estado',
                'estado_civil',
                'nome_conjuge',
                'selfie_documento',
                'frente_documento',
                'verso_documento',
                'selfie_com_documento',
                'outros_comprovantes',
                'orgao_expedidor'
            ];
            switch ($model->proposta->tipo) {
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
                        case 'celular': $valor = $this->context->format_telefone($value); break;
                        case 'fone_residencial': $valor = $this->context->format_telefone($value); break;
                        case 'data_nascimento': $valor = date('d/m/Y',strtotime($value)); break;
                        case 'genero': $valor = $value=='M'?'Masculino':'Feminino'; break;
                        default: $valor = $value; break;
                    }
                    echo '<div class="item-campo col-md-10">';
                    // echo "<= $key =><br>";
                    echo imprime_campo('SloInfospessoais', $key, $pessoa->getAttributeLabel($key),$valor, $pessoa->id);
                    echo '</div>';
                    echo '<div class="item-campo col-md-2">';
                    // echo '<button class="urlx btn btn-info" value="sapos pulam muito">';
                    // echo 'Copiar  ';
                    // // echo '<input class="inputcopiado" type="text" id="url" value="'.$valor.'" style="border: 0px; color: white; background-color: #00c0ef; cursor: pointer"  />';
                    // echo '<br><span style="color: white; font-size: 16px; font-weight: bold"></span>';
                    // echo '</button>';
                    // echo '<p id="invisivel_'.$key.'" style="display: none">'.$valor.'</p>';
                    echo '<br><button title="Copiar" alt="Copiar" class="btn btn-info" onClick="copyToClipboard(\'#SloInfospessoais_invisivel_'.$key.'-targ\')"><i class="fas fa-copy"></i></button>';
                    echo '</div>';
                    if ($i%3==0)
                        echo '</div></div><div class="col-md-6"><div class="item-interno-proposta col-md-12">';
                    $i++;
                endif;
            }
            echo '</div></div>';
            //Seção 1 --------------------------------------------------------------------
            //Seção 2 --------------------------------------------------------------------
            echo '<div class="col-md-12"></div>';
            //Seção 2 --------------------------------------------------------------------
            //Seção 3 --------------------------------------------------------------------
            echo '<div class="col-md-6">
            <div class="item-interno-proposta col-md-12">';
            echo "<h4><strong>Mais Informações e Documentação</strong></h4><hr>";
            $k = 1;
            if (count($docmto) > 0){
                foreach ($docmto as $key => $value) {
                    if (!in_array($key,$arr_campos_retirados_docs)):
                        switch ($key) {
                            case 'end_cep': $valor = $this->context->format_doc($value,'cep'); break;
                            case 'cep': $valor = $this->context->format_doc($value,'cep'); break;
                            case 'cpf': $valor = $this->context->format_doc($value,'cpf'); break;
                            case 'celular': $valor = $this->context->format_telefone($value); break;
                            case 'fone_celular': $valor = $this->context->format_telefone($value); break;
                            case 'fone_residencial': $valor = $this->context->format_telefone($value); break;
                            case 'data_nascimento': $valor = date('d/m/Y',strtotime($value)); break;
                            case 'data_expedicao': $valor = date('d/m/Y',strtotime($value)); break;
                            case 'genero': $valor = $value=='M'?'Masculino':'Feminino'; break;
                            default: $valor = $value; break;
                        }
                        echo '<div class="item-campo col-md-10">';
                        // echo "<= $key =><br>";
                        echo imprime_campo('SloContratodocumento', $key, $docmto->getAttributeLabel($key),$valor, $docmto->id);
                        echo '</div>';
                        echo '<div class="item-campo col-md-2">';
                        echo '<br><button title="Copiar" alt="Copiar" class="btn btn-info" onClick="copyToClipboard(\'#SloContratodocumento_invisivel_'.$key.'-targ\');"><i class="fas fa-copy"></i></button>';
                        echo '</div>';
                        // echo '<span id="alerta_invisivel_'.$key.'" class="alert-message">Copiado para a área de transferência</span>';
                        // echo '<div class="col-md-12">';
                        // echo '</div>';
                        // if ($k%11==0)
                        //     echo '</div></div><div class="col-md-6"><div class="item-interno-proposta">';
                        // $k++;
                    endif;
                }
            }
            echo "</div></div>";
            //     echo "</div></div>";
            if ($docmto->estado_civil == 'Casado' && $docmto->conjuge->conj_nome != ''){
                $j = 1;
                echo '<div class="col-md-6">
                <div class="item-interno-proposta col-md-12">';
                echo "<h4><strong>Cônjuge: {$docmto->conjuge->conj_nome}</strong></h4><hr>";
                
                foreach ($docmto->conjuge as $key => $value) {
                    if (!in_array($key,$arr_campos_retirados_docs_conj)):
                        switch ($key) {
                            case 'conj_cpf': $valor = $this->context->format_doc($value,'cpf'); break;
                            case 'celular': $valor = $this->context->format_telefone($value); break;
                            case 'fone_celular': $valor = $this->context->format_telefone($value); break;
                            case 'fone_residencial': $valor = $this->context->format_telefone($value); break;
                            case 'data_nascimento': $valor = date('d/m/Y',strtotime($value)); break;
                            case 'genero': $valor = $value=='M'?'Masculino':'Feminino'; break;
                            case 'data_expedicao': $valor = date('d/m/Y',strtotime($value)); break;
                            default: $valor = $value; break;
                        }
                        echo '<div class="item-campo col-md-10">';
                        // echo "<= $key =><br>";
                        echo imprime_campo('SloContratodocumento', $key, $docmto->getAttributeLabel($key),$valor, $docmto->conjuge->id, 'conj');
                        echo '</div>';
                        echo '<div class="item-campo col-md-2">';
                        echo '<br><button title="Copiar" alt="Copiar" class="btn btn-info" onClick="copyToClipboard(\'#conjuge_SloContratodocumento_invisivel_'.$key.'-targ\')"><i class="fas fa-copy"></i></button>';
                        echo '</div>';
                        
                    endif;
                }
                echo "</div></div>";
                
            }
            
            //Seção 3 --------------------------------------------------------------------
            //Seção 4 --------------------------------------------------------------------
            if (count($propos) > 0){
                $j = 1;
                echo '<div class="col-md-6">
                <div class="item-interno-proposta">';
                echo "<h4><strong>Mais Proponentes</strong></h4><hr>";
                
                foreach ($propos as $item) {
                    foreach ($item as $key => $value) {
                        if (!in_array($key,['id','telefone_fixo','pretendente_id'])):
                            switch ($key) {
                                case 'cpf': $valor = $this->context->format_doc($value,'cpf'); break;
                                case 'celular': $valor = $this->context->format_telefone($value); break;
                                case 'telefone_celular': $valor = $this->context->format_telefone($value); break;
                                case 'telefone_residencial': $valor = $this->context->format_telefone($value); break;
                                case 'data_nascimento': $valor = date('d/m/Y',strtotime($value)); break;
                                case 'genero': $valor = $value=='M'?'Masculino':'Feminino'; break;
                                default: $valor = $value; break;
                            }
                            echo '<div class="item-campo">';
                            // echo "<= $key =><br>";
                            echo imprime_campo('proponente', $key, $item->getAttributeLabel($key),$valor, $propos->id);
                            echo '</div>';
                            
                        endif;
                    }
                    echo '<br>';
                }
                echo "</div></div>";
            }
            //Seção 4 --------------------------------------------------------------------
            echo '<div class="clearfix"></div>';
            //Seção 5 --------------------------------------------------------------------
            
            if (count($docmto) > 0){
                echo '<h4><strong>Arquivos da Documentação</strong></h4> <hr>';
                
                echo '<div class="col-md-3">';
                    Modal::begin([
                        'header' => '<h3>Proponente: Frente do Documento</h3>',
                        'toggleButton' => [
                            'label' => (pathinfo($docmto->frente_documento, PATHINFO_EXTENSION) == 'pdf' ? '<i class="fas fa-file-pdf" style="font-size: 25px"></i>' : '<img src="/'.$docmto->frente_documento.'" style="width: auto;max-height: 120px;">').'<hr>'."<strong>Frente do Documento</strong>",
                            'class' => 'btn',
                            'style' => 'margin-bottom: 12px;width:100%'
                        ],
                    ]);
                        if (pathinfo($docmto->frente_documento, PATHINFO_EXTENSION) == 'pdf'){
                            echo '<div>
                                    <object data="/'.$docmto->frente_documento.'" type="application/pdf" width="550" height="500">
                                        alt : <a href="/'.$docmto->frente_documento.'">test.pdf</a>
                                    </object>
                                </div>';
                        } else {
                            echo '<img src="/'.$docmto->frente_documento.'" style="width: 100%;">';
                        }
                    Modal::end();
                echo '</div>';
                echo '<div class="col-md-3">';
                    Modal::begin([
                        'header' => '<h3>Proponente: Verso do Documento</h3>',
                        'toggleButton' => [
                            'label' => (pathinfo($docmto->verso_documento, PATHINFO_EXTENSION) == 'pdf' ? '<i class="fas fa-file-pdf" style="font-size: 25px"></i>' : '<img src="/'.$docmto->verso_documento.'" style="width: auto;max-height: 120px;">').'<hr>'."<strong>Verso do Documento</strong>",
                            'class' => 'btn',
                            'style' => 'margin-bottom: 12px;width:100%'
                        ],
                    ]);
                    if (pathinfo($docmto->verso_documento, PATHINFO_EXTENSION) == 'pdf'){
                        echo '<div>
                                <object data="/'.$docmto->verso_documento.'" type="application/pdf" width="550" height="500">
                                    alt : <a href="/'.$docmto->verso_documento.'">test.pdf</a>
                                </object>
                            </div>';
                    } else {
                        echo '<img src="/'.$docmto->verso_documento.'" style="width: 100%;">';
                    }
                    Modal::end();
                echo '</div>';
                if ($docmto->estado_civil == "Casado") {

                    echo '<div class="col-md-3">';
                    Modal::begin([
                        'header' => '<h3>Cônjuge: Frente do Documento</h3>',
                        'toggleButton' => [
                            'label' => (pathinfo($docmto->conjuge->frente_documento, PATHINFO_EXTENSION) == 'pdf' ? '<i class="fas fa-file-pdf" style="font-size: 25px"></i>' : '<img src="/'.$docmto->conjuge->frente_documento.'" style="width: auto;max-height: 120px;">').'<hr>'."<strong>Cônjuge: Frente do Documento</strong>",
                            'class' => 'btn',
                            'style' => 'margin-bottom: 12px;width:100%'
                        ],
                        ]);
                        if (pathinfo($docmto->conjuge->frente_documento, PATHINFO_EXTENSION) == 'pdf'){
                            echo '<div>
                                    <object data="/'.$docmto->conjuge->frente_documento.'" type="application/pdf" width="550" height="500">
                                        alt : <a href="/'.$docmto->conjuge->frente_documento.'">test.pdf</a>
                                    </object>
                                </div>';
                        } else {
                            echo '<img src="/'.$docmto->conjuge->frente_documento.'" style="width: 100%;">';
                        }
                    Modal::end();
                    echo '</div>';
                
                    echo '<div class="col-md-3">';
                    Modal::begin([
                        'header' => '<h3>Cônjuge: Verso do Documento</h3>',
                        'toggleButton' => [
                            'label' => (pathinfo($docmto->conjuge->verso_documento, PATHINFO_EXTENSION) == 'pdf' ? '<i class="fas fa-file-pdf" style="font-size: 25px"></i>' : '<img src="/'.$docmto->conjuge->verso_documento.'" style="width: auto;max-height: 120px;">').'<hr>'."<strong>Cônjuge: Verso do Documento</strong>",
                            'class' => 'btn',
                            'style' => 'margin-bottom: 12px;width:100%'
                        ],
                    ]);
                    if (pathinfo($docmto->conjuge->verso_documento, PATHINFO_EXTENSION) == 'pdf'){
                        echo '<div>
                                <object data="/'.$docmto->conjuge->verso_documento.'" type="application/pdf" width="550" height="500">
                                    alt : <a href="/'.$docmto->conjuge->verso_documento.'">test.pdf</a>
                                </object>
                            </div>';
                    } else {
                        echo '<img src="/'.$docmto->conjuge->verso_documento.'" style="width: 100%;">';
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
        el.setAttribute("style","position:absolute;top:40%;left:45%;background-color:rgba(255,0,255, 0.7);font-size:14px;color:white;font-weight: bold;padding:20px;border-radius:20px;");
        el.innerHTML = msg;
        setTimeout(function(){
        el.parentNode.removeChild(el);
        },duration);
        document.body.appendChild(el);
    }
</script>