<?php

/* @var $this yii\web\View */
use yii\web\Response;
use app\models\LoginForm;
use yii\helpers\Html;

use app\models\Usuariopermutas as UP;
use app\models\ImovelPermuta as IP;
use app\models\SloProposta as Proposta;
use app\models\SloAgenda as Agenda;

// use rmrevin\yii\fontawesome\FA;

$this->title = 'Café Inteligência Imobiliária';

?>
<style type="text/css">
    #acoisatoda .col-md-2{
        margin-top: 25px;
    }
    #acoisatoda .glyphicon, #acoisatoda .fa, #acoisatoda .fas{
        color: gray !important;
    }
    #acoisatoda img {
        filter: brightness(0.0) opacity(40%);
    }
    #acoisatoda .btn, .btn-info {
        color: black !important;
        background-color: lightgray;
        border: gray;
    }
    #acoisatoda .btn-info:hover {
        background-color: darkgray;
    }
    #acoisatoda .badge {
        right: -2% !important;
    }
    /*Propostas*/
    .btn-proposta{
        width: 100%;
        background-color: gray !important;
        /*margin: 2%;*/
    }
    .btn-proposta img{
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 1px solid #fff;
        float: left;
        background-color: white;
    }
    /*Agendas*/
    .btn-agenda{
        background-color: lightyellow !important;
        padding: 5%;
        margin-bottom: 5%;
        width: 100%;
        text-align: center;
        box-shadow: 5px 5px lightgray;
    }
</style>
<div class="site-index">
    <div class="col-md-12" id="acoisatoda">
        <?php if(!Yii::$app->user->isGuest): ?>
        <h5 style="color:lightgray">Bem vindo, <?=Yii::$app->user->identity->nome?></h5>
        <hr>
        <?php if (!Yii::$app->user->can('cliente')): ?>
            <div class="col-md-6">
                <?php if (!Yii::$app->user->can('cliente')): ?>
                    <div class="col-md-3" style="text-align:center">
                        <a href="<?=Yii::$app->homeUrl.'imovelpermuta'?>" class="btn btn-default" style="width: 135px;">
                            <label class="badge" style="position: absolute;top: -6%;">
                                <?= number_format(app\models\ImovelPermuta::find()->count(),0,",",".") ?>
                            </label>
                            <span class="glyphicon glyphicon-sort" style="text-align:center;font-size:75px;transform: rotate(90deg); height:80px;"></span>
                            <hr style="margin-top:5px;margin-bottom:5px">
                            Permutas<br>(Cruzamentos)
                        </a>
                    </div>
                <?php endif; ?>
                <?php if (!Yii::$app->user->can('cliente')): ?>
                    <div class="col-md-3" style="text-align:center">
                        <a href="<?=Yii::$app->homeUrl.'imoveisexternos'?>" class="btn btn-default" style="width: 135px;">
                            <!-- <span class="glyphicon glyphicon-home" style="text-align:center;font-size:75px"></span> -->
                            <label class="badge" style="position: absolute;top: -6%;">
                                <?= number_format(app\models\Imoveisexternos::find()->count(),0,",",".") ?>
                            </label>
                            <i class="fa fa-building" style="font-size:75px; height:80px;"></i>
                            <hr style="margin-top:5px;margin-bottom:5px">
                            Imóveis Externos<br>(Jetimob)
                        </a>
                    </div>
                <?php endif; ?>
                <?php if (!Yii::$app->user->can('cliente')): ?>
                    <div class="col-md-3" style="text-align:center">
                        <a href="<?=Yii::$app->homeUrl.'visita'?>" class="btn btn-default" style="width: 135px;">
                            <label class="badge" style="position: absolute;top: -6%;">
                                <?= number_format(app\models\Visita::find()->count(),0,",",".") ?>
                            </label>
                            <img src="<?=Yii::$app->homeUrl.'icones/visita_blue.png'?>" alt="" height="80">
                            <hr style="margin-top:5px;margin-bottom:5px">
                            Registro de<br>visitas
                        </a>
                    </div>
                <?php endif; ?>
                <?php if (!Yii::$app->user->can('cliente')): ?>
                    <div class="col-md-3" style="text-align:center;">
                        <a href="<?=Yii::$app->homeUrl.'cyber'?>" class="btn btn-default" style="width: 135px;">
                            <label class="badge" style="position: absolute;top: -6%;">
                                <?= number_format(app\models\Cyber::find()->count(),0,",",".") ?>
                            </label>
                            <i class="fa fa-sitemap" style="font-size:75px; height:80px;"></i>
                            <hr style="margin-top:5px;margin-bottom:5px">
                            Cybers: Gestão<br>de Conhecimentos
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="col-md-6">
            <?php if (Yii::$app->user->can('administrador')): ?>
                <div class="col-md-3" style="text-align:center">
                    <a href="<?=Yii::$app->homeUrl.'vernomapa'?>" class="btn btn-default" style="width: 135px;">
                        <label class="badge" style="position: absolute;top: -6%;">
                            <?= number_format(app\models\Vernomapa::find()->count(),0,",",".") ?>
                        </label>
                        <span class="glyphicon glyphicon-map-marker" style="text-align:center;font-size:75px; height:80px;"></span>
                        <hr style="margin-top:5px;margin-bottom:5px">
                        Cliques (site)<br>Ver no Mapa
                    </a>
                </div>
            <?php endif;?>
            <?php if (Yii::$app->user->can('administrador')): ?>
                <div class="col-md-3" style="text-align:center">
                    <a href="<?=Yii::$app->homeUrl.'corretor'?>" class="btn btn-default" style="width: 135px;">
                        <label class="badge" style="position: absolute;top: -6%;">
                            <?= number_format(app\models\Corretor::find()->count(),0,",",".") ?>
                        </label>
                        <img src="<?=Yii::$app->homeUrl.'icones/corretor.png'?>" alt=""  height="80">
                        <hr style="margin-top:5px;margin-bottom:5px">
                        Corretores<br>(Mod. Visitas)
                    </a>
                </div>
            <?php endif; ?>
            
        </div>
        <?php else:
            if (!Yii::$app->user->isGuest) {
                return $this->goHome();
            }
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->goBack();
            }
            echo $this->render('login', [
                'model' => $model,
            ]);
        ?>

        <?php endif; ?>
    </div>
    <div class="clearfix col-md-12"><br></div>


    <div class="clearfix col-md-12">
    <hr style="padding: 0 1px;">
    </div>
    <?php if (!Yii::$app->user->can('cliente')): ?>
        <div class="col-md-6">
            <h3>Suas Permutas</h3>
            <hr>
            <?php

                $permutas = UP::find()->where(['usuario'=>Yii::$app->user->identity->id])->all();
                foreach ($permutas as $row) {
                    $permuta = IP::find()->where(['idimovel_permuta'=>$row->permuta])->one();
                    echo '<div class="col-md-6">';
                    // echo '<div class="col-md-6">';
                    echo '<a href="'.Yii::$app->homeUrl.'imovelpermuta/view?id='.$permuta['idimovel_permuta'].'" target="blanck" class="btn btn-info" style="margin-bottom:4%;width:100%">';
                    echo '<div class="col-md-12">';
                    echo 'Código: PIN - '.$permuta['codigo'].'<br>';
                    echo 'Tipo: '.substr($permuta['tipo'],0,18).'(...)<br>';
                    echo 'Valor: '.'R$ ' . number_format($permuta['valor_maximo'], 2, ',', '.').'<br>';
                    echo '<label alt="dormitórios" title="dormitórios" style="padding:3px"><span class="glyphicon glyphicon-bed"></span> '.$permuta['dormitorios'].'</label>';
                    echo '<label alt="garagens" title="garagens" style="padding:3px"><span class="glyphicon glyphicon-th"></span> '.$permuta['garagens'].'</label>';
                    if ($permuta['elevador'] != 0) {
                        echo '<label alt="elevador" title="elevador" style="padding:3px"><span class="glyphicon glyphicon-collapse-up"></span></label>';
                    }
                    if ($permuta['sacada'] != 0) {
                        echo '<label alt="sacada" title="sacada" style="padding:3px"><span class="glyphicon glyphicon-modal-window"></span></label>';
                    }
                    echo '</div>';
                    echo '<div class="col-md-12" style="">';
                    echo '<label alt="área privativa" title="área privativa" style="">
                        <span class="glyphicon glyphicon-fullscreen"></span> Área Privativa: '.number_format($permuta['area_privativa'], 2, ',', '.').' m²</label>';
                    echo '<br>';
                    echo '<label alt="área total" title="área total" style="">
                        <span class="glyphicon glyphicon-fullscreen"></span> Área Total: '.number_format($permuta['area_total'], 2, ',', '.').' m²</label>';
                    echo '</div>';
                    echo '<div class="col-md-12">';
                    // echo 'Bairro: '.$row['bairros'].'<br>';
                    echo '</div>';
                    echo '</a>';
                    // echo '</div>';
                    // echo '<div class="col-md-6">';
                    // echo '<h4>Permutas compatíveis</h4>';

                    // echo '</div>';
                    echo '</div>';
                }
            ?>
        </div>

        <div class="col-md-6" style="border-left: 1px solid #eee">
            <h3>Seus tópicos favoritos</h3>
            <hr>
            <?php

                $favoritos = app\models\TopicoMembros::find()->where([
                    'usuario_id' => Yii::$app->user->identity->id,
                    'favorito' => 1
                ])->all();
                $idstopicos = [];
                foreach ($favoritos as $value) {
                    # code...
                    array_push($idstopicos,$value->topico_idtopico);
                }

                $topicos = app\models\CyberTopico::find()->where(['idtopico'=>$idstopicos])->all();

                foreach ($topicos as $row) {
                    // echo $row->titulo.',<br>';
                    echo Html::a('<h4><i class="fas fa-star"></i> '.$row->titulo.'</h4>
                        <hr style="margin: 0 2%">
                        <p>'.
                        nl2br($row->descricao)
                        .'</p>',
                    [
                        '/cybertopico/view',
                        'idtopico' => $row->idtopico,
                        'cyber_idcyber' => $row->cyber_idcyber,
                    ], [
                        'class' => 'btn col-md-12',
                        'style' => 'white-space: pre-line;border:1px solid #eee;color:gray;'
                    ]);
                    echo "<div class='col-md-12 clearfix'><br /></div>";
                }
            ?>
        </div>
    <?php else: ?>
        <!-- Aqui a área de resumos e avisos do Cliente! -->
        <?php
            echo '<div class="col-md-12">';
            echo "<h3>Visitas Marcadas para você:</h3><br>";
            $cliente = app\models\SloCliente::find()->where(['nome'=>Yii::$app->user->identity->nome])->one();
            $agendas = Agenda::find()->where(['slo_cliente_id' => $cliente->id])->all();
            foreach ($agendas as $row) {
                # code...
                echo "<div class='col-md-3'>";
                // echo "<a class='btn btn-primary btn-proposta' href='#'>";
                    echo "<div class='btn-agenda'>";
                        echo '<h3><i class="far fa-clock"></i></h3>';
                        echo "<label>Proposta: PIN-".$row->sloProposta->codigo_imovel.'</label><br>';
                        echo "<label>Data:</label> ".date('d/m/Y',strtotime($row->data)).'<br>';
                        echo "<label>Hora:</label> ".$row->hora.' ('.$row->turno.')'.'<br>';
                        echo "<label>Com o Corretor:</label> ".$row->corretorIdcorretor->nome.'<br>';
                    echo "</div>";
                // echo "</a>";
                echo "</div>";
            }
            echo "</div>";
            echo '<div class="col-md-12 clearfix">';
            echo "<hr>";
            echo "</div>";
            echo '<div class="col-md-12"><h3>Propostas disponíveis:</h3><br>';
            $propostas = Proposta::find()->all();
            foreach ($propostas as $row) {
                # code...
                echo "<div class='col-md-4'>";
                    echo "<a class='btn btn-primary btn-proposta' href='".Yii::$app->homeUrl.'proposta/'."'>";
                        echo "<div class='col-md-4'>";
                            echo "<img src='https://cafeinteligencia27-mrwru33hbcqg1251.netdna-ssl.com/assets/images/logo_site.png'/>";
                        echo "</div>";
                        echo "<div class='col-md-8'>";
                            echo '<h4><b>PIN-'.$row->codigo_imovel.'</b></h4>';
                            echo '<label>Prazo/responder:</label><br>'.date('d/m/Y',strtotime($row->prazo_responder)).'<br>';
                            echo '<label>Valores do Imóvel:</label><br>'.$row->imovel_valores.'<br>';
                        echo "</div>";
                    echo "</a>";
                echo "</div>";
            }
            echo "</div>";


        ?>
    <?php endif; ?>

</div>
<?php
//Seta permissão
/*

$auth = \Yii::$app->authManager;
//Add um NOVO
//$novo_tipo_usuario  = $auth->createRole('cliente');
//Selecionar UM
$novo_tipo_usuario  = $auth->getRole('cliente');
//Cria Permissão
$permissao = $auth->createPermission('cliente-indexa');
//Add Items
//$auth->add($novo_tipo_usuario);
$auth->add($permissao);

//$perm = $auth->getPermission('cliente-indexa');

$auth->addChild($novo_tipo_usuario, $permissao);

// $auth->assign($novo_tipo_usuario,16);
*/
// Mover "*/" para cima junto de "/*" Para redefinir/definir permissões
?>
