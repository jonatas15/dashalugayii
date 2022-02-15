<?php
use dmstr\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */
$this->title = $this->title;
dmstr\web\AdminLteAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Ionicons -->
    <link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <!-- Theme style -->
    <?php $this->head() ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="846905942616-8opej9vrudnlj4osjr3ddsvlcanv1hch.apps.googleusercontent.com">
    <!-- JFKXBhnirYgf_RjVZtM0Flhq -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
</head>

<body class="hold-transition skin-black sidebar-mini" style="overflow:hidden">
  <style media="screen">
    .skin-black .main-header>.navbar {
      background-color: #222d32 !important;
      color: #fff !important;
    }
    .skin-black .main-header>.navbar .nav>li>a {
      color: ghostwhite;

    }
    .skin-black .main-header>.logo {
      background-color: #222d32 !important;
          border-right: none !important;
    }
    .skin-black .main-header>.navbar>.sidebar-toggle {
      color: ghostwhite;
    }
    li .active span{
      z-index: 1
    }
    .pull-right-container{
      display: none !important;
      opacity: 0.5;
    }
    .breadcrumb {
      background-color: transparent;
      padding: 0;
      padding-top: 15px;
      line-height: 20px;
      padding-left: 15px;
      padding-right: 15px;
    }
    @media (max-width: 480px) {
      #breadss{
        display: none;
      }
      .nao-no-mobile{
        display: none !important;
      }
    }
    /*Estilo par aos Tópicos em Ávore*/

    body {
      font-family: sans-serif;
      font-size: 15px;
    }

    .tree {
      /*-webkit-transform: rotate(180deg);
              transform: rotate(180deg);*/
      -webkit-transform-origin: 50%;
              transform-origin: 50%;
    }

    .tree ul {
      position: relative;
      padding: 1em 0;
      white-space: nowrap;
      margin: 0 auto;
      text-align: center;
    }
    .tree ul::after {
      content: '';
      display: table;
      clear: both;
    }

    .tree li {
      display: inline-block;
      vertical-align: top;
      text-align: center;
      list-style-type: none;
      position: relative;
      padding: 1em .5em 0 .5em;
    }
    .tree li::before, .tree li::after {
      content: '';
      position: absolute;
      top: 0;
      right: 50%;
      border-top: 1px solid #ccc;
      width: 50%;
      height: 1em;
    }
    .tree li::after {
      right: auto;
      left: 50%;
      border-left: 1px solid #ccc;
    }
    .tree li:only-child::after, .tree li:only-child::before {
      display: none;
    }
    .tree li:only-child {
      padding-top: 0;
    }
    .tree li:first-child::before, .tree li:last-child::after {
      border: 0 none;
    }
    .tree li:last-child::before {
      border-right: 1px solid #ccc;
      border-radius: 0 5px 0 0;
    }
    .tree li:first-child::after {
      border-radius: 5px 0 0 0;
    }

    .tree ul ul::before {
      content: '';
      position: absolute;
      top: 0;
      left: 50%;
      border-left: 1px solid #ccc;
      width: 0;
      height: 1em;
    }

    .tree li a {
      border: 1px solid #ccc;
      padding: .5em .75em;
      text-decoration: none;
      display: inline-block;
      border-radius: 5px;
      color: #333;
      position: relative;
      top: 1px;
      /*-webkit-transform: rotate(180deg);
              transform: rotate(180deg);*/
    }

    .tree li a:hover,
    .tree li a:hover + ul li a {
      background: lightgray;
      color: black;
      /*font-weight: bolder;*/
      /*font-style: italic;*/
      border: 1px solid lightgray;
    }

    .tree li a:hover + ul li::after,
    .tree li a:hover + ul li::before,
    .tree li a:hover + ul::before,
    .tree li a:hover + ul ul::before {
      border-color: lightgray;
    }
    /*Div para cartão cyber*/
    /*.cyber-sombra-caixa {
      -webkit-border-radius: 0% 0% 100% 100% / 0% 0% 8px 8px;
      -webkit-box-shadow: rgba(0, 0, 0,.30) 0 2px 3px;
        width:100%;
    }*/
    .cyber-conteudo {
      margin: 0 auto;
      /*margin-top: 50px;;*/

      height: 250px;
      background: #F2F2F2;
      border: 1px solid lightgray;
      box-shadow: 1px 1px 2px #fff inset,
                  -1px -1px 2px #fff inset;
      border-radius: 3px/6px;

      /*padding: 10px;*/

    }

    .cyber-rodape {

      height: 40px;
      background: #F2F2F2;

      border-radius: 3px/6px 0;
      border-bottom: 1px solid lightgray;

      padding: 10px;

      width: 100%;

    }

    .cyber-conteudo:hover{
      border: 1px solid gray;
    }

    .cyber-conteudo .titulo{
      text-align: center
    }
    /*.treeview:hover{
      width: 250px;
    }
    .treeview li:hover{
      width: 300px;
    }*/
    @media (min-width: 768px){
      .sidebar-mini.sidebar-collapse .sidebar-menu>li:hover>a>span:not(.pull-right), .sidebar-mini.sidebar-collapse .sidebar-menu>li:hover>.treeview-menu {
        width: 250px;
      }
      .no-mobile{
        display: none !important;
      }
    }

    .cyber-conteudo .titulo {
        text-align: left !important;
    }

    /* Icones Alertas */
    .dashbord{display: inline-block;color:#fff;margin-top: 50px;text-align: center;}
    .dashbord .icon-section i{
        font-size: 30px;
        padding:10px;
        border:2px solid #fff;
        border-radius:50%;
        margin-top:-25px;
        margin-bottom: 10px;
        background-color:#34495E;
    }
    .dashbord .imagem-icone {
        font-size: 30px;
        /* padding:10px; */
        /* border:5px solid cadetblue; */
        border-radius:50%;
        margin-top:-10px;
        margin-bottom: 10px;
        background-color: cadetblue;
        width: 60px !important;
        height: 60px !important;
        /* background-color: lightgray;  */
        color: #000 !important; 
        margin-right: -10px;
    }
    .dashbord .imagem-icone-imovel {
        font-size: 30px;
        /* padding:10px; */
        /* border:1px solid cadetblue; */
        border-radius:50%;
        margin-top:-10px;
        margin-bottom: 10px;
        width: 100px !important;
        height: 100px !important;
        background-color: cadetblue; 
        color: #000 !important; 
        margin-left: -13px;
    }
    .icon-section p{margin:0px;font-size: 20px;padding-bottom: 10px;}
    .detail-section{background-color: #2F4254;padding: 5px 0px;}
    .dashbord .detail-section:hover{background-color: #5a5a5a;cursor: pointer;}
    .detail-section a{color:#fff;text-decoration: none;}
    .dashbord-green .icon-section,.dashbord-green .icon-section i{background-color: #16A085;}
    .dashbord-green .detail-section{background-color: #149077;}
    .dashbord-orange .icon-section,.dashbord-orange .icon-section i{background-color: #F39C12;}
    .dashbord-orange .detail-section{background-color: #DA8C10;}
    .dashbord-blue .icon-section,.dashbord-blue .icon-section i{background-color: #2980B9;}
    .dashbord-blue .detail-section{background-color:#2573A6;}
    .dashbord-lightblue .icon-section,.dashbord-lightblue .icon-section i{
      background-color: lightblue;
      border-radius: 10px;
      color: darkblue;
      box-shadow: 0 4px 4px 0 lightgrey; 
    }
    .dashbord-lightblue .detail-section{background-color:#2980B9;padding:15px}
    .dashbord-red .icon-section,.dashbord-red .icon-section i {
      background-color: bisque;
      border-radius: 10px;
      color: darkred;
      box-shadow: 0 4px 4px 0 lightgrey;
    }
    .dashbord-skyblue .detail-section{background-color:#803D9B;}
    .dashbord-skyblue .icon-section,.dashbord-skyblue .icon-section i{background-color:#8E44AD;}
    .dashbord-gray .detail-section{background-color:lightgray;color:black}
    .dashbord-gray .icon-section,.dashbord-skyblue .icon-section i{background-color:lightgray;color:black}
    .dashbord-white .detail-section{background-color:white;}
    .dashbord-white .icon-section,.dashbord-white .icon-section i{background-color:#fff;}
    #saalerta-alertaopovo .btn {
        width: 130px !important;
        border-radius: 0px !important;
    }
    .float-right{float: right}
    .float-left{float: left}

  </style>
  <?php $this->beginBody() ?>

  <div class="wrapper">

      <header class="main-header">
          <!-- Logo -->
          <a href="<?= \Yii::$app->homeUrl ?>" class="logo">
            <img src="<?= \Yii::$app->homeUrl ?>icones/logo_site.png" alt="" width="30" style="margin-left:-5px">
          </a>
          <!-- Header Navbar: style can be found in header.less -->
          <nav class="navbar navbar-static-top" role="navigation">
              <!-- Sidebar toggle button-->
              <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                  <span class="sr-only">Toggle navigation</span>
              </a>

              <div class="navbar-custom-menu">
                  <ul class="nav navbar-nav">
                      <?php if (!\Yii::$app->user->isGuest): ?>
                          <!-- Messages: style can be found in dropdown.less-->
                          <li id="breadss">
                            <?= Breadcrumbs::widget([
                              'itemTemplate' => "<li><i>{link}</i></li>\n",
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            ]); ?>
                          </li>
                          <li class="dropdown tasks-menu">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                  <i class="fa fa-flag"></i>
                                  Formulários
                                  <span class="label label-default"></span>
                              </a>
                              <ul class="dropdown-menu">
                                  <li class="header"></li>
                                  <li> <a target="blanck" style="" href="http://cadastros.cafeimobiliaria.com.br/notificacao-de-agenciamento">
                                    Form. Agenciamento
                                  </a></li>
                                  <li class="header">Vendas</li>
                                  <li> <a target="blanck" style="" href="http://cadastros.cafeimobiliaria.com.br/formulariocomprador">
                                    Form. Comprador
                                  </a></li>
                                  <li> <a target="blanck" style="" href="http://cadastros.cafeimobiliaria.com.br/formulariovendedor">
                                    Form. Vendedor
                                  </a></li>
                                  <li class="header">Locações</li>
                                  <li> <a target="blanck" style="" href="http://cadastros.cafeinteligencia.com.br/formulariolocador">
                                    Form. Locador
                                  </a></li>
                                  <li> <a target="blanck" style="" href="http://cadastros.cafeinteligencia.com.br/formulariolocatario">
                                    Form. Locatário
                                  </a></li>
                                  <li class="header">Solicitações</li>
                                  <li class="">
                                    <a href="https://app.pipefy.com/public/form/udhcltYc" target="_blank" title="Solicitação de Contratos">
                                      Solicitação de Contratos
                                    </a>
                                  </li>
                                  <!-- <li class="">
                                    <a href="https://app.pipefy.com/public/form/udhcltYc" target="_blank" title="Solicitação de Contratos para o Jurídico">
                                      Solicitação de Contratos p/ Jurídico
                                    </a>
                                  </li> -->
                                  <!-- <li> -->
                                      <!-- inner menu: contains the actual data -->
                                      <!-- <ul class="menu"> -->
                                      <!-- </ul> -->
                                  <!-- </li> -->
                              </ul>
                          </li>
                          <!-- <li class="dropdown tasks-menu">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                  <i class="fa fa-dollar"></i>
                                  Contratos
                                  <span class="label label-default"></span>
                              </a>
                              <ul class="dropdown-menu">
                                <li class="">
                                  <a href="https://app.pipefy.com/public/form/udhcltYc" target="_blank" title="Solicitação de Contratos">
                                    Solicitação de Contratos
                                  </a>
                                </li>
                                <li class="">
                                  <a href="https://app.pipefy.com/public/form/udhcltYc" target="_blank" title="Solicitação de Contratos para o Jurídico">
                                    Solicitação de Contratos p/ Jurídico
                                  </a>
                                </li>
                              </ul>
                          </li> -->
                          
                          <li class="dropdown messages-menu">
                            <?php
                              $historico = app\models\Historico::find()->where([
                                'atividade' => 'Atualização do Cliente'
                              ])->orderBy(['data'=>SORT_DESC])->all();

                              $javisto = app\models\Userhistvisto::find()->where([
                                'usuario_id' => Yii::$app->user->identity->id,
                              ])->all();
                              $idsvistos = [];
                              foreach($javisto as $r) {
                                array_push($idsvistos, $r->historico_id);
                              }
                            ?>
                            <?php 
                            $count = 0;
                            $echo_avisos = '';
                              foreach ($historico as $key => $row):
                                if(!in_array($row->id, $idsvistos)):
                                  $echo_avisos .= '<li>
                                    <a href="#">
                                      <i class="ion ion-ios7-clock info"></i> '.
                                      "<strong class='title'>{$row->atividade}: <br>{$row->proponente->sloInfospessoais->nome}</strong>
                                      <p class='description''>
                                        {$row->descricao}
                                      </p>"
                                      .'
                                    </a>
                                  </li>';
                                  $count++;
                                endif;
                              endforeach;
                            ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="label label-success"><?= $count ?></span>
                            </a>
                            <ul class="dropdown-menu">
                              <li class="header">Você tem <?= $count ?> notificações(s)</li>
                              <li>
                                  <ul class="menu">
                                      <?= $echo_avisos; ?>
                                  </ul>
                              </li>
                            </ul>
                          </li>

                          <!-- User Account: style can be found in dropdown.less -->
                          <li class="dropdown user user-menu">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                  <i class="glyphicon glyphicon-user"></i>
                                  <span><?= \Yii::$app->user->identity->username ?> <i class="caret"></i></span>
                              </a>
                              <ul class="dropdown-menu">
                                  <!-- User image -->
                                  <li class="user-header bg-light-blue">
                                      <?php
                                        echo \cebe\gravatar\Gravatar::widget(
                                          [
                                              'email'   => \Yii::$app->user->identity->email,
                                              'options' => [
                                                  'alt' => \Yii::$app->user->identity->username
                                              ],
                                              'size'    => 128
                                          ]
                                        );
                                      ?>
                                      <p>
                                          <?= \Yii::$app->user->identity->username ?>
                                          <small><?= \Yii::$app->user->identity->email ?></small>
                                      </p>
                                  </li>
                                  <!-- Menu Footer-->
                                  <li class="user-footer">
                                      <div class="pull-left">
                                          <a href="<?= Yii::$app->homeUrl.'usuario/view?id='.Yii::$app->user->identity->id ?>"
                                            class="btn btn-default btn-flat">Profile</a>
                                      </div>
                                      <div class="pull-right">
                                            <?php
                                            echo Html::beginForm(['/site/logout'], 'post')
                                            . Html::submitButton(
                                                'Logout (' . Yii::$app->user->identity->nome . ')',
                                                ['class' => 'btn btn-primary logout']
                                            )
                                            . Html::endForm()
                                            ?>
                                      </div>
                                      <?php if (Yii::$app->user->can('administrador')): ?>
                                      <br />
                                      <br />
                                      <hr style="border: 1px solid lightgray">
                                      <div class="pull-center" style="text-align: center">
                                          <a href="<?= Yii::$app->homeUrl.'usuario' ?>" class="btn btn-success btn-flat">
                                              <i class="fa fa-cog"></i> Gerir Usuários
                                          </a>
                                      </div>
                                      <?php endif; ?>
                                  </li>
                              </ul>
                          </li>
                      <?php endif; ?>
                  </ul>
              </div>
          </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
          <!-- sidebar: style can be found in sidebar.less -->
          <section class="sidebar">
              <?= $this->render('_sidebar') ?>
          </section>
          <!-- /.sidebar -->
      </aside>

      <!-- Right side column. Contains the navbar and content of the page -->
      <div class="content-wrapper" style="background: white; height: 100vh;">
          <!-- Content Header (Page header) -->
          <?php /*
          <section class="content-header">
              <h1>
                  <small><?= $this->title ?></small>
              </h1>
              <ol class="breadcrumb" style="">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],

                ]); ?>
              </ol>
          </section>
          */ ?>

          <!-- Main content -->

          <section class="content" style="overflow-y:scroll; height: 86vh;width: 100%;">
              <?= Alert::widget() ?>
              <?= $content ?>
          </section>
          <footer class="main-footer" style="height: 14vh;width: 100%;margin-left:0px !important;">
              Powered by <strong><a href="https://cafeinteligencia.com.br" target="_blank">Jonatas A.Silva - Café Inteligência Imobiliária</a></strong>
          </footer>
          <!-- /.content -->
      </div>
      
      <!-- /.content-wrapper -->
      <?php /*
      <footer class="main-footer">
          Powered by <strong><a href="http://phundament.com">Phundament 4</a></strong>
      </footer>
      */ ?>
  </div>
  <!-- ./wrapper -->

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
