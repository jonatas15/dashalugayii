<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <section class="sidebar">

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
    <nav class="mt-2">
    <?php 

        $menuItems = [];

        $favouriteMenuItems[] = ['label'=>'MAIN NAVIGATION', 'options'=>['class'=>'header']];

        $developerMenuItems = [];

        # Permissões:
        $administrador = Yii::$app->user->can('administrador');
        $corretor = Yii::$app->user->can('corretor');
        $u_vendas = Yii::$app->user->can('venda');
        $u_alugas = Yii::$app->user->can('locacao');
        $cliente = Yii::$app->user->can('cliente');

        if($administrador){

        }

        $menuItems[] = [
            'url' => ['/'],
            'icon' => 'home',
            'label'   => 'Início',
            'options' => ['class' => 'treeview'],
            'visible' => true
        ];
        // Módulo de Alertas
        $menuItems[] = [
            'url' => ['/alerta'],
            'icon' => 'bell',
            'label'   => 'Aviso do Sistema',
            'options' => ['class' => 'treeview'],
            'visible' => ($administrador or $corretor or $u_vendas or $u_alugas)
        ];
        //Módulo de Permutas
        $menuItems[] = [
            'url' => ['/imovelpermuta'],
            'icon' => 'exchange',
            'label'   => 'Permutas',
            'items'   => [
            [
                'url' => ['/imovelpermuta'],
                'label'   => 'Pesquisar',
                'icon' => 'search',
            ],
            [
                'url' => ['/imovelpermuta/create'],
                'label'   => 'Cadastrar',
                'icon' => 'plus',
            ],
            [
                'url' => ['/controle'],
                'label'   => 'Logs',
                'icon' => 'history',
            ],
            ],
            'options' => ['class' => 'treeview'],
            'visible' => ($administrador or $corretor or $u_vendas or $u_alugas)
        ];
        //Módulo de Visitas
        $menuItems[] = [
            'url' => 'visita',
            'icon' => 'calendar',
            'label'   => 'Registro de Visitas',
            'items'   => [
            [
                'url' => ['/visita'],
                'label'   => 'Pesquisar',
                'icon' => 'search',
            ],
            // [
            //   'url' => ['/visita/create'],
            //   'label'   => 'Cadastrar',
            //   'icon' => 'plus',
            // ],
            [
                'url' => ['/corretor'],
                'label'   => 'Corretores',
                'icon' => 'user',
                // 'items' => [
                //   [
                //     'url' => ['/corretor'],
                //     'label'   => 'Pesquisar',
                //     'icon' => 'search',
                //   ],
                //   [
                //     'url' => ['/corretor/create'],
                //     'label'   => 'Cadastrar',
                //     'icon' => 'plus',
                //   ],
                // ]
            ],
            ],
            'options' => ['class' => 'treeview'],
            'visible' => ($administrador or $corretor or $u_vendas or $u_alugas)
        ];
        //Módulo de Marcação Visitas
        // $menuItems[] = [
        //     'url' => 'visita',
        //     'icon' => 'calendar-check',
        //     'label'   => 'Agendamento de Visitas',
        //     'items'   => [
        //       [
        //         'url' => ['/sloagenda'],
        //         'label'   => 'Agenda',
        //         'icon' => 'calendar',
        //       ],
        //       [
        //         'url' => ['/slocliente'],
        //         'label'   => 'Registros de Clientes',
        //         'icon' => 'address-book',
        //         'visible' => ($administrador or $corretor or $u_vendas or $u_alugas)
        //       ],
        //     ],
        //     'options' => ['class' => 'treeview'],
        //     'visible' => !Yii::$app->user->isGuest
        // ];
        //Módulo de Listagem de Clientes
        $menuItems[] = [
        'url' => Yii::$app->homeUrl.'clientes',
        'icon' => 'coffee',
        'label'  => 'Cadastro de Clientes',
        'visible' => !Yii::$app->user->isGuest
        ];
        $menuItems[] = [
        'url' => Yii::$app->homeUrl.'disparoswh',
        'icon' => 'whatsapp',
        'label'  => 'Disparo em Massa',
        'visible' => !Yii::$app->user->isGuest
        ];
        //Propostas
        // $menuItems[] = [
        //     'url' => Yii::$app->homeUrl.'/proposta',
        //     'icon' => 'dollar',
        //     'label'   => 'Pesquisa Externa',
        //     'items'   => [
        //       [
        //         'url' => ['/proposta'],
        //         'label'   => 'Pesquisar Propostas',
        //         'icon' => 'search',
        //       ],
        //       [
        //         'url' => ['/proposta/create'],
        //         'label'   => 'Nova Proposta',
        //         'icon' => 'plus',
        //       ],
        //     ],
        //     'options' => ['class' => 'treeview'],
        //     'visible' => ($administrador or $corretor or $u_vendas or $u_alugas)
        // ];
        //Pesquisa Externa
        $menuItems[] = [
            'url' => '#',
            'icon' => 'search',
            'label'   => 'Pesquisa Externa',
            'items'   => [
            [
                'url' => ['/imoveisexternos'],
                'label'   => 'Imóveis Externos',
                'icon' => 'search',
            ],
            [
                'url' => ['/imobiliarias'],
                'label'   => 'Imobiliárias',
                'icon' => 'umbrella',
            ],
            [
                'url' => ['/condominio'],
                'label'   => 'Condomínios',
                'icon' => 'building',
            ],
            ],
            // 'options' => ['class' => 'treeview'],
            'visible' => ($administrador or $corretor or $u_vendas or $u_alugas)
        ];
        //Cyber - Gestão de Conhecimento
        if(Yii::$app->user->can('administrador')){
            $cybers = app\models\Cyber::find()->all();
        }else{
            $cybers = app\models\Cyber::find()->where([
                'or',
                ['=', 'cybercol', Yii::$app->user->identity->tipo],
                ['=', 'cybercol', 'publico'],
            ])->all();    
        }
        
        $vetor_cybers = [[
                'url' => ['/cyber'],
                'label'   => 'Todos os Cybers',
                'icon' => 'sitemap',
            ],];
        //if(Yii::$app->user->can('administrador')){
            foreach ($cybers as $c) {
                # code...
                if ($c) {
                    array_push($vetor_cybers, [
                    'url' => ['/cybertopico/index', 'cyber_idcyber' => $c->idcyber],
                    'label' => $c->nome,
                    'icon' => 'th-list',
                ]);
                }
            }
        //}
        

        // $menuItems[] = [
        //     'url' => ['/cyber'],
        //     'icon' => 'sitemap',
        //     'label'   => 'Gestão/Conhecimento',
        //     'items'   => $vetor_cybers,
        //     'options' => ['class' => 'treeview'],
        //     'visible' => ($administrador or $corretor or $u_vendas or $u_alugas)
        // ];

        $menuItems[] = [
        'url' => '',
        'icon' => 'cog',
        'label' => 'Utilitários',
        'items' => [
            $vetor_cybers
        ],
        'options' => ['class' => 'treeview'],
        'visible' => ($administrador or $corretor or $u_vendas or $u_alugas)
        ];
        //Clicks ver no mapa
        // $menuItems[] = ['label' => 'Utilitários', 'options' => ['class' => 'header'], 'visible' => (Yii::$app->user->identity->id == 1?true:false)];
        $menuItems[] = [
            'url' => ['/vernomapa'],
            'icon' => 'map-marker',
            'label'   => '+ "Ver no Mapa" (Site)',
            'options' => ['class' => 'treeview'],
            'visible' => Yii::$app->user->can('administrador')
        ];
        //Clicks ver no mapa
        $menuItems[] = [
            'url' => ['/site/calculoc'],
            'icon' => 'calculator',
            'label'   => 'Calcular Locação',
            'options' => ['class' => 'treeview'],
            'visible' => 1
        ];
        //Gerenciar CAMPANHAS
        $menuItems[] = [
        'url' => ['/registrocampanhas'],
        'icon' => 'microphone',
        'label'   => 'Campanhas',
        'options' => ['class' => 'treeview'],
        'visible' => Yii::$app->user->can('administrador')
        ];
        //Gerenciar usuários
        $menuItems[] = [
            'url' => ['/usuario'],
            'icon' => 'users',
            'label'   => 'Usuários',
            'options' => ['class' => 'treeview'],
            'visible' => Yii::$app->user->can('administrador')
        ];
    
    ?>

        <?php 
        /**
         * 
        = dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Some tools',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) 
        
         */

        echo dmstr\widgets\Menu::widget([
            'options' => [
              'class' => 'sidebar-menu  nav-sidebar',
              'data-widget'=> 'treeview'
            ],
            'items' => \yii\helpers\ArrayHelper::merge($favouriteMenuItems, $menuItems),
            // 'active'=>true
        ]);
        ?>
    </nav>
    </section>

</aside>
