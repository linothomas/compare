<?php 
$main_color = compare_get_option( 'main_color' );
$main_color_font = compare_get_option( 'main_color_font' );

$secondary_color = compare_get_option( 'secondary_color' );
$secondary_font_color = compare_get_option( 'secondary_font_color' );
$secondary_color_hvr = compare_get_option( 'secondary_color_hvr' );
$secondary_font_color_hvr = compare_get_option( 'secondary_font_color_hvr' );

$top_bar_bg_color = compare_get_option( 'top_bar_bg_color' );
$top_bar_font_color = compare_get_option( 'top_bar_font_color' );

$submenu_bg_color = compare_get_option( 'submenu_bg_color' );
$submenu_font_color = compare_get_option( 'submenu_font_color' );
$submenu_bottom_border_color = compare_get_option( 'submenu_bottom_border_color' );

$categories_font_color_hvr = compare_get_option( 'categories_font_color_hvr' );
$categories_bg_color_hvr = compare_get_option( 'categories_bg_color_hvr' );

$copyrights_bg_color = compare_get_option( 'copyrights_bg_color' );
$copyrights_font_color = compare_get_option( 'copyrights_font_color' );
$copyrights_link_color = compare_get_option( 'copyrights_link_color' );

$font_family = compare_get_option( 'font_family' );

$site_logo_padding = compare_get_option( 'site_logo_padding' );

?>


.top-bar{
    background-color: <?php echo  $top_bar_bg_color ?>;
}
/* top bar font color - - - */
.top-bar .navbar ul li,
.top-bar .navbar ul li a,
.top-bar .navbar ul li a i,
.top-bar .navbar ul li a:hover,
.top-bar .navbar ul li a:focus,
.top-bar ul li,
.top-bar ul li i {
    color: <?php echo  $top_bar_font_color ?>;
}

/* category search on hover font color - - - */
.search_bar .dropdown .dropdown-menu li a:hover,
.search_bar .dropdown .dropdown-menu li a:hover i,
.search_bar .dropdown .dropdown-menu li a:hover span {
    color: <?php echo  $categories_font_color_hvr ?>;
}

.search_bar .dropdown .dropdown-menu li a:hover{
    background-color: <?php echo  $categories_bg_color_hvr ?>;
}


/* subemnu background */
.navigation .navbar .navbar-collapse ul li .dropdown-menu li{
    background-color: <?php echo  $submenu_bg_color ?>;
}

.navigation .navbar .navbar-collapse ul li .dropdown-menu li a{
    color: <?php echo  $submenu_font_color ?>;
}

/* =Main Color
--------------------------------------------------------------------- */
/* bg color - - - */
.featured-slider-wrap .owl-controls .owl-dots .active,
.newsletter .newsletter-form a,
.white-title i,
.single-product .widget-footer .widget-title:before,
.widget-footer .widget-title:before,
.tagcloud a:hover,
.search-filter .white-block .white-block-content .checkbox input[type="checkbox"]:checked + label::after,
.reset_filter:hover,
.pagination ul li a:hover,
.pagination ul li.active a,
.store-name a:hover{
    background-color: <?php echo  $main_color ?>;
    color: <?php echo  $main_color_font ?>;
}


.navigation .navbar .navbar-collapse ul li .dropdown-menu li:hover > a,
.search_bar .dropdown .dropdown-menu li a:hover,
blockquote{
    border-color: <?php echo  $main_color ?>;
}

/* font color - - - */
.navigation .navbar .navbar-collapse ul li a:hover,
.navigation .navbar .navbar-collapse ul li.mega_menu_li .mega_menu li.white-block ul li a:hover,
.navigation .navbar .navbar-collapse ul .current-menu-item a,
.search_bar .dropdown .dropdown-menu li .category_mega_menu_wrap ul li a:hover,
.widget-title i,
.search-filter i,
.single-product .white-block.product-box .white-block-content h4 a:hover,
.white-block.product-box .white-block-content h4 a:hover,
.single-product .white-block.product-box .white-block-content .product-meta span:nth-child(2),
.white-block.product-box .white-block-content .product-meta span:nth-child(2),
.categories .owl-item .category-item p a:hover,
.blog .white-block .white-block-content h3 a:hover,
.shortcode-blogs .white-block .white-block-content h3 a:hover,
.footer a,
.search-filter .white-block .white-block-content .view-more,
.search-filter .white-block .white-block-content .view-more:hover,
.search-filter .white-block.filter-bar .white-block-content:nth-child(2) ul li a[data-value="list"].active i, .search-filter .white-block.filter-bar .white-block-content:nth-child(2) ul li a[data-value="grid"].active i,
.search-filter .white-block.filter-bar .white-block-content:nth-child(2) ul li:last-child span,
.reset_filter,
.reset_filter:focus, .reset_filter:active,
.pagination ul li.prev a, .pagination ul li.next a,
.single-product .white-block .tab-content #tags .white-block-content a:hover,
.single-product .white-block .tab-content #categories .white-block-content a:hover,
.single-product .comments ~ .white-block .white-block-content a:hover,
.bootstrap-table .table tbody tr td.shipping a,
.bootstrap-table .table tbody tr td.shipping a:hover,
.comment-respond .logged-in-as a,
.comment-respond .logged-in-as a:hover,
.comments .white-block-content .media .media-body .comment-reply-link,
.comments .white-block-content .media .media-body .comment-reply-link:hover,
.send_result .alert.alert-info,
.send_result .alert.alert-info span,
.widget ul li a:hover,
.widget ul li.recentcomments a,
.widget ul.children li:hover > a, .widget ul.sub-menu li:hover > a,
.widget-footer ul li a:hover,
.widget-footer .white-block.widget_compare_custom_menu ul li a:hover,
.widget-footer .widget_archive ul li.recentcomments span,
.widget-footer .widget_recent_entries ul li.recentcomments span,
.widget-footer .widget_recent_comments ul li.recentcomments span,
.widget-footer .widget_meta ul li.recentcomments span,
.widget-footer .widget_categories ul li.recentcomments span,
.widget-footer .widget_archive ul li.recentcomments a:hover,
.widget-footer .widget_recent_entries ul li.recentcomments a:hover,
.widget-footer .widget_recent_comments ul li.recentcomments a:hover,
.widget-footer .widget_meta ul li.recentcomments a:hover,
.widget-footer .widget_categories ul li.recentcomments a:hover,
.widget-footer .widget_recent_comments .recentcomments .comment-author-link,
.widget-footer .widget_recent_comments .recentcomments .comment-author-link a,
.widget-footer .widget_recent_comments .recentcomments .comment-author-link a:hover,
.widget-footer .widget_rss a,
.post-tags-block a:hover,
.comment-reply-title a ,
.comment-reply-title a:hover,
.comment-reply-title small a,
.comment-reply-title small a:hover,
.modal .modal-body a,
.modal .modal-body a:hover,
.panel-group .panel-default .panel-heading .panel-title .count,
.panel-group .panel-default .panel-collapse .panel-body ul li a:hover,
.panel-group .panel-default .panel-collapse .panel-body ul li .count,
.alert.alert-info,
.alert.alert-info span {
    color: <?php echo  $main_color ?>;
}

.widget-title i,
.search-filter i{
    background-color: transparent;
}

/* =Green button
--------------------------------------------------------------------------------- */
/* bg - - - */
.navigation .navbar .navbar-collapse ul .register-nav a,
.bootstrap-table .table tbody tr td:not(.shipping) a,
.comment-respond .form-submit .submit,
.register-store .submit-form-store,
.submit-form-contact,
.input-group .form-submit .submit,
.toggle-navigation,
.toggle-categories,
.small-screen-register-store {
    background-color: <?php echo  $secondary_color ?>;
}
/* bg on hover - - - */
.navigation .navbar .navbar-collapse ul .register-nav a:hover,
.bootstrap-table .table tbody tr td:not(.shipping) a:hover,
.bootstrap-table .table tbody tr td:not(.shipping) a:focus
.comment-respond .form-submit .submit:hover,
.comment-respond .form-submit .submit:focus
.register-store .submit-form-store:hover,
.register-store .submit-form-store:focus
.submit-form-contact:hover,
.submit-form-contact:focus
.input-group .form-submit .submit:hover,
.input-group .form-submit .submit:focus,
.toggle-navigation:hover,
.toggle-categories:hover,
.small-screen-register-store:hover,
.toggle-navigation:focus,
.toggle-categories:focus,
.small-screen-register-store:focus {
    background-color: <?php echo  $secondary_color_hvr ?>;
}

/* font color - - - */
.navigation .navbar .navbar-collapse ul .register-nav a
.bootstrap-table .table tbody tr td:not(.shipping) a,
.comment-respond .form-submit .submit,
.register-store .submit-form-store,
.submit-form-contact,
.submit-form-contact:hover,
.submit-form-contact:focus
.input-group .form-submit .submit,
.toggle-navigation,
.toggle-categories,
.small-screen-register-store {
    color: <?php echo  $secondary_font_color ?>;
}
/* font color on hover - - -*/
.navigation .navbar .navbar-collapse ul .register-nav a:hover,
.navigation .navbar .navbar-collapse ul .register-nav a:focus,
.bootstrap-table .table tbody tr td:not(.shipping) a:hover,
.bootstrap-table .table tbody tr td:not(.shipping) a:focus
.comment-respond .form-submit .submit:hover,
.comment-respond .form-submit .submit:focus
.register-store .submit-form-store:hover,
.register-store .submit-form-store:focus,
.input-group .form-submit .submit:hover,
.input-group .form-submit .submit:focus
.toggle-navigation:hover,
.toggle-categories:hover,
.toggle-navigation:focus,
.toggle-categories:focus
.small-screen-register-store:hover,
.small-screen-register-store:focus {
    color: <?php echo  $secondary_font_color_hvr ?>;
}


.footer {
    background-color: <?php echo  $copyrights_bg_color ?>;
    color: <?php echo  $copyrights_font_color ?>;
}
.footer a {
    color: <?php echo  $copyrights_link_color ?>;
}

body,
h1,
h2,
h3,
h4,
h5,
h6 {
    font-family: "<?php echo  $font_family ?>", Helvetica, Arial, sans-serif;
}

.site-logo{
    padding: <?php echo  $site_logo_padding ?>;
}

.navigation .navbar .navbar-collapse ul li .dropdown-menu li:hover>a, .search_bar .dropdown .dropdown-menu li a:hover{
    border-bottom-color: <?php echo  $submenu_bottom_border_color ?>;
}