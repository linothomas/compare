<?php 
	if ( is_active_sidebar( 'sidebar-contact' ) ){
		?>
		<div class="col-md-3">
			<?php dynamic_sidebar( 'sidebar-contact' ); ?>
		</div>
		<?php
	}
?>