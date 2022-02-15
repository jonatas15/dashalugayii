<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Visita */

$this->title = 'Nova Visita';
$this->params['breadcrumbs'][] = ['label' => 'Visitas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visita-create">

    <h3><img src="<?=Yii::$app->homeUrl.'icones/visita.png'?>" alt="" height="50" /><?= Html::encode($this->title) ?></h3>
    <hr>
	<?php
		// $contrato = 'Venda';
		if($_REQUEST['1']['contrato']){
			$contrato = $_REQUEST['1']['contrato'];
		}
    ?>
    <?= $this->render('_form', [
        'model' => $model,
        'contrato' => $contrato,
    ]) ?>

</div>
