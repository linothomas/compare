<?php
/*
	Template Name: Contact Page
*/
get_header();
the_post();
?>
<section>
    <div class="container">
        <div class="white-block map-container">
            <div class="contact_map">
                <?php
                $contact_map = compare_get_option( 'contact_map' );
                if( !empty( $contact_map[0] ) ){
                    foreach( $contact_map as $long_lat ){
                        echo '<input type="hidden" value="'.esc_attr( $long_lat ).'" class="contact_map_marker">';
                    }
                    $contact_map_scroll_zoom = compare_get_option( 'contact_map_scroll_zoom' );
                    if( $contact_map_scroll_zoom == 'yes' ){
                        echo '<input type="hidden" value="1" class="contact_map_scroll_zoom">';
                    }
                    ?>
                    <div id="map" class="embed-responsive-item"></div>
                    <?php
                }
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-<?php echo is_active_sidebar( 'sidebar-contact' ) ? '9' : '12' ?>">
                <div class="white-block">
                    <div class="white-title clearfix">
						<div class="white-block-border clearfix">
							 <div class="pull-left">
								<?php echo compare_get_white_title_icon(); ?>
								<h3><?php the_title(); ?></h3>
							</div>
						</div>
                    </div>                
                    <div class="white-block-content">
                        <form class="contact-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <label for="email"><?php esc_attr_e( 'Your Name', 'compare' ) ?> <span class="required">*</span></label>
                                        <input type="text" name="name" class="form-control" id="name"><span class="required"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <label for="email"><?php esc_attr_e( 'Your Email', 'compare' ) ?> <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="email" id="email">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group">
                                    <label for="message"><?php esc_attr_e( 'Your Message', 'compare' ) ?> <span class="required">*</span></label>
                                        <textarea class="form-control" name="message" id="message"></textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="action" value="contact">
                                <div class="col-md-12">
                                    <a class="btn submit-form-contact" href="javascript:;"><?php _e( 'SUBMIT MESSAGE', 'compare' ); ?></a>
                                </div>
                            </div>
                        </form>
                        
                        <div class="send_result"></div>

                        <div class="page-content clearfix">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php get_sidebar( 'contact' ); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>