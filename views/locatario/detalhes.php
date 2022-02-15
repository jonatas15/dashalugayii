<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
?>
<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            // 'nome',
            // 'contato',
            // 'codigo_do_imovel',
            // 'logradouro',
            'numero_do_apartamento',
            'numero_do_box',
            'inicio_da_locacao',
            'mais_informacoes:ntext',
            // 'proprietario.nome',
            // 'proprietario_mes_referencia_id',
        ],
    ]); 
?>