<aside class="sidebar">
    <h2>Recent Posts</h2>
    <ul class="recent-posts">
        <?php
        // Получаем настройки
        $category_id = get_theme_mod('sidebar_category', ''); // ID выбранной категории
        $post_count = get_theme_mod('sidebar_post_count', 5); // Количество постов
        $show_thumbnail = get_theme_mod('show_thumbnail', true); // Показывать ли миниатюры
        $word_count = get_theme_mod('word_count', 15); // Количество слов для вывода
        $show_date = get_theme_mod('show_date', true); // Показывать ли дату поста

        // Запрос постов из выбранной категории, если категория не указана, берём все посты
        $args = array(
            'posts_per_page' => $post_count,
            'post_status' => 'publish',
        );

        if (!empty($category_id)) {
            $args['cat'] = $category_id; // Если указана категория, добавляем её в запрос
        }

        $recent_posts = new WP_Query($args);

        while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
            <li class="recent-post">
                <?php if ($show_thumbnail && has_post_thumbnail()) : ?>
                    <div class="recent-post-thumbnail">
                        <?php the_post_thumbnail('thumbnail'); ?>
                    </div>
                <?php endif; ?>
                <div class="recent-post-content">
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                    <?php if ($show_date) : ?>
                        <span class="post-date"><?php echo get_the_date(); ?></span>
                    <?php endif; ?>

                    <p><?php echo wp_trim_words(get_the_excerpt(), $word_count); ?></p> <!-- Отображаем заданное количество слов -->
                </div>
            </li>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    </ul>
</aside>
