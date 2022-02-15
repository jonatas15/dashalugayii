<?php
use yii\helpers\Html;

?>

<!-- Sidebar user panel -->
<?php if (!\Yii::$app->user->isGuest): ?>
    <div class="user-panel">
        <div class="pull-left image">
            <?php echo \cebe\gravatar\Gravatar::widget(
                [
                    'email'   => \Yii::$app->user->identity->email,
                    'options' => [
                        'alt' => \Yii::$app->user->identity->username
                    ],
                    'size'    => 64
                ]
            ); ?>
        </div>
        <div class="pull-left info">
            <p><?= \Yii::$app->user->identity->username ?></p>

            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
<?php endif; ?>


<!-- search form -->
<!--<form action="#" method="get" class="sidebar-form">
    <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search..."/>
        <span class="input-group-btn">
            <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
    </div>
</form>-->
<!-- /.search form -->


<?php

// prepare menu items, get all modules
$menuItems = [];

$favouriteMenuItems[] = ['label'=>'MENU PRINCIPAL', 'options'=>['class'=>'header']];

$developerMenuItems = [];

// foreach (\dmstr\helpers\Metadata::getModules() as $name => $module) {
//     $role                        = $name;
//
//     $defaultItem = [
//         'icon' => 'cube',
//         'label'   => $name,
//         'url'     => ['/' . $name],
//         'visible' => Yii::$app->user->can($role) || (Yii::$app->user->identity && Yii::$app->user->identity->isAdmin),
//         'items'   => []
//     ];
//
//     // check for module configuration and assign to favourites
//     $moduleConfigItem = (is_object($module)) ?
//         (isset($module->params['menuItems']) ? $module->params['menuItems'] : []) :
//         (isset($module['params']['menuItems']) ? $module['params']['menuItems'] : []);
//     switch (true) {
//         case (!empty($moduleConfigItem)):
//             $moduleConfigItem            = array_merge($defaultItem, $moduleConfigItem);
//             $moduleConfigItem['visible'] = \dmstr\helpers\RouteAccess::can($moduleConfigItem['url']);
//             $favouriteMenuItems[]        = $moduleConfigItem;
//             continue 2;
//             break;
//         default:
//             $defaultItem['icon'] = 'circle-o';
//             $developerMenuItems[] = $defaultItem;
//             break;
//     }
// }

// create developer menu, when user is admin

    // $menuItems[] = [
    //     'url' => '#',
    //     'icon' => 'cog',
    //     'label'   => 'Developer',
    //     'items'   => $developerMenuItems,
    //     'options' => ['class' => 'treeview'],
    //     'visible' => Yii::$app->user->can('administrador')
    // ];
    //Início de tudo

    # Permissões:
    $administrador = Yii::$app->user->can('administrador');
    $corretor = Yii::$app->user->can('corretor');
    $u_vendas = Yii::$app->user->can('venda');
    $u_alugas = Yii::$app->user->can('locacao');
    $cliente = Yii::$app->user->can('cliente');

    $menuItems[] = [
        'url' => ['/'],
        'icon' => 'home',
        'label'   => 'Início',
        'options' => ['class' => 'treeview'],
        'visible' => true
    ];
    
    $menuItems[] = ['label' => 'Negócios', 'options' => ['class' => 'header'], 'visible' => !Yii::$app->user->isGuest];
    //Módulo de Visitas
    $menuItems[] = [
        'url' => ['/visita'],
        'icon' => 'calendar',
        'label'   => 'Registro de Visitas',
        'options' => ['class' => 'treeview'],
        'visible' => ($administrador or $corretor or $u_vendas or $u_alugas)
    ];
    $menuItems[] = ['label' => 'Utilitários', 'options' => ['class' => 'header'], 'visible' => (Yii::$app->user->identity->id == 1?true:false)];
    //Módulo de Listagem de Clientes
    $menuItems[] = [
      'url' => ['/clientes'],
      'icon' => 'coffee',
      'label'  => 'Cadastro de Clientes',
      'visible' => !Yii::$app->user->isGuest
    ];
    $menuItems[] = [
      'url' => ['/disparoswh'],
      'icon' => 'whatsapp',
      'label'  => 'Disparo em Massa',
      'visible' => !Yii::$app->user->isGuest
    ];
    //Clicks ver no mapa
    $menuItems[] = [
        'url' => ['/site/calculoc'],
        'icon' => 'calculator',
        'label'   => 'Calcular Locação',
        'options' => ['class' => 'treeview'],
        'visible' => 1
    ];
    
    //Gerenciar usuários
    
    $menuItems[] = ['label' => 'SITE', 'options' => ['class' => 'header'], 'visible' => !Yii::$app->user->isGuest];
    $menuItems[] = [
        'url' => ['/vernomapa'],
        'icon' => 'map-marker',
        'label'   => 'Cliques: "Ver no Mapa"',
        'options' => ['class' => 'treeview'],
        'visible' => Yii::$app->user->can('administrador')
    ];
    //Gerenciar CAMPANHAS
    $menuItems[] = [
      'url' => ['/registrocampanhas'],
      'icon' => 'microphone',
      'label'   => 'Campanhas',
      'options' => ['class' => 'treeview'],
      'visible' => Yii::$app->user->can('administrador')
    ];
    $menuItems[] = [
        'url' => ['/usuario'],
        'icon' => 'users',
        'label'   => 'Usuários',
        'options' => ['class' => 'treeview'],
        'visible' => Yii::$app->user->can('administrador')
    ];

echo dmstr\widgets\Menu::widget([
    'options' => [
      'class' => 'sidebar-menu'
    ],
    'items' => \yii\helpers\ArrayHelper::merge($favouriteMenuItems, $menuItems),
    // 'active'=>true
]);
?>
<style>
  .main-sidebar{
    z-index: 100000 !important;
  }
</style>
