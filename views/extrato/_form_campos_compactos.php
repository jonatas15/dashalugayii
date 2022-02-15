<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use app\models\Locatario;
use app\models\Proprietario;
use app\models\Base;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Extrato */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
label {
    white-space: nowrap;
}
</style>
<div class="extrato-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-12">      
        <div class="col-md-3">
        <?php //= $form->field($model, 'locatario_id')->textInput() ?>
        <?php           
            $nivel=Locatario::find()->all();
            $listData=ArrayHelper::map($nivel,'id','nome');
            echo $form->field($model, 'locatario_id')->dropDownList($listData, ['prompt'=>'Selecione']);
        ?>
        </div>
        <div class="col-md-3">
        <?php //= $form->field($model, 'locatario_id')->textInput() ?>
        <?php           
            $nivel=Proprietario::find()->all();
            $listData=ArrayHelper::map($nivel,'id','nome');
            echo $form->field($model, 'proprietario_id')->dropDownList($listData, ['prompt'=>'Selecione']);
        ?>
        </div>
        <div class="col-md-3">
        <?php //= $form->field($model, 'locatario_id')->textInput() ?>
        <?php           
            $nivel=Base::find()->all();
            $listData=ArrayHelper::map($nivel,'id','codigo');
            echo $form->field($model, 'base_id')->dropDownList($listData, ['prompt'=>'Selecione']);
        ?>
        </div>
        <div class="col-md-3">
        <?php
        $meses = [
            'Janeiro'=>'Janeiro',
            'Fevereiro'=>'Fevereiro',
            'Março'=>'Março',
            'Abril'=>'Abril',
            'Maio'=>'Maio',
            'Junho'=>'Junho',
            'Julho'=>'Julho',
            'Agosto'=>'Agosto',
            'Setembro'=>'Setembro',
            'Outubro'=>'Outubro',
            'Novembro'=>'Novembro',
            'Dezembro'=>'Dezembro'
        ];
        ?>
        <?= $form->field($model, 'mes')->dropDownList($meses, ['prompt'=>'Selecione']); ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-3">
        <?php 
        if(!$model->isNewRecord AND $model->data_aplicacao != null) {
            $model->data_aplicacao = Yii::$app->formatter->asDate($model->data_aplicacao, 'dd/MM/yyyy');
        }
        else {
            $model->data_aplicacao = Yii::$app->formatter->asDate(now, 'dd/MM/yyyy');
        }
        echo $form->field($model, 'data_aplicacao')->widget(DatePicker::classname(), [
            'language' => 'pt-BR',
            'options' => ['placeholder' => 'Data de Aplicação'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd/mm/yyyy'
            ]
            ]);
        ?>
        </div>
        <div class="col-md-3">
        <?php 
        if(!$model->isNewRecord AND $model->data_vencimento != null) {
            $model->data_vencimento = Yii::$app->formatter->asDate($model->data_vencimento, 'dd/MM/yyyy');
        }
        else {
            $model->data_vencimento = Yii::$app->formatter->asDate(now, 'dd/MM/yyyy');
        }
        echo $form->field($model, 'data_vencimento')->widget(DatePicker::classname(), [
            'language' => 'pt-BR',
            'options' => ['placeholder' => 'Data de Vencimento'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd/mm/yyyy'
            ]
            ]);
        ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'receita_locacao',['addon' => ['prepend' => ['content'=>'R$']]])->textInput(['maxlength' => true,'type' => 'number','step'=>"0.01"]) ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'receitas_subtotal',['addon' => ['prepend' => ['content'=>'R$']]])->textInput(['maxlength' => true,'type' => 'number','step'=>"0.01"]) ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'iptu',['addon' => ['prepend' => ['content'=>'R$']]])->textInput(['maxlength' => true,'type' => 'number','step'=>"0.01"]) ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-2">
        <?= $form->field($model, 'iptu_apt_garag',['addon' => ['prepend' => ['content'=>'R$']]])->textInput(['maxlength' => true,'type' => 'number','step'=>"0.01"]) ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'condominio',['addon' => ['prepend' => ['content'=>'R$']]])->textInput(['maxlength' => true,'type' => 'number','step'=>"0.01"]) ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'taxa_condominio',['addon' => ['prepend' => ['content'=>'R$']]])->textInput(['maxlength' => true,'type' => 'number','step'=>"0.01"]) ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'outros',['addon' => ['prepend' => ['content'=>'R$']]])->textInput(['maxlength' => true,'type' => 'number','step'=>"0.01"]) ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'total',['addon' => ['prepend' => ['content'=>'R$']]])->textInput(['maxlength' => true,'type' => 'number','step'=>"0.01"]) ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'nosso_numero')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-2">
        <?= $form->field($model, 'numero_nota')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'honorarios_porcentagem')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'honorarios_valor',['addon' => ['prepend' => ['content'=>'R$']]])->textInput(['maxlength' => true,'type' => 'number','step'=>"0.01"]) ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'honorarios_admin',['addon' => ['prepend' => ['content'=>'R$']]])->textInput(['maxlength' => true,'type' => 'number','step'=>"0.01"]) ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'descontos_subtotal',['addon' => ['prepend' => ['content'=>'R$']]])->textInput(['maxlength' => true,'type' => 'number','step'=>"0.01"]) ?>
        </div>
        <div class="col-md-2">
        <?= $form->field($model, 'total_depositado',['addon' => ['prepend' => ['content'=>'R$']]])->textInput(['maxlength' => true,'type' => 'number','step'=>"0.01"]) ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-2">
        <?= $form->field($model, 'valor_pago_ao_proprietario',['addon' => ['prepend' => ['content'=>'R$']]])->textInput(['maxlength' => true,'type' => 'number','step'=>"0.01"]) ?>
        </div>
        <div class="col-md-3">
        <?php 
        if(!$model->isNewRecord AND $model->data_pagamento != null) {
            $model->data_pagamento = Yii::$app->formatter->asDate($model->data_pagamento, 'dd/MM/yyyy');
        }
        else {
            $model->data_pagamento = Yii::$app->formatter->asDate(now, 'dd/MM/yyyy');
        }
        echo $form->field($model, 'data_pagamento')->widget(DatePicker::classname(), [
            'language' => 'pt-BR',
            'options' => ['placeholder' => 'Data de Pagamento'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'dd/mm/yyyy'
            ]
            ]);
        ?>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
        <?= $form->field($model, 'descricao_descontos')->textarea(['rows' => 6]) ?>
        </div>
        <!-- <div class="col-md-12">
        <?= $form->field($model, 'descricao_descontos')->textarea(['rows' => 6]) ?>
        </div> -->
        
        
    </div>
    <div class="col-md-12">
        <hr>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Salvar') : Yii::t('app', 'Atualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','style'=>'float:right']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
