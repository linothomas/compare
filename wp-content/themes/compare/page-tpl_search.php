<?php
/*
	Template Name: Search Page
*/
get_header();
the_post();
global $compare_slugs;

$keyword = !empty( $_GET[$compare_slugs['keyword']] ) ? $_GET[$compare_slugs['keyword']] : '';
$product_cat = !empty( $_GET[$compare_slugs['product-cat']] ) && !empty( $_GET[$compare_slugs['product-cat']][0] ) ? $_GET[$compare_slugs['product-cat']] : '';
$product_tag = !empty( $_GET[$compare_slugs['product-tag']] ) ? $_GET[$compare_slugs['product-tag']] : '';
$product_brand = !empty( $_GET[$compare_slugs['product-brand']] ) && !empty( $_GET[$compare_slugs['product-brand']][0] ) ? $_GET[$compare_slugs['product-brand']] : '';
$product_ratings = !empty( $_GET['product-ratings'] ) ? $_GET['product-ratings'] : '';
$product_sort = !empty( $_GET['product-sort'] ) ? $_GET['product-sort'] : '';
$product_view = !empty( $_GET['product-view'] ) ? $_GET['product-view'] : '';
$product_price_range = !empty( $_GET['price'] ) ? $_GET['price'] : '';

$cur_page = 1;
if( get_query_var( 'paged' ) ){
    $cur_page = get_query_var( 'paged' );
}
else if( get_query_var( 'page' ) ){
    $cur_page = get_query_var( 'page' );
}

$args = array(
    'post_type' => 'product',
    'posts_per_page' => compare_get_option( 'products_per_page' ),
    'paged' => $cur_page,
    'post_status' => 'publish',
    'tax_query' => array()
);

$category_ancestors = array();
if( !empty( $product_cat ) ){
    $permalink = add_query_arg( array( $compare_slugs['product-cat'] => $product_cat ) );   
    $args['tax_query'][] = array(
        'taxonomy' => 'product-cat',
        'field'    => 'slug',
        'terms'    => $product_cat,
    );
    foreach( (array)$product_cat as $item ){
        $term = get_term_by( 'slug', $item, 'product-cat' );
        $category_ancestors[] = $term->term_id;
        while ( $term->parent != 0 ){
            $term  = get_term_by( 'id', $term->parent, 'product-cat' );
            $category_ancestors[] = $term->term_id;
        }
    }
}

if( !empty( $product_tag ) ){
    $permalink = add_query_arg( array( $compare_slugs['product-tag'] => $product_tag ) );   
    $args['tax_query'][] = array(
        'taxonomy' => 'product-tag',
        'field'    => 'slug',
        'terms'    => $product_tag,
    );
}

if( !empty( $keyword ) ){
    $args['s'] = $keyword;
}


if( !empty( $product_brand ) ){
    $args['tax_query'][] = array(
        'taxonomy' => 'product-brand',
        'field'    => 'slug',
        'terms'    => $product_brand,
    );
}

if( !empty( $product_ratings ) ){
    if( sizeof( $product_ratings ) > 1 ){
        $args['meta_query']['relation'] = 'OR';
    }
    foreach( $product_ratings as $product_rating ){
        switch( $product_rating ){
            case '1' : $between = array( 0, 1.49 ); break;
            case '2' : $between = array( 1.5, 2.49 ); break;
            case '3' : $between = array( 2.5, 3.49 ); break;
            case '4' : $between = array( 3.5, 4.49 ); break;
            case '5' : $between = array( 4.5, 5 ); break;
        }

        $args['meta_query'][] = array(
            'key' => 'average_review',
            'value' => $between,
            'compare' => 'BETWEEN'
        );

        if( $product_rating == '1' ){
            $args['meta_query']['relation'] = 'OR';
            $args['meta_query'][] = array(
                'key' => 'average_review',
                'value' => '-1',
                'compare' => 'NOT EXISTS'
            );
        }
    }
}

if( !empty( $product_price_range ) ){
    add_filter('posts_join', 'compare_join_price_range');
    add_filter( 'posts_groupby', 'compare_groupby_price_range', 10, 2 );
}

if( !empty( $product_sort ) ){
    $temp = explode( '-', $product_sort );
    $args['order'] = $temp[1];
    if( !$temp[0] == 'date' ){
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = $temp[0];
    }

    if( stristr( $product_sort,'price' ) ){
        if( empty( $product_price_range ) ){
            add_filter('posts_join', 'compare_join_price_range');
            add_filter( 'posts_groupby', 'compare_groupby_price_range', 10, 2 );
        }
        add_filter( 'posts_fields', 'compare_filter_posts_fields', 10, 1 );
        add_filter('posts_orderby', 'compare_orderby_price');
    }
}


$products = new WP_Query( $args );
$product_ids = wp_list_pluck( $products->posts, 'ID' );
$product_metas = compare_product_item_meta( $product_ids );

$page_links_total =  $products->max_num_pages;
$pagination_args = array(
    'prev_next' => true,
    'end_size' => 2,
    'mid_size' => 2,
    'total' => $page_links_total,
    'current' => $cur_page, 
    'prev_next' => true,
    'prev_text' => __( 'Prev', 'compare' ),
    'next_text' => __( 'Next', 'compare' ),    
    'type' => 'array'
);

$page_links = paginate_links( $pagination_args );
$pagination = compare_format_pagination( $page_links );  

$counter = 0;

?>
<form action="<?php echo esc_url( compare_get_permalink_by_tpl( 'page-tpl_search' ) ); ?>" class="search-filter">
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="search-overlay sidebar">  
                    <i class="fa fa-spin fa-spinner"></i>
                    <p><?php _e( 'Loading results...', 'compare' ) ?></p>
                </div>            
                <div class="white-block">
                    <div class="white-title clearfix clearfix">
						<div class="white-block-border clearfix">
							 <div class="pull-left">
								<?php echo compare_get_white_title_icon(); ?>
								<h3><?php _e( 'Search Filter', 'compare' ); ?></h3>
							</div>
                            <div class="pull-right">
                                <a href="javascript:;" class="list-left filter-collapse">
                                    <i class="fa fa-angle-up"></i>
                                </a>
                            </div>
						</div>
                    </div>
                    <div class="filter-wrap">
                        <div class="white-block-content">
                            <h3><?php _e( 'Term', 'compare' ); ?></h3>
                            <div class="search-input">
                                <input type="text" class="form-control" name="<?php echo esc_attr( $compare_slugs['keyword'] )  ?>" value="<?php echo esc_attr( $keyword ) ?>" placeholder="<?php esc_attr_e( 'Type term...', 'compare' ) ?>">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>

                        <div class="white-block-content">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h3><?php _e( 'Categories', 'compare' ); ?></h3>
                                </div>
                                <div class="pull-right">
                                    <a href="javascript:;" class="view-more closed hidden" data-target=".category-filter" data-visible="<?php echo esc_attr( compare_get_option( 'search_categories_visible' ) ); ?>" data-less="<?php esc_attr_e( 'VIEW LESS', 'compare' ) ?>"><?php _e( 'VIEW MORE', 'compare' ) ?><i class="fa fa-angle-down"></i></a>
                                </div>
                            </div>
                            <ul class="list-unstyled category-filter">
                                <?php compare_list_filter_categories( $category_ancestors ); ?>
                            </ul>                        
                        </div>

                        <div class="white-block-content">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h3><?php _e( 'Brands', 'compare' ); ?></h3>
                                </div>
                                <div class="pull-right">
                                    <a href="javascript:;" class="view-more closed hidden" data-target=".brand-filter" data-visible="<?php echo esc_attr( compare_get_option( 'search-brands_visible' ) ); ?>" data-less="<?php esc_attr_e( 'VIEW LESS', 'compare' ) ?>"><?php _e( 'VIEW MORE', 'compare' ) ?><i class="fa fa-angle-down"></i></a>
                                </div>
                            </div>
                            <ul class="list-unstyled brand-filter">
                                <?php compare_list_filter_brands() ?>
                            </ul>                        
                        </div>

                        <div class="white-block-content filter-ratings">
                            <h3><?php _e( 'Ratings', 'compare' ); ?></h3>
                            <?php
                            for( $i=5; $i>=1; $i-- ){
                                ?>
                                <div class="checkbox checkbox-inline">
                                    <input type="checkbox" id="product-ratings-<?php echo esc_attr( $i ) ?>" name="product-ratings[]" value="<?php echo esc_attr( $i ) ?>">
                                    <label for="product-ratings-<?php echo esc_attr( $i ) ?>">
                                        <?php echo str_repeat('<i class="fa fa-star"></i>', $i); ?>
                                    </label>
                                </div>                                
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                        $price_ranges = compare_get_option( 'price_ranges' );
                        if( !empty( $price_ranges ) ){
                            $price_ranges = explode( "\n", $price_ranges );
                            ?>
                            <div class="white-block-content">
                                <h3><?php _e( 'Price Range', 'compare' ); ?></h3>
                                <?php
                                for( $i=0; $i<sizeof( $price_ranges ); $i++ ){
                                    ?>
                                    <div class="checkbox checkbox-inline">
                                        <input type="checkbox" id="price-<?php echo esc_attr( $i ) ?>" name="price[]" value="<?php echo esc_attr( trim( $price_ranges[$i] ) ) ?>">
                                        <label for="price-<?php echo esc_attr( $i ) ?>">
                                            <?php echo compare_format_price_range( $price_ranges[$i] ); ?>
                                        </label>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>                        
                            <?php
                        }
                        ?>

                        <a href="javascript:;" class="reset_filter"><?php _e( 'Clear Filters', 'compare' ) ?></a>
                    </div>
                </div>
                <?php get_sidebar( 'search' ); ?>
            </div>
            <div class="col-md-9 ajax-container">
                <?php
                $slider = '';
                if( isset( $_GET[$compare_slugs['product-cat']] ) && sizeof( (array)$_GET[$compare_slugs['product-cat']] ) == 1 ){
                    $slider_cat = (array)$_GET[$compare_slugs['product-cat']];
                    $slider = get_posts(array(
                        'post_type' => 'slider',
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'meta_query' => array(
                            array(
                                'key' => 'slider_cat',
                                'value' => $slider_cat[0],
                                'compare' => '='
                            )
                        )
                    ));
                    wp_reset_postdata();
                }
                else if( !isset( $_GET[$compare_slugs['product-cat']] ) ){
                    $slider = get_posts(array(
                        'post_type' => 'slider',
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'meta_query' => array(
                            array(
                                'key' => 'slider_cat_all',
                                'value' => 'yes',
                                'compare' => '='
                            )
                        )
                    ));
                    wp_reset_postdata();
                }
                if( !empty( $slider ) ){
                    $slider = array_shift( $slider );
                    echo do_shortcode( '[slider slider_id="'.$slider->ID.'"][/slider]' );
                }                
                ?>
                <div class="white-block filter-bar">
                    <?php
                    $item_list = '';
                    $has_title = false;
                    if( isset( $_GET[$compare_slugs['product-cat']] ) ){
                        $item_list = array();
                        foreach( (array)$_GET[$compare_slugs['product-cat']] as $item ){
                            $term = get_term_by( 'slug', $item, 'product-cat' );
                            if( !empty( $term ) && !is_wp_error( $term ) ){
                                $item_list[] = $term->name;
                            }
                        }
                        $item_list =  join( ', ', $item_list );
                        if( !empty( $item_list ) ){
                            $has_title = true;
                        }
                    }
                    ?>           
                    <div class="white-block-content <?php echo !$has_title ? esc_attr( 'hidden' ) : '' ?>">
                        <h1>
                        <?php echo  $item_list; ?>
                        </h1>
                    </div>
                    <div class="white-block-content">
                        <ul class="list-unstyled list-inline">
                            <li><?php _e( 'Pick view', 'compare' ) ?></li>
                            <li>
                                <a href="javascript:;" data-value="list" class="<?php echo !empty( $product_view ) && $product_view == 'list' ? esc_attr( 'active' ) : ''; ?> view"><i class="fa fa-list-ul"></i></a>
                            </li>
                            <li>
                                <a href="javascript:;" data-value="grid" class="<?php echo empty( $product_view ) || $product_view == 'grid' ? esc_attr( 'active' ) : ''; ?> view"><i class="fa fa-th"></i></a>
                                <input type="hidden" value="<?php echo esc_attr( $product_view ) ?>" name="product-view" id="product-view">
                            </li>
                            <li><?php _e( 'Sort by', 'compare' ) ?></li>
                            <li>
                                <select name="product-sort">
                                    <option value="date-asc" <?php echo empty( $product_sort ) || $product_sort == 'date-asc' ? 'selected="selected"' : '' ?>><?php _e( 'Date Ascending', 'compare' ) ?></option>
                                    <option value="date-desc" <?php echo $product_sort == 'date-desc' ? esc_attr( 'selected="selected"' ) : '' ?>><?php _e( 'Date Descending', 'compare' ) ?></option>
                                    <option value="price-asc" <?php echo $product_sort == 'price-asc' ? esc_attr( 'selected="selected"' ) : '' ?>><?php _e( 'Price Ascending', 'compare' ) ?></option>
                                    <option value="price-desc" <?php echo $product_sort == 'price-desc' ? esc_attr( 'selected="selected"' ) : '' ?>><?php _e( 'Price Descending', 'compare' ) ?></option>
                                </select>
                            </li>
                            <li>
                                <?php echo '<span>'.$products->found_posts.'</span>'; $products->found_posts == 1 ? _e( ' match', 'compare' ) : _e( ' matches', 'compare' ); ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="products-box">
                    <div class="search-overlay row">  
                        <i class="fa fa-spin fa-spinner"></i>
                        <p><?php _e( 'Loading results...', 'compare' ) ?></p>
                    </div>
                    <div class="row">                
                    <?php
                    $product_box_style = compare_get_option( 'product_box_style' );
                    if( !empty( $product_view ) ){
                        $product_box_style = $product_view;
                    }
                    if( $products->have_posts() ){
                        while( $products->have_posts() ){
                            $products->the_post();
                            if( $counter == 3 ){
                                echo '</div><div class="row">';
                                $counter = 0;
                            }
                            $counter ++;
                            echo '<div class="col-sm-'.( $product_box_style == 'grid' ? esc_attr( '4' ) : esc_attr( '12' ) ).'">';
                                if( $product_box_style == 'grid' ){
                                    include( get_template_directory() . '/includes/product-box.php' );
                                }
                                else{
                                    include( get_template_directory() . '/includes/product-box-alt.php' );   
                                }
                            echo '</div>';
                        }
                    }
                    else{
                        ?>
                        <div class="col-md-12">
                            <div class="white-block no-results">
                                <div class="white-block-content">
                                    <?php _e( 'No results found to match your criteria', 'compare' ) ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    </div>
                </div>

                <?php
                if( !empty( $pagination ) ) {
                    ?>
                    <div class="white-block pagination">
                        <ul class="list-unstyled">
                            <?php echo  $pagination; ?>
                        </ul>
                    </div>
                    <?php
                }
                ?> 
                
                <?php 
                wp_reset_postdata();
                the_content(); 
                ?>
            </div>
        </div>
    </div>
</section>
</form>
<?php
get_footer();
?>