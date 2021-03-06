<?php
use yii\helpers\Html;
?>
<style>
    .main-panel>.navbar {
        /* background-color: #191919 !important; */
        /* background-color: #000 !important;
        font-style: bold !important;
        font-family: Georgia, "Times New Roman", Times, serif !important;
        font-size: 12px !important; */
        /* background-image: url("<?=Yii::$app->homeUrl?>img/sidebar-5.jpg");
        background-position: center top;
        background-size: 100% auto; */
    }
</style>
<nav class="navbar navbar-transparent navbar-expand-lg navbar-absolute fixed-top" role="navigation-demo">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <!-- <div class="navbar-wrapper"> -->
            <h1>
                <a class="" href="#"><?=$this->title;?></a>
            </h1>
        <!-- </div> -->

        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end">
            <!-- <form class="navbar-form">
              <span class="bmd-form-group"><div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div></span>
            </form> -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#pablo">
                        <i class="material-icons">dashboard</i>
                        <p class="d-lg-none d-md-block">
                            Stats
                        </p>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">notifications</i>
                        <span class="notification">5</span>
                        <p class="d-lg-none d-md-block">
                            Some Actions
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Mike John responded to your email</a>
                        <a class="dropdown-item" href="#">You have 5 new tasks</a>
                        <a class="dropdown-item" href="#">You're now friend with Andrew</a>
                        <a class="dropdown-item" href="#">Another Notification</a>
                        <a class="dropdown-item" href="#">Another One</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">person</i>
                        <p class="d-lg-none d-md-block">
                            Account
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a class="dropdown-item" href="#">Settings</a>
                        <div class="dropdown-divider"></div>
                        <?=
                            Yii::$app->user->isGuest ? 
                                Html::a(
                                    'Log in',
                                    ['/site/login'],
                                    ['class'=>'dropdown-item']
                                ) : 
                                Html::a(
                                    'Log out ('.Yii::$app->user->identity->username.')',
                                    ['/site/logout'],
                                    ['class'=>'dropdown-item','data-method'=>'post']
                                );
                        ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- /.container-->
</nav>