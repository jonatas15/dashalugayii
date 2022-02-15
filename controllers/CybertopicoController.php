<?php

namespace app\controllers;

use Yii;
use app\models\CyberTopico;
use app\models\CybertopicoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\UploadForm;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use app\models\TopicoMembros;
use app\models\Topicoupdates;
use app\models\Topicovisitas;
/**
 * CybertopicoController implements the CRUD actions for CyberTopico model.
 */
class CybertopicoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access'=> [
                'class' => AccessControl::className(),
                //'only' => ['create','delete','update'],
                'rules' => [
                    ['actions' => ['update'],           'allow' => true,   'roles' => ['faturas-update']],
                    ['actions' => ['editregistro'],     'allow' => true,   'roles' => ['faturas-update']],
                    ['actions' => ['favoritopico'],     'allow' => true,   'roles' => ['faturas-update']],
                    ['actions' => ['registravisita'],   'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['create'],           'allow' => true,   'roles' => ['faturas-create']],
                    ['actions' => ['index'],            'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['view'],             'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['delete'],           'allow' => true,   'roles' => ['faturas-delete']],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CyberTopico models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CybertopicoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CyberTopico model.
     * @param integer $idtopico
     * @param integer $cyber_idcyber
     * @return mixed
     */
    public function actionView($idtopico, $cyber_idcyber)
    {
        return $this->render('view', [
            'model' => $this->findModel($idtopico, $cyber_idcyber),
        ]);
    }

    /**
     * Creates a new CyberTopico model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CyberTopico();

        if ($model->load(Yii::$app->request->post())) {
            
            if(UploadedFile::getInstance($model, 'imageFile')){
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                $model->imagem = $model->imageFile->baseName.'.'.$model->imageFile->extension;
            }
            
            $post_tags = $_POST['CyberTopico']['palavraschaves'];
            if($post_tags != ''){
                $palavraschaves = '';
                $i = 0;
                foreach ($post_tags as $key => $value) {
                    $palavraschaves .= $value;
                    $i++;
                    if($i < count($post_tags)){
                      $palavraschaves .= ';';
                    }
                }
                $model->palavraschaves = $palavraschaves;
            }elseif ($_POST["{$model->topico_pai}-ramo-palavraschaves"]) {

                $palavraschaves = '';
                $i = 0;
                $post_tags = $_POST["{$model->topico_pai}-ramo-palavraschaves"];
                foreach ($post_tags as $key => $value) {
                  $palavraschaves .= $value;
                  $i++;
                  if($i < count($post_tags)){
                    $palavraschaves .= ';';
                  }
                }
                $model->palavraschaves = $palavraschaves;
            }

            $model->datetime = date('Y-m-d H:i:s');
            
            if ($model->save()){
                if ($model->imageFile) $model->upload();
                return $this->redirect(['index?cyber_idcyber='.$model->cyber_idcyber]);
            }else{
                echo 'deu erro, tente novamente mais tarde';
            }
            // return $this->redirect(['view', 'idtopico' => $model->idtopico, 'cyber_idcyber' => $model->cyber_idcyber]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CyberTopico model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $idtopico
     * @param integer $cyber_idcyber
     * @return mixed
     */
    public function actionUpdate($idtopico, $cyber_idcyber)
    {
        $model = $this->findModel($idtopico, $cyber_idcyber);

        if ($model->load(Yii::$app->request->post())) {
            
            if(UploadedFile::getInstance($model, 'imageFile')){
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                $model->imagem = $model->imageFile->baseName.'.'.$model->imageFile->extension;
            }
            if($_POST['CyberTopico']['palavraschaves'] != ''){
                $palavraschaves = '';
                $i = 0;
                $post_tags = $_POST['CyberTopico']['palavraschaves'];
                foreach ($post_tags as $key => $value) {
                  $palavraschaves .= $value;
                  $i++;
                  if($i < count($post_tags)){
                    $palavraschaves .= ';';
                  }
                }
                $model->palavraschaves = $palavraschaves;

            }elseif ($_POST["$idtopico-palavraschaves"]) {

                $palavraschaves = '';
                $i = 0;
                $post_tags = $_POST["$idtopico-palavraschaves"];
                foreach ($post_tags as $key => $value) {
                  $palavraschaves .= $value;
                  $i++;
                  if($i < count($post_tags)){
                    $palavraschaves .= ';';
                  }
                }
                $model->palavraschaves = $palavraschaves;
            }
            if ($model->save()) {
                if ($model->imageFile) $model->upload();
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CyberTopico model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $idtopico
     * @param integer $cyber_idcyber
     * @return mixed
     */
    public function actionDelete($idtopico, $cyber_idcyber)
    {
        $this->findModel($idtopico, $cyber_idcyber)->delete();

        return $this->redirect(['index?cyber_idcyber='.$cyber_idcyber]);
    }

    /**
     * Finds the CyberTopico model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $idtopico
     * @param integer $cyber_idcyber
     * @return CyberTopico the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($idtopico, $cyber_idcyber)
    {
        if (($model = CyberTopico::findOne(['idtopico' => $idtopico, 'cyber_idcyber' => $cyber_idcyber])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionEditregistro($idtopico, $cyber_idcyber){

      $model = $this->findModel($idtopico, $cyber_idcyber);
      $antigo = new Topicoupdates;
      $antigo->topico_id = $idtopico;
      $antigo->usuario_id = Yii::$app->user->identity->id;
      $antigo->datetime = date('Y-m-d H:i:s');
      
      if(!empty($_REQUEST['CyberTopico']['titulo'])){
        $antigo->antigo_campo = 'titulo';
        $antigo->antigo = $model->titulo;
        $model->titulo = $_REQUEST['CyberTopico']['titulo'];
      }
      if(!empty($_REQUEST['CyberTopico']['tipo'])){
        $antigo->antigo_campo = 'tipo';
        $antigo->antigo = $model->tipo;
        $model->tipo = $_REQUEST['CyberTopico']['tipo'];
      }
      if(!empty($_REQUEST['CyberTopico']['descricao'])){
        $antigo->antigo_campo = 'descricao';
        $antigo->antigo = $model->descricao;
        $model->descricao = $_REQUEST['CyberTopico']['descricao'];
      }
      if(!empty($_REQUEST['CyberTopico']['topico_pai'])){
        $antigo->antigo_campo = 'topico_pai';
        $antigo->antigo = $model->topico_pai;
        $model->topico_pai = $_REQUEST['CyberTopico']['topico_pai'];
      }

      if(!empty($_REQUEST['palavraschaves'])){
        $antigo->antigo_campo = 'keywords';
        $antigo->antigo = $model->palavraschaves;
        $palavraschaves = '';
        $i = 0;
        $post_tags = $_REQUEST['palavraschaves'];
        foreach ($post_tags as $key => $value) {
          $palavraschaves .= $value;
          $i++;
          if($i < count($post_tags)){
            $palavraschaves .= ';';
          }
        }
        $model->palavraschaves = $palavraschaves;
        $antigo->antigo_campo = 'keywords';
      }

      if(UploadedFile::getInstance($model, 'imageFile')){
          $antigo->antigo_campo = 'imagem';
          $antigo->antigo = $model->imagem;
          $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
          $model->imagem = $model->imageFile->baseName.'.'.$model->imageFile->extension;
      }

      if($model->save()){
        //echo 1;
        $antigo->save();
        if ($model->imageFile) $model->upload();
         return $this->redirect(Yii::$app->request->referrer);
      }

    }
    public function actionFavoritopico($idtopico,$favoritar,$tipo){
        $model = TopicoMembros::find()->where([
            'topico_idtopico'=>$idtopico,
            'usuario_id'=>Yii::$app->user->identity->id
        ])->all();
        if(count($model) > 0){
            Yii::$app->db->createCommand()->update('topico_membros', [$tipo => $favoritar], 'topico_idtopico = '.$idtopico.' and usuario_id = '.Yii::$app->user->identity->id)->execute();
        }else{
            $model = new TopicoMembros();
            $model->topico_idtopico = $idtopico;
            $model->usuario_id = Yii::$app->user->identity->id;
            
            switch ($tipo){
                case 'favorito': $model->favorito = $favoritar; break;
                case 'ajudou': $model->ajudou = $favoritar; break;
                case 'nao_ajudou': $model->nao_ajudou = $favoritar; break;
                default: $model->favorito = $favoritar; break;
            }
            
            
            $model->save();
        }
    }
    private function converter($tempo)
    {
        $hora = 0;
        $tempo = $tempo / 1000;
        $ms = str_replace('0.', '', $tempo - floor($tempo));
        if($tempo > 3600)
        {
            $hora = floor($tempo / 3600);
        }
        $tempo = $tempo % 3600;
        $out = str_pad($hora, 2, '0', STR_PAD_LEFT) . gmdate(':i:s', $tempo) . ($ms ? ".$ms" : '');
        return $out;
    }
    private function tirarAcentos($string) {
        $stringa = str_replace(', ', ',', $string);
        $stringb = str_replace(' ,', ',', $stringa);
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç)/", "/(Ç)/"), explode(" ", "a A e E i I o O u U n N c C"), $stringb);
    }
    public function urlAmigavel($nom_tag, $slug = "-") {
        $nom_tag2 = $this->tirarAcentos($nom_tag);
        $string = strtolower($nom_tag2);
        
        // Código ASCII das vogais
        $ascii['a'] = range(224, 230);
        $ascii['e'] = range(232, 235);
        $ascii['i'] = range(236, 239);
        $ascii['o'] = array_merge(range(242, 246), array(240, 248));
        $ascii['u'] = range(249, 252);
        
        // Código ASCII dos outros caracteres
        $ascii['b'] = array(223);
        $ascii['c'] = array(231);
        $ascii['d'] = array(208);
        $ascii['n'] = array(241);
        $ascii['y'] = array(253, 255);
        
        foreach ($ascii as $key => $item) {
            $acentos = '';
            foreach ($item AS $codigo)
                $acentos .= chr($codigo);
                $troca[$key] = '/[' . $acentos . ']/i';
        }
        
        $string = preg_replace(array_values($troca), array_keys($troca), $string);
        
        if ($slug) {
            $string = preg_replace('/[^a-z0-9\']/i', $slug, $string);
            $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
            $string = trim($string, $slug);
        }
        return $string;
    }
    public function actionRegistravisita() {
        //Cadastra visitas
		$model = new Topicovisitas;
		$model->topico_id = $_REQUEST['topico_id'];
		$model->usuario_id = Yii::$app->user->identity->id;
		$model->datetime = date('Y-m-d H:i:s');
		$model->tempo = $this->converter($_REQUEST['time']);
		$model->save();
	}
}
