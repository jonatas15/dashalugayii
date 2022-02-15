<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CyberTopico;
// use app\models\Cyber;
use kartik\select2\Select2;

use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\CyberTopico */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cyber-topico-form">
    <div style="text-align: left">
        <?php $form = ActiveForm::begin([
            'action'=> $model->isNewRecord ? Yii::$app->homeUrl.'/cybertopico/create' : Yii::$app->homeUrl.'/cybertopico/update?idtopico='.$prefixo_id.'&cyber_idcyber='.$model->cyber_idcyber,
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>

        <?= $form->field($model, 'cyber_idcyber')->hiddenInput(['value' => $idcyber])->label(false) ?>

        <?= $form->field($model, 'usuario_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>

        <?php 
            $countries = CyberTopico::find()->where(['cyber_idcyber'=>$idcyber])->all();
            $listData = ArrayHelper::map($countries,'idtopico','titulo');
            if (!empty($topico_pai)) {
              $model->topico_pai = $topico_pai;
            }
        ?>

        <?= $form->field($model, 'topico_pai')->dropDownList($listData, ['prompt'=>'Selecione...']); ?>

        <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'tipo')->dropDownList([ 'tópico' => 'Tópico', 'documento' => 'Documento', 'imagem' => 'Imagem', 'passo a passo' => 'Passo a passo', ], ['prompt' => '']) ?>

        <?= $form->field($model, 'descricao')->textarea(['rows' => 6]) ?>

        <?php

            $model->palavraschaves = explode(';',$model->palavraschaves);
            $chaves = CyberTopico::find()->all();
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
          <?php if (empty($topico_pai)) { ?>
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
          <?php } else { ?>
            <div class="form-group field-cyber-palavraschaves">
                <label class="control-label" for="<?=$topico_pai?>-ramo-palavraschaves">Palavras-Chave</label>
                <?= Select2::widget([
                      'data' => $data_tags2,
                      'name' => $topico_pai.'-ramo-palavraschaves',
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
          <?php } ?>
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

        <?php //= $form->field($model, 'imagem')->textInput(['maxlength' => true]) ?>

        <?php if($model->imagem) {
            echo '<hr>';
            echo Html::img('@web/uploads/'.$model->imagem, ['class' => 'pull-left img-responsive col-md-6']);
            echo "<br>"; 
            echo "<hr style='width:100%;'>"; 
            
        }
        ?>
        <?= $form->field($model, 'imageFile')->fileInput() ?>
        <div style="display: none">

        <?= $form->field($model, 'documento')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'datetime')->textInput() ?>

        </div>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Cadastrar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>