<?php

namespace app\modules\api\controllers;

use yii\rest\ActiveController;
use yii\web\UploadedFile;

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


class ProprietarioController extends ActiveController
{
    /**
     * Renders the index view for the module
     * @return string
     */

    public $file_cpf;
    public $file_rg;


    public $modelClass = 'app\models\Proprietario';
    public function actions () {

        $this->file_rg = UploadedFile::getInstanceByName('file_foto_rg');
        $this->file_cpf = UploadedFile::getInstanceByName('file_foto_cpf');

        $proposta_id = $_REQUEST['codigo_imovel'];
        $pasta = "uploads/";
        if (!empty($this->file_cpf)) { $this->file_cpf->saveAs($pasta ."_file_cpf_proprietario_{$proposta_id}_" . $this->file_cpf->baseName . '.' . $this->file_cpf->extension); }
        if (!empty($this->file_rg)) { $this->file_rg->saveAs($pasta ."_file_rg_proprietario_{$proposta_id}_" . $this->file_rg->baseName . '.' . $this->file_rg->extension); }

        $actions = parent::actions();
        unset($actions['delete']);

        return $actions;
    }

}