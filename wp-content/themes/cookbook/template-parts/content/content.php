<?php
use CookBook\Classes\Refrigerator;
$Refrigerator = new Refrigerator;
$category = get_the_terms( $post->ID, 'cookCategory' );
$tag = get_the_terms( $post->ID, 'cookTag' );
$oembed = rwmb_meta( 'cook_oembed' );
$group = rwmb_get_value( 'material_group' );
$step = rwmb_get_value( 'cook_step' );
$thumb = rwmb_get_value( 'cook_thumb' );
?>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <?php if($oembed) : ?>
            <div class="youtube">
                <?php echo $oembed; ?>
            </div>
            <?php else : ?>
                <?php if($thumb['sizes']['large']['url']) :?>
                    <img src="<?php echo $thumb['sizes']['large']['url'] ?>" alt="">
                <?php else : ?>
                    <img src="https://via.placeholder.com/500x300" class="card-img-top" alt="...">
                <?php endif; ?>
            <?php endif; ?>
            <div class="card-body">
                <div class="card-title">
                    <b><?php the_title() ?></b>
                </div>
                <div class="text-muted mt-2">
                    <small><?php echo human_time_diff(get_the_time('U')) ?> 전</small>
                </div>
                <hr>
                <?php if(!is_null(the_content())) : ?>
                <div class="card-text">
                    <?php the_content(); ?>
                </div>
                <hr>
                <?php endif; ?>
                <?php if($category || $tag) :?>
                    <div class="">
                        <?php if($category) :?>
                            <div>
                                <i class="bi bi-archive"></i>
                                <?php foreach ($category as $index => $item) : $term = get_term_link($item, 'cookCategory'); ?>
                                    <a href="<?= $term ?>" class="text-link1">
                                        <small class="text-muted"><?= $item->name ?></small>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php if($tag) :?>
                            <div>
                                <i class="bi bi-tag"></i>
                                <?php foreach ($tag as $index => $item) : $term = get_term_link($item, 'cookTag'); ?>
                                    <a href="<?php echo $term ?>" class="text-link1">
                                        <small class="text-muted"><?php echo $item->name ?></small>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 g-4 mt-2">
            <?php $terms = []; ?>
            <?php foreach ($group as $key => $value) : $materialTitle = $value['material_group_title']; ?>
                <div class="col">
                    <div class="card">
                        <div class="card-header"><?php echo $materialTitle ?></div>
                        <ul class="list-group list-group-flush">
                            <?php
                            foreach ($value['material_class'] as $index => $item) :
                                $term = get_term_by('name', $item['material_name'], 'material');
                                $termLink = get_term_link($term->name, 'material');
                                $terms[$index] = $term;
                                //$termLink .= '&post_type='.get_post_type(get_the_ID());
                            ?>
                            <li class="list-group-item">
                                <small class="text-muted">
                                    <a href="<?php echo $termLink ?>" class=""><?php echo $term->name?></a>
                                    <?php if(in_array($term->name, $Refrigerator->getTerms('term'))):?>
                                    (있음)
                                    <?php endif; ?>
                                    <span class="float-end"><?php echo $item['material_unit'] ?></span>
                                </small>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="card store mt-4">
            <div class="card-body">
                <h4 class="mb-3 text-center">장보러 가기</h4>
                <iframe src="https://coupa.ng/bCTGZa" width="100%" height="36" frameborder="0" scrolling="no" class="mb-1"></iframe>
                <div>부족한 재료</div>
                <?php
                foreach ($terms as $index => $term) {
                    foreach ($_SESSION['addRefrigerator'] as $index => $item) {
                        if($term->term_id == $item['term_id']){
                            continue 2;
                        }
                    }
                ?>
                <span class="badge bg-secondary">
                    <a href="<?php echo printCoupangLink($term->name); ?>" target="_blank"><?php echo $term->name;?></a>
                </span>
                <?php
                }
                ?>
            </div>
        </div>
        <ol class="p-0 mt-4">
            <?php foreach ($step as $key => $value) : ?>
            <li>
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="card-title text-muted">STEP. <?php echo $key+1 ?></div>
                        <div class="card-text mt-3">
                            <?php echo $value?>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ol>
    </div>
    <div class="col-lg-4 ps-lg-5 mt-3 mt-lg-0">
        <?php get_template_part('template-parts/related-list', get_post_type()) ?>
    </div>
    <?php
    if ( ( is_single() || is_page() ) && ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
    ?>

    <div class="comments-wrapper section-inner">

        <?php //comments_template(); ?>

    </div>

    <?php
	}
	?>
</div>

