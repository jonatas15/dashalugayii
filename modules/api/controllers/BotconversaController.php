<?php

namespace app\modules\api\controllers;
use yii\rest\ActiveController;
use app\models\SloProposta as Proposta;
use app\models\Bitly;
use app\models\Mail;
/**
 * Default controller for the `api` module
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS, CREATE');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
// header("Content-Type: application/x-www-form-urlencoded");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");         
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        // header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding");
    exit(0);
}


class BotconversaController extends ActiveController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $modelClass = 'app\models\Historicodedisparos';
    public function actions () {
        
        $actionbotconversa = $_REQUEST['acaobotconversa'];

        $url = 'https://backend.botconversa.com.br/api/v1/webhook/subscriber/';
        $key = '2575d5e8-9f95-4338-9cb0-cf8f2b23ab44';
        
        $nome = $_REQUEST['nome'];
        $idproposta = $_REQUEST['idproposta'];
        $tipo = $_REQUEST['tipo'];
        $mensagem = $_REQUEST['mensagem'];
        $nome_arr = explode(' ', $nome);
        $primeiro_nome = $nome_arr[0];
        $segundo_nome = $nome_arr[1];

        $telefonexx = $_REQUEST['telefone'];
        $telefone_para_api = $this->telefone_api($telefonexx);

        switch ($actionbotconversa) {
            case 'add_subscrito':
                $curl = curl_init();

                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_URL, $url);

                //Como array
                $arr_enviar = [
                    "phone" => $telefone_para_api,
                    "first_name" => $primeiro_nome,
                    "last_name" => $segundo_nome,
                ];
            
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($arr_enviar));

                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    "Content-Type: application/json",
                    "API-KEY: $key",
                ));

                $response = curl_exec($curl);

                if ($error = curl_error($curl)) {
                    throw new \Exception($error);
                }

                curl_close($curl);

                $response = json_decode($response, true);
                break;
            case 'return_id_subscrito':
                $curl = curl_init();

                // set url: para retornar dados do Botconversa, tenha sempre o "/" no final da URL - DICA DE OURO
                curl_setopt($curl, CURLOPT_URL, $url.$telefone_para_api.'/');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                //chave
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    "Content-Type: application/json",
                    "API-KEY: $key"
                ));
                // Captura as informações,em string
                $output = curl_exec($curl);
                if(!$output){
                    die("Sem conectar...");
                }
                // Fecha a conexão com a API
                curl_close($curl); 
                //Torna Objeto para captura dos dados
                $output = json_decode($output);
                $proposta = Proposta::find()->where(['id'=>$idproposta])->one();
                // URL - geração única, boraaa
                $complementando = '/'.$idproposta.'X'.$proposta->proprietario_info;
                $url = 'https://alugadigital.com.br/'.($proposta->tipo === 'Credpago' ? 'credpago' : 'seguro-fianca').$complementando;
                
                //Gera a URL encurtada!
                $bitly = new Bitly('o_21m850qm97', 'dc5e209e26b7595ba7e956d3e22e2ff50a516cf8');
                $bitly->shorten($url);

                // Mais dados de URL
                $proposta->url = $url;
                $proposta->shorturl = $bitly->debug();
                $proposta->apibotsubs = $output->id;
                $proposta->save();
                break;
            case 'send_msg':
                $curl = curl_init();

                $proposta = Proposta::findOne($idproposta);
                $subscriberid = $proposta->apibotsubs;

                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_URL, $url."$subscriberid/send_message/");

                //Como array
                $mensagem1 = "*Cadastro recebido. Em análise.* \n \n".
                    "Ual! Ficamos felizes em conhecer você 😍 \n \n".
                    "A partir de agora seu cadastro está em análise! Em até 1 dia útil retornamos com o resultado 🙌 \n \n".
                    "Qualquer dúvida não hesite em nos contatar. 🤝 \n \n".
                    "Acompanhe aqui seu processo 👉 {$proposta->shorturl} \n \n"."[*Mensagem automática da AlugaDigital*] 📢";

                $arr_enviar = [
                    "type" => "text",
                    "value" => $mensagem1
                ];
                
                
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($arr_enviar));
                
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    "Content-Type: application/json",
                    "API-KEY: $key",
                ));

                $response = curl_exec($curl);
                $response = json_decode($response, true);

                if ($error = curl_error($curl)) {
                    throw new \Exception($error);
                    $retorno = 0;
                } else {
                    $retorno = 1;
                }

                curl_close($curl);
                $this->atualizaremail($proposta);
                // echo '<pre>';
                // echo "$subscriberid";
                // print_r($response);
                // echo '</pre>';
                break;
            case 'send_msg_ultimafatura':
                $curl = curl_init();

                $proposta = Proposta::findOne($idproposta);
                # => ID botconversa do Cliente
                // $subscriberid = $proposta->apibotsubs;
                
                # => ID botconversa da Aluga Digital
                // $subscriberid = '12651452';
                
                # => ID botconversa do Webmaster Bonitão
                $subscriberid = '33787259';

                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_URL, $url."$subscriberid/send_message/");

                $mensagem1 = "📋 *Documentação recebida: Última Fatura* 📋 \n \n".
                    "Pretendente: {$proposta->nome} \n".
                    "Ver no Sistema: https://alugadigital.com.br/adigitalsistema/proposta/update?id={$proposta->id} \n".
                    "Url para o Cliente: {$proposta->shorturl} \n \n".
                    "⚙️ [*Mensagem automática da AlugaDigital*] ⚙️";

                $arr_enviar = [
                    "type" => "text",
                    "value" => $mensagem1
                ];
                
                curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($arr_enviar));
                
                curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                    "Content-Type: application/json",
                    "API-KEY: $key",
                ));

                $response = curl_exec($curl);
                $response = json_decode($response, true);

                if ($error = curl_error($curl)) {
                    throw new \Exception($error);
                    $retorno = 0;
                } else {
                    $retorno = 1;
                }

                curl_close($curl);
                $this->atualizaremail($proposta);
                
                break;
            default:
                null;
                break;
        }

        // var_dump('Response:', $response);
        // echo '<pre>';
        // print_r($response);
        // echo '</pre>';
        // echo '<pre>';
        // print_r($arr_enviar);
        // echo '</pre>';

        // $this->apibotget($telefone_para_api, $proposta_id);
        // if ($response['error_message']) {
        //     return 0;
        // } else {
        //     return 1;
        // }
        
        $actions = parent::actions();
        unset($actions['delete']);

        return $actions;
    }

    // Métoods extras
    public function clean($string) {
        $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 
        return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.
     }
     public function telefone_api($telefone) {
        $telefone_clean = $this->clean($telefone);
        $fone_arr = str_split($telefone_clean);

        $telefone_para_api = '+55'.$fone_arr[0].$fone_arr[1]
        .$fone_arr[3].$fone_arr[4].$fone_arr[5].$fone_arr[6]    //retiramos o arr[2] ou terceiro número, que é o nono dígito
        .$fone_arr[7].$fone_arr[8].$fone_arr[9].$fone_arr[10];
        return $telefone_para_api;
    }
    public function atualizaremail ($model) {
        // $model = Proposta:($id);
        
        $texto_status = 'Em análise';
        switch ($model->opcoes) {
            case '0': $texto_status = 'Não há pendências'; break;
            case '1': $texto_status = 'Precisa de fatura'; break;
            case '2': $texto_status = 'Precisa de Co-responsável'; break;
            case '3': $texto_status = 'Reprovado'; break;
        }
        
        $titulo_email = "Cadastro recebido. Em análise.";
        $textos_email = "<p>Ual! Ficamos felizes em conhecer você 😍 </p>
            <p>A partir de agora seu cadastro está <strong>em análise</strong>! Em até 1 dia útil retornamos com o resultado 🙌 🤝 </p>
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
                    break;
                case '1':
                    $titulo_email = "Opa! Cadastro com pendências. 😕";
                    $textos_email = "
                        <p>
                        A $credpagoouseg solicitou mais alguns dados para completar sua análise. Favor acessar e conferir seu processo através do botão abaixo.
                        <br>
                        Qualquer dúvida estamos aqui à sua disposição! 😉
                        </p>";
                    break;
                case '2':
                    $titulo_email = "Opa! Cadastro com pendências. 😕";
                    $textos_email = "
                        <p>
                        A $credpagoouseg solicitou mais alguns dados para completar sua análise. Favor acessar e conferir seu processo através do botão abaixo.
                        <br>
                        Qualquer dúvida estamos aqui à sua disposição! 😉
                        </p>";
                    break;
                case '3':
                    $titulo_email = "Ops, cadastro não aprovado 😕";
                    $textos_email = "
                        <strong>Não desanime!</strong><br>
                        Nossa equipe de locações em breve fará contato contigo para melhor lhe atender! 😉
                        </p>";
                    break;
            }
        endif;
        switch ($model->etapa_andamento) {
            case '3':
                $titulo_email = "Cadastro APROVADO 🥳";
                $textos_email = "
                    <p>
                    Que felicidade 🙌😄 seu cadastro está aprovadíssimooo! 
                    </p><p>
                    Para finalizar precisamos de mais alguns dados, prometo que vai ser rápido. Favor acesse seu processo através do botão abaixo.
                    </p><p>                    
                    Qualquer dúvida estamos aqui à sua disposição! 😉
                    </p>";
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
                break;
            case '5':
                $titulo_email = "Contrato pronto para assinatura!";
                $textos_email = "
                    <p>
                    Chegou a hora de você assinar seu contrato digital. Em breve você estará morando no seu novo imóvel 😊
                    <p></p>
                    Clique no botão abaixo para proceder com a assinatura.
                    <p>
                    Viu só? tudo digital, rápido e sem burocracia né?! 😉
                    </p>";
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
                break;
        }

        $msg = '<center>';
        $msg.= "<h2>$titulo_email</h2>";
        $msg.= '<hr>';
        $msg.= '<p>';
        // $msg.= 'Etapa: "<strong>'.$model->etapa_andamento.'</strong>"';
        // $msg.= '</p>';
        // $msg.= '<p>';
        // $msg.= 'Status da negociação 😀: "'.$texto_status.'"';
        $msg.= "<p>$textos_email</p>";
        $msg.= '</p>';

        $msg.= '<p>';
        $msg.= '<a style="cursor: pointer" href="'.$model->shorturl.'"><button style="cursor: pointer;background-color: white; color: black; font-weight: bolder; padding: 10px 20px; border: 5px solid black; border-radius: 0px;font-size: 20px">Acompanhe seu processo</button></a>';
        $msg.= '<br /><br />Ou acesse "<a href="'.$model->shorturl.'">'.$model->shorturl.'</a>"';
        $msg.= '</p>';
        $msg.= '<img src="https://alugadigital.com.br/img/AlugaDigital-02.png" width="100">';
        $msg.= '</center>';
            
        $assunto = $titulo_email;    
            

        // echo $assunto;
        // echo '<br>';
        // echo $msg;
        // exit();

        $mododisparo = [
            'assinatura' => 'AlugaDigital <atendimento@alugadigital.com>'
        ];

        if(Mail::send($model->email, $assunto, $msg, $mododisparo)){
            $alerta_enviado .= "Sucesso: Atualização enviada para {$usuario->nome} - {$usuario->email} <br>";//'enviou!';                            
            // echo $model->email;
            // exit();
            $disparo = new \app\models\Historicodedisparos();
            $disparo->data = date('Y-m-d h:i:s');
            $disparo->proposta_id = $model->id;
            $disparo->mensagem = utf8_encode($msg.'<p>Mensagem enviada para '.$model->email.'</p>');
            $disparo->usuario_id = 1;
            $disparo->etapa = $model->etapa_andamento;
            $disparo->modo = 'email';

            $disparo->save();

        }
    }
}