<?php
    if ( ! function_exists( 'hatt_setup_theme' ) ) :
        /**
         * Sets up theme defaults and registers support for various WordPress features.
         *
         * Note that this function is hooked into the after_setup_theme hook, which
         * runs before the init hook. The init hook is too late for some features, such
         * as indicating support for post thumbnails.
         */
        function hatt_setup_theme() {

            /*
             * Make theme available for translation.
             * Translations can be filed in the /languages/ directory.
             * If you're building a theme based on stframework, use a find and replace
             * to change $st_textdomain to the name of your theme in all the template files
             */
            // Add default posts and comments RSS feed links to head.
            add_theme_support( 'automatic-feed-links' );
            /*
             * Enable support for Post Thumbnails on posts and pages.
             *
             * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
             */
            add_theme_support( 'post-thumbnails' );
            // This theme uses wp_nav_menu() in one location.
            register_nav_menus( array(
                'primary'        => __( 'Header Navigation', HATT_TEXTDOMAIN ),
                'primary_mobile' => __( 'Header Mobile Navigation', HATT_TEXTDOMAIN ),
                'footer'         => __( 'Footer Navigation', HATT_TEXTDOMAIN ),
            ) );
            /*
             * Switch default core markup for search form, comment form, and comments
             * to output valid HTML5.
             */
            add_theme_support( 'html5', array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ) );
            if ( ! isset( $content_width ) ) {
                $content_width = 900;
            }
//        add_theme_support( 'woocommerce' );
            /*
             * Enable support for Post Formats.
             * See http://codex.wordpress.org/Post_Formats

             */
            add_theme_support( 'post-formats', array(
                'image',
                'video',
                'gallery',
                'audio',
            ) );
            // Setup the WordPress core custom background feature.
//        add_theme_support( 'custom-background', apply_filters( 'stframework_custom_background_args', array(
//            'default-color' => 'ffffff',
//            'default-image' => '',
//        ) ) );
        }
    endif; // stframework_setup
    if ( ! function_exists( 'hatt_setup_author' ) ) {
        function hatt_setup_author() {

            global $wp_query;
            if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
                $GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
            }
        }
    }
    if ( ! function_exists( 'hatt_wp_title' ) ) {
        function hatt_wp_title( $title, $sep ) {

            if ( is_feed() ) {
                return $title;
            }
            global $page, $paged;
            // Add the blog name
            $title .= get_bloginfo( 'name', 'display' );
            // Add the blog description for the home/front page.
            $site_description = get_bloginfo( 'description', 'display' );
            if ( $site_description && ( is_home() || is_front_page() ) ) {
                $title .= " $sep $site_description";
            }
            // Add a page number if necessary:
            if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
                $title .= " $sep " . sprintf( __( 'Page %s', HATT_TEXTDOMAIN ), max( $paged, $page ) );
            }

            return $title;
        }
    }
    if ( ! function_exists( 'admin_custom_css' ) ) {
        function admin_custom_css() {

            wp_register_style( 'customadmin', get_template_directory_uri() . '/admin/css/custom.css' );
            wp_register_style( 'customadmin', get_template_directory_uri() . '/admin/css/custom.css' );
            wp_enqueue_style( 'customadmin' );
        }
    }
if ( ! function_exists( 'admin_custom_script' ) ) {
     function admin_custom_script() {
          wp_register_script( 'jquery.searchabledropdown-1.0.8.min.js', get_template_directory_uri() . '/admin/js/jquery.searchabledropdown-1.0.8.min.js', array( 'jquery' ), null, TRUE );
          wp_register_script( 'admin.js', get_template_directory_uri() . '/admin/js/admin.js', array( 'jquery' ), null, TRUE );

          wp_enqueue_script( "jquery.searchabledropdown-1.0.8.min.js" );
          wp_enqueue_script( "admin.js" );

     }
}
    if ( ! function_exists( 'hatt_add_scripts' ) ) {
        function hatt_add_scripts() {

			// REPLACE CORE JQUERY
			wp_deregister_script( 'jquery-core' );
			wp_register_script( 'jquery-core', get_template_directory_uri() . '/js/jquery-3.6.0.js', array(), '3.6.0' );
			wp_deregister_script( 'jquery-migrate' );
			wp_register_script( 'jquery-migrate', get_template_directory_uri() . '/js/jquery-migrate-3.3.2.min.js', array(), '3.3.2' );


            //Scripts
            wp_register_script( 'bootstrap.min.js', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), null, TRUE );
            wp_register_script( 'bootstrap-modal.js', get_template_directory_uri() . '/js/bootstrap-modal.js', array( 'jquery' ), null, TRUE );
            wp_register_script( 'breakpoints.js', get_template_directory_uri() . '/js/breakpoints.js', array( 'jquery' ), null, TRUE );
            wp_register_script( 'smoothscroll.js', get_template_directory_uri() . '/js/smoothscroll.js', array( 'jquery' ), null, TRUE );
            wp_register_script( 'jquery.nicescroll.min.js', get_template_directory_uri() . '/js/jquery.nicescroll.min.js', array( 'jquery' ), null, TRUE );
            wp_register_script( 'owl.carousel.min.js', get_template_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ), null, TRUE );
            wp_register_script( 'jquery.flexslider-min.js', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array( 'jquery' ), null, TRUE );
            wp_register_script( 'wow.min.js', get_template_directory_uri() . '/js/wow.min.js', array( 'jquery' ), null, TRUE );
            wp_register_script( 'jquery.magnific-popup.min.js', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), null, TRUE );
            wp_register_script( 'prettyPhoto.js', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array( 'jquery' ), null, TRUE );
            wp_register_script( 'jquery.sticky.js', get_template_directory_uri() . '/js/jquery.sticky.js', array( 'jquery' ), null, TRUE );
            wp_register_script( 'tinynav.min.js', get_template_directory_uri() . '/js/tinynav.min.js', array( 'jquery' ), null, TRUE );
                wp_register_script( 'jquery.history.js', get_template_directory_uri() . '/js/jquery.history.js', array( 'jquery' ), null, TRUE );
                wp_register_script( 'jquery.cookie.js', get_template_directory_uri() . '/js/jquery.cookie.js', array( 'jquery' ), null, TRUE );

            if(SITE_LOCALE=="cn"){
            //load specific JS for CN site for find tyre
                wp_register_script( 'find-tyre.js', get_template_directory_uri() . '/js/ajax/find-tyre-CN.js', array( 'jquery' ), null, TRUE );
            /*}else if(SITE_LOCALE=="in" || SITE_LOCALE=="ph" ){
                wp_register_script( 'find-tyre.js', get_template_directory_uri() . '/js/ajax/find-tyre-IN.js', array( 'jquery' ), null, TRUE );
            */}else{
                wp_register_script( 'find-tyre.js', get_template_directory_uri() . '/js/ajax/find-tyre.js', array( 'jquery' ), null, TRUE );
            }


            wp_register_script( 'rfq-find-tyre.js', get_template_directory_uri() . '/js/ajax/rfq-find-tyre.js', array( 'jquery' ), null, TRUE );
            wp_localize_script( 'jquery', 'hatt_params', array(
                            'theme_url' => get_template_directory_uri(),
                            'site_url'  => site_url(),
                            'ajax_url'  => admin_url( 'admin-ajax.php' ),
                            'no_more'   => __( 'No more', HATT_TEXTDOMAIN )
                        ) );



            wp_register_script( 'main.js', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), null, TRUE );
            wp_register_script( 'mobile.js', get_template_directory_uri() . '/js/mobile.js', array( 'jquery' ), null, TRUE );
            wp_localize_script( 'jquery', 'hatt_params', array(
                'theme_url' => get_template_directory_uri(),
                'site_url'  => site_url(),
                'ajax_url'  => admin_url( 'admin-ajax.php' ),
                'no_more'   => __( 'No more', HATT_TEXTDOMAIN ),
                'locale'    => SITE_LOCALE,
            ) );
            wp_enqueue_script( "prettyPhoto.js" );
            wp_enqueue_script( "wow.min.js" );
            wp_enqueue_script( "bootstrap.min.js" );
            wp_enqueue_script( "bootstrap-modal.js" );
            wp_enqueue_script( "breakpoints.js" );
            wp_enqueue_script( "owl.carousel.min.js" );
            wp_enqueue_script( "jquery.magnific-popup.min.js" );

            if ( Hatt()->get_option( 'gen_enable_smscroll' ) == 'on' ) {
                wp_enqueue_script( "smoothscroll.js" );
            }

            if ( is_singular( 'tyres' ) ) {
                wp_enqueue_script( "jquery.flexslider-min.js" );

            }
            wp_enqueue_script( "jquery.nicescroll.min.js" );
            wp_enqueue_script( "jquery.sticky.js" );
            wp_enqueue_script( "tinynav.min.js" );
            wp_enqueue_script( 'main.js' );
            wp_enqueue_script( 'mobile.js' );
                wp_enqueue_script( 'jquery.history.js' );
                wp_enqueue_script( 'jquery.cookie.js' );

                if( is_page('request-for-quote') || is_page('request-for-quote-form') ){
                    wp_enqueue_script( 'rfq-find-tyre.js' );

                    wp_register_script('rfq_js_script',get_template_directory_uri().'/js/ajax/rfq-tyre.js', array( 'main.js' ));
                    wp_enqueue_script('rfq_js_script');


                }else{
                    wp_enqueue_script( 'find-tyre.js' );
                }


            /*** DTC script ***/
            if( is_page('worry-free-assurance') ){
                wp_register_script( 'dtc_script', get_template_directory_uri() . '/js/ajax/dtc.js?r=20250108', array( 'jquery' ), null, TRUE );
                wp_enqueue_script('dtc_script');
            }

            if( is_page('register-your-tyres') ){

                wp_register_script( 'jquery_ui', '/wp-content/themes/dtc-theme/js/jquery-ui.min.js', array( 'jquery' ), null, TRUE );
                wp_register_script( 'parsley', '/wp-content/themes/dtc-theme/js/parsley-2.3.7.js', array( 'jquery' ), null, TRUE );
                wp_register_script( 'typeahead', 'https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js', array( 'jquery' ), null, TRUE );
                wp_register_script( 'dtc_form_script', get_template_directory_uri() . '/js/ajax/dtc-form.js?r=20261007', array( 'jquery' ), null, TRUE );
                wp_register_script( 'mask', '/wp-content/themes/dtc-theme/js/jquery.mask.min.js', array( 'jquery' ), null, TRUE );

                wp_enqueue_script('jquery_ui');
                wp_enqueue_script('parsley');
                wp_enqueue_script('typeahead');
                wp_enqueue_script('dtc_form_script');
                wp_enqueue_script('mask');
            }

            if( is_page('check-warranty') ){
                wp_register_script( 'jquery_ui', '/wp-content/themes/dtc-theme/js/jquery-ui.min.js', array( 'jquery' ), null, TRUE );
                wp_register_script( 'parsley', '/wp-content/themes/dtc-theme/js/parsley-2.3.7.js', array( 'jquery' ), null, TRUE );
                wp_register_script( 'dtc_form_script', get_template_directory_uri() . '/js/ajax/dtc-check.js?r=20261009-4', array( 'jquery' ), null, TRUE );

                wp_enqueue_script('jquery_ui');
                wp_enqueue_script('parsley');
                wp_enqueue_script('dtc_form_script');
            }


            // TODO: load only on store page
            // is_archive()

            // echo 'HOOK, SITE_LOCALE:'.SITE_LOCALE;

            wp_register_script( 'findStore', get_template_directory_uri() . '/js/find-store.js', null, null, false );

            if(SITE_LOCALE=='cn'){
                wp_register_script( 'baidu.api', 'http://api.map.baidu.com/api?v=2.0&ak=eV38NdaEPDMPv9dquljiPalL', array(), '1.0.0', true );
                wp_register_script( 'baidu-texticon', 'http://api.map.baidu.com/library/TextIconOverlay/1.2/src/TextIconOverlay_min.js', array(), '1.0.0', true );
                wp_register_script( 'baidu-cluster', 'http://api.map.baidu.com/library/MarkerClusterer/1.2/src/MarkerClusterer_min.js', array(), '1.0.0', true );
                wp_register_script( 'baidu.area.restrict', 'http://api.map.baidu.com/library/AreaRestriction/1.2/src/AreaRestriction_min.js', array( 'baidu.api' ), null, false );
            }else{
                wp_register_script( 'google-map', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCP8e53mMTKV2lHJhTiGK2ZjYUfpJpRWzI', array(), '1.0.0', true );
                wp_register_script( 'google-map-clustering', get_template_directory_uri() . '/js/markerclusterer.js', array('google-map'), '1.0.0', true );
            }


            // wp_register_style( 'default-style', get_stylesheet_uri() );
            wp_register_style( 'normalize', get_template_directory_uri() . '/css/normalize.css' );
            wp_register_style( 'font-awesome.min', get_template_directory_uri() . '/css/font-awesome.min.css' );
            wp_register_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
            wp_register_style( 'owl.carousel.css', get_template_directory_uri() . '/css/owl.carousel.css' );
            wp_register_style( 'owl.theme.css', get_template_directory_uri() . '/css/owl.theme.css' );
            wp_register_style( 'flexslider.css', get_template_directory_uri() . '/css/flexslider.css' );
            wp_register_style( 'hover-min.css', get_template_directory_uri() . '/css/hover-min.css' );
            wp_register_style( 'magnific-popup.css', get_template_directory_uri() . '/css/magnific-popup.css' );
            wp_register_style( 'magnific-popup.css', get_template_directory_uri() . '/css/magnific-popup.css' );
            wp_register_style( 'prettyphoto.css', get_template_directory_uri() . '/css/prettyPhoto.css' );
            wp_register_style( 'wow.css', get_template_directory_uri() . '/css/wow/animate.css' );
            wp_register_style( 'font-style', get_template_directory_uri() . '/css/fonts.css' );

            if(SITE_LOCALE=='cn'){
                wp_register_style( 'main-style', get_template_directory_uri() . '/css/style-cn.css' );
            }else{
                wp_register_style( 'main-style', get_template_directory_uri() . '/css/style.css' );
            }

            if(SITE_LOCALE=='cn'){
                wp_register_style( 'font-style-cn', get_template_directory_uri() . '/css/fonts-cn.css' );
            }
            if(SITE_LOCALE=='th'){
                wp_register_style( 'font-style-th', get_template_directory_uri() . '/css/fonts-th.css' );
            }
            if(SITE_LOCALE=='vn'){
                wp_register_style( 'font-style-vn', get_template_directory_uri() . '/css/fonts-vn.css' );
            }
            if(SITE_LANG == "hkzh"){
                wp_register_style( 'font-style-hkzh', get_template_directory_uri() . '/css/fonts-hkzh.css' );
            }



            if(SITE_LOCALE=='cn'){
                wp_register_style( 'custom', get_template_directory_uri() . '/css/custom-cn.css' );
            /*}else if(SITE_LANG == "hkzh"){
                wp_register_style( 'custom', get_template_directory_uri() . '/css/custom-hkzh.css' );
            */}else{
                wp_register_style( 'custom', get_template_directory_uri() . '/css/custom.css' );
            }


                if(SITE_LOCALE=='cn'){
                     wp_register_style( 'inno', get_template_directory_uri() . '/css/inno-cn.css' );
                }else{
                     wp_register_style( 'inno', get_template_directory_uri() . '/css/inno.css' );
                }

            wp_register_style( 'mobile', get_template_directory_uri() . '/css/mobile.css' );

            wp_enqueue_style( 'bootstrap' );
            // wp_enqueue_style( 'default-style' );
            wp_enqueue_style( 'normalize' );
            wp_enqueue_style( 'prettyphoto.css' );
            wp_enqueue_style( 'wow.css' );
            wp_enqueue_style( 'owl.carousel.css' );
            wp_enqueue_style( 'owl.theme.css' );
            wp_enqueue_style( 'hover-min.css' );
            wp_enqueue_style( 'magnific-popup.css' );

            if ( is_singular( 'tyres' ) ) {
                wp_enqueue_style( 'flexslider.css' );
            }

            wp_enqueue_style( 'font-awesome.min' );
            wp_enqueue_style( 'font-style' );

            if(SITE_LOCALE=='cn'){
                wp_enqueue_style( 'font-style-cn' );
            }
            if(SITE_LANG=='hkzh'){
                wp_enqueue_style( 'font-style-hkzh' );
            }
            if(SITE_LOCALE=='th'){
                wp_enqueue_style( 'font-style-th' );
            }

            if(SITE_LOCALE=='vn'){
                wp_enqueue_style( 'font-style-vn' );
            }

            wp_enqueue_style( 'main-style' );
            wp_enqueue_style( 'custom' );
            wp_enqueue_style( 'mobile' );
                wp_enqueue_style( 'inno' );
        }
    }
    if ( ! function_exists( 'hatt_add_favicon' ) ) {
        function hatt_add_favicon() {

            $favicon = Hatt()->get_option( 'favicon', get_template_directory_uri() . '/images/favicon.png' );
            $ext     = pathinfo( $favicon, PATHINFO_EXTENSION );
            //if(strtolower($ext)=="pne")
            $type = "";
            switch ( strtolower( $ext ) ) {
                case "png":
                    $type = "image/png";
                    break;
                case "jpg":
                    $type = "image/jpg";
                    break;
                case "jpeg":
                    $type = "image/jpeg";
                    break;
                case "gif":
                    $type = "image/gif";
                    break;
            }
            if ( $type ) {
                $type = 'type="' . esc_attr( $type ) . '"';
            }
            echo '<link rel="icon"  ' . $type . '  href="' . esc_url( $favicon ) . '">';
//
        }
    }
    if ( ! function_exists( 'hatt_before_body_content' ) ) {
        function hatt_before_body_content() {

            if ( Hatt()->get_option( 'gen_disable_preload' ) == "off" ) {
                ?>
                <!-- Preload -->
                <div id="bt-preload"></div>
                <!-- End Preload -->
            <?php
            }
        }
    }
    if ( ! function_exists( 'hatt_add_compress_html' ) ) {
        function hatt_add_compress_html() {

            if ( Hatt()->get_option( 'adv_compress_html' ) == "on" ) {
                include_once Hatt()->dir( 'plugins/html-compression.php' );
            }
        }
    }
    if ( ! function_exists( 'hatt_add_ie8_support' ) ) {
        function hatt_add_ie8_support() {

            ?>
            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js" );
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js" );
            <![endif]-->
        <?php
        }
    }
    if ( ! function_exists( 'hatt_control_container' ) ) {
        function hatt_control_container( $is_wrap = FALSE ) {

            $layout = Hatt()->get_option( 'style_layout' );
            if ( is_singular() ) {
                if ( $layout_meta = get_post_meta( get_the_ID(), 'style_layout', TRUE ) ) {
                    $layout = $layout_meta;
                }
            }
            if ( $layout == "boxed" ) {
                if ( $is_wrap ) {
                    return "container";
                } else {
                    return "container-wrap";
                }
            } else {
                if ( ! $is_wrap ) {
                    return "container";
                }
            }
        }
    }
    if ( ! function_exists( 'hatt_add_body_class' ) ) {
        function hatt_add_body_class( $class = array() ) {

            $class[] = 'woocommerce';

            return $class;
        }
    }
    if ( ! function_exists( 'hatt_widgets_init' ) ) {
        function hatt_widgets_init() {

            register_sidebar( array(
                'name'          => __( 'Shop Sidebar', HATT_TEXTDOMAIN ),
                'id'            => 'sidebar-shop',
                'description'   => __( 'Widgets in this area will be shown on shop.', HATT_TEXTDOMAIN ),
                'before_title'  => '<h4 class="widget-title">',
                'after_title'   => '</h4>',
                'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
                'after_widget'  => '</div>',
            ) );
        }
    }

    if ( ! function_exists( 'hatt_sidebar_blog' ) ) {
        function hatt_sidebar_blog( $pos = 'no' ) {

			
            $pos = Hatt()->get_option( 'blog_sidebar_pos', 'no' );
		
            if ( is_single() ) {
                if ( $meta = get_post_meta( get_the_ID(), 'sidebar_pos', TRUE ) ) {
                    $pos = $meta;
                }
            }
            if ( isset( $_REQUEST['sidebar_pos'] ) ) {
                $pos = $_REQUEST['sidebar_pos'];
            }

            return $pos;
        }
    }
    if ( ! function_exists( 'hatt_blog_subtitle' ) ) {
        function hatt_blog_subtitle( $title ) {

            if ( $new_title = Hatt()->get_option( 'blog_subtitle' ) ) {
                $title = $new_title;
            }
            if ( is_singular() ) {
                if ( $meta = get_post_meta( get_the_ID(), 'page_subtitle', TRUE ) ) {
                    $title = $meta;
                } else {
                    $title = FALSE;
                }
            }
            if ( is_archive() ) {
                $title = '';
            }
            if ( is_404() ) {
                $title = __( 'Oops! That page can&rsquo;t be found.', HATT_TEXTDOMAIN );
            }
            if ( is_search() ) {
                $title = '';
            }

            return $title;
        }
    }
    if ( ! function_exists( 'hatt_blog_title' ) ) {
        function hatt_blog_title( $title ) {

            if ( $new_title = Hatt()->get_option( 'blog_title' ) ) {
                $title = $new_title;
            }
            if ( is_singular() ) {
                $title = get_the_title();
            }
            if ( is_archive() ) {
                $title = hatt_archive_title();
            }
            if ( is_404() ) {
                $title = __( '404 Not Found', HATT_TEXTDOMAIN );
            }
            if ( is_search() ) {
                $title = sprintf( __( 'Search Results for: %s', HATT_TEXTDOMAIN ), get_search_query() );
            }

            return $title;
        }
    }
    if ( ! function_exists( 'ht_page_banner' ) ) {
        function ht_page_banner() {

            $banner = Hatt()->get_option( 'blog_topimg' );
            if ( is_page() ) {
                if ( $banner_meta = get_post_meta( get_the_ID(), 'page_banner', TRUE ) ) {
                    $banner = $banner_meta;
                }
            }

            return $banner;
        }
    }
    if ( ! function_exists( 'the_breadcrumb' ) ) {
        function the_breadcrumb() {


            global $post;

            // Plain posts and pages: Home / Title. The About Us / Learn crumbs below need pages this site does not have.
            if (is_home() || (isset($post) && in_array($post->post_type, ['post', 'page'], true))) {
                echo '<div class="breadcrumb"><span><a href="' . esc_url(home_url()) . '">' . esc_html(get_bloginfo('name')) . '</a></span>';
                if (is_singular()) {
                    echo ' / <span>' . esc_html(get_the_title()) . '</span>';
                }
                echo '</div>';
                return;
            }

            // echo "ID:".$post->post_type . "<br/>";
            // echo "ID:".$post->ID . "<br/>";
            $postterms = isset($post) ? get_the_terms($post->ID, $post->post_type ?? '' .'_cat') : "";
            // print_r($postterms);
            if(is_array($postterms)){
                if(sizeof($postterms)>0){
                    $postcat=$postterms[0]->taxonomy;
                }else{
                    $postcat="";
                }
            }else{
                $postcat="";
            }
            // echo "postcat:".$postcat. "<br/>";

            $sep = ' / ';
            // $sep = '<li class="separator"> / </li>';
            echo "<!-- start breadcrumb  ";
            echo $post->post_type ?? "" ." ";
            echo $postcat." ";
            echo is_search()." ";
            echo $post->post_name ?? '' ." ";
            echo "-->";

            if(!is_search() && (($post && $post->post_type == "post") || ($postcat == "learn_cat")) ){   //for news/learn

                echo '<!-- :case 1 -->';
                echo '<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">';

                echo '<span typeof="v:Breadcrumb"><a rel="v:url" property:"v:title" href="'.home_url().'">'.get_bloginfo('name').'</a></span>' . $sep;
                    // if(is_search()){
                    //  echo '<li>Search results</li>';
                    // }

                        // echo "--".get_the_category_list()."--";

                        // the_category("++".$sep."++");
                    // if ( is_category() || is_single() ) {

                        // foreach((get_the_category()) as $category) {
                        //   echo $category->cat_name . ' + ';
                        // }
                    $siteurl=get_site_url();

                    if($post && $post->post_type == "post"){                         //news
                        $page = get_page_by_path('/about-us');
                        $title = get_the_title($page->ID);
                        echo '<span typeof="v:Breadcrumb"><a rel="v:url" property:"v:title" href="'.$siteurl.'/about-us">';
                        echo $title;
                        echo '</a></span>'.$sep;

                        $page = get_page_by_path('/about-us/news');
                        $title = get_the_title($page->ID);
                        echo '<span typeof="v:Breadcrumb"><a rel="v:url" property:"v:title" href="'.$siteurl.'/about-us/news">';
                        echo $title;
                        echo '</a></span>'.$sep;
                    }else{                                                          //learn
                        $path='/learn';
                        if (hatt()->get_option('learn_banner_title', FALSE)) {
                            $title = hatt()->get_option('learn_banner_title', FALSE);
                        } else {
                            $title = get_post_type_object($post_type['post_type']);
                            $title = ($title->labels->singular_name);
                        }


                        if(!is_archive()){
                            echo '<span typeof="v:Breadcrumb"><a rel="v:url" property:"v:title" href="'.$siteurl.$path.'">';
                            echo $title;
                            echo '</a></span>'.$sep;

                            $path='/learn/'.$postterms[0]->slug;
                            $title = $postterms[0]->name;
                            echo '<span typeof="v:Breadcrumb"><a rel="v:url" property:"v:title" href="'.$siteurl.$path.'">';
                            echo $title;
                            echo '</a></span>'.$sep;

                        }else{
                            // $path='/learn/'.$postterms[0]->slug;
                            // $title = $postterms[0]->name;
                            echo '<span typeof="v:Breadcrumb">';
                            echo $title;
                            echo '</a></span>';
                        }
                    }
                    if(!is_archive()){
                        echo '<span typeof="v:Breadcrumb">';
                        echo the_title();
                        echo '</span>';
                    }

                echo '</div>';
                //end .breadcrumb

                return;
            }else if(!is_search() && (isset($post->post_type) && $post->post_type == "learn")) {               // learn selection page, check is archive to remove learn-archive

                    echo '<!-- :case 2 -->';
                    echo '<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">';
                    echo '<span typeof="v:Breadcrumb"><a rel="v:url" property:"v:title" href="'.home_url().'">'.get_bloginfo('name').'</a></span>' . $sep;

                    $siteurl=get_site_url();

                    $path='/learn';
                    if (hatt()->get_option('learn_banner_title', FALSE)) {
                        $title = hatt()->get_option('learn_banner_title', FALSE);
                    } else {
                        $title = get_post_type_object($post_type['post_type']);
                        $title = ($title->labels->singular_name);
                    }
                    // $path='/learn/'.$postterms[0]->slug;
                    // $title = $postterms[0]->name;
                    // echo '<span typeof="v:Breadcrumb"><a rel="v:url" property:"v:title" href="'.$siteurl.$path.'">';
                    // echo $title;
                    // echo '</a></span>'.$sep;

                    if(  !is_archive() ) {

                        echo '<span typeof="v:Breadcrumb"><a rel="v:url" property:"v:title" href="'.$siteurl.$path.'">';
                        echo $title;
                        echo '</a></span>'.$sep;

                        echo '<span typeof="v:Breadcrumb">';
                        echo the_title();
                        echo '</span>';
                    }else{
                        echo '<span typeof="v:Breadcrumb">';
                        echo $title;
                        echo '</a></span>';
                    }
                    echo '</div>';

            }else if(($post && $post->post_type == "offer")) {               // offer page

                    echo '<!-- :case 3 -->';
                    echo '<!-- //offer -->';
                    echo '<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">';
                    echo '<span typeof="v:Breadcrumb"><a rel="v:url" property:"v:title" href="'.home_url().'">'.get_bloginfo('name').'</a></span>' . $sep;

                    $siteurl=get_site_url();

                    $path='/offers';

                    $title = _x("Offers", "breadcrumb",HATT_TEXTDOMAIN);

                    if(  !is_archive() ) {

                        echo '<span typeof="v:Breadcrumb"><a rel="v:url" property:"v:title" href="'.$siteurl.$path.'">';
                        echo $title;
                        echo '</a></span>'.$sep;

                        echo '<span typeof="v:Breadcrumb">';
                        echo the_title();
                        echo '</span>';
                    }else{
                        echo '<span typeof="v:Breadcrumb">';
                        echo $title;
                        echo '</a></span>';
                    }
                    echo '</div>';

            }else if(($post && $post->post_type == "store")) {               // single store page

                echo "<!-- start store:  ";
                echo $post->post_type." ";
                echo $postcat." ";
                echo "-->";
                echo '<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">';


                echo '<span typeof="v:Breadcrumb"><a rel="v:url" property:"v:title" href="'.home_url().'">'.get_bloginfo('name').'</a></span>' . $sep;
                $siteurl=get_site_url();


                if(  !is_archive() ) {
                    //1st level
                    $page = get_page_by_path('/store');
                    $title = get_the_title(isset($page->ID));
                    $title = __('STORE',HATT_TEXTDOMAIN);
                    echo '<span typeof="v:Breadcrumb"><a rel="v:url" property:"v:title" href="'.$siteurl.'/store">';
                    echo $title;
                    echo '</a></span>'.$sep;

                    //2nd level
                    // var_dump($postterms[0]);
                    // $path='/store?category='.$postterms[0]->term_id;
                    // $title = $postterms[0]->name;
                    // echo '<span typeof="v:Breadcrumb"><a rel="v:url" property:"v:title" href="'.$siteurl.$path.'">';
                    // echo $title;
                    // echo '</a></span>'.$sep;

                    //actual
                    echo '<span typeof="v:Breadcrumb">';
                    echo the_title();
                    echo '</span>';
                }else{
                    //1st level
                    $page = get_page_by_path('/store');
                    $title = get_the_title(isset($page->ID));
                    $title = __('STORE',HATT_TEXTDOMAIN);
                    echo '<span typeof="v:Breadcrumb">';
                    echo $title;
                    echo '</span>';
                }
                echo '</div>';
                //. end breadcrumb


            }else if(is_search() ) {

                echo '<!-- :search -->';

                echo '<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">';
                echo '<span typeof="v:Breadcrumb"><a rel="v:url" property:"v:title" href="'.home_url().'">'.get_bloginfo('name').'</a></span>' . $sep;
                $siteurl=get_site_url();
                // $page = get_page_by_path('/store');
                // $title = get_the_title($page->ID);
                // $title = __('STORE',HATT_TEXTDOMAIN);
                echo '<span typeof="v:Breadcrumb">';
                echo sprintf( __( 'Search Results for: %s', HATT_TEXTDOMAIN ), get_search_query() );
                echo '</span>';
                echo '</div>';


            }else if($post && $post->post_name == "rfq" ) {

                echo '<!-- :rfq -->';

                echo '<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">';
                echo '<span typeof="v:Breadcrumb"><a rel="v:url" property:"v:title" href="'.home_url().'">'.get_bloginfo('name').'</a></span>' . $sep;
                $siteurl=get_site_url();
                // $page = get_page_by_path('/store');
                // $title = get_the_title($page->ID);
                // $title = __('STORE',HATT_TEXTDOMAIN);
                echo '<span typeof="v:Breadcrumb">';
                echo __( 'REQUEST FOR QUOTE', HATT_TEXTDOMAIN );
                echo '</span>';
                echo '</div>';


            }else if(($post && $post->post_type == "tyres")) {               // single store page

                echo "<!-- start tyre:  ";
                echo $post->post_type." ";
                echo $postcat." ";
                echo "-->";
                echo '<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">';
                echo '<span typeof="v:Breadcrumb"><a rel="v:url" property:"v:title" href="'.home_url().'">'.get_bloginfo('name').'</a></span>' . $sep;
				echo '<span typeof="v:Breadcrumb"><a href="/filter-tyre">tyres</a></span>'. $sep;
				echo '<span typeof="v:Breadcrumb">' .get_the_title(isset($page->ID)). '</span>';
				echo '</div>'; 
				
			}else{ //default


                if ( function_exists( 'bcn_display' ) ) {

                    /**/
                    ?>
                    <!-- :default -->
                    <div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">
                        <?php
                            bcn_display(); ?>
                    </div>

                    <?php
                    return;
                }else {
					/* Temporary while breadcrumbs are disabled */
					?>
					<div class="breadcrumb invisible" xmlns:v="http://rdf.data-vocabulary.org/#">
						
					</div>
					<?php
				}
            }









        }
    }
    if ( ! function_exists( 'hatt_comments' ) ) {
        function hatt_comments( $comment, $args, $depth ) {

            echo Hatt()->load_template( 'comment_list', null, array(
                'comment' => $comment,
                'args'    => $args,
                'depth'   => $depth
            ) );
        }
    }
    if ( ! function_exists( 'hatt_paging' ) ) {
        function hatt_paging() {

            // Don't print empty markup if there's only one page.
            if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
                return;
            }
            $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
            $pagenum_link = html_entity_decode( get_pagenum_link() );
            $query_args   = array();
            $url_parts    = explode( '?', $pagenum_link );
            if ( isset( $url_parts[1] ) ) {
                wp_parse_str( $url_parts[1], $query_args );
            }
            $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
            $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';
            $format       = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
            $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';
            // Set up paginated links.
            $links = paginate_links( array(
                'base'      => $pagenum_link,
                'format'    => $format,
                'total'     => $GLOBALS['wp_query']->max_num_pages,
                'current'   => $paged,
                'mid_size'  => 1,
                // 'add_args' => array_map( 'urlencode', $query_args ),
                'add_args'  => $query_args,
                'prev_text' => __( 'Previous Page', HATT_TEXTDOMAIN ),
                'next_text' => __( 'Next Page', HATT_TEXTDOMAIN ),
                'type'      => 'list'
            ) );
            if ( $links ) :
                $links = str_replace( 'page-numbers', 'pagination', balanceTags( $links ) );
                $links = str_replace( '<span', '<a', $links );
                $links = str_replace( '</span>', '</a>', $links );
                ?>
                <?php echo str_replace( 'page-numbers', 'pagination', balanceTags( $links ) );//do not use esc_html() with  paginate_links() result
                ?>
            <?php
            endif;
        }
    }
    if ( ! function_exists( 'hatt_widget_area' ) ) {
        function hatt_widget_area( $old = FALSE ) {

            $sidebar = Hatt()->get_option( 'blog_sidebar_id' );
            if ( is_single() ) {
                if ( $meta = get_post_meta( get_the_ID(), 'sidebar_id', TRUE ) ) {
                    $sidebar = $meta;
                }
            }
            if ( $sidebar ) {
                return $sidebar;
            }

            return $old;
        }
    }
    if ( ! function_exists( 'hatt_get_sidebar_ids' ) ) {
        function hatt_get_sidebar_ids() {

            global $wp_registered_sidebars;
            $r   = array();
            $r[] = array(
                'label' => __( '--Select--', HATT_TEXTDOMAIN ),
                'value' => ''
            );
            if ( ! empty( $wp_registered_sidebars ) ) {
                foreach ( $wp_registered_sidebars as $key => $value ) {
                    $r[] = array(
                        'label' => $value['name'],
                        'value' => $value['id']
                    );
                }
            }

            return $r;
        }
    }
    if ( ! function_exists( 'ht_load_custom_css' ) ) {
        function ht_load_custom_css() {
            ?>
            <!--Custom css-->
            <style><?php echo Hatt()->load_template('custom_css')?></style>
        <?php
        }
    }

    if ( ! function_exists( 'ht_hide_admin_bar' ) ) {
        function ht_hide_admin_bar() {

        }
    }
    if ( ! function_exists( 'ht_banner_before_content_func' ) ) {
        function ht_banner_before_content_func() {

            get_template_part( 'banner_before_content' );
        }
    }

    if ( ! function_exists( 'ht_api_stores_func' ) ) {
        function ht_api_stores_func() {

            $data = array();
            $category_array  = array();
            $argv = array(
                'post_type' => 'store',
                'paged'     => get_query_var( 'paged' ),
            );

            if ( isset( $_POST['category'] ) and ! empty( $_POST['category'] ) ) {
                $category           = $_POST['category'];
                $arg['tax_query'][] = array(
                    'taxonomy' => 'store_cat',
                    'terms'    => array( $category )
                );
            }

            if ( isset( $_POST['tyre_id'] ) and ! empty( $_POST['tyre_id'] ) ) {
                $tyre_id         = $_POST['tyre_id'];
                $list_store      = get_post_meta( $tyre_id, 'ht_tyre_store_select', TRUE );
                $arg['post__in'] = $list_store;
            }

            $query = new WP_Query( $arg );
            if ( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                    $query->the_post();

                    $terms = wp_get_post_terms( get_the_ID(), 'store_cat' );
                    if ( ! is_wp_error( $terms ) ) {
                        foreach ( $terms as $key => $val ) {
                            $category_array[$key]['id']= $val->term_id;
                            $category_array[$key]['name']= $val->name;
                            $category_array[$key]['url']= get_term_link( $val->term_id, 'store_cat' );
                            $img = get_tax_meta( $val->term_id, 'store_cat_image' );
                            if($img){
                                $category_array[$key]['image']= $img['url'];
                            }
                        }
                    }

                    $data[] = array(
                        'store_id'      => get_the_ID(),
                        'store_name'    => get_the_title(),
                        'store_content' => get_the_content(),
                        'store_address' => get_post_meta( get_the_ID(), 'ht_store_address', TRUE ),
                        'store_email'   => get_post_meta( get_the_ID(), 'ht_store_email', TRUE ),
                        'store_phone'   => get_post_meta( get_the_ID(), 'ht_store_phone', TRUE ),
                        'store_category'=>$category_array
                    );
                }

                echo json_encode(array('status'=>1,'data'=>$data));
                die;
                wp_reset_query();
            }else{
                echo json_encode(array('status'=>0,'message'=>'No data'));
                die;
            }
        }
    }

    function register_session() {
          //session_start();
    }


    /*
    add_filter( 'posts_where', 'title_like_posts_where', 10, 2 );
    function title_like_posts_where( $where, &$wp_query ) {
         global $wpdb;
         if ( $post_title_like = $wp_query->get( 'post_title_like' ) ) {
              $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'' . esc_sql( $wpdb->esc_like( $post_title_like ) ) . '%\'';
         }
         return $where;
    }*/
    add_filter( 'posts_where', 'address_like_posts_where', 10, 2 );
    function address_like_posts_where( $where, $wp_query ) {
         global $wpdb;
         if ( $post_title_address_like = $wp_query->get( 'post_title_address_like' ) ) {
              // $where .= ' OR ' . $wpdb->posts . '.post_title LIKE \'' . esc_sql( $wpdb->esc_like( $post_address_like ) ) . '%\'';
              // $where .= " AND ((hatt_posts.post_title LIKE '".$post_address_like."') OR (mt1.meta_key = 'ht_store_address' AND mt1.meta_value LIKE '%".$post_address_like."%')";

              // $where .= " AND ( mt1.meta_key = 'ht_store_address' AND mt1.meta_value LIKE '%".$post_address_like."%') OR (hatt_posts.post_title LIKE '%".$post_address_like."%') )";
              $where .= " AND (( mt1.meta_key = 'ht_store_address' AND mt1.meta_value LIKE '%".$post_title_address_like."%') OR (hatt_posts.post_title LIKE '%".$post_title_address_like."%') )";
              // $where .= " AND (hatt_posts.post_title LIKE '%".$post_address_like."%')";
              // $where .= " AND (mt1.meta_key = 'ht_store_address' AND mt1.meta_value LIKE '%".$post_address_like."%')";

                // print_r($where);
              // $where .= " OR meta_key = 'ht_store_address' meta_value LIKE '%".$post_address_like."%')";
         }
         return $where;
    }
    function search_distinct() {
         return "DISTINCT";
    }

     function rc_filter_where( $where ) {

          $lat = isset($_GET['lat'])?$_GET['lat']:"0";
          $lon = isset($_GET['lon'])?$_GET['lon']:"0";
          $where .= " AND ( mt1.meta_key = 'ht_store_map_lat' AND mt2.meta_key = 'ht_store_map_long')
                AND (ACOS(SIN(PI()* mt1.meta_value /180.0)*SIN(PI()* " . $lat . " /180.0)+COS(PI()* mt1.meta_value /180.0)*COS(PI()* " . $lat . " /180.0)*COS(PI()* " . $lon . " /180.0-PI()* mt2.meta_value / 180.0))*6371) < " . $_GET['resultwithin'];

          return $where;
     }

     function rc_filter_join1( $join ) {

          $join .= " INNER JOIN hatt_postmeta AS mt1 ON ( hatt_posts.ID = mt1.post_id ) ";
          return $join;
     }

     function rc_filter_join2( $join ) {

          $join .= " INNER JOIN hatt_postmeta AS mt2 ON ( hatt_posts.ID = mt2.post_id ) ";
          return $join;
     }
     function ht_setcookie (){
          if(isset($_GET['tyre_id']) and !empty($_GET['tyre_id'])){
		setcookie('last_tyre',$_GET['tyre_id'], ['expires' => time() + (86400 * 30),'path' => "/", 'domain' => $_SERVER['HTTP_HOST'],'httponly' => true, 'secure' => true,'SameSite' => 'Strict']);                
          }
     }

    function inno_tyre_by_vehicle(){
        check_ajax_referer('inno-tyrenonce','security', false);

        if ( ! empty( $_POST ) ) {
            echo hatt()->load_template('tyres/find/ajax', 'vehicle');
        }
        exit;
    }

    function inno_tyre_by_size(){
        check_ajax_referer('inno-tyrenonce','security');

        if ( ! empty( $_POST ) ) {
            echo hatt()->load_template('tyres/find/ajax', 'size');
        }
        exit;
    }

    function rfq_inno_tyre_by_vehicle(){
        check_ajax_referer('inno-tyrenonce','security');

        if ( ! empty( $_POST ) ) {
            echo hatt()->load_template('tyres/rfq/ajax', 'vehicle');
        }
        exit;
    }

    function rfq_inno_tyre_by_size(){
        check_ajax_referer('inno-tyrenonce','security');

        if ( ! empty( $_POST ) ) {
            echo hatt()->load_template('tyres/rfq/ajax', 'size');
        }
        exit;
    }



// function proto_admin_ajax( $url, $path ) {
//     if ( $path == 'admin-ajax.php' && is_ssl() == FALSE ) {
//         return str_replace( 'https:', 'http:', $url );
//     }
//     return $url;
// }
// add_filter( 'admin_url', 'proto_admin_ajax', 20, 2 );

function ewp_remove_script_version( $src ) {
  return remove_query_arg( 'ver', $src );
}

add_filter( 'script_loader_src', 'ewp_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'ewp_remove_script_version', 15, 1 );
/***************** DTC ********************/

    function customSort($a, $b){
        if(is_numeric($a) && !is_numeric($b))
            return 1;
        else if(!is_numeric($a) && is_numeric($b))
            return -1;
        else
            return ($a < $b) ? -1 : 1;
    }

    function dtc_get_vehicle_child(){
        check_ajax_referer('inno-tyrenonce','security', false);


        list($term_id,$term_name) = explode("|", $_POST['selected_option']);

        $next_options =  get_terms( 'vehicles_cat', 'orderby=name&hide_empty=0&parent='.$term_id );
        $dropdown_options = "";

        // Convert object into array list

        if( $_POST['option_order'] == 1 ){
            foreach ($next_options as $option) {
                $yearToArray[$option->term_id] = $option->name;
            }

            usort ( $yearToArray , 'customSort' );
            foreach ($yearToArray as $key => $year) {
                $dropdown_options .= "<option value='{$key}|{$year}'>{$year}</option>";
            }
        } else {
            foreach ($next_options as $option) {
                $dropdown_options .= "<option value='{$option->term_id}|{$option->name}'>{$option->name}</option>";
            }
        }

        $data = [];
        $data['html'] = $dropdown_options;
        $data['append_to'] = $_POST['option_order'] + 1;
        $data['total_options'] = $_POST['total_options'];

        echo json_encode($data);
        exit;
    }

    function dtc_get_retailers(){
        check_ajax_referer('inno-tyrenonce','security', false);
        // echo json_encode(['post_data' => $_POST]);

        $args = array(
        'post_type'     => 'store',
        'post_status'   => 'publish',
    'orderby'       => 'title',
    'tax_query' => array(
        array(
            'taxonomy' => 'store_visib',
            'field'    => 'slug',
            'terms'    =>  'DTC',
        ),
    ),
        'posts_per_page'=>  -1,
        'meta_query' => array(
            array(
                'key' => 'ht_store_area',
                'value' => $_POST['area']
            ),
            array(
                'key' => 'ht_store_state',
                'value' => $_POST['province']
            )
        )
    );

    $getPosts = new WP_Query($args);

        // The Loop
        if ( $getPosts->have_posts() ) {
            while ( $getPosts->have_posts() ) {
                $getPosts->the_post();
                $stores[] = get_the_title();
            }
        } else {
            // no posts found
        }
        /* Restore original Post Data */
        wp_reset_postdata();


        // $myquery = new WP_Query( "post_type=stores&meta_key=player_team&meta_value=$teamname&order=ASC" );
        echo json_encode($stores ?? "");
        exit;
    }

      // QR CODE 
     function dtc_get_store_area_state(){
        check_ajax_referer('inno-tyrenonce','security', false);
        $args = array(
        'name'      => $_POST['store_slug'],
            'post_type'     => 'store',
            'post_status'   => 'publish',
        'orderby'       => 'title',
        'tax_query' => array(
            array(
                'taxonomy' => 'store_visib',
                'field'    => 'slug',
                'terms'    =>  'DTC',
            ),
        )
    );

    $getPosts = new WP_Query($args);

        // The Loop
        if ( $getPosts->have_posts() ) {
            while ( $getPosts->have_posts() ) {
                $getPosts->the_post();
                $data['area'] = get_post_meta( get_the_ID() , 'ht_store_area', TRUE);
                $data['state'] = get_post_meta( get_the_ID() , 'ht_store_state', TRUE);
                $data['store'] = get_the_title();
            }
        } else {
            // no posts found
        }
        /* Restore original Post Data */
        wp_reset_postdata();

        echo json_encode($data);
        exit;
    } 


    function dtc_submit(){

        check_ajax_referer('inno-tyrenonce','security', false);
        $rawDateInput = wp_unslash($_POST['date_of_purchase'] ?? '');
        $dateInput = is_string($rawDateInput) ? sanitize_text_field($rawDateInput) : '';
        $purchaseDate = DateTimeImmutable::createFromFormat('!m/d/Y', $dateInput, new DateTimeZone('Asia/Manila'));
        $dateErrors = DateTimeImmutable::getLastErrors();
        if (! $purchaseDate || ($dateErrors !== false && ($dateErrors['warning_count'] > 0 || $dateErrors['error_count'] > 0))) {
            wp_send_json_error(['message' => 'Please enter a valid purchase date.', 'code' => 4], 422);
        }
        $new_date = $purchaseDate->format('Y-m-d');
        $wfaLocale = dtc_wfa_market_locale();

        //$birthdateInput = explode('/',$_POST['birthdate']);
        //$birthdate_new_date = $birthdateInput[2].'-'.$birthdateInput[0].'-'.$birthdateInput[1];

        global $wpdb;

        /* ALLOW SAME VEHICLE/PLATE NO AND DATE PURCHASE */
        /*
        $url = dtc_theme_api_url('checkExistingRecord');
        $response = wp_remote_post( $url, array(
            'method' => 'POST',
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'body' => ['vehicle_reg_id' => $_POST['vehicle_reg_id'], 'qty' => $_POST['qty'], 'date_of_purchase' => $new_date, 'locale' => SITE_LOCALE ],
            'cookies' => array()
            )
        );


        if ( is_wp_error( $response ) ) {
           $error_message = $response->get_error_message();
           echo "Something went wrong: $error_message";
           exit;
        } else {
           $duplicate = json_decode( $response['body'] );

        }

        if( $duplicate->data ){
            echo 1; // Return record already exists
            exit;
        }
        */
		
        // Verify independently on submit; the live-validation AJAX handler returns JSON and must not terminate this request.
        $dtc_code_status = dtc_lookup_code_status(sanitize_text_field(wp_unslash($_POST['dtc_card_no'] ?? '')));
        if (is_wp_error($dtc_code_status)) {
            write_log('DTC CODE VERIFICATION ERROR', $dtc_code_status->get_error_message());
            wp_send_json_error([
                'message' => 'We could not verify your DTC Code. Please try again.',
                'code' => 7,
            ], 502);
        }

        if ($dtc_code_status === 'valid') {

            // Set up product mode/tyre details

            $rof = false;
            if (strpos($_POST['product_model'], "R") !== false) {
                $rof = true;
                $product_model = get_post(str_replace("R", "", $_POST['product_model']));
            } else {
                $product_model = get_post($_POST['product_model']);
            }

            $_POST['description'] = $product_model->post_excerpt;
            $tyre_url  =  site_url($product_model->post_type.'/'.sanitize_title($product_model->post_name),'http');
			
			$find_retailer_val = isset( $_POST['find_retailer'] ) ? sanitize_text_field( $_POST['find_retailer'] ) : '';

			if ( ! empty( $find_retailer_val ) && $find_retailer_val !== 'OTHERS' ) {
				$retailer_name = $find_retailer_val;
			} elseif ( ! empty( $_POST['others_dealer'] ) ) {
				$retailer_name = sanitize_text_field( $_POST['others_dealer'] );
			} elseif ( ! empty( $_POST['others_store'] ) ) {
				$retailer_name = sanitize_text_field( $_POST['others_store'] );
			} else {
				wp_send_json_error( [ 'message' => 'Please select or enter a store name.', 'code' => 4 ] );
				wp_die();
			}

            $store = get_page_by_title( $_POST['find_retailer'], OBJECT , 'store' );
            $autocare_translations = ['Autocare'];

            $under_autocare = array();
            if( $store ){
                $store_category = get_post_meta( $store->ID , 'ht_store_cat' );
                $under_autocare = array_intersect($store_category, $autocare_translations );
            }

            $store_page = get_page_by_title( 'store' );
			$store_query = '';
			if(isset($under_autocare[0])){
				$store_query = 'store?state='.$_POST['province'].'&area='.$_POST['area'].'&category='. $under_autocare[0];
			}else {
				$store_query = 'store?state='.$_POST['province'].'&area='.$_POST['area'];
			}
            $store_url = site_url($store_query);
		
            $dtc_fields = [
                'retailer' => $_POST['find_retailer'],
                'qty' => $_POST['qty'],
                'product_model' => $product_model->ID,
                'dtc_tyres' => $_POST['dtc_tyres']
            ];

            $is_dtc = is_dtc($dtc_fields);
            $promoSettings = dtc_efuel_promo_settings();
            $rawPromoProvince = wp_unslash($_POST['province'] ?? '');
            $rawPromoRetailer = wp_unslash($_POST['find_retailer'] ?? '');
            $promoProvince = is_string($rawPromoProvince) ? sanitize_text_field($rawPromoProvince) : '';
            $promoRetailer = is_string($rawPromoRetailer) ? sanitize_text_field($rawPromoRetailer) : '';
            $promoStoreMap = dtc_store_register_map();
            $isParticipatingStore = in_array($promoRetailer, $promoStoreMap[$promoProvince] ?? [], true);
            $selectedStore = get_page_by_title($promoRetailer, OBJECT, 'stores');
            $wfaArea = $selectedStore
                ? sanitize_text_field((string) get_field('city', $selectedStore->ID))
                : '';
            if ($wfaArea === '') {
                $wfaArea = $promoProvince;
            }
            $rawPromoQuantity = wp_unslash($_POST['qty'] ?? 0);
            $rawPromoRim = wp_unslash($_POST['diameter'] ?? 0);
            $promoQuantity = is_scalar($rawPromoQuantity) ? absint($rawPromoQuantity) : 0;
            $promoRim = is_scalar($rawPromoRim) ? absint($rawPromoRim) : 0;
            $promoCampaign = dtc_registration_promo_campaign($purchaseDate->format('Y-m-d'));
            $validPromo = $promoCampaign !== null
                && $promoQuantity === $promoSettings['required_quantity']
                && $promoRim >= $promoSettings['minimum_rim']
                && $isParticipatingStore
                && $promoRetailer !== 'OTHERS'
                && $promoRetailer !== 'employee_purchase';
            $promoInput = isset($_POST['promo']) && is_array($_POST['promo'])
                ? wp_unslash($_POST['promo'])
                : [];
            $rawAssistedPerson = $promoInput['assisted_person'] ?? '';
            $assistedPerson = is_string($rawAssistedPerson) ? sanitize_text_field($rawAssistedPerson) : '';
            $promoConfirmed = is_scalar($promoInput['confirm'] ?? null) && (string) $promoInput['confirm'] === '1';
            $promoTermsAccepted = is_scalar($promoInput['terms'] ?? null) && (string) $promoInput['terms'] === '1';

            if ($validPromo && (! $assistedPerson || ! $promoConfirmed || ! $promoTermsAccepted)) {
                wp_send_json_error([
                    'message' => 'Complete the eFuel promotion confirmation before submitting.',
                    'code' => 4,
                ], 422);
            }

            $filetoUpload = '';
            $invoiceMime = '';
            $invoiceExtension = '';
            $invoice = $_FILES['invoice'] ?? null;
            $invoiceError = $invoice ? (int) ($invoice['error'] ?? UPLOAD_ERR_NO_FILE) : UPLOAD_ERR_NO_FILE;
            if ($validPromo && $invoiceError === UPLOAD_ERR_NO_FILE) {
                wp_send_json_error([
                    'message' => 'Please upload your sales invoice or receipt for the eFuel promotion.',
                    'code' => 4,
                ], 422);
            }
            if ($invoiceError !== UPLOAD_ERR_NO_FILE) {
                if ($invoiceError !== UPLOAD_ERR_OK || empty($invoice['tmp_name']) || ! is_uploaded_file($invoice['tmp_name'])) {
                    wp_send_json_error(['message' => 'There was a problem uploading your sales invoice or receipt.', 'code' => 4], 422);
                }
                if ((int) ($invoice['size'] ?? 0) > 5 * 1024 * 1024) {
                    wp_send_json_error(['message' => 'The sales invoice or receipt must be 5 MB or smaller.', 'code' => 4], 422);
                }

                $invoiceExtension = strtolower(pathinfo((string) ($invoice['name'] ?? ''), PATHINFO_EXTENSION));
                $allowedInvoiceTypes = [
                    'jpg' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'png' => 'image/png',
                    'pdf' => 'application/pdf',
                ];
                $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
                if (! $fileInfo) {
                    wp_send_json_error(['message' => 'Invoice upload validation is temporarily unavailable.', 'code' => 7], 500);
                }
                $invoiceMime = finfo_file($fileInfo, $invoice['tmp_name']);
                finfo_close($fileInfo);
                if (! isset($allowedInvoiceTypes[$invoiceExtension]) || $allowedInvoiceTypes[$invoiceExtension] !== $invoiceMime) {
                    wp_send_json_error(['message' => 'Upload your invoice as a JPG, PNG, or PDF file.', 'code' => 4], 422);
                }
                $filetoUpload = $invoice['tmp_name'];
            }

            if ($rof) {
                $tire_mode = $product_model->post_title.' (ROF) ';
            } else {
                $tire_mode = $product_model->post_title;
            }

            //'address'         => trim($_POST['address_line1']).' '. trim($_POST['address_line2']).' '.trim($_POST[addr_area]).','.trim($_POST['addr_province']).' '.trim($_POST['postal_code']),
			$other_dealer = isset($_POST['others_dealer']) ? $_POST['others_dealer'] : '';
            if($other_dealer != '') {
                $other_store = $other_dealer;
            } else if(isset($_POST['others_store']) && $_POST['others_store'] != null) {
                $other_store = $_POST['others_store'];
            } else {
                $other_store = '';
            }

            $record = [
                'first_name'        => $_POST['first_name'],
                'last_name'         => $_POST['last_name'],
                'email'             => ($_POST['email'] != null) ? $_POST['email'] : '',
                'phone_no'          => $_POST['phone_no'],
                'contact_no'        => $_POST['phone_no'],
                // 'brand'             => $_POST['brand'],
                // 'model'             => $_POST['model'],
                'vehicle_reg_id'    => $_POST['vehicle_reg_id'],
                'survey_form'       => 'DTC website registration',
                // 'vehicle'           => $_POST['vehicle'],
                'description'       => $_POST['description'],
                'tyre_url'          => $tyre_url,
                'product_id'        => (int) $product_model->ID,
                'product_image'     => dtc_tyre_image_url((int) $product_model->ID, 'large'),
                'store_url'         => $store_url,
                'qty'               => $_POST['qty'],
                'quantity'          => $_POST['qty'],
                'tyre'              => $tire_mode,
                'date_of_purchase'  => $new_date,
                'province'          => $_POST['province'],
                'state'             => $_POST['province'],
                'area'              => $wfaArea,
                'locale'            => $wfaLocale,
                'tnc'               => $_POST['tnc'],
                'find_retailer'     => ($_POST['find_retailer'] != null) ? $_POST['find_retailer'] : 'Other',  
                'subscribe'         => ($_POST['subscribe'] != null) ? 1 : 0,
                // 'is_dtc'            => ($is_dtc) ? 1 : 0,
                'is_dtc'            => 1,
                'dtc_store'         => ( isset($under_autocare[0]) && $under_autocare[0] ) ? 1 :  0,
                'is_wfa'            => 1,
                'wfa_store'         => ( isset($under_autocare[0]) && $under_autocare[0] ) ? 1 :  0,
                'product_year'      => '',
                'birthdate'         => '0000-00-00',
                // 'birthdate'          => $birthdate_new_date,
                // 'dtc_card_no'    => ($is_dtc) ? $_POST['dtc_card_no'] : '',
		'dtc_card_no'       => $_POST['dtc_card_no'],
		'wfa_card_no'       => $_POST['dtc_card_no'],
                'area_other'        => $_POST['others_area'],
                'store_name_other'      => $other_store,
                'receipt'           => $_POST['receipt'],
                'validpromo'        => $validPromo ? 1 : 0,
                //'nric_no'           => $_POST['nric_no'],
                // 'address'           => trim($_POST[addr_area]).','.trim($_POST['addr_province']).' '.trim($_POST['postal_code']),
                'raya_reason'       => trim(isset($_POST['raya_reason']) ? $_POST['raya_reason'] : ''),
                'is_raya_promo'     => (isset($_POST['is_raya_promo']) && $_POST['is_raya_promo'] != null) ? 1 : 0,
                // 'tyre_size'         => trim($_POST['width']).'/'.trim($_POST['ratio']),
                'tyre_size'         => isset($_POST['tyre_size']) ? sanitize_text_field($_POST['tyre_size']) : '',
                'brand'             => isset($_POST['brand']) ? sanitize_text_field($_POST['brand']) : '',
                'model'             => isset($_POST['model']) ? sanitize_text_field($_POST['model']) : '',
                'mileage'           => isset($_POST['mileage']) ? sanitize_text_field($_POST['mileage']) : '',
                'rim_size'          => sprintf('R%s', $_POST['diameter']),

            ];

            if ($validPromo) {
                $record['promo[promo]'] = $promoCampaign['name'];
                $record['promo[assisted_person]'] = $assistedPerson;
                $record['promo[confirm]'] = 'Yes';
                $record['promo[terms]'] = 'Yes';
            }
			
			$url_latest_created_date = dtc_theme_api_url('fetchPlateNumLatestEntryToday');
				$response_latest_created_date = wp_remote_post(
					$url_latest_created_date,
					array(
						'method' => 'POST',
						'timeout' => 45,
						'redirection' => 5,
						'httpversion' => '1.0',
						'blocking' => true,
						'headers' => array(),
						'body' => ['vehicle_reg_id' => $_POST['vehicle_reg_id'],
							'locale' => $wfaLocale],
						'cookies' => array()
					)
				);
                if (is_wp_error($response_latest_created_date)) {
                    write_log('WFA DUPLICATE CHECK ERROR', $response_latest_created_date->get_error_message());
                    wp_send_json_error(['message' => 'We could not verify your registration with WFA. Please try again.', 'code' => 7], 502);
                }
                $latestResponseBody = json_decode(wp_remote_retrieve_body($response_latest_created_date), true);
                if (wp_remote_retrieve_response_code($response_latest_created_date) !== 200 || ! is_array($latestResponseBody) || ! array_key_exists('data', $latestResponseBody)) {
                    write_log('WFA DUPLICATE CHECK ERROR', ['status' => wp_remote_retrieve_response_code($response_latest_created_date)]);
                    wp_send_json_error(['message' => 'WFA could not verify your registration. Please try again later.', 'code' => 7], 502);
                }

                $plate_number = sanitize_text_field(wp_unslash($_POST['vehicle_reg_id'] ?? ''));
                if (! empty($latestResponseBody['data'])) {
                    wp_send_json_error(['message' => 'This plate number already has a registration today.', 'code' => 3], 409);
                }
				
				// DTC Code generation
				$url_count_purchase_date = dtc_theme_api_url('countAllPurchaseDates');
				$response_count_purchase_date = wp_remote_post(
					$url_count_purchase_date,
					array(
						'method' => 'POST',
						'timeout' => 45,
						'redirection' => 5,
						'httpversion' => '1.0',
						'blocking' => true,
						'headers' => array(),
						'body' => ['vehicle_reg_id' => $_POST['vehicle_reg_id'],
							'date_of_purchase' => $new_date,
							'locale' => $wfaLocale],
						'cookies' => array()
					)
				);
                if (is_wp_error($response_count_purchase_date)) {
                    write_log('WFA PURCHASE COUNT ERROR', $response_count_purchase_date->get_error_message());
                    wp_send_json_error(['message' => 'We could not prepare your WFA registration. Please try again.', 'code' => 7], 502);
                }
                $purchaseCountResponse = json_decode(wp_remote_retrieve_body($response_count_purchase_date), true);
                if (wp_remote_retrieve_response_code($response_count_purchase_date) !== 200 || ! is_array($purchaseCountResponse) || ! is_numeric($purchaseCountResponse['data'] ?? null)) {
                    write_log('WFA PURCHASE COUNT ERROR', ['status' => wp_remote_retrieve_response_code($response_count_purchase_date)]);
                    wp_send_json_error(['message' => 'WFA could not prepare your registration. Please try again later.', 'code' => 7], 502);
                }
				$total_purchases = (int) $purchaseCountResponse['data'];
				write_log("total_purchases", $total_purchases);
				
				$sequence_number = $total_purchases + 1;
				$dtc_date = (new DateTime($new_date))->format('ym');
				$padded_plate_number = str_pad($plate_number,14,"X");
				$dtc_code = "$dtc_date$padded_plate_number$sequence_number";
				if ($record['dtc_card_no'] === '') {
					$record["dtc_card_no"] = $dtc_code;
				}
                $record['wfa_card_no'] = $record['dtc_card_no'];
				write_log("dtc_code record", $record["dtc_card_no"]);
                $blobName = $filetoUpload ? sanitize_file_name(strtoupper($record['dtc_card_no']).'.'.$invoiceExtension) : '';

            /* start of  wp_remote_post using multipart/formdata */
            $url = dtc_theme_api_url('register');

			$boundary = wp_generate_password(24);
			$headers  = array(
				'content-type' => 'multipart/form-data; boundary=' . $boundary,
			);
			$payload = '';


			// First, add the standard POST fields:
			foreach ($record as $name => $value) {
				$payload .= '--' . $boundary;
				$payload .= "\r\n";
				$payload .= 'Content-Disposition: form-data; name="' . $name .
					'"' . "\r\n\r\n";
				$payload .= $value;
				$payload .= "\r\n";
			}

			// Upload the invoice file
			if ($filetoUpload) {
                $invoiceContents = file_get_contents($filetoUpload);
                if ($invoiceContents === false) {
                    wp_send_json_error(['message' => 'We could not read the uploaded invoice. Please try again.', 'code' => 4], 422);
                }
				$payload .= '--' . $boundary;
				$payload .= "\r\n";
				$payload .= 'Content-Disposition: form-data; name="' . 'invoice' .
					'"; filename="' . $blobName . '"' . "\r\n";
                $payload .= 'Content-Type: ' . $invoiceMime . "\r\n";
				$payload .= "\r\n";
				$payload .= $invoiceContents;
				$payload .= "\r\n";
			}

			$payload .= '--' . $boundary . '--';
			$response = wp_remote_post(
				$url,
				array(
					'method' => 'POST',
					'timeout' => 60,
					'redirection' => 5,
					'httpversion' => '1.0',
					'blocking' => true,
					'headers' => $headers,
					'body' => $payload,
					'cookies' => array()
				)
			);
			/* end of  wp_remote_post using multipart/formdata */

            if ( is_wp_error($response) ) {
                write_log("REGISTRATION API CONNECTION ERROR", $response->get_error_message());
                wp_send_json_error([
                    'message' => 'We could not reach the registration service. Please try again in a moment.',
                    'code' => 7,
                ], 502);
            }

            $response_code = wp_remote_retrieve_response_code($response);
            $save_response = json_decode(wp_remote_retrieve_body($response));

            if ( $response_code == 422 && ! empty($save_response->message) ) {
                $messages = [];
                foreach ((array) $save_response->message as $field_errors) {
                    foreach ((array) $field_errors as $message) {
                        $messages[] = $message;
                    }
                }
                wp_send_json_error(['message' => implode(' ', $messages), 'code' => 5], 422);
            }

            if ( ! in_array($response_code, [200, 201], true) || ! is_object($save_response) || ($save_response->status ?? null) !== 'success' ) {
                write_log("REGISTRATION API ERROR", [
                    'status' => $response_code,
                    'response' => wp_remote_retrieve_body($response),
                ]);
                wp_send_json_error([
                    'message' => 'We could not complete your registration. Please check your details and try again.',
                    'code' => 7,
                ], 502);
            }

            // Contacts are stored by the Laravel API; no third-party mailing list is called from WordPress.
            wp_send_json(['html' => hatt()->load_template('dtc/thankyou', null, $record)]);
        }
        else {
			write_log("DTC NOT VALID", ['status' => $dtc_code_status]);
            $message = $dtc_code_status === 'used'
                ? 'This DTC Code has already been used.'
                : 'DTC Code not found. Please check and enter a valid code.';
            wp_send_json_error(['message' => $message, 'code' => 6], 422);
        }
    }

    // For DTC, condition must be:
    // - Quantity should be more than 2 tyres
    // - Tyre should be equal in any of 8 feature tyres
    function is_dtc($data){
		//check if store is an autocare
		$store = get_page_by_title( $data['retailer'], OBJECT , 'store' );
		$autocare_translations = ['Autocare'];
		// $autocare_translations = ['ตัวแทนจำหน่ายกู๊ดเยียร์'];
	
		$under_autocare = array(); // safe default
		if ( $store && isset( $store->ID ) ) {
			$store_category = get_post_meta( $store->ID , 'ht_store_cat' );
			if ( is_array( $store_category ) ) {
				$under_autocare = array_intersect($store_category, $autocare_translations );
			}
		}
	
		// Validate if the selected retailer is an autocare
		( count($under_autocare) > 0 ) ? $is_autocare = true :  $is_autocare = false;
		$dtc_tyres = explode(',', $data['dtc_tyres']);
		if( $data['qty'] >= 1 && in_array($data['product_model'], $dtc_tyres)){
			return true;
		} else {
			return false;
		}
	}

    // For DTC, condition must be:
    // - Quantity should be more than 4 tyres
    // - Tyre should be bought from Autocare store
    // - Tyre should be equal in any of 5 feature tyres
    function is_dtc_api(){

        check_ajax_referer('inno-tyrenonce','security', false);

        $dtc_tyres = explode(',', $_POST['dtc_tyres']);

        if( $_POST['qty'] >= 2 && in_array($_POST['selected_tyre'], $dtc_tyres)){
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }

        wp_die();
    }

    // Function that will extract the description of certain tyre
    function getTyrePostExerpt($tyre){
        global $wpdb;
        $results = $wpdb->get_results( 'SELECT post_excerpt FROM hatt_posts WHERE post_title = "'.$tyre.'" LIMIT 1' );

        return $results[0]->post_excerpt;
    }

    function addContact($data) {
        $url = 'https://api.sendgrid.com/v3/contactdb/recipients';
		$default = [
			'first_name' => '',
			'last_name' => '',
			'email' => '',
			'phone_no' => '',
			'brand' => '',
			'model' => '',
			'product_year' => '',
			'vehicle_reg_id' => '',
			'product_model' => '',
			'qty' => 0,
			'date_of_purchase' => '',
			'province' => '',
			'area' => '',
			'retailer' => '',
			'is_subscribe' => 0,
			'store_name_other' => '',
		];
		$mergedData = array_merge($default, $data);
        $json = [
                    [
                        // Personal Info
                        "first_name"        => $mergedData['first_name'],
                        "last_name"         => $mergedData['last_name'],
                        "email"             => $mergedData['email'],
                        "phone_no"          => $mergedData['phone_no'],
                        // About your vehicle
                        "brand"             => $mergedData['brand'],
                        "model"             => $mergedData['model'],
                        "year"              => $mergedData['product_year'],
                        "vehicle_reg_id"    => $mergedData['vehicle_reg_id'],
                        // About your tyres
                        "tyre"              => $mergedData['product_model'],
                        "qty"               => $mergedData['qty'],
                        "date_of_purchase"  => $mergedData['date_of_purchase'],
                        // Store Details
                        "province"          => $mergedData['province'],
                        "area"              => $mergedData['area'],
                        "retailer"          => $mergedData['retailer'],
                        // "tyre_permalink" => $data['tyre_permalink'],
                        //"store_permalink" => $data['store_permalink'],
                        "is_subscribe"      => $mergedData['is_subscribe'],
                        "store_name_other"  => $mergedData['store_name_other']
                    ]
                ];

        // Add subscriber
        executeCurl($url, $json, 'POST', 'add');
    }

    function sendEmail($data){
        $url = 'https://api.sendgrid.com/api/mail.send.json';

        $json = [
                    "api_user"      => "rexestremera",
                    "api_key"       => "rex12345",
                    "to"            => $data['email'],
                    "toname"        => $data['first_name'],
                    "subject"       => "ขอบคุณสำหรับการลงทะเบียนโปรแกรม Worry Free ขับขี่ปลอดภัย", //"Thank you for registering with David Tyre Company!",
                    "html"          => hatt()->load_template('dtc/edm-thankyou',null,$data),
                    "from"          => "no-reply@dtc.local",
                    "fromname"      => "DTC Thailand",
                ];

        executeCurl($url, $json, 'POST', 'send');
    }

    function executeCurl($url, $data, $method, $type){

        $ch = curl_init($url);

        if($type != 'send'){
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Authorization: Basic cmV4ZXN0cmVtZXJhOnJleDEyMzQ1']);
            $data = json_encode($data);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);
    }


    function dtc_import_get_tyres(){

        global $post;

        $dtc_vc_component = get_posts(array('name' => 'register-your-tyres', 'post_type' => 'page','post_status' => 'publish'));
        $dtc_vc_content = $dtc_vc_component[0]->post_content;

        preg_match('/ht_tyres_category=\"([0-9].*)\" ht_dtc_tyres/', $dtc_vc_content, $tyres_category);
        preg_match('/ht_dtc_tyres="([0-9].*)"/', $dtc_vc_content, $tyres);

        if( !$tyres_category && !$tyres ){
            echo "no tyres component.";
            exit;
        }

        $tyres_json_data = array();
        $args = array(
            'post_type'     => 'tyres',
            'post_status'   => 'publish',
            'orderby'       => 'title',
            'include'       =>  $tyres[1],
            'posts_per_page'=>  -1,
            'category'      => $tyres_category[1],
            'orderby'       => 'post_title',
            'order'         =>'ASC'
        );

        $query = new WP_Query( $args );

        $created_at =  Date('Y-m-d H:i:s');


        while ( $query->have_posts() ) : $query->the_post();
            $tyres_json_data[] =  array(
                                            'tyre_name' => $post->post_title,
                                            'slug' => $post->post_name ?? '',
                                            'url' => get_permalink($post->ID),
                                            'locale' => SITE_LOCALE,
                                            'post_excerpt' => $post->post_excerpt,
                                            'created_at' => $created_at
                                        );
        endwhile;

        wp_reset_query();
        echo  json_encode($tyres_json_data);
        exit;
    }

    function dtc_import_get_stores(){

        $autocare_translations = ['Autocare'];
        $store_json_data = array();


        $args = array(
            'post_type'     => 'store',
            'post_status'   => 'publish',
            'orderby'       => 'title',
            'posts_per_page'=>  -1
        );

        $query = new WP_Query( $args );

        if(!$query){
            echo "no stores found.";
            exit;
        }

        $created_at =  Date('Y-m-d H:i:s');

        while ( $query->have_posts() ) : $query->the_post();

            $state = get_post_meta(get_the_ID() , 'ht_store_state' );
            $store_category = get_post_meta( get_the_ID()  , 'ht_store_cat' );

            $under_autocare = array_intersect($store_category, $autocare_translations );

            ( count($under_autocare) > 0 ) ? $is_autocare = true :  $is_autocare = false;

            $store_json_data[] = array(
                'store_name' => trim(get_the_title()),
                'state' => trim($state[0]),
                'category' => implode(',',$store_category),
                'url' => get_permalink( get_the_ID() ),
                'is_dtc' => $is_autocare,
                'locale' => SITE_LOCALE,
                'created_at' => $created_at
            );
        endwhile;

        wp_reset_query();
        echo json_encode($store_json_data);
        exit;

    }


    function dtc_lookup_code_status(string $code)
    {
        $code = strtoupper(trim($code));
        if ($code === '') {
            return 'invalid';
        }

        $url = dtc_theme_api_url('dtc_codes_new/is_exist/' . rawurlencode($code));
        $response = wp_remote_get($url, ['timeout' => 15]);
        if (is_wp_error($response)) {
            return $response;
        }

        $response_code = wp_remote_retrieve_response_code($response);
        $response_body = wp_remote_retrieve_body($response);
        $result = json_decode($response_body, true);
        if ($response_code !== 200 || ! is_array($result)) {
            write_log('DTC CODE API ERROR', [
                'status' => $response_code,
                'response' => substr(wp_strip_all_tags($response_body), 0, 1000),
            ]);
            return new WP_Error('dtc_code_api_error', 'The WFA DTC Code service returned HTTP ' . $response_code . '.');
        }

        if (empty($result['success'])) {
            return 'invalid';
        }

        return ! empty($result['is_use']) ? 'used' : 'valid';
    }

    function is_dtc_card_valid()
    {
        if (! check_ajax_referer('inno-tyrenonce', 'security', false)) {
            wp_send_json(['success' => false, 'status' => 'error', 'message' => 'Unable to verify the request. Refresh the page and try again.'], 403);
        }

        $code = isset($_POST['dtc_code']) ? strtoupper(sanitize_text_field(wp_unslash($_POST['dtc_code']))) : '';
        $status = dtc_lookup_code_status($code);
        if (is_wp_error($status)) {
            write_log('DTC CODE VERIFICATION ERROR', $status->get_error_message());
            wp_send_json(['success' => false, 'status' => 'error', 'message' => 'Could not verify the DTC Code. Please try again.'], 502);
        }

        wp_send_json([
            'success' => $status === 'valid',
            'status' => $status,
        ]);
    }

    function is_dtc_card_valid_experimental()
    {
        global $dtcdb;

        check_ajax_referer('inno-tyrenonce','security', false);

        if(isset($_POST['dtc_card_no'])){
            $dtc_code =  $_POST['dtc_card_no'];
        }
        else {
            $dtc_code =  $_POST['dtc_code'];
        }
        // select count(id) as cnt from dtc_codes where locale = 'my' and is_use = 0 and code = 'UQ8DS4MB';
        $sql = "select count(id) as cnt from dtc_codes where locale = '" . SITE_LOCALE . "' and is_use = 1 and code ='" . $dtc_code . "'";
        $results = $dtcdb->get_results($sql);

        print_r($results);


        /*
        if ( 200 != $response_code && ! empty( $response_message ) ) {
            return new WP_Error( $response_code, $response_message );
        } elseif ( 200 != $response_code ) {
            return new WP_Error( $response_code, 'Unknown error occurred' );
        } else {
            // return wp_remote_retrieve_body( $response );
            if($_POST['dtc_card_no']){
                return $save_response->success;
            }
            else{
                echo json_encode(['success' => $save_response->success]);
            }
        }
        */
        wp_die();
    }


    /* DTC Registry Checker */
    function dtc_check_registry(){
		
        check_ajax_referer('inno-tyrenonce','security');

        $url = dtc_theme_api_url('checkRecordByDtcCodeOrPlateNum');
        $response = wp_remote_post( $url, array(
            'method' => 'POST',
            'timeout' => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'body' => ['dtc_code' => $_POST['dtc_code'], 'locale' => SITE_LOCALE ],
            'cookies' => array()
            )
        );


        if ( is_wp_error( $response ) ) {
           $error_message = $response->get_error_message();
           echo "Something went wrong: $error_message";
           exit;
        } else {
           $record = json_decode( $response['body'] );

        }
 
        if($record && !empty($record->data)){
            $entries = is_array($record->data) ? $record->data : [$record->data];
            foreach ($entries as $entry) {
                $entry->plate_no = $entry->vehicle_reg_id;
                $entry->lookup_input = ! empty($entry->matched_by_plate) ? sanitize_text_field(wp_unslash($_POST['dtc_code'] ?? '')) : '';
            }
            echo wp_json_encode(['html' => hatt()->load_template('dtc/check-records', null, $entries)]);
        }
        else {
            echo 0;
        }

        exit;
    }



    function uploadBlob($filetoUpload, $destinationURL, $accesskey) {

	    $handle = fopen($filetoUpload, "r");
	    $fileLen = filesize($filetoUpload);

		$headers = [
		'x-ms-blob-type: BlockBlob',
		];

		$ch = curl_init($destinationURL."?".$accesskey);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_INFILE, $handle);
		curl_setopt($ch, CURLOPT_INFILESIZE, $fileLen);
		curl_setopt($ch, CURLOPT_UPLOAD, true);


		$result = curl_exec($ch);

		if (curl_errno($ch)) {
			curl_close($ch);
			return json_encode('Error');
		} else {
			$resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($resultStatus == 200 || $resultStatus == 201) {
				curl_close($ch);
				return json_encode('Success');
			} else {
				curl_close($ch);
				return json_encode('Error');
			}
		}
		curl_close($ch);
    }
	
	//Custom log for debuggin purpose
	function write_log($header, $log) {
		
		// Current date and time
		date_default_timezone_set('Asia/Singapore');
		$timestamp = date('Y-m-d H:i:s');
		
		$log = (is_object($log) || is_array($log) || is_resource($log) ? json_encode($log, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : $log);
		// Log format: [Timestamp] Message
		$log_entry = "[$timestamp] $header : $log\n";
		file_put_contents(ABSPATH . 'wp-content/logger.log', $log_entry, FILE_APPEND);
	}
    
	
	add_action('wp_ajax_validate_plate_number', 'validate_plate_number');
	add_action('wp_ajax_nopriv_validate_plate_number', 'validate_plate_number');
	
	function validate_plate_number() {
	
		$plate_number = sanitize_text_field($_POST['vehicle_reg_id']);
	
		$url_latest_created_date = dtc_theme_api_url('fetchPlateNumLatestEntryToday');
	
		$response = wp_remote_post(
			$url_latest_created_date,
			array(
				'method' => 'POST',
				'timeout' => 45,
				'body' => array(
					'vehicle_reg_id' => $plate_number,
					'locale' => SITE_LOCALE
				)
			)
		);
	
		$parsed = json_decode(wp_remote_retrieve_body($response));
	
		if ($parsed->data != null) {
	
			wp_send_json_success(array(
				'exists' => true,
				'code' => 3,
				'message' => "The plate number {$plate_number} is already registered."
			));
		}
	
		wp_send_json_success(array(
			'exists' => false
		));
	}

/************ ./DTC *************************/
