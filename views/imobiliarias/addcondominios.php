<?php
use app\models\Condominio;
$sitemap = $model->url.'/sitemap-condominios.xml';

$xml = simplexml_load_file($sitemap);

foreach ($xml as $row) {
    # code...
    $url = $row->loc;
    echo $url;
    echo '<br>';
    $arr_conds = explode('/',$row->loc);
    $slug = $arr_conds[4];
    echo $slug;
    $nome = str_replace('-',' ',$slug);
    $nome = ucwords($nome);
    echo '<br>';
    echo $nome;
    echo '<br>';

    $cond = new Condominio();
    $cond->nome = $nome;
    $cond->slug = $slug;
    $cond->url = (string)$url;
    $cond->id_imobiliarias = $model->id;
    
    $model->save(true);

    $haystack = $url;
    $needle   = $slug;

    $pos = strripos($haystack, $needle);

    if ($pos === false) {
        if ($cond->save()) {
            echo 'salvo';
        }
        else {
            var_dump($cond->errors);
            echo 'não salvo';
        }
    }else{
        echo 'condomínio já cadastrado!';
    }
    echo '<hr>';
    
}