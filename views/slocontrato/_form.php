<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Slocontrato */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slocontrato-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'proposta_id')->textInput() ?>

    <?= $form->field($model, 'id_imovel_imo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_tipo_con')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dt_inicio_con')->textInput() ?>

    <?= $form->field($model, 'dt_fim_con')->textInput() ?>

    <?= $form->field($model, 'vl_aluguel_con')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tx_adm_con')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fl_txadmvalorfixo_con')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nm_diavencimento_con')->textInput() ?>

    <?= $form->field($model, 'tx_locacao_con')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_indicereajuste_con')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nm_mesreajuste_con')->textInput() ?>

    <?= $form->field($model, 'dt_ultimoreajuste_con')->textInput() ?>

    <?= $form->field($model, 'fl_mesfechado_con')->textInput() ?>

    <?= $form->field($model, 'id_contabanco_cb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fl_diafixorepasse_con')->textInput() ?>

    <?= $form->field($model, 'nm_diarepasse_con')->textInput() ?>

    <?= $form->field($model, 'fl_mesvencido_con')->textInput() ?>

    <?= $form->field($model, 'fl_dimob_con')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_filial_fil')->textInput() ?>

    <?= $form->field($model, 'st_observacao_con')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nm_repassegarantido_con')->textInput() ?>

    <?= $form->field($model, 'fl_garantia_con')->textInput() ?>

    <?= $form->field($model, 'fl_seguroincendio_con')->textInput() ?>

    <?= $form->field($model, 'fl_endcobranca_con')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
