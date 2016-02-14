<?php
/*
    Template Name: All Stores
*/
get_header();
the_post();

global $wpdb;
$stores = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}stores");

?>
<section class="contact-page">
    <div class="container">

        <?php 
        $content = get_the_content();
        if( !empty( $content ) ):
        ?>
            <div class="white-block">
                <div class="white-block-content">
                    <div class="page-content clearfix">
                        <?php echo apply_filters( 'the_content', $content ) ?>
                    </div>
                </div>
            </div>
        <?php
        endif;
        ?>

        <div class="row">

            <div class="col-md-12">

                <div class="row">
                    <?php
                    $brands = get_terms( 'product-brand', array(
                    	'hide-empty' => false
                    ) );
                    $counter = 0;
                    if( !empty( $stores ) ){
                        foreach( $stores as $store ){
                            if( $counter == 6 ){
                                $counter = 0;
                                echo '</div><div class="row">';
                            }
                            $counter++;
                            ?>
                            <div class="col-sm-2">
                                <div class="white-block">
                                    <div class="store-name">
                                        <a href="<?php echo esc_url( $store->store_url ) ?>">
                                            <?php echo esc_html( $store->store_name ); ?>
                                        </a>
                                    </div>                                
                                    <div class="embed-responsive embed-responsive-4by3">
                                        <div class="store-logo">

                                            <a href="<?php echo esc_url( $store->store_url ) ?>">
                                            	<?php echo wp_get_attachment_image( $store->store_logo, 'full', false, array( 'class' => 'img-responsive' ) ) ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
               </div>

            </div>

        </div>
    </div>
</section>
<?php get_footer(); ?>