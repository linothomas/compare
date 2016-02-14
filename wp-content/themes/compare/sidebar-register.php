<?php 
	if ( is_active_sidebar( 'sidebar-register' ) ){
		?>
		<div class="col-md-3">
			<?php dynamic_sidebar( 'sidebar-register' ); ?>
		</div>
		<?php
	}
?>