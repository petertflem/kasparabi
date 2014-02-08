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

        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        
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
                        <div class="visible-xs text-center">
                            <a data-toggle="collapse" id="toggle-main-nav" data-target="#main-menu">[MOBIL]</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <nav>
                            <?php wp_nav_menu(array(
                                'theme_location' => 'main-navigation',
                                'menu_class' => 'nav nav-pills nav-justified',
                                'menu_id' => 'main-menu'
                            )); ?>
                        </nav>
                    </div>
                </div>
            </div>
        </header>    
        <!-- END HEADER -->