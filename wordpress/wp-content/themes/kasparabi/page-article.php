<?php
    /*
        Template Name: Article
    */
?>
<?php get_header(); ?>
        
        <?php 
            $meta_show_menu = get_post_meta( $post->ID, 'left_menu_checkbox', true ); 
            $show_menu = !empty($meta_show_menu);
        ?>

  <div class="container">

    <div class="row">
				<div class="col-xs-12">
						<div class="visible-xs text-center sub-menu-toggle">
								<a data-toggle="collapse" data-target="#sub-menu">Undermeny</a>
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
												'menu_class' => 'nav nav-pills nav-justified collapse sub-menu',
												'menu_id' => 'sub-menu')); ?>
								</nav>
						</div>

				<?php endif; ?>
				<!-- END LEFT MENU -->
		</div>

      <!-- ARTICLE -->
      <?php if (have_posts()) : while(have_posts()) : the_post(); ?>

        <div class="col-xs-12">
          <article class="article">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
          </article>
        </div>

      <?php endwhile; else : ?>

        <p><?php _e('No page was found.', 'kasparabi'); ?></p>

      <?php endif; ?>
      <!-- END ARTICLE -->

    </div>
  </div>        

<?php get_footer(); ?>