<?php
get_header();
global $POSTTYPES;
$taxArr = ['cookTag', 'cookCategory', 'material'];
$args = array(
    'post_type' => $POSTTYPES,
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
    'posts_per_page' => 16,
);

if(get_query_var('s')){
    function advance_search_where($where){
        global $wpdb;
        if (is_search())
            $where .= "OR (t.name LIKE '%".get_search_query()."%' AND {$wpdb->posts}.post_status = 'publish')";
        return $where;
    }

    function advance_search_join($join){
        global $wpdb;
        if (is_search())
            $join .= "LEFT JOIN {$wpdb->term_relationships} tr ON {$wpdb->posts}.ID = tr.object_id INNER JOIN {$wpdb->term_taxonomy} tt ON tt.term_taxonomy_id=tr.term_taxonomy_id INNER JOIN {$wpdb->terms} t ON t.term_id = tt.term_id";
        return $join;
    }

    function advance_search_groupby($groupby){
        global $wpdb;
        // we need to group on post ID
        $groupby_id = "{$wpdb->posts}.ID";

        if(!is_search() || strpos($groupby, $groupby_id) !== false) return $groupby;

        // groupby was empty, use ours
        if(!strlen(trim($groupby))) return $groupby_id;

        // wasn't empty, append ours
        return $groupby.", ".$groupby_id;
    }

    add_filter('posts_where','advance_search_where');
    add_filter('posts_join', 'advance_search_join');
    add_filter('posts_groupby', 'advance_search_groupby');

    $args['s'] = get_query_var('s');
}

foreach ($taxArr as $index => $item) {
    if(is_tax($item)){
        $taxquery = array(
            'tax_query' => array(
                array(
                    'taxonomy' => $item,
                    'field'    => 'slug',
                    'terms'    => get_query_var($item),
                ),
            ),
        );
        $args = array_merge($args, $taxquery);
    }
}


$wp_query = new WP_Query( $args );
$taxonomyName     = '';
$archive_title    = '';
$archive_subtitle = '';
if ( is_search() ) {
    global $wp_query;

    $archive_title = sprintf(
        '%1$s %2$s',
        '<span class="color-accent">' . __( 'Search:', 'cookbook' ) . '</span>',
        '&ldquo;' . get_search_query() . '&rdquo;'
    );

    if ( $wp_query->found_posts ) {
        $archive_subtitle = sprintf(
        /* translators: %s: Number of search results. */
            _n(
                'We found %s result for your search.',
                'We found %s results for your search.',
                $wp_query->found_posts,
                'cookbook'
            ),
            number_format_i18n( $wp_query->found_posts )
        );
    } else {
        $archive_subtitle = __( 'We could not find any results for your search. You can give it another try through the search form below.', 'cookbook' );
    }
} elseif ( is_archive() && ! have_posts() ) {
    $archive_title = __( 'Nothing Found', 'cookbook' );
} elseif ( ! is_home() ) {
    $archive_title    = get_the_archive_title();
    $archive_subtitle = get_the_archive_description();
}
?>

<?php if ( $archive_title || $archive_subtitle ) :?>
<header class="archive-header text-center mb-5">
    <div class="archive-header-inner">
        <?php if ( $archive_title ) : ?>
            <h1 class="archive-title"><?php echo wp_kses_post( $archive_title ); ?></h1>
        <?php endif; ?>
        <?php if ( $archive_subtitle ) : ?>
            <div class="archive-subtitle"><?php echo wp_kses_post( wpautop( $archive_subtitle ) ); ?></div>
        <?php endif; ?>
    </div><!-- .archive-header-inner -->
</header><!-- .archive-header -->
<?php endif; ?>
<div class="container">
    <?php
    $param = [
        'wp_query' => $wp_query,
    ];
    get_template_part( 'template-parts/content/content', 'grid', $param);
    ?>
</div>
<?php
get_footer();
