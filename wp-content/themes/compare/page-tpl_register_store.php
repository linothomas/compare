<?php
/*
    Template Name: Register Store
*/
get_header();
the_post();
?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-<?php echo is_active_sidebar( 'sidebar-contanct' ) ? '9' : '12' ?>">
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

                        <?php $message = compare_payment_result(); ?>

                        <?php if( !empty( $message ) ): ?>
                            <?php echo  $message ?>
                        <?php elseif( !empty( $_GET['hash'] ) ): ?>
                            <?php
                            $hash = $_GET['hash'];
                            global $wpdb;
                            $store = $wpdb->get_results(
                                $wpdb->prepare(
                                    "SELECT * FROM {$wpdb->prefix}stores WHERE store_update = %s",
                                    $hash
                                )
                            );
                            $store = array_shift( $store );
                            if( !empty( $store ) ){
                                ?>
                                <form class="register-store">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <label for="store_package"><?php esc_attr_e( 'Chose your package', 'compare' ) ?> <span class="required">*</span>
                                                <?php
                                                $all_packages_link = compare_get_option( 'all_packages_link' );
                                                if( !empty( $all_packages_link ) ):
                                                ?>
                                                <a href="<?php echo esc_url( $all_packages_link ) ?>" class="pull-right"> <?php _e( 'Check list of available packages', 'compare' ) ?></a></label>
                                                <?php endif; ?>
                                                <select name="store_package" id="store_package" class="form-control">
                                                    <option value=""><?php _e( 'Select Package', 'compare' ) ?></option>
                                                    <?php echo compare_list_packages(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <a class="btn submit-form-store" href="javascript:;"><?php _e( 'REGISTER MY STORE', 'compare' ); ?></a>
                                            <p class="">
                                                <a href="#"><?php _e( 'Check here XML/CSV examples', 'compare' ) ?></a>
                                            </p>
                                        </div>

                                        <input type="hidden" name="action" value="update_store">
                                        <input type="hidden" name="store_id" value="<?php echo esc_attr( $store->store_id ); ?>">
                                    </div>
                                </form>
                                <div class="send_result"></div>
                                <div class="payments"></div>                                
                                <?php
                            }
                            else{
                               echo '<div class="alert alert-danger no-margin">'.__( 'Hash is not valid', 'compare' ).'</div>'; 
                            }
                            ?>
                        <?php else: ?>
                            <form class="register-store">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <label for="store_name"><?php esc_attr_e( 'Store Name', 'compare' ) ?> <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="store_name" id="store_name">
                                            <p class="field-description"><?php _e( 'Input name of your store', 'compare' ) ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <label for="store_url"><?php esc_attr_e( 'Store URL', 'compare' ) ?> <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="store_url" id="store_url">
                                            <p class="field-description"><?php _e( 'Input link to your store', 'compare' ) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <label for="store_contact_name"><?php esc_attr_e( 'Your Name', 'compare' ) ?> <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="store_contact_name" id="store_contact_name">
                                            <p class="field-description"><?php _e( 'Input your full name', 'compare' ) ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <label for="store_contact_phone"><?php esc_attr_e( 'Your Phone', 'compare' ) ?> <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="store_contact_phone" id="store_contact_phone">
                                            <p class="field-description"><?php _e( 'Input your phone with internation prefix', 'compare' ) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <label for="store_contact_email"><?php esc_attr_e( 'Your Email', 'compare' ) ?> <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="store_contact_email" id="store_contact_email">
                                            <p class="field-description"><?php _e( 'Input your mail for contact', 'compare' ) ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <label for="store_package"><?php esc_attr_e( 'Chose your package', 'compare' ) ?> <span class="required">*</span>
                                            <?php
                                            $all_packages_link = compare_get_permalink_by_tpl( 'page-tpl_packages' );
                                            if( $all_packages_link !== 'javascript:;' ):
                                            ?>
                                            <a href="<?php echo esc_url( $all_packages_link ) ?>" class="pull-right"> <?php _e( 'Check list of available packages', 'compare' ) ?></a></label>
                                            <?php endif; ?>
                                            <select name="store_package" id="store_package" class="form-control">
                                                <option value=""><?php _e( 'Select Package', 'compare' ) ?></option>
                                                <?php echo compare_list_packages(); ?>
                                            </select>
                                            <p class="field-description"><?php _e( 'Select package for your store', 'compare' ) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <label for="store_xml_feed"><?php esc_attr_e( 'Store Feed URL', 'compare' ) ?> <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="store_xml_feed" id="store_xml_feed">
                                            <p class="field-description"><?php _e( 'Input link to your XML / CSV products feed', 'compare' ) ?></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <label for="store_logo"><?php esc_attr_e( 'Store Logo URL', 'compare' ) ?> <span class="required">*</span></label>
                                            <input type="text" class="form-control" name="store_logo" id="store_logo">
                                            <p class="field-description"><?php _e( 'Input link to your store logo', 'compare' ) ?></p>
                                        </div>
                                    </div>
                                    <input type="hidden" name="action" value="register_store">
                                    <div class="col-md-12">
                                        <a class="btn submit-form-store" href="javascript:;"><?php _e( 'REGISTER MY STORE', 'compare' ); ?></a>
                                        <p class="">
                                            <a href="#" data-toggle="modal" data-target="#feed_modal"><?php _e( 'Check here XML/CSV examples', 'compare' ) ?></a>
                                        </p>
                                    </div>
                                </div>
                            </form>
                            <div class="send_result"></div>
                            <div class="payments"></div>
                        <?php endif; ?>

                        <div class="page-content clearfix">
                            <?php the_content(); ?>
                        </div>

                    </div>
                </div>
            </div>
            <?php get_sidebar( 'register' ); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>