<?php
/*
	DEFAULT BLOG LSITING WITH THE MASONRY
*/	
get_header();
global $wp_query;
$cur_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; //get curent page

$page_links_total =  $wp_query->max_num_pages;
$page_links = paginate_links( 
	array(
		'prev_next' => true,
		'end_size' => 2,
		'mid_size' => 2,
		'total' => $page_links_total,
		'current' => $cur_page,	
		'prev_next' => true,
		'prev_text' => __( 'Prev', 'compare' ),
		'next_text' => __( 'Next', 'compare' ),
		'type' => 'array'
	)
);

$pagination = compare_format_pagination( $page_links );
$counter = 0;
?>
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-<?php echo is_active_sidebar( 'sidebar-blog' ) ? '9' : '12' ?>">
				<div class="row">
					<?php
					if( have_posts() ){
						while( have_posts() ){
							the_post();
							$has_media = compare_has_media();
							if( $counter == 2 ){
								echo '</div><div class="row">';
								$counter = 0;
							}
							$counter++;
							echo '<div class="col-md-6">';
								include( get_template_directory() . '/includes/blog-box.php' );
							echo '</div>';
						}
					}
					else{
						?>
						<div class="white-block">
							<div class="white-block-content">
								<?php _e( 'No results found', 'compare' ) ?>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<?php
				if( !empty( $pagination ) )	{
					?>
					<div class="white-block pagination">
						<ul class="list-unstyled">
							<?php echo  $pagination; ?>
						</ul>
					</div>
					<?php
				}
				?>
			</div>

			<?php get_sidebar(); ?>

		</div>
	</div>
</section>

<?php get_footer(); ?>