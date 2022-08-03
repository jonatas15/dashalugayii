<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;

use app\models\SloProposta as Proposta;

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
                $mensagem1 = "*Cadastro recebido. Em análise.* 👏🙌 \n \n".
                    "Ual! Ficamos felizes em conhecer você 😍 \n \n".
                    "A partir de agora seu cadastro está em análise! Em até 1 dia útil retornamos com o resultado 🙌 \n \n".
                    "Qualquer dúvida não hesite em nos contatar. 🤝 \n \n".
                    "Acompanhe aqui seu processo 👉 link_aqui \n \n"."[*Mensagem automática da AlugaDigital*] 📢";

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
                // echo '<pre>';
                // echo "$subscriberid";
                // print_r($response);
                // echo '</pre>';
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
}