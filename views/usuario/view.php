<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Usuários', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-view">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <hr>
    <div class="col-md-3">
        <?=Html::img(Yii::$app->homeUrl.'usuarios/'.$model->foto, ['width' => '200']);?>
    </div>
    <div class="col-md-6">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'nome',
            'email',
            'tipo',
            'username',
            // 'password',
            'mais_informacoes:ntext',
            // 'foto',
        ],
    ]) ?>
    </div>
    <div class="col-md-12">
    <hr>
        <div style="float:right">
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Excluir', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tens certeza que deseja excluir este usuário do sistema?',
                'method' => 'post',
            ],
        ]) ?>
        </div>
    </div>

</div>
