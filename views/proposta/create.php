<?php
use yii\helpers\Html;
use app\models\SloProposta;
$this->title = "Cadastrar Proposta Express";
$this->params['breadcrumbs'][] = ['label' => 'Propostas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Nova Proposta';
?>
<h3><?= Html::encode($this->title) ?></h3>
<div class="clearfix"></div>
<hr>
<div class="col-md-12" style="text-align: center;">
<h4 style="text-align: left">Preencher com dados de Proposta Anterior:</h4>
    <?php 
      $propostas = SloProposta::find()->all();
      foreach ($propostas as $key => $val) {
        echo '<!-- Campo -->
        <a href="?codigo='.$val->id.'" style="'.
        'border-radius: 0px !important; border: 1px solid lightgray;'.
        ($_REQUEST['codigo'] == $val->id?'border: 1px solid;background-color: lightgray;font-weight:bolder;':'').
        '" class="btn btn-dafault col-md-2">'.
        '<h4>Proposta: PIN-'.$val->codigo_imovel.'</h4>'.
        '</a>';
      }
    ?>
</div>
<br />
<br />
<br>
<div class="clearfix"></div>
<hr>
<div class="slo-proposta-create col-md-12">
	<?= $this->render('_form', [
    'model' => $model,
  ]) ?>
</div>
