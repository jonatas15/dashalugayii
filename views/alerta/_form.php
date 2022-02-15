<?php

use app\models\SaAlerta;
use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\select2\Select2;


use app\models\Usuario;
use app\models\SaPendenciausuarios;
use app\models\SaAlertausuarios as alertaUser;
use kartik\widgets\DateTimePicker;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\SaAlerta */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    label.active {
        background-color: gray !important;
        color: white !important;
    }
</style>
<div class="sa-alerta-form" style="text-align: left">
    <div class="col-md-6">
    <?php $form = ActiveForm::begin([
        'action' => Yii::$app->homeUrl.'alerta/'.$modo,
    ]); ?>
    <div class="col-md-12">
    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true])->label('Título') ?>
    </div>
    <?php 
        $arr_pretendentes = [];
        foreach (\app\models\SloPretendente::find()->all() as $key => $p) {
            if($p->sloInfospessoais->nome != ''){
                $arr_pretendentes[$p->id] = $p->sloInfospessoais->nome;
            }
        }
        // $arr_pretendentes = array_unique($arr_pretendentes);
        
    ?>
    <div class="col-md-12">
    <?php if($model->isNewRecord):?>
    <?= $form->field($model, 'pretendente')->widget(Select2::classname(), [
        'data' => $arr_pretendentes,
        'language' => 'pt',
        'options' => [
            'placeholder' => 'Selecione',
            'multiple' => false
        ],
        'pluginOptions' => [
        'tags'=>true,
        'allowClear' => false,
        'maximumInputLength' => 100
        ],
    ]); ?>
    <?php else: ?>
        <div class="form-group field-categoria">
            <label class="control-label" for="<?=$prefixo_id?>-pretendente">Pretendente</label>
            <?= Select2::widget([
                    'data' => $arr_pretendentes,
                    'name' => $prefixo_id.'-pretendente',
                    'value' => $model->pretendente,
                    'language' => 'pt',
                    'options' => [
                        'placeholder' => 'Digite ou selecione',
                        'multiple' => false
                    ],
                    'pluginOptions' => [
                    'tags'=>true,
                    'allowClear' => false,
                    'maximumInputLength' => 100
                    ],
            ]); ?>
        </div>
    <?php endif; ?>
    </div>
    <div class="col-md-12">
    <?= $form->field($model, 'descricao')->textarea(['rows' => 6])->label('Descrição') ?>
    <?php //= $form->field($model, 'categoria')->textInput() 
        $categorias = SaAlerta::find()->select('categoria')->distinct()->all();
        $arr_categorias = [];
        foreach ($categorias as $key => $value) {
            $cat = $value['categoria'];
            $arr_categorias[$cat] = $cat;
        }
    ?>
    </div>
    <div class="col-md-12">
    <?php if($model->isNewRecord):?>
          
          <?= $form->field($model, 'categoria')->widget(Select2::classname(), [
              'data' => $arr_categorias,
              'language' => 'pt',
              'options' => [
                  'placeholder' => 'Selecione',
                  'multiple' => false
              ],
              'pluginOptions' => [
                'tags'=>true,
                'allowClear' => false,
                'maximumInputLength' => 100
              ],
          ]); ?>
          <?php else: ?>
            <div class="form-group field-categoria">
                <label class="control-label" for="<?=$prefixo_id?>-categoria">Categoria</label>
                <?= Select2::widget([
                      'data' => $arr_categorias,
                      'name' => $prefixo_id.'-categoria',
                      'value' => $model->categoria,
                      'language' => 'pt',
                      'options' => [
                          'placeholder' => 'Digite ou selecione',
                          'multiple' => false
                      ],
                      'pluginOptions' => [
                        'tags'=>true,
                        'allowClear' => false,
                        'maximumInputLength' => 100
                      ],
                ]); ?>
            </div>
        <?php endif; ?>
        </div>
            <?php //= $form->field($model, 'data_inicio')->textInput(['value'=>date('yy-m-d h:i:s')]) ?>
            <?php 
                echo '<div class="col-md-7">';
                echo $form->field($model, 'data_inicio')->widget(DatePicker::classname(), [
                    'language' => 'pt',
                    'type' => 2,
                    'options' => [
                        'placeholder' => 'Início do Prazo',
                        'id'=> 'data_inicio_'.rand(1000, 9999),
                        'value' => ($model->isNewRecord ? date('d/m/yy') : date('d/m/yy', strtotime($model->data_inicio))),
                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd/mm/yyyy'
                    ]
                ])->label('Início do Prazo');

                $edit_hora_ini = explode(' ', $model->data_inicio);

                echo '</div><div class="col-md-5">';
                echo '<label class="control-label has-star" for="t1">Horário</label>';
                echo TimePicker::widget([
                    'name' => 't1',
                    'value' => ($model->isNewRecord?'00:00':$edit_hora_ini[1]),
                    'pluginOptions' => [
                        'showSeconds' => false,
                        'showMeridian' => false,
                        'minuteStep' => 1,
                        'secondStep' => 5,
                    ]
                ]);
                echo '</div>';
            ?>
            <br />
            <?php 
                echo '<div class="col-md-7">';
                echo $form->field($model, 'data_limite')->widget(DatePicker::classname(), [
                    'language' => 'pt',
                    'options' => [
                        'placeholder' => 'Fim do Prazo',
                        'id'=> 'data_limite_'.rand(1000, 9999),
                        'value' => ($model->isNewRecord ? date('d/m/yy') : date('d/m/yy', strtotime($model->data_limite)))
                    ],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd/mm/yyyy'
                    ]
                ])->label('Fim do Prazo');
                echo '</div><div class="col-md-5">';

                $edit_hora = explode(' ', $model->data_limite);

                echo '<label class="control-label has-star" for="t2">Horário</label>';
                echo TimePicker::widget([
                    'name' => 't2',
                    'value' => ($model->isNewRecord?'00:00':$edit_hora[1]),
                    'pluginOptions' => [
                        'showSeconds' => false,
                        'showMeridian' => false,
                        'minuteStep' => 1,
                        'secondStep' => 5,
                    ]
                ]);
                echo '</div>';
            ?>
    <div class="hidden">
        <?= $form->field($model, 'envio')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'usuario_id')->textInput(['value'=>Yii::$app->user->identity->id]) ?>
        <?= $form->field($model, 'sa_pendencia_id')->textInput() ?>
        <?= $form->field($model, 'data_criacao')->textInput(['value'=>date('yy-m-d h:i:s')]) ?>
    </div>

    <?php
        $usuarios = [];
        $modelUsuarios = Usuario::find()->where([
            'tipo'=> [
                'admin',
                'corretor',
                'cliente',
                'locacao'
            ]])->andwhere(['<>','id', Yii::$app->user->identity->id])->orderBy([
            'tipo'=>SORT_ASC,
            'id'=>SORT_ASC,
        ])->all();

        foreach ($modelUsuarios as $key => $user) {
            $usuarios[$user->id] = '<img src="'.Yii::$app->homeUrl.'usuarios/'.($user->foto?$user->foto:'1211811759.png').'" width="50" height="50" /><br/>'.
            "<br><label>". substr($user->nome, 0, 10) . "<br>({$user->tipo})" 
            ."</label>";

        }
        $usuarios_ativos = [];
        if (!$model->isNewRecord) {
            foreach ($model->saAlertausuarios as $u) {
                array_push($usuarios_ativos,$u->usuario_id);
            }
            // echo "<pre>";
            // print_r($usuarios_ativos);
            // echo "</pre>";
            $model->alertaopovo = $usuarios_ativos;
        }
    ?>
    </div>
    
    <div class="col-md-6">
        <?=$form->field($model, 'alertaopovo')->checkboxButtonGroup($usuarios)->label('Usuários a Alertar');?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
