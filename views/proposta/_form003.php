<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\SloProposta */
/* @var $form yii\widgets\ActiveForm */
?>
<?php

    $dats = str_split($model->cpf,3);
    $dados_anteriores .= 'Cpf: '.$dats[0].'.'.$dats[1].'.'.$dats[2].'-'.$dats[3]."\n";
    $dados_anteriores .= 'Data de Nacimento: ' . date('d/m/Y', strtotime($model->data_nascimento))."\n";
    $dados_anteriores .= 'Emancipado: ' . ($model->emancipado == 1 ? 'Sim' : 'Não')."\n";
    $dados_anteriores .= 'Email: ' . $model->email."\n";
    $dados_anteriores .= 'Telefone Residencial: ' . $this->context->format_telefone($model->fone_residencial)."\n";
    $dados_anteriores .= 'Celular: ' . $this->context->format_telefone($model->celular)."\n";

?>
<div class="slo-proposta-form">
    <div class="">
        <a class="btn btn-primary btn-destaque" href="<?= Yii::$app->homeUrl.'proposta/pretendente001?form=001&id='.$model->id.'&pretendente_id='.$pretendente_id.'&proposta_id='.$proposta_id ?>"><i class="fas fa-angle-double-left"></i> Voltar</a>
        <h4 class="titulo">1 - Informações Pessoais <sup><span class="badge badge-primary"> 2/2 </span></sup>
            <br><sub title="<?= $dados_anteriores ?>"> <strong>Pretendente:</strong> <?=$model->nome?></sub>
        </h4>
        <hr>
        <?php $form = ActiveForm::begin(); ?>

        <div class="col-md-6">
          <?= $form->field($model, 'nacionalidade')->dropDownList([ 'brasileiro' => 'Brasileiro', 'extrangeiro' => 'Extrangeiro', ], [
            'prompt' => '',
            'onChange' =>'if($(this).val() == "extrangeiro"){
                $("#extrangeiro_div").show();
            }else{
                 $("#extrangeiro_div").hide();
            }'
        ]) ?>
        </div>
        <div class="col-md-6" >
            <?= $form->field($model, 'numero_dependentes')->textInput(['type' => 'number']) ?>
        </div>
        <div class="col-md-12" style="display: none" id="extrangeiro_div">
            <?= $form->field($model, 'extrangeiro_temponopais')->textInput() ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'nome_pai')->textInput() ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'nome_mae')->textInput() ?>
        </div>

        <div class="col-md-6" style="display: none">
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
                <?= Html::submitButton('CONTINUAR  <i class="fas fa-angle-double-right"></i>', ['class' => 'btn btn-primary btn-destaque', 'style'=>'font-weight: bolder']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
