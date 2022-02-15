<?php 
use yii\bootstrap\Collapse;
?>
<style type="text/css">
    :root {
        --cor-bg-fundo: #66ccff;
        /*lightgray;*/
        --cor-bg-elementos: #084d6e;
        /*gray;*/
        --fundo-com-transparencia: rgba(0, 0, 0, 0.1);
    }
    #chat-msg {
        background-color: var(--cor-bg-elementos);
        position: fixed;
        right: 5px;
        bottom: 0;
        padding: 10px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        z-index: 10000;
    }
    #chat-msg label{
        width: 100%;
        background: ghostwhite;
        text-align: center;
        padding: 5px;
        margin-bottom: 0;
        /*border-top-left-radius: 10px;
        border-top-right-radius: 10px;*/
    }
    #chat-msg textarea{
        width: 100% !important;
        border: 5px solid !important;
        border-color: ghostwhite !important;
        text-transform: none !important;
        /*border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;*/
    }
    #chat-msg a:hover, #chat-msg a:focus {
        /* color: white; */
        text-decoration: none!important;
        font-weight: bolder;
    }
    #chat-msg .panel-heading {
        text-align: center;
    }
    #chat-msg .btn-success {
        color: gray;
        background-color: lightgray;
        border-color: lightgray;
    }
    #historico-div {
        overflow-y: auto;
        height: 300px;
        border: 5px solid ghostwhite;
        border-top-left-radius: 10px;
        background-color: ghostwhite;
    }
    .balao-1 {
        background-color: var(--cor-bg-elementos);
        margin: 5px;
        padding: 10px;
        border-radius: 10px;
        width: 80%;
        float: right;
        color: white;
        font-style: italic;
        padding-top: 20px;
    }
    .balao-2 {
        background-color: var(--cor-bg-fundo);
        margin: 5px;
        padding: 10px;
        padding-top: 20px;
        border-radius: 10px;
        width: 80%;
        float: left;
        color: white;
        font-style: italic;
    }
    .data-msg{
        float: left;
        position: relative;
        top: -7px;
    }
    .collapse-toggle {
        text-transform: capitalize;
    }
    /* .panel-default > .panel-heading {
        color: white !important;
        background-color: slategray;
        border-color: slategray;
    } */
</style>
<?php
    $pessoais = $model->proponente->sloInfospessoais;
    echo "<div class='col-md-3 float-right' style='' id='chat-msg'>";
    $mensagem = new app\models\Mensagem;

    $conversa = app\models\Mensagem::find()->where([
        'proposta_id'=>$model->id
    ])->orderBy(['id' => SORT_ASC])->all();

    $historico = '<div id="historico-div" class="col-md-12">';
    if (count($conversa) > 0) {
        $historico .= '';
        foreach ($conversa as $row) {

            $balao = ($row->usuario_id != '') ? '1' : '2' ;

            $historico .= '<div class="col-md-12 balao-'.$balao.'">';
            $historico .= '<sup class="data-msg"><b>'.$row->usuario->nome.'</b>: '.$row->data.'</sup>';
            $historico .= '<span>'.$row->texto.'</span>';
            $historico .= '</div>';
            $historico .= '<div class="clearfix"></div>';

        }
        $historico .= '<hr>';
    }

    $historico .= '</div>';

    echo Collapse::widget([
        'items' => [
            [
                'label' => 'Chat com Cliente '.$pessoais->nome,
                'content' => $historico.$this->render('/mensagem/_form', [
                        'model' => $mensagem,
                        'proposta_id' => $model->id,
                        'usuario_id' => Yii::$app->user->identity->id,
                        'ativo' => 'admin'
                    ]),

            ]
        ]
    ]);
    echo "</div>";
    $this->registerJS('
        $(".comment-form").on(\'beforeSubmit\', function () {
            var data = $(this).serializeArray();
            var url = $(this).attr(\'action\');
            $.ajax({
                url: url,
                type: \'post\',
                dataType: \'json\',
                data: data,
                beforeSend: function(){
                    $("#bota-submit-nisso").html("Enviando...");
                },
                success: function(data){
                    setInterval(function(){ $("#bota-submit-nisso").html("Enviar") },1000);
                }
            })
            .done(function(response) {
                if (response.data.success == true) {
                    console.log("Wow you commented");
                    $("#mensagem-texto").val("");
                    $("#historico-div").html(response.data.message);
                    var objDiv = document.getElementById("historico-div");
                    objDiv.scrollTop = objDiv.scrollHeight;
                }
            })
            .fail(function() {
                console.log("error");
            });
            return false;
        });

        setInterval(function(){
            var formulario = $(".comment-form");
            // var data = formulario.serializeArray();
            var url = "'.Yii::$app->homeUrl.'mensagem/ajaxcommentadmin";
            $.ajax({
                url: url,
                type: \'post\',
                // dataType: \'json\',
                data: {
                    "proposta_id" : "'.$model->id.'",
                    "ativo" : "admin"
                }
            })
            .done(function(response) {
                if (response.data.success == true) {
                    $("#historico-div").html(response.data.message);
                    // var objDiv = document.getElementById("historico-div");
                    // objDiv.scrollTop = objDiv.scrollHeight;
                }
            })
            .fail(function() {
                console.log("error");
            });
        }, 5000);
    ');
    // USAR ID DO PRETENTENDE PRA IDENTIFICAR A RESPOSTA DO USUÁRIO ADMIN DO SISTEMA
    // IDEIA: criar função a ser chamada via AJAX que atualize a Div de histórico a cada 5 segundos
    // NÃO usar o formulário vigente
?>