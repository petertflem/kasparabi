<?php
    /*
        Template Name: Contact Us
    */
?>
<?php get_header(); ?>
        
    <!-- CONTANT US -->
        <div class="container contact-us">
            <div class="row">
                <div class="col-xs-12">
                    <h1><?php _e('Contact us', 'kasparabi'); ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <img src="http://lorempixel.com/100/100/" alt="Bildet av Nathalie Bergsaune" class="img-responsive" />
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut fringilla metus sit amet arcu ornare tempor. Suspendisse mi diam, volutpat ut velit quis, faucibus ultricies enim. Pellentesque sagittis lobortis nulla, id ultrices diam. Donec aliquet arcu et ultrices tempor. Aliquam blandit odio eu sapien euismod, quis laoreet nisl semper
                    </p>
                </div>
                <div class="col-sm-6">
                   <img src="http://lorempixel.com/100/100/" alt="Bildet av Heidi Madelen" class="img-responsive" />
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut fringilla metus sit amet arcu ornare tempor. Suspendisse mi diam, volutpat ut velit quis, faucibus ultricies enim. Pellentesque sagittis lobortis nulla, id ultrices diam. Donec aliquet arcu et ultrices tempor. Aliquam blandit odio eu sapien euismod, quis laoreet nisl semper
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <h4><?php _e('Send us an email', 'kasparabi'); ?></h4>
                    <form role="form">
                        <div class="form-group">
                            <label for="email-subject">Emne</label>
                            <input type="email" class="form-control" id="email-subject" placeholder="Emne..." />
                        </div>
                        <div class="form-group">
                            <label for="email-content">Innhold</label>
                            <textarea class="form-control" id="email-content" placeholder="Innhold..." rows="4" ></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Send epost</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- END CONTACT US -->

<?php get_footer(); ?>