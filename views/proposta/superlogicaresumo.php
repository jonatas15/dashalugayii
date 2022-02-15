<?php

    use yii\bootstrap\Modal;
    // echo '<pre>';
    // print_r($this->context->superlogicaitem(216));
    // echo '</pre>';
    

    $item = $this->context->superlogicaitem(216)->data[0];
    // $item = $resumo['prop']->data;
    // $desp = $resumo['desp']->data;
    // $cobr = $resumo['cobr']->data;
    /*/
    // $sapo = $resumo['sapo'];
    /*/
    // echo '<pre>';
    // print_r($item);
    // echo '</pre>';

    function formata_real($v){
        return 'R$ ' . number_format($v, 2, ',', '.');
    }

    function printaitem($campo, $valor, $icone){
        if ($valor != null) {
            return "<!-- $campo -->
            <span style='width:20px;float:left'><strong><i class='fa fa-$icone'></i></strong></span>
            <label for=''>
                <strong> $campo: </strong>
            </label>
            <span>$valor</span>
            <hr style='margin: 1px;'>
            <br />";
        }else{
            return '';
        }
    }

    
?>
<style>
    .botao_ver_mais {
        float: right;
        position: relative;
        margin-top: -59px;
    }
</style>
<h3 style="text-align: center"><?= $item->imovel_formatado; ?></h3>
<a href="https://apps.superlogica.net/imobiliaria/contratos/id/<?=$model->id_slogica?>" class="btn btn-primary" target="_blanck">
    <i class="fa fa-file-text"></i> Ver CONTRATO no Superlógica
</a>
<hr>
<div class="col-md-12">
    <div class="col-md-6">
        <h4 style="text-align: left"><strong><?=strip_tags($item->detalhes_contrato)?></strong></h4>
        <hr>
        <?= printaitem('Imóvel',$item->st_identificador_imo,'home'); ?>
        <?= printaitem('Aluguel',formata_real($item->vl_aluguel_con).'; '.$item->st_complprimeiroaluguel_con,'dollar'); ?>
        <?= printaitem('TX de adm',number_format($item->tx_adm_con,0).'%','user'); ?>
        <?= printaitem('Repasse',$item->nm_diarepasse_con.' dias úteis após o pagamento do aluguel','exchange'); ?>
        <?= printaitem('Tarifa Cobrança',$item->vl_tarifabancariarepasse_con,'dollar'); ?>
        <?= printaitem('Endereço de Cobrança',($item->fl_endcobranca_con?'Usar endereço do imóvel':'não informado'),'thumbtack'); ?>
        <h4 style="text-align: left"><strong>Reajuste</strong></h4>
        <?= printaitem('Último Reajuste',$item->dt_ultimoreajuste_con,'calendar-check'); ?>
        <?php //= printaitem('Próximo Reajuste',$item->dt_ultimoreajuste_con,'calendar-check'); ?>
        <h4 style="text-align: left"><strong>Locador</strong></h4>
        <?php //= printaitem('Locador',$item->nome_proprietario,'user'); ?>
        <?php if($item->proprietarios_beneficiarios): foreach ($item->proprietarios_beneficiarios as $prop): ?>
            <?= printaitem('','<a href="https://apps.superlogica.net/imobiliaria/pessoas/id/'.$prop->id_pessoa_pes.'" target="_blanck">'.$prop->st_fantasia_pes.'</a>','user'); ?>
            <?php 
                $id_proprietario = $prop->id_pessoa_pes; 
                Modal::begin([
                    'header' => '<h4>'.$prop->st_fantasia_pes.'</h4>',
                    'toggleButton' => ['label' => 'Mais detalhes','class'=>'botao_ver_mais'],
                ]);
                $estado_civil = 'Solteiro(a)';
                switch ($prop->st_estadocivil_pes) {
                    case '1': $estado_civil = 'Casado(a)'; break;
                    case '2': $estado_civil = 'Solteiro(a)'; break;
                    default: $estado_civil = 'Solteiro(a)'; break;
                }
                echo '<div class="col-md-6">';
                echo printaitem('CPF',$this->context->format_doc($prop->st_cnpj_pes,'cpf'),'user');
                echo printaitem('RG',$prop->st_rg_pes,'list');
                echo printaitem('Nacionalidade',$prop->st_nacionalidade_pes,'file-text');
                echo printaitem('Estado Civil',$estado_civil,'file-text');
                $endereco = ($prop->st_endereco_pes!=''?$prop->st_endereco_pes:'').
                            (!in_array($prop->st_numero_pes,['',null,'s/n'])?' - '.$prop->st_numero_pes.', ':'').
                            ($prop->st_bairro_pes != ''?$prop->st_bairro_pes.', ':'').
                            ($prop->st_cidade_pes != ''?', '.$prop->st_cidade_pes.' - '.$prop->st_estado_pes:'');
                echo printaitem('Endereço', $endereco,'map-marker');
                echo '</div>';
                echo '<div class="col-md-6">';
                echo '<h4>Contato</h4>';
                echo printaitem('Celular',$prop->st_celular_pes,'mobile');
                echo printaitem('Email',$prop->st_email_pes,'envelope');
                echo '</div>';
                echo '<div class="clearfix"></div>';
                // echo '<h4>Pagamento</h4>';
                Modal::end();
            ?>
        <?php endforeach; endif; ?>
        <h4 style="text-align: left"><strong>Locatários</strong></h4>
        <?php if($item->inquilinos): foreach ($item->inquilinos as $loc): ?>
            <?= printaitem('','<a href="https://apps.superlogica.net/imobiliaria/pessoas/id/'.$loc->id_pessoa_pes.'" target="_blanck">'.$loc->st_fantasia_pes.'</a>','key'); ?>
            <?php 
                $prop = $loc;
                Modal::begin([
                    'header' => '<h4>'.$prop->st_fantasia_pes.'</h4>',
                    'toggleButton' => ['label' => 'Mais detalhes','class'=>'botao_ver_mais'],
                ]);
                $estado_civil = 'Solteiro(a)';
                switch ($prop->st_estadocivil_pes) {
                    case '1': $estado_civil = 'Casado(a)'; break;
                    case '2': $estado_civil = 'Solteiro(a)'; break;
                    default: $estado_civil = 'Solteiro(a)'; break;
                }
                echo '<div class="col-md-6">';
                echo printaitem('CPF',$this->context->format_doc($prop->st_cnpj_pes,'cpf'),'user');
                echo printaitem('RG',$prop->st_rg_pes,'list');
                echo printaitem('Nacionalidade',$prop->st_nacionalidade_pes,'file-text');
                echo printaitem('Estado Civil',$estado_civil,'file-text');
                $endereco = ($prop->st_endereco_pes!=''?$prop->st_endereco_pes:'').
                            (!in_array($prop->st_numero_pes,['',null,'s/n'])?' - '.$prop->st_numero_pes.', ':'').
                            ($prop->st_bairro_pes != ''?$prop->st_bairro_pes.', ':'').
                            ($prop->st_cidade_pes != ''?', '.$prop->st_cidade_pes.' - '.$prop->st_estado_pes:'');
                echo printaitem('Endereço', $endereco,'map-marker');
                echo '</div>';
                echo '<div class="col-md-6">';
                echo '<h4>Contato</h4>';
                echo printaitem('Celular',$prop->st_celular_pes,'mobile');
                echo printaitem('Email',$prop->st_email_pes,'envelope');
                echo '</div>';
                echo '<div class="clearfix"></div>';
                // echo '<h4>Pagamento</h4>';
                Modal::end();
            ?>
        <?php endforeach; endif; ?>
        <h4 style="text-align: left"><strong>Fiadores</strong></h4>
        <?php if($item->fiadores): foreach ($item->fiadores as $loc): ?>
            <?= printaitem('','<a href="https://apps.superlogica.net/imobiliaria/pessoas/id/'.$loc->id_pessoa_pes.'" target="_blanck">'.$loc->st_nomefiador.'</a>','user'); ?>
            <?php 
                $prop = $loc;
                Modal::begin([
                    'header' => '<h4>'.$prop->st_nomefiador.'</h4>',
                    'toggleButton' => ['label' => 'Mais detalhes','class'=>'botao_ver_mais'],
                ]);
                $estado_civil = 'Solteiro(a)';
                switch ($prop->st_estadocivil_pes) {
                    case '1': $estado_civil = 'Casado(a)'; break;
                    case '2': $estado_civil = 'Solteiro(a)'; break;
                    default: $estado_civil = 'Solteiro(a)'; break;
                }
                echo '<div class="col-md-6">';
                echo printaitem('CPF',$this->context->format_doc($prop->st_cnpj_pes,'cpf'),'user');
                echo printaitem('RG',$prop->st_rg_pes,'list');
                echo printaitem('Nacionalidade',$prop->st_nacionalidade_pes,'file-text');
                echo printaitem('Estado Civil',$estado_civil,'file-text');
                $endereco = ($prop->st_endereco_pes!=''?$prop->st_endereco_pes:'').
                            (!in_array($prop->st_numero_pes,['',null,'s/n'])?' - '.$prop->st_numero_pes.', ':'').
                            ($prop->st_bairro_pes != ''?$prop->st_bairro_pes.', ':'').
                            ($prop->st_cidade_pes != ''?', '.$prop->st_cidade_pes.' - '.$prop->st_estado_pes:'');
                echo printaitem('Endereço', $endereco,'map-marker');
                echo '</div>';
                echo '<div class="col-md-6">';
                echo '<h4>Contato</h4>';
                echo printaitem('Celular',$prop->st_celular_pes,'mobile');
                echo printaitem('Email',$prop->st_email_pes,'envelope');
                echo '</div>';
                echo '<div class="clearfix"></div>';
                // echo '<h4>Pagamento</h4>';
                Modal::end();
            ?>
        <?php endforeach; endif; ?>
    </div>
    <div class="col-md-6">
        <h4 style="text-align: left"><strong>Despesas</strong></h4>
        <?php if($item->desp):  foreach ($desp as $ds): ?>
            <?php 
                $conteudo = '';
                $titulo = date('M/Y',strtotime($ds->dt_referencia_imod)).', Vencimento: '.date('d/m/Y',strtotime($ds->vencimento));    
                $conteudo .= '<br>';
                $conteudo .= '<strong>'.$ds->st_descricao_prd.'</strong> '.$ds->st_complemento_imod;
            ?>
            <?= printaitem($titulo,$conteudo,'table'); ?>
        <?php endforeach; endif; ?>
    </div>
    <div class="col-md-6">
        <h4 style="text-align: left"><strong>Cobranças do contrato em 2020</strong></h4>
        <?php 
            $i = 0; 
            if($cobr):
                $cobr = array_reverse($cobr);
            endif;
        ?>
        <?php if($cobr): foreach ($cobr as $cb): ?>
            <?php 
                $conteudo = '';
                $titulo = 'Vencimento '.date('d/m/Y',strtotime($cb->dt_vencimento_recb));    
                $conteudo .= '<br>';
                $conteudo .= '<strong>Cliente: '.$cb->st_nomeref_sac.'</strong>, <span>Cobrança '.$cb->st_documentoex_recb.'</span>';
                $conteudo .= '<br>';
                $conteudo .= '<strong>'.formata_real($cb->vl_emitido_recb).'</strong>';
            ?>
            <?= printaitem($titulo,$conteudo,'check'); ?>
            <?php 
                $i+=1;
                if ($i > 2) { break; }
            ?>
        <?php endforeach; endif; ?>
    </div>
</div>
<div class="clearfix"></div>
<!-- <br />
<br />
<br />
<br />
<br />
<br />
<?php 
    // echo "<pre>";
    // print_r($cobr);
    // echo "</pre>";
?> -->