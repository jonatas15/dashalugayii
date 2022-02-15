<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use app\models\Corretor;
use app\models\SloCliente as Cliente;

use kartik\widgets\TimePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\SloAgenda */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slo-agenda-form" style="text-align: left">

    <?php $form = ActiveForm::begin([
      'action'=> $model->isNewRecord ? Yii::$app->homeUrl.'/sloagenda/create' : Yii::$app->homeUrl.'/sloagenda/update?id='.$prefixo_id
    ]); ?>

    <?php //= $form->field($model, 'slo_cliente_id')->textInput() 
    $clientes = ArrayHelper::map(Cliente::find()->asArray()->all(), 'id','nome');
    ?>
    <div class="col-md-6">
        <input type="hidden" name="indice" value="<?=$i?>">
        <div class="form-group field-cyber-o_cliente">
              <label class="control-label" for="<?=$i?>-o_cliente">Nome do Cliente</label>
              <?= Select2::widget([
                'data' => $clientes,
                'name' => $i.'-o_cliente',
                'value' => $model->slo_cliente_id,
                'language' => 'pt',
                'options' => [
                    'placeholder' => 'Digite ou selecione',
                    'multiple' => false
                ],
                'pluginOptions' => [
                    'tags'=>true,
                    'allowClear' => true,
                ],
            ]); 
            ?>
        </div>
    </div>
    <?php //= $form->field($model, 'corretor_idcorretor')->textInput() 
        $corretores = ArrayHelper::map(Corretor::find()->asArray()->all(), 'idcorretor','nome');
    ?>
    <div class="col-md-6">
        <div class="form-group field-cyber-o_corretor">
            <label class="control-label" for="<?=$i?>-o_corretor">Nome do Corretor</label>
            <?php if(Yii::$app->user->can('corretor')): ?>
                <?php
                    $corretor_logado = Corretor::find()->where(['usuario_id' => Yii::$app->user->identity->id])->one();
                ?>
                <input type="hidden" name="<?= $i.'-o_corretor' ?>" value="<?= $corretor_logado->idcorretor ?>" />
                <input type="text" name="nada" value="<?= $corretor_logado->nome ?>" disabled="disabled" class="form-control" />
                <div class="help-block"></div>            
            <?php else: ?>
              <?= Select2::widget([
                'data' => $corretores,
                'name' => $i.'-o_corretor',
                'language' => 'pt',
                'options' => [
                    'placeholder' => 'Digite ou selecione',
                    'multiple' => false
                ],
                'pluginOptions' => [
                    'tags'=>true,
                    'allowClear' => true,
                ],
            ]); ?>
            <?php endif; ?> 
            
        </div>
    </div>
    <div class="col-md-6">
        <?php //= $form->field($model, 'imovel')->textInput(['maxlength' => true]) ?>
        <?php //= $form->field($model, 'slo_cliente_id')->textInput() 
        $propostas = ArrayHelper::map(\app\models\SloProposta::find()->asArray()->all(), 'id','codigo_imovel');
        ?>
        <input type="hidden" name="indice" value="<?=$i?>">
        <div class="form-group field-cyber-o_cliente">
              <label class="control-label" for="<?=$i?>-a_proposta">Proposta</label>
              <?= Select2::widget([
                'data' => $propostas,
                'name' => $i.'-a_proposta',
                'value' => $model->slo_proposta_id,
                'language' => 'pt',
                'options' => [
                    'placeholder' => 'Digite ou selecione',
                    'multiple' => false
                ],
                'pluginOptions' => [
                    'tags'=>false,
                    'allowClear' => true,
                ],
            ]); 
            ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group field-visita-id_corretor has-success">
            <?php //= $form->field($model, 'data_visita')->textInput()
                echo '<label class="control-label">Hora</label>';
                echo TimePicker::widget([
                    'name' => 'SloAgenda[hora]',
                    // 'type' => TimePicker::TYPE_COMPONENT_APPEND,
                    'value' => '',
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'HH:ii',
                        'showSeconds' => true,
                        'showMeridian' => false,
                        'minuteStep' => 1,
                        'secondStep' => 5,
                    ]
                ]);
            ?>
            <div class="help-block"></div>
        </div>
    </div>
    
    <?php //= $form->field($model, 'hora')->textInput() ?>
    <div class="col-md-12">
        <?= $form->field($model, 'mais_informacoes')->textarea(['rows' => 6]) ?>
    </div>

    <div style="display: none">
        <?= $form->field($model, 'usuario_id')->textInput(['value' => Yii::$app->user->identity->id]) ?>
        <?= $form->field($model, 'data')->textInput(['value'=>$data1]) ?>
        <?php //$form->field($model, 'slo_proposta_id')->textInput(['value'=>1]) ?>
        <?= $form->field($model, 'turno')->textInput(['value'=>$turno]); //dropDownList([ 'manhã' => 'Manhã', 'tarde' => 'Tarde', 'noite' => 'Noite', ], ['prompt' => '']) ?>
    </div>

    <div class="form-group col-md-12">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <div class='clearfix'></div>
</div>
