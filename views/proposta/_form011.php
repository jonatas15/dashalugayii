<?php

use yii\helpers\Html;
use yii\widgets\MaskedInput;
use kartik\form\ActiveForm;
// use kartik\widgets\DatePicker;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\SloProposta */
/* @var $form yii\widgets\ActiveForm */
?>
<?php

    $dats = str_split($model2->cpf,3);
    $dados_anteriores .= 'Cpf: '.$dats[0].'.'.$dats[1].'.'.$dats[2].'-'.$dats[3]."\n";
    $dados_anteriores .= 'Data de Nacimento: ' . date('d/m/Y', strtotime($model2->data_nascimento))."\n";
    $dados_anteriores .= 'Email: ' . $model2->email."\n";

    $dats = str_split($model->cpf,3);
    $dados_conjuje .= 'Cpf: '.$dats[0].'.'.$dats[1].'.'.$dats[2].'-'.$dats[3]."\n";
    $dados_conjuje .= 'Data de Nacimento: ' . date('d/m/Y', strtotime($model->data_nascimento))."\n";
    $dados_conjuje .= 'Email: ' . $model->email."\n";

?>
<div class="slo-proposta-form">
    <h4 class="titulo">Cônjuge: mais Informações <sup><span class="badge badge-primary"> 11 </span></sup>
        <br><sub title="<?=$dados_anteriores?>"> <strong>Pretendente:</strong> <?=$model2->nome?></sub>
        <br class="aparece-mobile"><sub title="<?=$dados_conjuje?>"> <strong>Cônjuje:</strong> <?=$model->nome?></sub>
    </h4>
    <hr>
    <div class="progress">
      <div class="progress-bar bg-success" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <a class="btn btn-primary" href="<?= Yii::$app->homeUrl.'proposta/pretendente001?form=010&id='.$model2->id .'&iddoc=' .$model->id .'&pretendente_id='.$pretendente_id.'&proposta_id='.$proposta_id ?>"><i class="fas fa-angle-double-left"></i> Voltar</a>
    <hr>
    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-6">
      <?= $form->field($model, 'genero')->dropDownList([ 'M' => 'Masculino', 'F' => 'Feminino', ], ['prompt' => '']) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'estado_civil')->dropDownList([ 'solteiro' => 'Solteiro', 'casado' => 'Casado', 'desquitado' => 'Desquitado', 'divorciado' => 'Divorciado', 'separado' => 'Separado', 'amasiado' => 'Amasiado', 'viúvo' => 'Viúvo', ], ['prompt' => '']) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'possui_renda')->widget(SwitchInput::classname(), [
              'pluginOptions' => [
                'onText' => 'SIM',
                'offText' => 'Não',
                'onColor' => 'success',
                'offColor' => 'warning',
              ],
            ]); ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'vai_morar')->widget(SwitchInput::classname(), [
              'pluginOptions' => [
                'onText' => 'SIM',
                'offText' => 'Não',
                'onColor' => 'success',
                'offColor' => 'warning',
              ],
            ]); ?>
    </div>
    <div class="col-md-12">
        <div class="form-group float-right">
            <?= Html::submitButton('CONTINUAR  <i class="fas fa-angle-double-right"></i>', ['class' => 'btn btn-primary', 'style'=>'font-weight: bolder']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
