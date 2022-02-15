<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS, CREATE');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");         
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        // header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding");
    exit(0);
}


class MensagemController extends ActiveController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $modelClass = 'app\models\Mensagem';
    public function actions () {
        $actions = parent::actions();
        unset($actions['delete']);

        // print_r($_REQUEST);
        // echo '<pre>';
        // print_r($_REQUEST);
        // echo '</pre>';
        // exit();
        return $actions;
    }

}

/**
 * 
    axios.post(this.pastalocal + "api/default/create", {
        post_id: this.idpost,
        autor: this.name,
        email: this.email,
        telefone: this.telefone,
        comentario: this.message
    })
 */