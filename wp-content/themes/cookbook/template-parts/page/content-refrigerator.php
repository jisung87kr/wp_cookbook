<?php if($args['terms']) : ?>
    <div class="">
        <h3><?php echo $args['title']; ?></h3>
    </div>
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-6 g-2 content-refrigerator mb-5 mt-2">
        <?php foreach ($args['terms'] as $key => $value) : ?>
            <?php
            $myMaterials = wp_list_pluck( $_SESSION['addRefrigerator'], 'term_id' );
            $isAdd = in_array($value->term_id, $myMaterials) ? 'add' : '';
            ?>
            <div class="col">
                <div class="card p-1 p-sm-3 text-center content-refrigerator-item <?php echo $isAdd;?>">
                    <a href="" class="text-link1" data-id="<?php echo $value->term_id ?>"><?php echo $value->name ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<div class="text-center">
    <a href="" class="btn btn-primary">레시피 찾기</a>
</div>
<?php
if($_SESSION['addRefrigerator']){
    global $POSTTYPES;
    $args = array(
        'post_type' => $POSTTYPES,
        'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
        'posts_per_page' => 16,
    );

    $param = [
        'title' => '냉장고'
    ];

    $terms = wp_list_pluck($_SESSION['addRefrigerator'], 'term_id');
    $taxquery = array(
        'tax_query' => array(
            array(
                'taxonomy' => 'material',
                'field'    => 'term_id',
                'terms'    => $terms,
            ),
        ),
    );
    $args = array_merge($args, $taxquery);
}

$wp_query = new WP_Query( $args );
get_template_part( 'template-parts/content/content', 'grid', $param);
?>
<script>
    $(document).ready(function () {
        var themeUrl = "<?php echo get_template_directory_uri(); ?>";
        $(".content-refrigerator-item").click(function (e) {
            e.preventDefault();
            if($(this).hasClass('add')){
                $(this).removeClass('add');
                var act = 'deleteRefrigerator';
            } else {
                $(this).addClass('add');
                var act = 'addRefrigerator';
            }

            $.ajax({
                data: {
                    'act': act,
                    'term_id' : $("a", this).data('id'),
                    'term' : $("a", this).text(),
                },
                url: themeUrl + '/requests.php',
                async: true,
                dataType: 'json',
                method: 'POST',
                success: function (data) {
                    console.log(data);
                },
                error: function(data){
                    console.log(data);
                },
            });
        });
    });
</script>