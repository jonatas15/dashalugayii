<?php
namespace app\controllers;

use Yii;

use app\models\ImovelPermuta;
use app\models\ImovelpermutaSearch;
use app\models\Controle;
use app\models\Usuariopermutas;
use app\models\Usuario;
use app\models\Mail;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ImovelpermutaController implements the CRUD actions for ImovelPermuta model.
 */
class ImovelpermutaController extends Controller
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
                    ['actions' => ['update'],       'allow' => true,   'roles' => ['faturas-update']],
                    ['actions' => ['create'],       'allow' => true,   'roles' => ['faturas-create']],
                    ['actions' => ['index'],        'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['view'],         'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['cruzamento'],   'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['delete'],       'allow' => true,   'roles' => ['faturas-delete']],
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
     * Lists all ImovelPermuta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImovelpermutaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ImovelPermuta model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Detalhes do cruzamento entre permutas
     * @param integer $id
     * @return mixed
     */
    public function actionCruzamento($id)
    {
        return $this->render('cruzamento', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ImovelPermuta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ImovelPermuta();

        if ($model->load(Yii::$app->request->post())) {
            if(!empty($_REQUEST['ImovelPermuta']['tipo']))
                $model->tipo = implode(';',$_REQUEST['ImovelPermuta']['tipo']);
            if(!empty($_REQUEST['ImovelPermuta']['bairros']))
                $model->bairros = implode(';',$_REQUEST['ImovelPermuta']['bairros']);
            if($model->save()) {
                //Adiciona o registro de Log para controle no sistema:
                $controle = new Controle;
                $controle->acao_feita = 'Cadastro';
                $controle->detalhes_acao = implode(",", $model->attributes);
                $controle->permuta_id = $model->idimovel_permuta;
                $controle->cadastrador = Yii::$app->user->identity->id;
                $controle->data_cadastro = date('Y-m-d H:i:s');
                $controle->save();
                //Adiciona a relação usuário e permuta no sistema:
                $up = new UsuarioPermutas;
                $up->permuta = $model->idimovel_permuta;
                $up->usuario = Yii::$app->user->identity->id;
                $up->save();
                //pesquisa permutas compatíveis e envia email sobre essa nova permuta compatível:
                // Para os bairros
                $query = ImovelPermuta::find();
                $ors = [
                    'or',
                    ['like', 'bairros', $model->bairros],
                ];
                if(!empty($model->bairros)):
                    $bairros_registro = $model->bairros;
                    $bairros = explode(';',$bairros_registro);
                    $ors = [
                        'or',
                        ['like', 'bairros', $bairros],
                    ];
                    if(!empty($bairros)):
                        foreach ($bairros as $b):
                            array_push($ors,['like', 'bairros', $b]);
                        endforeach;
                        // $ors = array_unique($ors);
                        // echo count($ors);
                        // echo '<pre>';
                        // print_r($ors);
                        // echo '</pre>';
                        // exit();
                        $query->andFilterWhere($ors)->orWhere(['bairros' => '']);
                    else:
                        $query->andFilterWhere($ors);
                    endif;
                endif;
                // Para os tipos de imóveis
                $tipo_registro = $model->tipo;
                $tipos = explode(';',$tipo_registro);
                $ors2 = [
                    'or',
                    ['like', 'tipo', $model->tipo],
                ];
                if(!empty($tipo_registro))
                foreach ($tipos as $t):
                    array_push($ors2,['like', 'tipo', $t]);
                endforeach;
                //pesquisa
                $permutas = ImovelPermuta::find()->where([
                    'elevador' => $model->elevador,
                    'sacada' => $model->sacada,
                ])->andFilterWhere($ors)->andFilterWhere($ors2)
                ->andFilterWhere(['<>', 'codigo',  $model->codigo])
                ->andFilterWhere(['<=', 'valor_minimo',  $model->valor_minimo])
                ->andFilterWhere(['>=', 'valor_maximo',  $model->valor_maximo])
                ->andFilterWhere(['<=', 'area_total',    $model->area_total])
                ->andFilterWhere(['<=', 'area_privativa',$model->area_privativa])
                ->andFilterWhere(['<=', 'garagens',      $model->garagens])
                ->andFilterWhere(['<=', 'dormitorios',   $model->dormitorios])->all();

                foreach ($permutas as $row) {
                    $msg = '';
                    $up = Usuariopermutas::find()->where(['permuta'=>$row->idimovel_permuta])->one();
                    $user_recebe_email = Usuario::find()->where(['id'=>$up->usuario])->one();
                    $msg .= '<a href="https://www.cafeinteligencia.com.br/'.Yii::$app->homeUrl.'imovelpermuta/view?id='.$model->idimovel_permuta.'">Permuta código PIN-'.$model->codigo.'</a><br>';
                    $msg .= '<div><br><hr>';
                    $msg .= '<ul>';
                    $msg .= '<li><strong>Código: </strong>PIN-'.$model->codigo."<br>".
                            '</li>'.
                            '<li><strong>Tipo: </strong>'.$model->tipo."<br>".
                            '</li>'.
                            '<li><strong>Dormitórios: </strong>'.$model->dormitorios."<br>".
                            '</li>'.
                            '<li><strong>Garagens: </strong>'.$model->garagens."<br>".
                            '</li>'.
                            '<li><strong>Área Privativa: </strong>'.number_format($model->area_privativa.'.00', 2, ',', '.').' m²'."<br>".
                            '</li>'.
                            '<li><strong>Área Total: </strong>'.number_format($model->area_total.'.00', 2, ',', '.').' m²'."<br>".
                            '</li>'.
                            '<li><strong>Bairros: </strong>'.$model->bairros."<br>".
                            '</li>'.
                            '<li><strong>Elevador: </strong>'.$model->elevador."<br>".
                            '</li>'.
                            '<li><strong>Sacada: </strong>'.$model->sacada."<br>".
                            '</li>'.
                            '<li><strong>Valor Máximo: </strong>'.'R$ '.number_format($model->valor_maximo.'.00', 2, ',', '.')."<br>".
                            '</li>'.
                            '<li><strong>Valor Mínimo: </strong>'.'R$ '.number_format($model->valor_minimo.'.00', 2, ',', '.')."<br>".
                            '</li>';
                    $msg .= '</ul>';
                    $msg .= '</div>';
                    $msg .= '<br>';
                    $msg .= '<hr>';
                    $msg .= '<p>'.$model->observacoes.'</p>';
                    $msg .= '<hr>';
                    $msg .= '<strong>Café Inteligência Imobiliária</strong>';
                    $assunto = 'Nova Permuta Compatível com o seu registro PIN-'.$row->codigo.' cadastrada no Sistema';
                    // Yii::$app->mailer->compose("@app/mail/layouts/html",['content'=>$msg])
                    //         ->setTo($user_recebe_email->email)
                    //         ->setFrom(['cafeinteligencia@gmail.com' => 'Café Inteligência Imobiliária'])
                    //         ->setSubject('Nova Permuta Compatível com o seu registro PIN-'.$row->codigo.', cadastrada no Sistema')
                    //         ->setTextBody('corpo da mensagem')
                    //         ->send();
                    
                    if (Mail::send($user_recebe_email->email, $assunto, $msg))
                        echo "sucesso no envio";
                }
                // exit();
                
                //========================================================================

                return $this->redirect(['view', 'id' => $model->idimovel_permuta]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ImovelPermuta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            
            if(!empty($_REQUEST['ImovelPermuta']['tipo']))
                $model->tipo = implode(';',$_REQUEST['ImovelPermuta']['tipo']);

            if(!empty($_REQUEST['ImovelPermuta']['bairros']))
                $model->bairros = implode(';',$_REQUEST['ImovelPermuta']['bairros']);
            else
                $model->bairros = '';

            if($model->save()) {
                $controle = new Controle;
                $controle->acao_feita = 'Alteração';
                $controle->detalhes_acao = implode(",", $model->attributes);
                $controle->permuta_id = $model->idimovel_permuta;
                $controle->atualizador = Yii::$app->user->identity->id;
                $controle->data_alteracao = date('Y-m-d H:i:s');
                $controle->save();

                $msg = 'registro alterado';

                // Yii::$app->mailer->compose("@app/mail/layouts/html",['content'=>$msg])
                // ->setTo('jonatas.a.s.2012@hotmail.com')
                // ->setFrom(['cafeinteligencia@gmail.com' => 'Café Intelecto'])
                // ->setSubject('teste em update')
                // ->setTextBody('corpo da mensagem')
                // ->send();

                //pesquisa permutas compatíveis e envia email sobre essa nova permuta compatível:
                // Para os bairros
                $query = ImovelPermuta::find();
                $ors = [
                    'or',
                    ['like', 'bairros', $model->bairros],
                ];
                if(!empty($model->bairros)):
                    $bairros_registro = $model->bairros;
                    $bairros = explode(';',$bairros_registro);
                    $ors = [
                        'or',
                        ['like', 'bairros', $bairros],
                    ];
                    if(!empty($bairros)):
                        foreach ($bairros as $b):
                            array_push($ors,['like', 'bairros', $b]);
                        endforeach;
                        // $ors = array_unique($ors);
                        // echo count($ors);
                        // echo '<pre>';
                        // print_r($ors);
                        // echo '</pre>';
                        // exit();
                        $query->andFilterWhere($ors)->orWhere(['bairros' => '']);
                    else:
                        $query->andFilterWhere($ors);
                    endif;
                endif;
                // Para os tipos de imóveis
                $tipo_registro = $model->tipo;
                $tipos = explode(';',$tipo_registro);
                $ors2 = [
                    'or',
                    ['like', 'tipo', $model->tipo],
                ];
                if(!empty($tipo_registro))
                foreach ($tipos as $t):
                    array_push($ors2,['like', 'tipo', $t]);
                endforeach;
                //pesquisa
                $permutas = ImovelPermuta::find()->where([
                    'elevador' => $model->elevador,
                    'sacada' => $model->sacada,
                ])->andFilterWhere($ors)->andFilterWhere($ors2)
                ->andFilterWhere(['<>', 'codigo',  $model->codigo])
                ->andFilterWhere(['<=', 'valor_minimo',  $model->valor_minimo])
                ->andFilterWhere(['>=', 'valor_maximo',  $model->valor_maximo])
                ->andFilterWhere(['<=', 'area_total',    $model->area_total])
                ->andFilterWhere(['<=', 'area_privativa',$model->area_privativa])
                ->andFilterWhere(['<=', 'garagens',      $model->garagens])
                ->andFilterWhere(['<=', 'dormitorios',   $model->dormitorios])->all();

                foreach ($permutas as $row) {
                    // echo $row->idimovel_permuta.'<br>';
                    // exit();
                    $msg = '';
                    $up = Usuariopermutas::find()->where(['permuta'=>$row->idimovel_permuta])->one();
                    $user_recebe_email = Usuario::find()->where(['id'=>$up->usuario])->one();
                    $msg .= '<a href="https://www.cafeinteligencia.com.br'.Yii::$app->homeUrl.'imovelpermuta/view?id='.$model->idimovel_permuta.'">Permuta código PIN-'.$model->codigo.'</a><br>';
                    $msg .= '<div><br><hr>';
                    $msg .= '<ul>';
                    $msg .= '<li><strong>Código: </strong>PIN-'.$model->codigo."<br>".
                            '</li>'.
                            '<li><strong>Tipo: </strong>'.$model->tipo."<br>".
                            '</li>'.
                            '<li><strong>Dormitórios: </strong>'.$model->dormitorios."<br>".
                            '</li>'.
                            '<li><strong>Garagens: </strong>'.$model->garagens."<br>".
                            '</li>'.
                            '<li><strong>Área Privativa: </strong>'.number_format($model->area_privativa.'.00', 2, ',', '.').' m²'."<br>".
                            '</li>'.
                            '<li><strong>Área Total: </strong>'.number_format($model->area_total.'.00', 2, ',', '.').' m²'."<br>".
                            '</li>'.
                            '<li><strong>Bairros: </strong>'.$model->bairros."<br>".
                            '</li>'.
                            '<li><strong>Elevador: </strong>'.$model->elevador."<br>".
                            '</li>'.
                            '<li><strong>Sacada: </strong>'.$model->sacada."<br>".
                            '</li>'.
                            '<li><strong>Valor Máximo: </strong>'.'R$ '.number_format($model->valor_maximo.'.00', 2, ',', '.')."<br>".
                            '</li>'.
                            '<li><strong>Valor Mínimo: </strong>'.'R$ '.number_format($model->valor_minimo.'.00', 2, ',', '.')."<br>".
                            '</li>';
                    $msg .= '</ul>';
                    $msg .= '</div>';
                    $msg .= '<br>';
                    $msg .= '<hr>';
                    $msg .= '<p>'.$model->observacoes.'</p>';
                    $msg .= '<hr>';
                    $msg .= '<strong>Café Inteligência Imobiliária</strong>';
                    $assunto = 'Edição de Permuta Compatível com o seu registro PIN-'.$row->codigo;
                    // Yii::$app->mailer->compose("@app/mail/layouts/html",['content'=>$msg])
                    //         ->setTo($user_recebe_email->email)
                    //         ->setFrom(['cafeinteligencia@gmail.com' => 'Café Inteligência Imobiliária'])
                    //         ->setSubject('Edição de Permuta Compatível com o seu registro PIN-'.$row->codigo.', cadastrada no Sistema')
                    //         ->setTextBody('corpo da mensagem')
                    //         ->send();

                    if (Mail::send($user_recebe_email->email, $assunto, $msg))
                        echo "sucesso no envio";
                    // Mail::send($para, $assunto, $mensagem);
                }

                return $this->redirect(['view', 'id' => $model->idimovel_permuta]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ImovelPermuta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $controle = new Controle;
        $controle->acao_feita = 'Exclusão';
        $controle->detalhes_acao = implode(",", $model->attributes);
        $controle->permuta_id = $model->idimovel_permuta;
        $controle->atualizador = Yii::$app->user->identity->id;
        $controle->data_alteracao = date('Y-m-d H:i:s');
        $controle->save();

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ImovelPermuta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ImovelPermuta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ImovelPermuta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /*
    *
    */
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
    //globais dos jsons
    
}
