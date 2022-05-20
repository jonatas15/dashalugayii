<?php //$this->beginContent('@app/views/layouts/main_old.php'); ?>

<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use app\models\Bitly;
use yii\bootstrap\Modal;
use kartik\checkbox\CheckboxX;
use kartik\select2\Select2;
use kartik\form\ActiveForm;

use deyraka\materialdashboard\widgets\Card;
use deyraka\materialdashboard\widgets\CardProduct;
use deyraka\materialdashboard\widgets\CardStats;
use deyraka\materialdashboard\widgets\Progress;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\SloProposta */
?>
<style>
    .nav-tabs {
        font-size: 15px !important;
    }
</style>
<?php
    echo $this->render('/site/avisos', [
        'idreferencia' => $model->id,
    ]);
    $arquivo = 'credpago';
    $quant_etapas = 5;
    if ($model->tipo != "Credpago") {
        $arquivo = 'seguro';
    }

    if ($model->tipo == "Credpago") {
        $credpagoouseg = "Credpago";
        $quant_etapas = 6;
    } else {
        $credpagoouseg = "Seguradora";
        $quant_etapas = 5;
    }

    //Dados do Imóvel - inserir se vazio
    // echo 'Código!!! '.$model->imovel_info;
    $model_imovelinfo_ = json_decode($model->imovel_info);
    if (empty($model_imovelinfo_) or $model_imovelinfo_ == "") {
        echo '<span>Imóvel não definido/atualize a página</span>';
        $this->context->cadastraimovelupdate($model->id, $model->codigo_imovel);
    }

    // $msg_whats = "Teste de Msg\\n_Italico_ \\n*negrito*\\n~tachado~\\n```Monoespaçado```\\n😜";
    $msg_whats = "Cadastro recebido. Em análise.";

    $fonewhats = "55".$model->telefone_celular;
    // echo "teste: ".$fonewhats;
    ########################################################################################
    ########################### PRA HTML ###################################################
    $titulo_email = "Cadastro recebido. Em análise.";
        $textos_email = "<p>Ual! Ficamos felizes em conhecer você 😍 </p>
            <p>A partir de agora seu cadastro está <strong>em análise</strong>! Em até 1 dia útil retornamos com o
            <br>resultado 🙌 🤝 </p>
            <p>Qualquer dúvida não hesite em nos contatar.</p>";
        if ($model->tipo == "Credpago") {
            $credpagoouseg = "Credpago";
        } else {
            $credpagoouseg = "Seguradora";
        }
        if ($model->etapa_andamento >= 1):
            switch ($model->opcoes) {
                case '0':
                    $titulo_email = "Tudo certo! 👏🙌";
                    $textos_email = "
                        <p>
                        Nossa equipe vai começar a redigir seu contrato! 
                        </p>
                        <p>
                        ⭐ Em até 24 horas seu contrato estará disponível para assinatura digital.
                        </p>
                        <p>                
                        ⭐ Após assinado você já pode preparar sua mudança. Entregaremos as chaves do seu imóvel em até 2 dias úteis (após assinatura do contrato).</p>
                        <p>
                        Viu só? tudo digital, rápido e sem burocracia né?! 😉
                        </p>";

                    $msg_whats = "\\n*Tudo certo!* 👏🙌 \\n \\n";
                    $msg_whats.= "⭐ Em até 24 horas seu contrato estará disponível para assinatura digital. \\n";
                    $msg_whats.= "⭐ Após assinado você já pode preparar sua mudança. Entregaremos as chaves do seu imóvel em até 2 dias úteis (após assinatura do contrato). \\n";
                    $msg_whats.= "Viu só? tudo digital, rápido e sem burocracia né?! 😉 \\n \\n";
                    break;
                case '1':
                    $titulo_email = "Opa! Cadastro com pendências. 😕";
                    $textos_email = "
                        <p>
                        A $credpagoouseg solicitou mais alguns dados para completar sua análise. Favor acessar e conferir seu processo através do botão abaixo.
                        <br>
                        Qualquer dúvida estamos aqui à sua disposição! 😉
                        </p>";

                    $msg_whats = "\\n*Opa! Cadastro com pendências.* 😕 \\n \\n";
                    $msg_whats.= "A $credpagoouseg solicitou mais alguns dados para completar sua análise. Favor acessar e conferir as observações do seu processo através do link abaixo. \\n";
                    $msg_whats.= " Qualquer dúvida estamos aqui à sua disposição! 😉 \\n \\n";
                    break;
                case '2':
                    $titulo_email = "Opa! Cadastro com pendências. 😕";
                    $textos_email = "
                        <p>
                        A $credpagoouseg solicitou mais alguns dados para completar sua análise. Favor acessar e conferir seu processo através do botão abaixo.
                        <br>
                        Qualquer dúvida estamos aqui à sua disposição! 😉
                        </p>";

                    $msg_whats = "\\n*Opa! Cadastro com pendências.* 😕 \\n \\n";
                    $msg_whats.= "A $credpagoouseg solicitou mais alguns dados para completar sua análise. Favor acessar e conferir as observações do seu processo através do link abaixo. \\n";
                    $msg_whats.= " Qualquer dúvida estamos aqui à sua disposição! 😉 \\n \\n";
                    break;
                case '3':
                    $titulo_email = "Ops, cadastro não aprovado 😕";
                    $textos_email = "
                        <strong>Por algum motivo, seu cadastro não foi aprovado. Mas não desanime!</strong><br>
                        Nossa equipe em breve fará contato com você para melhor lhe atender! 😉
                        </p>";

                    $msg_whats = "\\n*Ops, cadastro não aprovado* 😕 \\n \\n";
                    $msg_whats.= "Por algum motivo, seu cadastro não foi aprovado. Mas não desanime! \\n";
                    $msg_whats.= "Nossa equipe em breve fará contato com você para melhor lhe atender! 😉 \\n \\n";
                    break;
                default:
                    $titulo_email = "Cadastro recebido. Em análise.";
                    $textos_email = "<p>Ual! Ficamos felizes em conhecer você 😍 </p>
                        <p>A partir de agora seu cadastro está <strong>em análise</strong>! Em até 1 dia útil retornamos com o
                        <br>resultado 🙌 </p>
                        <p>Qualquer dúvida não hesite em nos contatar. 🤝 </p>";

                    $msg_whats = "\\n*Cadastro recebido. Em análise.* \\n \\n";
                    $msg_whats.= "Ual! Ficamos felizes em conhecer você 😍 \\n";
                    $msg_whats.= "A partir de agora seu cadastro está *em análise*! Em até 1 dia útil retornamos com o \\n";
                    $msg_whats.= "resultado 🙌 \\n";
                    $msg_whats.= "Qualquer dúvida não hesite em nos contatar. 🤝 \\n \\n";
                    break;
            }
        endif;
        switch ($model->etapa_andamento) {
            case '3':
                // $titulo_email = "Cadastro APROVADO 🥳";
                // $textos_email = "
                //     <p>
                //     Que felicidade 🙌😄 seu cadastro está aprovadíssimooo! 
                //     </p><p>
                //     Para finalizar precisamos de mais alguns dados, prometo que vai ser rápido. Favor acesse seu processo através do botão abaixo.
                //     </p><p>                    
                //     Qualquer dúvida estamos aqui à sua disposição! 😉
                //     </p>";
                // break;
                $titulo_email = "Cadastro APROVADO 🥳";
                $textos_email = "
                    <p>
                    Após sua confirmação, nossa equipe vai começar a redigir seu contrato! 
                    </p>
                    <p>
                    ⭐ Em até 24 horas (após confirmação) seu contrato estará disponível para assinatura digital.
                    </p>
                    <p>                
                    ⭐ Após assinado você já pode preparar sua mudança. Entregaremos as chaves do seu imóvel em até 2 dias úteis (após assinatura do contrato).</p>
                    <p>
                    Viu só? tudo digital, rápido e sem burocracia né?! 😉
                    </p>";

                    $msg_whats = "\\n*Cadastro APROVADO 🥳* \\n \\n";
                    $msg_whats.= "Após sua confirmação, nossa equipe vai começar a redigir seu contrato! \\n";
                    $msg_whats.= "⭐ Em até 24 horas (após confirmação) seu contrato estará disponível para assinatura digital. \\n";
                    $msg_whats.= "⭐ Após assinado você já pode preparar sua mudança. Entregaremos as chaves do seu imóvel em até 2 dias úteis (após assinatura do contrato). \\n";
                    $msg_whats.= "Viu só? tudo digital, rápido e sem burocracia né?! 😉 \\n \\n";

                break;
            case '4':
                $titulo_email = "Tudo certo! 👏🙌";
                $textos_email = "
                    <p>
                    Após sua confirmação, nossa equipe vai começar a redigir seu contrato! 
                    </p>
                    <p>
                    ⭐ Em até 24 horas seu contrato estará disponível para assinatura digital.
                    </p>
                    <p>                
                    ⭐ Após assinado, você já pode preparar sua mudança, entregaremos as chaves do seu imóvel em até 
                    2 dias úteis (após assinatura do contrato).</p>
                    <p>
                    Viu só? tudo digital, rápido e sem burocracia né?! 😉
                    </p>";

                    $msg_whats = "\\n*Tudo certo! 👏🙌* \\n \\n";
                    $msg_whats.= "Após sua confirmação, nossa equipe vai começar a redigir seu contrato! \\n";
                    $msg_whats.= "⭐ Em até 24 horas seu contrato estará disponível para assinatura digital. \\n";
                    $msg_whats.= "⭐ Após assinado, você já pode preparar sua mudança, entregaremos as chaves do seu imóvel em até 2 dias úteis (após assinatura do contrato). \\n";
                    $msg_whats.= "Viu só? tudo digital, rápido e sem burocracia né?! 😉 \\n \\n";

                break;
            case '5':
                $titulo_email = "Contrato pronto para assinatura! 😍";
                $textos_email = "
                    <p>
                    Chegou a hora de você assinar seu contrato digital. Sem filas de cartório, sem custo, e sem burocracia 😉
                    </p>
                    <p>
                    Após assinatura do contrato, liberamos a chaves do seu novo imóvel em até 2 dias úteis (tempo para vistoria).
                    </p>
                    Clique no botão abaixo para proceder com a assinatura.";

                    $msg_whats = "\\n*Contrato pronto para assinatura! 😍* \\n \\n";
                    $msg_whats.= "Chegou a hora de você assinar seu contrato digital. Sem filas de cartório, sem custo, e sem burocracia 😉 \\n";
                    $msg_whats.= "Após assinatura do contrato, liberamos a chaves do seu novo imóvel em até 2 dias úteis (tempo para vistoria). 😉 \\n";
                    $msg_whats.= "Clique no link abaixo para proceder com a assinatura. \\n \\n";

                break;
            case '6':
                $titulo_email = "Vistoria em andamento";
                $textos_email = "
                    <p>
                    Parabéns 👏  seu contrato foi assinado com sucesso!
                    <p></p>
                    Agora é só aguardar a vistoria de entrada. Em até 2 dias úteis as chaves do seu novo imóvel estará disponível para retirada. 
                    <p></p>
                    Não se preocupe! Vamos lhe avisar assim que disponível.
                    </p>";

                    $msg_whats = "\\n*Vistoria em andamento* \\n \\n";
                    $msg_whats.= "Parabéns 👏  seu contrato foi assinado com sucesso! \\n";
                    $msg_whats.= "Agora é só aguardar a vistoria de entrada. Em até 2 dias úteis as chaves do seu novo imóvel estará disponível para retirada. \\n";
                    $msg_whats.= "Não se preocupe! Vamos lhe avisar assim que disponível. \\n \\n";

                break;
        }

        $msg_html = '<center>';
        $msg_html.= "<h2>$titulo_email</h2>";
        $msg_html.= '<hr>';
        $msg_html.= '<p>';
        $msg_html.= "<p>$textos_email</p>";
        $msg_html.= '</p>';

    
        $msg_whats .= "\\n";
        
        // echo "<pre>$model->etapa_andamento</pre>";
        // echo '<pre>';
        // echo $msg_whats;
        // echo '</pre>';


    // $msg_whats .= "\\n ".'https://alugadigital.com.br/'.($model->tipo === 'Credpago' ? 'credpago' : 'seguro-fianca').'/'.$model->id;

?>
<script>
    function myFunction() {
        /* Get the text field */
        var copyText = document.getElementById("myInput");
    
        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */
    
        /* Copy the text inside the text field */
        document.execCommand("copy");
    
        /* Alert the copied text */
        alert("Copied the text: " + copyText.value);
    }
</script>
<?php
$this->title = 'Proposta: ' . $model->tipo .' pelo Imóvel '. $model->codigo_imovel;
$this->params['breadcrumbs'][] = ['label' => 'Propostas', 'url' => ['/site/indexlocacao']];
// $this->params['breadcrumbs'][] = ['label' => 'Imóvel '.$model->codigo_imovel, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<style>
    .item1,.item2,.item3,.item4,.item5,.item6,.item7,.item8,.item9,.item10 {
        position:absolute;
        margin-top:-17px;
        z-index:1;
        height:45px;
        width:45px;
        border-radius:45px;
    }
    .item1:hover,.item2:hover,.item3:hover,.item4:hover,.item5:hover,.item6:hover,.item7:hover,.item8:hover,.item9:hover,.item10:hover {
        background-color: green !important;
        border-color: #69c629;
    }
    .etapa-ativa {border: 4px solid #4989bd;}
    <?php if ($model->tipo == 'Credpago') : ?>
    .item1{left:0%;}
    .item2{left:20%;}
    .item3{left:40%;}
    .item4{left:60%;}
    .item5{left:80%;}
    .item6{left:98%;}
    .item7{left:70%;}
    .item8{left:80%;}
    .item9{left:90%;}
    .item10{left:100%;}
    <?php else: ?>
    .item1{left:0%;}
    .item2{left:25%;}
    .item3{left:50%;}
    .item4{left:75%;}
    .item5{left:100%;}
    <?php endif; ?>
    /* .one{left:10%;}
    .two{left:20%;}
    .three{left:30%;}
    .for{left:40%;} */
    .primary-color{background-color:black;}
    .success-color{background-color:#5cb85c;}
    .danger-color{background-color:#d9534f;}
    .warning-color{background-color:#f0ad4e;}
    .info-color{background-color:#5bc0de;}
    .no-color{
        background-color: black;
        border: 6px solid lightgray;
    }
    .item-formulario{
        color: white;
        font-size: 20px;
        margin-left: 33%;
        margin-top: 8%;
        cursor: pointer;
    }
    
    @media (max-width: 700px) {
        .desaparece-mobile { display: none; }
    }
    .item-interno-proposta {
        border: 1px solid lightgray; border-radius: 5px; padding: 10px;
    }
    .etapa-ativa {
        border: 6px solid #69c629 !important;
    }
    .descricao-formulario {
        white-space: nowrap;
        /* margin: 8px; */
        /* margin-left: -42px; */
        text-align: center !important;
        position: absolute;
        top: 52px;
        left: -42px;
        max-width: none !important;
    }
    .progress-bar {
        background-color: #69c629 !important;
    }
</style>
<div class="slo-proposta-update">
    <?php 
        
        // function generateRandomString($length = 10) {
        //     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        //     $charactersLength = strlen($characters);
        //     $randomString = '';
        //     for ($i = 0; $i < $length; $i++) {
        //         $randomString .= $characters[rand(0, $charactersLength - 1)];
        //     }
        //     return $randomString;
        // }
        // echo '<pre>'.generateRandomString().'</pre>';
    ?>
    <!-- <h3 style="text-align: center">
        <div class="float-left" style="position: absolute !important; z-index: 1000;"><a href="<?=Yii::$app->homeUrl?>/site/indexlocacao" class="btn btn-primary"><b><i class="fas fa-arrow-left"></i> Voltar</b><br>Propostas</a></div>
        <strong><?= Html::encode($this->title) ?></strong>
    </h3> -->
    <div class="row"><br />
        <div class="col-md-1"></div>
		<div class="col-md-10" style="padding-right: 0px !important;">
            <?php 
                $etp_1 = 'no-color';
                $etp_2 = 'no-color';
                $etp_3 = 'no-color';
                $etp_4 = 'no-color';
                $etp_5 = 'no-color';
                $etp_6 = 'no-color';

                // $model->etapa_andamento = '6';

                $etp_ativa =  'primary-color etapa-ativa';
                if ($model->tipo == 'Credpago'){
                    switch ($model->etapa_andamento) {
                        case 1: $etapa_atual = '0%'; $etp_1 = $etp_ativa; break;
                        case 2: $etapa_atual = '21%'; $etp_1 = $etp_2 = $etp_ativa; break;
                        case 3: $etapa_atual = '41%'; $etp_1 = $etp_2 = $etp_3 = $etp_ativa; break;
                        case 4: $etapa_atual = '61%'; $etp_1 = $etp_2 = $etp_3 = $etp_4 = $etp_ativa; break;
                        case 5: $etapa_atual = '81%'; $etp_1 = $etp_2 = $etp_3 = $etp_4 = $etp_5 = $etp_ativa; break;
                        case 6: $etapa_atual = '100%'; $etp_1 = $etp_2 = $etp_3 = $etp_4 = $etp_5 = $etp_6 = $etp_ativa; break;
                        default: $etapa_atual = '0%'; break;
                    }
                } else {
                    // $model->etapa_andamento = 5;
                    switch ($model->etapa_andamento) {
                        case 1: $etapa_atual = '0%';    $etp_1 = $etp_ativa; break;
                        case 2: $etapa_atual = '26%';   $etp_1 = $etp_2 = $etp_ativa; break;
                        case 3: $etapa_atual = '51%';   $etp_1 = $etp_2 = $etp_3 = $etp_ativa; break;
                        case 4: $etapa_atual = '76%';   $etp_1 = $etp_2 = $etp_3 = $etp_4 = $etp_ativa; break;
                        case 5: $etapa_atual = '100%';  $etp_1 = $etp_2 = $etp_3 = $etp_4 = $etp_5 = $etp_ativa; break;
                        default: $etapa_atual = '0%';   break;
                    }
                }
                $complementando = '/'.$model->id.'X'.$model->codigo;
                $linkcp = ($model->tipo === 'Credpago' ? 'credpago' : 'seguro-fianca').''.$complementando;
            ?>

            <div class="progress" style="width: 101%">
                <a href="<?=Yii::$app->homeUrl.'proposta/atualizarprop?etapa=1&id='.$model->id?>">
                    <div class="item1 <?=$etp_1?>">
                        <label class="item-formulario">1</label>
                        <label class="descricao-formulario desaparece-mobile">Cadastro</label>
                    </div>
                </a>
                <a href="<?=Yii::$app->homeUrl.'proposta/atualizarprop?etapa=2&id='.$model->id?>">
                    <div class="item2 <?=$etp_2?>">
                        <label class="item-formulario">2</label>
                        <label class="descricao-formulario desaparece-mobile">Análise</label>
                    </div>
                </a>
                <a href="<?=Yii::$app->homeUrl.'proposta/atualizarprop?etapa=3&id='.$model->id?>" class="<?=$model->tipo == 'Seguro Fiança' ? "hidden-tirar-depois" :''?>">
                    <div class="item3 <?=$etp_3?>">
                        <label class="item-formulario">3</label>
                        <label class="descricao-formulario desaparece-mobile">Aprovação</label>
                    </div>
                </a>
                <a href="<?=Yii::$app->homeUrl.'proposta/atualizarprop?etapa=4&id='.$model->id?>">
                    <div class="item4 <?=$etp_4?>">
                        <label class="item-formulario">4</label>
                        <label class="descricao-formulario desaparece-mobile">Resultado</label>
                    </div>
                </a>
                <a href="<?=Yii::$app->homeUrl.'proposta/atualizarprop?etapa=5&id='.$model->id?>">
                    <div class="item5 <?=$etp_5?>">
                        <label class="item-formulario">5</label>
                        <label class="descricao-formulario desaparece-mobile"><?= $model->tipo == 'Credpago' ? 'Assinatura' : 'Vistoria<br>Entrega de Chaves'; ?></label>
                    </div>
                </a>
                <?php if ($model->tipo == 'Credpago'): ?>
                <a href="<?=Yii::$app->homeUrl.'proposta/atualizarprop?etapa=6&id='.$model->id?>">
                    <div class="item6 <?=$etp_6?>">
                        <label class="item-formulario">6</label>
                        <label class="descricao-formulario desaparece-mobile">Vistoria<br>Entrega de Chaves</label>
                    </div>
                </a>
                <?php endif; ?>
                
                <div class="progress-bar" style="width: <?= $etapa_atual ?>;"></div>
                
            </div>
            <br />
            <br />
            <br />
            <div class="clearfix"></div>
            <br />
            <br />
            <br />
            <div class="clearfix"></div>
            <div class="row">
	            <div class="col-md-4" style="">
                    <?php
                        Card::begin([  
                            'id' => 'card1', 
                            'color' => Card::COLOR_PRIMARY, 
                            'headerIcon' => 'search', 
                            'collapsable' => false, 
                            'title' => '<strong style="font-size: 15px">Tela da Fase, no site:</strong>', 
                            'titleTextType' => Card::TYPE_PRIMARY, 
                            'showFooter' => true,
                            'options' => [
                                'style' => 'z-index: 1049 !important;',
                            ],
                            'footerContent' => 'Clique nos botões pra ver as diferentes fases desse processo',
                        ]);
                    ?>
                    <img id="preview-site" src="<?=Yii::$app->homeUrl.'uploads/capturas-tela/credpago_'.$model->etapa_andamento.'.png';?>" style="width: 100%; height: auto"/>
                    <?php 
                        // echo '<center style="outline: 1px solid">';
                        for($i=1;$i<=$quant_etapas;$i++) {
                            Modal::begin([
                                // 'header' => '<h3 style="text-align: center">Visualizar etapa '.$i.' no Site</h3>',
                                'size' => 'modal-lg',
                                'toggleButton' => [
                                    'id' => $i,
                                    // 'label' => '<strong>'.$i.' <i class="fa fa-eye"></i></strong>',
                                    'label' => '<strong>'.$i.'</strong>',
                                    'title' => 'Visualizar etapa '.$i,
                                    'alt' => 'Visualizar etapa '.$i,
                                    'class' => 'btn btn-info',
                                    'style' => 'padding: 0 !important;font-size: 13px; font-weight: bolder; position: relative; left: '.(($i*5)).'px; border-radius: 50%;width:40px;height:40px'
                                ]
                            ]);
                            echo '<h3 style="text-align: center">Visualizar etapa '.$i.' no Site</h3>';
                            echo '<img src="'.Yii::$app->homeUrl.'uploads/capturas-tela/'.$arquivo."_$i.png".'" style="width: 100%"/>';
                            Modal::end();
                        }
                        // echo '</center>';
                    ?>
                    <?php Card::end(); ?>
                </div>
                <div class="col-md-8">
                    <div class="col-md-12" style="text-align: center">
                        <?php if ($model->etapa_andamento - 1 == 1): ?>
                        <a href="<?= Yii::$app->homeUrl.'proposta/atualizarprop?resposta=0&etapa=3&id='.$model->id ?>" class="btn btn-<?=($model->opcoes == '0' ? 'primary' : 'default')?>">Sem pendências</a>
                        <a href="<?= Yii::$app->homeUrl.'proposta/atualizarprog?resposta=1&id='.$model->id ?>" class="btn btn-<?=($model->opcoes == '1' ? 'primary' : 'default')?>">Pendenciado</a>
                        <?php 
                            // Modal aqui
                            if ($model->opcoes == '1' and $model->tipo == "Seguro Fiança"):
                                Modal::begin([
                                    // 'header' => 'Definir Documentos',
                                    'size' => 'modal-md',
                                    'toggleButton' => [
                                        'label' => '<i class="fa fa-check-square"></i> Docs',
                                        'class' => 'btn btn-success',
                                        'style' => 'font-weight: bolder',
                                    ]
                                ]);
                                echo "<h3><center>Definir Documentos</center></h3>";
                                $docs_escolha = [
                                    'CPF' => 'CPF',
                                    'RG (frente)' => 'RG (frente)',
                                    'RG (verso)' => 'RG (verso)',
                                    'Extrato bancário' => 'Extrato bancário',
                                    'Imposto de renda (completo)' => 'Imposto de renda (completo)',
                                    'Comprovante de endereço' => 'Comprovante de endereço',
                                    'Carteira de trabalho (registro do emprego)' => 'Carteira de trabalho (registro do emprego)',
                                    'Extrato INSS' => 'Extrato INSS',
                                ];
                                // $k = 1;
                                // echo '<div class="col-md-12" style="text-align: left">';
                                // foreach ($docs_escolha as $val) {
                                //     $valor = 0;
                                //     if (preg_match($pattern, $tags)) {
                                //         $valor = 1;
                                //     }
                                //     echo '<div class="col-md-6" style="text-align: left">';
                                //     echo CheckboxX::widget([
                                //         'name' => 'documento['.$val.']',
                                //         'value' => $valor,
                                //         'initInputType' => CheckboxX::INPUT_CHECKBOX,
                                //         'pluginOptions' => [
                                //             'threeState'=>false
                                //         ],
                                //         'pluginEvents' => [
                                //             'change' => 'function() {
                                //                 console.log("checkbox changed");
                                //                 $.ajax({
                                //                     method: "POST",
                                //                     url: "definedocs",
                                //                     data: {
                                //                         ch: $(this).prop(\'checked\'),
                                //                         id: '.$model->id.',
                                //                         vl: '.$val.'
                                //                     },
                                //                 });
                                //             }'
                                //         ],
                                //         'labelSettings' => [
                                //             'label' => '',
                                //             'position' => CheckboxX::LABEL_LEFT
                                //         ],
                                        
                                //     ]).' <span class="" style="position: relative;top: -6px;">'.$val.'</span><br>';
                                //     echo '</div>';
                                //     $k++;
                                // }
                                // echo '</div>';
                                // echo '<label class="control-label">Tag Multiple</label>';
                                $form = ActiveForm::begin([
                                    'options' => [
                                    ],
                                    'action' => [
                                        'definedocs',
                                        'id' => $model->id
                                    ]
                                ]);
                                $preselect = explode(',', $model->motivo_locacao);
                                echo Select2::widget([
                                    'name' => 'motivo_locacao',
                                    'value' => $preselect, // initial value
                                    'data' => $docs_escolha,
                                    'maintainOrder' => true,
                                    'options' => [
                                        'placeholder' => 'Selecione', 
                                        'multiple' => true
                                    ],
                                    'pluginOptions' => [
                                        'tags' => false,
                                        'maximumInputLength' => 20
                                    ],
                                ]);
                                echo '<br>';
                                echo Html::submitButton('Confirmar  <i class="fas fa-angle-double-right"></i>', [
                                    'class' => 'btn btn-primary btn-destaque', 
                                    'style'=>'font-weight: bolder'
                                ]);
                                ActiveForm::end();
                                echo '<div class="clearfix"></div>';
                                Modal::end();
                            endif;
                        ?>
                        <?php if($model->tipo == "Credpago"): ?>
                            <a href="<?= Yii::$app->homeUrl.'proposta/atualizarprog?resposta=2&id='.$model->id ?>" class="btn btn-<?=($model->opcoes == '2' ? 'primary' : 'default')?>">Precisa de Co-responsável</a>
                        <?php endif; ?>
                        <a href="<?= Yii::$app->homeUrl.'proposta/atualizarprog?resposta=3&id='.$model->id ?>" class="btn btn-<?=($model->opcoes == '3' ? 'primary' : 'default')?>">Reprovado</a>
                        <?php else: ?>
                        <?php 
                            switch ($model->opcoes) {
                                case '0': $resultado_analise_feita = 'Não há pendências'; break;
                                case '1': $resultado_analise_feita = 'Precisa de fatura'; break;
                                case '2': $resultado_analise_feita = 'Precisa de Co-responsável'; break;
                                case '3': $resultado_analise_feita = 'Reprovado'; break;
                                default: $resultado_analise_feita = 'A verificar'; break;
                            }    
                        ?>
                        <label for=""><strong>Resultado da Análise: </strong><?=$resultado_analise_feita?></label>
                        <?php endif; ?>
                    </div>
                    <br />
                    <br />
                    <br />
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <?php 
                            $url = 'https://alugadigital.com.br/'.$linkcp;
                            // $bitly = new Bitly('o_21m850qm97', 'dc5e209e26b7595ba7e956d3e22e2ff50a516cf8');
                            $bitly = new Bitly('o_21m850qm97', 'dc5e209e26b7595ba7e956d3e22e2ff50a516cf8');
                            $bitly->shorten($url);
                        ?>
                        
                        <center>
                            <br>
                            <label for=""><strong>Url original: </strong><?=$url?></label><br>
                            <!-- The text field -->
                            <input type="text" value="<?=$bitly->debug()?>" id="myInput" style="width: 50%">
                            <!-- The button used to copy the text -->
                            <button onclick="myFunction()">Copiar URL</button>
                            <br />
                            <br />
                            <?php 
                                $disparos_whats = \app\models\Historicodedisparos::find()->where([
                                    'proposta_id' => $model->id,
                                    'modo' => 'whats',
                                    'etapa' => $model->etapa_andamento,
                                    'status' => $model->opcoes
                                ])->all();
                                // echo '<br>Já foram feitos '.count($disparos_whats).' disparos de whatsapp dessa Etapa!<br>';
                                $disparos_email = \app\models\Historicodedisparos::find()->where([
                                    'proposta_id' => $model->id,
                                    'modo' => 'email',
                                    'etapa' => $model->etapa_andamento,
                                ])->all();
                                // echo '<br>Já foram feitos '.count($disparos_email).' disparos de email dessa Etapa!<br>';
                                Modal::begin([
                                    // 'header' => 'Disparar mensagem pelo Whats',
                                    'toggleButton' => [
                                        'label' => '<i class="fa fa-whatsapp"></i> Avisar pelo Whatsapp',
                                        'class' => 'btn btn-success',
                                        'style' => 'font-weight: bolder',
                                        'disabled' => count($disparos_whats) > 0 ? true : false
                                    ]
                                ]);
                                $msg_html2 = '<p>';
                                $msg_html2.= '<br /><br />"Acompanhe seu processo: <a href="'.$bitly->debug().'">'.$bitly->debug().'</a>"';
                                $msg_html2.= '</p>';
                                $msg_html2.= '</center>';
                                $msg_htmlW = str_replace('botão', 'link', $msg_html);
                                echo $msg_htmlW.$msg_html2;
                                echo '<br>';
                            ?>
                            <button id="botao-whats" class="btn btn-success" style='font-weight: bolder; font-size: 20px'><i class="fa fa-whatsapp"></i> Disparar</button>
                            <?php Modal::end(); ?>
                            <?php 
                                Modal::begin([
                                    // 'header' => 'Disparar mensagem pelo Email',
                                    'toggleButton' => [
                                        'label' => '<i class="fa fa-envelope"></i> Avisar pelo Email',
                                        'class' => 'btn btn-primary',
                                        'style' => 'font-weight: bolder',
                                        'disabled' => count($disparos_email) > 0 ? true : false
                                    ],
                                    // 'bodyOptions' => [
                                    //     'style' => 'background-color: red'
                                    // ]
                                ]);
                                $msg_html3 = '<p>';
                                $msg_html3.= '<a style="cursor: pointer" href="'.$bitly->debug().'"><button style="cursor: pointer;background-color: white; color: black; font-weight: bolder; padding: 10px 20px; border: 5px solid black; border-radius: 0px;font-size: 20px">Acompanhe seu processo</button></a>';
                                $msg_html3.= '<br /><br />Ou acesse "<a href="'.$bitly->debug().'">'.$bitly->debug().'</a>"';
                                $msg_html3.= '</p>';
                                $msg_html3.= '<img src="https://alugadigital.com.br/img/logo_a_empresa.f21cb89d.png" width="100">';
                                $msg_html3.= '</center>';
                                echo $msg_html.$msg_html3;
                                echo '<br>';
                            ?>
                            <a href="<?= Yii::$app->homeUrl.'proposta/atualizaremail?id='.$model->id ?>" class="btn btn-primary" style='font-weight: bolder; font-size: 20px'><i class="fa fa-envelope"></i> Avisar por email</a>
                            <?php Modal::end(); ?>
                            <?= '<br>'; ?>
                            <?= '<br>Já foram feitos '.count($disparos_whats).' disparo(s) de whatsapp dessa Etapa!'; ?>
                            <?= '<br>Já foram feitos '.count($disparos_email).' disparo(s) de email dessa Etapa!'; ?>
                        </center>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <div class="col-md-6" style="text-align: center !important;">
                            <h4><strong>Gerar PDF com essas Informações</strong></h4>
                            <a href="<?=Yii::$app->homeUrl.'proposta/report?id='.$model->id?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style = 'width: 100%'>
                            <i style="font-size: 20px; padding: 5px;" class="fa fa-file"></i> Gerar Documento PDF
                            </a>
                        </div>
                        <div class="col-md-6" style="text-align: center !important;">
                            <h4><strong>Cadastrar essas Informações no Jetimob</strong></h4>
                            <?=Html::a('<i style="" class="fa fa-gear"></i> SUPERLÓGICA: Proprietário e Imóvel',  ['proposta/addtosuperlogica', 'id' => $model->id], [
                                'class' => 'btn btn-primary',
                                'style' => 'width: 100%',
                                'onClick' => '
                                    $("body").css("cursor", "wait");
                                    $(this).css("cursor", "wait");
                                    $("#progressando").show();
                                    // $(this).addAttribute(\'disabled\');
                                    $(this).addClass(\'disabled\');
                                '
                            ]);?>
                            <br />
                            <br />
                            <div id="progressando" style="display: none">
                                <?php
                                    use kartik\spinner\Spinner;
                                    echo '<div class="">';
                                        echo Spinner::widget(['preset' => 'large', 'align' => 'center']);
                                        echo '<div class="clearfix"></div>';
                                    echo '</div>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php /* 
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <?php $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/deyraka/yii2-material-dashboard/assets/'); ?>
                    <?=
                    CardProduct::widget(
                        [
                            "image" => $directoryAsset.'\img\sidebar-1.jpg',
                            "hiddenIcon" => 'send',
                            "hiddenText" => 'See Details',
                            "hiddenTooltip" => 'Lets check Details',
                            "url" => Url::to(['/site/about']),
                            "title" => "Feel Excellent Panorama with Us",
                            "description" => "The place is close to Manchester Beach and bus stop just 2 min by walk and near to 'Naviglio' where you can enjoy the main night life in Manchester.",
                            "footerTextLeft" => "$8,000/night",
                            "footerTextRight" => "Manchester",
                            "footerTextType" => Cardstats::TYPE_INFO,
                        ]
                    )
                    ?>
                </div>
            </div>
            
            <div class="col-lg-4" style="border: 1px solid lightgray; height: 200px;">
                <label for="">Tela da Fase, no site:</label><br>
                <img id="preview-site" src="<?=Yii::$app->homeUrl.'uploads/capturas-tela/credpago_'.$model->etapa_andamento.'.png';?>" style="width: 100%; height: auto"/>
                <?php 
                    echo '<center style="outline: 1px solid">';
                    for($i=1;$i<=$quant_etapas;$i++) {
                        Modal::begin([
                            'header' => '<h3 style="text-align: center">Visualizar etapa '.$i.' no Site</h3>',
                            'size' => 'modal-lg',
                            'toggleButton' => [
                                'id' => $i,
                                'label' => '<strong>'.$i.' <i class="fa fa-eye"></i></strong>',
                                'title' => 'Visualizar etapa '.$i,
                                'alt' => 'Visualizar etapa '.$i,
                                'class' => 'btn-info',
                                'style' => 'font-weight: bolder; position: relative; left: '.(($i*10)).'px;z-index:1000'
                            ]
                        ]);
                        echo '<img src="'.Yii::$app->homeUrl.'uploads/capturas-tela/'.$arquivo."_$i.png".'" style="width: 100%"/>';
                        Modal::end();
                    }
                    echo '</center>';
                ?>
            </div>
            */
            ?>
            
            

        </div>
    </div>
    <br />
    <br />
    <!-- <hr> -->
    <div class="clearfix"></div>
    <?php 
        $msg_whats.= $bitly->debug()."\\n \\n"."[*Mensagem automática da AlugaDigital*] 📢";
        $this->registerJs("
            $('#preview-site').attr({'src':'".Yii::$app->homeUrl.'uploads/capturas-tela/'.$arquivo.'_'.$model->etapa_andamento.'.png'."'});
            $('.item1').on('mouseover', function() {
                $('#preview-site').attr({'src':'".Yii::$app->homeUrl.'uploads/capturas-tela/'.$arquivo.'_1.png'."'});
            }).on('mouseout', function() {
                $('#preview-site').attr({'src':'".Yii::$app->homeUrl.'uploads/capturas-tela/'.$arquivo.'_'.$model->etapa_andamento.'.png'."'});
            });
            $('.item2').on('mouseover', function() {
                $('#preview-site').attr({'src':'".Yii::$app->homeUrl.'uploads/capturas-tela/'.$arquivo.'_2.png'."'});
            }).on('mouseout', function() {
                $('#preview-site').attr({'src':'".Yii::$app->homeUrl.'uploads/capturas-tela/'.$arquivo.'_'.$model->etapa_andamento.'.png'."'});
            });
            $('.item3').on('mouseover', function() {
                $('#preview-site').attr({'src':'".Yii::$app->homeUrl.'uploads/capturas-tela/'.$arquivo.'_3.png'."'});
            }).on('mouseout', function() {
                $('#preview-site').attr({'src':'".Yii::$app->homeUrl.'uploads/capturas-tela/'.$arquivo.'_'.$model->etapa_andamento.'.png'."'});
            });
            $('.item4').on('mouseover', function() {
                $('#preview-site').attr({'src':'".Yii::$app->homeUrl.'uploads/capturas-tela/'.$arquivo.'_4.png'."'});
            }).on('mouseout', function() {
                $('#preview-site').attr({'src':'".Yii::$app->homeUrl.'uploads/capturas-tela/'.$arquivo.'_'.$model->etapa_andamento.'.png'."'});
            });
            $('.item5').on('mouseover', function() {
                $('#preview-site').attr({'src':'".Yii::$app->homeUrl.'uploads/capturas-tela/'.$arquivo.'_5.png'."'});
            }).on('mouseout', function() {
                $('#preview-site').attr({'src':'".Yii::$app->homeUrl.'uploads/capturas-tela/'.$arquivo.'_'.$model->etapa_andamento.'.png'."'});
            });
            $('.item6').on('mouseover', function() {
                $('#preview-site').attr({'src':'".Yii::$app->homeUrl.'uploads/capturas-tela/'.$arquivo.'_6.png'."'});
            }).on('mouseout', function() {
                $('#preview-site').attr({'src':'".Yii::$app->homeUrl.'uploads/capturas-tela/'.$arquivo.'_'.$model->etapa_andamento.'.png'."'});
            });

            var settings = {
                'url': '".Yii::$app->homeUrl."proposta/apibotmensagem',
                'method': 'POST',
                'timeout': 0,
                'headers': {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                'data': {
                    'subscriberid': ".$model->apibotsubs.",
                    'mensagem': '".$msg_whats."'
                }
            };

            $('#botao-whats').on('click', function() {
                $.ajax(settings).done(function (response) {
                    console.log(response);
                    if(response.result == 1 || response.result == '1') {
                        alert('Mensagem enviada com sucesso! <hr> $msg_whats');
                        $.ajax({
                            'url': '".Yii::$app->homeUrl."proposta/gravahistorico',
                            'method': 'POST',
                            'data': {
                                'proposta_id': '{$model->id}',
                                'data': '".date('yy-m-d h:i:s')."',
                                'mensagem': '$msg_whats',
                                'usuario_id': '".Yii::$app->user->identity->id."',
                                'etapa': '{$model->etapa_andamento}',
                                'modo': 'whats',
                                'status': '{$model->opcoes}'
                            }
                        });
                        document.location.reload(true);
                    } else {
                        alert('Ocorreu algum erro:' + response.result);
                        console.log(response);
                    }
                });
            })
            
        ");
    ?>
    <!-- <div class="col-md-8">
        <div class="item-interno-proposta">
            <?php
            /*
            if($model->proponente){
                echo $this->render('/pretendente/checklist', [
                    'model' => $model->proponente,
                    'pretendente_id' => $model->proponente->id
                ]);
            }else{
            */
                // echo '<h4 style="text-align: center"><strong>Ainda sem Proponente</strong></h4>';
                // echo '<h5 style="text-align: center">(Copie o Link abaixo pra enviar ao Pretendente)</h5><hr>';
                // $retorno .= "<div class='col-md-10' style='padding: 0px'>";
                // $retorno .= '<input style="background-color: lightgray; height: 35px; width: 100%" type="text" value="https:://www.alugadigital.com.br'.Yii::$app->homeUrl.'proposta/pretendente001?proposta_id='.$data->id.'&pretendente_id=novo" id="myInput">';
                // $retorno .= "</div>";

                // $retorno .= '<div class="col-md-2" style="margin-top: 0px !important;padding-right: 0px;padding-left: 0px;">';
                // $retorno .= '<button id="btn-copia" class="btn btn-info" alt="Copiar Link!" title="Copiar Link!"><i class="far fa-copy"></i> Copiar Link</button>';
                // $retorno .= "</div>";
                // echo $retorno;
                // echo '<div class="clearfix"></div>';
            // }
            // $this->registerJs('$("#btn-copia").on("click", function() {
            //     var copyText = document.getElementById("myInput");
            //     copyText.select();
            //     copyText.setSelectionRange(0, 99999);

            //     document.execCommand("copy");
            //     console.log("Copied the text: " + copyText.value);
            //     $(this).addClass("btn btn-danger").text("Link Copiado!");
            //   });');
            ?>
        </div>
    </div> -->
    

    <div class="clearfix"></div>
    <br>
    <div class="col-md-12">
        <?php
            echo Tabs::widget([
                'items' => [
                    [
                        'label' => 'Registro do Imóvel',
                        'content' => 
                        // '<img src="'.Yii::$app->homeUrl.'img/construcao.jpg" alt="">'
                        '<div style="background-color: white !important">'.
                                $this->render('_imovel', [
                                    'model' => $model,
                                ]).
                            '</div>',
                        'active' => true
                    ],
                    [
                        'label' => 'Registro: Pretendente',
                        'content' => '<div style="background-color: white !important">'.
                        $this->render('proponente', [
                            'model' => $model,
                            'id' => $id,
                        ]).
                        '</div>',
                        'active' => false 
                    ],
                    // 'nome',
                    [
                        'label' => 'Histórico',
                        'content' => $this->render('timeline', [
                            'model' => $model,
                            'pretendente_id' => $model->id,
                        ]),
                    ],
                    // [
                    //     'label' => 'Resumo',
                    //     // 'content' => '<div class="col-md-12">Resumo</div>',
                    //     'content' => $this->render('superlogicaresumo', [
                    //         'model' => $model,
                    //     ]),
                    //     'active' =>true
                    // ],
                ]
            ]);
            // echo $this->render('chatinterno', [
            //     'model' => $model
            // ]);
        ?>
    </div>
</div>
<?php //$this->endContent(); ?>