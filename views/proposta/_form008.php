<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\widgets\FileInput;
// use kartik\widgets\DatePicker;
// use kartik\widgets\SwitchInput;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\SloProposta */
/* @var $form yii\widgets\ActiveForm */
?>
<style media="screen">
  input{
    height: 36px !important;
  }
</style>
<?php

    $dats = str_split($model2->cpf,3);
    $dados_anteriores .= 'Cpf: '.$dats[0].'.'.$dats[1].'.'.$dats[2].'-'.$dats[3]."\n";
    $dados_anteriores .= 'Data de Nacimento: ' . date('d/m/Y', strtotime($model2->data_nascimento))."\n";
    $dados_anteriores .= 'Email: ' . $model2->email."\n";

    $dados_anteriores_empresariais .= 'Telefone: ' . $this->context->format_telefone($model->fone)."\n";
    $dados_anteriores_empresariais .= 'Data de Admissão: ' . date('d/m/Y', strtotime($model->data_admissao))."\n";
    $dados_anteriores_empresariais .= 'Vínculo Empregatício: ' . $model->vinculo_empregaticio ."\n";

?>
<div class="slo-proposta-form">
    <div class="">

        <h4 class="titulo">Informações Profissionais <sup><span class="badge badge-primary"> 8 </span></sup>
            <br><sub title="<?=$dados_anteriores?>"> <strong>Pretendente:</strong> <?=$model2->nome?></sub>
            <br class="aparece-mobile"><sub title="<?=$dados_anteriores_empresariais?>"> <strong>Empresa:</strong> <?=$model->empresa?></sub>
        </h4>
        <hr>
        <div class="progress">
          <div class="progress-bar bg-success" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <a class="btn btn-primary" href="<?= Yii::$app->homeUrl.'proposta/pretendente001?form=007&id='.$model2->id .'&iddoc='.$model->id.'&pretendente_id='.$pretendente_id.'&proposta_id='.$proposta_id ?>"><i class="fas fa-angle-double-left"></i>  Voltar</a>
        <hr>
        
        <?php $form = ActiveForm::begin(); ?>

        <div class="col-md-12">
            <?= $form->field($model, 'profissao')->textInput(); ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'salario',['addon' => ['prepend' => ['content'=>'R$']]])->widget(MaskedInput::className(), [
              'clientOptions' => [
                  'alias' =>  'decimal',
                  'groupSeparator' => '.',
                  'radixPoint' => ',',
                  'autoGroup' => true,
                  'text-align'=>'left'
              ],
              // 'options' => ['style' => 'text-align:left']
            ]) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'outros_rendimentos')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'total_rendimentos')->textInput(['maxlength' => true]) ?>
        </div>
        <img src="" alt="">

        <?php /*
        <?= $form->field($model, 'profissao')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'salario')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'outros_rendimentos')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'total_rendimentos')->textInput(['maxlength' => true]) ?>
        */ ?>

        <div class="col-md-12">
            <div class="form-group float-left">
                <?= Html::submitButton('CONTINUAR  <i class="fas fa-angle-double-right"></i>', ['class' => 'btn btn-primary', 'style'=>'font-weight: bolder']) ?>
            </div>
        </div>


        <?php ActiveForm::end(); ?>
        <?php

          $this->registerJs("$('#sloinfosprofissionais-salario').css('text-align','left')");

        ?>
    </div>
</div>
