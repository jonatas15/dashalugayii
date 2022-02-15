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
    $dados_anteriores .= 'Sexo: ' . ($model->genero == 'M' ? 'Masculino':'Feminino')."\n";
    $dados_anteriores .= 'Estado Civil: ' . $model->estado_civil."\n";
    $dados_anteriores .= 'Possui renda: ' . ($model->possui_renda == 1 ? 'Sim':'Não')."\n";
    $dados_anteriores .= 'Sexo: ' . ($model->genero == 'M' ? 'Masculino':'Feminino')."\n";
    $dados_anteriores .= 'Vai Morar? ' . ($model->vai_morar == 1 ? 'Sim':'Não')."\n";
        

?>
<div class="slo-proposta-form">
    <div class="">
        <h4 class="titulo">Informações Pessoais <sup><span class="badge badge-primary"> 4 </span></sup>
            <br><sub title="<?= $dados_anteriores ?>"> <strong>Pretendente:</strong> <?=$model->nome?></sub>
        </h4>
        <hr>
        <div class="progress">
          <div class="progress-bar bg-success" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <a class="btn btn-primary" href="<?= Yii::$app->homeUrl.'proposta/pretendente001?form=003&id='.$model->id.'&pretendente_id='.$pretendente_id.'&proposta_id='.$proposta_id ?>"><i class="fas fa-angle-double-left"></i> Voltar</a>
        <hr>
        <?php $form = ActiveForm::begin(); ?>

        <div class="col-md-12">
          <?= $form->field($model, 'nacionalidade')->dropDownList([ 'brasileiro' => 'Brasileiro', 'extrangeiro' => 'Extrangeiro', ], ['prompt' => '']) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'extrangeiro_temponopais')->textInput() ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'numero_dependentes')->textInput(['type' => 'number']) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'nome_pai')->textInput() ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'nome_mae')->textInput() ?>
        </div>

        <div class="col-md-12">
            <div class="form-group float-right">
                <?= Html::submitButton('CONTINUAR PARA DOCUMENTAÇÃO  <i class="fas fa-angle-double-right"></i>', ['class' => 'btn btn-primary', 'style'=>'font-weight: bolder']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
