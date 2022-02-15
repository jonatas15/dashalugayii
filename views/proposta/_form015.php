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
?>
<div class="slo-proposta-form">
    <a class="btn btn-primary btn-destaque" href="<?= Yii::$app->homeUrl.'proposta/pretendente001?form=001&id='.$model2->id.'&pretendente_id='.$pretendente_id.'&proposta_id='.$proposta_id ?>"><i class="fas fa-angle-double-left"></i> Voltar ao Início</a>
    <h4 class="titulo"><?= 4 + $se_casado ?> - Referências Bancárias  <sup><span class="badge badge-primary"> 1/1 </span></sup>
        <!-- <br><span class="badge badge-info" style="background: orange">opcional</span> -->
        <br><sub title="<?=$dados_anteriores?>"> <strong>Pretendente:</strong> <?=$model2->nome?></sub>
    </h4>
    <hr>
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-4 hidden">
        <?= $form->field($model, 'slo_pretendente_id')->textInput(['value'=>$pretendente_id]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'nome_banco')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'agencia')->widget(MaskedInput::className(), [
            'mask' => '99999',
            'options'=>[
                // 'onfocus'=> '$(this).key',
                // 'pattern'=>"[0-9]*",
                'inputmode'=>"numeric",
                'class'=>"form-control",
            ]
        ]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'conta_corrente')->textInput(['maxlength' => true,'type' => 'number']) ?>     
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'cliente_desde')->widget(MaskedInput::className(), [
            'clientOptions' => [
                'alias' =>  'dd/mm/yyyy',
                'placeholder' => 'dd/mm/aaaa',
            ],
            'options'=>[
                // 'onfocus'=> '$(this).key',
                // 'pattern'=>"[0-9]*",
                'inputmode'=>"numeric",
                'class'=>"form-control",
                'value'=> $model->cliente_desde ? date('d/m/Y',strtotime($model->cliente_desde)):'',
            ]
        ]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'gerente')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'telefone')->widget(MaskedInput::className(), [
            'mask' => '(99) 9999-9999',
            'options'=>[
                // 'onfocus'=> '$(this).key',
                // 'pattern'=>"[0-9]*",
                'inputmode'=>"numeric",
                'class'=>"form-control",
            ]
        ]) ?>
    </div>
    
    <img src="" alt="">


    
    <div class="col-md-12">
        <div class="form-group float-right">
            <?= Html::submitButton('PULAR / CONTINUAR  <i class="fas fa-angle-double-right"></i>', ['class' => 'btn btn-primary btn-destaque', 'style'=>'font-weight: bolder']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    <?php

      $this->registerJs("$('#sloinfosprofissionais-salario').css('text-align','left')");

    ?>
</div>
