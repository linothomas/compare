<?php
	global $wpdb;
	$hash = md5( uniqid() );
	compare_display_import_info( '***** '.__( 'STORE FEED IMPORT PROCESS STARTED', 'compare' ).' *****<br/>' );
	if( $store->store_status == '1' ){
		if( empty( $store->store_expire_time ) || current_time( 'timestamp' ) <= $store->store_expire_time ){
			$remain = $store->store_expire_time - current_time( 'timestamp' );
			if( $remain <= 86400*3 ){
				/* send mail that store package will soon expire with some link to prolongate */
				$remain  = compare_time2string( $remain );
				$wpdb->query(
					$wpdb->prepare(
						"UPDATE {$wpdb->prefix}stores SET store_update = %s WHERE store_id = %d",
						$hash,
						$store_id
					)
				);			
				$link = add_query_arg( array( 'hash' => $hash ), compare_get_permalink_by_tpl( 'page-tpl_register_store' ) );

				$message = __( 'Your store will expire and feed associated with your store will be deleted unless you prolongate your package.', 'compare' )."<br/><br/>";
				$message .= __( 'Time remaining: ', 'compare' ).$remain."<br/><br/>";
				$message .= __( 'In order to prolongate your store visit link bellow and select your new package.', 'compare' )."<br/><br/>";
				$message .= '<a href="'.esc_attr( $link ).'" target="_blank">'.$link.'</a>';

				compare_inform_store( $message, $store->store_contact_email, __( 'Store Is About To Exipre - Notification', 'compare' ) );
				compare_display_import_info( __( 'Store is about to expire, owner has been informed.', 'compare' ) );
			}
			if( !empty( $store->store_xml_feed ) && stristr( $store->store_xml_feed, 'http' ) !== false ){
				$import_data = compare_store_parse_and_import( $store->store_xml_feed, $store_id, $store->store_parser );
				if ( is_wp_error( $import_data ) ) {
					echo '<p><strong>' . __( 'Sorry, there has been an error.', 'compare' ) . '</strong><br/>';
					echo esc_html( $import_data->get_error_message() ) . '</p>';
					return false;
				}
			}
			else{
				$message = __( 'Store ', 'compare' ).'<strong>'.$store->store_name.'</strong>'.__( ' has no feed associated with it.', 'compare' );
				compare_display_import_info( $message );
			}
		}
		else{
			/*store has expired delete its feeds*/
			$wpdb->query(
				$wpdb->prepare(
					"DELETE FROM {$wpdb->prefix}feed_list WHERE store_id = %d",
					$store_id
				)
			);

			/* mark store as not paid and set available for update */
			$wpdb->query(
				$wpdb->prepare(
					"UPDATE {$wpdb->prefix}stores SET store_status = '0', store_update = %s WHERE store_id = %d",
					$hash,
					$store_id
				)
			);
			/* inform user that store has expired, feeds deleted and add some links where he can prolongate this */
			$link = add_query_arg( array( 'hash' => $hash ), compare_get_permalink_by_tpl( 'page-tpl_register_store' ) );

			$message = __( 'Your store has been expired and feed associated with your store have been deleted.', 'compare' )."<br/><br/>";
			$message .= __( 'In order to activate your store again visit link bellow and select your new package.', 'compare' )."<br/><br/>";	
			$message .= '<a href="'.esc_attr( $link ).'" target="_blank">'.$link.'</a>';

			compare_inform_store( $message, $store->store_contact_email, __( 'Store Has Expired - Feeds Removed', 'compare' ) );
			compare_display_import_info( __( 'Store has expired, owner has been informed.', 'compare' ) );
		}
	}
	else{
		$message = __( 'Store ', 'compare' ).'<strong>'.$store->store_name.'</strong>'.__( ' is disabled since it is not paid for.', 'compare' );
		compare_display_import_info( $message );
	}

	compare_display_import_info( '<br/>***** '.__( 'STORE FEED IMPORT PROCESS COMPLETED', 'compare' ).' *****<br/>' );
?>