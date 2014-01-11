<?php
	/*
		Template Name: Inspiration Picker
	*/	
?>

<?php get_header(); ?>

    <?php 
        $meta = get_post_meta($post->ID);

        $wedding_link = isset($meta['wedding_archive_link']) ? esc_attr( $meta['wedding_archive_link'][0] ) : '';
        $wedding_archive_type = isset($meta['cat_wedding']) ? esc_attr( $meta['cat_wedding'][0] ) : '';
      
        $interior_link = isset($meta['interior_archive_link']) ? esc_attr( $meta['interior_archive_link'][0] ) : '';
        $interior_archive_type = isset($meta['cat_interior']) ? esc_attr( $meta['cat_interior'][0] ) : '';

        $wedding_image = isset($meta['wedding_inspiration_image']) ? $meta['wedding_inspiration_image'][0] : '';
        $interior_image = isset($meta['interior_inspiration_image']) ? $meta['interior_inspiration_image'][0] : '';
    ?>

	<!-- INSIPRATION -->
    <div class="container inspiration">
        <div class="row">
            <div class="col-xs-12">
                <h1>Inspirasjon</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <a href="<?php echo $wedding_link . '?category=' . $wedding_archive_type; ?>">
                    <img src="<?php echo $wedding_image; ?>" alt="Bilde for bryllupinspirasjon" class="img-responsive">
                    <h4><?php _e('Bryllup', 'kasparabi'); ?></h4>
                </a>
            </div>
            <div class="col-sm-6">
                <a href="<?php echo $interior_link . '?category=' . $interior_archive_type; ?>">
                    <img src="<?php echo $interior_image; ?>" alt="Bilde for interiør inspirasjon" class="img-responsive">
                    <h4><?php _e('Interiør', 'kasparabi'); ?></h4>
                </a>
            </div>
        </div>
    </div>
    <!-- END INSPIRATION -->

<?php get_footer(); ?>