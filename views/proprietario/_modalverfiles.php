<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
Modal::begin([
    'header' => '',
    'size' => 'modal-lg',
    'toggleButton' => [
        'label' => "<i class='fa fa-file'></i>",
        'class' => 'btn btn-primary'
    ],
    'options' => ['tabindex' => true],
]);
?>
<h2><center><?=$model->nome?></center></h2>
<hr>
<div class="col-md-12">
    <h3>Dados Bancários</h3>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'banco', 'Banco', $model->banco, $model->id) ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'agencia', 'Agência', $model->agencia, $model->id) ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'operacao', 'Operação', $model->operacao, $model->id) ?>
    <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'conta_deposito', 'Nº Conta', $model->conta_deposito, $model->id) ?>
</div>
<div class="clearfix"></div>
<hr>
<?php if ($model->estado_civil == 'Casado'): ?>
    <div class="col-md-12">
        <h3>Cônjuge</h3>
        <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'cnj_nome', $model->getAttributeLabel('cnj_nome'), $model->cnj_nome, $model->id) ?>
        <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'cnj_email', $model->getAttributeLabel('cnj_email'), $model->cnj_email, $model->id) ?>
        <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'cnj_cpf', $model->getAttributeLabel('cnj_cpf'), $model->cnj_cpf, $model->id) ?>
        <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'cnj_documento_numero', $model->getAttributeLabel('cnj_documento_numero'), $model->cnj_documento_numero, $model->id) ?>
        <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'cnj_nacionalidade', $model->getAttributeLabel('cnj_nacionalidade'), $model->cnj_nacionalidade, $model->id) ?>
        <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'cnj_data_nascimento', $model->getAttributeLabel('cnj_data_nascimento'), $model->cnj_data_nascimento, $model->id) ?>
        <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'cnj_telefone_celular', $model->getAttributeLabel('cnj_telefone_celular'), $model->cnj_telefone_celular, $model->id) ?>
        <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'cnj_profissao', $model->getAttributeLabel('cnj_profissao'), $model->cnj_profissao, $model->id) ?>
        <?= $this->context->imprime_campo_editavel('6', 'Proprietario', 'cnj_num_dependentes', $model->getAttributeLabel('cnj_num_dependentes'), $model->cnj_num_dependentes, $model->id) ?>
    </div>
    <div class="clearfix"></div>
    <hr>
<?php endif; ?>
<div class="col-md-12">
    <div class="col-md-6" style="text-align: center; ">
        <h4><strong>RG</strong></h4>
        <?= Html::img('@web/uploads/_file_rg_proprietario_'.$model->codigo_imovel.'_'.$model->foto_rg, [
            'alt' => 'RG',
            'style' => 'width: auto; max-width: 100%; max-height: 300px;'
        ]); ?>
    </div>
    <div class="col-md-6" style="text-align: center; ">
        <h4><strong>CPF</strong></h4>
        <?= Html::img('@web/uploads/_file_cpf_proprietario_'.$model->codigo_imovel.'_'.$model->foto_cpf, [
            'alt' => 'RG',
            'style' => 'width: auto; max-width: 100%; max-height: 300px;'
        ]); ?>
    </div>
</div>
<div class="clearfix"></div>
    <hr>
<?php if ($model->estado_civil == 'Casado'): ?>
    <div class="col-md-12">
        <h3>Documentos do Cônjuge</h3>
        <div class="col-md-6" style="text-align: center; ">
            <h4><strong>RG</strong></h4>
            <?= Html::img('@web/uploads/_cnj_file_foto_rg_proprietario_'.$model->codigo_imovel.'_'.$model->cnj_foto_rg, [
                'alt' => 'RG',
                'style' => 'width: auto; max-width: 100%; max-height: 300px;'
            ]); ?>
        </div>
        <div class="col-md-6" style="text-align: center; ">
            <h4><strong>CPF</strong></h4>
            <?= Html::img('@web/uploads/_cnj_file_foto_cpf_proprietario_'.$model->codigo_imovel.'_'.$model->cnj_foto_cpf, [
                'alt' => 'RG',
                'style' => 'width: auto; max-width: 100%; max-height: 300px;'
            ]); ?>
        </div>
    </div>
    <div class="clearfix"></div>
    <hr>
<?php endif; ?>
<?php
echo "<div class=\"clearfix\"></div>";
Modal::end();