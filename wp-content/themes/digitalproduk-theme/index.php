<?php
/**
 * The template for displaying all single posts & fallback
 *
 * @package DigitalProduk
 */

get_header();
?>

<div class="container section">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1 class="section-title"><?php the_title(); ?></h1>
                <div class="post-content" style="color: var(--text-secondary); margin-top: 1.5rem; line-height: 1.8;">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        endwhile;
    endif;
    ?>
</div>

<?php
get_footer();
