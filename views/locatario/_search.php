<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Collapse;
use yii\helpers\ArrayHelper;
use app\models\Proprietario;

/* @var $this yii\web\View */
/* @var $model app\models\LocatarioSearch */
/* @var $form yii\widgets\ActiveForm */
    $items = '';
?>

<div class="locatario-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php //= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nome') ?>

    <?= $form->field($model, 'contato') ?>

    <?= $form->field($model, 'codigo_do_imovel') ?>

    <?= $form->field($model, 'logradouro') ?>
    
    <?php  $items .= $form->field($model, 'cpf') ?>
    
    <?php  $items .= $form->field($model, 'numero_do_apartamento') ?>

    <?php  $items .= $form->field($model, 'numero_do_box') ?>

    <?php  $items .= $form->field($model, 'inicio_da_locacao') ?>

    <?php  $items .= $form->field($model, 'mais_informacoes') ?>

    <?php  
    // $listData = ArrayHelper::map(Proprietario::find()->all(),'id','nome');
    // $items .=  $form->field($model, 'proprietario_id')->dropDownList($listData,['prompt'=>'Proprietário do Imóvel']);    
     ?>
    <?php echo Collapse::widget([
    'items' => [
        // equivalent to the above
        [
            'label' => 'Ver mais Itens',
            'content' => ''.$items,
        ],
    ]
    ]);
    ?>

    

    <?php // echo $form->field($model, 'proprietario_mes_referencia_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Limpar Filtros', ['class' => 'btn btn-info','id'=>'form-reset-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
    $this->registerJS('
        $("#form-reset-button").click(function(){
            location.href = "'.Yii::$app->urlManager->createUrl("locatario/index").'";
        });');
    ?>

</div>
<script>

</script>