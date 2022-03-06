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


class AntaresController extends ActiveController
{
    /**
     * Renders the index view for the module
     * @return string
     */

    public $file_cpf;
    public $file_rg_frente;
    public $file_rg_verso;
    public $file_extrato_bancario;
    public $file_imposto_de_renda;
    public $file_comprovante_de_endereco;
    public $file_carteira_de_trabalho;
    public $file_extrato_inss;


    public $modelClass = 'app\models\SloExfiles';
    public function actions () {

        $this->file_cpf = UploadedFile::getInstanceByName('file_cpf');
        $this->file_rg_frente = UploadedFile::getInstanceByName('file_rg_frente');
        $this->file_rg_verso = UploadedFile::getInstanceByName('file_rg_verso');
        $this->file_extrato_bancario = UploadedFile::getInstanceByName('file_extrato_bancario');
        $this->file_imposto_de_renda = UploadedFile::getInstanceByName('file_imposto_de_renda');
        $this->file_comprovante_de_endereco = UploadedFile::getInstanceByName('file_comprovante_de_endereco');
        $this->file_carteira_de_trabalho = UploadedFile::getInstanceByName('file_carteira_de_trabalho');
        $this->file_extrato_inss = UploadedFile::getInstanceByName('file_extrato_inss');

        $proposta_id = $_REQUEST['proposta_id'];
        $pasta = "uploads/";
        if (!empty($this->file_cpf)) { $this->file_cpf->saveAs($pasta ."_file_cpf_{$proposta_id}_" . $this->file_cpf->baseName . '.' . $this->file_cpf->extension); }
        if (!empty($this->file_rg_frente)) { $this->file_rg_frente->saveAs($pasta ."_file_rg_frente_{$proposta_id}_" . $this->file_rg_frente->baseName . '.' . $this->file_rg_frente->extension); }
        if (!empty($this->file_rg_verso)) { $this->file_rg_verso->saveAs($pasta ."_file_rg_verso_{$proposta_id}_" . $this->file_rg_verso->baseName . '.' . $this->file_rg_verso->extension); }
        if (!empty($this->file_extrato_bancario)) { $this->file_extrato_bancario->saveAs($pasta ."_file_extrato_bancario_{$proposta_id}_" . $this->file_extrato_bancario->baseName . '.' . $this->file_extrato_bancario->extension); }
        if (!empty($this->file_imposto_de_renda)) { $this->file_imposto_de_renda->saveAs($pasta ."_file_imposto_de_renda_{$proposta_id}_" . $this->file_imposto_de_renda->baseName . '.' . $this->file_imposto_de_renda->extension); }
        if (!empty($this->file_comprovante_de_endereco)) { $this->file_comprovante_de_endereco->saveAs($pasta ."_file_comprovante_de_endereco_{$proposta_id}_" . $this->file_comprovante_de_endereco->baseName . '.' . $this->file_comprovante_de_endereco->extension); }
        if (!empty($this->file_carteira_de_trabalho)) { $this->file_carteira_de_trabalho->saveAs($pasta ."_file_carteira_de_trabalho_{$proposta_id}_" . $this->file_carteira_de_trabalho->baseName . '.' . $this->file_carteira_de_trabalho->extension); }
        if (!empty($this->file_extrato_inss)) { $this->file_extrato_inss->saveAs($pasta ."_file_extrato_inss_{$proposta_id}_" . $this->file_extrato_inss->baseName . '.' . $this->file_extrato_inss->extension); }

        $actions = parent::actions();
        unset($actions['delete']);

        return $actions;
    }

}