<?php 
use yii\bootstrap\Modal;
use kartik\checkbox\CheckboxX;
use kartik\select2\Select2;
use kartik\spinner\Spinner;
?>

<div class="col-md-12">
    <div class="col-md-12"><br /></div>
    <div class="col-md-6">
        <div class="col-md-12" style="text-align: center !important; box-shadow: 0 1px 4px 0 rgb(0 0 0 / 14%); padding: 2%">
            <h3><strong>Gerar PDF</strong></h3>
            <p>
                <label>Informações do Imóvel, da proposta e do proponente. Inclui documentos.</label>
            </p>
            <a href="<?=Yii::$app->homeUrl.'proposta/report?id='.$model->id?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
            <i style="font-size: 20px; padding: 5px;" class="fa fa-file"></i> Gerar Documento PDF
            </a>
        </div>
    </div>
    <?php if ($model->etapa_andamento >= 4) : ?>
        <div class="col-md-6" style="text-align: center !important;">
            <div class="col-md-12 estilo-card-caixa">
                <h3><strong>Cadastrar essas Informações no Superlógica</strong></h3>
                <p>
                    <label>Informações do Imóvel, da proposta e do proponente. Inclui documentos.</label>
                </p>
                <?php
                $superlogica = app\models\Superlogica::find()->where([
                    'id_proposta' => $model->id
                ])->one();
                if ($superlogica):

                    $estilos_links_superlogica = [
                        'color' => 'darkgreen',
                        'text-align' => 'center !important',
                        'border' => '1px solid'
                    ];

                    echo '<h4><strong>Registro já encontra-se no Superlógica, deseja editar?</strong></h4>';
                    
                    echo Html::a('Proprietário: '.$superlogica->id_sl_proprietario,
                        'https://apps.superlogica.net/imobiliaria/proprietarios/id/'.$superlogica->id_sl_proprietario
                    , [
                        'target'=>'_blank', 
                        'class' => 'btn btn-link',
                        'style' => $estilos_links_superlogica,
                        'title' => 'Ver no Superlógica'
                    ]);
                    echo Html::a('Imóvel: '.$superlogica->id_sl_imovel, 
                        'https://apps.superlogica.net/imobiliaria/imoveis/id/'.$superlogica->id_sl_imovel
                    , [
                        'target'=>'_blank', 
                        'class' => 'btn btn-link',
                        'style' => $estilos_links_superlogica,
                        'title' => 'Ver no Superlógica'
                    ]);
                    echo Html::a('Locatário: '.$superlogica->id_sl_locatario, 
                        'https://apps.superlogica.net/imobiliaria/locatarios/id/'.$superlogica->id_sl_locatario
                    , [
                        'target'=>'_blank', 
                        'class' => 'btn btn-link',
                        'style' => $estilos_links_superlogica,
                        'title' => 'Ver no Superlógica'
                    ]);
                    echo Html::a('Contrato: '.$superlogica->id_sl_contrato, 
                        'https://apps.superlogica.net/imobiliaria/contratos/id/'.$superlogica->id_sl_contrato
                    , [
                        'target'=>'_blank', 
                        'class' => 'btn btn-link',
                        'style' => $estilos_links_superlogica,
                        'title' => 'Ver no Superlógica'
                    ]);
                else:
                Modal::begin([
                    'size' => 'modal-lg',
                    'toggleButton' => [
                        'label' => '<i style="" class="fa fa-gear"></i> SUPERLÓGICA: Cadastro Completo',
                        'class' => 'btn btn-primary',
                        'style' => 'font-weight: bolder'
                    ]
                ]);
                ?>
                <?php
                    // echo Html::a('<i style="" class="fa fa-gear"></i> SUPERLÓGICA: Proprietário e Imóvel',  ['proposta/addtosuperlogica', 'id' => $model->id], [
                    //     'class' => 'btn btn-primary',
                    //     'style' => 'width: 100%',
                    //     'onClick' => '
                    //         $("body").css("cursor", "wait");
                    //         $(this).css("cursor", "wait");
                    //         $("#progressando").show();
                    //         // $(this).addAttribute(\'disabled\');
                    //         $(this).addClass(\'disabled\');
                    //     '
                    // ]);
                    // MODAL DO SUPERLOGICS CONTEUDO
                    // echo $this->render('_superlogica', [
                    //     'model' => $model,
                    // ]);
                ?>
                <?php Modal::end(); ?>
                <?php endif; ?>
                <br />
                <div id="progressando" style="display: none">
                    <?php
                        
                        echo '<div class="">';
                        echo Spinner::widget(['preset' => 'large', 'align' => 'center']);
                        echo '<div class="clearfix"></div>';
                        echo '</div>';
                        ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>