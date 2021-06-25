<?php
use CookBook\Classes\Refrigerator;
//error_reporting( E_ALL );
//ini_set( "display_errors", 1 );

function theme_init()
{
    include get_home_path() . '/vendor/autoload.php';
    require get_template_directory() . '/inc/template-tags.php';
}

add_action('init', 'theme_init');

function theme_support()
{
    add_theme_support( 'automatic-feed-links' );\
    add_theme_support(
        'custom-background',
        array(
            'default-color' => 'fff',
        )
    );

    global $content_width;
    if ( ! isset( $content_width ) ) {
        $content_width = 998;
    }

    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 1200, 9999 );
    add_image_size( 'cookbook-fullscreen', 1980, 9999 );

    $logo_width  = 120;
    $logo_height = 90;

    if ( get_theme_mod( 'retina_logo', false ) ) {
        $logo_width  = floor( $logo_width * 2 );
        $logo_height = floor( $logo_height * 2 );
    }

    add_theme_support(
        'custom-logo',
        array(
            'height'      => $logo_height,
            'width'       => $logo_width,
            'flex-height' => true,
            'flex-width'  => true,
        )
    );

    add_theme_support( 'title-tag' );
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'script',
            'style',
            'navigation-widgets',
        )
    );

    load_theme_textdomain( 'cookbook' );

}

add_action( 'after_setup_theme', 'theme_support' );

function register_styles() {
    wp_enqueue_style( 'cookbook-style', get_theme_file_uri('/style.css'), array(), time() );
    wp_enqueue_style( 'bootstrap-icon', '/node_modules/bootstrap-icons/font/bootstrap-icons.css', array(), time() );

}
add_action( 'wp_enqueue_scripts', 'register_styles' );

function register_scripts() {
    wp_enqueue_script('cookbook_jquery', get_theme_file_uri('/js/jquery-3.6.0.min.js'), array(), '202106', false);
}
add_action( 'wp_enqueue_scripts', 'register_scripts' );

function set_global_nav_var()
{
    global $POSTTYPES;
    $POSTTYPES = array( 'post', 'cookbook');
}
add_action( 'init', 'set_global_nav_var' );

function cookbook_menus() {

    $locations = array(
        'primary'  => __( 'Desktop Horizontal Menu', 'cookbook' ),
        'expanded' => __( 'Desktop Expanded Menu', 'cookbook' ),
        'mobile'   => __( 'Mobile Menu', 'cookbook' ),
        'footer'   => __( 'Footer Menu', 'cookbook' ),
        'social'   => __( 'Social Menu', 'cookbook' ),
    );

    register_nav_menus( $locations );
}

add_action( 'init', 'cookbook_menus' );

function bootstrap_pagination( \WP_Query $wp_query = null, $echo = true, $params = [] ) {
    if ( null === $wp_query ) {
        global $wp_query;
    }

    $add_args = [];

    //add query (GET) parameters to generated page URLs
    /*if (isset($_GET[ 'sort' ])) {
        $add_args[ 'sort' ] = (string)$_GET[ 'sort' ];
    }*/

    $pages = paginate_links( array_merge( [
            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
            'format'       => '?paged=%#%',
            'current'      => max( 1, get_query_var( 'paged' ) ),
            'total'        => $wp_query->max_num_pages,
            'type'         => 'array',
            'show_all'     => false,
            'end_size'     => 3,
            'mid_size'     => 1,
            'prev_next'    => true,
            'prev_text'    => __( '« Prev' ),
            'next_text'    => __( 'Next »' ),
            'add_args'     => $add_args,
            'add_fragment' => ''
        ], $params )
    );

    if ( is_array( $pages ) ) {
        //$current_page = ( get_query_var( 'paged' ) == 0 ) ? 1 : get_query_var( 'paged' );
        $pagination = '<div class="pagination justify-content-center"><ul class="pagination">';

        foreach ( $pages as $page ) {
            $pagination .= '<li class="page-item' . (strpos($page, 'current') !== false ? ' active' : '') . '"> ' . str_replace('page-numbers', 'page-link', $page) . '</li>';
        }

        $pagination .= '</ul></div>';

        if ( $echo ) {
            echo $pagination;
        } else {
            return $pagination;
        }
    }

    return null;
}

function sidebar_registration() {

    // Arguments used in all register_sidebar() calls.
    $shared_args = array(
        'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
        'after_title'   => '</h2>',
        'before_widget' => '<div class="widget %2$s col"><div class="widget-content">',
        'after_widget'  => '</div></div>',
    );

    // Footer #1.
    register_sidebar(
        array_merge(
            $shared_args,
            array(
                'name'        => __( 'Footer #1', 'cookbook' ),
                'id'          => 'sidebar-1',
                'description' => __( 'Widgets in this area will be displayed in the first column in the footer.', 'cookbook' ),
            )
        )
    );

}

add_action( 'widgets_init', 'sidebar_registration' );

//function my_theme_archive_title( $title ) {
//    if ( is_tax('material') ) {
//        $title = single_cat_title( '', false );
//    }
//
//    return $title;
//}
//
//add_filter( 'get_the_archive_title', 'my_theme_archive_title' );

function widget_posts_args_add_custom_type($params) {
    global $POSTTYPES;
    $params['post_type'] = $POSTTYPES;
    return $params;
}

add_filter('widget_posts_args', 'widget_posts_args_add_custom_type');

function search_filter($query) {
    global $POSTTYPES;
    if ( ! is_admin() && $query->is_main_query() ) {
        if ( $query->is_search ) {
            $query->set( 'post_type', $POSTTYPES );
        }
    }
}

add_action( 'pre_get_posts', 'search_filter' );

function add_additional_class_on_li($classes, $item, $args) {
    if(isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

function insertTerm($postId)
{
    $request = $_REQUEST;
    $materialGroup = $_REQUEST['material_group'];
    $terms = [];
    foreach ($materialGroup as $index => $item) {
        foreach ($item['material_class'] as $key => $value) {
            $terms[] = $value['material_name'];
        }
    }
    wp_set_object_terms($postId, $terms, 'material');
}

add_action('save_post', 'insertTerm');

function d($dump)
{
    echo '<pre>';
    var_dump($dump);
    echo '</pre>';
}

function printCoupangLink($keyword){
    include get_home_path() . '/env.php';
    date_default_timezone_set("GMT+0");

    $datetime = date("ymd").'T'.date("His").'Z';
    $method = "POST";
    $path = "/v2/providers/affiliate_open_api/apis/openapi/v1/deeplink";

    $message = $datetime.$method.str_replace("?", "", $path);

// Replace with your own ACCESS_KEY and SECRET_KEY
    $ACCESS_KEY = $api['coupang']['ACCESS_KEY'];
    $SECRET_KEY = $api['coupang']['SECRET_KEY'];

    $algorithm = "HmacSHA256";

    $signature = hash_hmac('sha256', $message, $SECRET_KEY);

    $authorization  = "CEA algorithm=HmacSHA256, access-key=".$ACCESS_KEY.", signed-date=".$datetime.", signature=".$signature;

    $url = 'https://api-gateway.coupang.com'.$path;

    $strjson='
    {
        "coupangUrls": [
            "https://www.coupang.com/np/search?component=&q='.$keyword.'&channel=user" 
        ]
    }
';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type:  application/json;charset=UTF-8", "Authorization:".$authorization));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $strjson);
    $result = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    $data = json_decode($result);
    echo $data->data[0]->shortenUrl;
}

function get_posts_custom_query( $query_args ) {
    global $wpdb;
    $sql_query = $query_args['sql_query'];
    // Do the necessary funky stuff here to build $sql_query from the given $query_args
    $limit = " LIMIT {$query_args['offset']}, {$query_args['posts_per_page']}";
    $wpdb->get_results($sql_query);

    // If you've limited the results returned and using SQL_CALC_FOUND_ROWS in the select query...
    if ( $query_args['posts_per_page'] > 1 ) {
        $found_posts = $wpdb->get_var('SELECT FOUND_ROWS()');
        $max_num_pages = ceil($found_posts/$query_args['posts_per_page']);
    }

    // Sanitise each post result
    $custom_query = $wpdb->get_results($sql_query.$limit);
    foreach( $custom_query as $i => $post ) {
        $custom_query[$i] = sanitize_post($post, 'raw');
    }

    // Setup WP_Query object
    $new_wp_query = new WP_Query();
    $new_wp_query->query = $sql_query;
    $new_wp_query->posts = $custom_query;
    $new_wp_query->post_count = count($custom_query);
    $new_wp_query->query_vars = ['paged' => $query_args['paged']];
    if ( isset($found_posts) ) $new_wp_query->found_posts = $found_posts;
    if ( isset($max_num_pages) ) $new_wp_query->max_num_pages = $max_num_pages;


    // Set the first post
    if ( $new_wp_query->post_count > 0 )
        $new_wp_query->post = $custom_query[0];

//    d($new_wp_query);
    return $new_wp_query;
}