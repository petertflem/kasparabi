/*
 * Attaches the image uploader to the input field
 */
/*jQuery(document).ready(function($){
 
    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;

    // Runs when the image button is clicked.
    $('#select-image').click(function(e){
 		
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
            //var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
            var selectedSizeUrl = meta_image_frame.sizes[$('select[name="large"]').val()].url;
          
            console.log(meta_image_frame);
            
            // Sends the attachment URL to our custom image input field.
            that.siblings('#text_link_image').val(media_attachment.url);
        });
 
        // Opens the media library frame.
        meta_image_frame.open();
    });
});
*/
/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function($){

  // Instantiates the variable that holds the media library frame.
  var meta_image_frame;

  // Runs when the image button is clicked.
  $('#select-image').click(function(e){

  var that = $(this);

  // Prevents the default action from occuring.
  e.preventDefault();

  // Sets up the media library frame
  file_frame  = wp.media({
    frame:   'select',
    state:   'mystate',
    library:   { type: 'image' },
    multiple:   false
  });

  file_frame.states.add([
    new wp.media.controller.Library({
      id: 'mystate',
      title: 'Velg bilde',
      priority: 20,
      toolbar: 'select',
      filterable: 'uploaded',
      library: wp.media.query( file_frame.options.library ),
      multiple: file_frame.options.multiple ? 'reset' : false,
      editable: true,
      displayUserSettings: false,
      displaySettings: true,
      allowLocalEdits: true
    })
  ]);

  // Runs when an image is selected.
  file_frame.on('select', function() {

    // Grabs the attachment selection and creates a JSON representation of the model.
    var media_attachment = file_frame.state().get('selection').first().toJSON();
    console.log(media_attachment);

    var selectedSizeUrl = media_attachment.sizes.large.url;
    
    // Sends the attachment URL to our custom image input field.
    that.siblings('#text_link_image').val(selectedSizeUrl);
  });

  file_frame.open();

  });
});