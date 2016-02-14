<?php
/*==================
 SINGLE BLOG POST
==================*/

get_header();
the_post();

$post_pages = compare_link_pages();
?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-<?php echo is_active_sidebar( 'sidebar-blog' ) ? '9' : '12' ?>">
                <div class="white-block">
                    <?php
                    if( compare_has_media() ){
                        ?>
                        <div class="white-block-media">
                            <?php
                                $image_size = 'post-thumbnail';
                                $post_format = get_post_format();
                                include( get_template_directory() . '/media/media'.( !empty( $post_format ) ? '-'.$post_format : '' ).'.php' );
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="white-block-content blog-item-content">
                        <p class="blog-meta">
                            <?php the_time( 'm/d/Y' ); _e( ' by ', 'compare' ); the_author(); _e( ' with ', 'compare' ); comments_number( __( '0 comments', 'compare' ), __( '1 comment', 'compare' ), __( '% comments', 'compare' ) )  ?>
                        </p>

                        <h1 class="blog-title size-h2"><?php the_title(); ?></h1>

                        <hr />

                        <?php the_content(); ?>
                    </div>

                    <?php
                    if( !empty( $post_pages ) ){
                        ?>
                        <div class="white-block pagination blog-pagination">
                            <ul class="list-unstyled">
                                <?php echo  $post_pages; ?>
                            </ul>
                        </div>                        
                        <?php
                    }
                    ?>

                    <div class="post-tags-block">
                        <?php
                        $tags = compare_tags_list();
                        if( !empty( $tags ) ){
                            _e( 'TAGS: ', 'compare' ); 
                            echo  $tags; 
                        }
                        ?>
                    </div>

                </div>

                <?php comments_template( '', true ); ?>

            </div>

            <?php  get_sidebar(); ?>

        </div>
    </div>
</section>

<?php
get_footer();
?>