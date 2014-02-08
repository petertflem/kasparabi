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
    $headers = 'From: '. $email . "rn" .
        'Reply-To: ' . $email . "rn";

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
                     
                        form span{
                            color: red;
                        }
                    </style>
                     
                    <div id="respond">
                        <?php echo $response; ?>
                        <form role="form" action="<?php the_permalink(); ?>" method="post">
                            <div class="form-group">
                                <label for="name">Name: *</label>
                                <input type="text" name="message_name" class="form-control" value="<?php echo esc_attr($_POST['message_name']); ?>" />
                            </div>
                            <div class="form-group">
                                <label for="message_email">Email: *</label>
                                <input type="text" name="message_email" class="form-control" value="<?php echo esc_attr($_POST['message_email']); ?>" />
                            </div>
                            <div class="form-group">
                                <label for="message_text">Message: *</label>
                                <textarea type="text" rows="4" class="form-control" name="message_text"><?php echo esc_textarea($_POST['message_text']); ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="message_human">Human Verification: *<input type="text" style="width: 60px;" class="form-control" name="message_human"> + 3 = 5</label>
                            </div>

                            <input type="hidden" name="submitted" value="1" />
                            <button type="submit" class="btn btn-default">Send epost</button>
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