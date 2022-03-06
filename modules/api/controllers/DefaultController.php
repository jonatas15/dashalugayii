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


class DefaultController extends ActiveController
{
    public $frente;
    public $verso;
    public $conj_frente;
    public $conj_verso;
    /**
     * Renders the index view for the module
     * @return string
     */
    public $modelClass = 'app\models\SloProposta';
    public function actions () {
        
        $this->frente = \yii\web\UploadedFile::getInstanceByName('file_frente');
        $this->verso = \yii\web\UploadedFile::getInstanceByName('file_verso');
        $this->conj_frente = \yii\web\UploadedFile::getInstanceByName('file_conj_frente');
        $this->conj_verso = \yii\web\UploadedFile::getInstanceByName('file_conj_verso');

        // $aleatorio = rand(10000,99999).'_arquivo_';
        $pasta = "uploads/";

        // function uploadimagem($file) {
        //     $aleatorio = rand(10000,99999).'_arquivo_';
        //     $pasta = "uploads/";
        //     // $uploadfile = $pasta . $aleatorio . basename($file->name);
        //     // if (move_uploaded_file($file->tmp_name, $uploadfile)) {
        //     //     return $uploadfile;
        //     // }
        //     $file->saveAs($pasta . $aleatorio . $file->baseName . '.' . $file->extension);
        // }

        // uploadimagem($frente);
        $request_numero = $_REQUEST['cpf'];
        if (!empty($this->frente)) {
            $this->frente->saveAs($pasta ."_frente_{$request_numero}_" . $this->frente->baseName . '.' . $this->frente->extension);
        }
        if (!empty($this->verso)) {
            $this->verso->saveAs($pasta ."_verso_{$request_numero}_" . $this->verso->baseName . '.' . $this->verso->extension);
        }
        if (!empty($this->conj_frente)) {
            $this->conj_frente->saveAs($pasta ."_conj_frente_{$request_numero}_" . $this->conj_frente->baseName . '.' . $this->conj_frente->extension);
        }
        if (!empty($this->conj_verso)) {
            $this->conj_verso->saveAs($pasta ."_conj_verso_{$request_numero}_" . $this->conj_verso->baseName . '.' . $this->conj_verso->extension);
        }
        
        // echo '<pre>';
        // print_r($request_numero);
        // echo '</pre>';
        // echo "\n";
        // echo '<pre>';
        // print_r($this->frente);
        // echo '</pre>';
        
        $actions = parent::actions();
        // $modelClass->frente = 'pasta/'.$frente->baseName.'.'.$frente->extension;

        if ($action === 'create') {
            echo 'estamos criando';
        }

        unset($actions['delete']);

        // print_r($_REQUEST);
        // echo '<pre>';
        // print_r($_REQUEST);
        // echo '</pre>';
        // exit();
        return $actions;
    }
    public function actionCreate() {
        $model = $modelClass;
        $model->data_inicio = '2022-12-12 00:00:00';
        $model->save();
        // $model->file3 = UploadedFile::getInstance($model, 'frente');
        // if ($model->file3) {
        //     $model->frente = $model->file3->baseName.'.'.$model->file3->extension;
        //     $model->upload();
        // }
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