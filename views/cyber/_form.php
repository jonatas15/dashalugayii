<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;
use kartik\widgets\ColorInput;
use app\models\Cyber as Cyber;

use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Cyber */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cyber-form">

    <?php $form = ActiveForm::begin([
      'action'=> $model->isNewRecord ? Yii::$app->homeUrl.'/cyber/create' : Yii::$app->homeUrl.'/cyber/update?id='.$prefixo_id
    ]); ?>

    <?= $form->field($model, 'usuario_id')->hiddenInput(['value'=>Yii::$app->user->identity->id])->label(false) ?>
    <!-- <div class="col-md-6"> -->
      <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
      <?php if($model->isNewRecord):?>
      <?= $form->field($model, 'cor')->widget(ColorInput::classname(), [
        'options' => ['placeholder' => 'Selecione ...'],

      ]);
      ?>
      <?php else: ?>
        <div class="form-group field-cyber-cor">
          <label class="control-label" for="<?=$prefixo_id?>-cor">Cor</label>
          <?= ColorInput::widget([
            'name'=> $prefixo_id.'-cor',
            'value' => $model->cor,
            'options' => [
              'placeholder' => 'Selecione ...',
            ],
          ]);?>
        </div>
      <?php endif; ?>
      <?php

        $model->palavraschaves = explode(';',$model->palavraschaves);
        $chaves = Cyber::find()->all();
        $data_tags = [];
        $i = 0;
        foreach ($chaves as $key) {
          $string_tags .= $key['palavraschaves'];
          $i++;
          if($i < count($chaves)){
            $string_tags .= ';';
          }
        }

        $data_tags = explode(';',$string_tags);

        foreach ($data_tags as $key => $value) {
            $data_tags2[$value] = $value;
        }

        // $data_tags2 = array_unique($data_tags2);

        // $data_tags = \app\models\
      ?>
      <?php if($model->isNewRecord):?>
      <?= $form->field($model, 'palavraschaves')->widget(Select2::classname(), [
          'data' => $data_tags2,
          'language' => 'pt',
          'options' => [
              'placeholder' => 'Selecione',
              'multiple' => true
          ],
          'pluginOptions' => [
            'tags'=>true,
            'allowClear' => true,
          ],
      ]); ?>
      <?php else: ?>
        <div class="form-group field-cyber-palavraschaves">
          <label class="control-label" for="<?=$prefixo_id?>-palavraschaves">Palavras-Chave</label>
          <?= Select2::widget([
              'data' => $data_tags2,
              'name' => $prefixo_id.'-palavraschaves',
              'value' => $model->palavraschaves,
              'language' => 'pt',
              'options' => [
                  'placeholder' => 'Digite ou selecione',
                  'multiple' => true
              ],
              'pluginOptions' => [
                'tags'=>true,
                'allowClear' => true,
              ],
          ]); ?>
       </div>
     <?php endif; ?>
    <!-- </div> -->
    <!-- <div class="col-md-6"> -->
      <?php /*
      <?= $form->field($model, 'descricao')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
          	'preset' => 'full'
          ]);
      ?>
      */ ?>
      <?= $form->field($model, 'descricao')->textArea(['rows' => 6,'id'=>$prefixo_id.'-cyber-descricao']); ?>
    <!-- </div> -->
    <?php 

    ?>
    <?= Yii::$app->user->can('administrador') ? $form->field($model, 'cybercol')->dropDownList([
      'publico' => 'Público',
      'admin' => 'Administrador',
      'corretor' => 'Corretor',
      'vendas' => 'Vendas',
      'locacao' => 'Locação',
    ]) : '' ?>

    <?= $form->field($model, 'datetime')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Cadastrar') : Yii::t('app', 'Atualizar'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
