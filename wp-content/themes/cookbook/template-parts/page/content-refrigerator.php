<?php if($args['terms']) : ?>
    <div class="row row-cols-6 g-2 content-refrigerator mb-5">
        <div class="col-12">
            <h3><?php echo $args['title']; ?></h3>
        </div>
        <?php foreach ($args['terms'] as $key => $value) : ?>
            <div class="col">
                <div class="card p-1 text-center content-refrigerator-item">
                    <a href="" class="text-link1"><?php echo $value->name ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<script>
    $(document).ready(function(){
        $(".content-refrigerator-item").click(function(e){
            e.preventDefault();
           $(this).toggleClass('add');
        });
    });
</script>