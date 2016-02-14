<?php
/*
    Template Name: Packages
*/
get_header();
the_post();
global $compare_slugs;

?>
<section>
    <div class="container">
        <div class="white-block">
            <div class="white-title clearfix">
                <div class="white-block-border clearfix">
                     <div class="pull-left">
                        <?php echo compare_get_white_title_icon(); ?>
                        <h3><?php the_title(); ?></h3>
                    </div>
                </div>
            </div>
            <?php
            $content = get_the_content();
            if( !empty( $content ) ):
            ?>
                <div class="white-block-content">
                    <div class="page-content clearfix">
                        <?php echo apply_filters( 'the_content', $content ); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div> 
        <div class="row">
        <?php
            $packages = trim( compare_get_option( 'packages' ) );
            $counter = 0;
            if( !empty( $packages ) ){
                $packages = explode( "\n", $packages );
                foreach( $packages as $package ){
                    $temp = explode( "|", $package );
                    $link = add_query_arg( array( 'package' => $temp[1].'-'.$temp[2] ), compare_get_permalink_by_tpl( 'page-tpl_register_store' ) );
                    if( $counter == 2 ){
                        echo '</div><div class="row">';
                        $counter = 0;
                    }
                    $counter++;
                    ?>
                    <div class="col-md-6">
                        <div class="white-block <?php echo !empty( $temp[3] ) == 'A' ? esc_attr( 'active' ) : '' ?>">
                            <div class="white-block-content">
                                <a href="<?php echo esc_url( $link ) ?>" class="package-container">
                                    <p class="package-title"><?php echo esc_html( $temp[0] ); ?></p>
                                    <p class="package-value">
                                        <?php 
                                        $price = compare_format_currency_number( $temp[1] );
                                        $price_temp = explode( '.', $price );
                                        echo  $price_temp[0].'.<span>'.$price_temp[1].__( ' & ', 'compare' ).'</span>'.$temp[2].'<span>'.__( ' Days', 'compare' ).'</span>'; ?>
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } 
        ?>
        </div>        
    </div>
</section>      
<?php get_footer(); ?>