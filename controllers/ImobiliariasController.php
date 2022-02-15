<?php

namespace app\controllers;

use Yii;
use app\models\Imobiliarias;
use app\models\ImobiliariasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ImobiliariasController implements the CRUD actions for Imobiliarias model.
 */
class ImobiliariasController extends Controller
{
    /**
     * @inheritdoc
     */

     public $bairros_santamaria = [
         "Agroindustrial",
         "Arroio Grande",
         "Boi Morto",
         "Boca do Monte",
         "Bonfim",
         "Camobi",
         "Campestre do Menino Deus",
         "Caramelo",
         "Carolina",
         "Caturrita",
         "Cauduro",
         "Centro",
         "Cerrito",
         "Chácara das Flores",
         "Cohab F Ferrari",
         "Cohab Passo Ferreira",
         "Cohab Santa Marta",
         "Cohab Tancredo Neves",
         "Diácono João Luiz Pozzobon",
         "Distrito Industrial",
         "Divina Providência",
         "Dom Antônio Reis",
         "Duque de Caxias",
         "Faixa Soo Pedro",
         "Formosa",
         "Industrial",
         "Itararé",
         "Itararu",
         "Juscelino Kubitschek",
         "João Luiz Pozzobon",
         "Jardim Berleze",
         "Km 3",
         "Lorenzi",
         "Maringá",
         "Menino Jesus",
         "Noal",
         "Nonoai",
         "Nossa Senhora das Dores",
         "Nossa Senhora de Fátima",
         "Nossa Senhora de Lourdes",
         "Nossa Senhora do Perpétuo Socorro",
         "Nossa Senhora do Rosário",
         "Nossa Senhora Dores",
         "Nossa Senhora Medianeira",
         "Medianeira",
         "Nova Santa Marta",
         "Novo Horizonte",
         "Padre de Platano",
         "Passo D'areia",
         "Passo das Tropas",
         "Patronato",
         "Pé de Plátano",
         "Pinheiro Machado",
         "Presidente João Goulart",
         "Renascença",
         "Retiro Padres",
         "Ruralcel",
         "Salgado Filho",
         "São João",
         "São José",
         "Subúrbios",
         "Switch",
         "Tancredo Neves",
         "Tomazetti",
         "Uglione",
         "Urlandia",
         "Vila Arco-íris",
         "Vila Bilibio",
         "Vila Fighera",
         "Vila Formosa",
         "Zona Rural",
         "Área Rural",
     ];

     

    public function behaviors()
    {
        return [
            'access'=> [
                'class' => AccessControl::className(),
                //'only' => ['create','delete','update'],
                'rules' => [
                    ['actions' => ['update'],           'allow' => true,   'roles' => ['faturas-update']],
                    ['actions' => ['create'],           'allow' => true,   'roles' => ['faturas-create']],
                    ['actions' => ['index'],            'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['view'],             'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['atualiza'],         'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['addcondominios'],   'allow' => true,   'roles' => ['faturas-indexa']],
                    ['actions' => ['cruzamento'],       'allow' => true,   'roles' => ['faturas-indexa']],
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
     * Lists all Imobiliarias models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImobiliariasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Lists all Imobiliarias models.
     * @return mixed
     */
    public function actionAddcondominios($id)
    {
        return $this->render('addcondominios', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Displays a single Imobiliarias model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionAtualiza($id)
    {
        return $this->render('atualiza', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Imobiliarias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Imobiliarias();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Imobiliarias model.
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
     * Deletes an existing Imobiliarias model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Imobiliarias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Imobiliarias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Imobiliarias::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Funções by Jonatas Almeida da Silva
     */
    private function tirarAcentos($string) {
        $stringa = str_replace(', ', ',', $string);
        $stringb = str_replace(' ,', ',', $stringa);
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/", "/(ç)/", "/(Ç)/"), explode(" ", "a A e E i I o O u U n N c C"), $stringb);
    }

    private function urlAmigavel($nom_tag, $slug = "-") {
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
        // echo "<pre>";
        // print_r($images);
        // echo "</pre>";

        if(empty($images)){
          // echo 'array vazio';
          foreach($document->getElementsByTagName('a') as $img)
          {
              // Extract what we want
              $image = array
              (
                  'src' => $img->getAttribute('href'),
                  'img' => $img->getAttribute('rel'),
              );

              // Skip images without src
              if( ! $image['src'])
                  continue;

              // Add to collection. Use src as key to prevent duplicates.
              if($image['img'] == 'galeria-imovel')
                $images[$image['src']] = $image;
          }
          $images = array_values($images);
        }
        // echo "<pre>";
        // print_r($images);
        // echo "</pre>";

        return $images;

    }

    function captura_info($conteudo, $procura, $marcador = false, $encontrado = false, $mystring = false){

        if($marcador == 'cod'){
            $posicao_procurada = strrpos($conteudo, $procura);
            $informacao = substr($conteudo,$posicao_procurada+strlen($procura));
            if ($informacao == '') {
              $informacao = preg_replace("/[^0-9]/", "",$conteudo);
              $informacao = substr($informacao,0,5);
            }
        }
        $medida = '';
        // $encontrado = false;
        if($encontrado):

                if($marcador == 'imagem'){
                    $informacao = 'imagem não encontrada';
                    $imagens = $this->ProcurarImagensNoHTML($conteudo);
                    if($imagens and !empty($imagens)){
                        $imagem = array_shift($imagens);
                        $informacao = $imagem['src'];
                    }

                }
                //criar array a partir dos registros da imobiliaria
                if($marcador == 'comodidades'){
                    
                    $informacao = 'Não';

                    $arr_comodidades_encontradas = [];
                    foreach ($procura as $row) {
                        
                        $posicao_procurada = strpos($mystring, strtolower($row));
                        if($posicao_procurada){
                            array_push($arr_comodidades_encontradas, $row);
                        }
                    }
                    $informacao = $arr_comodidades_encontradas;

                }
                //Comodidades
                if($marcador == 'condominio'){
                    $informacao = 'Sem condomínio';
                    $mystring = $this->urlAmigavel($mystring);
                    foreach ($procura as $b=>$v) {
                        $posicao_procurada = strpos($mystring, $b);
                        if($posicao_procurada){
                            $informacao = $v;
                            break;
                        }
                    }
                }
                //Area
                if($marcador == 'area'){
                    $informacao = 0;
                    foreach ($procura as $b) {
                        # code...
                        $posicao_procurada = strpos($mystring, $b);

                        if ($posicao_procurada !== false) {

                            $informacao = substr($mystring, $posicao_procurada+strlen($b),10);
                            // echo $informacao;
                            $info = explode(',',$informacao);
                            $dig1 = 0;
                            $dig2 = 0;
                            if(!empty($info[0])){
                                $dig1 = preg_replace("/[^0-9]/", "",$info[0]);
                            }
                            if($info[1]){
                                $dig2 = preg_replace("/[^0-9]/", "",$info[1]);
                            }
                            $informacao = $dig1.'.'.$dig2;
                            break;
                        }
                    }
                }
                elseif($marcador == 'R$'){
                    $informacao = 0;
                    foreach ($procura as $row) {

                        $posicao_procurada = strpos($mystring, strtolower($row));

                        if($posicao_procurada !== false){

                            $recebe = substr($mystring,$posicao_procurada+strlen($row),11);

                            if(strpos($recebe, ',00')){
                                $mystring = strstr($mystring,',00',true);
                            }
                            if(strpos($recebe, '.00')){
                                $mystring = strstr($mystring,'.00',true);
                            }

                            $informacao = preg_replace("/[^0-9]/", "",str_replace(',00','',$recebe));
                            if (strlen($informacao) > 10 or empty($informacao)){
                                $informacao = 0;
                            }

                            $medida = $row;
                            break;
                        }else{
                            echo "pos nao encontrada";
                        }
                    }
                }

                elseif($marcador == 'quartos'){
                    $informacao = 0;
                    foreach ($procura as $row) {
                        $posicao_procurada = strpos($conteudo, $row);
                        if($posicao_procurada){
                            $informacao = substr($conteudo,$posicao_procurada-2,2);
                            $informacao = preg_replace("/[^0-9]/", "",$informacao);
                            break;
                        }else{
                            $posicao_procurada = strpos($mystring, $row);
                            $informacao = substr($mystring,$posicao_procurada+strlen($row),5);
                            $informacao = preg_replace("/[^0-9]/", "",$informacao);
                            break;
                        }
                    }
                    if ($informacao == 0) {
                        foreach ($procura as $row) {
                            $pos2 = strpos($mystring, $row);
                            if (!empty($pos2)) {
                                // echo 'row: '.$row;
                                $informacao = substr($mystring,$pos2+strlen($row),2);
                                $informacao = preg_replace("/[^0-9]/", "",$informacao);
                                if($informacao == '') {
                                  $informacao = substr($mystring,$pos2-2,2);
                                  $informacao = preg_replace("/[^0-9]/", "",$informacao);
                                }
                                $medida = 'pegou pelo Html';
                                break;
                            }else{
                                $informacao = 0;
                            }
                        }
                    }

                }
                elseif($marcador == 'banheiros'){
                    $informacao = 0;
                    foreach ($procura as $row) {
                        $pos2 = strpos($mystring, $row);
                        if (!empty($pos2)) {
                            // echo 'row: '.$row;
                            $informacao = substr($mystring,$pos2+strlen($row),2);
                            $informacao = preg_replace("/[^0-9]/", "",$informacao);
                            if($informacao == '') {
                              $informacao = substr($mystring,$pos2-2,2);
                              $informacao = preg_replace("/[^0-9]/", "",$informacao);
                            }
                            $medida = 'pegou pelo Html';
                            break;
                        }
                    }
                }
                elseif($marcador == 'vagas'){
                    $informacao = 0;
                    foreach ($procura as $row) {
                        $posicao_procurada = strpos($conteudo, $row);
                        if(!empty($posicao_procurada)){
                            $informacao = substr($conteudo,$posicao_procurada-2,2);
                            $informacao = preg_replace("/[^0-9]/", "",$informacao);
                            $medida = 'pegou pela Url';
                            break;
                        }
                    }
                    if ($informacao == 0) {
                        foreach ($procura as $row) {
                            $pos2 = strpos($mystring, $row);
                            if (!empty($pos2)) {
                              // echo $row;
                                $informacao = substr($mystring,$pos2+strlen($row),2);
                                $informacao = preg_replace("/[^0-9]/", "",$informacao);
                                $medida = 'pegou pelo Html (depois)';
                                if($informacao == '') {
                                  $informacao = substr($mystring,$pos2-2,2);
                                  $informacao = preg_replace("/[^0-9]/", "",$informacao);
                                  $medida = 'pegou pelo Html (antes)';
                                }
                                
                                break;
                            }
                        }
                    }
                }
                elseif($marcador == 'contrato'){
                    $informacao = 'não encontrado';
                    foreach ($procura as $row) {
                        $posicao_procurada = strpos($conteudo, $row);
                        if($posicao_procurada !== false){
                            if(in_array($row,['venda-para-alugar','venda-locacao'])) $informacao = 'Venda/Locação';
                            elseif(in_array($row,['venda','compra','comprar'])) $informacao = 'Venda';
                            elseif(in_array($row,['locacao','aluguel','alugar','aluga'])) $informacao = 'Locação';
                            break;
                        }else{
                            $posicao_procurada = strpos($mystring, $row);
                            if($posicao_procurada !== false){
                                if(in_array($row,['venda-para-alugar','venda-locacao'])) $informacao = 'Venda/Locação';
                                elseif(in_array($row,['venda','compra','comprar'])) $informacao = 'Venda';
                                elseif(in_array($row,['locacao','aluguel','alugar','aluga'])) $informacao = 'Locação';
                                break;
                            }
                        }
                    }
                }
                elseif($marcador == 'tipo'){
                    $informacao = 'Tipo Indefinido';
                    foreach ($procura as $row) {
                        $posicao_procurada = strpos($conteudo, $this->urlAmigavel($row).'-');
                        if(!empty($posicao_procurada)){
                            $informacao = $row;
                            break;
                        }
                    }
                }
                elseif($marcador == 'bairro'){

                    $informacao = 'Bairro não encontrado';

                    foreach ($this->bairros_santamaria as $b) {
                        $pos = strpos($conteudo, $this->urlAmigavel($b));
                        if(!empty($pos)){
                            $informacao = $b;
                            $medida = 'pegou pela url';
                            break;
                        }
                    }

                    if ($informacao == 'Bairro não encontrado') {
                        foreach ($this->bairros_santamaria as $b) {
                            $pos2 = strpos($mystring, strtolower($b));
                            if (!empty($pos2)) {
                                $informacao = $b;
                                $medida = 'pegou pelo Html';
                                break;
                            }
                        }
                    }
                }
                elseif(!$marcador){

                    $posicao_procurada = strpos($conteudo, $procura);
                    $informacao = substr($conteudo,$posicao_procurada,100);
                    $informacao = preg_replace("/[^0-9]/", "",$informacao);

                }

                $retorno = [
                    'dado'=>$informacao,
                    'medida'=>$medida
                ];



                return $retorno;

        else:
            $retorno = [
                'dado'=> $informacao,
                'medida'=>'inexistente'
            ];
            return $retorno;
        endif;
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

    public function strip_html_tags( $text ) {
        $text = preg_replace(
            array(
              // Remove invisible content
                '@<head[^>]*?>.*?</head>@siu',
                '@<style[^>]*?>.*?</style>@siu',
                '@<script[^>]*?.*?</script>@siu',
                '@<object[^>]*?.*?</object>@siu',
                '@<embed[^>]*?.*?</embed>@siu',
                '@<applet[^>]*?.*?</applet>@siu',
                '@<noframes[^>]*?.*?</noframes>@siu',
                '@<noscript[^>]*?.*?</noscript>@siu',
                '@<noembed[^>]*?.*?</noembed>@siu',
              // Add line breaks before and after blocks
                '@</?((address)|(blockquote)|(center)|(del))@iu',
                '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
                '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
                '@</?((table)|(th)|(td)|(caption))@iu',
                '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
                '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
                '@</?((frameset)|(frame)|(iframe))@iu',
            ),
            array(
                ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
                "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
                "\n\$0", "\n\$0",
            ),
            $text );
        return strip_tags( $text );
    }
}
