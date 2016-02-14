jQuery(document).ready(function($){	
	function handle_images( frameArgs, callback ){
		var SM_Frame = wp.media( frameArgs );

		SM_Frame.on( 'select', function() {

			callback( SM_Frame.state().get('selection') );
			SM_Frame.close();
		});

		SM_Frame.open();	
	}

	function imageExists(url, callback) {
		var img = new Image();
		img.onload = function() { callback(true); };
		img.onerror = function() { callback(false); };
		img.src = url;
	}	

	$(document).on( 'click', '.add_store_logo', function(e) {
		e.preventDefault();

		var frameArgs = {
			multiple: false,
			title: 'Select Logo'
		};

		handle_images( frameArgs, function( selection ){
			model = selection.first();
			$('input[name="store_logo"]').val( model.id );
			var img = model.attributes.url;
			var ext = img.substring(img.lastIndexOf('.'));
			img = img.replace( ext, '-150x150'+ext );
			imageExists( img, function(exists){
				if( exists ){
					$('.store_current_image').html( '<img src="'+img+'"><a href="javascript:;" class="remove_store_logo">X</a>' );	
				}
				else{
					$('.store_current_image').html( '<img src="'+model.attributes.url+'"><a href="javascript:;" class="remove_store_logo">X</a>' );
				}

			} );
		});
	});	

	$(document).on( 'click', '.remove_store_logo', function(){
		$('.store_current_image').html('');
		$('input[name="store_logo"]').val( '' );
	} );

	$(document).on( 'click', '.add_cat_image', function(e) {
		e.preventDefault();
		var $this=  $(this);

		var frameArgs = {
			multiple: false,
			title: 'Select Image'
		};

		handle_images( frameArgs, function( selection ){
			model = selection.first();
			$this.parent().find('input').val( model.id );
			var img = model.attributes.url;
			var ext = img.substring(img.lastIndexOf('.'));
			img = img.replace( ext, '-150x150'+ext );
			imageExists( img, function(exists){
				if( exists ){
					$('.image-holder').html( '<img src="'+img+'"><a href="javascript:;" class="remove_cat_image">X</a>' );
				}
				else{
					$('.image-holder').html( '<img src="'+model.attributes.url+'"><a href="javascript:;" class="remove_cat_image">X</a>' );
				}

			} );			
			
		});
	});	

	$(document).on( 'click', '.remove_cat_image', function(){
		$(this).parent().parent().find('input').val( '' );
		$('.image-holder').html('');
	} );


	/* MANAGING RETAILERS */
	function product_store_manupulation( data, callback ){
		$('.bt-table').css('pointer-events', 'none').css('opacity', '0.5');
		$.ajax({
			url: ajaxurl,
			data: data,
			method: "POST",
			success: function( response ){
				$('.bt-table').html( $('<div>'+response+'</div>').find('.bt-table').html() );
				if( callback ){
					callback( response );
				}				
			},
			complete: function(){
				$('.bt-table').css('pointer-events', 'auto').css('opacity', '1');
			}
		})
	}
	$(document).on( 'click', '.edit-feed', function(){
		var feed_id = $(this).attr('data-feed_id')
		var data = {
			action: 'update_product_store',
			feed_id: feed_id
		}

		product_store_manupulation( data, function(response){
			$('tr[data-id="'+feed_id+'"]').after( '<tr><td colspan="6"><div class="store-feed-form">'+$('<div>'+response+'</div>').find('.store-feed-form').html()+'</div></td></tr>' );
			$('tr[data-id="'+feed_id+'"] .store-feed-form').slideDown();
		});
	});

	$(document).on( 'click', '.delete-feed', function(){
		var data = {
			action: 'delete_product_store',
			feed_id: $(this).attr('data-feed_id'),
			post_id: $('#post_ID').val()
		}

		product_store_manupulation( data );
	});	

	$(document).on( 'click', '.save-feed', function(){
		var data = {
			action: 'add_product_store'
		};
		if( $(this).parents('tr').length > 0 ){
			$('.store-feed-form:first input').each(function(){
				data[$(this).attr('name')] = $(this).val();
			});
			$('.store-feed-form:first select').each(function(){
				data[$(this).attr('name')] = $(this).val();
			});
		}
		else{
			$('.store-feed-form:last input').each(function(){
				data[$(this).attr('name')] = $(this).val();
			});
			$('.store-feed-form:last select').each(function(){
				data[$(this).attr('name')] = $(this).val();
			});
		}
		product_store_manupulation( data );
	});	

	$('.add-feed').click(function(){
		$('.store-feed-form input[name="feed_id"]').remove();
		$('.store-feed-form').slideDown();
		$('.save-feed').text( $('.save-feed').attr('data-save') );
	});

	$(document).on( 'click', '.close-store-feed-form', function(){
		$('.store-feed-form').slideUp();
		$('.store-feed-form').parents('tr').slideUp(100, function(){ $('.store-feed-form').parents('tr').remove() });
	});

});