jQuery(document).ready(function($) {
   //uploading files variable
   var custom_file_frame;

   $(document).on('click', '.media-upload-button', function(event) {
      var $this = $(this);
      var $upload_field = $this.siblings('.media-upload-url');
      var $this_frame = {
         title: ($this.data('upload-title')) ? $this.data('upload-title') : 'Upload Media',
         type: ($this.data('upload-type')) ? $this.data('upload-type') : 'image',
         button_text: ($this.data('upload-button-text')) ? $this.data('upload-button-text') : 'Insert',
         allow_multiple: ($this.data('upload-multiple')) ? true : false
      }

      //If the frame already exists, reopen it
      if (typeof(custom_file_frame)!=="undefined") {
         custom_file_frame.close();
      }
 
      //Create WP media frame.
      custom_file_frame = wp.media.frames.customHeader = wp.media({
         title: $this_frame.title,
         library: {
            type: $this_frame.type
         },
         button: {
            text: $this_frame.button_text
         },
         multiple: $this_frame.allow_multiple
      });
 
      //callback for selected image
      custom_file_frame.on('select', function() {
         var attachment = custom_file_frame.state().get('selection').first().toJSON();
                  
         $upload_field.val(attachment.url);
         $upload_field.siblings('.media-upload-preview').html('<img src="'+$upload_field.val()+'" />');
      });
 
      //Open modal
      custom_file_frame.open();

      event.preventDefault();
   });
});