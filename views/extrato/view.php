<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Extrato */

// $this->title = $model->mes;
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Extratos'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="extrato-view">

    <h3><center><?= Html::encode($model->mes) ?></center></h3>
    <?php /*
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    */ ?>
    <div class="col-md-6">
        <h4>Informações</h4>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                // 'id',
                'proprietario.nome',
                'locatario.nome',
                'base.codigo',
                'base.logradouro',
                'base.valor',
                'mes',
                [
                    'attribute'=>'data_aplicacao',
                    'value'=> Yii::$app->formatter->asDate($model->data_aplicacao,'dd/M/Y'),
                ],
                [
                    'attribute'=>'data_vencimento',
                    'value'=> Yii::$app->formatter->asDate($model->data_vencimento,'dd/M/Y'),
                ],
                'nosso_numero',
                'numero_nota',
                // 'descricao_descontos',
                [
                    'attribute'=>'data_pagamento',
                    'value'=> Yii::$app->formatter->asDate($model->data_pagamento,'dd/M/Y'),
                ],
            ],
        ]) ?>
    </div>
    <div class="col-md-6">
        <h4>Valores</h4>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                // 'id',
                [
                    'attribute'=>'receita_locacao',
                    'value'=> function($data){
                        return 'R$ ' . number_format($data->receita_locacao, 2, ',', '.');
                    }
                ],
                [
                    'attribute'=>'receitas_subtotal',
                    'value'=> function($data){
                        return 'R$ ' . number_format($data->receitas_subtotal, 2, ',', '.');
                    }
                ],
                [
                    'attribute'=>'iptu',
                    'value'=> function($data){
                        return 'R$ ' . number_format($data->iptu, 2, ',', '.');
                    }
                ],
                [
                    'attribute'=>'iptu_apt_garag',
                    'value'=> function($data){
                        return 'R$ ' . number_format($data->iptu_apt_garag, 2, ',', '.');
                    }
                ],
                [
                    'attribute'=>'condominio',
                    'value'=> function($data){
                        return 'R$ ' . number_format($data->condominio, 2, ',', '.');
                    }
                ],
                [
                    'attribute'=>'taxa_condominio',
                    'value'=> function($data){
                        return 'R$ ' . number_format($data->taxa_condominio, 2, ',', '.');
                    }
                ],
                [
                    'attribute'=>'outros',
                    'value'=> function($data){
                        return 'R$ ' . number_format($data->outros, 2, ',', '.');
                    }
                ],
                [
                    'attribute'=>'total',
                    'value'=> function($data){
                        return 'R$ ' . number_format($data->total, 2, ',', '.');
                    }
                ],
                [
                    'attribute'=>'valor_pago_ao_proprietario',
                    'value'=> 'R$ ' . number_format($model->valor_pago_ao_proprietario, 2, ',', '.')
                ],
                [
                    'attribute'=>'honorarios_porcentagem',
                    'value'=> function($data){
                        return 'R$ ' . number_format($data->honorarios_porcentagem, 2, ',', '.');
                    }
                ],
                [
                    'attribute'=>'honorarios_valor',
                    'value'=> function($data){
                        return 'R$ ' . number_format($data->honorarios_valor, 2, ',', '.');
                    }
                ],
                [
                    'attribute'=>'honorarios_admin',
                    'value'=> function($data){
                        return 'R$ ' . number_format($data->honorarios_admin, 2, ',', '.');
                    }
                ],
                [
                    'attribute'=>'descontos_subtotal',
                    'value'=> function($data){
                        return 'R$ ' . number_format($data->descontos_subtotal, 2, ',', '.');
                    }
                ],
                [
                    'attribute'=>'total_depositado',
                    'value'=> function($data){
                        return 'R$ ' . number_format($data->total_depositado, 2, ',', '.');
                    }
                ],
            ],
        ]) ?>
    </div>
</div>
