<?php

namespace app\controllers;

use Yii;
use app\models\Imoveisexternos;
use app\models\ImoveisexternosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ImoveisexternosController implements the CRUD actions for Imoveisexternos model.
 */
class ImoveisexternosController extends Controller
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
                    ['actions' => ['editregistro'], 'allow' => true,   'roles' => ['faturas-update']],
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
     * Lists all Imoveisexternos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImoveisexternosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // $this->getView()->registerJs("function addCommas(nStr) {
        //     nStr += '';
        //     var x = nStr.split('.');
        //     var x1 = x[0];
        //     var x2 = x.length > 1 ? '.' + x[1] : '';
        //     var rgx = /(\d+)(\d{3})/;
        //     while (rgx.test(x1)) {
        //             x1 = x1.replace(rgx, '$1' + '.' + '$2');
        //     }
        //     return x1 + x2;
        // };");

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            // 'model' => $this->findModel($id),
        ]);
    }

    /**
     * Displays a single Imoveisexternos model.
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
     * Creates a new Imoveisexternos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Imoveisexternos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Imoveisexternos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Imoveisexternos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(Yii::$app->request->referrer);
        // return $this->redirect(['index']);
    }

    /**
     * Finds the Imoveisexternos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Imoveisexternos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Imoveisexternos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

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

    public function ProcurarImagensNoHTML( $link ) {
        
        $content = file_get_contents($link);
        libxml_use_internal_errors(true);
        $document = new \DOMDocument();
        $document->loadHTML($content);
        
        $images = array();

        foreach($document->getElementsByTagName('meta') as $img)
        {
            // Extract what we want
            $image = array
            (
                'src' => $img->getAttribute('content'),
                'img' => $img->getAttribute('itemprop'),
            );
            
            // Skip images without src
            if( ! $image['src'])
                continue;

            // Add to collection. Use src as key to prevent duplicates.
            if($image['img'] == 'image')
                $images[$image['src']] = $image;
        }
        $images = array_values($images);

        return $images;
        
    }


    //Edita o registro da área
    public function actionEditregistro(){
        $model = $this->findModel($_REQUEST['editableKey']);
        $model->area_privativa = $_REQUEST['Imoveisexternos']['0']['area_privativa'];
        $model->save();
        return '{}';
    }
}
