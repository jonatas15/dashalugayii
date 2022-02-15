<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CyberComentario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cyber-comentario-form">
    <div style="text-align: left">
        <?php $form = ActiveForm::begin([
            'action'=> $model->isNewRecord ? Yii::$app->homeUrl.'/cybercomentario/create' : Yii::$app->homeUrl.'/cybercomentario/update?idtopico='.$prefixo_id.'&cyber_idcyber='.$model->cyber_idcyber,
        ]); ?>
        <div style="display: none">
            <?= $form->field($model, 'usuario_id')->textInput(['value'=>Yii::$app->user->identity->id]) ?>
            <?= $form->field($model, 'cyber_topico_idtopico')->textInput(['value'=>$topico_idtopico]) ?>
            <?= $form->field($model, 'cyber_idcyber')->textInput(['value'=>$cyber_idcyber]) ?>
        </div>
        <hr>
        <?= $form->field($model, 'comentario')->textarea([
            'rows' => 6,
            'style'=>'border: 1px solid lightgray;
                        // box-shadow: 5px 5px lightgray;
                        border-radius: 10px;
                        padding: 10px;
                        margin: 10px;
                        width: 99%;',
        ])->label('Comentar:') ?>
        <div style="display: none">
            <?= $form->field($model, 'datetime')->textInput(['value'=>date('Y-m-d H:i:s')]) ?>
            <?= $form->field($model, 'imagem')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'documento')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Comentar') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-info' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
