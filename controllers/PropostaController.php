<?php

namespace app\controllers;

use Yii;
use app\models\SloProposta;
#Auxiliares
use app\models\SloPretendente;
use app\models\SloInfospessoais;
use app\models\SloInfosprofissionais;
use app\models\SloContratodocumento;
use app\models\SloConjuje;
use app\models\SloRefbancaria;
use app\models\SloMoratual;
use app\models\SloOcupante;
use app\models\SloFiador;
use app\models\Proprietario;

use app\models\PropostaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\UploadedFile;

use app\models\Usuario;
use app\models\User as User2;
use app\models\LoginForm;
use app\models\Chtopico;

use app\models\SaAlerta;
use app\models\Mail;
use app\models\Bitly;
use app\models\Historicodedisparos;

use yii\helpers\Json;

use kartik\mpdf\Pdf;

use kartik\editable\Editable;
use yii\widgets\MaskedInput;

/**
 * PropostaController implements the CRUD actions for SloProposta model.
 */
class PropostaController extends Controller
{
    /**
     * @inheritdoc
     */


    public function callAPI($method, $url, $data, $chave){
        $curl = curl_init();
        switch ($method){
           case "POST":
              curl_setopt($curl, CURLOPT_POST, 1);
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
              break;
           case "PUT":
              curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
              break;
           default:
              if ($data)
                 $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
           'API-KEY: '.$chave.'',
           'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection deu Merdis");}
        curl_close($curl);
        return $result;
     }

    public $estadosBrasileiros = [
        'AC'=>'Acre',
        'AL'=>'Alagoas',
        'AP'=>'Amapá',
        'AM'=>'Amazonas',
        'BA'=>'Bahia',
        'CE'=>'Ceará',
        'DF'=>'Distrito Federal',
        'ES'=>'Espírito Santo',
        'GO'=>'Goiás',
        'MA'=>'Maranhão',
        'MT'=>'Mato Grosso',
        'MS'=>'Mato Grosso do Sul',
        'MG'=>'Minas Gerais',
        'PA'=>'Pará',
        'PB'=>'Paraíba',
        'PR'=>'Paraná',
        'PE'=>'Pernambuco',
        'PI'=>'Piauí',
        'RJ'=>'Rio de Janeiro',
        'RN'=>'Rio Grande do Norte',
        'RS'=>'Rio Grande do Sul',
        'RO'=>'Rondônia',
        'RR'=>'Roraima',
        'SC'=>'Santa Catarina',
        'SP'=>'São Paulo',
        'SE'=>'Sergipe',
        'TO'=>'Tocantins'
    ];

    public function returnEstado($valor, $modo) {
        if ($modo == 'sigla') {
            foreach ($this->estadosBrasileiros as $key => $value) {
                if ($value == $valor) {
                    $retorno = $key;
                }
            }
        } else {
            foreach ($this->estadosBrasileiros as $key => $value) {
                if ($key == $valor) {
                    $retorno = $value;
                }
            }
        }
        return $retorno;
    }

    public $arr_campos_retirados_docs_conj = [
        'id_conjuge_pretendente',
        'slo_pretendente_id',
        'id',
        'selfie_documento',
        'endereco_atual',
        'endereco',
        'end_numero',
        'end_cidade',
        'end_cep',
        'end_complemento',
        'end_bairro',
        'end_estado',
        'estado_civil',
        'nome_conjuge',
        'selfie_documento',
        'frente_documento',
        'verso_documento',
        'selfie_com_documento',
        'outros_comprovantes',
    ];

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
     * Lists all SloProposta models.
     * @return mixed
     */

     public function actionLogincliente()
     {
         if (Yii::$app->user->can('administrador')) {
             //return $this->render('view');
         } else {
             return $this->render('logincliente');
         }
     }

    public function actionIndex()
    {
        if (Yii::$app->user->can('administrador') or Yii::$app->user->can('locacao') or Yii::$app->user->can('corretor')) {
            $searchModel = new PropostaSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            return $this->goHome();
        }
    }

    /**
     * Displays a single SloProposta model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (Yii::$app->user->can('administrador') or Yii::$app->user->can('locacao') or Yii::$app->user->can('corretor')) {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        } else {
            return $this->goHome();
        }
    }

    /**
     * Creates a new SloProposta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->can('administrador') or Yii::$app->user->can('locacao') or Yii::$app->user->can('corretor')) {
            $model = new SloProposta();

            if ($model->load(Yii::$app->request->post())) {
                $model->prazo_responder = date("Y-m-d", strtotime($model->prazo_responder));
                $model->data_inicio = date("Y-m-d");
                if ($model->save()) {
                    # code...
                    return $this->redirect(['update', 'id' => $model->id]);
                }
            } else {
                // return $this->renderPartial('create', [
                if ($_REQUEST['codigo']) {
                    $model_duplicata = SloProposta::findOne(['id'=>$_REQUEST['codigo']]);
                    return $this->render('create', [
                        'model' => $model_duplicata,
                    ]);
                } else {
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }  
            }
        } else {
            return $this->goHome();
        }
    }

    /**
     * Updates an existing SloProposta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('administrador') or Yii::$app->user->can('locacao') or Yii::$app->user->can('corretor')) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {
                if ($_REQUEST['sloproposta-aluguel-disp']) {
                    $model->aluguel = $this->clean($_REQUEST['sloproposta-aluguel-disp']);
                }
                $model->prazo_responder = date("Y-m-d", strtotime($model->prazo_responder));
                if($model->save()){
                    return $this->redirect(['update', 'id' => $model->id]);
                }
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->goHome();
        }
    }

    /**
     * Deletes an existing SloProposta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->can('administrador')) {
            $this->findModel($id)->delete();

            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->goHome();
        }
    }
    public function actionDelete_ocupante($id)
    {
        \app\models\SloOcupante::findOne($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);

    }

    public function actionDelete_fiador($id)
    {
        \app\models\SloFiador::findOne($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);

    }

    public function actionDeletar_comprovante($id, $comprovante)
    {
        $comp = \app\models\SloContratodocumento::findOne($id);
        // echo $comprovante;
        // echo "<br>";
        $novo_registro = str_replace($comprovante.';', "", $comp->outros_comprovantes);
        $comp->outros_comprovantes = $novo_registro;
        $comp->save();


        // $comprovante

        return $this->redirect(Yii::$app->request->referrer);

    }

    /**
     * Finds the SloProposta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SloProposta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SloProposta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //Limpa caracteres especiais

    public function clean($string) {
       $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
       $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

       return preg_replace('/-+/', '', $string); // Replaces multiple hyphens with single one.
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
    // Função Término de cadastro de informações do pretendente
    public function actionConcluido($proposta_id, $pretendente_id) {
        $proposta = SloProposta::findOne($proposta_id);
        $pretendente = SloPretendente::findOne($pretendente_id);

        $this->layout = 'layoutnovo';
        return $this->render('concluido', [
            'pretendente' => $pretendente,
            'proposta' => $proposta,
        ]);
    }
    #Editar Ocupantes
    public function actionEditocp($id){

        $ocupante = SloOcupante::findOne($id);

        if ($ocupante->load(Yii::$app->request->post())) {

            $ocupante->cpf = $this->clean($_REQUEST['editado_cpf']);

            $ocupante__data_expedicao = str_replace('/','-', $_REQUEST['editado_data_expedicao']);
            $ocupante->data_expedicao = date('Y-m-d',strtotime($ocupante__data_expedicao));

            $ocupante__data_nascimento = str_replace('/','-', $_REQUEST['editado_data_nascimento']);
            $ocupante->data_nascimento = date('Y-m-d',strtotime($ocupante__data_nascimento));

            if ($ocupante->sexo == '') {
                $ocupante->sexo = 'M';
            }
            if ($ocupante->tipo_documento == '') {
                $ocupante->tipo_documento = 'rg';
            }

            if ($ocupante->save()) {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }
    #Add Ocupante Conjuge
    public function actionAdd_ocupante_conjuge(){
        $valor = $_REQUEST['val'];
        $id_prep = $_REQUEST['id'];
        $pretendente = SloInfospessoais::findOne($id_prep);
        if ($valor == 0) {
            $pretendente->vai_morar = 1;
            $pretendente->save();
            $vai_ocupar = SloOcupante::find()->where([
                'slo_pretendente_id' => $pretendente->pretendente_id,
                'nome' => $pretendente->nome,
            ])->one();
            if (count($vai_ocupar) > 0) {
                # code...
            } else {
                # code...
                $vai_ocupar = new SloOcupante;
            }

            $vai_ocupar->slo_pretendente_id = $pretendente->pretendente_id;
            $vai_ocupar->nome = $pretendente->nome;
            $vai_ocupar->sexo = $pretendente->genero;
            $vai_ocupar->data_nascimento = $pretendente->data_nascimento;
            $vai_ocupar->cpf = $pretendente->cpf;

            $vai_ocupar->save();
        }elseif ($valor == 1) {
            $pretendente->vai_morar = 0;
            $pretendente->save();
            $vai_ocupar = SloOcupante::find()->where([
                'slo_pretendente_id' => $pretendente->pretendente_id,
                'nome' => $pretendente->nome,
            ])->one();
            if (count($vai_ocupar) > 0) {
                # code...
                $vai_ocupar->delete();
            } else {
                # code...
            }
        }
    }
    #Add Ocupante Pretendente
    public function actionAdd_ocupante_pretendente(){
        $valor = $_REQUEST['val'];
        $id_prep = $_REQUEST['id'];
        $pretendente = SloInfospessoais::findOne($id_prep);
        if ($valor == 0) {
            $pretendente->vai_morar = 1;
            $pretendente->save();
            $vai_ocupar = SloOcupante::find()->where([
                'slo_pretendente_id' => $pretendente->pretendente_id,
                'nome' => $pretendente->nome,
            ])->one();
            if (count($vai_ocupar) > 0) {
                # code...
            } else {
                # code...
                $vai_ocupar = new SloOcupante;
            }

            $vai_ocupar->slo_pretendente_id = $pretendente->pretendente_id;
            $vai_ocupar->nome = $pretendente->nome;
            $vai_ocupar->sexo = $pretendente->genero;
            $vai_ocupar->data_nascimento = $pretendente->data_nascimento;
            $vai_ocupar->cpf = $pretendente->cpf;

            $vai_ocupar->save();
        }elseif ($valor == 1) {
            $pretendente->vai_morar = 0;
            $pretendente->save();
            $vai_ocupar = SloOcupante::find()->where([
                'slo_pretendente_id' => $pretendente->pretendente_id,
                'nome' => $pretendente->nome,
            ])->one();
            if (count($vai_ocupar) > 0) {
                # code...
                $vai_ocupar->delete();
            } else {
                # code...
            }
        }
    }

    // EDITAR AS INFORMAÇÕES DO FIADOR
    public function actionEditfiador($id) {

        $fiador = SloFiador::findOne($id);

        if ($fiador->load(Yii::$app->request->post())) {
          #Declarações para campo de NAME modificado pra manter as máscaras no campo no formulário
          #Fiador --------------------------------------------------------------------------------
          $fiador->data_nascimento     = $_REQUEST["data_nascimento_$id"];
          $fiador->data_expedicao      = $_REQUEST["data_expedicao_$id"];
          $fiador->cpf                 = $_REQUEST["cpf_$id"];
          $fiador->fone_residencial    = $_REQUEST["fone_residencial_$id"];
          $fiador->celular             = $_REQUEST["celular_$id"];
          #Empresa ------------------------------------------------------------------------------
          $fiador->fone                = $_REQUEST["fone_$id"];
          $fiador->data_admissao       = $_REQUEST["data_admissao_$id"];
          $fiador->salario             = $_REQUEST["salario_$id"];
          $fiador->outros_rendimentos  = $_REQUEST["outros_rendimentos_$id"];
          $fiador->total_rendimentos   = $_REQUEST["total_rendimentos_$id"];
          #Cônjuge ------------------------------------------------------------------------------
          $fiador->cj_data_nascimento  = $_REQUEST["cj_data_nascimento_$id"];
          $fiador->cj_cpf              = $_REQUEST["cj_cpf_$id"];
          $fiador->cj_fone_residencial = $_REQUEST["cj_fone_residencial_$id"];
          $fiador->cj_celular          = $_REQUEST["cj_celular_$id"];

          #Tratamento dos Campos
          $fiador->cpf = $this->clean($fiador->cpf);
          $fiador->fone_residencial = $this->clean($fiador->fone_residencial);
          $fiador->celular = $this->clean($fiador->celular);

          $fiador->fone = $this->clean($fiador->fone);

          $fiador->cj_cpf = $this->clean($fiador->cj_cpf);
          $fiador->cj_fone_residencial = $this->clean($fiador->cj_fone_residencial);
          $fiador->cj_celular = $this->clean($fiador->cj_celular);

          // tratar os campos com data
          $fiador->data_nascimento = str_replace('/','-', $fiador->data_nascimento);
          $fiador->data_nascimento = date('Y-m-d',strtotime($fiador->data_nascimento));

          $fiador->data_expedicao = str_replace('/','-', $fiador->data_expedicao);
          $fiador->data_expedicao = date('Y-m-d',strtotime($fiador->data_expedicao));

          $fiador->data_admissao = str_replace('/','-', $fiador->data_admissao);
          $fiador->data_admissao = date('Y-m-d',strtotime($fiador->data_admissao));

          $fiador->cj_data_nascimento = str_replace('/','-', $fiador->cj_data_nascimento);
          $fiador->cj_data_nascimento = date('Y-m-d',strtotime($fiador->cj_data_nascimento));

          if ($fiador->genero == '') {
              $fiador->genero = 'M';
          }
          if ($fiador->tipo_documento == '') {
              $fiador->tipo_documento = 'rg';
          }

          // Setando as Informações pessoais do Fiador
          $pessoais_fiador = SloInfospessoais::findOne($fiador->sloInfospessoais->id);
          $pessoais_fiador->nome = $fiador->nome;
          $pessoais_fiador->cpf = $fiador->cpf;
          $pessoais_fiador->genero = $fiador->genero;
          $pessoais_fiador->data_nascimento = $fiador->data_nascimento;
          $pessoais_fiador->fone_residencial = $fiador->fone_residencial;
          $pessoais_fiador->celular = $fiador->celular;
          $pessoais_fiador->estado_civil = $fiador->estado_civil;
          $pessoais_fiador->genero = $fiador->genero;
          $pessoais_fiador->extrangeiro_temponopais = $fiador->extrangeiro_temponopais;
          $pessoais_fiador->numero_dependentes = $fiador->numero_dependentes;
          $pessoais_fiador->email = $fiador->email;

          // Setando as Informações profissonais do Fiador
          $prof_fiador = SloInfosprofissionais::findOne($fiador->sloInfosprofissionais->id);
          $prof_fiador->empresa = $fiador->empresa;

          $prof_fiador->fone = $fiador->fone;
          $prof_fiador->data_admissao = $fiador->data_admissao;
          $prof_fiador->profissao = $fiador->profissao;
          $prof_fiador->vinculo_empregaticio = $fiador->vinculo_empregaticio;
          $prof_fiador->salario = $fiador->salario;
          $prof_fiador->outros_rendimentos = $fiador->outros_rendimentos;
          $prof_fiador->total_rendimentos = $fiador->total_rendimentos;

          // Setando as Informações pessoais do Fiador
          $pss_conj_fiador = SloInfospessoais::findOne($fiador->sloFiadorconjuges->sloInfospessoais->id);
          $pss_conj_fiador->nome = $fiador->cj_nome;
          $pss_conj_fiador->cpf = $fiador->cj_cpf;
          $pss_conj_fiador->genero = $fiador->cj_genero;
          $pss_conj_fiador->data_nascimento = $fiador->cj_data_nascimento;
          $pss_conj_fiador->fone_residencial = $fiador->cj_fone_residencial;
          $pss_conj_fiador->celular = $fiador->cj_celular;
          $pss_conj_fiador->estado_civil = $fiador->cj_estado_civil;
          $pss_conj_fiador->genero = $fiador->cj_genero;
          $pss_conj_fiador->extrangeiro_temponopais = $fiador->cj_extrangeiro_temponopais;
          $pss_conj_fiador->numero_dependentes = $fiador->cj_numero_dependentes;
          $pss_conj_fiador->email = $fiador->cj_email;

          if ($fiador->save()) {
              $pessoais_fiador->slo_fiador_id = $fiador->id;
              $prof_fiador->slo_fiador_id = $fiador->id;



                $pessoais_fiador->save();
                $prof_fiador->save();
                $pss_conj_fiador->save();

                Yii::$app->session->setFlash('success', 'Fiador editado com sucesso!');
                return $this->redirect(Yii::$app->request->referrer);
              }
        }
    }

    // ATUALIZANDO O Pretendente
    public function actionPretfiador() {
      $valor = $_REQUEST['val'];
      $id_prep = $_REQUEST['id'];
      if ($valor != '') {
          $pretendente = SloPretendente::findOne($id_prep);
          $pretendente->tipo_fiador = $valor;
          $pretendente->save();
      }
      exit();
    }

    public function addtopicoch($id_checklist, $conteudo, $etapa) {
        $topico = new Chtopico();
        $topico->checklist_id = $id_checklist;
        $topico->conteudo = $conteudo;
        $topico->etapa = $etapa;
        $topico->save();
    }

    public function actionDeletetopico($id) {
        Chtopico::findOne($id)->delete();
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function superlogicaproprietario($codigo_imovel) {

         $proprietario = \app\models\Proprietario::find()->where([
             'codigo_imovel' => $codigo_imovel,
         ])->one();

        $jatem_superlogica = "";
        if ($proprietario->superlogica != "") {
            $jatem_superlogica = '"ID_PESSOA_PES": "'.$proprietario->superlogica.'",';
        }

        $ch = curl_init("http://apps.superlogica.net/imobiliaria/api/proprietarios/put");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);

        $model = $proprietario;

        $a_enviar = json_encode('{
            '.$jatem_superlogica.'
            "ST_NOME_PES": "'.$model->nome.'",
            "ST_FANTASIA_PES": "'.$model->nome.'",
            "ST_CNPJ_PES": "'.$model->cpf_cnpj.'",
            "ST_CELULAR_PES": "'.$this->clean($model->celular).'",
            "ST_TELEFONE_PES": "'.$this->clean($model->telefone).'",
            "ST_EMAIL_PES": "'.$model->email.'",
            "ST_RG_PES": "'.$model->rg.'",
            "ST_ORGAO_PES": "'.$model->orgao.'",
            "ST_SEXO_PES": "'.($model->sexo == 'M'?1:2).'",
            "DT_NASCIMENTO_PES": "'.date("m/d/Y", strtotime($model->data_nascimento)).'",
            "ST_NACIONALIDADE_PES": "'.$model->nacionalidade.'",
            "ST_CEP_PES": "'.$this->clean($model->cep).'",
            "ST_ENDERECO_PES": "'.$model->endereco.'",
            "ST_NUMERO_PES": "'.$model->numero.'",
            "ST_COMPLEMENTO_PES": "'.$model->complemento.'",
            "ST_BAIRRO_PES":"'.$model->bairro.'",
            "ST_CIDADE_PES": "'.$model->cidade.'",
            "ST_ESTADO_PES": "'.$this->returnEstado($model->estado, 'sigla').'",
            "ST_OBSERVACAO_PES": "Cadastro pelo sistema em '.date().'"
        }');
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_decode($a_enviar));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "app_token: 86f34537-5693-3c40-a60d-754b3c5b9fa8",
            "access_token: d615ff2c-35bc-3855-8a44-c231c920fc4c"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $retorno = json_decode($response);

        // echo '<pre>';
        // print_r($a_enviar);
        // echo '<pre>';
        // echo '<hr>';
        // echo '<pre>';
        // print_r($retorno);
        // echo '<pre>';
        // echo '<hr>';
        // exit();
        
        // if ($retorno->data[0]->msg == 'Sucesso') {
        //     $retorna_id_proprietario_superlogica = $retorno->data[0]->data->id_pessoa_pes;
        //     $proprietario->superlogica = (int)$retorna_id_proprietario_superlogica;
        //     $proprietario->save();
        //     return $retorna_id_proprietario_superlogica;
        // }

        if ($retorno->data[0]->status == '200') {
            $retorna_id_proprietario_superlogica = $retorno->data[0]->data->id_pessoa_pes;
            $proprietario->superlogica = (int)$retorna_id_proprietario_superlogica;
            $proprietario->save();
            // return $retorna_id_proprietario_superlogica;
            return [
                'superlogica' => $retorna_id_proprietario_superlogica,
                'conteudo' => $retorno->data[0]->msg,
                'resultado' => 'sucesso'
            ];
        } else {
            // return $proprietario->superlogica;
            return [
                'superlogica' => $proposta->superlogica,
                'conteudo' => $retorno->data[0]->msg,
                'resultado' => 'erro'
            ];
        }

    }

    public function superlogicaimovel($proposta, $proprietario) {
        // está criando
        $jatem_superlogica = "";
        $proprietarios_beneficiados = '"PROPRIETARIOS_BENEFICIARIOS": [
            {
                "ID_PESSOA_PES": "'.$proprietario.'",
                "FL_PROPRIETARIO_PRB": "1",
                "NM_FRACAO_PRB": "100.00"
            }
        ],';
        $identificador_imovel = '"ST_IDENTIFICADOR_IMO": "'.$proposta->codigo_imovel.'",';
        // está editando
        if ($proposta->superlogica_imovel != "") {
            // echo '<br><hr>Edita<hr><br>';
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, "http://apps.superlogica.net/imobiliaria/api/imoveis");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            $jatem_superlogica = '"ID_IMOVEL_IMO": "'.$proposta->superlogica_imovel.'",';
            // $identificador_imovel = '';
            // $proprietarios_beneficiados = '';
        } 
        // está criando um novo
        else {
            // echo '<br><hr>Cria<hr><br>';
            $ch = curl_init("http://apps.superlogica.net/imobiliaria/api/imoveis/put");
    
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POST, true);
        }


        $tipo_imovel = 4;
        $model_infoimovel = json_decode($proposta->imovel_info,true);
        $complemento = 'Apartamento';

        $a_enviar = json_encode('{
            '.$jatem_superlogica.'
            "ST_TIPO_IMO": "'.$tipo_imovel.'",
            "ST_CEP_IMO": "'.$this->clean($model_infoimovel['cep']).'",
            "ST_ENDERECO_IMO": "'.$model_infoimovel['endereco'].'",
            "ST_NUMERO_IMO": "'.$model_infoimovel['numero'].'",
            "ST_COMPLEMENTO_IMO": "'.$complemento.'",
            "ST_BAIRRO_IMO":"'.$model_infoimovel['bairro'].'",
            "ST_CIDADE_IMO": "'.$model_infoimovel['cidade'].'",
            "ST_ESTADO_IMO": "'.$this->returnEstado($model_infoimovel['estado'], 'sigla').'",
            '.$proprietarios_beneficiados.'
            '.$identificador_imovel.'
            "VL_ALUGUEL_IMO": "'.$model_infoimovel['aluguel'].'",
            "VL_VENDA_IMO": "0",
            "TX_ADM_IMO": "0"
        }');
       
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_decode($a_enviar));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "app_token: 86f34537-5693-3c40-a60d-754b3c5b9fa8",
            "access_token: d615ff2c-35bc-3855-8a44-c231c920fc4c"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        $retorno = json_decode($response);

        // echo '<pre>';
        // print_r(json_decode($a_enviar));
        // echo '<pre>';
        // echo '<hr>';
        // echo '<pre>';
        // print_r($retorno);
        // echo '<pre>';
        // echo '<hr>';
       
        if ($retorno->data[0]->status == '200') {
            $retorna_id_imovel_superlogica = $retorno->data[0]->data->id_imovel_imo;
            $proposta->superlogica_imovel = (int)$retorna_id_imovel_superlogica;
            $proposta->save();
            // return $retorna_id_imovel_superlogica;
            return [
                'superlogica_imovel' => $retorna_id_imovel_superlogica,
                'conteudo' => $retorno->data[0]->msg,
                'resultado' => 'sucesso'
            ];
        } else {
            return [
                'superlogica_imovel' => $proposta->superlogica_imovel,
                'conteudo' => $retorno->data[0]->msg,
                'resultado' => 'erro'
            ];
        }
        
        
   }

    public function actionAddtosuperlogica ($id) {
        $proposta = $this->findModel($id);
        $proprietario = $this->superlogicaproprietario($proposta->codigo_imovel);
        $propostajet = $this->superlogicaimovel($proposta,  $proprietario['superlogica']);

        // Add Imóvel ao Propríetário no Superlógica
        // estamos aqui ó
        
        if ($propostajet["resultado"] == 'sucesso') {
            Yii::$app->session->setFlash('success', 'Proprietário e Imóvel cadastrado/atualizado com sucesso no Superlógica!');
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            Yii::$app->session->setFlash('warning', 'Algo deu errado, solicite o suporte e mostre isso: <hr>'.$propostajet["conteudo"].'<hr>'.$proprietario['conteudo'].'<hr>');
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionTrazprops () {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://apps.superlogica.net/imobiliaria/api/proprietarios");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        // curl_setopt($ch, CURLOPT_POSTFIELDS, '{
        //     "id": "219",
        //     "apenasColunasPrincipais": "1",
        //     "status": "0"
        // }');

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "app_token: 86f34537-5693-3c40-a60d-754b3c5b9fa8",
            "access_token: d615ff2c-35bc-3855-8a44-c231c920fc4c"
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        echo '<pre>';
        print_r(json_decode($response));
        echo '</pre>';

        
    }

    public function format_doc($doc,$tipo){
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

    // Pega dados do Jetimob
    public function get_content($url, $expire = 0) {
        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . sha1($url);
    
        if (file_exists($file) && (time() - $expire < filemtime($file))) {
            return file_get_contents($file);
        } else {
            $content = file_get_contents($url);
            file_put_contents($file, $content, LOCK_EX);
            return $content;
        }
    }
    // Retorna os Imóveis
    public function retorna_imoveis(){
        $json_imoveis = $this->get_content('https://api.jetimob.com/webservice/tZuuHuri8Q3ohAf7cvmMm8hTmWrXKJoEdes8ViSi/imoveis?v=v2',864000);
        
        $imoveis = json_decode($json_imoveis);
        $codigos = array();
        foreach ($imoveis as $e) {
            if ($e->contrato != 'Compra') {
                $codigos[$e->codigo] = 'PIN-'.$e->codigo;
            }
        }

        return $codigos;
    }
    // Pega Json do Imóvel e cadastra
    public function cadastraimovelupdate($id, $codigo) {
        // Pega os dados no Jetimob
        $json_imoveis = $this->get_content('https://api.jetimob.app/webservice/tZuuHuri8Q3ohAf7cvmMm8hTmWrXKJoEdes8ViSi/imoveis?v=v2',864000);
        // $json_imoveis = $this->get_content('http://www.jetimob.com/services/tZuuHuri8Q3ohAf7cvmMm8hTmWrXKJoEdes8ViSi/imoveis/',864000);
        $imoveis = json_decode($json_imoveis);
        $imovel = array();
        foreach ($imoveis as $e) {
            if ($e->codigo == $codigo && $e->contrato != 'Compra') {

                $imovel['subtipo'] = ($e->subtipo != ''?$e->subtipo:$e->tipo);
                $imovel['endereco'] = $e->endereco_logradouro;
                $imovel['complemento'] = $e->endereco_complemento;
                $imovel['numero'] = $e->endereco_numero;
                $imovel['bairro'] = $e->endereco_bairro;
                $imovel['cidade'] = $e->endereco_cidade;
                $imovel['estado'] = $e->endereco_estado;
                $imovel['cep'] = $e->endereco_cep;
                $imovel['dormitorios'] = $e->dormitorios;
                $imovel['aluguel'] = $e->valor_locacao;
                $imovel['iptu'] = $e->valor_iptu;
                $imovel['condominio'] = $e->valor_condominio;
                $imovel['codigo'] = $e->codigo;

                break;
            }
        }
        $dados_do_imovel = json_encode($imovel);
        // Atualiza no Banco de dados para
        $atualizar = SloProposta::findOne($id);
        $atualizar->imovel_info = $dados_do_imovel;
        $atualizar->save();

    }
    // Retorna o Imóvel
    public function actionRetornaimovel(){
        $codigo = filter_input(INPUT_POST, 'codigo', FILTER_SANITIZE_STRING);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
        
        // Atualiza a Model:
        $model = $this->findModel($id);
        $model->codigo_imovel = $codigo;
        $model->save();
        // --------------------------------------------------------------------------------

        $json_imoveis = $this->get_content('https://api.jetimob.app/webservice/tZuuHuri8Q3ohAf7cvmMm8hTmWrXKJoEdes8ViSi/imoveis?v=v2',864000);
        // $json_imoveis = $this->get_content('http://www.jetimob.com/services/tZuuHuri8Q3ohAf7cvmMm8hTmWrXKJoEdes8ViSi/imoveis/',864000);
        $imoveis = json_decode($json_imoveis);
        $imovel = array();
        foreach ($imoveis as $e) {
            if ($e->codigo == $codigo && $e->contrato != 'Compra') {

                $imovel['subtipo'] = ($e->subtipo != ''?$e->subtipo:$e->tipo);
                $imovel['endereco'] = $e->endereco_logradouro;
                $imovel['complemento'] = $e->endereco_complemento;
                $imovel['numero'] = $e->endereco_numero;
                $imovel['bairro'] = $e->endereco_bairro;
                $imovel['cidade'] = $e->endereco_cidade;
                $imovel['estado'] = $e->endereco_estado;
                $imovel['cep'] = $e->endereco_cep;
                $imovel['dormitorios'] = $e->dormitorios;
                $imovel['aluguel'] = $e->valor_locacao;
                $imovel['iptu'] = $e->valor_iptu;
                $imovel['condominio'] = $e->valor_condominio;
                $imovel['codigo'] = $e->codigo;

                break;
            }
        }
        return json_encode($imovel);
    }

    public function actionAtualizaremail ($id) {
        $model = $this->findModel($id);
        $complementando = '/'.$model->id.'X'.$model->codigo;
        $texto_status = 'Em análise';
        switch ($model->opcoes) {
            case '0': $texto_status = 'Não há pendências'; break;
            case '1': $texto_status = 'Precisa de fatura'; break;
            case '2': $texto_status = 'Precisa de Co-responsável'; break;
            case '3': $texto_status = 'Reprovado'; break;
        }
        $url = 'https://alugadigital.com.br/'.($model->tipo === 'Credpago' ? 'credpago' : 'seguro-fianca').$complementando;
        
        //Gera a URL encurtada!
        $bitly = new Bitly('o_21m850qm97', 'dc5e209e26b7595ba7e956d3e22e2ff50a516cf8');
        $bitly->shorten($url);
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
        $msg.= '<a style="cursor: pointer" href="'.$bitly->debug().'"><button style="cursor: pointer;background-color: white; color: black; font-weight: bolder; padding: 10px 20px; border: 5px solid black; border-radius: 0px;font-size: 20px">Acompanhe seu processo</button></a>';
        $msg.= '<br /><br />Ou acesse "<a href="'.$bitly->debug().'">'.$bitly->debug().'</a>"';
        $msg.= '</p>';
        $msg.= '<img src="https://alugadigital.com.br/img/logo_a_empresa.f21cb89d.png" width="100">';
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
            $disparo = new Historicodedisparos();
            $disparo->data = date('Y-m-d h:i:s');
            $disparo->proposta_id = $model->id;
            $disparo->mensagem = utf8_encode($msg.'<p>Mensagem enviada para '.$model->email.'</p>');
            $disparo->usuario_id = Yii::$app->user->identity->id;
            $disparo->etapa = $model->etapa_andamento;
            $disparo->modo = 'email';

            $disparo->save();

        } else {
            $alerta_enviado .= "Erro: Atualização não enviada para {$usuario->nome} - {$usuario->email} <br>";//'não enviou!';                            
            exit();
        }

        Yii::$app->session->setFlash('info', 'Email enviado para '.$model->email);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionAtualizarprop ($id) {
        // echo 'chegou '.$id;
        $etapa = $_REQUEST['etapa'];
        $resposta = $_REQUEST['resposta'];
        $model = $this->findModel($id);
        $model->etapa_andamento = $etapa;
        if ($etapa == 3) {
            $model->opcoes = $resposta;
        }
        if ($model->save()) {
            // Envia o email
            $complementando = '/'.$model->id.'X'.$model->codigo;
            // if ($model->etapa_andamento - 1 == 2) {
            //     $complementando .= '/3';
            // } else {
            //     if ($model->etapa_andamento - 1 == 1) {
            //         $complementando .= '/2';
            //     }
            // }
            // if ($model->etapa_andamento) {
            //     $nome = 'Nosso Cliente';
            //     $nome_gravado = explode(" ", $model->nome);
            //     $nome = $nome_gravado[0];
            //     $complementando .= '/'.$nome;
            // }
            // if ($model->etapa_andamento - 1 == 1) {
            //     $complementando .= '/'.$model->opcoes;
            // }
            // if ($model->etapa_andamento < 1) {
            //     $model->etapa_andamento = 1;
            // }
            $url = 'https://alugadigital.com.br/'.($model->tipo === 'Credpago' ? 'credpago' : 'seguro-fianca').'/'.$complementando;
            
            //Gera a URL encurtada!
            $bitly = new Bitly('o_21m850qm97', 'dc5e209e26b7595ba7e956d3e22e2ff50a516cf8');
            $bitly->shorten($url);
            
            // $assunto = 'Café Inteligência Imobiliária: Atualização '.date("d M/Y H:i:s");
            $assunto = 'Café Inteligência Imobiliária: Atualização '.date("d M/Y H:i:s");
            $msg = '<center>';
            $msg.= '<h3>Atualização da sua negociação de Locação do Imóvel PIN-'.$model->codigo_imovel.'</h3>';
            $msg.= '<p>';
            $msg.= 'A etapa de sua negociação foi modificada para "'.$etapa.'"';
            $msg.= '</p>';
            $msg.= '<p>';
            $msg.= '<a style="cursor: pointer" href="'.$bitly->debug().'"><button style="background-color: blue; color: white; font-weight: bolder;padding: 10px; border: 1px solid blue; border-radius: 5px; cursor: pointer">Clique aqui para acompanhar</button></a>';
            $msg.= '<br /><br />Ou acesse "<a href="'.$bitly->debug().'">'.$bitly->debug().'</a>"';
            $msg.= '</p>';
            $msg.= '<img src="https://alugadigital.com.br/img/logo_a_empresa.f21cb89d.png">';
            $msg.= '</center>';

            // echo $assunto;
            // echo '<br>';
            // echo $msg;
            // exit();
            // if(Mail::send($model->email, $assunto, $msg)){
            //     $alerta_enviado .= "Sucesso: Atualização enviada para {$usuario->nome} - {$usuario->email} <br>";//'enviou!';                            
            // } else {
            //     $alerta_enviado .= "Erro: Atualização não enviada para {$usuario->nome} - {$usuario->email} <br>";//'não enviou!';                            
            // }
            // Retorna
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            echo 'erro de registro, envie isso ao seu programador: <br>';
            echo '<pre>';
            print_r($model);
            echo '</pre>';
        }
    }

    public function actionGravahistorico() {
        $proposta_id = $_REQUEST['proposta_id'];
        $mensagem = $_REQUEST['mensagem'];
        $usuario_id = $_REQUEST['usuario_id'];
        $etapa = $_REQUEST['etapa'];
        $status = $_REQUEST['status'];

        $disparo = new Historicodedisparos();
        
        $disparo->data = date('Y-m-d h:i:s');
        $disparo->proposta_id = $proposta_id;
        $disparo->mensagem = utf8_encode($mensagem.'<p>Mensagem enviada para '.$disparo->proposta->telefone_celular.'</p>');
        $disparo->usuario_id = $usuario_id;
        $disparo->etapa = $etapa;
        $disparo->modo = 'whats';
        $disparo->status = $status;

        $disparo->save();
    }

    public function actionAtualizarprog ($id) {
        // echo 'chegou '.$id;
        $resposta = $_REQUEST['resposta'];
        $model = $this->findModel($id);
        $model->opcoes = $resposta;
        $model->save();
        
        // Envia o email
        $complementando = '/'.$model->id;
        // if ($model->etapa_andamento - 1 == 2) {
        //     $complementando .= '/3';
        // } else {
        //     if ($model->etapa_andamento - 1 == 1) {
        //         $complementando .= '/2';
        //     }
        // }
        // if ($model->etapa_andamento) {
        //     $nome = 'Nosso Cliente';
        //     $nome_gravado = explode(" ", $model->nome);
        //     $nome = $nome_gravado[0];
        //     $complementando .= '/'.$nome;
        // }
        // if ($model->etapa_andamento - 1 == 1) {
        //     $complementando .= '/'.$model->opcoes;
        // }
        $texto_status = 'Em análise';
        switch ($model->opcoes) {
            case '0': $texto_status = 'Não há pendências'; break;
            case '1': $texto_status = 'Precisa de fatura'; break;
            case '2': $texto_status = 'Precisa de Co-responsável'; break;
            case '3': $texto_status = 'Reprovado'; break;
        }
        $url = 'https://alugadigital.com.br/'.($model->tipo === 'Credpago' ? 'credpago' : 'seguro-fianca').$complementando;
        
        //Gera a URL encurtada!
        $bitly = new Bitly('o_21m850qm97', 'dc5e209e26b7595ba7e956d3e22e2ff50a516cf8');
        $bitly->shorten($url);

        $assunto = 'Café Inteligência Imobiliária: Atualização '.date("d M/Y H:i:s");
        $msg = '<h3>Atualização da sua negociação de Locação do Imóvel PIN-'.$model->codigo_imovel.'</h3>';
        $msg.= '<p>';
        $msg.= 'Status da negociação: "'.$texto_status.'"';
        $msg.= '</p>';
        $msg.= '<p>';
        $msg.= 'Acesse " <a href="'.$bitly->debug().'">'.$bitly->debug().'</a> " para acompanhar';
        $msg.= '</p>';

        // echo $assunto;
        // echo '<br>';
        // echo $msg;
        // exit();

        // if(Mail::send($model->email, $assunto, $msg)){
        //     $alerta_enviado .= "Sucesso: Atualização enviada para {$usuario->nome} - {$usuario->email} <br>";//'enviou!';                            
        // } else {
        //     $alerta_enviado .= "Erro: Atualização não enviada para {$usuario->nome} - {$usuario->email} <br>";//'não enviou!';                            
        // }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionTornaralerta($id) {
        // echo $id;
        $topico = Chtopico::findOne($id);
        if (!is_null($topico->alerta_id)) {
            $id_alerta = $topico->alerta_id;
            $topico->alerta_id = NULL;
            $topico->save();
            SaAlerta::findOne($id_alerta)->delete();
        } else {
            $alerta = new SaAlerta();
            $alerta->titulo = $topico->conteudo;
            $alerta->usuario_id = Yii::$app->user->identity->id;
            $alerta->data_inicio = date('yy-m-d h:i:s');
            $alerta->data_limite = date('yy-m-d h:i:s');
            $alerta->save();

            $topico->alerta_id = $alerta->id;
            $topico->save();
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
    
    public function actionNotifica(){
        // Yii::$app->homeUrl."alerta/sendwhats?msg=$mensagem&num=$fone"
        
    }
    public function actionFeed(){
        // Yii::$app->homeUrl."alerta/sendwhats?msg=$mensagem&num=$fone"
        $model = SloProposta::find()->All();
        $propostas = [];

        foreach ($model as $prop) {
            // echo $prop->id;
            $propostas[$prop->id] = [
                "id" => $prop->id,
                "nome" => $prop->nome,
                "etapa_andamento" => $prop->etapa_andamento - 1,
                "status" => $prop->opcoes,
                "pretendente_id" => $prop->proponente->id,
            ];
        }

        $data = Json::encode($propostas);

        $fp = fopen('../../cafe/propostas.json', 'w');
        fwrite($fp, $data);
        fclose($fp);

        // return $data;
    }

    public function formatar_data_pro_banco($data) {
        $arr = explode('/',$data);
        return $arr[2].'-'.$arr[1].'-'.$arr[0];
    }

    public function formatar_data_pra_tela($data) {
        $arr = explode('-',$data);
        return $arr[2].'/'.$arr[1].'/'.$arr[0];
    }

    public function actionEditcampo($id, $tabela, $campo){
        // Yii::$app->homeUrl."alerta/sendwhats?msg=$mensagem&num=$fone"
        // echo $tabela;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $valor = $_REQUEST[$campo];
        switch ($tabela) {
            case 'SloProposta':
                $model = SloProposta::findOne($id);
            break;
            case 'Proprietario':
                $model = Proprietario::findOne($id);
            break;
        }
        // $model = SloProposta::findOne($id);
        switch ($campo) {
            case 'data': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'data_nascimento': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'data_expedicao': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'documento_data_emissao': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'data_admissao': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'conj_data_nascimento': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'inicio_locacao': $model->$campo = $this->formatar_data_pro_banco($valor); break;
            case 'cpf': $model->$campo = $this->clean($valor); break;
            case 'conj_cpf': $model->$campo = $this->clean($valor); break;
            case 'cep': $model->$campo = $this->clean($valor); break;
            case 'end_cep': $model->$campo = $this->clean($valor); break;
            case 'celular': $model->$campo = $this->clean($valor); break;
            case 'telefone': $model->$campo = $this->clean($valor); break;
            case 'fone_celular': $model->$campo = $this->clean($valor); break;
            case 'celular': $model->$campo = $this->clean($valor); break;
            case 'fone_residencial': $model->$campo = $this->clean($valor); break;
            case 'cpf_cnpj': $model->$campo = $this->clean($valor); break;
            default: $model->$campo = $valor; break;
        }
        $model->save(); 
        // return 1;
        // return $this->redirect(Yii::$app->request->referrer);
        return ['output'=>$valor, 'message'=>''];
    }

    public function actionImovelinfo(){
        $id = $_REQUEST['id'];
        $campo = $_REQUEST['campo'];
        $model = SloProposta::findOne($id);
        $model->imovel_info = $campo;
        $model->save();
    }

    public function actionDefinedocs($id) {
        $model = $this->findModel($id);
        $vetores = $_REQUEST['motivo_locacao'];
        $motivo_locacao = '';
        $i = 1;
        foreach ($vetores as $v) {
            $motivo_locacao .= $v;
            $i++;
            if ($i <= count($vetores)) {
                $motivo_locacao .= ',';
            }
        }
        // echo '<br>quantos '.count($vetores);
        // echo '<br>indice '.$i;
        // echo '<br>vai pro banco '.$motivo_locacao;
        $model->motivo_locacao = $motivo_locacao;
        $model->save();
        return $this->redirect(Yii::$app->request->referrer);
    }

    private function campopdf($label, $valor) {
        return '<exp style="font-size: 10px; color: blue">'.$label.':</exp><br><strong>'.$valor.'</strong><br><br>';
    }

    public function actionReport($id) {
        // get your HTML raw content without any layouts or scripts
        $content = '<br>';

        $proposta = $this->findModel($id);

        $content .= '<div style="width: 100%">';
        $content .= '<div style="width: 48%; float: left; padding: 1%;">';
            $content .= $this->campopdf('Nome', $proposta->nome);
            $content .= $this->campopdf('Data de Nascimento', date('d/m/Y', strtotime($proposta->data_nascimento)));
            $content .= $this->campopdf('Celular (whats)', $this->format_telefone($proposta->telefone_celular));
            $content .= $this->campopdf('CPF', $this->format_doc($proposta->cpf,'cpf'));
            $content .= $this->campopdf('Email', $proposta->email);
        $content .= '</div>';
        $content .= '<div style="width: 48%; float: left; padding: 1%;">';
            $content .= $this->campopdf('Tipo de Documento', $proposta->documento_tipo);
            $content .= $this->campopdf('Nº do Documento', $proposta->documento_numero);
            $content .= $this->campopdf('Órgão Emissor', $proposta->documento_orgao_emissor);
            $content .= $this->campopdf('Data de Expedição', date('d/m/Y', strtotime($proposta->documento_data_emissao)));
            $content .= $this->campopdf('Telefone Residencial', $this->format_telefone($proposta->telefone_residencial));
        $content .= '</div>';
        $content .= '<div style="width: 48%; float: left; padding: 1%;">';
            $content .= $this->campopdf('Nacionalidade', $proposta->nacionalidade);
            $content .= $this->campopdf('Profissão', $proposta->profissao);
            $content .= $this->campopdf('Estado Civil', $proposta->estado_civil);
            $content .= $this->campopdf('Vínculo Empregatício', $proposta->vinculo_empregaticio);
        $content .= '</div>';
        $content .= '<div style="width: 48%; float: left; padding: 1%;">';
            $content .= $this->campopdf('Renda', 'R$ '.number_format($proposta->renda, 2, ',', '.'));
            $content .= $this->campopdf('Endereço', "{$proposta->endereco} - {$proposta->numero}, {$proposta->bairro}<br>{$proposta->cidade} - {$proposta->estado}");
            $content .= $this->campopdf('CEP', $proposta->cep);
        $content .= '</div>';
        if ($proposta->estado_civil == 'Casado') {
            $content .= '<hr>';
            $content .= '<h4>Cônjuge: '.$proposta->conj_nome.'</h4>';
            $content .= '<div style="width: 30%; float: left; padding: 1%;">';
            
            $i = 1;
                foreach ($proposta as $key => $value) {
                    if (!in_array($key,$this->arr_campos_retirados_docs_conj)):
                        switch ($key) {
                            case 'conj_cpf': $valor = $this->format_doc($value,'cpf'); break;
                            case 'celular': $valor = $this->format_telefone($value); break;
                            case 'fone_celular': $valor = $this->format_telefone($value); break;
                            case 'fone_residencial': $valor = $this->format_telefone($value); break;
                            case 'data_nascimento': $valor = date('d/m/Y',strtotime($value)); break;
                            case 'data_expedicao': $valor = date('d/m/Y',strtotime($value)); break;
                            case 'genero': $valor = $value=='M'?'Masculino':'Feminino'; break;
                            case 'renda': $valor = 'R$ '.number_format($value, 2, ',', '.'); break;
                            default: $valor = $value; break;
                        }
                        $content .= $this->campopdf($proposta->getAttributeLabel($key), $valor);
                        if ($i%5 == 0) {
                            $content .= '</div>';
                            $content .= '<div style="width: 30%; float: left; padding: 1%;">';
                        }
                        $i++;
                    endif;
                }
                // $content .= $this->campopdf('Nome', $proposta->conjuge->conj_nome);
                // $content .= $this->campopdf('Nome', $proposta->conjuge->numero_documento);
            $content .= '</div>';
        }
        $content .= '</div>';
        /*
        if ($proposta->codigo_imovel) :
            $content .= '<pagebreak />';
            $content .= '<br>';
            $content .= '<br>';
            $content .= '<div style="width: 100%">';
            $content .= '<h4><strong>Informações do Imóvel</strong></h4> <hr>';
            $content .= '<div style="width: 48%; float: left; padding: 1%;">';
                $content .= $this->campopdf('Imovel', $proposta->codigo_imovel);
                $content .= $this->campopdf('Tipo do Imovel', $proposta->tipo_imovel);
                $content .= $this->campopdf('Tipo de Proposta', $proposta->tipo);
                // $content .= $this->campopdf('Motivo de Locação', $proposta->motivo_locacao);
                $content .= $this->campopdf('Dormitórios', $proposta->dormitorios);
                $content .= $this->campopdf('Data de Contato', date('d/m/Y', strtotime($proposta->data_inicio)));
            $content .= '</div>';
            $content .= '<div style="width: 48%; float: left; padding: 1%;">';
                $content .= $this->campopdf('Endereço', $proposta->endereco.' - '.$proposta->numero.'<br>'.
                    $proposta->bairro.', '.$proposta->cidade.' - '.$proposta->estado
                );
                $content .= $this->campopdf('CEP', $this->format_doc($proposta->cep,'cep'));
                $content .= '<div style="width: 48%; float: left; padding: 1%;">';
                $content .= $this->campopdf('Aluguel', 'R$ '.number_format($proposta->aluguel, 2, ',', '.'));
                $content .= $this->campopdf('IPTU', 'R$ '.number_format($proposta->iptu, 2, ',', '.'));
                $content .= $this->campopdf('Condomínio', 'R$ '.number_format($proposta->condominio, 2, ',', '.'));
                $content .= '</div>';

                $content .= '<div style="width: 48%; float: left; padding: 1%;">';
                $content .= $this->campopdf('Água', 'R$ '.number_format($proposta->agua, 2, ',', '.'));
                $content .= $this->campopdf('Luz', 'R$ '.number_format($proposta->luz, 2, ',', '.'));
                $content .= $this->campopdf('Gás Encanado', 'R$ '.number_format($proposta->gas_encanado, 2, ',', '.'));
                $content .= '</div>';
                $content .= $this->campopdf('Total', 'R$ '.number_format($proposta->total, 2, ',', '.'));

            $content .= '</div>';
            $content .= '</div>';
        endif;
        */
        if ($proposta->frente) :
            
            $prefixo_nome_arquivo = $this->clean($proposta->cpf);
            $frente_doc = Yii::$app->homeUrl.'/uploads/_frente_'.$prefixo_nome_arquivo.'_'.$proposta->frente;
            $verso_doc = Yii::$app->homeUrl.'/uploads/_verso_'.$prefixo_nome_arquivo.'_'.$proposta->verso;
            $conj_frente_doc = Yii::$app->homeUrl.'/uploads/_conj_frente_'.$prefixo_nome_arquivo.'_'.$proposta->conj_frente;
            $conj_verso_doc = Yii::$app->homeUrl.'/uploads/_conj_verso_'.$prefixo_nome_arquivo.'_'.$proposta->conj_verso;

            $content .= '<pagebreak />';
            $localfolder = Yii::$app->homeUrl;
            $content .= '<br>';
            $content .= '<br>';
            $content .= '<div style="width: 100%; top:100px">';
            if (pathinfo($frente_doc, PATHINFO_EXTENSION) != 'pdf') {
                $content .= '<div style="width: 47%; float: left; padding: 1%;">';
                // $content .= '<hr>';
                $content .= '<strong>Frente do Documento</strong>';
                $content .= "<img src='".$frente_doc."'/>";
                $content .= '<br>';
                $content .= '</div>';
            }
            if (pathinfo($verso_doc, PATHINFO_EXTENSION) != 'pdf') {
                $content .= '<div style="width: 47%; float: left; padding: 1%;">';
                // $content .= '<hr>';
                $content .= '<strong>Verso do Documento</strong>';
                $content .= "<img src='".$verso_doc."'/>";
                $content .= '<br>';
                $content .= '</div>';
            }
            if ($proposta->estado_civil == 'Casado') {
                $content .= '<hr>';
                if (pathinfo($conj_frente_doc, PATHINFO_EXTENSION) != 'pdf') {
                    $content .= '<div style="width: 47%; float: left; padding: 1%;">';
                    // $content .= '<hr>';
                    $content .= '<strong>Cônjuge: Frente do Documento</strong>';
                    $content .= "<img src='".$conj_frente_doc."'/>";
                    $content .= '<br>';
                    $content .= '</div>';
                }
                if (pathinfo($conj_verso_doc, PATHINFO_EXTENSION) != 'pdf') {
                    $content .= '<div style="width: 47%; float: left; padding: 1%;">';
                    // $content .= '<hr>';
                    $content .= '<strong>Cônjuge: Verso do Documento</strong>';
                    $content .= "<img src='".$conj_verso_doc."'/>";
                    $content .= '<br>';
                    $content .= '</div>';
                }
            
            }
        endif;
        $content .= '</div>';
        
        $arques = $proposta->maisarquivos;
        if (count($arques) > 0){
            $content .= '<pagebreak />';
            $content .= '<br>';
            $content .= '<br>';
            $content .= '<div style="width: 100%; top:100px;">';
            $content .= '<h4><strong>Mais Documentos</strong></h4> <hr>';
            
            foreach ($arques as $key => $value) {
                if (!in_array($key,['id','proposta_id']) and $value != null) {
                    $nome_arq = "_file_{$key}_{$proposta->id}_";
                    $content .=  '<div style="width: 47%; float: left; padding: 1%;border:1px solid">';
                    $content .= '<h4>'.$arques->getAttributeLabel($key).'</h4>';
                    if (pathinfo($value, PATHINFO_EXTENSION) == 'pdf' or pathinfo($value, PATHINFO_EXTENSION) == 'docx'){
                        $content .=  '<hr></br>Conferir no Sistema - Arquivo em PDF ou DOC';
                    } else {
                        $content .=  '<img src="'.Yii::$app->homeUrl.'uploads/'.$nome_arq.$value.'" style="width: 70%">';
                    }

                    $content .=  '</div>';
                }
            }
        }
        $content .= '</div>';
        
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}', 
             // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>['<img src="'.Yii::$app->homeUrl.'icones/logo-alugadigital.png" width="70" />'], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        
        // return the pdf output as per the destination setting
        return $pdf->render(); 
    }
    /**
     * Campo Editável
     */
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

        if (in_array($campo,['data', 'data_nascimento', 'data_expedicao', 'documento_data_emissao', 'data_admissao', 'inicio_locacao'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '99/99/9999'
            ];
            $widgetClass = MaskedInput::className();
            // $valore = date('d/m/Y', strtotime($valor));
        }
        if (in_array($campo,['cpf', 'conj_cpf'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '999.999.999-99',
                'value' => $valor
            ];
            $widgetClass = MaskedInput::className();
            $valore = $this->format_doc($valor, 'cpf');
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
        if (in_array($campo,['mais_informacoes'])) {
            $input = Editable::INPUT_TEXTAREA;
            $submitOnEnter = false;
        }
        if (in_array($campo,['cpf_cnpj', 'cnpj'])) {
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
            $valore = $this->format_telefone($valor);
        }

        $retorno = '<label>'.$title.'</label><br />';
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
            'data' => $data,
            'displayValueConfig'=> $displayValueConfig,
            'submitOnEnter' => $submitOnEnter,
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
        return '<div class="col-md-'.$col_md.'">'.$retorno.'</div>';
    }
    
    public function imprime_campo($col_md, $tabela, $campo, $title, $valor, $id, $conj = null) {
        $retorno .= "<label><strong>$title: </strong><br><span>$valor</span></label>";
        // $retorno .= "<br>";
        // $retorno .= "<br>";
        // $retorno .= "<br>";
        return '<div class="col-md-'.$col_md.'">'.$retorno.'<hr></div>';
    }

    public function telefone_api($telefone) {
        $telefone_clean = $this->clean($telefone);
        $fone_arr = str_split($telefone_clean);

        $telefone_para_api = '+55'.$fone_arr[0].$fone_arr[1]
        .$fone_arr[3].$fone_arr[4].$fone_arr[5].$fone_arr[6]    //retiramos o arr[2] ou terceiro número, que é o nono dígito
        .$fone_arr[7].$fone_arr[8].$fone_arr[9].$fone_arr[10];
        return $telefone_para_api;
    }

    public function actionRobo1() {

        $url = 'https://backend.botconversa.com.br/api/v1/webhook/subscriber/';
        $key = '2575d5e8-9f95-4338-9cb0-cf8f2b23ab44';

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_URL, $url);



        // curl_setopt_array($curl, [
        //     CURLOPT_URL => $url,
        //     CURLOPT_HEADER => false,
        //     CURLOPT_RETURNTRANSFER => true,
        //     // CURLOPT_POST => [
        //     //     "phone" => "+559991642468",
        //     //     "first_name" => "Núrya",
        //     //     "last_name" => "Ramos",
        //     // ],
        //     CURLOPT_POST => json_encode('{
        //         "phone": "+559991642468,
        //         "first_name": "Núrya",
        //         "last_name": "Ramos",
        //     }'),
        // ]);
        $a_enviar = json_encode('{
            "phone": "+559991642468",
            "first_name": "Núrya",
            "last_name": "Ramos",
        }');

        //Como array
        $arr_enviar = [
            "phone" => "+559991642468",
            "first_name" => "Núrya",
            "last_name" => "Ramos",
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

        var_dump('Response:', $response);
        echo '<pre>';
        print_r($response);
        echo '</pre>';

        /**
         * para o envio de mensagem, parâmetros:
         * 
        {
            "type": "text",
            "value": "teste teste"
        }
        * meu ID
        15437309
        * Url
        /subscriber/{subscriber_id}/send_message/
        */
    }
                    //    apibotsubscriber
    public function actionApibotsubscriber() {
        // MySql
        // alter table slo_proposta add apibotsubs int after id;
        $url = 'https://backend.botconversa.com.br/api/v1/webhook/subscriber/';
        $key = '2575d5e8-9f95-4338-9cb0-cf8f2b23ab44';
        
        $nome = $_REQUEST['nome'];
        $proposta_id = $_REQUEST['proposta_id'];
        $nome_arr = explode(' ', $nome);
        $primeiro_nome = $nome_arr[0];
        $segundo_nome = $nome_arr[1];

        $telefonexx = $_REQUEST['telefone'];
        $telefone_para_api = $this->telefone_api($telefonexx);
        

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

        // var_dump('Response:', $response);
        // echo '<pre>';
        // print_r($response);
        // echo '</pre>';
        // echo '<pre>';
        // print_r($arr_enviar);
        // echo '</pre>';

        // $this->apibotget($telefone_para_api, $proposta_id);
        if ($response['error_message']) {
            return 0;
        } else {
            return 1;
        }

    }

    public function actionApibotget() {
        
        $proposta = $_REQUEST['proposta'];
        $telefone = $_REQUEST['telefone'];
        $telefone_pra_api = $this->telefone_api($telefone);
        
        // A barra '/' no final é indispensável pra essa URL funcionar... IMPORTANTE
        $url = 'https://backend.botconversa.com.br/api/v1/webhook/subscriber/'.$telefone_pra_api.'/';
        $key = '2575d5e8-9f95-4338-9cb0-cf8f2b23ab44';
        
        $curl = curl_init();

        // set url
        curl_setopt($curl, CURLOPT_URL, $url);

        //return the transfer as a string
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curl, CURLOPT_HEADER, 0);

        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
       
        // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($arr_enviar));

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

        // TESTES ======================================================================================
        // echo '<hr>'.$url;
        // echo '<hr>';
        // echo '<pre>';
        // print_r($output);
        // echo '</pre>';
        // TESTES ======================================================================================
        
        // Salva no Banco de dados
        $proposta = $this->findModel($proposta);
        $proposta->apibotsubs = $output->id;
        $proposta->save();

    }

    public function actionApibotmensagem() {

        $subscriberid = $_REQUEST['subscriberid'];
        $mensagem = $_REQUEST['mensagem'];

        $url = "https://backend.botconversa.com.br/api/v1/webhook/subscriber/$subscriberid/send_message/";
        $key = '2575d5e8-9f95-4338-9cb0-cf8f2b23ab44';

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_URL, $url);

        $a_enviar = json_encode('{
            "type": "text",
            "value": '.$mensagem.'
        }');

        //Como array
        $arr_enviar = [
            "type" => "text",
            "value" => $mensagem,
        ];
       
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($arr_enviar));

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "API-KEY: $key",
        ));

        $response = curl_exec($curl);

        if ($error = curl_error($curl)) {
            throw new \Exception($error);
            $retorno = 0;
        } else {
            $retorno = 1;
        }

        curl_close($curl);
        $response = json_decode($response, true);

        if ($response['error_message']) {
            return 0;
        } else {
            return 1;
        }

    }

    // Traz as informações dos proprietários
    public function actionRetornaproprietario () {
        $id = $_REQUEST['id'];
        $P = Proprietario::find()->where([
            'id' => $id
        ])->one();
        $arrP = [];
        $arrP['nome'] = $P->nome;
        $arrP['proprietario_nomefantasia'] = $P->nome_fantasia;
        $arrP['proprietario_cnpj'] = $P->cpf_cnpj;
        $arrP['proprietario_celular'] = $P->celular;
        $arrP['proprietario_telefone'] = $P->telefone;
        $arrP['proprietario_email'] = $P->email;
        $arrP['proprietario_rg'] = $P->rg;
        $arrP['proprietario_orgao'] = $P->orgao;
        $arrP['proprietario_sexo'] = $P->sexo;
        $arrP['proprietario_datanascimento'] = $this->formatar_data_pra_tela($P->data_nascimento);
        $arrP['proprietario_nacionalidade'] = $P->nacionalidade;
        $arrP['proprietario_cep'] = $P->cep;
        $arrP['proprietario_endereco'] = $P->endereco;
        $arrP['proprietario_numero'] = $P->numero;
        $arrP['proprietario_complemento'] = $P->complemento;
        $arrP['proprietario_bairro'] = $P->bairro;
        $arrP['proprietario_cidade'] = $P->cidade;
        $arrP['proprietario_estado'] = $P->estado;
        return json_encode($arrP);
    }

    // INPUTS mais simples para o Disparo ao Superlógica
    public function linhatabela($campo, $id_campo, $formulario, $valor = null, $opcoes = null) {
        if ($id_campo == 'proprietario_datanascimento') {
            $valor = $this->formatar_data_pra_tela($valor);
        }
        if ($opcoes) {
            // switch ($valor) {
            //     case 'M': $sexoM = 'selected'; $sexoF = ''; break;
            //     case 'F': $sexoM = ''; $sexoF = 'selected'; break;
            //     default: $sexoM = 'selected'; $sexoF = ''; break;
            // }
            $select_content = '';
            foreach ($opcoes as $key => $value) {
                $selected = '';
                if ($key == $valor) {
                    $selected = 'selected';
                }
                $select_content .= "<option value='$key' $selected >$value</option>\n";
            }
            $input = '<select style="width: 100%;border: 1px solid lightgray;padding:4px;background-color:transparent" id="'.$id_campo.'" name="'.$formulario.'['.$id_campo.']" required>
                '.$select_content.'
            </select>';
        } else {
            $input = '<input style="width: 100%;border: 1px solid lightgray;padding:4px;" type="text" id="'.$id_campo.'" name="'.$formulario.'['.$id_campo.']" value="'.$valor.'" required>';
        }
        return '<tr style="">
         <td style="font-size: 15px !important;text-align:left;">
            <exp style="color:#AAAAAA;font-weight:bold;">'.$campo.':</exp>'.$input.
        '</td></tr>';
    }
}
