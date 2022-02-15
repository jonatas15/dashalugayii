<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use abhimanyu\sms\components\Sms;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Entrar no Sistema:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Nome Login') ?>

    <?= $form->field($model, 'password')->passwordInput()->label('Senha') ?>

    <?= $form->field($model, 'rememberMe')->checkbox([
        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ])->label('Relembrar-me') ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11 float-right">
            <?= Html::submitButton('Entrar no Sistema', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="clearfix"></div>
    <div class="col-md-12">
        <div class="col-md-12">
          <label>Entrar com conta Google:</label>
        </div>
        <div class="col-md-4" style="text-align: center">

            <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark" style=""></div>
            <!-- <a href="#" id="logout-do-google" style="display: none" class="btn btn-warning" onclick="signOut();">Sign out</a> -->
            <div id="msg"></div>
        </div>
    </div>
    <script>
      function onSignIn(googleUser) {
        // Useful data for your client-side scripts:
        var profile   = googleUser.getBasicProfile();
        var userId    = profile.getName();
        var userName  = profile.getGivenName();
        var userImage = profile.getImageUrl();
        var userEmail = profile.getEmail();
        var userToken = googleUser.getAuthResponse().id_token;
        /*
        console.log("ID: " + profile.getId()); // Don't send this directly to your server!
        console.log('Full Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        console.log('Family Name: ' + profile.getFamilyName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());
        // The ID token you need to pass to your backend:
        var id_token = googleUser.getAuthResponse().id_token;
        console.log("ID Token: " + id_token);
        */

        if(userEmail !== '') {
            var dados = {
                userId: userId,
                userName: userName,
                userEmail: userEmail,
                userImage: userImage,
            };
            $.post('site/valida', dados, function(eee){

               if(eee == 0){
                 $("#msg").html('<hr><label><i>Não temos esse usuário no sistema, por favor, tente usar o formulário acima</i></label>')
               }
            });
        }
      }
      /**
      function signOut() {
          var auth2 = gapi.auth2.getAuthInstance();
          auth2.signOut().then(function () {
            console.log('User signed out.');
          });
      */
    </script>

    <?php
    // $smsss = new \SoapClient;
    // $sms = new Sms();
    // $sms->transportType    = 'php'; // php/smtp
    // $sms->transportOptions = [
    //   'host' => 'smtp.gmail.com',
    //   'username'   => 'jonatas.webdeveloper@gmail.com',
    //   'password'   => 'EnquantoHouverSol',
    //   'port'       => '587',
    //   'encryption' => 'tls'
    // ];
    // $carrier = "T-Mobile";
    // $number = "5599991609507";
    // $subject = "Assunto para enviar";
    // $message = "Envia isso pooo";
    // if($sms->send($carrier, $number, $subject, $message)){
    //   echo "<hr><br> enviou lazarento";
    // }else {
    //   echo "<hr><br> não enviou, lazarento";
    // }
    ?>

</div>
