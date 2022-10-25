<?php

namespace app\controllers;

use Yii;
use app\models\Visitchaves;
use app\models\VisitchavesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use kartik\editable\Editable;
use yii\widgets\MaskedInput;

/**
 * VisitchavesController implements the CRUD actions for Visitchaves model.
 */
class VisitchavesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Visitchaves models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VisitchavesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExcell()
    {
        // $searchModel = new VisitchavesSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('excell', []);
    }

    /**
     * Displays a single Visitchaves model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Visitchaves model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function dataviewtodb($data) {
        $rarr = explode("/", $data);
        return $rarr[2].'-'.$rarr[1].'-'.$rarr[0];
    }
    public function datadbtoview($data) {
        $rarr = explode("-", $data);
        return $rarr[2].'/'.$rarr[1].'/'.$rarr[0];
    }

    public function actionCreate()
    {
        $model = new Visitchaves();

        if ($model->load(Yii::$app->request->post())) {
            $model->data_visita = $this->dataviewtodb($model->data_visita);
            if($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Visitchaves model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Visitchaves model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Visitchaves model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Visitchaves the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Visitchaves::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function clean($string) {
        $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 
        return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.
    }

    public function actionEditcampo($id, $tabela, $campo){
        // Yii::$app->homeUrl."alerta/sendwhats?msg=$mensagem&num=$fone"
        // echo $tabela;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $valor = $_REQUEST[$campo];
        $model = $this->findModel($id);
        // $model = SloProposta::findOne($id);
        switch ($campo) {
            case 'data': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'data_nascimento': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'data_expedicao': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'documento_data_emissao': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'data_admissao': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'cnj_data_nascimento': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'data_visita': $model->$campo = $this->dataviewtodb($valor); break;
            case 'cpf': $model->$campo = $this->clean($valor); break;
            case 'cnj_cpf': $model->$campo = $this->clean($valor); break;
            case 'cep': $model->$campo = $this->clean($valor); break;
            case 'end_cep': $model->$campo = $this->clean($valor); break;
            case 'celular': $model->$campo = $this->clean($valor); break;
            case 'telefone': $model->$campo = $this->clean($valor); break;
            case 'fone_celular': $model->$campo = $this->clean($valor); break;
            case 'fone_residencial': $model->$campo = $this->clean($valor); break;
            default: $model->$campo = $valor; break;
        }
        $model->save(); 
        // return 1;
        // return $this->redirect(Yii::$app->request->referrer);
        return ['output'=>$valor, 'message'=>''];
    }
    public function imprime_campo($tabela, $campo, $title, $valor, $id, $conj = null) {
        $input = Editable::INPUT_TEXT;
        $editableoptions = [
                'class'=>'form-control',
        ];
        $widgetClass = '';

        if (in_array($campo,['data', 'data_nascimento', 'data_expedicao', 'documento_data_emissao', 'data_admissao'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '99/99/9999'
            ];
            $widgetClass = MaskedInput::className();
        }
        if (in_array($campo,['cpf', 'cnj_cpf'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '999.999.999-99',
                'value' => $valor
            ];
            $widgetClass = MaskedInput::className();
        }
        if (in_array($campo,['cep', 'end_cep'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '99.999-999'
            ];
            $widgetClass = MaskedInput::className();
        }
        if (in_array($campo,['celular', 'telefone_celular', 'whatsapp', 'telefone', 'fone', 'telefone_residencial','fone_residencial', 'fone_celular'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => ['(99)9999-9999','(99)99999-9999']
            ];
            $widgetClass = MaskedInput::className();
        }

        $retorno = '<label>'.$title.'</label><br />';
        $retorno .= Editable::widget([
            'language' => 'pt_BR',
            'name'=> $campo, 
            'asPopover' => false,
            'value' => $valor,
            'displayValue' => $valor,
            'header' => 'Name',
            'size'=>'md',
            'options' => $editableoptions,
            'inputType' => $input,
            'widgetClass' => $widgetClass,
            'id' => ($conj?'conjuge_':'').$tabela.'_invisivel_'.$campo,
            'formOptions' => [
                'action' => [
                    'editcampo',
                    'id' => $id,
                    'tabela' => $tabela,
                    'campo' => $campo
                ]
            ],
            'valueIfNull' => 'valor alterado'
        ]);
        $retorno .= "<br>";
        $retorno .= "<br>";
        $retorno .= "<br>";
        return $retorno;
    }
    public function format_doc($doc,$tipo){
        $doc = trim($doc);
        $doc = $this->clean($doc);
        switch ($tipo) {
            case 'cpf': $f = str_split($doc,3); $retorno = $f[0].'.'.$f[1].'.'.$f[2].'-'.$f[3]; break;
            case 'cep': $f = str_split($doc,5); $retorno = $f[0].'-'.$f[1]; break;
            case 'cnpj': 
                $f = str_split($doc,1); 
                // XX. XXX. XXX/0001-XX
                $retorno = $f[0].$f[1].'.'.$f[2].$f[3].$f[4].'.'.$f[5].$f[6].$f[7].'/'.$f[8].$f[9].$f[10].$f[11].'-'.$f[12].$f[13]; 
                break;
            default: $retorno = null; break;
        }
        return $retorno;        
    }
    public function format_telefone($fone){
        $fone = $this->clean($fone);
        $f = str_split($fone,1);
        $ddd = $f[0].$f[1];
        $g1 = '';
        if(count($f) == 11){
          $g1 = $f[2].' '.$f[3].$f[4].$f[5].$f[6].'-'.$f[7].$f[8].$f[9].$f[10];
        }else{
          $g1 = $f[2].$f[3].$f[4].$f[5].'-'.$f[6].$f[7].$f[8].$f[9];
        }
        return '('.$ddd.') '.$g1;
    }
    public function imprime_campo_editavel($col_md, $tabela, $campo, $title, $valor, $id, $conj = null) {
        $input = Editable::INPUT_TEXT;
        $editableoptions = [
                'class'=>'form-control',
        ];
        $widgetClass = '';
        $valore = $valor;
        $data = [];
        $displayValueConfig = [];

        $submitOnEnter = true;

        if (in_array($campo,['data', 'data_nascimento', 'cnj_data_nascimento', 'data_expedicao', 'documento_data_emissao', 'data_admissao', 'data_visita'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '99/99/9999'
            ];
            $widgetClass = MaskedInput::className();
            $valor = $this->datadbtoview($valor);
            $valore = $valor;
        }
        if (in_array($campo,['cpf', 'cnj_cpf'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '999.999.999-99',
                'value' => $valor
            ];
            $widgetClass = MaskedInput::className();
        }
        if (in_array($campo,['feedbacks'])) {
            $input = Editable::INPUT_TEXTAREA;
            $editableoptions = [
                'class' => 'form-control',
                'value' => $valor,
            ];
            $submitOnEnter = false;
        }
        if (in_array($campo,['hora', 'hora_visita'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '99:99:00',
                'value' => $valor
            ];
            $widgetClass = MaskedInput::className();
        }
        if (in_array($campo,['cep', 'end_cep'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '99.999-999'
            ];
            $widgetClass = MaskedInput::className();
        }
        if (in_array($campo,['cpf_cnpj'])) {
            // XX. XXX. XXX/0001-XX
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => ['999.999.999-99', '99.999.999/9999-99'],
                'value' => $valor
            ];
            $widgetClass = MaskedInput::className();
            if (strlen($this->clean($valor)) == 11) {
                $valore = $this->format_doc($valor, 'cpf');
            } else {
                $valore = $this->format_doc($valor, 'cnpj');
            }
        }
        if (in_array($campo,['celular', 'telefone_celular', 'whatsapp', 'telefone', 'fone', 'telefone_residencial','fone_residencial', 'fone_celular', 'num_disparo'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => ['(99)9999-9999','(99)99999-9999']
            ];
            $widgetClass = MaskedInput::className();
            $valore = $this->format_telefone($valor);
        }
        if (in_array($campo,['sexo'])) {
            $input = Editable::INPUT_DROPDOWN_LIST;
            $data = ['M' => 'Masculino', 'F' => 'Feminino', 'I' => 'Indefinido'];
            switch ($valor) {
                case 'M': $valore = "Masculino"; break;
                case 'F': $valore = "Feminino"; break;
                case 'I': $valore = "Indefinido"; break;
                default: $valore = "Masculino"; break;
            }
            $displayValueConfig = [
                'M' => "Masculino",
                'F' => "Feminino",
                'I' => "Indefinido"
            ];
        }
        if (in_array($campo, ['tipovisitante'])) {
            $input = Editable::INPUT_DROPDOWN_LIST;
            $data = [ 'Corretor' => 'Corretor', 'Corretor externo' => 'Corretor externo', 'Cliente' => 'Cliente', ];
            $valore = $valor;
        }
        if ($title) {
            $retorno = '<label>'.$title.' </label>';
        }
        $retorno .= Editable::widget([
            'language' => 'pt_BR',
            'name'=> $campo, 
            'asPopover' => false,
            'value' => $valor,
            'displayValue' => $valore,
            'header' => 'Name',
            'size'=>'md',
            'options' => $editableoptions,
            'inputType' => $input,
            'widgetClass' => $widgetClass,
            'submitOnEnter' => $submitOnEnter,
            'data' => $data,
            'displayValueConfig'=> $displayValueConfig,
            'id' => ($conj?'conjuge_':'').$tabela.'_invisivel_'.$campo.'_'.$id,
            'formOptions' => [
                'action' => [
                    'editcampo',
                    'id' => $id,
                    'tabela' => $tabela,
                    'campo' => $campo
                ]
            ],
            'valueIfNull' => 'valor alterado'
        ]);
        if ($title) {
            $retorno .= "<br>";
        }
        return '<div class="col-md-'.$col_md.'">'.$retorno.'</div>';
    }

    /**
     * Exportar PDF
     * E gera campos de PDF
    **/
    private function campopdf($label, $valor) {
        return '<exp style="font-size: 10px; color: blue">'.$label.':</exp><br><strong>'.$valor.'</strong><br><br>';
    }

    /**
     * Ajustes
     */
    public function actionBotmensagem($id) {
        $id = $_REQUEST['id'];
        $atualiza = $this->findModel($id);
        $subscriberid = $atualiza->botconversaid;
        $url = 'https://backend.botconversa.com.br/api/v1/webhook/subscriber/';
        $key = '2575d5e8-9f95-4338-9cb0-cf8f2b23ab44';
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_URL, $url."$subscriberid/send_message/");

        //Como array
        $mensagem1 = "*Atualização no seu Imóvel PIN-{$atualiza->codigo_imovel}* \n \n".
            "".trim($atualiza->feedbacks)." \n".
            "Qualquer dúvida não hesite em nos contatar. 🤝 \n \n".
            "[*Mensagem automática da AlugaDigital*] 📢";

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
        $atualiza->msg_enviada = 1;
        // Cadastra
        if($atualiza->save()) {
            return 1;
        } else {
            return 0;
        }
    }
    public function actionRetornabot($id) {
        $url = 'https://backend.botconversa.com.br/api/v1/webhook/subscriber/';
        $key = '2575d5e8-9f95-4338-9cb0-cf8f2b23ab44';
        $telefonexx = $_REQUEST['telefone'];
        $id = $_REQUEST['id'];
        $telefone_para_api = $this->telefone_api($telefonexx);
        
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
        // Torna Objeto para captura dos dados
        $output = json_decode($output);
        // return $output->id;
        $atualiza = $this->findModel($id);
        $atualiza->botconversaid = $output->id;
        // Cadastra
        if($atualiza->save()) {
            return $atualiza->botconversaid;
        } else {
            return 0;
        }
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
