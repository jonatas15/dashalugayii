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

    $dats = str_split($conjuge->cpf,3);
    $dados_conjuje .= 'Cpf: '.$dats[0].'.'.$dats[1].'.'.$dats[2].'-'.$dats[3]."\n";
    $dados_conjuje .= 'Data de Nacimento: ' . date('d/m/Y', strtotime($conjuge->data_nascimento))."\n";
    $dados_conjuje .= 'Email: ' . $conjuge->email."\n";

    $dados_profissionais .= 'Telefone: '.$this->context->format_telefone($model->fone)."\n";
    $dados_profissionais .= 'Data de Admissão: ' . date('d/m/Y', strtotime($model->data_admissao))."\n";
    $dados_profissionais .= 'Vínculo: ' . $model->vinculo_empregaticio."\n";
?>
<div class="slo-proposta-form">
    <h4 class="titulo">Cônjuge: Mais informações Profissionais <sup><span class="badge badge-primary"> 13 </span></sup>
        <br><sub title="<?=$dados_anteriores?>"> <strong>Pretendente:</strong> <?=$model2->nome?></sub>
        <br><sub title="<?=$dados_conjuje?>"> <strong>Cônjuje:</strong> <?=$conjuge->nome?></sub>
        <br><sub title="<?=$dados_profissionais?>"> <strong>Empresa:</strong> <?=$model->empresa?></sub>
    </h4>
    <hr>
    <div class="progress">
      <div class="progress-bar bg-success" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <a class="btn btn-primary" href="<?= Yii::$app->homeUrl.'proposta/pretendente001?form=013&id='.$model2->id.'&iddoc='.$model->id .'&pretendente_id='.$pretendente_id.'&proposta_id='.$proposta_id ?>"><i class="fas fa-angle-double-left"></i> Voltar</a>
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


    
    <div class="col-md-12">
        <div class="form-group float-right">
            <?= Html::submitButton('CONTINUAR  <i class="fas fa-angle-double-right"></i>', ['class' => 'btn btn-primary', 'style'=>'font-weight: bolder']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    <?php

      $this->registerJs("$('#sloinfosprofissionais-salario').css('text-align','left')");

    ?>
</div>
