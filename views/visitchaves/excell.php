<?php
use app\models\NewTable as V;

function RemoveSpecialChar($str){
      
    // Using preg_replace() function 
    // to replace the word 
    $res = preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$str);
      
    // Returning the result 
    return $res;
}

function cadastra($arr) {
    $model = new V();
    $model->pessoa_responsavel = $arr['C'];
    $model->pessoa_agenciou = $arr['G'];
    $model->id_proprietarios = RemoveSpecialChar($arr['H']);
    $model->proprietarios = $arr['I'];
    $model->codigo = RemoveSpecialChar($arr['L']);
    if ($model->save()) {
        echo '<br> Registro feito: '.$arr['I'];
    } else {
        echo '<br> houve erro aqui: '.$arr['I'];
    }
}


if (file_exists(Yii::$app->basePath.'/web/planilias/'. 'backup.xlsx')) {
    echo 'existe! <hr>';
    $objPHPExcel = \PHPExcel_IOFactory::load(Yii::$app->basePath.'/web/planilias/'. 'backup.xlsx');
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
    // echo '<pre>';
    // print_r($sheetData);
    // echo '</pre>';
    echo '<table border="1">';
    $imprime_isso = '';
    $i = 1;
    foreach ($sheetData as $key => $value) {
        // if ( $i <= 20) {
            if ($key != '1') {
                // $imprime_isso .= '<tr>';
                // $imprime_isso .= '<td>';
                // $imprime_isso .= RemoveSpecialChar($value['C']);
                // $imprime_isso .= '</td>';
                // $imprime_isso .= '<td>';
                // $imprime_isso .= RemoveSpecialChar($value['G']);
                // $imprime_isso .= '</td>';
                // $imprime_isso .= '<td>';
                // $imprime_isso .= RemoveSpecialChar($value['H']);
                // $imprime_isso .= '</td>';
                // $imprime_isso .= '<td>';
                // $imprime_isso .= RemoveSpecialChar($value['I']);
                // $imprime_isso .= '</td>';
                // $imprime_isso .= '<td>';
                // $imprime_isso .= RemoveSpecialChar($value['L']);
                // $imprime_isso .= '</td>';
                // $imprime_isso .= '</tr>';
                // EXECUTA O REGISTRO TODO:
                cadastra($value);
            } else {
                // echo '<tr>';
                // echo '<td>';
                // echo $value['C'];
                // echo '</td>';
                // echo '<td>';
                // echo $value['G'];
                // echo '</td>';
                // echo '<td>';
                // echo $value['H'];
                // echo '</td>';
                // echo '<td>';
                // echo $value['I'];
                // echo '</td>';
                // echo '<td>';
                // echo $value['L'];
                // echo '</td>';
                // echo '</tr>';
            }
        // } else {
        //     break;
        // }
        // $i++;
    }
    echo $imprime_isso;
    echo '</table>';
} else {
    echo 'nao existe';
}