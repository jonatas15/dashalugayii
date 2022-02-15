<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use app\models\Imoveisexternos;
use app\models\Condominio;


$todas_comodidades = $this->context->get_content('http://www.jetimob.com/services/tZuuHuri8Q3ohAf7cvmMm8hTmWrXKJoEdes8ViSi/comodidades/',864000);
$todas_comodidades = json_decode($todas_comodidades);

$arr_comodidades = [];
foreach ($todas_comodidades as $row) {
    array_push($arr_comodidades,$row->descricao);
}

/* @var $this yii\web\View */
/* @var $model app\models\Imobiliarias */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Imobiliarias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<hr>
    <?php 
    $i = 1;

    $arr_busca_valor = [
        'Venda (Financiável) R$',
        'Locação (Financiável) R$',
        'Venda R$',
        'Locação R$',
        'Valor R$',
        'Valor de venda R$',
        'Valor de locação R$',
        'Preço R$',
        'Preço de venda R$',
        'Preço de locação R$',
        'Investimento R$',
    ];
    
    $arr_busca_cod = ['Ref.:','Referência','Código','Cod.:'];

    $xml = simplexml_load_file($model->sitemap);

    $contratos = [
        'venda-para-alugar',
        'venda-locacao',
        'venda',
        'compra',
        'comprar',
        'locacao',
        'aluga',
        'alugar',
        'investimento'
    ];
    $tipos = [
        'Casa',
        'Sobrado',
        'Apartamento',
        'Kitnet',
        'Cobertura',
        'Coberturas',
        'Duplex',
        'Triplex',
        'Loft',
        'Sala',
        'Loja',
        'Pavilhão',
        'Prédio',
        'Casa',
        'Terreno',
        'Chácara',
        'Campo',
        'Fazenda',
        'Sítio',
    ];
    $medidas_area = [
        'm2',
        'm²',
        'ha',
        'hectares',
    ];
    $arr_busca_valor = [
        'Venda (Minha Casa Minha Vida) R$',
        'Venda (Financiável) R$',
        'Venda (Financiável)R$',
        'Venda R$',
        'VendaR$',
        'Valor R$',
        'Valor de venda R$',
        'Preço R$',
        'Preço de venda R$',
        'Investimento R$',
        'Compra R$',
        'Valor Venda: R$'
    ];
    $arr_busca_valor_locacao = [
        'Locação (Financiável) R$',
        'Locação (Financiável)R$',
        'Locação R$',
        'LocaçãoR$',
        'Valor R$',
        'Valor de locação R$',
        'Preço R$',
        'Preço de locação R$',
        'Investimento R$',
        'Aluguel R$',
        'Valor Locação: R$'
    ];
    $dormitorios = [
        'quartos',
        'quarto',
        'dormitorios',
        'dormitorio',
        'Dormitórios',
        'Quartos',
        'quartos:',
        'quarto:',
        'dormitorios:',
        'dormitorio:',
        'Dormitórios:',
        'Quartos:',
    ];
    $vagas = [
        'Vagas/Garagens',
        'Vagas/Garagem',
        'vagas',
        'vaga',
        'garagens',
        'garagem',
        'Vagas',
        'Garagens',
        'Vagas/Box',
        'Box/Garagens',
        'Box',
        'Garagem:',
    ];
    $banheiros = [
        'Banheiros',
        'banheiros',
        'Banheiro',
        'banheiro',
    ];

    $arr_condominios = array();
    foreach (Condominio::find()->all() as $row) {
        // array_push($arr_condominios,$row->slug);
        $arr_condominios[$row->slug] = $row->nome;
    }
    // echo '<pre>';
    // print_r($arr_condominios);
    // echo '</pre>';
    // exit();

    $count_registros = 0;
    $count_erros = 0;
    $count_jaregistrados = 0;

    switch ($model->id) {
        case 1:  $cod_imobiliaria = 'FF-'; break;
        case 2:  $cod_imobiliaria = 'DZ-'; break;
        case 3:  $cod_imobiliaria = 'NI-'; break;
        case 5:  $cod_imobiliaria = '8I-'; break;
        case 6:  $cod_imobiliaria = 'AP-'; break;
        case 7:  $cod_imobiliaria = 'AI-'; break;
        case 8:  $cod_imobiliaria = 'AY-'; break;
        case 9:  $cod_imobiliaria = 'BI-'; break;
        case 10: $cod_imobiliaria = 'BL-'; break;
        case 11: $cod_imobiliaria = 'BR-'; break;
        case 12: $cod_imobiliaria = 'CI-'; break;
        case 13: $cod_imobiliaria = 'CN-'; break;
        case 15: $cod_imobiliaria = 'CM-'; break;
        case 16: $cod_imobiliaria = 'CS-'; break;
        case 17: $cod_imobiliaria = 'CT-'; break;
        case 18: $cod_imobiliaria = 'CB-'; break;
        case 19: $cod_imobiliaria = 'CR-'; break;
        case 20: $cod_imobiliaria = 'ES-'; break;
        case 21: $cod_imobiliaria = 'IS-'; break;
        case 22: $cod_imobiliaria = 'II-'; break;
        case 23: $cod_imobiliaria = 'IG-'; break;
        case 24: $cod_imobiliaria = 'IM-'; break;
        case 25: $cod_imobiliaria = 'IO-'; break;
        case 26: $cod_imobiliaria = 'IP-'; break;
        case 27: $cod_imobiliaria = 'IT-'; break;
        case 28: $cod_imobiliaria = 'JC-'; break;
        case 29: $cod_imobiliaria = 'KI-'; break;
        case 30: $cod_imobiliaria = 'LI-'; break;
        case 31: $cod_imobiliaria = 'LC-'; break;
        case 32: $cod_imobiliaria = 'MI-'; break;
        case 33: $cod_imobiliaria = 'NR-'; break;
        case 34: $cod_imobiliaria = 'OI-'; break;
        case 35: $cod_imobiliaria = 'PA-'; break;
        case 36: $cod_imobiliaria = 'PR-'; break;
        case 37: $cod_imobiliaria = 'PO-'; break;
        case 38: $cod_imobiliaria = 'PI-'; break;
        case 39: $cod_imobiliaria = 'RI-'; break;
        case 40: $cod_imobiliaria = 'RB-'; break;
        case 41: $cod_imobiliaria = 'RM-'; break;
        case 42: $cod_imobiliaria = 'RV-'; break;
        case 43: $cod_imobiliaria = 'SS-'; break;
        case 44: $cod_imobiliaria = 'SI-'; break;
        case 45: $cod_imobiliaria = 'SM-'; break;
        case 46: $cod_imobiliaria = 'SV-'; break;
        case 47: $cod_imobiliaria = 'TZ-'; break;
        case 48: $cod_imobiliaria = 'MZ-'; break;
        case 49: $cod_imobiliaria = 'WB-'; break;
        case 50: $cod_imobiliaria = 'RD-'; break;
        case 51: $cod_imobiliaria = 'IV-'; break;
        case 52: $cod_imobiliaria = 'MO-'; break;
        case 53: $cod_imobiliaria = 'AX-'; break;
        case 54: $cod_imobiliaria = 'AL-'; break;
        case 55: $cod_imobiliaria = 'CA-'; break;
        case 56: $cod_imobiliaria = 'CO-'; break;
        case 57: $cod_imobiliaria = 'FC-'; break;
        case 58: $cod_imobiliaria = 'BG-'; break;
        case 59: $cod_imobiliaria = 'BS-'; break;
        case 61: $cod_imobiliaria = 'RF-'; break;
		case 62: $cod_imobiliaria = 'MT-'; break;

        default: 
            $cod_imobiliaria = 'Imob-';  
            break;
    }
    $pesquisa_codigos = ArrayHelper::map(Imoveisexternos::find()->asArray()->all(), 'id','codigo');

    foreach ($xml as $row) {
        $pos = strpos(strtolower($row->loc), 'santa-maria');
        
        if(!empty($pos)){
            
            $inicio = 0;
            $final = 3;
            if($_REQUEST['inicio']) $inicio = $_REQUEST['inicio'];
            if($_REQUEST['final']) $final = $_REQUEST['final'];

            if ($i>$inicio):

                $codigo_exoimovel = $cod_imobiliaria.$this->context->captura_info($row->loc,'/','cod')['dado'];

                if (!in_array($codigo_exoimovel,$pesquisa_codigos)) {

                    //Gerar aqui de uma só vez o conteúdo da página
                    $content = file_get_contents($row->loc);

                    $content = $this->context->strip_html_tags($content);

                    if($content):
                
                      $mystring = strip_tags($content);
                      $partness = ['/\r?\n/','/\s+/'];
                      $mystring = preg_replace($partness, ' ', $mystring);
                      $mystring = trim($mystring);

                      $sub_string = strtolower($mystring);
                      
                      if(strpos($sub_string, 'home')) {
                          $sub_string = strstr(strtolower($mystring),'home');
                      }
                      
                      if(strpos($sub_string, 'início')) {
                          $sub_string = strstr(strtolower($mystring),'início');
                      }
                      
                      if(strpos($sub_string, 'outras unidades')) {
                          $sub_string = strstr($sub_string,'outras unidades',true);
                      }
                      
                      if(strpos($sub_string, 'imóveis semelhantes')) {
                          $sub_string = strstr($sub_string,'imóveis semelhantes',true);
                      }

                      echo "<pre>";
                      echo $sub_string;
                      echo "</pre>";

                      $mystring = str_replace('/','-',$sub_string);

                    endif;

                    $tipo_exoimovel = $this->context->captura_info($row->loc,$tipos,'tipo',true)['dado'];
                    $contrato_exoimovel = $this->context->captura_info($row->loc,$contratos,'contrato',true,$mystring)['dado'];
                    $bairro_exoimovel = $this->context->captura_info($row->loc,'','bairro',true,$mystring)['dado'];
                    $dormitorios_exoimovel = $this->context->captura_info($row->loc,$dormitorios,'quartos',true,$mystring)['dado'];
                    $garagens_exoimovel = $this->context->captura_info($row->loc,$vagas,'vagas',true,$mystring);
                    $area_exoimovel = $this->context->captura_info($row->loc,[
                        'Área Privativa',
                        'Área privativa',
                        'área privativa',
                        'Área Útil',
                        'Área útil',
                        'área útil',
                        'Área Total',
                        'Área total',
                        'área total',
                        'Área do Terreno',
                        'Área do terreno',
                        'área do terreno',
                    ],'area',true,$mystring)['dado'];
                    $condominio_exoimovel = $this->context->captura_info($row->loc,$arr_condominios,'condominio',true,$mystring)['dado'];

                    $banheiros_exoimovel = $this->context->captura_info($row->loc,$banheiros,'banheiros',true, $mystring)['dado'];
                    $comodidades_exoimovel = $this->context->captura_info($row->loc,$arr_comodidades,'comodidades',true, $mystring)['dado'];

                    if ($contrato_exoimovel == 'Locação') {
                        $valor_exoimovel = $this->context->captura_info($row->loc,$arr_busca_valor_locacao,'R$',true, $mystring)['dado'];
                    } else {
                        $valor_exoimovel = $this->context->captura_info($row->loc,$arr_busca_valor,'R$',true, $mystring)['dado'];
                    }
                    $imagem_exoimovel = $this->context->captura_info($row->loc,'','imagem',true)['dado'];

                    echo "<a href='$row->loc' target='_blanck'>".$i.') '.$row->loc.'</a>';
                    echo '<br>';
                    echo 'Codigo => '.$codigo_exoimovel.'<br>';
                    echo 'Contrato => '.$contrato_exoimovel.'<br>';
                    echo 'Tipo => '.$tipo_exoimovel.'<br>';
                    echo 'Bairro => '.$bairro_exoimovel.'<br>';
                    echo 'Condominio => '.$condominio_exoimovel.'<br>';
                    echo 'Quartos => '.$dormitorios_exoimovel.'<br>';
                    echo 'Garagens => '.$garagens_exoimovel['dado'].' - '.$garagens_exoimovel['medida'].'<br>';
                    echo 'Área privativa => '.$area_exoimovel.' m²<br>';
                    echo 'Banheiros => '.$banheiros_exoimovel.'<br>';
                    // echo 'Garagens => '.$this->context->captura_info($row->loc,$vagas,'vagas')['medida'].'<br>';
                    // echo 'Área => '.$this->context->captura_info($row->loc,$medidas_area,'area')['dado'].' '.$this->context->captura_info($row->loc,$medidas_area,'area')['medida'].'<br>';
                    //Agora vamos capturar os valores, seja o que deus quiser
                    
                    
                    echo 'Valor => ' . 'R$ '.number_format($valor_exoimovel, 2, ',', '.');
                    // echo ' :: ('.$this->context->captura_info($row->loc,$arr_busca_valor,'R$')['medida'].')';
                    
                    // exit();

                    // echo '<hr>';

                    // echo "<img src='$imagem_exoimovel' width='180' />";

                    // echo '<hr>';

                    //Insere no banco de dados:
                    
                    $grava_comodidades = "";
                    $conta_comodidades = count($comodidades_exoimovel);
                    $cc = 1;

                    foreach ($comodidades_exoimovel as $key => $value) {
                        $grava_comodidades .= $value;
                        if ($cc < $conta_comodidades) {
                            $grava_comodidades .= ', ';
                        }
                        $cc++;
                    }

                    echo "<br>";
                    echo "<pre>";
                    echo $grava_comodidades;
                    echo "<hr>";
                    print_r($comodidades_exoimovel);
                    echo "</pre>";
                    echo "<br>";
                    /*
                    */
                     
                    $exoimovel = new Imoveisexternos();
                    $exoimovel->imobiliarias_id = $model->id;
                    $exoimovel->url_imovel = (string)$row->loc;
                    $exoimovel->url_imagem = ($imagem_exoimovel?(string)$imagem_exoimovel:'sem imagem');
                    $exoimovel->endereco_bairro = $bairro_exoimovel;
                    $exoimovel->codigo = (empty($codigo_exoimovel)?'Indefinido':$codigo_exoimovel);
                    $exoimovel->tipo = (empty($tipo_exoimovel)?'Indefinido':$tipo_exoimovel);
                    $exoimovel->contrato = (empty($contrato_exoimovel)?'Indefinido':$contrato_exoimovel);
                    $exoimovel->valor_venda = $valor_exoimovel;
                    $exoimovel->dormitorios = (int)$dormitorios_exoimovel;
                    $exoimovel->banheiros = (int)$banheiros_exoimovel;
                    $exoimovel->garagens = (int)$garagens_exoimovel;
                    $exoimovel->area_privativa = $area_exoimovel;
                    $exoimovel->condominio = $condominio_exoimovel;
                    $exoimovel->comodidades = $grava_comodidades;
                    
                
                    // if($exoimovel->save()){
                    //     echo '<pre>imovel salvo</pre>';
                    //     $count_registros++;
                    // }else{
                    //     echo '<pre>erro ao cadastrar</pre>';
                    //     $count_erros++;
                    // }
                }else{
                    
                    $contrato_exoimovel = $this->context->captura_info($row->loc,$contratos,'contrato')['dado'];
                    if ($contrato_exoimovel == 'Locação') {
                        $valor_exoimovel = $this->context->captura_info($row->loc,$arr_busca_valor_locacao,'R$')['dado'];
                    } else {
                        $valor_exoimovel = $this->context->captura_info($row->loc,$arr_busca_valor,'R$')['dado'];
                    }

                    echo '<br>'."<a href='$row->loc' target='_blanck'>".$i.') '.$row->loc.'</a>';
                    echo '<pre>imovel '.$codigo_exoimovel.' já existente!</pre>';
                    $count_jaregistrados++;
                }
               
                
            endif;
            $i++;
            if($i >= $final){
                break;
                /*
                $novo_final = $final + 50;
                
                return $this->context->redirect(['view',
                    'id' => $model->id,
                    'inicio' => $final,
                    'final' => $novo_final,
                ]);
                */
                
                // break;
            }
            // if($i>=11){
            //     break;
            // }
            
            // $i++;
        }
    }
    echo 'imoveis: '.$i;
    echo '<hr>';
    echo '<ul>';
    echo '<li>Registros feitos: '.$count_registros.'</li>';
    echo '<li>Erros de registro: '.$count_erros.'</li>';
    echo '<li>Já registrados: '.$count_jaregistrados.'</li>';
    echo '</ul>';
    ?>
<hr>


<div class="imobiliarias-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'url:url',
            'sitemap',
            'data_cadastro',
            'data_alteracao',
        ],
    ]) ?>

</div>
