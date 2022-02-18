<?php
//silence is golden

/**
 * @package lyra
 */


get_header( ); ?>

<?php 

if(!is_home(  )){?>
<h2 class="page-title screen-reader-text">
    <?php echo single_post_title( ); ?>

</h2>
<?php } ?>


<?php


$number_of_cols = 3;


if(have_posts()):?>
<div class="row ">
<?php
    while(have_posts()):
        the_post();
        ?>
        <div class="col-sm-12 col-md-6 col-lg-4 mb-2 p-2">
            <div class="blog-post-archive-card bg-light p-4">
                <a class="text-dark" href="<?php the_permalink() ?>">
               <?php get_template_part( 'template-parts/content' ); ?>
               </a>
            </div>
        </div>
        <?php
    endwhile;
    ?>
    </div>
    <?php
    else:
        get_template_part( 'template-parts/content-none' );
endif;


get_footer( );

