<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

use app\models\SaAlerta as Alerta;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AlertaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Alertas';
$this->params['breadcrumbs'][] = $this->title;
?>

<style media="screen">
    
</style>

<div class="sa-alerta-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr>
    <?php # p/ CASO SOLICITADO FILTRO AMPLO PELA CATEGORIA
        // $categorias = SaAlerta::find()->select('categoria')->distinct()->all();
        // $arr_categorias = [];
        // foreach ($categorias as $key => $value) {
        //     $cat = $value['categoria'];
        //     $arr_categorias[$cat] = $cat;
        // }
    ?>
    
    <!-- <hr> -->
    <p>
        <?php //= Html::a('Novo Alerta', ['create'], ['class' => 'btn btn-success'])
            $model = new Alerta();
        ?>
        <?php
        Modal::begin([
            'header' => '<h2>Novo Alerta</h2>',
            'size' => 'modal-lg',
            'options' => ['tabindex' => false ],
            'toggleButton' => [
                'label' => '<h4><i class="fa fa-bell"></i> '.' Novo Alerta</h4>',
                'class' => 'btn btn-success'
            ],
        ]);
        ?>
        <?= $this->render('_form', [
            'model' => $model,
            'modo' => 'create'
        ]) ?>
        <?php Modal::end(); ?>
    </p>

    <div class="col-md-12">

        <?php // echo $this->render('_search', ['model' => $searchModel]);
            foreach ($dataProvider->getModels() as $key => $alert) {
                echo '<!-- Alerta -->'.
                "<div class='col-md-3 dashbord dashbord-green'>
            		<div class='icon-section'>
            			<a title='Disparar Alerta' style='color: #fff' href='".Yii::$app->homeUrl."/alerta/dispara?id={$alert->id}'><i class='fa fa-bell' aria-hidden='true'></i></a><br>
            			<h3><strong>{$alert->titulo}</strong><span style='float-right'>".Html::a(' <span class="fa fa-trash"></span>', ['delete', 'id' => $alert->id], [
                            'class' => '',
                            'style' => 'color:white; float: right; left: 85%; top: 10%; position: absolute',
                            'data' => [
                                'confirm' => 'Deseja realmente excluir o Alerta "'.$alert->titulo.'"?',
                                'method' => 'post',
                            ],
                        ])."</span>";
                        
                        echo "</h3>
            			<p>".substr($alert->descricao,0, 20)."... </p>
                    </div>";
                    Modal::begin([
                        'header' => "<h2>{$alert->titulo}</h2>",
                        'size' => 'modal-lg',
                        'options' => [
                            'style' => 'color: black',
                            'tabindex' => false 
                        ],
                        'toggleButton' => [
                            'label' => '<span class="fa fa-edit"></span>',
                            'class' => '',
                            'style' => 'border: 0px !important; background-color: transparent !important; color:white; float: left; left: 8%; top: 7%; position: absolute; font-size: 30px',
                        ],
                    ]);
                    $model2 = Alerta::findOne($alert->id);
                    echo $this->render('_form', [
                        'model' => $model2,
                        'modo' => 'update?id='.$alert->id,
                        'prefixo_id' => $alert->id
                    ]);
                    Modal::end();
            		echo "<div class='detail-section'>";

                    Modal::begin([
                        'header' => "",
                        // 'size' => 'modal-lg',
                        'options' => [
                            'style' => 'color: black',
                        ],
                        'toggleButton' => [
                            'label' => 'Mais Informações',
                            'class' => 'btn btn-success',
                            'style' => 'margin: 0px; width: 100%;background: transparent;border:0px !important'
                        ],
                    ]);
                    $model2 = Alerta::findOne($alert->id);
                    echo $this->render('view', [
                        'model' => $model2,
                        'ativo' => true,
                    ]);
                    Modal::end();

                echo "</div></div>";
            }
        ?>
    </div>

    </div>

    <hr>
    <div class="clearfix">
    <?php /* = GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'titulo',
            'descricao:ntext',
            'envio',
            'usuario_id',
            // 'sa_pendencia_id',
            // 'data_criacao',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); */ ?>

    <?php
        // $this->registerJs("$(function() {
        //     $('.img_imovel').click(function(e) {
        //       e.preventDefault();
        //       $('#modal').modal('show').find('.modal-body').html('');
        //       //$('#modal').modal('show').find('.modal-header h2').html($(this).attr('title'));
        //     });
        // });");
        // Modal::begin(['id' =>'modal','header' => '<h2>Imagem Principal</h2>','options'=>['style'=>'z-index:100000']]);
        // Modal::end();
        $this->registerJs("$(function() {
            
        });");
    ?>

</div>
