<?php
    /*
        Template Name: Contact Us
    */
?>
<?php
 
    //response generation function
    $response = "";

    //function to generate response
    function my_contact_form_generate_response($type, $message){

        global $response;

        if($type == "success") $response = "<div class='success'>{$message}</div>";
        else $response = "<div class='error'>{$message}</div>";

    }

    //response messages
    $not_human       = "Human verification incorrect.";
    $missing_content = "Please supply all information.";
    $email_invalid   = "Email Address Invalid.";
    $message_unsent  = "Message was not sent. Try Again.";
    $message_sent    = "Thanks! Your message has been sent.";
     
    //user posted variables
    $name = $_POST['message_name'];
    $email = $_POST['message_email'];
    $message = $_POST['message_text'];
    $human = $_POST['message_human'];
     
    //php mailer variables
    $to = get_option('admin_email');
    $subject = "Someone sent a message from " . get_bloginfo('name');
    $headers = "Reply-To: " . $name . "<" . $email . ">" . "\r\n";

    if(!$human == 0){
        if($human != 2) 
            my_contact_form_generate_response("error", $not_human); //not human!
        else {

            //validate email
            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
                my_contact_form_generate_response("error", $email_invalid);
            else //email is valid
            {
                //validate presence of name and message
                if(empty($name) || empty($message)){
                    my_contact_form_generate_response("error", $missing_content);
                }
                else //ready to go!
                {
                    $sent = wp_mail($to, $subject, strip_tags($message), $headers);
                    
                    if($sent) 
                        my_contact_form_generate_response("success", $message_sent); //message sent!
                    else 
                        my_contact_form_generate_response("error", $message_unsent); //message wasn't sent
                }
            }
        }
    }
    else if ($_POST['submitted']) my_contact_form_generate_response("error", $missing_content);

    /* Get conact information and their pictures */
    $meta = get_post_meta($post->ID);

    $nb_image = isset($meta['nathalie_bergsaune_image']) ? esc_attr( $meta['nathalie_bergsaune_image'][0] ) : '';
    $nb_description = isset($meta['nathalie_bergsaune_description']) ? esc_attr( $meta['nathalie_bergsaune_description'][0] ) : '';
    $nb_name = isset($meta['nathalie_bergsaune_name']) ? esc_attr( $meta['nathalie_bergsaune_name'][0] ) : '';
    $nb_phonenumber = isset($meta['nathalie_bergsaune_phonenumber']) ? esc_attr( $meta['nathalie_bergsaune_phonenumber'][0] ) : '';
    $nb_email = isset($meta['nathalie_bergsaune_email']) ? esc_attr( $meta['nathalie_bergsaune_email'][0] ) : '';

  
    $hm_image = isset($meta['heidi_madelen_image']) ? esc_attr( $meta['heidi_madelen_image'][0] ) : '';
    $hm_description = isset($meta['heidi_madelen_description']) ? esc_attr( $meta['heidi_madelen_description'][0] ) : '';
    $hm_name = isset($meta['heidi_madelen_name']) ? esc_attr( $meta['heidi_madelen_name'][0] ) : '';
    $hm_phonenumber = isset($meta['heidi_madelen_phonenumber']) ? esc_attr( $meta['heidi_madelen_phonenumber'][0] ) : '';
    $hm_email = isset($meta['heidi_madelen_email']) ? esc_attr( $meta['heidi_madelen_email'][0] ) : '';

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
                <div class="col-sm-6 left-column">
                    <div class="left-image">
                        <img src="<?php echo $nb_image; ?>" alt="Bildet av Nathalie Bergsaune" class="img-responsive" />
                        <div>
                            <h4><?php echo $nb_name; ?></h4>
                            <p class="contact-us-persona">
                                <?php echo $nb_description; ?>
                            </p>
                            <p>
                                <?php echo $nb_phonenumber; ?>
                            </p>
                            <p>
                                <?php echo $nb_email; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 right-column">
                    <div class="right-image">
                       <img src="<?php echo $hm_image; ?>" alt="Bildet av Heidi Madelen" class="img-responsive" />
                        <div>
                            <h4><?php echo $hm_name; ?></h4>
                            <p class="contact-us-persona">
                                <?php echo $hm_description; ?>
                            </p>
                            <p>
                                <?php echo $hm_phonenumber; ?>
                            </p>
                            <p>
                                <?php echo $hm_email; ?>
                            </p>
                        </div>
                    </div>   
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <h4><?php _e('Send us an email', 'kasparabi'); ?></h4>

                    <style type="text/css">
                        .error{
                            padding: 5px 9px;
                            border: 1px solid red;
                            color: red;
                            border-radius: 3px;
                        }
                     
                        .success{
                            padding: 5px 9px;
                            border: 1px solid green;
                            color: green;
                            border-radius: 3px;
                        }

                        .human-verification {
                            display: inline-block;
                        }

                        form {
                            margin-bottom: 20px;
                        }
                     
                        form span{
                            color: red;
                        }
                    </style>
                     
                    <div id="respond" class="email-contact-form">
                        <?php echo $response; ?>
                        <form role="form" action="<?php the_permalink(); ?>" method="post">
                            <div class="form-group">
                                <label for="name"><?php echo _e('Name: *', 'kasparabi'); ?></label>
                                <input type="text" name="message_name" class="form-control" value="<?php echo esc_attr($_POST['message_name']); ?>" />
                            </div>
                            <div class="form-group">
                                <label for="message_email"><?php echo _e('Email: *', 'kasparabi'); ?></label>
                                <input type="text" name="message_email" class="form-control" value="<?php echo esc_attr($_POST['message_email']); ?>" />
                            </div>
                            <div class="form-group">
                                <label for="message_text"><?php echo _e('Message: *', 'kasparabi'); ?></label>
                                <textarea type="text" rows="4" class="form-control" name="message_text"><?php echo esc_textarea($_POST['message_text']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="message_human"><?php echo _e('Human Verification: *', 'kasparabi'); ?><br /><input type="text" style="width: 60px;" class="form-control human-verification" name="message_human"> + 3 = 5</label>
                            </div>

                            <input type="hidden" name="submitted" value="1" />
                            <button type="submit" class="btn btn-default"><?php echo _e('Send email', 'kasparabi'); ?></button>
                        </form>
                    </div>

                    <!--form role="form">
                        <div class="form-group">
                            <label for="email-subject">Emne</label>
                            <input type="email" class="form-control" id="email-subject" placeholder="Emne..." />
                        </div>
                        <div class="form-group">
                            <label for="email-content">Innhold</label>
                            <textarea class="form-control" id="email-content" placeholder="Innhold..." rows="4" ></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Send epost</button>
                    </form-->

                </div>
            </div>
        </div>
        <!-- END CONTACT US -->

<?php get_footer(); ?>