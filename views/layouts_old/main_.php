<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Café Inteligência Imobiliária',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            // ['label' => 'Sobre', 'url' => ['/site/about']],
            // ['label' => 'Contato', 'url' => ['/site/contact']],
            // '<li class="divider"></li>',
            // '<li class="dropdown-header">Extratos</li>',
            //<span class="glyphicon glyphicon-house"></span>
            // ['label' => 'Locações', 
            //     'visible' => (Yii::$app->user->can('administrador')?true:false),
            //     'items' => [
            //         ['label' => 'Bases de Imóveis', 'url' => ['/base']],
            //         ['label' => 'Proprietários', 'url' => ['/proprietario']],
            //         ['label' => 'Locatários', 'url' => ['/locatario']],
            //         ['label' => 'Extratos', 'url' => ['/extrato']],
            //         ]],
            ['label' => 'Permutas', 
                'visible' => (Yii::$app->user->isGuest?false:true),
                'items' => [
                    ['label' => 'Pesquisar', 'url' => ['/imovelpermuta']],
                    ['label' => 'Cadastrar Nova','url' => ['/imovelpermuta/create']],
                    ['label' => 'Logs','url' => ['/controle'],'visible' => (Yii::$app->user->can('administrador')?true:false)],
                ]
            ],
            ['label' => 'Visitas', 
                'visible' => (Yii::$app->user->isGuest?false:true),
                'items' => [
                    ['label' => 'Pesquisar', 'url' => ['/visita']],
                    ['label' => 'Cadastrar Nova','url' => ['/visita/create']],
                    ['label' => 'Corretores','url' => ['/corretor'],'visible' => Yii::$app->user->can('administrador')?true:false,],
                ]
            ],
            ['label' => 'Pesq. externa', 
                'visible' => (Yii::$app->user->isGuest?false:true),
                'items' => [
                    ['label' => 'Imóveis Externos', 'url' => ['/imoveisexternos']],
                    ['label' => 'Imobiliárias', 'url' => ['/imobiliarias'],
                        'visible' => Yii::$app->user->can('administrador')?true:false,
                    ],
                    ['label' => 'Condomínios', 'url' => ['/condominio'],
                        'visible' => Yii::$app->user->can('administrador')?true:false,
                    ],
                ]
            ],
            ['label' => 'Relatórios', 
                'visible' => ((Yii::$app->user->can('administrador'))?true:false),
                'items' => [
                    ['label' => 'Site: Clicks Ver-Imóvel-no-Mapa', 'url' => ['/vernomapa']],
                ]
            ],
            ['label' => 'Usuários', 
                'visible' => ((Yii::$app->user->can('administrador'))?true:false),
                'items' => [
                    ['label' => 'Pesquisar', 'url' => ['/usuario']],
                    ['label' => 'Cadastrar Novo','url' => ['/usuario/create']],
            ]],
            [
                'label' => 'Solicitação de Contratos', 
                'url' => 'https://app.pipefy.com/public/form/udhcltYc',
                'linkOptions' => ['target'=>'_blank'],
            ],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->nome . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
