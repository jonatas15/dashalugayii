<table class="kv-grid-table table table-bordered table-striped kv-table-wrap">
    <tr style="font-size: 15px !important;">
        <td style="font-weight: bolder !important">Nome:</td>
        <td id=""><strong><?=$model->nome?></strong></td>
    </tr>
    <tr style="font-size: 15px !important;">
        <td style="font-weight: bolder !important">Email:</td>
        <td id=""><strong><?=$model->email?></strong></td>
    </tr>
    <tr style="font-size: 15px !important;">
        <td style="font-weight: bolder !important">Celular:</td>
        <td id=""><strong><?=$this->context->format_telefone($model->celular)?></strong></td>
    </tr>
    <tr style="font-size: 15px !important;">
        <td style="font-weight: bolder !important">CPF/CNPJ:</td>
        <td id=""><strong><?=$model->cpf_cnpj?></strong></td>
    </tr>
    <!-- <tr style="font-size: 15px !important;">
        <td style="font-weight: bolder !important">Condomínio:</td>
        <td id=""><strong><?=$model->condominio?></strong></td>
    </tr> -->
</table>