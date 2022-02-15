<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ControleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="controle-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idcontrole') ?>

    <?= $form->field($model, 'acao_feita') ?>

    <?= $form->field($model, 'detalhes_acao') ?>

    <?= $form->field($model, 'permuta_id') ?>

    <?= $form->field($model, 'cadastrador') ?>

    <?php // echo $form->field($model, 'data_cadastro') ?>

    <?php // echo $form->field($model, 'atualizador') ?>

    <?php // echo $form->field($model, 'data_alteracao') ?>

    <?php // echo $form->field($model, 'mais_infos') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
