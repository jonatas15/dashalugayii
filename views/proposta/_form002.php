<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\widgets\DatePicker;
use yii\widgets\MaskedInput;

// use yii\bootstrap\Collapse;

/* @var $this yii\web\View */
/* @var $model app\models\SloProposta */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 
    // echo Collapse::widget([
    //     'items' => [
    //         // equivalent to the above
    //         [
    //             'label' => 'Pretendente Formulário Prévio',
    //             'content' => 'Anim pariatur cliche...',
    //             // open its content by default
    //             'contentOptions' => ['class' => 'in']
    //         ],
    //     ],
    // ]);
?>
<?php

    $dats = str_split($model->cpf,3);
    $dados_anteriores .= 'Cpf: '.$dats[0].'.'.$dats[1].'.'.$dats[2].'-'.$dats[3]."\n";
    $dados_anteriores .= 'Data de Nacimento: ' . date('d/m/Y', strtotime($model->data_nascimento))."\n";
    $dados_anteriores .= 'Emancipado: ' . ($model->emancipado == 1 ? 'Sim' : 'Não')."\n";

?>

<div class="slo-proposta-form">
    <div class="">
        <h4 class="titulo">Informações Pessoais <sup><span class="badge badge-primary"> 2 </span></sup>
            <br><sub title="<?= $dados_anteriores ?>"> <strong>Pretendente:</strong> <?=$model->nome?></sub>
        </h4>
        <hr>
        <div class="progress">
          <div class="progress-bar bg-success" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <a class="btn btn-primary" href="<?= Yii::$app->homeUrl.'proposta/pretendente001?form=001&id='.$model->id.'&pretendente_id='.$pretendente_id.'&proposta_id='.$proposta_id ?>"><i class="fas fa-angle-double-left"></i> Voltar</a>
        <hr>
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-12">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'fone_residencial')->widget(MaskedInput::className(), ['mask' => '(99) 9999-9999']) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'celular')->widget(MaskedInput::className(), ['mask' => '(99) 9 9999-9999']) ?>
        </div>
        <div class="col-md-12">
            <div class="form-group float-right">
                <?= Html::submitButton('CONTINUAR  <i class="fas fa-angle-double-right"></i>', ['class' => 'btn btn-primary', 'style'=>'font-weight: bolder']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
