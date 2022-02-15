<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\CyberTopico;


/* @var $this yii\web\View */
/* @var $searchModel app\models\CybertopicoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$Cyber = app\models\Cyber::find()->where(['idcyber'=>$_REQUEST['cyber_idcyber']])->one();
$this->title = 'Cyber '.$Cyber->nome;
$this->params['breadcrumbs'][] = ['label' => 'Cybers', 'url' => ['/cyber/index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<style type="text/css">
  .titulo{
/*     margin-top: 3%; */
    /*position: absolute;*/
    font-weight: bolder;
    padding: 1% 2%;
  }
  .conf-topicos{
/*     margin-top: 3%; */
    padding-right: 2%;
    position: initial;
    font-weight: bolder;
    position: absolute;
    top: 10%;
    left: 90%;
  }
  .icons-marcadores label{
    margin-left:1%;
    margin-right:1%;
    float: right;
  }
  @media (max-width: 480px) {
    .titulo{
      margin-top: 1%;
      position: absolute;
      font-weight: bolder;
      width: 52%;
    }
    
    .corpo-topico{
      padding: 1%; width: 100%; height: 80px; max-height: 80px;
    }
    .icons-marcadores {
      opacity: 0.7;
      position: absolute;
      top: 32%;
      right: 3%;
    }
    .conf-topicos {
        position: absolute;
        top: 6% !important;
        left: 80% !important;
    }
  }
  .corpo-topico{
    padding: 1%; width: 100%; height: 80px; max-height: 80px;
  }
</style>
<div class="cyber-topico-index">
    <div class="col-md-12">
      <a href="<?= Yii::$app->homeUrl.'cyber'; ?>" class="btn btn-success" style="float: left;margin-top: 20px; margin-bottom: 10px;"><i class="glyphicon glyphicon-arrow-left"></i></a>
      <h3 style="float: left; padding-left: 12px"><?= Html::encode($this->title).' <sup style="font-style: italic;font-size: 10px">'.count($dataProvider->models).' Tópicos Encontrados</sup>' ?></h3>
      <a href="<?= Yii::$app->homeUrl.'cybertopico/index?cyber_idcyber='.$Cyber->idcyber ?>" class="btn btn-warning" style="float:right;margin-top: 20px; margin-bottom: 10px; margin-left: 10px"><i class="glyphicon glyphicon-glass"></i> Limpar Filtros</a>
      <?php
      yii\bootstrap\Modal::begin([
          'header' => '<h4>Cadastrar novo Tópico</h4>',
          'toggleButton' => ['label' => 'Cadastrar Novo Tópico <i class="glyphicon glyphicon-plus"></i>','class'=>"btn btn-success", 'title'=>'Cadastrar Novo Cyber', 'style'=>'float:right;margin-top: 20px; margin-bottom: 10px;'],
      ]);
      $cyber = new app\models\CyberTopico;
      echo $this->render('create', [
          'model' => $cyber,
          'idcyber' => $_REQUEST['cyber_idcyber'],
          'topico_pai' => ''
      ]);
      yii\bootstrap\Modal::end();
      ?>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
      <form>
        <div class="input-group">
          <input type="text" name="CybertopicoSearch[buscatudo]" value="<?=$_REQUEST['CybertopicoSearch']['buscatudo']?>" class="form-control" style="border-radius: 10px 0 0 10px;" placeholder="Busque por Nome, descrição ou palavras chaves">
          <span class="input-group-addon" style="border-radius: 0 10px 10px 0;"><i class="glyphicon glyphicon-search"></i></span>
          <input type="hidden" name="cyber_idcyber" value="<?=$_REQUEST['cyber_idcyber']?>">
        </div>
      </form>
    </div>
    <div class="col-md-12" style="padding: 10px"></div>
    <div class="col-md-4">
      <sub><?php 
        
        $keywords = $Cyber->palavraschaves;

        $todos_topicos = CyberTopico::find()->where(['cyber_idcyber' => $Cyber->idcyber])->all();
        if(count($todos_topicos)>0){
          $keywords .= ';';
            foreach ($todos_topicos as $tops) {
              if ($tops->palavraschaves != '') {
                  $keywords .= $tops->palavraschaves;
                  $keywords .= ';';
              }
            }
        }
        
        $arr_palavraschaves = explode(';',$keywords);
        $arr_palavraschaves = array_unique($arr_palavraschaves);
        foreach ($arr_palavraschaves as $palavra) {
           echo '<a class="" href="index?cyber_idcyber='.$Cyber->idcyber.'&CybertopicoSearch%5Bbuscatudo%5D='.$palavra.'">'.$palavra.'</a> ';
        } 
      ?></sub>
      <hr>
      <p align="justify"><?=$Cyber->descricao?></p>
      <hr>
      <?php
        $relacionados = app\models\Usuario::find()->where([
            'or',
            ['=','tipo',$this->context->urlAmigavel($Cyber->cybercol)],
            ['=','tipo','admin',],
        ])->all();
        

        if (count($relacionados) > 0) {
          echo "<h4 class='view-titulo-do-cybertopico'>Usuários:</h4>";
          echo '<ul class="list-group">';
          foreach ($relacionados as $rel) {
            # code...
            $sty_online = '';
            if ($rel->id == Yii::$app->user->identity->id) {
                $sty_online = 'background-color: #39ff14;';
            }

            echo '<li class="list-group-item" style="'.$sty_online.'">';
            echo '<img src="'.Yii::$app->homeUrl.'usuarios/'.$rel->foto.'" width="25" style="border-radius: 20px; float:left;">';
            echo '<strong> - '.$rel->nome.'</strong>';
            echo '<sub style="font-style: italic"> '.$rel->tipo.'</sub>';
            echo "</li>";
          }
          echo "</ul>";
        }
      ?>
    </div>
    <div class="col-md-8" style="padding: 1%">
      <?php foreach ($dataProvider->models as $key => $value): ?>
          <?php
      	  
      	     $favoritei = app\models\TopicoMembros::find()->where([
      	         'topico_idtopico'=>$value->idtopico,
      	         'usuario_id'=>Yii::$app->user->identity->id,
      	         'favorito'=>1
      	     ])->one();
      	     
  	      ?>
  	      <?php //if(!empty($favoritei)): ?>
          
              <div class="col-md-12" style="margin-bottom: 2%;cursor:pointer">
                <div class="cyber-sombra-caixa" >
                  <?php
                     $cor = "lightgray";
                     $cor_borda = "gray";
                     $cyber_cor = $value->cyberIdcyber->cor;
                     if(!empty($cyber_cor)){
                         $hex = $cyber_cor;
                         list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
                         $cor = "rgb($r, $g, $b, 0.1)";
                         $cor_borda = "rgb($r, $g, $b, 0.2)";
                     }
                     $estilo_botal = 'background-color:'.$cor.';color:black;border-color:'.$cor_borda.';border-radius:4px;';
    
                  ?>
                  <div class="cyber-conteudo" style="background-color: <?=$cor?>; height: 120px; <?=!empty($favoritei)?'border:1px solid orange':''?>">
                    <a href="<?=Yii::$app->homeUrl?>cybertopico/view?idtopico=<?=$value->idtopico?>&cyber_idcyber=<?=$value->cyber_idcyber?>">
                      <div class="corpo-topico">
                        <h4 class="titulo">
                         	<?php 
                         	$favoritado = app\models\TopicoMembros::find()->where([
                         	    'topico_idtopico' => $value->idtopico,
                         	    'favorito' => 1,
                         	    'usuario_id' => Yii::$app->user->identity->id,
                         	])->one();
                         	?>
                          <?php if(count($favoritado)>0): ?>
                          	<i class="fas fa-star" style="color:orange"></i>
                          	<?php endif;?>
                          <?=$value->titulo?>
                        </h4>
                        
                        <div class="col-md-12 icons-marcadores" style="opacity: 0.7;">
                          <label>
                            <?php 
                            $comentarios = app\models\CyberComentario::find()->where(['cyber_topico_idtopico'=>$value->idtopico])->all();
                            $conta_comentarios = count($comentarios);
                            
                            ?>
                            <i class="fas fa-comments" style="<?= 'float:right;color:green' ?>"> (<?=$conta_comentarios?>) Comentários</i>
                          </label>
                          <label>
                            <?php 
                            $usuarios_ajudados = app\models\TopicoMembros::find()->where([
                                'topico_idtopico' => $value->idtopico,
                                'ajudou' => 1
                            ])->all();
                            
                            ?>
                            <i class="fas fa-thumbs-up" style="<?= 'float:right;color:blue' ?>"> (<?=count($usuarios_ajudados)?>) Útil</i>
                          </label>
                          <label>
                            <?php 
                            $usuarios_naoajudados = app\models\TopicoMembros::find()->where([
                                'topico_idtopico' => $value->idtopico,
                                'nao_ajudou' => 1
                            ])->all();
                            
                            ?>
                            <i class="fas fa-thumbs-down" style="<?= 'float:right;color:red' ?>"> (<?=count($usuarios_naoajudados)?>) Inútil</i>
                          </label>
                          <label>
                            <?php 
                            $usuarios_favoritaram = app\models\TopicoMembros::find()->where([
                                'topico_idtopico' => $value->idtopico,
                                'favorito' => 1
                            ])->all();
                            
                            ?>
                            <i class="fas fa-star" style="<?= 'float:right;color:orange' ?>"> <?=count($usuarios_favoritaram)?> favoritos</i>
                          </label>
                        </div>
                      </div>
                    </a>
                      <div class="conf-topicos">
                              <span>
                                <?php 
                                    yii\bootstrap\Modal::begin([
                                        'header' => '<h4>Árvore de tópicos</h4>',
                                        'size' => 'modal-lg',
                                        'toggleButton' => [
                                          'label' => '<i class="fa fa-sitemap"></i>',
                                          'class'=>"btn btn-primary", 'title'=>'Visualizar árvore esse registro', 
                                          'style'=>$estilo_botal.'float:right;'
                                        ],
                                    ]);
                                ?>
                                  <?php
    
                                  $raiz = app\models\CyberTopico::find()->where(['topico_pai'=>$value->idtopico])->all();
                                  echo '<div class="tree" style="width:100%;overflow-x:auto;">';
                                  echo "<ul>";
                                  echo '<li>
                                        <a href="#" title="'.$value->descricao.'">'.$value->titulo;
                                  if (!empty($value->imagem)) {
                                    echo "<br><img src='".Yii::$app->homeUrl.'uploads/'.$value->imagem."' height='50'/>";
                                  }
                                  echo '</a>';
    
                                  if (count($raiz) > 0){
                                    echo '<ul>';
                                    foreach ($raiz as $row) {
                                        echo '<li>';
                                        echo '<a href="#" title="'.$row->descricao.'">'.$row->titulo;
                                        if (!empty($row->imagem)) {
                                          echo "<br><img src='".Yii::$app->homeUrl.'uploads/'.$row->imagem."' height='40'/>";
                                        }
                                        echo '</a>';
                                        $ramo = app\models\CyberTopico::find()->where(['topico_pai'=>$row->idtopico])->all();
                                        
                                        if (count($ramo) > 0) {
                                            echo "<ul>";
                                            foreach ($ramo as $row2) {
                                                echo '<li>';
                                                echo '<a href="#" title="'.$row2->descricao.'">'.$row2->titulo;
                                                if (!empty($row2->imagem)) {
                                                  echo "<br><img src='".Yii::$app->homeUrl.'uploads/'.$row2->imagem."' height='30'/>";
                                                }
                                                echo '</a>';
                                                echo '</li>';
                                            }
                                            echo "</ul>";
                                        }
                                        
                                        echo '</li>';
                                    }
                                    echo "</ul>";
                                  }
                                  
                                  echo '</li>';
                                  echo "</ul>";
                                  echo "</div>";
    
                                  ?>
                                <?php
                                  yii\bootstrap\Modal::end();
                                ?>
                              </span>
                        </div>
                    <div class="cyber-rodape" style="background-color: <?=$cor?>">                
                      
                      <?php
                      yii\bootstrap\Modal::begin([
                          'header' => '<h4>Cadastrar novo Tópico</h4>',
                          'toggleButton' => [
                            'label' => '<strong>Novo Subtópico</strong> <i class="glyphicon glyphicon-plus"></i>',
                            'class'=>"btn btn-success", 
                            'title'=>'Cadastrar Novo Cyber', 
                            'style'=>$estilo_botal.'float:left;height: 22px;font-size: 11px;padding: 4px 8px;background-color:'.$cor_borda],
                      ]);
                      $cyber = new app\models\CyberTopico;
                      echo $this->render('create', [
                          'model' => $cyber,
                          'idcyber' => $_REQUEST['cyber_idcyber'],
                          'topico_pai' => $value->idtopico
                      ]);
                      yii\bootstrap\Modal::end();
                      ?>
                      <h6 style="float: right;margin: 5px">Autor: <?=$value->usuario->nome?></h6>
                    </div>
                  </div>
                </div>
              </div>
          <?php //endif; ?>
      <?php endforeach; ?>
		
    </div>
    <div class="col-md-12" style="padding: 10px"><hr></div>
    <?php /*
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idtopico',
            'cyber_idcyber',
            'usuario_id',
            'titulo',
            'tipo',
            // 'descricao:ntext',
            // 'palavraschaves:ntext',
            // 'imagem',
            // 'documento',
            // 'datetime',
            // 'topico_pai',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?> */ 
    ?>
</div>
