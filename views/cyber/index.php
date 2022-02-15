<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CyberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cybers');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>

@media (max-width: 480px) {
    .cyber-conteudo{
        height: 110px !important;
    }
    .cyber-conteudo sub{
        bottom: -3.25em !important;
        position: absolute !important;
        float: left !important;
    }
    .cyber-conteudo strong{
        float: left;
    }
    .cyber-conteudo .comandos-btn{
            float: right;
    margin-top: 10%
    }
}
@media (min-width: 480px) and (max-width: 991px) {

    .cyber-conteudo .comandos-btn{
            float: right;
            margin-top: -3%;
    }
}

</style>
<div class="cyber-index">


    <div class="col-md-12">
      <h3 style="float: left;"><?= Html::encode($this->title) ?></h3>
      <?php
      yii\bootstrap\Modal::begin([
          'header' => '<h4>Cadastrar novo Cyber</h4>',
          'toggleButton' => ['label' => 'Novo <i class="glyphicon glyphicon-plus"></i>','class'=>"btn btn-success", 'title'=>'Cadastrar Novo Cyber', 'style'=>'float:right;margin-top: 20px; margin-bottom: 10px;'],
      ]);
      $cyber = new app\models\Cyber;
      echo $this->render('create', [
          'model' => $cyber,
      ]);

      yii\bootstrap\Modal::end();

      ?>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
      <form>
        <div class="input-group">
          <input type="text" name="CyberSearch[buscatudo]"  value="<?=$_REQUEST['CyberSearch']['buscatudo']?>" class="form-control" style="border-radius: 10px 0 0 10px;" placeholder="Busque por Nome, descrição ou palavras chaves">
          <span class="input-group-addon" style="border-radius: 0 10px 10px 0;"><i class="glyphicon glyphicon-search"></i></span>
        </div>
      </form>
    </div>
    <div class="col-md-12" style="padding: 10px"></div>
    <div class="col-md-12" style="padding: 10px">
      <?php foreach ($dataProvider->models as $key => $value): ?>
        <div class="col-md-6" style="margin-bottom: 10px">
          <div class="cyber-sombra-caixa">
            <?php
               $cor = "lightgray";
               $cor_borda = "gray";
               if(!empty($value->cor)){
                   $hex = $value->cor;
                   list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
                   $cor = "rgb($r, $g, $b, 0.1)";
                   $cor_borda = "rgb($r, $g, $b, 0.2)";

               }
               $estilo_botal = 'background-color:'.$cor.';color:black;border-color:'.$cor_borda.';border-radius:4px;';

            ?>
            <div class="cyber-conteudo" style="background-color: <?=$cor?>; height: 60px;">
              <div style="padding: 5px 10px; width: 100%;">
                <h4 class="titulo">
                  <?php
                    $topicos = app\models\CyberTopico::find()->where(['cyber_idcyber'=>$value->idcyber])->all();
                    $conta_topicos = count($topicos);
                  ?>
                  <div class="col-md-8">
                      <a href="<?=Yii::$app->homeUrl.'/cybertopico/index?cyber_idcyber='.$value->idcyber.($_REQUEST['CyberSearch']['buscatudo'] != '' ? '&CybertopicoSearch%5Bbuscatudo%5D='.$_REQUEST['CyberSearch']['buscatudo'] :'')?>" style="color:#000;vertical-align: sub;"><strong><?=substr($value->nome,0,40)?></strong>
                      <!-- <sub>Autor: <?=$value->usuario->nome?></sub> -->
                      <sub style="font-size: 10px">
                        <?= '  <i class="glyphicon glyphicon-list"></i> '.$conta_topicos.' tópicos';?>
                      </sub>
                      </a>
                  </div>
                  <div class="col-md-4 comandos-btn">
                      <span>
                        <?= Html::a('<i class="glyphicon glyphicon-trash"></i>', ['delete', 'id' => $value->idcyber], [
                            'class' => 'btn btn-danger',
                            'style'=>$estilo_botal.'float:right;',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]) ?>
                      </span>
                      <span>
                        <?php
                          yii\bootstrap\Modal::begin([
                              'header' => '<h4>Editar Cyber</h4>',
                              'toggleButton' => ['label' => '<i class="glyphicon glyphicon-edit"></i>','class'=>"btn btn-primary", 'title'=>'Editar esse Cyber', 'style'=>$estilo_botal.'float:right'],
                          ]);

                          $cyber_update = $this->context->findModel($value->idcyber);
                          echo $this->render('update', [
                              'model' => $cyber_update,
                              'prefixo_id' => $value->idcyber,
                          ]);

                          yii\bootstrap\Modal::end();
                        ?>
                      </span>
                      <?php
                          yii\bootstrap\Modal::begin([
                              'header' => '<h4>Árvore de tópicos</h4>',
                              'size' => 'modal-lg',
                              'toggleButton' => [
                                'label' => '<i class="fa fa-sitemap"></i>',
                                'class'=>"btn btn-primary", 'title'=>'Visualizar esse registro',
                                'style'=>$estilo_botal.'float:right;'
                              ],
                          ]);
                      ?>
                      <?php

                        $raiz = app\models\CyberTopico::find()->where(['cyber_idcyber'=>$value->idcyber,'topico_pai'=>null])->all();
                        echo '<div class="tree" style="width:100%;overflow-x:auto;">';

                        if (count($raiz) > 0){
                          echo '<ul>';
                          foreach ($raiz as $row) {
                              echo '<li>';
                              echo '<a href="#" title="'.$row->descricao.'">'.$row->titulo;
                              if (!empty($row->imagem)) {
                                echo "<br><img src='".Yii::$app->homeUrl.'uploads/'.$row->imagem."' height='40'/>";
                              }
                              echo '</a>';
                              $ramo = app\models\CyberTopico::find()->where(['topico_pai'=>$row->idtopico])->andWhere(['not', ['topico_pai' => null]])->all();

                              if (count($ramo) > 0) {
                                  echo "<ul>";
                                  foreach ($ramo as $row2) {
                                      echo '<li>';
                                      echo '<a href="#" title="'.$row2->descricao.'">'.$row2->titulo;
                                      if (!empty($row2->imagem)) {
                                        echo "<br><img src='".Yii::$app->homeUrl.'uploads/'.$row2->imagem."' height='30'/>";
                                      }
                                      echo '</a>';

                                      $ramo2 = app\models\CyberTopico::find()->where(['topico_pai'=>$row2->idtopico])->andWhere(['not', ['topico_pai' => null]])->all();
                                      if (count($ramo2) > 0) {
                                          echo "<ul>";
                                          foreach ($ramo2 as $row3) {
                                              echo '<li>';
                                              echo '<a href="#" title="'.$row3->descricao.'">'.$row3->titulo;
                                              if (!empty($row3->imagem)) {
                                                echo "<br><img src='".Yii::$app->homeUrl.'uploads/'.$row3->imagem."' height='30'/>";
                                              }
                                              echo '</a>';
                                              echo '</li>';
                                          }
                                          echo '</ul>';
                                      }
                                      echo '</li>';
                                  }
                                  echo "</ul>";
                              }
                              echo '</li>';
                          }
                          echo "</ul>";
                        }
                        echo "</div>";

                      ?>
                      <?php
                        yii\bootstrap\Modal::end();
                      ?>
                  </div>
                </h4>
                <br>


                <?php /*
                <a href="<?=Yii::$app->homeUrl.'/cybertopico/index?cyber_idcyber='.$value->idcyber?>" style="color:#000"><div><p align="justify"><?=substr($value->descricao,0,200).'(...)'?></p></div></a>
                */ ?>
              </div>

            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="col-md-12" style="padding: 10px"><hr></div>

    <!-- Num segundo momento!
    <div class="tree">
      	<ul>
        <li>
          <a href="#">Parent</a>
          <ul>
            <li>
              <a href="#">Child</a>
              <ul>
                <li>
                  <a href="#">Grand Child</a>
                </li><li>
                  <a href="#">Grand Child</a>
                  <ul>
                    <li>
                      <a href="#">Grand Child</a>
                    </li><li>
                      <a href="#">Grand Child</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li><li>
              <a href="#">Child</a>
              <ul>
                <li>
                  <a href="#">Grand Child</a>
                  <ul>
                    <li>
                      <a href="#">Grand Grand Child</a>
                    </li>
                  </ul>
                </li><li>
                  <a href="#">Grand Child</a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </div>
    -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
</div>
