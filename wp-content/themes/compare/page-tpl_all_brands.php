<?php
/*
    Template Name: All Brands
*/
get_header();
the_post();
global $COMPARE_SEARCH_URL;
global $compare_slugs;
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
                    $brands = compare_get_organized( 'product-brand' );
                    $counter = 0;
                    if( !empty( $brands ) ){
                        foreach( $brands as $brand ){
                            if( $counter == 6 ){
                                $counter = 0;
                                echo '</div><div class="row">';
                            }
                            $counter++;
                            ?>
                            <div class="col-sm-2">
                                <div class="white-block">
                                    <div class="store-name">
                                        <a href="<?php echo esc_url( add_query_arg( array( $compare_slugs['product-brand'] => $brand->slug ), $COMPARE_SEARCH_URL ) ); ?>">
                                            <?php echo esc_html( $brand->name ); ?>
                                        </a>
                                    </div>                                
                                    <div class="embed-responsive embed-responsive-4by3">
                                        <div class="store-logo">

                                            <a href="<?php echo esc_url( add_query_arg( array( $compare_slugs['product-brand'] => $brand->slug ), $COMPARE_SEARCH_URL ) ); ?>">
                                                <?php
                                                $term_meta = get_option( "taxonomy_$brand->term_id" );
                                                $brand_image = !empty( $term_meta['brand_image'] ) ? $term_meta['brand_image'] : '';
                                                if( !empty( $brand_image ) ){
                                                	echo wp_get_attachment_image( $brand_image, 'full', 'false', array( 'class' => 'img-responsive' ) );
                                                }
                                                ?>
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