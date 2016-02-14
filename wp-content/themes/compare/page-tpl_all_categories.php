<?php
/*
    Template Name: All Categories
*/
get_header();
the_post();

$product_cats = compare_get_organized( 'product-cat' );
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
            <div class="col-md-4">
                <?php
                $counter = 0;
                $max = round( count( $product_cats ) / 3, 0 );
                $max = max( 1, $max );                
                if( !empty( $product_cats ) ){
                    foreach( $product_cats as $key => $cat){
                        if( $counter == $max ){
                            echo '</div><div class="col-md-4">';
                            $counter = 0;
                        }
                        $counter++;
                        ?>
                        <div class="panel-group" id="accordion_<?php echo esc_attr( $cat->slug ); ?>" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="acc_<?php echo esc_attr( $cat->slug ); ?>">
                                    <h4 class="panel-title">
                                        <a href="<?php echo esc_url( add_query_arg( array( $compare_slugs['product-cat'] => $cat->slug ), $COMPARE_SEARCH_URL) ); ?>">
                                            <?php echo esc_html( $cat->name ); ?>
                                        </a>
                                        <span class="count"><?php echo esc_html( $cat->count ); ?></span>
                                        <?php if( !empty( $cat->children ) ): ?>
                                            <a data-toggle="collapse" data-parent="#accordion_<?php echo esc_attr( $cat->slug ); ?>" href="#collapse_<?php echo esc_attr( $cat->slug ); ?>" aria-expanded="true" aria-controls="collapse_<?php echo esc_attr( $cat->slug ); ?>">
                                               <span class="toggle"><i class="fa fa-angle-down"></i></span>
                                            </a>
                                        <?php endif; ?>
                                        
                                    </h4>
                                </div>
                                <div id="collapse_<?php echo esc_attr( $cat->slug ); ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="acc_<?php echo esc_attr( $cat->slug ); ?>">
                                    <div class="panel-body">
                                        <?php if( !empty( $cat->children ) ){
                                            compare_display_tree( $cat, 'product-cat' );
                                        }
                                        ?>
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
</section>
<?php get_footer(); ?>