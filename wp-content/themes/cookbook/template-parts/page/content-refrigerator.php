<?php if($args['terms']) : ?>
    <div class="row row-cols-6 g-2 content-refrigerator mb-5">
        <div class="col-12">
            <h3><?php echo $args['title']; ?></h3>
        </div>
        <?php foreach ($args['terms'] as $key => $value) : ?>
            <?php
            $myMaterials = wp_list_pluck( $_SESSION['addRefrigerator'], 'term_id' );
            $isAdd = in_array($value->term_id, $myMaterials) ? 'add' : '';
            ?>
            <div class="col">
                <div class="card p-1 text-center content-refrigerator-item <?php echo $isAdd;?>">
                    <a href="" class="text-link1" data-id="<?php echo $value->term_id ?>"><?php echo $value->name ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php


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