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

<div class="slo-proposta-form">
    <?php if ($model->id == ''):?>
        <a class="btn btn-primary btn-destaque" href="<?= Yii::$app->homeUrl.'proposta/pretendente001?form=0016&id='.$model2->id.'&iddoc='.$model->id .'&pretendente_id='.$pretendente_id.'&proposta_id='.$proposta_id ?>"><i class="fas fa-angle-double-left"></i> Voltar</a>
        <h4 class="titulo">Cadastro de Ocupantes do Imóvel <sup><span class="badge badge-primary"> 1/1 </span></sup>
            <br><sub title=""> <strong>Pretendente:</strong> <?=$model2->nome?></sub>
        </h4>
        <hr>
    <?php endif;?>
    <div style = 'text-align: center'>
        <div class="col-md-6">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model2, 'vai_morar')->widget(SwitchInput::classname(), [
                'pluginOptions' => [
                    'onText' => 'SIM',
                    'offText' => 'Não',
                    'onColor' => 'success',
                    'offColor' => 'warning',
                ],
                'options' => [
                    'onChange' => '$.ajax({
                        type: "POST",
                        url:"add_ocupante_pretendente",
                        data:{
                            val: '.$model2->vai_morar.',
                            id: '.$model2->id.'
                        },
                        success: function(data){
                            window.location.reload();
                        }
                    })'
                ]
            ])->label('Pretendente Irá residir no imóvel?'); ?>
        </div>

        <?php if($model2->estado_civil == 'casado'): ?>
            <?php
                // $infospessoais_conjuge =
                $conjuje_pretendente = app\models\SloConjuje::find()->where([
                'pretendente_id' => $pretendente_id])->one();

                if (count($conjuje_pretendente) > 0){

                    $conjuje_pretendente_infos = app\models\SloInfospessoais::find()->where([
                      'conjuje_id' => $conjuje_pretendente->id
                    ])->one();

                    if(count($conjuje_pretendente_infos) > 0):
                        $infospessoais = app\models\SloInfospessoais::findOne($conjuje_pretendente_infos->id);
                        $infospessoais->vai_morar_2 = $infospessoais->vai_morar;
                        ?>
                        <div class="col-md-6">
                            <?= $form->field($infospessoais, 'vai_morar_2')->widget(SwitchInput::classname(), [
                                'pluginOptions' => [
                                    'onText' => 'SIM',
                                    'offText' => 'Não',
                                    'onColor' => 'success',
                                    'offColor' => 'warning',
                                ],
                                'options' => [
                                    'onChange' => '$.ajax({
                                        type: "POST",
                                        url:"add_ocupante_conjuge",
                                        data:{
                                            val: '.$infospessoais->vai_morar.',
                                            id: '.$infospessoais->id.'
                                        },
                                        success: function(data){
                                            window.location.reload();
                                        }
                                    })'
                                ]
                            ])->label('Cônjuge Irá residir no imóvel?'); ?>

                        </div>
                        <?php
                    endif;
                }
            ?>

        <?php else: ?>
        <?php endif; ?>

        <?php $form = ActiveForm::end(); ?>

        <div class="clearfix"></div>
        <hr>
        <p>Você precisa cadastrar dados básicos de todos os ocupantes do imóvel</p>
        <?php
            yii\bootstrap\Modal::begin([
                'header' => '<h3>Cadastrar Novo Ocupante</h3>',
                // 'size' => 'modal-lg',
                'toggleButton' => [
                    'label' => '<i class="fas fa-plus"></i> <span> Cadastrar Novo Ocupante</span>',
                    'class' => 'btn btn-primary',
                ],
            ]);
        ?>
        <div style="text-align: left">
            <?php $form = ActiveForm::begin(); ?>

            <div class="col-md-4 hidden">
                <?= $form->field($model, 'slo_pretendente_id')->textInput(['value'=>$pretendente_id]) ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-5">
                <?= $form->field($model, 'sexo')->dropDownList([ 'M' => 'Masculino', 'F' => 'Feminino', ], ['prompt' => '']) ?>
            </div>

            <div class="col-md-7">
                <?= $form->field($model, 'cpf')->widget(MaskedInput::className(), [
                    'mask' => '999.999.999-99',
                    'options'=>[
                        // 'onfocus'=> '$(this).key',
                        // 'pattern'=>"[0-9]*",
                        'inputmode'=>"numeric",
                        'class'=>"form-control",
                    ]
                ]) ?>
            </div>

            <div class="col-md-5">
                <?= $form->field($model, 'tipo_documento')->dropDownList([ 'RG' => 'RG', 'RNE' => 'RNE', 'CNH' => 'CNH', 'Doc de Classe' => 'Doc de Classe', ], ['prompt' => '']) ?>
            </div>

            <div class="col-md-7">
                <?= $form->field($model, 'numero_documento')->textInput(['maxlength' => true,'type'=>'number']) ?>
            </div>

            <div class="col-md-4">
                <?= $form->field($model, 'data_expedicao')->widget(MaskedInput::className(), [
                    'clientOptions' => [
                        'alias' =>  'dd/mm/yyyy',
                        'placeholder' => 'dd/mm/aaaa',
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
                <?= $form->field($model, 'orgao_expedidor')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-md-4">
                <?= $form->field($model, 'data_nascimento')->widget(MaskedInput::className(), [
                    'clientOptions' => [
                        'alias' =>  'dd/mm/yyyy',
                        'placeholder' => 'dd/mm/aaaa',
                    ],
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
                    <?= Html::submitButton('<i class="fas fa-plus"></i> Adicionar Ocupante', ['class' => 'btn btn-primary btn-destaque', 'style'=>'font-weight: bolder']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="clearfix"></div>

        <?php yii\bootstrap\Modal::end(); ?>
    </div>
    <hr>
</div>
