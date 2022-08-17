<?php

namespace app\controllers;

use Yii;
use app\models\Proprietario;
use app\models\ProprietarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use kartik\editable\Editable;
use yii\widgets\MaskedInput;

use yii\filters\AccessControl;
use kartik\mpdf\Pdf;
use yii\helpers\Html;

/**
 * ProprietarioController implements the CRUD actions for Proprietario model.
 */
class ProprietarioController extends Controller
{
    /**
     * {@inheritdoc}
     */
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
        'id',
        'superlogica',
        'nome',
        'documento_tipo',
        'documento_numero',
        'estado_civil',
        'nome_fantasia',
        'conta_deposito',
        'banco',
        'agencia',
        'operacao',
        'nome_titular',
        'cpf_titular',
        'codigo_imovel',
        'logradouro',
        'inicio_locacao',
        'mais_informacoes',
        'celular',
        'telefone',
        'email',
        'cpf_cnpj',
        'cpf',
        'usuario_id',
        'rg',
        'orgao',
        'sexo',
        'data_nascimento',
        'nacionalidade',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'proposta_id',
        'iptu',
        'condominio',
        'foto_rg',
        'foto_cpf',
        'cnj_foto_rg',
        'cnj_foto_cpf',
    ];
    public function behaviors() {
      return [
          'access'=> [
              'class' => AccessControl::className(),
              //'only' => ['create','delete','update'],
              'rules' => [
                    ['actions' => ['update'],       'allow' => true,   'roles' => ['faturas-update']],
                    ['actions' => ['editcampo','report'],    'allow' => true,   'roles' => ['faturas-update']],
                    ['actions' => ['create'],       'allow' => true,   'roles' => ['faturas-create']],
                    ['actions' => [
                        'novo',
                        'report'
                    ],
                    'allow' => true,
                    'roles' => ['faturas-create']],
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
     * Lists all Proprietario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProprietarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Proprietario model.
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
     * Creates a new Proprietario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Proprietario();

        if ($model->load(Yii::$app->request->post())) {
            // return $this->redirect(['view', 'id' => $model->id]);
            $model->data_nascimento = $this->formatar_data_pro_banco($model->data_nascimento);
            if ($model->save()) {
                $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Proprietario model.
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
     * Deletes an existing Proprietario model.
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

    /**
     * Finds the Proprietario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Proprietario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Proprietario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /**
     * Campo Editável
     * 
     */
    public function formatar_data_pro_banco($data) {
        $arr = explode('/',$data);
        return $arr[2].'-'.$arr[1].'-'.$arr[0];
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
            case 'cnj_data_nascimento': $model->$campo = $this->formatar_data_pro_banco($valor); break;
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
    public function imprime_campo_editavel($col_md, $tabela, $campo, $title, $valor, $id, $conj = null) {
        $input = Editable::INPUT_TEXT;
        $editableoptions = [
                'class'=>'form-control',
        ];
        $widgetClass = '';
        $valore = $valor;
        $data = [];
        $displayValueConfig = [];

        if (in_array($campo,['data', 'data_nascimento', 'cnj_data_nascimento', 'data_expedicao', 'documento_data_emissao', 'data_admissao'])) {
            $input = Editable::INPUT_WIDGET;
            $editableoptions = [
                'class' => 'form-control',
                'mask' => '99/99/9999'
            ];
            $widgetClass = MaskedInput::className();
            $valore = date('d/m/Y', strtotime($valor));
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
        if (in_array($campo,['celular', 'telefone_celular', 'whatsapp', 'telefone', 'fone', 'telefone_residencial','fone_residencial', 'fone_celular'])) {
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
        if ($title) {
            $retorno = '<label>'.$title.'</label><br />';
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
            $retorno .= "<br>";
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
    public function actionReport($id) {
        // get your HTML raw content without any layouts or scripts
        $content = '<br>';
        // echo $id;
        // exit();
        
        $proposta = $this->findModel($id);
        
        $content .= '<div style="width: 100%">';
            $content .= '<div style="width: 48%; float: left; padding: 1%;">';
                $content .= $this->campopdf('Nome', $proposta->nome);
                $content .= $this->campopdf('Data de Nascimento', date('d/m/Y', strtotime($proposta->data_nascimento)));
                $content .= $this->campopdf('Celular (whats)', $this->format_telefone($proposta->celular));
                $content .= $this->campopdf('Email', $proposta->email);
                $content .= $this->campopdf('Estado Civil', $proposta->estado_civil);
                $content .= $this->campopdf('<b>Imóvel:</b> Valor do IPTU', $proposta->iptu);
                $content .= $this->campopdf('<b>Imóvel:</b> Condomínio', $proposta->condominio);
            $content .= '</div>';
            $content .= '<div style="width: 48%; float: left; padding: 1%;">';
                $content .= $this->campopdf('CPF', $this->format_doc($proposta->cpf_cnpj,'cpf'));
                // $content .= $this->campopdf('Tipo de Documento', $proposta->documento_tipo);
                $content .= $this->campopdf('Nº do Documento '."($proposta->documento_tipo)", $proposta->documento_numero);
                $content .= $this->campopdf('Órgão Emissor', $proposta->orgao);
                $content .= $this->campopdf('<b>Dados Bancários</b> - Banco', $proposta->banco);
                $content .= $this->campopdf('Agência', $proposta->agencia);
                $content .= $this->campopdf('Operação', $proposta->operacao);
                $content .= $this->campopdf('Conta', $proposta->conta_deposito);
            $content .= '</div>';
        $content .= '</div>';
        if ($proposta->estado_civil == 'Casado') {
            $content .= '<hr>';
            $content .= '<h4>Cônjuge: '.$proposta->cnj_nome.'</h4>';
            $content .= '<div style="width: 48%; float: left; padding: 1%;">';
            
            $i = 1;
            foreach ($proposta as $key => $value) {
                if (!in_array($key,$this->arr_campos_retirados_docs_conj)):
                    switch ($key) {
                        case 'cnj_cpf': $valor = $this->format_doc($value,'cpf'); break;
                        case 'celular': $valor = $this->format_telefone($value); break;
                        case 'fone_celular': $valor = $this->format_telefone($value); break;
                        case 'fone_residencial': $valor = $this->format_telefone($value); break;
                        case 'data_nascimento': $valor = date('d/m/Y',strtotime($value)); break;
                        case 'cnj_data_nascimento': $valor = date('d/m/Y',strtotime($value)); break;
                        case 'data_expedicao': $valor = date('d/m/Y',strtotime($value)); break;
                        case 'genero': $valor = $value=='M'?'Masculino':'Feminino'; break;
                        case 'renda': $valor = 'R$ '.number_format($value, 2, ',', '.'); break;
                        default: $valor = $value; break;
                    }
                    $content .= $this->campopdf($proposta->getAttributeLabel($key), $valor);
                    if ($i%5 == 0) {
                        $content .= '</div>';
                        $content .= '<div style="width: 48%; float: left; padding: 1%;">';
                    }
                    $i++;
                endif;
            }
            $content .= '</div>';
        }
        $content .= '</div>';
        
        if ($proposta->foto_rg) :
            
            $prefixo_nome_arquivo = $this->clean($proposta->codigo_imovel);
            $frente_doc = Yii::$app->homeUrl.'/uploads/_file_rg_proprietario_'.$prefixo_nome_arquivo.'_'.$proposta->foto_rg;
            $verso_doc = Yii::$app->homeUrl.'/uploads/_file_cpf_proprietario_'.$prefixo_nome_arquivo.'_'.$proposta->foto_cpf;
            $cnj_frente_doc = Yii::$app->homeUrl.'/uploads/_cnj_file_foto_rg_proprietario_'.$prefixo_nome_arquivo.'_'.$proposta->cnj_foto_rg;
            $cnj_verso_doc = Yii::$app->homeUrl.'/uploads/_cnj_file_foto_cpf_proprietario_'.$prefixo_nome_arquivo.'_'.$proposta->cnj_foto_cpf;

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
                if (pathinfo($cnj_frente_doc, PATHINFO_EXTENSION) != 'pdf') {
                    $content .= '<div style="width: 47%; float: left; padding: 1%;">';
                    // $content .= '<hr>';
                    $content .= '<strong>Cônjuge: Frente do Documento</strong>';
                    $content .= "<img src='".$cnj_frente_doc."'/>";
                    $content .= '<br>';
                    $content .= '</div>';
                }
                if (pathinfo($cnj_verso_doc, PATHINFO_EXTENSION) != 'pdf') {
                    $content .= '<div style="width: 47%; float: left; padding: 1%;">';
                    // $content .= '<hr>';
                    $content .= '<strong>Cônjuge: Verso do Documento</strong>';
                    $content .= "<img src='".$cnj_verso_doc."'/>";
                    $content .= '<br>';
                    $content .= '</div>';
                }
            
            }
        endif;
        $content .= '</div>';
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

    public function mostrafiledoc($readarquivo) {
        header('Cache-control: private');
        header('Content-Type: application/octet-stream');
        $ext_imagens = [
            'JPG',
            'JPEG',
            'PNG',
            'PNEG',
            'BMP',
            'jpg',
            'jpeg',
            'png',
            'pneg',
            'bmp',
        ];
        $ext_pdfs = [
            'PDF',
            'pdf',
        ];
        $readarquivo = urldecode($readarquivo);
        if (in_array(pathinfo($readarquivo, PATHINFO_EXTENSION), $ext_pdfs)):
            return '<div>
                <object data="'.$readarquivo.'" type="application/pdf" width="250" height="300">
                    alt : <a href="'.$readarquivo.'">test.pdf</a>
                </object>
            </div>';
        elseif (in_array(pathinfo($readarquivo, PATHINFO_EXTENSION), $ext_imagens)):
            return Html::img($readarquivo, [
                'alt' => 'Frente',
                'style' => 'width: auto; max-width: 100%; max-height: 300px;'
            ]);
        else:
            return '<div>
                <a href="'.$readarquivo.'">
                    Baixar Documento
                </a>
            </div>';
        endif;
    }
}
