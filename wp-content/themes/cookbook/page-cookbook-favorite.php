<?php
if(!is_user_logged_in()){
    wp_redirect(wp_login_url());
}

get_header();
?>
    <div class="container">
        <?php
        global $POSTTYPES;
        $args = array(
            'post_type' => $POSTTYPES,
            'meta_key' => 'cookbook_favorite',
            'meta_query' => array(
                array(
                    'key' => 'cookbook_favorite',
                    'value' => get_current_user_id(),
                )
            )
        );
        $query = new WP_Query($args);

        $param = [
            'wp_query' => $query,
            'title' => '보관함'
        ];
        get_template_part('template-parts/content/content', 'grid', $param);

        ?>
    </div>
<?php
get_footer();
