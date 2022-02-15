<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="usuario-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="col-md-4">
        <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'tipo')->dropDownList([ 
            'admin' => 'Admin', 
            'corretor' => 'Corretor', 
            'vendas' => 'Vendas', 
            'locacao' => 'Locação', 
            'cliente' => 'Cliente', 
        ],
        ['prompt' => '']) ?>
        
        <?= $form->field($model, 'username')->textInput(['maxlength' => true,'autocomplete' => 'new-username']) ?>
        <?php if(!$model->isNewRecord): ?>
        <div class="form-group field-usuario-email">
            <label class="control-label" for="usuario-email">Nova Senha?</label>
            <input type="password" name="nova_senha" id="nova_senha" class="form-control" placeholder="Deixe vazio caso não queira modificar" autocomplete = "new-password">
            <div class="help-block"></div>
        </div>   
        <?php else: ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true,'autocomplete' => 'new-password']) ?>
        <?php endif; ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'email')->textInput() ?>
        <?= $form->field($model, 'mais_informacoes')->textarea(['rows' => 5]) ?>
    </div>
    <div class="col-md-4">
        <?php //= $form->field($model, 'foto')->textInput(['maxlength' => true]) ?>
        <?php if(!$model->isNewRecord): ?>
        <div class="col-md-12" style="text-align:center">
        <?= Html::img(Yii::$app->homeUrl.'usuarios/'.$model->foto, ['width' => '200']);?>
        <hr>
        </div>
        <?php endif; ?>
        <div class="col-md-12" style="text-align:center">
        <?= $form->field($model, 'arquivoimagem')->fileInput() ?>
        </div>
    </div>
    <div class="col-md-12 form-group">
    <hr>
        <?= Html::submitButton($model->isNewRecord ? 'Salvar Usuário' : 'Atualizar Usuário', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','style'=>"float:right"]) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>