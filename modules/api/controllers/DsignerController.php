<?php
    
    
    namespace app\modules\api\controllers;
    
    use yii\rest\ActiveController;
    // Futuramente talvez enviar docs ao d4sign por aqui:
    // use yii\web\UploadedFile;
    
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


class DsignerController extends ActiveController
{
    /**
     * Renders the index view for the module
     * @return string
     */

    public $url = "https://secure.d4sign.com.br/api/v1/documents/616c783c-74be-4dae-8da0-0b4a078de5ea/list?tokenAPI=live_8d98ce1ce19b695d27359ab3245f74237ef944f39536104ad4d9b8fadb487f12&cryptKey=live_crypt_ES70OaqIxBML9bPR0ZlXYaXZOU0T3pm9";


    public $modelClass = 'app\models\SloProposta';
    public function actions () {

        
        $actions = parent::actions();
        unset($actions['delete']);

        return $actions;
        
    }

}