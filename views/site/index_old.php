<?php

/* @var $this yii\web\View */
use yii\web\Response;
use app\models\LoginForm;
use yii\helpers\Html;
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
</style>
<div class="site-index">
    <?php
        // $auth = \Yii::$app->authManager;
        // // //Criando tipos de Usuários

        // $corretor = $auth->getRole('corretor');
        // $perm = $auth->getPermission('faturas-indexa');
        // $auth->addChild($corretor, $perm);
        // $auth->assign($corretor,1);

        // print_r($corretor);


        // $auth->add($corretor);
        // $faturas_view = $auth->createPermission('faturas-indexa');
        // $auth->addChild($corretor, $faturas_view);

        


        // $administrador  = $auth->createRole('administrador');
        // $locatario      = $auth->createRole('locatario');
        // $proprietario   = $auth->createRole('proprietario');
        // //adiciona os tipos
        // $auth->add($administrador);
        // $auth->add($locatario);
        // $auth->add($proprietario);
        // //Criando permissões
        // // -- Usuários
        // $usuario_view = $auth->createPermission('usuario-indexa');
        // $usuario_novo = $auth->createPermission('usuario-create');
        // $usuario_edit = $auth->createPermission('usuario-update');
        // $usuario_delt = $auth->createPermission('usuario-delete');
        // // -- Proprietários
        // $proprietario_view = $auth->createPermission('proprietario-indexa');
        // $proprietario_novo = $auth->createPermission('proprietario-create');
        // $proprietario_edit = $auth->createPermission('proprietario-update');
        // $proprietario_delt = $auth->createPermission('proprietario-delete');
        // // -- Locatários
        // $locatario_view = $auth->createPermission('locatario-indexa');
        // $locatario_novo = $auth->createPermission('locatario-create');
        // $locatario_edit = $auth->createPermission('locatario-update');
        // $locatario_delt = $auth->createPermission('locatario-delete');
        // // -- Extratos Faturas e movimentações
        // $faturas_view = $auth->createPermission('faturas-indexa');
        // $faturas_novo = $auth->createPermission('faturas-create');
        // $faturas_edit = $auth->createPermission('faturas-update');
        // $faturas_delt = $auth->createPermission('faturas-delete');
        // // Adiciona permissões
        // // -- Usuários
        // $auth->add($usuario_view);
        // $auth->add($usuario_novo);
        // $auth->add($usuario_edit);
        // $auth->add($usuario_delt);
        // // -- Proprietários
        // $auth->add($proprietario_view);
        // $auth->add($proprietario_novo);
        // $auth->add($proprietario_edit);
        // $auth->add($proprietario_delt);
        // // -- Locatários
        // $auth->add($locatario_view);
        // $auth->add($locatario_novo);
        // $auth->add($locatario_edit);
        // $auth->add($locatario_delt);
        // // -- Extratos Faturas e movimentações
        // $auth->add($faturas_view);
        // $auth->add($faturas_novo);
        // $auth->add($faturas_edit);
        // $auth->add($faturas_delt);

        // //Seta permissões aos usuários-níveis - Administrador
        // // -- Usuários
        // $auth->addChild($administrador, $usuario_view);
        // $auth->addChild($administrador, $usuario_edit);
        // $auth->addChild($administrador, $usuario_novo);
        // $auth->addChild($administrador, $usuario_delt);
        // // -- Proprietários
        // $auth->addChild($administrador, $proprietario_view);
        // $auth->addChild($administrador, $proprietario_novo);
        // $auth->addChild($administrador, $proprietario_edit);
        // $auth->addChild($administrador, $proprietario_delt);
        // // -- Locatários
        // $auth->addChild($administrador, $locatario_view);
        // $auth->addChild($administrador, $locatario_novo);
        // $auth->addChild($administrador, $locatario_edit);
        // $auth->addChild($administrador, $locatario_delt);
        // // -- Extratos Faturas e movimentações
        // $auth->addChild($administrador, $faturas_view);
        // $auth->addChild($administrador, $faturas_novo);
        // $auth->addChild($administrador, $faturas_edit);
        // $auth->addChild($administrador, $faturas_delt);

        // //Seta permissões aos usuários-níveis - Locatário
        // // -- Proprietários
        // $auth->addChild($locatario, $proprietario_view);
        // // -- Locatários
        // $auth->addChild($locatario, $locatario_view);
        // // -- Extratos Faturas e movimentações
        // $auth->addChild($locatario, $faturas_view);

        // //Seta permissões aos usuários-níveis - Proprietário
        // // -- Proprietários
        // $auth->addChild($proprietario, $proprietario_view);
        // // -- Locatários
        // $auth->addChild($proprietario, $locatario_view);
        // // -- Extratos Faturas e movimentações
        // $auth->addChild($proprietario, $faturas_view);

    ?>
    <div class="col-md-12" id="acoisatoda">
        <?php if(!Yii::$app->user->isGuest): ?>
        <h5 style="color:lightgray">Dashboard</h5>
        <hr>
        <!--
        <div class="col-md-3" style="text-align:center">
            <a href="<?=Yii::$app->homeUrl.'extrato'?>" class="btn btn-default" style="width:80%;">
            <span class="glyphicon glyphicon-list-alt" style="text-align:center;font-size:75px"></span>
            <hr style="margin-top:5px;margin-bottom:5px">
            Extratos e Faturas
            </a>
        </div>
        <div class="col-md-3" style="text-align:center">
            <a href="<?=Yii::$app->homeUrl.'proprietario'?>" class="btn btn-default" style="width:80%;">
            <span class="glyphicon glyphicon-home" style="text-align:center;font-size:75px"></span>
            <hr style="margin-top:5px;margin-bottom:5px">
            Proprietários
            </a>
        </div>
        <div class="col-md-3" style="text-align:center">
            <a href="<?=Yii::$app->homeUrl.'locatario'?>" class="btn btn-default" style="width:80%;">
            <span class="glyphicon glyphicon-briefcase" style="text-align:center;font-size:75px"></span>
            <hr style="margin-top:5px;margin-bottom:5px">
            Locatários
            </a>
        </div>
        -->
        <div class="col-md-6">
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
            <!-- <div class="col-md-3" style="text-align:center">
                <a href="<?php //=Yii::$app->homeUrl.'site/relatorios'?>" class="btn btn-default" style="width:80%;">
                <span class="glyphicon glyphicon-map-marker" style="text-align:center;font-size:75px"></span>
                <hr style="margin-top:5px;margin-bottom:5px">
                Cliques: Ver no Mapa (old)
                </a>
            </div> -->
            
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
            <?php /* if (Yii::$app->user->can('administrador')): ?>
                <div class="col-md-2" style="text-align:center">
                    <a href="<?=Yii::$app->homeUrl.'imobiliarias'?>" class="btn btn-default" style="width: 135px;">
                    <!-- <span class="glyphicon glyphicon-home" style="text-align:center;font-size:75px"></span> -->
                    <!-- <i class="fa fa-map-marker" style="font-size:75px"></i> -->
                    <img src="<?=Yii::$app->homeUrl.'icones/imobiliaria_blue.png'?>" alt="" height="80">
                    <hr style="margin-top:5px;margin-bottom:5px">
                    Imobiliárias<br>(Jetimob)
                    </a>
                </div>
            <?php endif; */ ?>
            <div class="col-md-3" style="text-align:center">
                <a href="<?=Yii::$app->homeUrl.'visita'?>" class="btn btn-default" style="width: 135px;">
                    <!-- <span class="glyphicon glyphicon-home" style="text-align:center;font-size:75px"></span> -->
                    <!-- <i class="fa fa-map-marker" style="font-size:75px"></i> -->
                    <label class="badge" style="position: absolute;top: -6%;">
                        <?= number_format(app\models\Visita::find()->count(),0,",",".") ?>
                    </label>
                    <img src="<?=Yii::$app->homeUrl.'icones/visita_blue.png'?>" alt="" height="80">
                    <hr style="margin-top:5px;margin-bottom:5px">
                    Registro de<br>visitas
                </a>
            </div>
            <div class="col-md-3" style="text-align:center;">
                <a href="<?=Yii::$app->homeUrl.'cyber'?>" class="btn btn-default" style="width: 135px;">
                    <!-- <span class="glyphicon glyphicon-home" style="text-align:center;font-size:75px"></span> -->
                    <label class="badge" style="position: absolute;top: -6%;">
                        <?= number_format(app\models\Cyber::find()->count(),0,",",".") ?>
                    </label>
                    <i class="fa fa-sitemap" style="font-size:75px; height:80px;"></i>
                    <hr style="margin-top:5px;margin-bottom:5px">
                    Cybers: Gestão<br>de Conhecimentos
                </a>
            </div>
        </div>
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
                        <!-- <span class="glyphicon glyphicon-home" style="text-align:center;font-size:75px"></span> -->
                        <!-- <i class="fa fa-map-marker" style="font-size:75px"></i> -->
                        <label class="badge" style="position: absolute;top: -6%;">
                            <?= number_format(app\models\Corretor::find()->count(),0,",",".") ?>
                        </label>
                        <img src="<?=Yii::$app->homeUrl.'icones/corretor.png'?>" alt=""  height="80">
                        <hr style="margin-top:5px;margin-bottom:5px">
                        Corretores<br>(Mod. Visitas)
                    </a>
                </div>
            <?php endif; ?>
            <?php if (Yii::$app->user->can('administrador')): ?>
                <div class="col-md-3" style="text-align:center">
                    <a href="<?=Yii::$app->homeUrl.'proposta'?>" class="btn btn-default" style="width: 135px;">
                        <!-- <i class="fa fa-address-book" style="font-size:70px; height:80px;"></i> -->
                        <label class="badge" style="position: absolute;top: -6%;">
                            <?= number_format(app\models\SloProposta::find()->count(),0,",",".") ?>
                        </label>
                        <i class="fas fa-comments-dollar" style="font-size:70px; height:80px;"></i>
                        <hr style="margin-top:5px;margin-bottom:5px">
                        Registro de<br>Propostas
                    </a>
                </div>
            <?php endif; ?>

            <div class="col-md-3" style="text-align:center">
                <a href="<?=Yii::$app->homeUrl.'sloagenda'?>" class="btn btn-default" style="width: 135px;">
                    <label class="badge" style="position: absolute;top: -6%;">
                        <?= number_format(app\models\SloAgenda::find()->count(),0,",",".") ?>
                    </label>
                    <img src="<?=Yii::$app->homeUrl.'icones/visita_blue.png'?>" alt="" height="80" style="-moz-transform: scaleX(-1);-o-transform: scaleX(-1);-webkit-transform: scaleX(-1);transform: scaleX(-1);">
                    <hr style="margin-top:5px;margin-bottom:5px">
                    Agendamento de<br>visitas
                </a>
            </div>
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
    <div class="col-md-6">
        <h3>Suas Permutas</h3>
        <hr>
        <?php
            use app\models\Usuariopermutas as UP;
            use app\models\ImovelPermuta as IP;
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
