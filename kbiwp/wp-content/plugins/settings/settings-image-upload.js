/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function($){
 
    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;

    // Hide the empty logo frame
    var logo = $('#logo-thumbnail');
    logo.attr('src') ? logo.show() : logo.hide();
    
    // Runs when the image button is clicked.
    $('#logo-upload-button').click(function(e){
 		
 		var that = $(this);

        if(meta_image_frame) {
            meta_image_frame.open();
            return;
        }

        // Prevents the default action from occuring.
        e.preventDefault();
 
        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: settings_image.title,
            button: { text:  settings_image.button },
            library: { type: 'image' },
            frame: 'select'
        });

        // Runs when an image is selected.
        meta_image_frame.on('select', function() {

            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();

            // Sends the attachment URL to our custom image input field.
            that.siblings('#logo_url').val(media_attachment.url);

            logo.attr('src', media_attachment.url);    // Update the thumbnail source
            logo.is(':hidden') && logo.show();    // Show the thumbnail if it is hidden
        });
 
        // Opens the media library frame.
        meta_image_frame.open();
    });
});