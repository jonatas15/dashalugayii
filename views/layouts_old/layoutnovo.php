<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Ionicons -->
    <link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <!-- Theme style -->
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<style>
  :root {
    /*
    --cor-bg-fundo: #cceeff;
    --cor-bg-elementos: #66ccff;
    */
    --cor-bg-fundo: #66ccff;
    /*lightgray;*/
    --cor-bg-elementos: #084d6e;
    /*gray;*/
    --fundo-com-transparencia: rgba(0, 0, 0, 0.1);
  }
  .titulofixo{
      background-color: white;
      position: fixed;
      top: 0;
      margin-top: 0;
      z-index: 10;
      line-height: 55px;
      width: 100%;
      text-align: center;
      color: var(--cor-bg-elementos);
      font-weight: bolder;
      text-transform: uppercase;
      font-size: 18px;
  }
  .float-right{
      float: right !important;
  }
  .float-left{
      float: left !important;
  }
  .titulofixo img{
      margin-top: 15px;
      position: absolute;
      left: 10px;
  }
  .form-control{
      color: var(--cor-bg-elementos) !important;
      border-color: var(--cor-bg-elementos) !important;
      border: 1px solid;
      border-top: 0px !important;
      border-right: 0px;
      /* height: 40px; */
      border-radius: 0px !important;
      box-shadow: none !important;
      text-transform: uppercase !important;
  }
  .control-label{
      color: var(--cor-bg-elementos) !important;
      font-weight: normal !important;
  }
  .btn-primary {
      background-color: var(--cor-bg-elementos);
      border-color: var(--cor-bg-elementos);
  }
  .btn-primary:active {
      background-color: orange;
      border-color: var(--cor-bg-elementos);
  }
  .has-success .input-group-addon {
      color: var(--cor-bg-elementos) !important;
      background-color: var(--cor-bg-fundo);
      border-color: var(--cor-bg-elementos) !important;
  }
  .has-error .form-control {
      border-color: var(--cor-bg-elementos) !important;
      -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
      box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
      border: 1px solid;
      border-top: 0px;
      border-right: 0px;
  }
  input::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
    color: red;
  }
  .titulo{
      text-transform: uppercase;
      color: var(--cor-bg-elementos);
  }
  .titulo sub{
    text-transform: capitalize !important;
    font-style: italic;
  }
  .titulo sup{
    text-transform: capitalize !important;
    font-style: italic;
  }
  .input-group-addon {
      border: 1px solid var(--cor-bg-elementos);;
      color: var(--cor-bg-elementos);
  }
  .aparece-mobile{
     display: none;
  }
  @media (max-width: 700px) {
    .aparece-mobile{
       display: block;
    }
    .desaparece-mobile{
      display: none;
    }
    .logo_banner{
      width: 30px !important;
    }
  }
  @media (max-width: 992px) {
    .desaparece-mobile{
      display: none;
    }
    .logo_banner{
      width: 50px !important;
    }
  }
  @media (min-width: 992px) {
    .menu-desktop{
      display: block;
      position: fixed;
      width: 290px;
    }
    .logo_banner{
      width: 60px !important;
    }
  }
  .badge-primary{
    background-color: var(--cor-bg-elementos) !important;
    float: right;
  }
  .bg-success{
    background-color: var(--cor-bg-elementos) !important;
  }
  .vertical{
    margin-top:50%;
  }
  .navbar .container {
    width: 100%;
  }
  .navbar-default {
    background-color: var(--fundo-com-transparencia);
    border-color: var(--cor-bg-elementos);
    border: none;
    padding: 0 !important;
  }
  .nav-pills > li > a {
    color: var(--cor-bg-elementos);
  }
  .nav-pills > li.active > a, .nav-pills > li.active > a:hover, .nav-pills > li.active > a:focus {
    font-weight: bolder;
    background: none;
    color: var(--cor-bg-elementos);
  }
  .nav > li > a {
    padding: 10px 5px;
  }
  .help-block {
    color: var(--cor-bg-elementos) !important;
  }
  .fa-check-square {
    color: var(--cor-bg-fundo) !important;
    float: right !important;
    font-size: 20px;
  }
  .btn-destaque {
    /*color:  var(--cor-bg-fundo) !important;*/
    font-size: 17px;
    margin-top: 20px !important;
  }
  .btn-warning {
    color: #fff;
    background-color: var(--cor-bg-fundo) !important;
    border-color: var(--cor-bg-fundo) !important;
  }
  .btn-imagem-info{
    color: var(--cor-bg-elementos) !important;
    background-color: #fff !important;
    border-color: var(--cor-bg-elementos) !important;
  }
  .div-ocupantes{
    /*background-color: var(--fundo-com-transparencia) !important;
    border-radius: 4px;*/
  }
  .bootstrap-switch .bootstrap-switch-handle-off.bootstrap-switch-warning {
    background: var(--cor-bg-fundo) !important;
  }
  .bootstrap-switch .bootstrap-switch-handle-on.bootstrap-switch-success {
    background: var(--cor-bg-elementos) !important;
  }
</style>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <div class="">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
