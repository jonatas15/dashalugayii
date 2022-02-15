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
    <a class="btn btn-primary" href="<?= Yii::$app->homeUrl.'proposta/pretendente001?form=0017&id='.$model2->id.'&iddoc='.$model->id .'&pretendente_id='.$pretendente_id.'&proposta_id='.$proposta_id ?>"><i class="fas fa-angle-double-left"></i> Voltar</a>
    <h4 class="titulo"><?= 6 + $se_casado ?> - Mora Atualmente: gastos <sup><span class="badge badge-primary"> 3/3 </span></sup>
        <br><sub title="<?=$dados_anteriores?>"> <strong>Pretendente:</strong> <?=$model2->nome?></sub>
        <br><sub title="<?=$dados_mara_atual?>"> <strong>Dados Anteriores:</strong> <?=$model->endereco?></sub>
    </h4>
    <hr>
    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-4">
        <?= $form->field($model, 'outros_imoveis_alugados')->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'onText' => 'SIM',
                'offText' => 'Não',
                'onColor' => 'success',
                'offColor' => 'warning',
            ],
          ]); ?>
    </div>
    <div class="col-md-8">
        <?= $form->field($model, 'outros_ia_aluguel_encargos')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-12"></div>
    <div class="col-md-4">
        <?= $form->field($model, 'bens_financiados_emprestimos')->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'onText' => 'SIM',
                'offText' => 'Não',
                'onColor' => 'success',
                'offColor' => 'warning',
            ],
          ]); ?>
    </div>
    <div class="col-md-8">
        <?= $form->field($model, 'bens_fe_nome_valor')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-12"></div>
    <div class="col-md-4">
        <?= $form->field($model, 'dependente_com_doenca')->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'onText' => 'SIM',
                'offText' => 'Não',
                'onColor' => 'success',
                'offColor' => 'warning',
            ],
        ]); ?>
    </div>
    <div class="col-md-8">
        <?= $form->field($model, 'dependente_doente_infos')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-12"></div>
    <div class="col-md-4">
        <?= $form->field($model, 'dependentes_estudantes')->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'onText' => 'SIM',
                'offText' => 'Não',
                'onColor' => 'success',
                'offColor' => 'warning',
            ],
        ]); ?>
    </div>
    <div class="col-md-8">
        <?= $form->field($model, 'dependentes_estudantes_info')->textInput(['maxlength' => true]) ?>
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
