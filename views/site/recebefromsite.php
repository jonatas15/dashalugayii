<?php
header('Content-Type: text/html; charset=utf-8');// para formatar corretamente os acentos
// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json);
echo "<pre>";
print_r($_POST);
echo "</pre>";
echo "<pre>";
print_r($data);
echo "</pre>";