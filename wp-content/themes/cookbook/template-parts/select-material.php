<div class="container">
    <?php
    $title = '내 재료 선택하기';
    if(is_user_logged_in()){
        $title = '내 재료 관리하기';
    }
    $args = [
        'title' => $title,
        'terms' => get_terms('material', [
            'orderby' => 'count',
            'order' => 'DESC',
            'childless' => true
        ]),
    ];
    get_template_part('template-parts/page/content', 'refrigerator', $args);
    ?>
</div>