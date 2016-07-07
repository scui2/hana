jQuery(document).ready( function($) {
  	var image_uploader;
  	
	$('#widgets-right').ajaxComplete( function(event, XMLHttpRequest, ajaxOptions) {

		$( '#widgets-right .hana-sortable' ).sortable({
			connectWith: '.connected',
			update: function( event, ui ){ updateData(event, ui) }
		});
	
		$("#widgets-right .widget-checkbox").change(function(){
			if (this.checked) {
				$(this).parent().addClass('tab-selected');			
			}
			else {
				$(this).parent().removeClass('tab-selected');		
			}
		});

		$("#widgets-right .media-upload-btn").click(function(e){
			mediaUploader( e );
		});	
		$("#widgets-right .media-upload-del").click(function(e){
			mediaClear( e );
		});	
	
	});

	$( '#widgets-right .hana-sortable' ).sortable({
		connectWith: '.connected',
		update: function( event, ui ){ updateData(event, ui) }
	});
	
	function updateData(event, ui) {
		var $target = $(event.target);
		
		var $data = $target.sortable('serialize');
		
		if ( $target.is('#widget-nav-tabs') ) {
			$target.parent().children('.hanadata').val( $data );
		}
	}
	function mediaClear( e ) {
        e.preventDefault();
		image_url = $(e.target).siblings('.media-upload-id');
		image_url.val( '' );
		wpWidgets.save( image_url.closest('div.widget'), 0, 1, 0 );
	}

	function mediaUploader( e ) {
        e.preventDefault();
		image_id = $(e.target).siblings('.media-upload-id');
        if ( image_uploader ) {
            image_uploader.open();
            return;
        }

        image_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
        image_uploader.open();
         
        image_uploader.on('select', function() {
            attachment = image_uploader.state().get('selection').first().toJSON();
            image_id.val( attachment.id );
			wpWidgets.save( image_id.closest('div.widget'), 0, 1, 0 );
        });
	}
	
	$("#widgets-right .widget-checkbox").change(function(){
		if (this.checked) {
			$(this).parent().addClass('tab-selected');			
		}
		else {
			$(this).parent().removeClass('tab-selected');		
		}
	});

	$("#widgets-right .media-upload-btn").click(function(e){
		mediaUploader( e );
	});	
	$("#widgets-right .media-upload-del").click(function(e){
		mediaClear( e );
	});	
	
});

