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
    $not_human       = __("Human verification incorrect.", "kasparabi");
    $missing_content = __("Please supply all information.", "kasparabi");
    $email_invalid   = __("Email Address Invalid.", "kasparabi");
    $message_unsent  = __("Message was not sent. Try Again.", "kasparabi");
    $message_sent    = __("Thanks! Your message has been sent.", "kasparabi");

    //user posted variables
    $name = $_POST['message_name'];
    $email = $_POST['message_email'];
    $message = $_POST['message_text'];
    $human = $_POST['message_human'];
    $newsletter = $_POST['newsletter'];

    //php mailer variables
    $to = get_option('admin_email');
    $subject = __("Someone sent a message from ", "kasparabi") . get_bloginfo('name');
    $headers = "Reply-To: <" . $email . ">" . "\r\n";

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
                    $message .= "\r\n\r\n" . __("Newsletter: ", "kasparabi") . ($newsletter ? __("Yes", "kasparabi") : __("No", "kasparabi")) . ".\r\n\r\nFra: " . $name;

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

    $nb_name = isset($meta['nathalie_bergsaune_name']) ? esc_attr( $meta['nathalie_bergsaune_name'][0] ) : '';
    $nb_phonenumber = isset($meta['nathalie_bergsaune_phonenumber']) ? esc_attr( $meta['nathalie_bergsaune_phonenumber'][0] ) : '';
    $nb_email = isset($meta['nathalie_bergsaune_email']) ? esc_attr( $meta['nathalie_bergsaune_email'][0] ) : '';

    $hm_name = isset($meta['heidi_madelen_name']) ? esc_attr( $meta['heidi_madelen_name'][0] ) : '';
    $hm_phonenumber = isset($meta['heidi_madelen_phonenumber']) ? esc_attr( $meta['heidi_madelen_phonenumber'][0] ) : '';
    $hm_email = isset($meta['heidi_madelen_email']) ? esc_attr( $meta['heidi_madelen_email'][0] ) : '';

    $street_name  = isset($meta['street_name']) ? esc_attr( $meta['street_name'][0] ) : '';
    $zip_code  = isset($meta['zip_code']) ? esc_attr( $meta['zip_code'][0] ) : '';
    $area  = isset($meta['area']) ? esc_attr( $meta['area'][0] ) : '';
    $kasparabi_email  = isset($meta['kasparabi_email']) ? esc_attr( $meta['kasparabi_email'][0] ) : '';

?>
<?php get_header(); ?>

        <!-- CONTANT US -->
        <div class="container contact-us">
            <div class="row">
                <div class="col-xs-12">
                    <h1><?php _e('Contact us', 'kasparabi'); ?></h1>
                </div>
            </div>

            <div class="row contact-us-row">
              <div class="col-sm-4">
                <?php echo $street_name; ?>
                <br />
                <?php echo $zip_code; ?> <?php echo $area; ?>
                <br />
                <?php echo $kasparabi_email; ?>
              </div>
              <div class="col-sm-4">
                <?php echo $nb_name ?>
                <br />
                <?php echo $nb_phonenumber ?>
                <br />
                <?php echo $nb_email ?>
              </div>
              <div class="col-sm-4">
                <?php echo $hm_name ?>
                <br />
                <?php echo $hm_phonenumber ?>
                <br />
                <?php echo $hm_email ?>
              </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <h4 class="email-title"><?php _e('Send us an email', 'kasparabi'); ?></h4>

                    <style type="text/css">
                        .error{
                            padding: 5px 9px;
                            border: 1px solid red;
                            color: red;
                            border-radius: 3px;
                            margin-bottom: 12px;
                            margin-top: 12px;
                        }

                        .success{
                            padding: 5px 9px;
                            border: 1px solid green;
                            color: green;
                            border-radius: 3px;
                            margin-bottom: 12px;
                            margin-top: 12px;
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
                                <label for="message_email"><?php echo _e('From email: *', 'kasparabi'); ?></label>
                                <input type="text" name="message_email" class="form-control" value="<?php echo esc_attr($_POST['message_email']); ?>" />
                            </div>
                            <div class="form-group">
                                <label for="message_text"><?php echo _e('Message: *', 'kasparabi'); ?></label>
                                <textarea type="text" rows="4" class="form-control" name="message_text"><?php echo esc_textarea($_POST['message_text']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="message_human"><?php echo _e('Human Verification: *', 'kasparabi'); ?><br /><input type="text" style="width: 60px;" class="form-control human-verification" name="message_human"> + 3 = 5</label>
                            </div>

                            <div class="form-group">
                                <label for="newsletter"><input style="margin-right: 5px; margin-top: 5px;" type="checkbox" name="newsletter" checked><?php _e("I wish to receive newsletters from Kaspara Bryllup & Interiør", "kasparabi"); ?></label>
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
