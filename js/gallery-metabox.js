jQuery(function(jQuery) {

  var file_frame;

  jQuery(document).on('click', '#mbgm a.gallery-add', function(e) {

    e.preventDefault();

    if (file_frame) file_frame.close();

    file_frame = wp.media.frames.file_frame = wp.media({
      title: jQuery(this).data('uploader-title'),
      button: {
        text: jQuery(this).data('uploader-button-text'),
      },
      multiple: true
    });

    file_frame.on('select', function() {
      var listIndex = jQuery('#gallery-metabox-list li').index(jQuery('#gallery-metabox-list li:last')),
          selection = file_frame.state().get('selection');

      selection.map(function(attachment, i) {
        attachment = attachment.toJSON(),
        index      = listIndex + (i + 1);

        jQuery('#gallery-metabox-list').append('<li><input type="hidden" name="mbgm_gallery_id[' + index + ']" value="' + attachment.id + '"><img class="image-preview" src="' + attachment.url + '"><a class="change-image button button-small" href="#" data-uploader-title="Change image" data-uploader-button-text="Change image">Change image</a><br><small><a class="remove-image" href="#">Remove image</a></small></li>');
      });
    });

    makeSortable();
    
    file_frame.open();

  });

  jQuery(document).on('click', '#mbgm a.change-image', function(e) {

    e.preventDefault();

    var that = jQuery(this);

    if (file_frame) file_frame.close();

    file_frame = wp.media.frames.file_frame = wp.media({
      title: jQuery(this).data('uploader-title'),
      button: {
        text: jQuery(this).data('uploader-button-text'),
      },
      multiple: false
    });

    file_frame.on( 'select', function() {
      attachment = file_frame.state().get('selection').first().toJSON();

      that.parent().find('input:hidden').attr('value', attachment.id);
      that.parent().find('img.image-preview').attr('src', attachment.url);
    });

    file_frame.open();

  });

  function resetIndex() {
    jQuery('#gallery-metabox-list li').each(function(i) {
      jQuery(this).find('input:hidden').attr('name', 'mbgm_gallery_id[' + i + ']');
    });
  }

  function makeSortable() {
    jQuery('#gallery-metabox-list').sortable({
      opacity: 0.6,
      stop: function() {
        resetIndex();
      }
    });
  }

  jQuery(document).on('click', '#mbgm a.remove-image', function(e) {
    e.preventDefault();

    jQuery(this).parents('li').animate({ opacity: 0 }, 200, function() {
      jQuery(this).remove();
      resetIndex();
    });
  });

  makeSortable();

});