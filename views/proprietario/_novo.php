<?php
    
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap\Modal;

$proprietarios_model = \app\models\Proprietario::find()->all();
$proprietarios = [];
foreach ($proprietarios_model as $row) {
    $proprietarios[$row->id] = $row->nome; 
}
?>
<?php 
// Modal::begin([
//     'header' => '',
//     'size' => 'modal-lg',
//     'toggleButton' => [
//         'label' => "Atribuir Proprietário",
//         'class' => "btn btn-primary"
//     ],
//     'options' => [
//         'tabindex' => true,
//         'style' => 'z-index: 1500 !important'
//     ],
// ]);
?>
<div class="divs-proprietario-inicial-mesmo">
    <!-- <h3><strong>Dados do Proprietário</strong></h3><hr style="margin-top:0px;margin-bottom:0px !important;"> -->
    <?php $form = ActiveForm::begin([
        'action' => ['proposta/atualizarcorretor'],
        'options' => [
            'id' => 'formulario-pra-proposta'
        ]
    ]); ?>
    <?= $form->field($model, 'proprietario_2')->widget(Select2::classname(), [
        'data' => $proprietarios,
        'language' => 'pt',
        'options' => [
            'placeholder' => 'Selecione o nome do Proprietário',
            'multiple' => false,
            'onchange' => '
                $("body").css("cursor", "wait");
                $(this).css("cursor", "wait");
                $("#progressando").show();
                $.ajax({
                    method: "POST",
                    url: "'.Yii::$app->homeUrl.'proposta/atribuiprop",
                    data: {
                        id: $(this).val(),
                        codigo: \''.$codigo.'\'
                    },
                }).done(function(data) {
                    var response = $.parseJSON(data);
                });
                $("body").css("cursor", "default");
                $(this).css("cursor", "default");
                $("#progressando").hide();
            '
        ],
        'pluginOptions' => [
            'tags'=>false,
            'allowClear' => false,
            'maximumInputLength' => 100
        ],
    ])->label(''); ?>
    <?php ActiveForm::end(); ?>
    <?php //Modal::end(); ?>
</div>