<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
        <meta name="description" content="<?php bloginfo('description'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- css -->
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
        
        <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
        <link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" type="image/icon">
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <?php wp_head(); ?>

        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-49610842-1', 'auto');
          ga('send', 'pageview');

        </script>
    </head>
    <body <?php body_class(); ?>>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        
        <div class="sticky-footer">
        
            <!-- HEADER -->        
            <header>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">                        
                            <a href="<?php echo home_url(); ?>">
                                <?php 
                                    $options = get_option('kasparabi_settings');
                                    $logo_url = isset($options['logo_url']) ? $options['logo_url'] : '';
                                ?>
                            
                                <img src="<?php echo $logo_url; ?>" alt="kaspara bryllup og interiør logo" class="img-responsive" />
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="visible-xs text-center mobile-menu-toggle">
                                <a data-toggle="collapse" id="toggle-main-nav" data-target="#main-menu">Meny</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <nav class="main-menu-wrapper">
                                <?php wp_nav_menu(array(
                                    'theme_location' => 'main-navigation',
                                    'menu_class' => 'nav nav-pills nav-justified collapse main-menu',
                                    'menu_id' => 'main-menu'
                                )); ?>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="header-seperator"></div>
            </header>    
            <!-- END HEADER -->