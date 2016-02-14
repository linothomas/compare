<?php
/******************************************************** 
Compare Brands
********************************************************/
class Compare_Brands extends WP_Widget {	
	public function __construct() {
		parent::__construct('compare_brands', __('Compare Brands','compare'), array('description' =>__("Compare Brands Widget","compare") ));
	}
	public function widget( $args, $instance ) {
		extract($args);
		global $COMPARE_SEARCH_URL;
		global $compare_slugs;
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __('Top Brands','compare') : $instance['title'], $instance, $this->id_base);
		$brands = $instance['brands'];
		$items = esc_attr( $instance['items'] );
		$columns = !empty( $instance['columns'] ) ? esc_attr( $instance['columns'] ) : 2;
		$rows = !empty( $instance['rows'] ) ? esc_attr( $instance['rows'] ) : 3;
		
		echo  $before_widget.
				$before_title.$title.$after_title.'
				<div class="widget-slider" data-visible-items="'.esc_attr( $columns ).'">';
				if( !empty( $items ) ){
					$brands = get_terms( 'product-brand', array(
						'orderby' => 'count',
						'order' => 'DESC',
						'number' => $items,
						'hide_empty' => false
					) );
				}
				if( !empty( $brands ) ){
					echo '<div>';
					$counter = 0;
					foreach( $brands as $term ){
						if( !is_object( $term ) ){
							$term = get_term_by( 'slug', $brand, 'product-brand' );
						}
						if( $counter == $rows ){
							echo '</div><div>';
							$counter = 0;
						}
						$counter++;
						$term_meta = get_option( "taxonomy_".$term->term_id );
						$brand_image = !empty( $term_meta['brand_image'] ) ? $term_meta['brand_image'] : '';
						echo '<a href="'.esc_url( add_query_arg( array( $compare_slugs['product-brand'] => $term->slug ), $COMPARE_SEARCH_URL ) ).'">'.wp_get_attachment_image( $brand_image, 'full' ).'</a>';
					}
					echo '</div>';
				}
		echo	'</div>'.$after_widget;
	}
 	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'brands' => array(), 'items' => '', 'columns' => '', 'rows' => '') );
		
		$title = esc_attr( $instance['title'] );
		$brands = $instance['brands'];
		$items = esc_attr( $instance['items'] );
		$columns = esc_attr( $instance['columns'] );
		$rows = esc_attr( $instance['rows'] );
		
		echo '<p><label for="'.esc_attr($this->get_field_id('title')).'">'.__('Title:','compare').'</label>';
		echo '<input class="widefat" id="'.esc_attr($this->get_field_id('title')).'"  name="'.esc_attr($this->get_field_name('title')).'" type="text" value="'.esc_attr( $title ).'" /></p>';	

		echo '<p><label for="'.esc_attr($this->get_field_id('brands')).'">'.__('Brands:','compare').'</label>';
		echo '<select class="widefat" id="'.esc_attr($this->get_field_id('brands')).'"  name="'.esc_attr($this->get_field_name('brands')).'[]" multiple>';
		$brands_list = get_terms( 'product-brand', array(
			'hide_empty' => false
		) );

		if( !empty( $brands_list ) ){
			foreach( $brands_list as $brand ){
				echo '<option value="'.esc_attr( $brand->slug ).'" '.( in_array( $brand->slug, $brands ) ? 'selected="selected"' : '' ).'>'.$brand->name.'</option>';
			}
		}
		echo '</select></p>';	

		echo '<p><label for="'.esc_attr($this->get_field_id('items')).'">'.__('Items:','compare').'</label>';
		echo '<input class="widefat" id="'.esc_attr($this->get_field_id('items')).'"  name="'.esc_attr($this->get_field_name('items')).'" type="text" value="'.esc_attr( $items ).'" /></p>';	

		echo '<p><label for="'.esc_attr($this->get_field_id('columns')).'">'.__('Columns:','compare').'</label>';
		echo '<input class="widefat" id="'.esc_attr($this->get_field_id('columns')).'"  name="'.esc_attr($this->get_field_name('columns')).'" type="text" value="'.esc_attr( $columns ).'" /></p>';	

		echo '<p><label for="'.esc_attr($this->get_field_id('rows')).'">'.__('Rows:','compare').'</label>';
		echo '<input class="widefat" id="'.esc_attr($this->get_field_id('rows')).'"  name="'.esc_attr($this->get_field_name('rows')).'" type="text" value="'.esc_attr( $rows ).'" /></p>';	
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['brands'] = $new_instance['brands'];
		$instance['items'] = strip_tags($new_instance['items']);
		$instance['columns'] = strip_tags($new_instance['columns']);
		$instance['rows'] = strip_tags($new_instance['rows']);
		return $instance;	
	}	
}

/******************************************************** 
Compare Brands
********************************************************/
class Compare_Stores extends WP_Widget {	
	public function __construct() {
		parent::__construct('compare_stores', __('Compare Stores','compare'), array('description' =>__("Compare Stores Widget","compare") ));
	}
	public function widget( $args, $instance ) {
		extract($args);
		global $wpdb;
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __('Top Stores','compare') : $instance['title'], $instance, $this->id_base);
		$stores = esc_attr( $instance['stores'] );
		$items = esc_attr( $instance['items'] );
		$columns = !empty( $instance['columns'] ) ? esc_attr( $instance['columns'] ) : 2;
		$rows = !empty( $instance['rows'] ) ? esc_attr( $instance['rows'] ) : 3;
		
		echo  $before_widget.
				$before_title.$title.$after_title.'
				<div class="widget-slider" data-visible-items="'.esc_attr( $columns ).'">';
				if( !empty( $items ) ){
					$stores = $wpdb->get_results(
						$wpdb->prepare(
							"SELECT * FROM {$wpdb->prefix}stores ORDER BY store_clicks LIMIT %d",
							$items
						)
					);
				}
				if( !empty( $stores ) ){
					echo '<div>';
					$counter = 0;
					foreach( $stores as $store_slug ){
						if( !empty( $store_slug->store_slug ) ){
							$store = $store_slug;
						}
						else{
							$store = $wpdb->get_results(
								$wpdb->prepare(
									"SELECT * FROM {$wpdb->prefix}stores WHERE 	store_slug = %s",
									$store_slug
								)
							);
						}
						if( $counter == $rows ){
							echo '</div><div>';
							$counter = 0;
						}
						$counter++;
						if( !empty( $store ) ){
							echo '<a href="'.esc_url( $store->store_url ).'" target="_blank">'.wp_get_attachment_image( $store->store_logo, 'full' ).'</a>';
						}
					}
					echo '</div>';
				}
		echo	'</div>'.$after_widget;
	}
 	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'stores' => array(), 'items' => '', 'columns' => '', 'rows' => '') );
		
		$title = esc_attr( $instance['title'] );
		$stores = $instance['stores'];
		$items = esc_attr( $instance['items'] );
		$columns = esc_attr( $instance['columns'] );
		$rows = esc_attr( $instance['rows'] );
		
		echo '<p><label for="'.esc_attr($this->get_field_id('title')).'">'.__('Title:','compare').'</label>';
		echo '<input class="widefat" id="'.esc_attr($this->get_field_id('title')).'"  name="'.esc_attr($this->get_field_name('title')).'" type="text" value="'.esc_attr( $title ).'" /></p>';	

		echo '<p><label for="'.esc_attr($this->get_field_id('stores')).'">'.__('Stores:','compare').'</label>';
		echo '<select class="widefat" id="'.esc_attr($this->get_field_id('stores')).'"  name="'.esc_attr($this->get_field_name('stores')).'[]" multiple>';
		
		global $wpdb;
		$stores_list = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}stores" );

		if( !empty( $stores_list ) ){
			foreach( $stores_list as $store ){
				echo '<option value="'.esc_attr( $store->store_slug ).'" '.( in_array( $store->store_slug, $stores ) ? 'selected="selected"' : '' ).'>'.$store->store_name.'</option>';
			}
		}
		echo '</select></p>';	

		echo '<p><label for="'.esc_attr($this->get_field_id('items')).'">'.__('Items:','compare').'</label>';
		echo '<input class="widefat" id="'.esc_attr($this->get_field_id('items')).'"  name="'.esc_attr($this->get_field_name('items')).'" type="text" value="'.esc_attr( $items ).'" /></p>';	

		echo '<p><label for="'.esc_attr($this->get_field_id('columns')).'">'.__('Columns:','compare').'</label>';
		echo '<input class="widefat" id="'.esc_attr($this->get_field_id('columns')).'"  name="'.esc_attr($this->get_field_name('columns')).'" type="text" value="'.esc_attr( $columns ).'" /></p>';	

		echo '<p><label for="'.esc_attr($this->get_field_id('rows')).'">'.__('Rows:','compare').'</label>';
		echo '<input class="widefat" id="'.esc_attr($this->get_field_id('rows')).'"  name="'.esc_attr($this->get_field_name('rows')).'" type="text" value="'.esc_attr( $rows ).'" /></p>';	
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['stores'] = $new_instance['stores'];
		$instance['items'] = strip_tags($new_instance['items']);
		$instance['columns'] = strip_tags($new_instance['columns']);
		$instance['rows'] = strip_tags($new_instance['rows']);
		return $instance;	
	}	
}

/******************************************************** 
Compare Banner
********************************************************/
class Compare_Banner extends WP_Widget {	
	public function __construct() {
		parent::__construct('compare_banner', __('Compare Banner','compare'), array('description' =>__("Compare Banner Widget","compare") ));
	}
	public function widget( $args, $instance ) {
		extract($args);
		$image = esc_attr( $instance['image'] );
		$link = esc_attr( $instance['link'] );
		
		echo  $before_widget.
			'<a href="'.esc_url( $link ).'"  target="_blank" ><img src="'.esc_url( $image ).'" class="img-responsive" alt=""></a>'.$after_widget;
	}
 	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'image' => '', 'link' => '') );

		$image = $instance['image'] ;
		$link = $instance['link'];
		
		echo '<p><label for="'.esc_attr($this->get_field_id('image')).'">'.__('Image URL:','compare').'</label>';
		echo '<input class="widefat" id="'.esc_attr($this->get_field_id('image')).'"  name="'.esc_attr($this->get_field_name('image')).'" type="text" value="'.esc_url( $image ).'" /></p>';	

		echo '<p><label for="'.esc_attr($this->get_field_id('link')).'">'.__('Link:','compare').'</label>';
		echo '<input class="widefat" id="'.esc_attr($this->get_field_id('link')).'"  name="'.esc_attr($this->get_field_name('link')).'" type="text" value="'.esc_url( $link ).'" /></p>';	
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['image'] = esc_url($new_instance['image']);
		$instance['link'] = esc_url($new_instance['link']);
		return $instance;	
	}	
}

/******************************************************** 
Compare Social
********************************************************/
class Compare_Social extends WP_Widget {	
	public function __construct() {
		parent::__construct('compare_social', __('Compare Social','compare'), array('description' =>__("Compare Social Widget","compare") ));
	}
	public function widget( $args, $instance ) {
		extract($args);
		$logo = esc_attr( $instance['logo'] );
		$link = esc_attr( $instance['link'] );
		$facebook = esc_attr( $instance['facebook'] );
		$google = esc_attr( $instance['google'] );
		$twitter = esc_attr( $instance['twitter'] );
		
		$logo_html = '';
		if( !empty( $logo ) ){
			$logo_html = '<a href="'.esc_url( $link ).'" target="_blank" class="widget-logo"><img src="'.esc_url( $logo ).'" class="img-responsive" alt="footer_logo"></a>';
		}

		echo  $before_widget.'
			'.$logo_html.'
			<ul class="list-unstyled list-inline">
				'.( !empty( $facebook ) ? '<li><a href="'.esc_url( $facebook ).'" target="_blank"><i class="fa fa-facebook"></i></a></li>' : '' ).'
				'.( !empty( $google ) ? '<li><a href="'.esc_url( $google ).'" target="_blank"><i class="fa fa-google-plus"></i></a></li>' : '' ).'
				'.( !empty( $twitter ) ? '<li><a href="'.esc_url( $twitter ).'" target="_blank"><i class="fa fa-twitter"></i></a></li>' : '' ).'
			</ul>
			'.$after_widget;
	}
 	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'logo' => '', 'link' => '', 'facebook' => '', 'google' => '', 'twitter' => '') );

		$logo = $instance['logo'] ;
		$link = $instance['link'];
		$facebook = $instance['facebook'];
		$google = $instance['google'];
		$twitter = $instance['twitter'];
		
		echo '<p><label for="'.esc_attr($this->get_field_id('logo')).'">'.__('Logo URL:','compare').'</label>';
		echo '<input class="widefat" id="'.esc_attr($this->get_field_id('logo')).'"  name="'.esc_attr($this->get_field_name('logo')).'" type="text" value="'.esc_url( $logo ).'" /></p>';	

		echo '<p><label for="'.esc_attr($this->get_field_id('link')).'">'.__('Link:','compare').'</label>';
		echo '<input class="widefat" id="'.esc_attr($this->get_field_id('link')).'"  name="'.esc_attr($this->get_field_name('link')).'" type="text" value="'.esc_url( $link ).'" /></p>';	

		echo '<p><label for="'.esc_attr($this->get_field_id('facebook')).'">'.__('Facebook Link:','compare').'</label>';
		echo '<input class="widefat" id="'.esc_attr($this->get_field_id('facebook')).'"  name="'.esc_attr($this->get_field_name('facebook')).'" type="text" value="'.esc_url( $facebook ).'" /></p>';	

		echo '<p><label for="'.esc_attr($this->get_field_id('google')).'">'.__('Google+ Link:','compare').'</label>';
		echo '<input class="widefat" id="'.esc_attr($this->get_field_id('google')).'"  name="'.esc_attr($this->get_field_name('google')).'" type="text" value="'.esc_url( $google ).'" /></p>';	

		echo '<p><label for="'.esc_attr($this->get_field_id('twitter')).'">'.__('Twitter Link:','compare').'</label>';
		echo '<input class="widefat" id="'.esc_attr($this->get_field_id('twitter')).'"  name="'.esc_attr($this->get_field_name('twitter')).'" type="text" value="'.esc_url( $twitter ).'" /></p>';	
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['logo'] = esc_url($new_instance['logo']);
		$instance['link'] = esc_url($new_instance['link']);
		$instance['facebook'] = esc_url($new_instance['facebook']);
		$instance['google'] = esc_url($new_instance['google']);
		$instance['twitter'] = esc_url($new_instance['twitter']);
		return $instance;	
	}	
}

/******************************************************** 
Compare Categories
********************************************************/
class Compare_Categories extends WP_Widget {	
	public function __construct() {
		parent::__construct('compare_categories', __('Compare Categories','compare'), array('description' =>__("Compare Categories Widget","compare") ));
	}
	public function widget( $args, $instance ) {
		extract($args);
		global $COMPARE_SEARCH_URL;
		global $compare_slugs;
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __('Categories','compare') : $instance['title'], $instance, $this->id_base);
		$categories = $instance['categories'];
		
		echo  $before_widget.
				$before_title.$title.$after_title.'
				<ul class="list-unstyled">';
				if( !empty( $categories ) )		{
					foreach( $categories as $category ){
						$term = get_term_by( 'slug', $category, 'product-cat' );
						echo '<li><a href="'.esc_url( add_query_arg( array( $compare_slugs['product-cat'] => $category ), $COMPARE_SEARCH_URL ) ).'">'.$term->name.'<span class="count">('.$term->count.')</span></a></li>';
					}				}
		echo	'</ul>'.$after_widget;
	}
 	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'categories' => array(), 'items' => '', 'columns' => '', 'rows' => '') );
		
		$title = esc_attr( $instance['title'] );
		$categories = $instance['categories'];
		
		echo '<p><label for="'.esc_attr($this->get_field_id('title')).'">'.__('Title:','compare').'</label>';
		echo '<input class="widefat" id="'.esc_attr($this->get_field_id('title')).'"  name="'.esc_attr($this->get_field_name('title')).'" type="text" value="'.esc_attr( $title ).'" /></p>';	

		echo '<p><label for="'.esc_attr($this->get_field_id('categories')).'">'.__('Categories:','compare').'</label>';
		echo '<select class="widefat" id="'.esc_attr($this->get_field_id('categories')).'"  name="'.esc_attr($this->get_field_name('categories')).'[]" multiple>';
		$categories_list = get_terms( 'product-cat', array(
			'hide_empty' => false
		) );

		if( !empty( $categories_list ) ){
			foreach( $categories_list as $category ){
				echo '<option value="'.esc_attr( $category->slug ).'" '.( in_array( $category->slug, $categories ) ? 'selected="selected"' : '' ).'>'.$category->name.'</option>';
			}
		}
		echo '</select></p>';	
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['categories'] = $new_instance['categories'];
		return $instance;	
	}	
}

/******************************************************** 
Compare Icon Text
********************************************************/
class Compare_Icon_Text extends WP_Widget {	
	public function __construct() {
		parent::__construct('compare_icon_text', __('Compare Icon Text','compare'), array('description' =>__("Compare Icon Text Widget","compare") ));
	}
	public function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __('Icon Text','compare') : $instance['title'], $instance, $this->id_base);
		
		echo  $before_widget.
				$before_title.$title.$after_title.'
				<ul class="list-unstyled">';
				for( $i=1; $i<=5; $i++ ){
					$title = $instance['title'.$i];
					$icon = $instance['icon'.$i];
					$text = $instance['text'.$i];
					if( !empty( $title ) || ( !empty( $icon ) && $icon !== 'No Icon' ) || !empty( $text ) ){
						echo '<li>
								'.( !empty( $icon ) ? '<i class="fa fa-'.esc_attr( $icon ).'"></i>' : '' ).'
								<div class="icon-text">
									'.( !empty( $title ) ? '<strong>'.$title.'</strong>' : '' ).'
									'.( !empty( $text ) ? '<p>'.$text.'</p>' : '' ).'
								</div>
						  	</li>';
					}
				}
		echo	'</ul>'.$after_widget;
	}
 	public function form( $instance ) {
 		$defaults = array(
 			'title' => ''
 		);
 		for( $i=1; $i<=5; $i++ ){
 			$defaults['title'.$i] = '';
 			$defaults['icon'.$i] = '';
 			$defaults['text'.$i] = '';
 		}

		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$title = esc_attr( $instance['title'] );

		
		echo '<p><label for="'.esc_attr($this->get_field_id('title')).'">'.__('Title:','compare').'</label>';
		echo '<input class="widefat" id="'.esc_attr($this->get_field_id('title')).'"  name="'.esc_attr($this->get_field_name('title')).'" type="text" value="'.esc_attr( $title ).'" /></p>';	

		for( $i=1; $i<=5; $i++ ){
			echo '<p><label for="'.esc_attr($this->get_field_id('title'.$i)).'">'.__('Title ','compare').''.$i.':</label>';
			echo '<input class="widefat" id="'.esc_attr($this->get_field_id('title'.$i)).'"  name="'.esc_attr($this->get_field_name('title'.$i)).'" type="text" value="'.esc_attr( $instance['title'.$i] ).'" /></p>';	

			echo '<p><label for="'.esc_attr($this->get_field_id('icon'.$i)).esc_attr( $i ).'">'.__('Icon ','compare').''.$i.':</label>';
			echo '<select class="widefat" id="'.esc_attr($this->get_field_id('icon'.$i)).'"  name="'.esc_attr($this->get_field_name('icon'.$i)).'">';
			$icons = compare_awesome_icons_list();
			foreach( $icons as $icon )			{
				echo '<option value="'.esc_attr( $icon ).'" '.( $icon == $instance['icon'.$i] ? 'selected="selected"' : '' ).'>'.$icon.'</option>';
			}
			echo '</select></p>';	

			echo '<p><label for="'.esc_attr($this->get_field_id('text'.$i)).'">'.__('Text ','compare').''.$i.':</label>';
			echo '<input class="widefat" id="'.esc_attr($this->get_field_id('text'.$i)).'"  name="'.esc_attr($this->get_field_name('text'.$i)).'" type="text" value="'.esc_attr( $instance['text'.$i] ).'" /></p>';	
		}
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		for( $i=1; $i<=5; $i++ ){
			$instance['title'.$i] = strip_tags($new_instance['title'.$i]);
			$instance['icon'.$i] = strip_tags($new_instance['icon'.$i]);
			$instance['text'.$i] = strip_tags($new_instance['text'.$i]);
		}
		return $instance;	
	}	
}

/********************************************************
Compare Custom Menu Widget
********************************************************/
class Compare_Custom_Menu extends WP_Widget {
	public function __construct() {
		parent::__construct('compare_custom_menu', __('Compare Custom Menu','compare'), array('description' =>__('Compare Custom Menu Widget For The Footer Only','compare') ));
	}
	public function widget( $args, $instance ) {
		extract($args);
		$title = empty( $instance['title'] ) ? '' : $instance['title'];
		$menu = empty( $instance['menu'] ) ? '' : $instance['menu'];
		$columns = empty( $instance['columns'] ) ? '' : $instance['columns'];
		$rnd = compare_random_string();

		$menu = wp_get_nav_menu_items( $menu );
		echo  $before_widget.$before_title.$title.$after_title.'<div class="white-block-content">';

		if( !empty( $menu ) ){
			$style = '<style>
			.list_'.$rnd.'{
				columns: '.$columns.';
				-moz-columns: '.$columns.';
				-webkit-columns: '.$columns.';
				-ms-columns: '.$columns.';
				-o-columns: '.$columns.';
			}
			</style>';
			echo compare_shortcode_style( $style ).'<ul class="list-unstyled list_'.$rnd.'">';
			foreach( $menu as $menu_item ){
				?>
				<li>
					<a href="<?php echo esc_url( $menu_item->url ); ?>">
						<?php echo esc_html( $menu_item->title ); ?>
					</a>
				</li>
				<?php
			}
			echo '</ul>';
		}
		echo '</div>'.$after_widget;	
	}
 	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'menu' => '', 'columns' => '1' ) );
		
		$title = esc_attr( $instance['title'] );
		$menu = $instance['menu'];
		$columns = esc_attr( $instance['columns'] );

		echo '<p><label for="'.esc_attr($this->get_field_id('title')).'">'.__( 'Title:', 'compare' ).'</label>';
		echo '<input type="text" class="widefat" id="'.esc_attr($this->get_field_id('title')).'"  name="'.esc_attr($this->get_field_name('title')).'" value="'.esc_attr( $title ).'"></p>';		

		echo '<p><label for="'.esc_attr($this->get_field_id('menu')).'">'.__( 'Menu:', 'compare' ).'</label>';
		echo '<select class="widefat" id="'.esc_attr($this->get_field_id('menu')).'"  name="'.esc_attr($this->get_field_name('menu')).'">';
			$menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );	
			if( !empty( $menus ) ){
				foreach( $menus as $menu_item ){
					echo '<option value="'.$menu_item->term_id.'" '.( $menu_item->term_id == $menu ? 'selected="selected"' : '' ).'>'.$menu_item->name.'</option>';
				}
			}
		echo '</select>';

		echo '<p><label for="'.esc_attr($this->get_field_id('columns')).'">'.__( 'Columns:', 'compare' ).'</label>';
		echo '<input type="text" class="widefat" id="'.esc_attr($this->get_field_id('columns')).'"  name="'.esc_attr($this->get_field_name('columns')).'" value="'.esc_attr( $columns ).'"></p>';		
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['menu'] = strip_tags( $new_instance['menu'] );
		$instance['columns'] = strip_tags( $new_instance['columns'] );
		return $instance;	
	}	
}

/********************************************************
Compare Latest Products
********************************************************/
class Compare_Latest_Products extends WP_Widget {
	public function __construct() {
		parent::__construct('compare_latest_product', __('Compare Latest Products','compare'), array('description' =>__('Compare Latest Products','compare') ));
	}
	public function widget( $args, $instance ) {
		extract($args);
		$title = empty( $instance['title'] ) ? '' : $instance['title'];
		$items = empty( $instance['items'] ) ? '' : $instance['items'];

		echo  $before_widget.$before_title.$title.$after_title;

		$latest = new WP_Query(
			array(
				'post_type' => 'product',
				'post_status' => 'publish',
				'posts_per_page' => $items
			)
		);
		$product_ids = wp_list_pluck( $latest->posts, 'ID' );
		$product_metas = compare_product_item_meta( $product_ids );			

		if( $latest->have_posts() ){
			while( $latest->have_posts() ){
				$latest->the_post();
				include( get_template_directory() . '/includes/product-box.php' );
			}
		}

		wp_reset_postdata();

		echo  $after_widget;	
	}
 	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'items' => '' ) );
		
		$title = esc_attr( $instance['title'] );
		$items = $instance['items'];

		echo '<p><label for="'.esc_attr($this->get_field_id('title')).'">'.__( 'Title:', 'compare' ).'</label>';
		echo '<input type="text" class="widefat" id="'.esc_attr($this->get_field_id('title')).'"  name="'.esc_attr($this->get_field_name('title')).'" value="'.esc_attr( $title ).'"></p>';		

		echo '<p><label for="'.esc_attr($this->get_field_id('items')).'">'.__( 'Items:', 'compare' ).'</label>';
		echo '<input type="text" class="widefat" id="'.esc_attr($this->get_field_id('items')).'"  name="'.esc_attr($this->get_field_name('items')).'" value="'.esc_attr( $items ).'"></p>';		
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['items'] = strip_tags( $new_instance['items'] );
		return $instance;	
	}	
}


/********************************************************
Add Compare Widgets
********************************************************/
function compare_widgets_load(){
	register_widget( 'Compare_Brands' );
	register_widget( 'Compare_Stores' );
	register_widget( 'Compare_Banner' );
	register_widget( 'Compare_Categories' );
	register_widget( 'Compare_Latest_Products' );
	register_widget( 'Compare_Icon_Text' );
	register_widget( 'Compare_Custom_Menu' );
	register_widget( 'Compare_Social' );
}
add_action( 'widgets_init', 'compare_widgets_load' );
?>