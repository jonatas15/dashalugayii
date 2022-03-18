<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
Modal::begin([
    'header' => '',
    'toggleButton' => [
        'label' => "<i class='fa fa-file'></i>",
        'class' => 'btn btn-primary'
    ],
    'options' => ['tabindex' => true],
]);
?>
<div class="col-md-6" style="text-align: center">
    <h4><strong>RG</strong></h4>
    <?= Html::img('@web/uploads/_file_rg_proprietario_'.$model->codigo_imovel.'_'.$model->foto_rg, [
        'alt' => 'RG',
        'style' => 'width: 100%'
    ]); ?>
</div>
<div class="col-md-6" style="text-align: center">
    <h4><strong>CPF</strong></h4>
    <?= Html::img('@web/uploads/_file_cpf_proprietario_'.$model->codigo_imovel.'_'.$model->foto_cpf, [
        'alt' => 'RG',
        'style' => 'width: 100%'
    ]); ?>
</div>
<?php
echo "<div class=\"clearfix\"></div>";
Modal::end();