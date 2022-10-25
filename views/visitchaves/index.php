<?php

use yii\helpers\Html;
use yii\helpers\Url;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
// use kartik\widgets\Alert;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VisitchavesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Visitas: Controle de Chaves';
$this->params['breadcrumbs'][] = $this->title;
// echo Alert::widget([
//     'type' => Alert::TYPE_SUCCESS,
//     'title' => 'Mensagem enviada!',
//     'icon' => 'fas fa-check-circle',
//     'body' => '',
//     'showSeparator' => true,
//     'delay' => false,
//     'id' => 'teste_alert',
//     'options' => [
//         'style' => 'display: none'
//     ]
// ]);
?>
<style>
    .kv-editable-value {
        color: darkblue !important;
    }
    .btn-ativa-docs {
        padding: 8% 43% !important;
        /* border-radius: 15% !important; */
        font-size: 15px !important;
        text-transform: capitalize !important;
    }
    th {
        /* font-weight: bold !important; */
        font-size: 13px !important;
    }
    select {
        background-color: white !important;
    }
    .bmd-form-group input {
        background-color: white !important;
    }
    select, select.form-control {
        -moz-appearance: auto !important;
        -webkit-appearance: auto !important;
    }
    .w2 button {
        border: 1px solid ghostwhite;
        border-radius: 5px;
        color: darkgreen;
    }
</style>
<div class="visitchaves-index col-md-12">

    <p>
        <?php //Html::a('Create Visitchaves', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="col-md-12">
        <?php // echo $this->render('_search', ['model' => $searchModel]); 

            Modal::begin([
                // 'header' => 'Nova Visita',
                'toggleButton' => [
                    'label' => '<i class="material-icons" style="font-size: 25px">key</i> | Nova Retirada',
                    'class'=>"btn btn-info",
                    'title'=>'Cadastrar Novo Registro de Visita',
                    'style'=>'float: left;margin-right: 5px;'
                ],
                'options' => [
                    'tabindex' => true
                ],
            ]);
            $model = new \app\models\visitChaves;
            echo '<div class="visitchaves-create">';
            echo $this->render('_form', [
                'model' => $model,
            ]) ;
            echo '</div>';
            echo '<div class="clearfix"></div>';
            Modal::end();
            ?>
    </div>
    <div class="clearfix">
    </div>
    <br/>
    <br/>
    <div class="col-md-12">
        <?php //Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                // 'id',
                // 'usuario_id',
                // 'nome',
                [
                    'attribute' => 'nome',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'width:20%'],
                    'value' => function ($data) {
                        return $this->context->imprime_campo_editavel('12', 'Visitchaves', 'nome', '', $data->nome, $data->id);
                    }
                ],
                [
                    'attribute' => 'tipovisitante',
                    'format' => 'raw',
                    'filter' => ['Corretor' => 'Corretor', 'Corretor externo' => 'Corretor externo', 'Cliente' => 'Cliente'],
                    'headerOptions' => ['style' => 'width:15%'],
                    'value' => function ($data) {
                        return $this->context->imprime_campo_editavel('12', 'Visitchaves', 'tipovisitante', '', $data->tipovisitante, $data->id);
                    }
                ],
                [
                    'attribute' => 'nome_cliente',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'width:20%'],
                    'value' => function ($data) {
                        return 
                        $this->context->imprime_campo_editavel('12', 'Visitchaves', 'nome_cliente', '', $data->nome_cliente, $data->id).
                        '<br/><hr style="margin: 8px">'.
                        // '<span style="position:absolute;display: block;">📞</span>'.
                        $this->context->imprime_campo_editavel('12', 'Visitchaves', 'num_disparo', '📞', $data->num_disparo, $data->id);
                    }
                ],
                [
                    'attribute' => 'codigo_imovel',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'width:5%'],
                    'value' => function ($data) {
                        return $this->context->imprime_campo_editavel('12', 'Visitchaves', 'codigo_imovel', '', $data->codigo_imovel, $data->id);
                    }
                ],
                [
                    'attribute' => 'data_visita',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'width:15%'],
                    'value' => function ($data) {
                        return 
                        $this->context->imprime_campo_editavel('12', 'Visitchaves', 'data_visita', '🗓️', $data->data_visita, $data->id).
                        '<br/><hr style="margin: 8px">'.
                        // '<span style="position:absolute;display: block;">🕒</span>' . 
                        $this->context->imprime_campo_editavel('12', 'Visitchaves', 'hora_visita', '🕒', $data->hora_visita, $data->id);
                    }
                ],
                // [
                //     'attribute' => 'hora_visita',
                //     'format' => 'raw',
                //     'headerOptions' => ['style' => 'width:3%'],
                //     'value' => function ($data) {
                //         return $this->context->imprime_campo_editavel('12', 'Visitchaves', 'hora_visita', '', $data->hora_visita, $data->id);
                //     }
                // ],
                [
                    'attribute' => 'feedbacks',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'width:25%'],
                    'value' => function ($data) {
                        return $this->context->imprime_campo_editavel('12', 'Visitchaves', 'feedbacks', '', $data->feedbacks, $data->id);
                    }
                ],
                // [
                //     'attribute' => 'num_disparo',
                //     'format' => 'raw',
                //     'headerOptions' => ['style' => 'width:3%'],
                //     'value' => function ($data) {
                //         return $this->context->imprime_campo_editavel('12', 'Visitchaves', 'num_disparo', '', $data->num_disparo, $data->id);
                //     }
                // ],
                // 'botconversaid',
                [
                    'attribute' => 'id',
                    'filter' => '',
                    'format' => 'raw',
                    'headerOptions' => ['style' => 'width:5%'],
                    'value' => function ($data) {
                        // $retorno = '<a href=""><i class="material-icons">telegram</i></a>';
                        $msg_env = '';
                        $retorno = '';
                        if ($data->msg_enviada == 1) {
                            $msg_env = '📢 Msg Enviada!';
                        }
                        if ($data->num_disparo) {
                            if ($data->botconversaid) {
                                $retorno = Html::button('<i class="material-icons">telegram</i>', ['onclick' => '
                                    $.ajax({
                                        type: "GET",
                                        url: "'.Yii::$app->homeUrl.'/visitchaves/botmensagem?id='.$data->id.'",
                                        data: {
                                            idboot: '.$data->botconversaid.'
                                        }, success: function(result) {
                                            console.log("mensagem enviada");
                                            createAutoClosingAlert(\'Mensagem enviada ao Cliente!\', 2000);
                                        }
                                    });
                                ']);
                            } else {
                                $retorno = Html::button('<i class="material-icons">telegram</i>', ['onclick' => '
                                    $.ajax({
                                        type: "PUT",
                                        url: "'.Yii::$app->homeUrl.'/api/visitakeys/update?id='.$data->id.'",
                                        data: {
                                            id: '.$data->id.',
                                            acaobotconversa: "add_subscrito",
                                            nome: "'.$data->nome_cliente.'",
                                            tipo: "add_subscrito",
                                            telefone: "'.$data->num_disparo.'",
                                            mensagem: "add_subscrito"
                                        }, success: function(result) {
                                            $.ajax({
                                                type: "GET",
                                                url: "'.Yii::$app->homeUrl.'/visitchaves/retornabot?id='.$data->id.'",
                                                data: {
                                                    id: '.$data->id.',
                                                    telefone: "'.$data->num_disparo.'"
                                                }, success: function(result) {
                                                    console.log("sucesso, subscrito: ");
                                                    console.log(result);
                                                    $.ajax({
                                                        type: "GET",
                                                        url: "'.Yii::$app->homeUrl.'/visitchaves/botmensagem?id='.$data->id.'",
                                                        data: {
                                                            idboot: '.$data->botconversaid.'
                                                        }, success: function(result) {
                                                            console.log("mensagem enviada");
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    });
                                ']);
                            }
                        }
                        return $msg_env.$retorno;
                    }
                ],
                // 'tipovisitante',
                // 'codigo_imovel',
                //'dthr_retirada',
                //'dthr_entrega',
                // 'data_visita',
                // 'hora_visita',
                // 'feedbacks:ntext',
                //'mensagem:ntext',
                // 'num_disparo',
                //'convertido_venda',

                // ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php //Pjax::end(); ?>
        <?php
            // $js = <<<JS
            // $(".doajax").on('click', function () {
            //     $.ajax({
            //         url: "{$url}",
            //         data: {id: 8},
            //         type: "get",
            //         success: function(){
            //             alert('SUCCESS');
            //         },
            //         error: function () {
            //             alert('ERROR');
            //         }
            //     });
            // });
            // JS;
            
            // $this->registerJs($js);
        ?>
    </div>
</div>
<script>
    function createAutoClosingAlert (msg,duration) {
        var el = document.createElement("div");
        el.setAttribute("style","z-index:1000000;position:fixed;top:40%;left:45%;background-color:rgba(0, 0, 0, 0.7);font-size:14px;color:yellow;font-weight: bold;padding:20px;border-radius:20px;");
        el.innerHTML = msg;
        setTimeout(function(){
        el.parentNode.removeChild(el);
        },duration);
        document.body.appendChild(el);
    }
    // createAutoClosingAlert ('Boooora eu',2000)
</script>
