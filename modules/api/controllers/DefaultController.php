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
    /**
     * Renders the index view for the module
     * @return string
     */
    public $modelClass = 'app\models\SloProposta';
    public function actions () {
        
        $frente = \yii\web\UploadedFile::getInstanceByName('file_frente');
        $verso = \yii\web\UploadedFile::getInstanceByName('file_verso');
        
        // echo '<pre>';
        // print_r($frente);
        // echo '</pre>';
        // echo "\n";
        // echo '<pre>';
        // print_r($frente);
        // echo '</pre>';
        
        $actions = parent::actions();
        $modelClass->frente = 'pasta/'.$frente->baseName.'.'.$frente->extension;

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