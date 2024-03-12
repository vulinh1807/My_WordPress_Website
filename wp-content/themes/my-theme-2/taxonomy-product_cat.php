<?php get_header();?>
    <!-- Breadcrumb Section Begin -->
    <?php get_template_part( 'ecommerce/global/breadcrumb.php' ); ?>
    
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <?php get_sidebar('shop');?>
                <div class="col-lg-9 col-md-7">
                    <?php if(have_posts()):?>
                    <?php get_template_part( 'ecommerce/archive/product__discount.php' ); ?>
                    <?php get_template_part( 'ecommerce/archive/filter__item.php' ); ?>
                    <div class="row">
                        <?php while ( have_posts() ) : the_post(); ?>
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <?php get_template_part('ecommerce/content/product.php',null,['post_id' => get_the_id() ]);?>
                        </div>
                        <?php endwhile;?>
                    </div>
                    <?php get_template_part( 'ecommerce/archive/product__pagination.php' ); ?>
                    <?php else: ?>
                        <?php get_template_part( 'ecommerce/archive/content-none.php' ); ?>    
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->
<?php get_footer();?>