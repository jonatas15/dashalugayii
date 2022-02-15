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

    $dados_mara_atual .= 'Endereço: '.$model->numero.' | '.$model->bairro.', '.$model->cidade.'-'.$model->uf;
?>
<div class="slo-proposta-form">
    <a class="btn btn-primary" href="<?= Yii::$app->homeUrl.'proposta/pretendente001?form=0016&id='.$model2->id.'&iddoc='.$model->id .'&pretendente_id='.$pretendente_id.'&proposta_id='.$proposta_id ?>"><i class="fas fa-angle-double-left"></i> Voltar</a>
    <h4 class="titulo"><?= 6 + $se_casado ?> - Mora Atualmente: gastos <sup><span class="badge badge-primary"> 2/3 </span></sup>
        <br><sub title="<?=$dados_anteriores?>"> <strong>Pretendente:</strong> <?=$model2->nome?></sub>
        <br><sub title="<?=$dados_mara_atual?>"> <strong>Dados Anteriores:</strong> <?=$model->endereco?></sub>
    </h4>
    <hr>
    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-6">
        <?= $form->field($model, 'residencia_atual')->dropDownList([ 
                'Alugada' => 'Alugada', 
                'Financiada' => 'Financiada', 
                'Hotel ou Flat' => 'Hotel ou Flat', 
                'Própria' => 'Própria', 
            ], 
            ['prompt' => '']) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'em_nome_de')->dropDownList([ 
                'Amigos' => 'Amigos', 
                'Pretendente' => 'Pretendente', 
                'Familiares' => 'Familiares', 
                'da Empresa' => 'Da Empresa', 
            ], 
            ['prompt' => '']) ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'paga_aluguel')->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'onText' => 'SIM',
                'offText' => 'Não',
                'onColor' => 'success',
                'offColor' => 'warning',
            ],
          ]); ?>
    </div>
    <div class="col-md-4">
        <?php $model->gastoatual_agua = (int)$model->gastoatual_agua; ?>
        <?= $form->field($model, 'gastoatual_agua',['addon' => ['prepend' => ['content'=>'R$']]])->widget(MaskedInput::className(), [
          'clientOptions' => [
              'alias' =>  'integer',
              'autoGroup' => true,
              'groupSeparator' => ".",
          ],
          'options'=>[
              // 'onfocus'=> '$(this).key',
              // 'pattern'=>"[0-9]*",
              'inputmode'=>"numeric",
              'class'=>"form-control",
          ]
        ]) ?>
    </div>
    <div class="col-md-4">
        <?php $model->gastoatual_luz = (int)$model->gastoatual_luz; ?>
        <?= $form->field($model, 'gastoatual_luz',['addon' => ['prepend' => ['content'=>'R$']]])->widget(MaskedInput::className(), [
          'clientOptions' => [
              'alias' =>  'integer',
              'autoGroup' => true,
              'groupSeparator' => ".",
          ],
          'options'=>[
              // 'onfocus'=> '$(this).key',
              // 'pattern'=>"[0-9]*",
              'inputmode'=>"numeric",
              'class'=>"form-control",
          ]
        ]) ?>
    </div>
    <div class="col-md-4">
        <?php $model->gastoatual_gas = (int)$model->gastoatual_gas; ?>
        <?= $form->field($model, 'gastoatual_gas',['addon' => ['prepend' => ['content'=>'R$']]])->widget(MaskedInput::className(), [
          'clientOptions' => [
              'alias' =>  'integer',
              'autoGroup' => true,
              'groupSeparator' => ".",
          ],
          'options'=>[
              // 'onfocus'=> '$(this).key',
              // 'pattern'=>"[0-9]*",
              'inputmode'=>"numeric",
              'class'=>"form-control",
          ]
        ]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'tempo_residencia')->dropDownList([ 
            'menos de 1 ano' => 'Menos de 1 ano', 
            '1 a 2 anos' => '1 a 2 anos', 
            '3 a 4 anos' => '3 a 4 anos', 
            '5 a 6 anos' => '5 a 6 anos', 
            '7 a 9 anos' => '7 a 9 anos', 
            'Acima de 10 anos' => 'Acima de 10 anos', 
        ], ['prompt' => '']) ?>
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
