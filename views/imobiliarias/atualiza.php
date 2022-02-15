<?php

$todas_comodidades = $this->context->get_content('http://www.jetimob.com/services/tZuuHuri8Q3ohAf7cvmMm8hTmWrXKJoEdes8ViSi/comodidades/',864000);
$todas_comodidades = json_decode($todas_comodidades);

$arr_comodidades = [];
foreach ($todas_comodidades as $row) {
    array_push($arr_comodidades,$row->descricao);
}

// echo "<pre>";
// print_r($arr_comodidades);
// echo "</pre>";
// exit();

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use app\models\Imoveisexternos;
use app\models\Condominio;

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
        'Casa Comercial',
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
    ];
    $dormitorios = [
        'Quartos',
        'quartos',
        'Quarto',
        'quarto',
        'dormitorios',
        'dormitórios',
        'dormitório',
        'dormitorio',
        'Dormitorios',
        'Dormitórios',
        'Dormitório',
        'Dormitorio',
    ];
    $vagas = [
        'Vagas/Garagens',
        'Vagas/Garagem',
        'vagas-garagem',
        'vagas',
        'vaga',
        'garagens',
        'garagem',
        'Vagas',
        'Garagens',
        'Vagas/Box',
        'Box/Garagens',
        'Box',
    ];
    $areas = [
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

        default:
            $cod_imobiliaria = 'Imob-';
            break;
    }
    $pesquisa_codigos = ArrayHelper::map(Imoveisexternos::find()->asArray()->all(), 'id','codigo');

    foreach ($xml as $row) {
        $pos = strpos($row->loc, 'santa-maria');
        if(!empty($pos)){
            $inicio = 0;
            $final = 100;
            if($_REQUEST['inicio']) $inicio = $_REQUEST['inicio'];
            if($_REQUEST['final']) $final = $_REQUEST['final'];

            if ($i > $inicio):

                $codigo_exoimovel = $cod_imobiliaria.$this->context->captura_info($row->loc,'/','cod')['dado'];

                if (in_array($codigo_exoimovel,$pesquisa_codigos)) {

                    //Gerar aqui de uma só vez o conteúdo da página
                    $content = file_get_contents($row->loc);

                    if($content):
                      
                      $mystring = strip_tags($content);
                      $partness = ['/\r?\n/','/\s+/'];
                      $mystring = preg_replace($partness, ' ', $mystring);
                      $mystring = trim($mystring);

                      $sub_string = strtolower($mystring);
                      if(strpos($sub_string, 'home')){
                          $sub_string = strstr(strtolower($mystring),'home');
                      }
                      if(strpos($sub_string, 'início')){
                          $sub_string = strstr(strtolower($mystring),'início');
                      }
                      if(strpos($sub_string, 'outras unidades')){
                          $sub_string = strstr($sub_string,'outras unidades',true);
                      }
                      if(strpos($sub_string, 'imóveis semelhantes')){
                          $sub_string = strstr($sub_string,'imóveis semelhantes',true);
                      }

                      $mystring = str_replace('/','-',$sub_string);

                    endif;

                    $banheiros_exoimovel = $this->context->captura_info($row->loc,$banheiros,'banheiros',true, $mystring)['dado'];
                    $comodidades_exoimovel = $this->context->captura_info($row->loc,$arr_comodidades,'comodidades',true, $mystring)['dado'];
                    
                    if ($contrato_exoimovel == 'Locação') {
                        $valor_exoimovel = $this->context->captura_info($row->loc,$arr_busca_valor_locacao,'R$',true,$mystring)['dado'];
                    } else {
                        $valor_exoimovel = $this->context->captura_info($row->loc,$arr_busca_valor,'R$',true,$mystring)['dado'];
                    }
                    $imagem_exoimovel = $this->context->captura_info($row->loc,'','imagem',true)['dado'];

                    echo "<pre>";
                    echo $mystring;
                    echo "</pre>";

                    echo "<a href='$row->loc' target='_blanck'>".$i.') '.$row->loc.'</a>';
                    echo '<br>';
                    echo 'Banheiros => '.$banheiros_exoimovel.'<br>';
                    echo 'Comodidades => ';
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

                    echo $grava_comodidades.'<br>';
                    
                    echo '<hr>';


                    echo '<hr>';
                    // echo "<img src='$imagem_exoimovel' width='180' />";
                    echo '<hr>';

                    Yii::$app->db->createCommand()->update('imoveisexternos', [
                        'banheiros' => (int)$banheiros_exoimovel,
                        'comodidades' => $grava_comodidades
                    ], "codigo = '".$codigo_exoimovel."'")->execute();

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
                $novo_final = $final + 100;
                
                return $this->context->redirect(['atualiza',
                    'id' => $model->id,
                    'inicio' => $final,
                    'final' => $novo_final,
                ]);
                
                break;
            }

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
