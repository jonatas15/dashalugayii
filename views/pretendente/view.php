<?php

    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\DetailView;
    use kartik\detail\DetailView as DetailView2;
    use yii\bootstrap\Collapse;
    use yii\bootstrap\Modal;
    use app\models\Checklist;
    use app\models\Chtopico;
    use kartik\editable\Editable;

    use kartik\checkbox\CheckboxX;
?>

<style type="text/css">
    :root {
        --cor-bg-fundo: #66ccff;
        /*lightgray;*/
        --cor-bg-elementos: #084d6e;
        /*gray;*/
        --fundo-com-transparencia: rgba(0, 0, 0, 0.1);
    }
</style>

<?php
    /* @var $this yii\web\View */
    /* @var $model app\models\SloPretendente */
    // $pessoais = app\models\SloInfospessoais::find()->where(['pretendente_id' => $model->id])->one();
    $pessoais = $model->sloInfospessoais;
    // Informações Documentais!
    $documentais = app\models\SloContratodocumento::find()->where(['slo_pretendente_id' => $model->id])->one();
    if (count($documentais) > 0) {
        $detailInfoDocumental = DetailView2::widget([
            'model'=>$documentais,
            'condensed'=>true,
            'hover'=>true,
            'mode'=>DetailView2::MODE_VIEW,
            'panel'=>[
                'heading'=>'Documentação',
                'type'=>DetailView2::TYPE_INFO,
            ],
            'attributes'=>[
                'tipo_documento',
                'numero',
                'orgao_expedidor',
                'data_expedicao',
                'endereco',
            ],
            'formOptions' => ['action' => ['upddocumentacao','id'=>$documentais->id]]
        ]);

    } else {
        $detailInfoDocumental = '<label>Não foram Informadas as referências bancárias</label>';
    }
    // Informações Profissionais!
    $profissionais = app\models\SloInfosprofissionais::find()->where(['pretendente_id' => $model->id])->one();
    if (count($profissionais) > 0) {
        $profissionais->data_admissao = date('d/m/Y', strtotime($profissionais->data_admissao));
        $detailInfoProfissional = DetailView2::widget([
            'model'=>$profissionais,
            'condensed'=>true,
            'hover'=>true,
            'mode'=>DetailView2::MODE_VIEW,
            'panel'=>[
                'heading'=>'Informações Profissionais',
                'type'=>DetailView2::TYPE_INFO,
                'deleteOptions' => false,
            ],
            'buttons1' => '{update}',
            'attributes'=>[
                'empresa',
                [
                    'attribute' => 'fone',
                    'format' => 'raw',
                    'value' => $this->context->format_telefone($profissionais->fone),
                    'type'=> DetailView2::INPUT_WIDGET,
                    'widgetOptions'=>[
                        'class' => 'yii\widgets\MaskedInput',
                        'mask' => '(99) 9999-9999',
                        'options'=>[
                            'inputmode'=>"numeric",
                            'class'=>"form-control"
                        ]
                    ],
                ],
                [
                    'attribute'=>'data_admissao',
                    'format'=>'raw',
                    'type'=>DetailView2::INPUT_DATE,
                    'widgetOptions'=>[
                        'language' => 'pt',
                        'pluginOptions' => [
                            'language' => 'pt',
                            'format' => 'dd/mm/yyyy',
                        ]
                    ],
                ],
                [
                    'attribute'=>'vinculo_empregaticio',
                    'format'=>'raw',
                    'type'=>DetailView2::INPUT_SELECT2,
                    'widgetOptions'=>[
                        'language' => 'pt',
                        'theme' => kartik\select2\Select2::THEME_DEFAULT,
                        'data'=>  [
                            'Aposentado / Pensionista' => 'Aposentado / Pensionista',
                            'Funcionário com Registro CLT' => 'Funcionário com Registro CLT',
                            'Autônomo' => 'Autônomo',
                            'Empresário' => 'Empresário',
                            'Profissional Liberal' => 'Profissional Liberal',
                            'Estudante' => 'Estudante',
                            'Funcionário Público' => 'Funcionário Público',
                            'Renda Proveniente de Aluguéis' => 'Renda Proveniente de Aluguéis',
                        ],
                        'options' => ['placeholder' => 'Select ...','id'=>''.$ocupante->id.'_tipo_documento',],
                        'pluginOptions' => ['allowClear'=>true, 'width'=>'100%'],
                    ]
                ],
                'profissao',
                'salario',
                'outros_rendimentos',
                'total_rendimentos',
                [
                    'attribute'=>'possui_renda',
                    'format'=>'raw',
                    'value'=>$profissionais->possui_renda ? '<span class="label label-success">Sim</span>' : '<span class="label label-danger">Não</span>',
                    'type'=>DetailView2::INPUT_SWITCH,
                    'widgetOptions' => [
                        'pluginOptions' => [
                            'onText' => 'Sim',
                            'offText' => 'Não',
                        ]
                    ],
                ],
                [
                    'attribute'=>'compoe_renda',
                    'format'=>'raw',
                    'value'=>$profissionais->compoe_renda ? '<span class="label label-success">Sim</span>' : '<span class="label label-danger">Não</span>',
                    'type'=>DetailView2::INPUT_SWITCH,
                    'widgetOptions' => [
                        'pluginOptions' => [
                            'onText' => 'Sim',
                            'offText' => 'Não',
                        ]
                    ],
                ],
                'cnpj',
                 [
                    'group'=>true,
                    'label'=>'<center>Emprego Anterior</center>',
                    'rowOptions'=>['class'=>'table-info','style'=>'background-color: #bce8f1; color:#31708f;text-align: center'],
                    //'groupOptions'=>['class'=>'text-center']
                ],
                'empganterior_empresa',
                'empganterior_fone',
                'empganterior_periodo',
                'empganterior_endereco',
                'empganterior_end_numero',
                'empganterior_end_complemento',
                'empganterior_end_bairro',
                'empganterior_end_cidade',
                'empganterior_end_estado',
                'empganterior_end_cep',
            ],
            'formOptions' => ['action' => ['updprofissional','id'=>$profissionais->id]]
        ]);
    } else {
        $detailInfoProfissional = '<label>Não foram Informadas os dados Profissionais</label>';
    }
    // Referências Bancárias do Pretendente!
    $refbancarias = app\models\SloRefbancaria::find()->where(['slo_pretendente_id' => $model->id])->one();
    if (count($refbancarias) > 0) {
        $detailInfoRefbancaria = DetailView2::widget([
            'model'=>$refbancarias,
            'condensed'=>true,
            'hover'=>true,
            'mode'=>DetailView2::MODE_VIEW,
            'panel'=>[
                'heading'=>'Referências Bancarias',
                'type'=>DetailView2::TYPE_INFO,
            ],
            'attributes'=>[
                'nome_banco',
                'agencia',
                'conta_corrente',
                'cliente_desde',
                'gerente',
                'telefone',
            ],
            'formOptions' => ['action' => ['updrefbancaria','id'=>$refbancarias->id]]
        ]);
    } else {
        $detailInfoRefbancaria = '<label>Não foram Informadas as referências bancárias</label>';
    }
    // Onde mora Atualmente !
    $moratual = app\models\SloMoratual::find()->where(['slo_pretendente_id' => $model->id])->one();
    if (count($moratual) > 0) {
        $detailMoratual = DetailView2::widget([
            'model'=>$moratual,
            'condensed'=>true,
            'hover'=>true,
            'mode'=>DetailView2::MODE_VIEW,
            'panel'=>[
                'heading'=>'Dados: Mora Atualmente',
                'type'=>DetailView2::TYPE_INFO,
            ],
            'attributes'=>[
                'endereco',
                'numero',
                'complemento',
                'cep',
                'bairro',
                'cidade',
                'uf',
                'residencia_atual',
                'em_nome_de',
                'locador_nome',
                'locador_fone',
                'gastoatual_agua',
                'gastoatual_luz',
                'gastoatual_gas',
                'tempo_residencia',
                'outros_imoveis_alugados',
                'outros_ia_aluguel_encargos',
                'bens_financiados_emprestimos',
                'bens_fe_nome_valor',
                'dependente_com_doenca',
                'dependente_doente_infos',
                'dependentes_estudantes',
                'dependentes_estudantes_info',
            ],
            'formOptions' => ['action' => ['updmoratual','id'=>$moratual->id]]
        ]);
    } else {
        $detailMoratual = '<label>Não foram informados dados</label>';
    }

    // Conjuge:
    if ($pessoais->estado_civil == 'casado') {

        $conjuje = app\models\SloConjuje::find()->where(['pretendente_id' => $model->id])->one();
        $conjuje_pessoais = app\models\SloInfospessoais::find()->where(['conjuje_id' => $conjuje->id])->one();
        $conjuje_profissionais = app\models\SloInfosprofissionais::find()->where(['conjuje_id' => $conjuje->id])->one();

        $conjuje_pessoais->conj_fone_residencial = $conjuje_pessoais->fone_residencial;
        $conjuje_pessoais->conj_celular = $conjuje_pessoais->celular;

        $conjuje_pessoais__genero = $conjuje_pessoais->genero;
        $conjuje_pessoais->genero = $conjuje_pessoais->genero == 'F' ? 1:0;

        $detailInfoPessoal_conjuje = DetailView2::widget([
            'model'=>$conjuje_pessoais,
            'condensed'=>true,
            'hover'=>true,
            'mode'=>DetailView2::MODE_VIEW,
            'panel'=>[
                'heading'=>'Informações Pessoais',
                'type'=>DetailView2::TYPE_INFO,
            ],
            'attributes'=>[
                'nome',
                'data_nascimento',
                'cpf',
                'emancipado',
                // 'fone_residencial',
                [
                    'attribute' => 'conj_fone_residencial',
                    'format' => 'raw',
                    'value' => $this->context->format_telefone($conjuje_pessoais->conj_fone_residencial),
                    'type'=> DetailView2::INPUT_WIDGET,
                    'widgetOptions'=>[
                        'class' => 'yii\widgets\MaskedInput',
                        'mask' => '(99) 9999-9999',
                        'options'=>[
                            'inputmode'=>"numeric",
                            'class'=>"form-control"
                        ]
                    ],
                ],
                // 'celular',
                [
                    'attribute' => 'conj_celular',
                    'format' => 'raw',
                    'value' => $this->context->format_telefone($conjuje_pessoais->conj_celular),
                    'type'=> DetailView2::INPUT_WIDGET,
                    'widgetOptions'=>[
                        'class' => 'yii\widgets\MaskedInput',
                        'mask' => '(99) 9 9999-9999',
                        'options'=>[
                            'inputmode'=>"numeric",
                            'class'=>"form-control"
                        ]
                    ],
                ],
                'possui_renda',
                'vai_morar',
                'estado_civil',
                // 'genero',
                // [
                //     'attribute' => 'conj_genero',
                //     'format' => 'raw',
                // ],
                [
                    'attribute'=>'conj_genero',
                    'format'=>'raw',
                    'value'=>$conjuje_pessoais__genero == 'F' ? '<span class="label label-danger">Feminino</span>' : '<span class="label label-primary">Masculino</span>',
                    'type'=>DetailView2::INPUT_SWITCH,
                    'widgetOptions' => [
                        //'data'=>  [ 'M' => 'Masculino', 'F' => 'Feminino', ],
                        'pluginOptions' => [
                            'onText' => '<i class="fas fa-venus"></i> Femin.',
                            'offText' => '<i class="fas fa-mars"></i> Mascul.',
                            'onColor' => 'danger',
                            'offColor' => 'primary',
                        ]
                    ],
                ],
                'nacionalidade',
                'extrangeiro_temponopais',
                'numero_dependentes',
                'nome_pai',
                'nome_mae',
                'email:email',
            ],
            'formOptions' => ['action' => ['updpessoa','id'=>$conjuje_pessoais->id]]
        ]);
        if (count($conjuje_profissionais) > 0) {
            $detailInfoProfissional_conjuje = DetailView2::widget([
                'model'=>$conjuje_profissionais,
                'condensed'=>true,
                'hover'=>true,
                'mode'=>DetailView2::MODE_VIEW,
                'panel'=>[
                    'heading'=>'Informações Profissionais',
                    'type'=>DetailView2::TYPE_INFO,
                ],
                'attributes'=>[
                    'empresa',
                    // 'fone',
                    [
                        'attribute' => 'fone',
                        'format' => 'raw',
                        'value' => $this->context->format_telefone($conjuje_profissionais->fone),
                        'type'=> DetailView2::INPUT_WIDGET,
                        'widgetOptions'=>[
                            'class' => 'yii\widgets\MaskedInput',
                            'mask' => '(99) 9999-9999',
                            'options'=>[
                                'inputmode'=>"numeric",
                                'class'=>"form-control"
                            ]
                        ],
                    ],
                    'data_admissao',
                    'vinculo_empregaticio',
                    'profissao',
                    'salario',
                    'outros_rendimentos',
                    'total_rendimentos',
                    [
                        'attribute'=>'possui_renda',
                        'format'=>'raw',
                        'value'=>$conjuje_profissionais->possui_renda ? '<span class="label label-success">Sim</span>' : '<span class="label label-danger">Não</span>',
                        'type'=>DetailView2::INPUT_SWITCH,
                        'widgetOptions' => [
                            'pluginOptions' => [
                                'onText' => 'Sim',
                                'offText' => 'Não',
                            ]
                        ],
                    ],
                    [
                        'attribute'=>'compoe_renda',
                        'format'=>'raw',
                        'value'=>$conjuje_profissionais->compoe_renda ? '<span class="label label-success">Sim</span>' : '<span class="label label-danger">Não</span>',
                        'type'=>DetailView2::INPUT_SWITCH,
                        'widgetOptions' => [
                            'pluginOptions' => [
                                'onText' => 'Sim',
                                'offText' => 'Não',
                            ]
                        ],
                    ],
                ],
                'formOptions' => ['action' => ['updprofissional','id'=>$conjuje_profissionais->id]]
            ]);
        } else {
            $detailInfoProfissional_conjuje = '<div class="col-md-12"><label>Não foram Informados Dados</label>'.
                            '</div>';
        }

        $item_conjuje = [
            'label' => '#3 Cônjuge',
            'content' => '<div class="col-md-6">'.$detailInfoPessoal_conjuje.'</div>'.
                        '<div class="col-md-6">'.$detailInfoProfissional_conjuje.
                        '</div>',
            'contentOptions' => ['class' => 'off']
        ];
    } else {
        $item_conjuje = [
            'label' => '#3 Cônjuge',
            'content' => '<div class="col-md-12"><label>Não foram Informados Dados</label>'.
                        '</div>',
            'contentOptions' => ['class' => 'off']
        ];
    }
    $ocupante = app\models\SloOcupante::find()->where(['slo_pretendente_id' => $model->id])->all();
    if (count($ocupante) > 0) {
        foreach ($ocupante as $row) {
            $ocupante = app\models\SloOcupante::find()->where(['id' => $row->id])->one();
            $detailOcupante .= '<div class="col-md-4" style="margin-bottom: 1%;">';

            $ocupante->data_nascimento = date('d/m/Y', strtotime($ocupante->data_nascimento));
            $ocupante->data_expedicao = date('d/m/Y', strtotime($ocupante->data_expedicao));

            $ocupante__sexo = $ocupante->sexo;
            $ocupante->sexo = $ocupante->sexo == 'F' ? 1:0;

            $detailOcupante .= DetailView2::widget([
                'model'=>$ocupante,
                'condensed'=>true,
                'hover'=>true,
                'mode'=>DetailView2::MODE_VIEW,
                'id' => $ocupante->id,
                'deleteOptions' => [
                    'url' => 'delete_ocupante?id='.$ocupante->id,
                ],
                'panel'=>[
                    'heading'=>'<strong style="text-transform: capitalize">'.$ocupante->nome.'</strong>',
                    'type'=>DetailView2::TYPE_INFO,
                ],
                'attributes'=>[
                    'nome',
                    //'sexo',
                    [
                        'attribute'=>'sexo',
                        'format'=>'raw',
                        'value'=>$ocupante__sexo == 'F' ? '<span class="label label-danger">Feminino</span>' : '<span class="label label-primary">Masculino</span>',
                        'type'=>DetailView2::INPUT_SWITCH,
                        'widgetOptions' => [
                            'options'=>[
                                'id'=>''.$ocupante->id.'_sexo',
                            ],
                            'pluginOptions' => [
                                'onText' => '<i class="fas fa-venus"></i> Femin.',
                                'offText' => '<i class="fas fa-mars"></i> Mascul.',
                                'onColor' => 'danger',
                                'offColor' => 'primary',
                            ]
                        ],
                    ],
                    [
                        'attribute' => 'cpf',
                        'format' => 'raw',
                        'value' => $this->context->format_cpf($ocupante->cpf),
                        'type'=> DetailView2::INPUT_WIDGET,
                        'widgetOptions'=>[
                            'class' => 'yii\widgets\MaskedInput',
                            'mask' => '999.999.999-99',
                            'options'=>[
                                'inputmode'=>"numeric",
                                'class'=>"form-control",
                                'id'=>''.$ocupante->id.'_cpf',
                            ]
                        ],
                    ],
                    [
                        'attribute'=>'tipo_documento',
                        'format'=>'raw',
                        'type'=>DetailView2::INPUT_SELECT2,
                        'widgetOptions'=>[
                            'language' => 'pt',
                            'theme' => kartik\select2\Select2::THEME_DEFAULT,
                            'data'=>  [ 'RG' => 'RG', 'RNE' => 'RNE', 'CNH' => 'CNH', 'Doc de Classe' => 'Doc de Classe', ],
                            'options' => ['placeholder' => 'Select ...','id'=>''.$ocupante->id.'_tipo_documento',],
                            'pluginOptions' => ['allowClear'=>true, 'width'=>'100%'],
                        ]
                    ],
                    'numero_documento',
                    [
                        'attribute'=>'data_expedicao',
                        'format'=>'raw',
                        'type'=>DetailView2::INPUT_DATE,
                        'widgetOptions'=>[
                            'options' => ['id'=>$ocupante->id.'_data_expedicao'],
                            'language' => 'pt',
                            'pluginOptions' => [
                                'language' => 'pt',
                                'format' => 'dd/mm/yyyy',
                            ]
                        ],
                    ],
                    'orgao_expedidor',
                    [
                        'attribute'=>'data_nascimento',
                        'format'=>'raw',
                        'type'=>DetailView2::INPUT_DATE,
                        'widgetOptions'=>[
                            'options' => ['id'=>$ocupante->id.'_data_nascimento'],
                            'language' => 'pt',
                            'pluginOptions' => [
                                'language' => 'pt',
                                'format' => 'dd/mm/yyyy',
                            ]
                        ],
                    ],
                ],
                'formOptions' => ['action' => ['updocupante','id'=>$ocupante->id]]
            ]);
            $detailOcupante .='</div>';
        }
        $detailOcupante .='<div class="col-md-12 clearfix"><br></div>';
        // $detailOcupante .='<div class="col-md-12">';
        // $detailOcupante .='</div>';
    } else {
        $detailOcupante = '<label>Não foram informados dados sobre o Ocupante</label>';
    }

    $item_ocupante = [
        'label' => '#5 Ocupantes do Imóvel',
        'content' => '<div class="col-md-12">'.$detailOcupante.
                     '</div>',
        'contentOptions' => ['class' => 'off']
    ];



    $this->title = 'Pretendente: '.$pessoais->nome;

    $this->params['breadcrumbs'][] = [
        'label' => 'Proposta',
        'url' => [
            '/proposta/update?id='.$model->proposta_id
        ]
    ];

    $this->params['breadcrumbs'][] = $this->title;
    ?>
    <div class="slo-pretendente-view">

        <h2 style="text-transform: capitalize"><?= Html::encode($this->title) ?></h2>
        <h4><?='Proposta pelo Imóvel PIN-'.$model->proposta->codigo_imovel?></h4>
        <style media="screen">
            #ul-checks, #ul-checks ul {list-style-type: none;}
            #ul-checks .help-block {margin: 0px !important}
            #ul-checks input[type="checkbox"] {width: 17px; height: 17px;margin-top: 0px;}
            #ul-checks label {margin-top: 10px;}
        </style>
        <div class="col-md-12">
          <?php
              // Modal::begin([
              //     'header' => '<h2>Processos da Locação</h2>',
              //     'toggleButton' => [
              //         'label' => 'Processos da Locação',
              //         'class' => 'btn'
              //     ],
              // ]);
              //
              // $novo_ocupante = new app\models\SloOcupante;
              //
              // echo $this->render('_form_novo_ocupante', [
              //     'model' => $novo_ocupante,
              //     'pretendente_id' => $model->id,
              //     'proposta_id' => $model->proposta->id,
              // ]);
              //
              // Modal::end();
              $checklist = Checklist::findOne(['pretendente_id'=>$model->id]);
              if (count($checklist) > 0){

              }else {
                  $checklist = new Checklist();
                  $checklist->titulo = 'Processo de Locação do Pretendente '.$pessoais->nome;
                  $checklist->pretendente_id = $model->id;
                  $checklist->save();

                  // 1ª Etapa
                  $this->context->addtopicoch($checklist->id,'Enviar ao cliente "lista" de documentos e "fichas" para cadastro.', '1ª Etapa');
                  $this->context->addtopicoch($checklist->id,'Criar pastas no Drive e colocar os documentos enviados.', '1ª Etapa');
                  $this->context->addtopicoch($checklist->id,'Criar "card" no Pipefy, para solicitar análise e contrato (definir prazo).', '1ª Etapa');
                  $this->context->addtopicoch($checklist->id,'Encaminhar contratos para assinatura eletrônica (se for o caso).', '1ª Etapa');
                  $this->context->addtopicoch($checklist->id,'Solicitar orçamento do "seguro incêndio" junto ao MK seguros.', '1ª Etapa');
                  $this->context->addtopicoch($checklist->id,'Realizar vistoria de entrada do imóvel.', '1ª Etapa');
                  $this->context->addtopicoch($checklist->id,'Entregar as "chaves", "contrato", "vistoria" e "cartão de vantagens".', '1ª Etapa');
                  $this->context->addtopicoch($checklist->id,'Digitalizar <b>todos</b> documentos assinados, contratos e subir pro DRIVE.', '1ª Etapa');

                  // 2ª Etapa
                  $this->context->addtopicoch($checklist->id,'Registrar no jetimob em "negociações" e "oportunidades".', '2ª Etapa');
                  $this->context->addtopicoch($checklist->id,'Registrar novo contrato no Superlógica.', '2ª Etapa');

                  // 3ª Etapa
                  $this->context->addtopicoch($checklist->id,'Se <b>Credpago</b>, anexar no sistema: "contrato", "vistoria com as fotos" e "apólice de seguro".', '3ª Etapa');
                  $this->context->addtopicoch($checklist->id,'Se <b>Segurança-fiança</b>, encaminhar a seguradora: "contrato", "procuração" e "vistoria".', '3ª Etapa');
                  $this->context->addtopicoch($checklist->id,'Após 1 semana do contrato assinado, realizar o "Pós-Venda".', '3ª Etapa');

                  // Outras etapas
                  // $this->context->addtopicoch($checklist->id,'.');

              }
              echo $checklist->titulo;
              // echo "<pre>";
              // print_r($checklist->chtopicos);
              // echo "</pre>";
            // $form = ActiveForm::begin([
            //       'id' => 'active-form',
            //       'options' => [
            //   		'class' => 'form-horizontal',
            //   		'enctype' => 'multipart/form-data'
            //   	],
            // ]);
            $cont_check = '';
            $primeira_etapa = '';
            $segunda_etapa = '';
            $terceira_etapa = '';

            $i = 0;
            foreach ($checklist->chtopicos as $key => $val) {

                $item_em_questao = '<li>'. CheckboxX::widget([
                                
                    'name' => 'topico['.$val->id.']',
                    'value' => $val->checked,
                    'initInputType' => CheckboxX::INPUT_CHECKBOX,
                    'autoLabel' => true,
                    'pluginEvents' => [
                        'change' => 'function() {$.ajax({
                                        method: "POST",
                                        url: "processodelocacao",
                                        data: {
                                            id: '.$val->id.',
                                            val: $(this).prop(\'checked\')
                                        }})}'
                    ],
                    'labelSettings' => [
                        'label' => '',
                        'position' => CheckboxX::LABEL_LEFT
                    ],
                    
                ]).Editable::widget([
                    'name'=>'province', 
                    'asPopover' => true,
                    'header' => 'Tópico',
                    'format' => Editable::FORMAT_BUTTON,
                    'inputType' => Editable::INPUT_TEXTAREA,
                     // any list of values
                    'value'=>$val->conteudo,
                    'options' => [
                        'class'=>'',
                        'style'=>'float:left',
                        
                    ],
                    'formOptions' => [ 'action' => [
                        'editregistro',
                        'id'=>$val->id
                    ] ],
                ]).Html::a('<i class="glyphicon glyphicon-trash"></i>', ['deletetopico', 'id' => $val->id], [
                    'class' => '',
                    'data' => [
                        'confirm' => 'Deseja mesmo excluir esse Tópico?',
                        'method' => 'post',
                    ],
                ]);

                if ($val->etapa == '1ª Etapa') {
                    $primeira_etapa .= $item_em_questao;
                    
                }
                if ($val->etapa == '2ª Etapa') {
                    $segunda_etapa .= $item_em_questao;
                }
                if ($val->etapa == '3ª Etapa') {
                    $terceira_etapa .= $item_em_questao;
                }
                $i++;
            }
            $cont_check .= '<h3><strong>';
            $cont_check .= '1ª Etapa';
            $cont_check .= '</strong></h3>';
            $cont_check .= '<ul id="ul-checks">';
            $cont_check .= $primeira_etapa;
            $cont_check .= '</ul>';
            $cont_check .= '</ul>';

            $cont_check .= '<h3><strong>';
            $cont_check .= '2ª Etapa';
            $cont_check .= '</strong></h3>';
            $cont_check .= '<ul id="ul-checks">';
            $cont_check .= $segunda_etapa;
            $cont_check .= '</ul>';
            
            
            $cont_check .= '<h3><strong>';
            $cont_check .= '3ª Etapa';
            $cont_check .= '</strong></h3>';
            $cont_check .= '<ul id="ul-checks">';
            $cont_check .= $terceira_etapa;
            $cont_check .= '</ul>';


              echo Collapse::widget([
                  'items' => [
                      [
                          'label' => 'PROCESSOS DA LOCAÇÃO',
                          'content' => $cont_check,
                          'contentOptions' => ['class' => 'off'],
                      ],
                    ]
              ]);

            //   ActiveForm::end();
            ?>
            <?php
                Modal::begin([
                    'header' => '<h2>Novo Tópico</h2>',
                    'toggleButton' => [
                        'label' => 'Cadastratar novo Tópico',
                        'class' => 'btn'
                    ],
                ]);

                $novo_topico = new Chtopico;

                echo $this->render('_form_novo_topico', [
                    'model' => $novo_topico,
                    'checklist_id' => $checklist->id,
                ]);

                Modal::end();
            ?>
        </div>
        <div class="clearfix"></div>
        <br>
        <div class="col-md-12">
            <?php
                if(!empty($pessoais->data_nascimento)){
                    $pessoais->data_nascimento = date('d/m/Y', strtotime($pessoais->data_nascimento));
                }

                $pessoais__genero = $pessoais->genero;
                if(!empty($pessoais->genero)){
                    $pessoais->genero = $pessoais->genero == 'F' ? 1:0;
                }
                //Pretendente Aqui

                $pessoais__nacionalidade = $pessoais->nacionalidade;
                if(!empty($pessoais->nacionalidade)){
                    $pessoais->nacionalidade = $pessoais->nacionalidade == 'brasileiro' ? 0:1;
                }

                $detailInfoPessoal = DetailView2::widget([
                    'model'=>$pessoais,
                    'condensed'=>true,
                    'hover'=>true,
                    'mode'=>DetailView2::MODE_VIEW,
                    'panel'=>[
                        'heading'=>'Informações Pessoais',
                        'type'=>DetailView2::TYPE_INFO,
                        'deleteOptions' => false,
                    ],
                    'buttons1' => '{update}',
                    'attributes'=>[
                        'nome',
                        [
                            'attribute'=>'data_nascimento',
                            'format'=>'raw',
                            'type'=>DetailView2::INPUT_DATE,
                            'widgetOptions'=>[
                                'language' => 'pt',
                                'pluginOptions' => [
                                    'language' => 'pt',
                                    'format' => 'dd/mm/yyyy',
                                ]
                            ],
                        ],
                        [
                            'attribute' => 'cpf',
                            'format' => 'raw',
                            'value' => $this->context->format_cpf($pessoais->cpf),
                            'type'=> DetailView2::INPUT_WIDGET,
                            'widgetOptions'=>[
                                'class' => 'yii\widgets\MaskedInput',
                                'mask' => '999.999.999-99',
                                'options'=>[
                                    'inputmode'=>"numeric",
                                    'class'=>"form-control"
                                ]
                            ],
                        ],
                        [
                            'attribute'=>'emancipado',
                            'label'=>'Emancipado',
                            'format'=>'raw',
                            'value'=>$pessoais->emancipado ? '<span class="label label-success">Sim</span>' : '<span class="label label-danger">Não</span>',
                            'type'=>DetailView2::INPUT_SWITCH,
                            'widgetOptions' => [
                                'pluginOptions' => [
                                    'onText' => 'Sim',
                                    'offText' => 'Não',
                                ]
                            ],
                        ],
                        [
                            'attribute' => 'fone_residencial',
                            'format' => 'raw',
                            'value' => $this->context->format_telefone($pessoais->fone_residencial),
                            'type'=> DetailView2::INPUT_WIDGET,
                            'widgetOptions'=>[
                                'class' => 'yii\widgets\MaskedInput',
                                'mask' => '(99) 9999-9999',
                                'options'=>[
                                    'inputmode'=>"numeric",
                                    'class'=>"form-control"
                                ]
                            ],
                        ],
                        [
                            'attribute' => 'celular',
                            'format' => 'raw',
                            'value' => $this->context->format_telefone($pessoais->celular),
                            'type'=> DetailView2::INPUT_WIDGET,
                            'widgetOptions'=>[
                                'class' => 'yii\widgets\MaskedInput',
                                'mask' => '(99) 9 9999-9999',
                                'options'=>[
                                    'inputmode'=>"numeric",
                                    'class'=>"form-control"
                                ]
                            ],
                        ],
                        [
                            'attribute'=>'vai_morar',
                            'format'=>'raw',
                            'value'=>$pessoais->vai_morar ? '<span class="label label-success">Sim</span>' : '<span class="label label-danger">Não</span>',
                            'type'=>DetailView2::INPUT_SWITCH,
                            'widgetOptions' => [
                                'pluginOptions' => [
                                    'onText' => 'Sim',
                                    'offText' => 'Não',
                                ]
                            ],
                        ],
                        [
                            'attribute'=>'estado_civil',
                            'format'=>'raw',
                            'type'=>DetailView2::INPUT_SELECT2,
                            'widgetOptions'=>[
                                'language' => 'pt',
                                'theme' => kartik\select2\Select2::THEME_DEFAULT,
                                'data'=>  [ 'solteiro' => 'Solteiro', 'casado' => 'Casado', 'desquitado' => 'Desquitado', 'divorciado' => 'Divorciado', 'separado' => 'Separado', 'amasiado' => 'Amasiado', 'viúvo' => 'Viúvo', ],
                                'options' => ['placeholder' => 'Select ...'],
                                'pluginOptions' => ['allowClear'=>true, 'width'=>'100%'],
                            ]
                        ],
                        [
                            'attribute'=>'genero',
                            'format'=>'raw',
                            'value'=>$pessoais__genero == 'F' ? '<span class="label label-danger">Feminino</span>' : '<span class="label label-primary">Masculino</span>',
                            'type'=>DetailView2::INPUT_SWITCH,
                            'widgetOptions' => [
                                //'data'=>  [ 'M' => 'Masculino', 'F' => 'Feminino', ],
                                'pluginOptions' => [
                                    'onText' => '<i class="fas fa-venus"></i> Femin.',
                                    'offText' => '<i class="fas fa-mars"></i> Mascul.',
                                    'onColor' => 'danger',
                                    'offColor' => 'primary',
                                ]
                            ],
                        ],
                        [
                            'attribute'=>'nacionalidade',
                            'format'=>'raw',
                            'value'=>$pessoais__nacionalidade == 'brasileiro' ? '<span class="label label-success">Brasileiro</span>' : '<span class="label label-warning">Estrangeiro</span>',
                            'type'=>DetailView2::INPUT_SWITCH,
                            'widgetOptions' => [
                                //'data'=>  [ 'M' => 'Masculino', 'F' => 'Feminino', ],
                                'pluginOptions' => [
                                    'onText' => 'Estrangeiro',
                                    'offText' => 'Brasileiro',
                                    'onColor' => 'warning',
                                    'offColor' => 'success',
                                ]
                            ],
                        ],
                        'extrangeiro_temponopais',
                        'numero_dependentes',
                        'nome_pai',
                        'nome_mae',
                        'email:email',
                    ],
                    'formOptions' => ['action' => ['updpessoa','id'=>$pessoais->id]]
                ]);


                echo Collapse::widget([
                    'items' => [
                        [
                            'label' => '#1 Informações Pessoais e Profissionais',
                            'content' => '<div class="col-md-6">'.$detailInfoPessoal.'</div>'.
                                        '<div class="col-md-6">'.$detailInfoProfissional.'</div>',
                            'contentOptions' => ['class' => 'off'],
                        ],
                        [
                            'label' => '#2 Informações Documentais',
                            'content' => '<div class="col-md-6">'.$detailInfoDocumental.
                                         '</div>'.
                                         '<div class="col-md-6">'.$detailInfoRefbancaria.
                                         '</div>',
                            'contentOptions' => ['class' => 'off']
                        ],
                        $item_conjuje,
                        [
                            'label' => '#4 Onde mora atualmente',
                            'content' => '<div class="col-md-12">'.$detailMoratual.
                                         '</div>',
                            'contentOptions' => ['class' => 'off']
                        ],
                        $item_ocupante,
                    ]
                ]);
            ?>
            <div class="clearfix col-md-12"></div>
            <?php
                Modal::begin([
                    'header' => '<h2>Novo Morador</h2>',
                    'toggleButton' => [
                        'label' => 'Cadastratar novo Ocupante',
                        'class' => 'btn'
                    ],
                ]);

                $novo_ocupante = new app\models\SloOcupante;

                echo $this->render('_form_novo_ocupante', [
                    'model' => $novo_ocupante,
                    'pretendente_id' => $model->id,
                    'proposta_id' => $model->proposta->id,
                ]);

                Modal::end();
            ?>
        </div>

        <!-- Botões Para os Documentos  -->
        <div class="col-md-12">
            <div class="col-md-6">
                <h3>Documentação - Fotos (<?= $documentais->tipo_documento ?>)</h3>
                <hr>
                <div class="col-md-6">
                    <?php
                        if(!empty($documentais->frente_documento)):
                            /* Antiga visualização da Imagem dentro do botão
                                '<br>
                                    <embed src="'.Yii::$app->homeUrl.'uploads/propostasdocs/'.$documentais->id.'_frentdoc_'.$documentais->frente_documento.'"
                                        style="width:95%;height:150px;border-radius: 10px;"/>'.
                            */
                            $pasta = Yii::$app->homeUrl.'uploads/propostasdocs/'.$documentais->id.'_frentdoc_';
                            $doc = $documentais->frente_documento;
                            $ext = substr($doc, -3);
                            $pdf_estilo = '';
                            if ($ext == 'pdf' or $ext == 'doc') {
                                $label_bt = '<i class="fas fa-file-pdf" style="font-size: 50px"></i>';
                                $pdf_estilo = 'width: 100%;height:500px;';
                            }else{
                                $label_bt = '<embed style="max-width:100%;height:100px" type="" src="'.$pasta.$doc.'"></embed>';
                            }
                            Modal::begin([
                                'header' => '<h2>Frente do Documento ('.$documentais->tipo_documento.')</h2>',
                                'toggleButton' => [
                                    'label' => '<strong>Frente do Documento</strong> <hr>'.$label_bt,
                                    'class' => 'btn',
                                    'style' =>  'width: 100%',
                                ],
                            ]);
                            $extencao = substr($documentais->frente_documento, strpos($documentais->frente_documento, ".") + 1);
                            $retVal = ($extencao == 'pdf') ? 'min-height: 500px;' : '' ;
                            echo '<embed src="'.$pasta.$doc.'" style="width:100%;height:auto;'.$retVal.'"/>';

                            Modal::end();
                        endif;
                    ?>
                </div>
                <div class="col-md-6">
                    <?php
                        if(!empty($documentais->verso_documento)):

                            $pasta = Yii::$app->homeUrl.'uploads/propostasdocs/'.$documentais->id.'_versodoc_';
                            $doc = $documentais->verso_documento;
                            $ext = substr($doc, -3);
                            $pdf_estilo = '';
                            if ($ext == 'pdf' or $ext == 'doc') {
                                $label_bt = '<i class="fas fa-file-pdf" style="font-size: 50px"></i>';
                                $pdf_estilo = 'width: 100%;height:500px;';
                            }else{
                                $label_bt = '<embed style="max-width:100%;height:100px" type="" src="'.$pasta.$doc.'"></embed>';
                            }
                            Modal::begin([
                                'header' => '<h2>Verso do Documento ('.$documentais->tipo_documento.')</h2>',
                                'toggleButton' => [
                                    'label' => '<strong>Verso do Documento</strong> <hr>'.$label_bt,
                                    'class' => 'btn',
                                    'style' =>  'width: 100%',
                                ],
                            ]);
                            $extencao = substr($documentais->verso_documento, strpos($documentais->verso_documento, ".") + 1);
                            $retVal = ($extencao == 'pdf') ? 'min-height: 500px;' : '' ;
                            echo '<embed src="'.Yii::$app->homeUrl.'uploads/propostasdocs/'.$documentais->id.'_versodoc_'.$documentais->verso_documento.'"
                                                    style="width:100%;height:auto;'.$retVal.'"/>';

                            Modal::end();
                        endif;
                    ?>
                </div>
            </div>
            <div class="col-md-6">
                <h3>Documentação: Outros Comprovantes</h3>
                <hr>
                <?php
                    if(!empty($documentais->outros_comprovantes)){
                        $outros_comprovantes = explode(';', substr($documentais->outros_comprovantes, 0, -1));
                        $pasta = Yii::$app->homeUrl.'uploads/propostasdocs/'.$documentais->id.'_outroscomprovantes_';
                        foreach ($outros_comprovantes as $doc) {
                            echo "<div class='col-md-3' style='padding: 1px'>";
                            $ext = substr($doc, -3);
                            $pdf_estilo = '';
                            if ($ext == 'pdf' or $ext == 'doc') {
                                $label_bt = '<i class="fas fa-file-pdf" style="font-size: 50px"></i>';
                                $pdf_estilo = 'width: 100%;height:500px;';
                            }else{
                                $label_bt = '<embed style="max-width:100%;height:50px" type="" src="'.$pasta.$doc.'"></embed>';
                            }
                            Modal::begin([
                                'header' => '<h2>Documento/Comprovante ('.$documentais->tipo_documento.')</h2>',
                                'toggleButton' => [
                                    'label' => $label_bt,
                                    'class' => 'btn',
                                    'style' =>  'width: 100%;height: 75px;',
                                ],
                            ]);
                            $extencao = substr($doc, strpos($doc, ".") + 1);
                            $retVal = ($extencao == 'pdf') ? 'min-height: 500px;' : '' ;
                            echo '<embed src="'.$pasta.$doc.'" style="width:100%;height:auto;'.$retVal.'"/>';

                            Modal::end();
                            echo "</div>";
                        }
                    }
                ?>
           </div>
        </div>
        <div class="col-md-12 clearfix"><br></div>
        <div class="col-md-12">
            <div class="col-md-12">
                <?php
                    Modal::begin([
                        'header' => '<h2>Imprimir Documento</h2>',
                        'size'=>'modal-lg',
                        'toggleButton' => [
                            'label' => 'Imprimir todos os Registros (PDF)',
                            'class' => 'btn',
                            'style' =>  'width: 100%',
                        ],
                    ]);

                    echo '<embed src="'.Yii::$app->homeUrl.'pretendente/report?id='.$model->id.'&proposta_id='.$model->proposta_id.'" style="width:100%;height:auto;min-height: 500px;" />';

                    Modal::end();
                ?>
            </div>
        </div>
        <div class="col-md-12 clearfix"><hr></div>
        <p>
            <?php //= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Excluir', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'style' => 'float:right',
                'data' => [
                    'confirm' => 'Deseja realmente exlcuir esse item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    </div>
    <style type="text/css">
        #chat-msg {
            background-color: whitesmoke;
            position: fixed;
            right: 5px;
            bottom: 0;
            padding: 10px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        #chat-msg label{
            width: 100%;
            background: ghostwhite;
            text-align: center;
            padding: 5px;
            margin-bottom: 0;
            /*border-top-left-radius: 10px;
            border-top-right-radius: 10px;*/
        }
        #chat-msg textarea{
            width: 100% !important;
            border: 5px solid !important;
            border-color: ghostwhite !important;
            text-transform: none !important;
            /*border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;*/
        }
        #chat-msg a:hover, #chat-msg a:focus {
            color: #23527c;
            text-decoration: none!important;
            font-weight: bolder;
        }
        #chat-msg .panel-heading {
            text-align: center;
        }
        #chat-msg .btn-success {
            color: gray;
            background-color: lightgray;
            border-color: lightgray;
        }
        #historico-div {
            overflow-y: auto;
            height: 300px;
            border: 5px solid ghostwhite;
            border-top-left-radius: 10px;
            background-color: ghostwhite;
        }
        .balao-1 {
            background-color: var(--cor-bg-elementos);
            margin: 5px;
            padding: 10px;
            border-radius: 10px;
            width: 80%;
            float: right;
            color: white;
            font-style: italic;
            padding-top: 20px;
        }
        .balao-2 {
            background-color: var(--cor-bg-fundo);
            margin: 5px;
            padding: 10px;
            padding-top: 20px;
            border-radius: 10px;
            width: 80%;
            float: left;
            color: white;
            font-style: italic;
        }
        .data-msg{
            float: left;
            position: relative;
            top: -7px;
        }
        .collapse-toggle {
            text-transform: capitalize;
        }
    </style>
    <?php
        echo "<div class='col-md-4 float-right' style='' id='chat-msg'>";
        $mensagem = new app\models\Mensagem;

        $conversa = app\models\Mensagem::find()->where([
            'slo_pretendente_id'=>$model->id
        ])->orderBy(['data' => SORT_ASC])->all();

        $historico = '<div id="historico-div" class="col-md-12">';
        if (count($conversa) > 0) {
            $historico .= '';
            foreach ($conversa as $row) {

                $balao = ($row->usuario_id != '') ? '1' : '2' ;

                $historico .= '<div class="col-md-12 balao-'.$balao.'">';
                $historico .= '<sup class="data-msg">'.$row->data.'</sup>';
                $historico .= '<span>'.$row->texto.'</span>';
                $historico .= '</div>';
                $historico .= '<div class="clearfix"></div>';

            }
            $historico .= '<hr>';
        }

        $historico .= '</div>';

        echo Collapse::widget([
            'items' => [
                [
                    'label' => 'Chat com o Cliente: '.$pessoais->nome,
                    'content' => $historico.$this->render('/mensagem/_form', [
                            'model' => $mensagem,
                            'pretendente_id' => $model->id,
                            'usuario_id' => Yii::$app->user->identity->id,
                            'ativo' => 'admin'
                        ]),

                ]
            ]
        ]);
        echo "</div>";
        $this->registerJS('
            $(".comment-form").on(\'beforeSubmit\', function () {
                var data = $(this).serializeArray();
                var url = $(this).attr(\'action\');
                $.ajax({
                    url: url,
                    type: \'post\',
                    dataType: \'json\',
                    data: data,
                    beforeSend: function(){
                        $("#bota-submit-nisso").html("Enviando...");
                    },
                    success: function(data){
                        setInterval(function(){ $("#bota-submit-nisso").html("Enviar") },1000);
                    }
                })
                .done(function(response) {
                    if (response.data.success == true) {
                        console.log("Wow you commented");
                        $("#mensagem-texto").val("");
                        $("#historico-div").html(response.data.message);
                        var objDiv = document.getElementById("historico-div");
                        objDiv.scrollTop = objDiv.scrollHeight;
                    }
                })
                .fail(function() {
                    console.log("error");
                });
                return false;
            });

            setInterval(function(){
                var formulario = $(".comment-form");
                // var data = formulario.serializeArray();
                var url = "'.Yii::$app->homeUrl.'mensagem/ajaxcommentadmin";
                $.ajax({
                    url: url,
                    type: \'post\',
                    // dataType: \'json\',
                    data: {
                        "pretendente_id" : "'.$model->id.'",
                        "ativo" : "admin"
                    }
                })
                .done(function(response) {
                    if (response.data.success == true) {
                        $("#historico-div").html(response.data.message);
                        // var objDiv = document.getElementById("historico-div");
                        // objDiv.scrollTop = objDiv.scrollHeight;
                    }
                })
                .fail(function() {
                    console.log("error");
                });
            }, 5000);
        ');
        // USAR ID DO PRETENTENDE PRA IDENTIFICAR A RESPOSTA DO USUÁRIO ADMIN DO SISTEMA
        // IDEIA: criar função a ser chamada via AJAX que atualize a Div de histórico a cada 5 segundos
        // NÃO usar o formulário vigente
    ?>
