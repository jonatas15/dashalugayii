<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProprietarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proprietario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'conta_deposito') ?>

    <?= $form->field($model, 'codigo_imovel') ?>

    <?= $form->field($model, 'logradouro') ?>

    <?php // echo $form->field($model, 'inicio_locacao') ?>

    <?php // echo $form->field($model, 'mais_informacoes') ?>

    <?php // echo $form->field($model, 'celular') ?>

    <?php // echo $form->field($model, 'telefone') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'cpf_cnpj') ?>

    <?php // echo $form->field($model, 'usuario_id') ?>

    <?php // echo $form->field($model, 'rg') ?>

    <?php // echo $form->field($model, 'orgao') ?>

    <?php // echo $form->field($model, 'sexo') ?>

    <?php // echo $form->field($model, 'data_nascimento') ?>

    <?php // echo $form->field($model, 'nacionalidade') ?>

    <?php // echo $form->field($model, 'cep') ?>

    <?php // echo $form->field($model, 'endereco') ?>

    <?php // echo $form->field($model, 'numero') ?>

    <?php // echo $form->field($model, 'complemento') ?>

    <?php // echo $form->field($model, 'bairro') ?>

    <?php // echo $form->field($model, 'cidade') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'proposta_id') ?>

    <?php // echo $form->field($model, 'iptu') ?>

    <?php // echo $form->field($model, 'condominio') ?>

    <?php // echo $form->field($model, 'foto_rg') ?>

    <?php // echo $form->field($model, 'foto_cpf') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
