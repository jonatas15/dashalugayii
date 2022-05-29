<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SlocontratoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slocontrato-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'proposta_id') ?>

    <?= $form->field($model, 'id_imovel_imo') ?>

    <?= $form->field($model, 'id_tipo_con') ?>

    <?= $form->field($model, 'dt_inicio_con') ?>

    <?php // echo $form->field($model, 'dt_fim_con') ?>

    <?php // echo $form->field($model, 'vl_aluguel_con') ?>

    <?php // echo $form->field($model, 'tx_adm_con') ?>

    <?php // echo $form->field($model, 'fl_txadmvalorfixo_con') ?>

    <?php // echo $form->field($model, 'nm_diavencimento_con') ?>

    <?php // echo $form->field($model, 'tx_locacao_con') ?>

    <?php // echo $form->field($model, 'id_indicereajuste_con') ?>

    <?php // echo $form->field($model, 'nm_mesreajuste_con') ?>

    <?php // echo $form->field($model, 'dt_ultimoreajuste_con') ?>

    <?php // echo $form->field($model, 'fl_mesfechado_con') ?>

    <?php // echo $form->field($model, 'id_contabanco_cb') ?>

    <?php // echo $form->field($model, 'fl_diafixorepasse_con') ?>

    <?php // echo $form->field($model, 'nm_diarepasse_con') ?>

    <?php // echo $form->field($model, 'fl_mesvencido_con') ?>

    <?php // echo $form->field($model, 'fl_dimob_con') ?>

    <?php // echo $form->field($model, 'id_filial_fil') ?>

    <?php // echo $form->field($model, 'st_observacao_con') ?>

    <?php // echo $form->field($model, 'nm_repassegarantido_con') ?>

    <?php // echo $form->field($model, 'fl_garantia_con') ?>

    <?php // echo $form->field($model, 'fl_seguroincendio_con') ?>

    <?php // echo $form->field($model, 'fl_endcobranca_con') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
