<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

use app\models\Imobiliarias;
use app\models\Condominio;

/* @var $this yii\web\View */
/* @var $model app\models\Imoveisexternos */

$this->title = $model->codigo;
$this->params['breadcrumbs'][] = ['label' => 'Imoveisexternos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="imoveisexternos-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <hr>
    
    <div class="col-md-12">
        <div class="col-md-6">          
        <?php 
        $imagens = $this->context->ProcurarImagensNoHTML($model->url_imovel);
        if ($imagens) {
            echo '<div class="col-md-12">';
            foreach ($imagens as $key => $value) {
                echo '<div class="col-md-6" >';
                echo '<img src="'.$value['src'].'" style="width:100%;margin:2%;border:1px solid lightgray; border-radius: 5px;"/>';
                echo '</div>';
            }
            echo '</div>';  
        }
        ?>
        </div>
        <div class="col-md-6">  
        <?php

            $medida = 'm²';
            $area_privativa = $model->area_privativa;
            
            if ($model->area_privativa < 10) {
                $medida = 'ha';
            }
            if ($model->area_privativa < 100 and in_array($model->tipo, ['Terreno','Campo','Imóvel Indefinido'])) {
                $medida = 'ha';
            }
            if ($model->area_privativa >= 10000) {
                $area_privativa = $model->area_privativa/10000;
                $medida = 'ha';
            }
            if ($model->area_privativa > 0) {
                $area_model = number_format($area_privativa, 2, ',', '.')." $medida";
            }else{
                $area_model = 'Consulte';
            }

            use kartik\detail\DetailView as DetailView2;
            echo DetailView2::widget([
                'model'=>$model,
                'condensed'=>true,
                'hover'=>true,
                'mode'=>DetailView2::MODE_VIEW,
                'panel'=>[
                    'heading'=>'Código: ' . $model->id,
                    'type'=>DetailView2::TYPE_INFO,
                ],
                'attributes'=>[
                    [
                        'attribute'=>'imobiliarias_id',
                        'format'=>'raw',
                        'value'=>$model->imobiliarias->nome,
                        'type'=>DetailView2::INPUT_SELECT2, 
                        'widgetOptions'=>[
                            'data'=>ArrayHelper::map(Imobiliarias::find()->orderBy('nome')->asArray()->all(), 'id', 'nome'),
                            'options' => ['placeholder' => 'Select ...'],
                            'pluginOptions' => ['allowClear'=>true, 'width'=>'100%'],
                        ]
                    ],
                    'url_imovel:url',
                    'codigo',
                    // 'tipo',
                    [
                        'attribute'=>'tipo',
                        'format'=>'raw',
                        'value'=>$model->tipo,
                        'type'=>DetailView2::INPUT_SELECT2, 
                        'widgetOptions'=>[
                            'data'=>$model->tipos,
                            'options' => ['placeholder' => 'Select ...'],
                            'pluginOptions' => ['allowClear'=>true, 'width'=>'100%'],
                        ]
                    ],
                    [
                        'attribute'=>'contrato',
                        'format'=>'raw',
                        'value'=>$model->contrato,
                        'type'=>DetailView2::INPUT_SELECT2, 
                        'widgetOptions'=>[
                            'data'=>['Venda/Locação'=>'Venda/Locação','Venda'=>'Venda','Locação'=>'Locação'],
                            'options' => ['placeholder' => 'Select ...'],
                            'pluginOptions' => ['allowClear'=>true, 'width'=>'100%'],
                        ]
                    ],
                    [
                        'attribute'=>'valor_venda',
                        'format'=>'raw',
                        'value'=> $model->valor_venda > 0 ? 'R$ '.number_format($model->valor_venda, 2, ',', '.') : 'Consulte'
                    ],
                    // 'valor_venda',
                    // 'endereco_estado',
                    // 'endereco_cidade',
                    // 'endereco_bairro',
                    [
                        'attribute'=>'endereco_bairro',
                        'format'=>'raw',
                        'value'=>$model->endereco_bairro,
                        'type'=>DetailView2::INPUT_SELECT2, 
                        'widgetOptions'=>[
                            'data'=>$model->bairros,
                            'options' => ['placeholder' => 'Select ...'],
                            'pluginOptions' => ['allowClear'=>true, 'width'=>'100%'],
                        ]
                    ],
                    'endereco_logradouro',
                    // 'dormitorios',
                    [
                        'attribute'=>'dormitorios',
                        'format'=>'raw',
                        'value'=>$model->dormitorios,
                        'type'=>DetailView2::INPUT_SLIDER, 
                        'widgetOptions'=>[
                            'sliderColor'=>'orange',
                            'pluginOptions'=>['min'=>0,'max'=>10,'step'=>1,'handle'=>'square']
                        ]
                    ],
                    [
                        'attribute'=>'banheiros',
                        'format'=>'raw',
                        'value'=>$model->banheiros,
                        'type'=>DetailView2::INPUT_SLIDER, 
                        'widgetOptions'=>[
                            'sliderColor'=>'orange',
                            'pluginOptions'=>['min'=>0,'max'=>10,'step'=>1,'handle'=>'square']
                        ]
                    ],
                    [
                        'attribute'=>'garagens',
                        'format'=>'raw',
                        'value'=>$model->garagens,
                        'type'=>DetailView2::INPUT_SLIDER, 
                        'widgetOptions'=>[
                            'sliderColor'=>'orange',
                            'pluginOptions'=>['min'=>0,'max'=>10,'step'=>1,'handle'=>'square']
                        ]
                    ],
                    // 'banheiros',
                    // 'garagens',
                    // 'elevador',
                    // 'sacada',
                    [
                        'attribute'=>'elevador', 
                        'label'=>'Elevador',
                        'format'=>'raw',
                        'value'=>$model->elevador ? '<span class="label label-success">Sim</span>' : '<span class="label label-danger">Não</span>',
                        'type'=>DetailView2::INPUT_SWITCH,
                        'widgetOptions' => [
                            'pluginOptions' => [
                                'onText' => 'Sim',
                                'offText' => 'Não',
                            ]
                        ],
                    ],
                    [
                        'attribute'=>'sacada', 
                        'label'=>'Sacada',
                        'format'=>'raw',
                        'value'=>$model->sacada ? '<span class="label label-success">Sim</span>' : '<span class="label label-danger">Não</span>',
                        'type'=>DetailView2::INPUT_SWITCH,
                        'widgetOptions' => [
                            'pluginOptions' => [
                                'onText' => 'Sim',
                                'offText' => 'Não',
                            ]
                        ],
                    ],
                    // 'area_privativa',
                    [
                        'attribute'=>'area_privativa',
                        'format'=>'raw',
                        'value'=> $area_model
                    ],
                    // 'area_total',
                    'comodidades:ntext',
                    // 'condominio',
                    [
                        'attribute'=>'condominio',
                        'format'=>'raw',
                        'value'=>$model->condominio,
                        'type'=>DetailView2::INPUT_SELECT2, 
                        'widgetOptions'=>[
                            'data'=> $condominios,
                            'options' => ['placeholder' => 'Select ...'],
                            'pluginOptions' => ['allowClear'=>true, 'width'=>'100%'],
                        ]
                    ],
                    [
                        'attribute'=>'financiavel', 
                        'label'=>'Financiável?',
                        'format'=>'raw',
                        'value'=>$model->financiavel ? '<span class="label label-success">Sim</span>' : '<span class="label label-danger">Não</span>',
                        'type'=>DetailView2::INPUT_SWITCH,
                        'widgetOptions' => [
                            'pluginOptions' => [
                                'onText' => 'Sim',
                                'offText' => 'Não',
                            ]
                        ],
                    ],
                    [
                        'attribute'=>'negociavel', 
                        'label'=>'Negociável?',
                        'format'=>'raw',
                        'value'=>$model->negociavel ? '<span class="label label-success">Sim</span>' : '<span class="label label-danger">Não</span>',
                        'type'=>DetailView2::INPUT_SWITCH,
                        'widgetOptions' => [
                            'pluginOptions' => [
                                'onText' => 'Sim',
                                'offText' => 'Não',
                            ]
                        ],
                    ],
                    [
                        'attribute'=>'aceita_permuta', 
                        'label'=>'Aceita Permuta?',
                        'format'=>'raw',
                        'value'=>$model->aceita_permuta ? '<span class="label label-success">Sim</span>' : '<span class="label label-danger">Não</span>',
                        'type'=>DetailView2::INPUT_SWITCH,
                        'widgetOptions' => [
                            'pluginOptions' => [
                                'onText' => 'Sim',
                                'offText' => 'Não',
                            ]
                        ],
                    ],
                    ['attribute'=>'observacoes', 'type'=>DetailView2::INPUT_TEXTAREA],
                    // 'data_cadastro',
                    // 'data_alteracao',
                    // ['attribute'=>'data_cadastro', 'type'=>DetailView2::INPUT_DATE],
                ],
                'formOptions' => ['action' => ['update','id'=>$model->id]]
            ]);
        ?>
        </div>

    </div>
    <p>
        <?php //= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Excluir', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            // 'style' => 'float:right',
            'data' => [
                'confirm' => 'Deseja realmente excluir esse registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
