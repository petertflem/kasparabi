/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function($){
 
    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;

    // Hide the empty thumbnail frames
    $('.inspiration-image-thumbnail').each(function (i, element) {
        var $element = $(element);

        $element.attr('src') ? $element.show() : $element.hide();
    });
 
    // Runs when the image button is clicked.
    $('.meta-image-button').click(function(e){
 		
 		var that = $(this);

        // Prevents the default action from occuring.
        e.preventDefault();
 
        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: meta_image.title,
            button: { text:  meta_image.button },
            library: { type: 'image' },
            frame: 'select'
        });

        // Runs when an image is selected.
        meta_image_frame.on('select', function() {

            // Grabs the attachment selection and creates a JSON representation of the model.
            var media_attachment = meta_image_frame.state().get('selection').first().toJSON();

            // Sends the attachment URL to our custom image input field.
            that.siblings('.meta-image').val(media_attachment.url);

            var thumbnail = that.siblings('.inspiration-image-thumbnail')
            thumbnail.attr('src', media_attachment.url);    // Update the thumbnail source
            thumbnail.is(':hidden') && thumbnail.show();    // Show the thumbnail if it is hidden
        });
 
        // Opens the media library frame.
        meta_image_frame.open();
    });
});