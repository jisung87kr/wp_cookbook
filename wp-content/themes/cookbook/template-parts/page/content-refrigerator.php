<?php
use CookBook\Classes\Refrigerator;
?>
<?php if($args['terms']) : ?>
    <div class="">
        <h3><?php echo $args['title']; ?></h3>
    </div>
    <div class="content-refrigerator-outer">
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
    </div>
<?php endif; ?>
<div class="text-center mb-5">
    <a href="" class="btn btn-primary">레시피 찾기</a>
</div>
    <script>
        $(document).ready(function () {
            var themeUrl = "<?php echo get_template_directory_uri(); ?>";
            $(".content-refrigerator-item").click(function (e) {
                e.preventDefault();
                if($(this).hasClass('add')){
                    $(this).removeClass('add');
                    var act = '<?php echo $deleteRefrigerator ?>';
                } else {
                    $(this).addClass('add');
                    var act = '<?php echo $addRefrigerator ?>';
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
<?php
$Refrigerator = new Refrigerator;
$addRefrigerator = $Refrigerator::addRefrigerator;
$deleteRefrigerator = $Refrigerator::deleteRefrigerator;

$wp_query = $Refrigerator->getPosts2();

$param = [
    'title' => '내 재료로 만들수 있는 요리',
    'wp_query' => $wp_query
];

get_template_part( 'template-parts/content/content', 'grid', $param);
?>