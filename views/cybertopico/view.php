<?php
use yii\helpers\Html;
// use yii\widgets\DetailView;
use kartik\editable\Editable;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Collapse;

use app\models\CyberTopico;
use app\models\Usuario;
use app\models\Topicoupdates;

/* @var $this yii\web\View */
/* @var $model app\models\CyberTopico */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = [
    'label' => $model->cyberIdcyber->nome,
    'url' => [
        'cybertopico/index?cyber_idcyber=' . $model->cyber_idcyber
    ]
];
$this->params['breadcrumbs'][] = $this->title;

?>

<style type="text/css">
.kv-editable-button.btn-sm {
	float: right;
}

.view-titulo-do-cybertopico {
	text-align: center;
	margin-top: 25px;
	margin-bottom: 10px;
	font-weight: bold;
	white-space: nowrap;
}

.star {
	visibility: hidden;
	font-size: 30px;
	cursor: pointer;
}

.star:before {
	content: "\2605";
	position: absolute;
	visibility: visible;
}

.star:checked:before {
	content: "\2606";
	position: absolute;
}

.smile {
	visibility: hidden;
	font-size: 30px;
	cursor: pointer;
}

.smile:before {
	font-family: "Font Awesome 5 Free";
	content: "\f164";
	position: absolute;
	visibility: visible;
}

.smile:checked:before {
	font-family: "Font Awesome 5 Free";
	content: "\f164";
	color: lightgray;
	position: absolute;
}
.nosmile {
	visibility: hidden;
	font-size: 30px;
	cursor: pointer;
}

.nosmile:before {
	font-family: "Font Awesome 5 Free";
	content: "\f165";
	position: absolute;
	visibility: visible;
}

.nosmile:checked:before {
	font-family: "Font Awesome 5 Free";
	content: "\f165";
	color: lightgray;
	position: absolute;
}
.titulo{
    font-weight: bolder;
    padding: 1% 4%;
}
.cyber-conteudo{
    background: white;
    height: 170px;
}
.ajudou-lb{color:blue !important;}
.nao-ajudou-lb{color:red !important;}
</style>
<div class="cyber-topico-view col-md-12">
	<div class='col-md-12'>
		<a
			href="<?= Yii::$app->homeUrl.'cybertopico/index?cyber_idcyber='.$model->cyber_idcyber; ?>"
			class="btn btn-info"
			style="float: left; margin-top: 20px; margin-bottom: 10px;"><i
			class="glyphicon glyphicon-arrow-left"></i> <?=$model->cyberIdcyber->nome?></a>
    <?php if(!empty($model->topico_pai)): ?>
        <a
			href="<?= Yii::$app->homeUrl.'cybertopico/view?idtopico='.$model->topico_pai.'&cyber_idcyber='.$model->cyber_idcyber; ?>"
			class="btn btn-info"
			style="float: left; margin-top: 20px; margin-bottom: 10px; margin-left: 5px"><i
			class="glyphicon glyphicon-arrow-left"></i> <?=$model->topicoPai->titulo?></a>
    <?php endif; ?>
    <?=Html::a('<i class="glyphicon glyphicon-trash"></i> Excluir registro', ['delete','idtopico' => $model->idtopico,'cyber_idcyber' => $model->cyber_idcyber], ['class' => 'btn btn-danger','style' => 'float:right; margin-top: 20px; margin-bottom: 10px;','data' => ['confirm' => Yii::t('app', 'Tens certeza que quer excluir esse registro?'),'method' => 'post']])?>
   </div> 
    <?php
    $comentarios = app\models\CyberComentario::find()->where([
        'cyber_topico_idtopico' => $model->idtopico
    ])->all();
    $conta_comentarios = count($comentarios);

    echo "<div class='col-md-12' style='outline: 1px solid ghostwhite;'>";

    // echo $model->descricao;
    ?>
          <div class="col-md-3"
		style="border-right: 1px solid ghostwhite">
            <?php if(!empty($model->imagem)):?>
                  <img
			src="<?=Yii::$app->homeUrl.'uploads/'.$model->imagem?>"
			style="height: auto; max-width: 100%; max-height: 100%;">
            <?php else: ?>
                <img
			src="https://cafeinteligencia27-mrwru33hbcqg1251.netdna-ssl.com/assets/images/logo_site.png"
			style="width: 100%; height: auto; padding: 2%;" />
            <?php endif; ?>
            <?php
//             if (Yii::$app->user->can('administrador')) :
                echo Editable::widget([
                    'model' => $model,
                    'attribute' => 'imageFile',
                    // 'type' => 'primary',
                    'asPopover' => true,
                    'size' => 'lg',
                    'displayValue' => ' ',
                    'format' => Editable::FORMAT_BUTTON,
                    'inputType' => Editable::INPUT_FILE,
                    'formOptions' => [
                        'action' => [
                            'editregistro',
                            'idtopico' => $model->idtopico,
                            'cyber_idcyber' => $model->cyber_idcyber
                        ]
                    ],
                    'editableValueOptions' => [
                        'class' => '',
                        'style' => 'float:right'
                    ],
                    'options' => [
                        'class' => 'form-control'
                    ]
                ]);
                ?>
            <?php //endif; ?>
            <?php
            $relacionados = CyberTopico::find()->where([
                'topico_pai' => $model->topico_pai,
                'cyber_idcyber' => $model->cyber_idcyber
            ])->all();
            if (count($relacionados) > 1) {
                echo "<h4 class='view-titulo-do-cybertopico'>Relacionados:</h4>";
                echo '<ul class="list-group">';
                foreach ($relacionados as $rel) {
                    // code...
                    echo '<li class="list-group-item">';
                    echo "<a href='" . Yii::$app->homeUrl . 'cybertopico/view?idtopico=' . $rel->idtopico . '&cyber_idcyber=' . $rel->cyber_idcyber . "'>";
                    echo $rel->titulo;
                    echo "</a>";
                    echo "</li>";
                }
                echo "</ul>";
            }
            ?>
            <!-- <ul class="list-group">
  <li class="list-group-item">Cras justo odio</li>
  <li class="list-group-item">Dapibus ac facilisis in</li>
  <li class="list-group-item">Morbi leo risus</li>
  <li class="list-group-item">Porta ac consectetur ac</li>
  <li class="list-group-item">Vestibulum at eros</li>
</ul> -->
	</div>
	<div class="col-md-9">
	    <?php
    // echo Html::a('Your Link name', 'javascript::void()', [
    // 'onclick' => "
    // $.ajax({
    // type :'POST',
    // url : '" . Yii::$app->homeUrl . 'cybertopico/favoritopico?idtopico=' . $model->idtopico . "&favoritar=1',
    // success : function(response) {
    // $('#close').html(response);
    // }
    // });return false;"
    // ]);

    ?>
        <?php
        $favoritei = app\models\TopicoMembros::find()->where([
            'topico_idtopico' => $model->idtopico,
            'usuario_id' => Yii::$app->user->identity->id
        ])->one();
        // echo $favoritei->favorito;
        $favorito = 'checked';
        $favoritar = 1;
        if ($favoritei->favorito == 1) {
            $favorito = '';
            $favoritar = 0;
        } else {
            $favorito = 'checked';
            $favoritar = 1;
        }
        ?>
        <div style="float: left">
			<input type="checkbox" <?=$favorito?>
				style="color: orange; font-size: 50px" class="star"
				title="Favoritar/Desfavoritar"
				onclick="$.ajax({
                    type     :'POST',
                    url  : '<?= Yii::$app->homeUrl . 'cybertopico/favoritopico?idtopico=' . $model->idtopico . '&favoritar='.$favoritar.'&tipo=favorito'?>',
            	})" />
		</div>
		<h3 class="view-titulo-do-cybertopico">
				
				<?= Html::encode($this->title) ?>
			
                <?php
//                 if (Yii::$app->user->can('administrador')) :
                    echo Editable::widget([
                        'model' => $model,
                        'attribute' => 'titulo',
                        // 'type' => 'primary',
                        'asPopover' => false,
                        'size' => 'lg',
                        'displayValue' => ' ',
                        'format' => Editable::FORMAT_BUTTON,
                        'inputType' => Editable::INPUT_TEXT,
                        'formOptions' => [
                            'action' => [
                                'editregistro',
                                'idtopico' => $model->idtopico,
                                'cyber_idcyber' => $model->cyber_idcyber
                            ]
                        ],
                        'editableValueOptions' => [
                            'class' => '',
                            'style' => 'float:right'
                        ],
                        'options' => [
                            'class' => 'form-control'
                        ]
                    ]);
                    ?>
              <?php //endif; ?>
              </h3>
		<hr>
		<h4 style="color: gray">
			<span style="float: left;">
                    <?= $model->usuario->nome ?>
                    <sub style="font-size: 10px; font-style: italic;">
                      em <?= $model->cyberIdcyber->nome ?>
                    </sub>
			</span> <span style="float: right;"> <sub
				style="font-size: 12px; font-style: italic;">
                      Criado em <?= date('d/m/Y',strtotime($model->datetime)) ?> às <?= date('H:i:s',strtotime($model->datetime)) ?>
                    </sub>
			</span>
		</h4>
		<div class="clearfix"></div>
		<hr>
		<h4 class="">Tipo: <?= $model->tipo ?>
                  <?php
                if (Yii::$app->user->can('administrador')) :
                    echo Editable::widget([
                        'model' => $model,
                        'attribute' => 'tipo',
                        // 'type' => 'primary',
                        'asPopover' => false,
                        'size' => 'lg',
                        'displayValue' => ' ',
                        'format' => Editable::FORMAT_BUTTON,
                        'inputType' => Editable::INPUT_DROPDOWN_LIST,
                        'data' => [
                            'tópico' => 'Tópico',
                            'documento' => 'Documento',
                            'imagem' => 'Imagem',
                            'passo a passo' => 'Passo a passo'
                        ],
                        'formOptions' => [
                            'action' => [
                                'editregistro',
                                'idtopico' => $model->idtopico,
                                'cyber_idcyber' => $model->cyber_idcyber
                            ]
                        ],
                        'editableValueOptions' => [
                            'class' => '',
                            'style' => 'float:right'
                        ],
                        'options' => [
                            'class' => 'form-control'
                        ]
                    ]);
                    ?>
                  <?php endif; ?>
                </h4>
				<h4 class="">Tópico Pai: <?= (!empty($model->topicoPai->titulo) ? $model->topicoPai->titulo : 'Cyber'.$model->cyberIdcyber->nome) ?>
                  <?php
                    if (Yii::$app->user->can('administrador')) :
                        $countries = CyberTopico::find()->where([
                            'cyber_idcyber' => $model->cyber_idcyber
                        ])->all();
                        $listData = ArrayHelper::map($countries, 'idtopico', 'titulo');
                        echo Editable::widget([
                            'model' => $model,
                            'attribute' => 'topico_pai',
                            // 'type' => 'primary',
                            'asPopover' => false,
                            'size' => 'lg',
                            'displayValue' => ' ',
                            'format' => Editable::FORMAT_BUTTON,
                            'inputType' => Editable::INPUT_DROPDOWN_LIST,
                            'data' => $listData,
                            'formOptions' => [
                                'action' => [
                                    'editregistro',
                                    'idtopico' => $model->idtopico,
                                    'cyber_idcyber' => $model->cyber_idcyber
                                ]
                            ],
                            'editableValueOptions' => [
                                'class' => '',
                                'style' => 'float:right'
                            ],
                            'options' => [
                                'class' => 'form-control'
                            ]
                        ]);
                    ?>
                  <?php endif; ?>
                </h4>
		<hr>
            <?php

            if (Yii::$app->user->can('administrador')) :
                echo Editable::widget([
                    'model' => $model,
                    'attribute' => 'descricao',
                    // 'type' => 'primary',
                    'asPopover' => false,
                    'size' => 'lg',
                    'format' => Editable::FORMAT_BUTTON,
                    'inputType' => Editable::INPUT_TEXTAREA,
                    'formOptions' => [
                        'action' => [
                            'editregistro',
                            'idtopico' => $model->idtopico,
                            'cyber_idcyber' => $model->cyber_idcyber
                        ]
                    ],
                    'editableValueOptions' => [
                        'class' => ''
                    ],
                    'options' => [
                        'class' => 'form-control',
                        'rows' => 5,
                        'cols' => 100
                    ],
                    'submitOnEnter' => false,
                    'displayValue' => nl2br($model->descricao)
                ]);
            else :
                echo '<p align="justify">' . nl2br($model->descricao) . '</p>';
            endif;

            $chaves = CyberTopico::find()->where([
                'cyber_idcyber' => $model->cyber_idcyber
            ])->all();
            $data_tags = [];
            $i = 0;
            foreach ($chaves as $key) {
                $string_tags .= $key['palavraschaves'];
                $i ++;
                if ($i < count($chaves)) {
                    $string_tags .= ';';
                }
            }

            $data_tags = explode(';', $string_tags);

            $datex = [];
            $data_tags2 = [];

            $datex = explode(';', $model->palavraschaves);
            foreach ($data_tags as $key => $value) {
                $data_tags2[$value] = $value;
            }
            $w = 0;
            $keywords = '';
            foreach ($datex as $word) {
                $keywords .= $word;
                $w ++;
                if ($w < count($datex)) {
                    $keywords .= ', ';
                }
            }

            echo "<p>";
            echo "<h4>Palavras-Chaves:</h4>";
            // echo "<div class='col-md-12 clearfix'><hr></div>";
            // echo $keywords;

            if (Yii::$app->user->can('administrador')) :
                // echo "<br>";
                echo Editable::widget([
                    'name' => 'palavraschaves',
                    'asPopover' => false,
                    'header' => 'Province',
                    // 'format' => Editable::FORMAT_BUTTON,
                    'inputType' => Editable::INPUT_SELECT2,
                    'value' => $datex,
                    'displayValue' => str_replace(';', ', ', $model->palavraschaves),
                    'options' => [
                        'data' => $data_tags2,
                        'class' => 'form-control',
                        'options' => [
                            'multiple' => true
                        ],
                        'pluginOptions' => [
                            'tags' => true,
                            'allowClear' => true
                        ]
                    ],
                    'pluginOptions' => [],
                    'editableValueOptions' => [
                        'class' => ''
                    ],
                    'formOptions' => [
                        'action' => [
                            'editregistro',
                            'idtopico' => $model->idtopico,
                            'cyber_idcyber' => $model->cyber_idcyber
                        ]
                    ]
                ]);
            else :
                echo $keywords;
            endif;

            echo "</p>";

            ?>
            <?php
            $ajudou = 'checked';
            $ajudar = 1;
            $nao_ajudou = 'checked';
            $nao_ajudar = 1;
            $cor_label_aj = "";
            $cor_label_nj = "";
            // Ajudou
            if ($favoritei->ajudou == 1) {
                $ajudou = '';
                $ajudar = 0;
                $cor_label_aj = "ajudou-lb";
            } else {
                $ajudou = 'checked';
                $ajudar = 1;
            }
            // Não ajudou
            if ($favoritei->nao_ajudou == 1) {
                $nao_ajudou = '';
                $nao_ajudar = 0;
                $cor_label_nj = "nao-ajudou-lb";
            } else {
                $nao_ajudou = 'checked';
                $nao_ajudar = 1;
            }
            ?>
            <hr>
          	<div class="col-md-12">
          		
				<label class="<?=$cor_label_aj?>" style="color:lightgray; float:left; cursor:pointer" id="labaj">Me Ajudou <input id="lb-ajudou" style="color: blue;" type="checkbox"
					<?=$ajudou?> class="smile" title="Esse Tópico me ajudou"
    					onclick="$.ajax({
                        type     :'POST',
                        url  : '<?= Yii::$app->homeUrl . 'cybertopico/favoritopico?idtopico=' . $model->idtopico . '&favoritar='.$ajudar.'&tipo=ajudou'?>',
                	})" />	
				</label>
				<label class="<?=$cor_label_nj?>" style="color:lightgray; float:right; cursor:pointer" id="labnj">Não me Ajudou <input id="lb-nao-ajudou" style="color: red;" type="checkbox"
					<?=$nao_ajudou?> class="nosmile" title="Esse Tópico não me ajudou"
    					onclick="$.ajax({
                        type     :'POST',
                        url  : '<?= Yii::$app->homeUrl . 'cybertopico/favoritopico?idtopico=' . $model->idtopico . '&favoritar='.$nao_ajudar.'&tipo=nao_ajudou'?>',
                	})" />	
				</label>
			</div>
		</div>
       <div class="col-md-12 clearfix"><br /></div>     
          
        <?php

        echo "</div>";

        ?>
        
        
        
        <?php
        $raiz = app\models\CyberTopico::find()->where([
            'topico_pai' => $model->idtopico
        ])->all();
        if (count($raiz) > 0) {
            echo "<div class='clearfix'><hr></div>";
            echo "<div class='col-md-12' style='outline: 1px solid ghostwhite;background-color: ghostwhite'>";
            echo "<h4 class='view-titulo-do-cybertopico'><strong>Subtópicos</strong></h4>";
            echo "<hr>";
            echo '<div class="tree" style="width:100%;overflow-x:auto;">';
            echo "<ul>";
            echo '<li>
                      <a href="#" title="' . $model->descricao . '">' . $model->titulo;
            if (! empty($model->imagem)) {
                echo "<br><img src='" . Yii::$app->homeUrl . 'uploads/' . $model->imagem . "' height='50'/>";
            }
            echo '</a>';

            echo '<ul>';
            foreach ($raiz as $row) {
                echo '<li>';
                echo '<a href="' . Yii::$app->homeUrl . 'cybertopico/view?idtopico=' . $row->idtopico . '&cyber_idcyber=' . $row->cyber_idcyber . '" title="' . $row->descricao . '" title="' . $row->descricao . '">' . $row->titulo;
                if (! empty($row->imagem)) {
                    echo "<br><img src='" . Yii::$app->homeUrl . 'uploads/' . $row->imagem . "' height='40'/>";
                }
                echo '</a>';
                $ramo = app\models\CyberTopico::find()->where([
                    'topico_pai' => $row->idtopico
                ])->all();

                if (count($ramo) > 0) {
                    echo "<ul>";
                    foreach ($ramo as $row2) {
                        echo '<li>';
                        echo '<a href="' . Yii::$app->homeUrl . 'cybertopico/view?idtopico=' . $row2->idtopico . '&cyber_idcyber=' . $row2->cyber_idcyber . '" title="' . $row2->descricao . '">' . $row2->titulo;
                        if (! empty($row2->imagem)) {
                            echo "<br><img src='" . Yii::$app->homeUrl . 'uploads/' . $row2->imagem . "' height='30'/>";
                        }
                        echo '</a>';
                        echo '</li>';
                    }
                    echo "</ul>";
                }

                echo '</li>';
            }
            echo "</ul>";

            echo '</li>';
            echo "</ul>";
            echo "</div>";
            echo "</div>";
        }

        echo "<div class='clearfix'><hr></div>";
        ?>
        <div class="" style="text-align: center">
		<br />
        <?php
        $ultima_visita = app\models\Topicovisitas::find()->where([
            'topico_id' => $model->idtopico,
        ])->orderBy(['datetime'=>SORT_DESC])->one();
        $ultimo_visitante = app\models\Usuario::find()->where(['id'=>$ultima_visita->usuario_id])->one();
        //Visitantes do Tópico
        $query = new yii\db\Query();
        $visitantes = $query->select(['usuario_id'])
        ->from('topicovisitas')
        ->distinct()
        ->where(['topico_id'=>$model->idtopico])
        ->groupBy(['usuario_id'])
        ->all();
        
        $content = '<div class="col-md-4" style="margin-bottom: 2%">
            <div class="cyber-sombra-caixa"><div class="cyber-conteudo">';
        
        $content .= '<div class="col-md-12">';
        $content .= '<h4 class="titulo">Último a visitar este Tópico</h4>';
        $content .= '<hr style="margin:1px 0 !important">';
        $content .= '<label class="titulo" style="float:left">';
        $content .= '<img src="'.Yii::$app->homeUrl.'usuarios/'.$ultimo_visitante->foto.'" width="40" style="border-radius:20px" />  '.$ultimo_visitante->nome;
        $content .= '</label>';
        $content .= '<label class="" style="float:left;padding:1% 4%">';
        
        $visitante_visitas = app\models\Topicovisitas::find()->where([
            'topico_id' => $model->idtopico,
            'usuario_id' => $ultima_visita->usuario_id
        ])->all();
        
        $content .= count($visitante_visitas);
        
        $content .= '<br><sob style="color: lightgray">VISITAS</sob>';
        $content .= '</label>';
        $content .= '<label class="" style="float:left;padding:1% 4%">';
        $parsed = date_parse((string)$ultima_visita->tempo);
        //$seconds = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second'];
        $tempo_maior = ($parsed['hour']>0?$parsed['hour'].'<sub>h</sub> ':'').($parsed['minute']>0?$parsed['minute'].'<sub>m</sub> ':'');
        $content .= $tempo_maior.$parsed['second'].'<sub style="">s</sub> ';
        $content .= '<br><sob style="color: lightgray">TEMPO</sob>';
        $content .= '</label>';
        $content .= '</div>';
        $content .= '<div class="col-md-12" style="color: gray;">';
        $content .= '<hr style="margin:1px 0 !important">';
        $content .= '<h4>+ '.count($visitantes).(count($visitantes) == 1?' pessoa viu':' pessoas viram').' esse tópico</h4>';
        $content .= '</div>';
        
        $content .= '</div></div></div>';
        
        # Usuários que Votaram ========================================================================
        $content .= '<div class="col-md-5" style="margin-bottom: 2%">
            <div class="cyber-sombra-caixa"><div class="cyber-conteudo">';
        
        $usuarios_favoritaram = app\models\TopicoMembros::find()->where([
        'topico_idtopico' => $model->idtopico,
        'favorito' => 1
        ])->all();
        $usuarios_ajudados = app\models\TopicoMembros::find()->where([
            'topico_idtopico' => $model->idtopico,
            'ajudou' => 1
        ])->all();
        $usuarios_nao_ajudados = app\models\TopicoMembros::find()->where([
            'topico_idtopico' => $model->idtopico,
            'nao_ajudou' => 1
        ])->all();
        $content .= '<div class="col-md-12">';
        $content .= '<h4 class="titulo" style="">Atividades neste Tópico</h4>';
        $content .= '<hr style="margin:1px 0 !important">';
        $content .= '<label class="titulo" style="float:left;text-align:center !important">';
        $content .= '<i class="fas fa-star"></i> '.count($usuarios_favoritaram);
        $content .= '<br><sob style="color: lightgray; font-size: 10px">FAVORITO</sob>';
        $content .= '</label>';
        $content .= '<label class="titulo" style="float:left;text-align:center !important">';
        $content .= '<i class="fas fa-thumbs-up"></i> '.count($usuarios_ajudados);
        $content .= '<br><sob style="color: lightgray; font-size: 10px">ME AJUDOU</sob>';
        $content .= '</label>';
        $content .= '<label class="titulo" style="float:left;text-align:center !important">';
        $content .= '<i class="fas fa-thumbs-down"></i> '.count($usuarios_nao_ajudados);
        $content .= '<br><sob style="color: lightgray; font-size: 10px">NÃO AJUDOU</sob>';
        $content .= '</label>';
        
        # Usuários que comentaram quantos foram
        $content .= '<label class="titulo" style="float:left;text-align:center !important">';
        $content .= '<i class="fas fa-comments"></i> '.count($comentarios);
        $content .= '<br><sob style="color: lightgray; font-size: 10px">COMENTÁRIOS</sob>';
        $content .= '</label>';
        
        # Modificações
        $alteracoes = app\models\Topicoupdates::find()->where(['topico_id'=>$model->idtopico])->all();
        $content .= '<a href="'.Yii::$app->homeUrl.'topicoupdates?TopicoupdatesSearch%5Btopico_id%5D='.$model->idtopico.'">';
        $content .= '<label class="titulo" style="float:left;text-align:center !important">';
        $content .= '<i class="fas fa-cog"></i> '.count($alteracoes);
        $content .= '<br><sob style="color: lightgray; font-size: 10px">EDIÇÕES</sob>';
        $content .= '</label>';
        $content .= '</a>';
        
        $content .= '</div></div></div></div>';
        
        # Usuário que editou ========================================================================
        $content .= '<div class="col-md-3" style="margin-bottom: 2%">
            <div class="cyber-sombra-caixa"><div class="cyber-conteudo">';
        $content .= '<div class="col-md-12">';
        $content .= '<h4 class="titulo" style="">Colaboradores</h4>';
        $content .= '<hr style="margin:1px !important">';
        $content .= '<label class="titulo" style="float:left">';
        $content .= '<img src="'.Yii::$app->homeUrl.'usuarios/'.$model->usuario->foto.'" width="40" style="border-radius:20px" />  '.$model->usuario->nome.' (autor)';
        $content .= '</label>';
        
        $colaboradores = $query->select(['usuario_id'])
        ->from('topicoupdates')
        ->distinct()
        ->where(['topico_id'=>$model->idtopico])
        ->groupBy(['usuario_id'])
        ->all();
        //echo("<pre>");
        //print_r($colaboradores);
        //echo("</pre>");
        $content .= '<div class="col-md-12" style="border-bottom:1px solid #eee"><sob style="color: gray; font-size: 10px">ÚLTIMOS EDITORES</sob></div>';
        $i = 0;
        foreach ($colaboradores as $r=>$k){
            $colaborador = Usuario::find()->where(['id'=>$k['usuario_id']])->one();
            $content .= '<label class="titulo" style="float:left">';
            
            $content .= '<img src="'.Yii::$app->homeUrl.'usuarios/'.$colaborador->foto.'" width="20" style="border-radius:20px" />';
            $content .= '<br><sob style="color: lightgray; font-size: 10px">'.$colaborador->nome.'</sob>';
            $content .= '</label>';
            $i++;
            if($i == 3){
                break;
            }
        }
        
        
        $content .= '</div></div></div></div>';
        
        echo Collapse::widget([
            'items' => [
                [
                    'label'   => 'Gráficos e Métricas',
                    'content' => $content,
                    'contentOptions' => ['class' => 'in']
                ],
            ]
        ]);
        ?>
        </div>
        <?php
        echo "<div class='col-md-12' style='outline: 1px solid ghostwhite;background-color: ghostwhite; padding: 2%'>";
        echo "<h4><strong>Comentários</strong></h4>";

        foreach ($comentarios as $com) {
            echo "<div style='background: ghostwhite; border: 1px solid lightgray; box-shadow: 2px 2px lightgray; border-radius:10px; padding: 10px; margin: 10px'>";
            echo '<img src="' . Yii::$app->homeUrl . 'usuarios/' . $com->usuario->foto . '" width="25" style="border-radius: 20px; float:left; margin: 5px;">';
            echo "<p align='justify' style=' margin: 5px;'>";
            echo "<strong>" . $com->usuario->nome . ":</strong> " . $com->comentario;
            echo "</p>";
            echo "</div>";
        }
        $cyber_comentario = new app\models\CyberComentario();
        echo $this->render('/cybercomentario/create', [
            'model' => $cyber_comentario,
            'topico_idtopico' => $model->idtopico,
            'cyber_idcyber' => $model->cyber_idcyber
        ]);
        echo "</div>";
        echo "<div class='clearfix'></div>";

        /*
         * DetailView::widget([
         * 'model' => $model,
         * 'attributes' => [
         * 'idtopico',
         * 'cyber_idcyber',
         * 'usuario_id',
         * 'titulo',
         * 'tipo',
         * 'descricao:ntext',
         * 'palavraschaves:ntext',
         * 'imagem',
         * 'documento',
         * 'datetime',
         * 'topico_pai',
         * ],
         * ])
         */
        ?>

</div>
<?php 
$this->registerJS("var inicio;
    $(document).ready(function(){
        inicio = new Date();
        inicio = inicio.getTime();
        // $(window).on('beforeunload ',function() {
        //     return 'Are you sure ?';
        // });
        // $(window).unload(function(){
        $(window).on('beforeunload ',function(){
            fim = new Date;
            fim = fim.getTime();
            $.ajax({
                url: '".Yii::$app->homeUrl."cybertopico/registravisita',
                data: {
                    'time': fim - inicio,
                    'topico_id': '".$model->idtopico."',
                },
            });
    
        });
        $('#lb-ajudou').on('click', function(){
            $('#labaj').toggleClass('ajudou-lb');
        });
        $('#lb-nao-ajudou').on('click', function(){
            $('#labnj').toggleClass('nao-ajudou-lb');
        });
    });");
?>

