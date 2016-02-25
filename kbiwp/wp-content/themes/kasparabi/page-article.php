<?php
    /*
        Template Name: Article
    */
?>
<?php get_header(); ?>

        <?php
            $meta_show_menu = get_post_meta( $post->ID, 'left_menu_checkbox', true );
            $show_menu = !empty($meta_show_menu);
            $menu_slug = get_post_meta( $post->ID, 'menu_select', true );
            $sub_title_menu_slug = get_post_meta( $post->ID, 'sub_title_menu_slug', true );
        ?>

  <div class="container">

    <div class="row">
				<div class="col-xs-12">
						<div class="visible-xs text-center sub-menu-toggle">
								<a data-toggle="collapse" data-target="#sub-menu"><?php _e('Sub menu', 'kasparabi'); ?></a>
						</div>
				</div>
		</div>
		<div class="row">
				<!-- LEFT MENU -->
				<?php if ($show_menu) : ?>

						<div class="col-sm-12 sub-menu">
								<nav class="sub-menu-wrapper">
                                  <?php wp_nav_menu(array(
                                          'menu' => $menu_slug,
                                          'menu_class' => 'nav nav-pills collapse sub-menu',
                                          'menu_id' => 'sub-menu')); ?>
								</nav>
						</div>

				<?php endif; ?>
				<!-- END LEFT MENU -->
		</div>
    <div class="row">
      <!-- ARTICLE -->
      <?php if (have_posts()) : while(have_posts()) : the_post(); ?>

        <div class="col-md-2"></div>
        <div class="col-sm-12 col-md-8">
          <article class="article">
            <h1><?php the_title(); ?></h1>

            <?php if (!empty($sub_title_menu_slug)) { ?>
            <div class="visible-xs text-center sub-title-menu-toggle">
              <a data-toggle="collapse" data-target="#sub-title-menu"><?php _e('Sub title menu', 'kasparabi'); ?></a>
            </div>
            <div class="sub-title-menu-container">
              <?php wp_nav_menu(array(
                'menu' => $sub_title_menu_slug,
                'menu_class' => 'nav nav-pills collapse sub-title-menu',
                'menu_id' => 'sub-title-menu'
              )); ?>
            </div>
            <?php } ?>

            <?php the_content(); ?>
          </article>
        </div>
        <div class="col-md-2"></div>

        <?php endwhile; else : ?>
          <p><?php _e('No page was found.', 'kasparabi'); ?></p>
        <?php endif; ?>
        
      <!-- END ARTICLE -->
      </div>
    </div>
  </div>

<?php get_footer(); ?>
