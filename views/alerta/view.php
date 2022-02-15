<?php

use app\models\Usuario;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SaAlerta */

// $this->title = $model->titulo;
// $this->params['breadcrumbs'][] = ['label' => 'Sa Alertas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;

?>
<div class="sa-alerta-view">

    <!-- <h3><?php //= Html::encode($this->title) 
                ?></h3> -->

    <?php /*= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'titulo',
            'descricao:ntext',
            'envio',
            'usuario_id',
            'sa_pendencia_id',
            'data_criacao',
        ],
    ]) */ ?>

    <div class='col-md-12 dashbord dashbord-green'>
        <div class='icon-section' style="padding: 0 10px 10px 10px;">
            <?php if($ativo): ?>
            <a href="<?= Yii::$app->homeUrl . "alerta/dispara?id=" . $model->id ?>" title="Enviar Alerta por Email">
                <i class='fa fa-bell' aria-hidden='true'></i>
            </a>
            <?php else: ?>
                <i class='fa fa-bell' aria-hidden='true' style="color: white !important"></i>
            <?php endif; ?>

            <!-- <a href="#" title="Enviar Alerta por SMS"><i class='fa fa-phone' aria-hidden='true'></i></a> -->
            <h2><strong><?= $model->titulo ?></strong></h2>
            <h3><strong><?= date('d/m/Y', strtotime($model->data_criacao)) . ' - '.date('d/m/Y', strtotime($model->data_limite)).' <br>' ?></strong></h3>
            <h4>Categoria: <?=$model->categoria?></h4>
            <h4>Pretendente: <?=$model->pretendente?></h4>
            <p><?= $model->descricao ?></p>
        </div>
    </div>
    <div class="clearfix"></div>
    <br />
    <div class="col-md-12">
        <h4>
            <center><strong>Usuários Alertados</strong></center>
        </h4>
        <hr>
        <?php foreach ($model->saAlertausuarios as $us) : ?>
            <?php $user = Usuario::findOne(['id' => $us->usuario_id]); ?>
            <div class="col-md-3">
                <img src="<?= Yii::$app->homeUrl . 'usuarios/' . $user->foto ?>" alt="" height="50">
                <br />
                <label for=""><?= $user->nome ?></label>
                <?php $pretendente = \app\models\SloPretendente::findOne(['pret_user' => $user->id]); ?>
                <?php if (count($pretendente) > 0) : ?>
                    <?php
                        $fone = $pretendente->sloInfospessoais->celular; # '99991642468';
                        $mensagem = "{$model->titulo}, {$model->categoria}: {$model->descricao}";
                    ?>
                    <!-- <a class="btn btn-success" href="https://api.whatsapp.com/send?phone=<?=$fone?>&text=<?=$mensagem?>" target="_blanck" title="Enviar Alerta por Whats">
                        Cliente <i class='fa fa-whatsapp' style="font-size: 14px" aria-hidden='true'></i>
                    </a> -->
                    <a class="btn btn-success" href="<?=Yii::$app->homeUrl."alerta/sendwhats?msg=$mensagem&num=$fone"?>" title="Enviar Alerta por Whats">
                        Cliente <i class='fa fa-whatsapp' style="font-size: 14px" aria-hidden='true'></i>
                    </a> 
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="clearfix"></div>
</div>