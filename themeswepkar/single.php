<?php get_header(); ?>

<div class="main-content">
    <main class="main-block single-post"> <!-- Добавляем класс single-post -->
        <h1><?php the_title(); ?></h1>
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>
                    <div><?php the_content(); ?></div>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p>No posts found.</p>
        <?php endif; ?>
    </main>

    <?php get_sidebar(); ?> <!-- Сайдбар -->
</div>

<?php get_footer(); ?>
