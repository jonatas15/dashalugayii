<!DOCTYPE html>
<?php
	use yii\helpers\Html;
	$this->title = "Cadastrar Proposta Express"
?>
<html>
<head>
	<title><?= Html::encode($this->title) ?></title>
	<head>
    <meta charset="UTF-8">
    <meta name="csrf-param" content="_csrf">
    <meta name="csrf-token" content="lS2faUh7cRRV_2vA9tMLanQkmsHu2m8oWPHSdYpxBMsfkhLbepa-f7EN2vMxoGgt__AkiG8vPfeG-NddVRbbOg==">
    <title>Nova Permuta</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Ionicons -->
    <link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <!-- Theme style -->
    <link href="/areacliente/web/assets/f9501ef4/css/bootstrap.css" rel="stylesheet">
	<link href="/areacliente/web/assets/d153fcfe/css/activeform.css" rel="stylesheet">
	<link href="/areacliente/web/assets/a0c7c868/css/select2.css" rel="stylesheet">
	<link href="/areacliente/web/assets/a0c7c868/css/select2-addl.css" rel="stylesheet">
	<link href="/areacliente/web/assets/a0c7c868/css/select2-krajee.css" rel="stylesheet">
	<link href="/areacliente/web/assets/316bde71/css/kv-widgets.css" rel="stylesheet">
	<link href="/areacliente/web/assets/bbe4412d/css/bootstrap-switch.css" rel="stylesheet">
	<link href="/areacliente/web/assets/bbe4412d/css/bootstrap-switch-kv.css" rel="stylesheet">
	<link href="/areacliente/web/assets/80369e2d/css/font-awesome.min.css" rel="stylesheet">
	<link href="/areacliente/web/assets/d15901d8/css/AdminLTE.min.css" rel="stylesheet">
	<link href="/areacliente/web/assets/d15901d8/css/skins/_all-skins.min.css" rel="stylesheet">
	<script type="text/javascript">var s2options_d6851687 = {"themeCss":".select2-container--krajee","sizeCss":"","doReset":true,"doToggle":false,"doOrder":false};
	window.select2_ea784dd6 = {"tags":true,"maximumInputLength":10,"theme":"krajee","width":"100%","placeholder":"Selecione o Código do imóvel","language":"pt"};

	var s2options_c4acac00 = {"themeCss":".select2-container--krajee","sizeCss":"","doReset":true,"doToggle":true,"doOrder":false};
	window.select2_3274357f = {"allowClear":true,"theme":"krajee","width":"100%","placeholder":"Selecione o Tipo","language":"pt"};

	window.bootstrapSwitch_623784a5 = {"onText":"Sim","offText":"Não","animate":true,"indeterminate":false,"disabled":false,"readonly":false};

	window.select2_a766e465 = {"allowClear":true,"theme":"krajee","width":"100%","placeholder":"Selecione os Bairros","language":"pt"};

	window.numberControl_525e4307 = {"displayId":"imovelpermuta-valor_maximo-disp","maskedInputOptions":{"alias":"numeric","digits":2,"groupSeparator":".","autoGroup":true,"autoUnmask":true,"unmaskAsNumber":true,"radixPoint":",","allowMinus":false}};

	window.numberControl_55c7b9e6 = {"displayId":"imovelpermuta-valor_minimo-disp","maskedInputOptions":{"alias":"numeric","digits":2,"groupSeparator":".","autoGroup":true,"autoUnmask":true,"unmaskAsNumber":true,"radixPoint":",","allowMinus":false}};
	</script>
	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	    <![endif]-->
</head>
<body>
	<h3 style="	
			background-color: #f1c318;
			position: fixed;
			top: 0;
			margin-top: 0;
			z-index: 10000;
			line-height: 55px;
			width: 100%;
			text-align: center;
			color: white;
			font-weight: bolder"><?= Html::encode($this->title) ?></h3>
	
	<div class="slo-proposta-create col-md-12">
		
	    
	    <?= $this->render('_form', [
	        'model' => $model,
	    ]) ?>

	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>