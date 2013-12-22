<?php
	/*
		Template Name: Inspiration Picker
	*/	
?>

<?php get_header(); ?>

    <?php 

        $wedding_link = esc_attr( get_post_meta( $post->ID, 'wedding_archive_link', true ) );
        $wedding_archive_type = esc_attr( get_post_meta( $post->ID, 'cat_wedding', true ) );
      
        $interior_link = esc_attr( get_post_meta( $post->ID, 'interior_archive_link', true ) );
        $interior_archive_type = esc_attr( get_post_meta( $post->ID, 'cat_interior', true ) );
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
                    <img src="http://lorempixel.com/1920/1080/" alt="Bilde for bryllupinspirasjon" class="img-responsive">
                    <h4>Bryllup</h4>
                </a>
            </div>
            <div class="col-sm-6">
                <a href="<?php echo $interior_link . '?category=' . $interior_archive_type; ?>">
                    <img src="http://lorempixel.com/1920/1080/" alt="Bilde for interiør inspirasjon" class="img-responsive">
                    <h4>Interiør</h4>
                </a>
            </div>
        </div>
    </div>
    <!-- END INSPIRATION -->

<?php get_footer(); ?>