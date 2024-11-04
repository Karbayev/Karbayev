<?php get_header(); ?>

<div class="main-content">
    <main class="main-block">
        <h1>Welcome to ThemesWepKar</h1>
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article style="overflow: hidden; margin-bottom: 20px;"> <!-- Добавлен стиль для очистки потока -->
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-thumbnail" style="float: left; margin-right: 15px;">
                            <?php the_post_thumbnail('thumbnail'); ?>
                        </div>
                    <?php endif; ?>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div><?php the_excerpt(); ?></div> <!-- Используйте the_excerpt() для краткого текста -->
                    <a class="read-more" href="<?php the_permalink(); ?>">Читать далее</a>
                    
                    <div class="post-divider" style="clear: both; border-top: 1px solid #ccc; margin: 20px 0;"></div> <!-- Разделитель -->
                </article>
            <?php endwhile; ?>

            <!-- Пагинация -->
            <div class="pagination">
                <?php
                echo paginate_links(array(
                    'total' => $wp_query->max_num_pages, // Общее количество страниц
                    'current' => max(1, get_query_var('paged')), // Текущая страница
                    'format' => '?paged=%#%', // Формат ссылки
                    'prev_text' => __('« Предыдущая', 'themeswepkar'), // Текст для предыдущей страницы
                    'next_text' => __('Следующая »', 'themeswepkar'), // Текст для следующей страницы
                ));
                ?>
            </div>

        <?php else : ?>
            <p>No posts found.</p>
        <?php endif; ?>
    </main>

    <?php get_sidebar(); ?> <!-- Сайдбар -->
</div>

<?php get_footer(); ?>
