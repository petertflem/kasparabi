/*
 * Attaches the image uploader to the input field
 */
jQuery(document).ready(function($){
  // Instantiates the variable that holds the media library frame.
  var meta_image_frame;

  // Runs when the image button is clicked.
  $('.select-image').click(function(e){

    var that = $(this);

    // Prevents the default action from occuring.
    e.preventDefault();

    // Sets up the media library frame
    var file_frame  = wp.media({
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
      var selectedSizeUrl = selectImageSize(media_attachment.sizes).url;

      // Sends the attachment URL to our custom image input field.
      that.siblings('#text_link_image').val(selectedSizeUrl);
    });

    file_frame.open();

  });
  
  function selectImageSize(sizes) {
    return sizes['large'] || sizes['medium'] || sizes['full'] || sizes['thumbnail'];
  }
});