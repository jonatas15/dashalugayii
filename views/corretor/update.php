<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Corretor */

$this->title =  'Atualizar dados do Corretor ' . $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Corretores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nome, ];
$this->params['breadcrumbs'][] = Yii::t('app', 'Editar');
?>
<div class="corretor-update">

    <h3><img src="<?=Yii::$app->homeUrl.'icones/corretor_b.png'?>" alt="" height="50" /><?= Html::encode($this->title) ?></h3>
    <hr>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
