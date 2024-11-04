<?php
function themeswepkar_setup() {
    // Поддержка заголовка
    add_theme_support('title-tag');

    // Поддержка миниатюр для постов
    add_theme_support('post-thumbnails');

    // Поддержка кастомного логотипа
    add_theme_support('custom-logo', array(
        'height'      => 100, // Высота логотипа
        'width'       => 400, // Ширина логотипа
        'flex-height' => true, // Позволяет изменение высоты
        'flex-width'  => true, // Позволяет изменение ширины
    ));

    // Регистрация меню
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'themeswepkar'), // Основное меню
        'secondary' => __('Secondary Menu', 'themeswepkar'), // Вторичное меню для бокового меню
    ));
}
add_action('after_setup_theme', 'themeswepkar_setup');

function enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');

function themeswepkar_scripts() {
    wp_enqueue_style('themeswepkar-style', get_stylesheet_uri());

    // Подключаем файл JavaScript для меню
    wp_enqueue_script('themeswepkar-menu', get_template_directory_uri() . '/menu.js', array(), null, true);

    // Подключаем файл JavaScript для живого поиска
    wp_enqueue_script('themeswepkar-live-search', get_template_directory_uri() . '/live-search.js', array(), null, true);
    
    // Подключаем файл JavaScript для переключения темы
    wp_enqueue_script('themeswepkar-theme-toggle', get_template_directory_uri() . '/theme-toggle.js', array(), null, true);

    wp_enqueue_script('themeswepkar-scroll-to-top', get_template_directory_uri() . '/scroll-to-top.js', array(), null, true);

}
add_action('wp_enqueue_scripts', 'themeswepkar_scripts');

// Функция для хлебных крошек
function custom_breadcrumbs() {
    // Параметры
    $separator = ' &gt; '; // Разделитель
    $home_title = 'Главная'; // Название главной страницы

    // Основной код
    echo '<div class="breadcrumbs">';
    echo '<a href="' . get_home_url() . '">' . $home_title . '</a>' . $separator;

    // Проверяем, является ли это главной страницей
    if (is_front_page()) {
        echo ''; // Если главная страница, выводим только название
    } elseif (is_category() || is_single()) {
        the_category($separator);
        if (is_single()) {
            echo $separator;
            the_title();
        }
    } elseif (is_page()) {
        echo the_title();
    } elseif (is_tag()) {
        echo 'Записи с тегом: "' . single_tag_title('', false) . '"';
    } elseif (is_day()) {
        echo 'Архив за ' . get_the_date();
    } elseif (is_month()) {
        echo 'Архив за ' . get_the_date('F Y');
    } elseif (is_year()) {
        echo 'Архив за ' . get_the_date('Y');
    } elseif (is_author()) {
        echo 'Автор: ' . get_the_author();
    } elseif (isset($_GET['s']) && !empty($_GET['s'])) {
        echo 'Результаты поиска для "' . get_search_query() . '"';
    } else {
        echo 'Ошибка 404';
    }

    echo '</div>';
}

// Добавляем настройки темы
function themeswepkar_customize_register($wp_customize) {
    // Настройка для выбора категории
    $wp_customize->add_setting('sidebar_category', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('sidebar_category', array(
        'label' => __('Select Category for Sidebar Posts', 'themeswepkar'),
        'section' => 'static_front_page',
        'settings' => 'sidebar_category',
        'type' => 'select',
        'choices' => themeswepkar_get_categories() + array('' => __('All Categories', 'themeswepkar')), // Получаем категории и добавляем опцию "Все категории"
    ));

    // Настройка для количества постов
    $wp_customize->add_setting('sidebar_post_count', array(
        'default' => 5,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('sidebar_post_count', array(
        'label' => __('Number of Posts', 'themeswepkar'),
        'section' => 'static_front_page',
        'settings' => 'sidebar_post_count',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 20,
            'step' => 1,
        ),
    ));

    // Настройка для количества слов
    $wp_customize->add_setting('word_count', array(
        'default' => 15,
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('word_count', array(
        'label' => __('Number of Words to Display', 'themeswepkar'),
        'section' => 'static_front_page',
        'settings' => 'word_count',
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 50,
            'step' => 1,
        ),
    ));

    // Настройка для отображения миниатюры
    $wp_customize->add_setting('show_thumbnail', array(
        'default' => true,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('show_thumbnail', array(
        'label' => __('Show Thumbnail', 'themeswepkar'),
        'section' => 'static_front_page',
        'settings' => 'show_thumbnail',
        'type' => 'checkbox',
    ));

    // Настройка для отображения даты
    $wp_customize->add_setting('show_date', array(
        'default' => true,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('show_date', array(
        'label' => __('Show Date', 'themeswepkar'),
        'section' => 'static_front_page',
        'settings' => 'show_date',
        'type' => 'checkbox',
    ));
}
add_action('customize_register', 'themeswepkar_customize_register');

// Функция для получения категорий
function themeswepkar_get_categories() {
    $categories = get_categories();
    $category_array = array();

    foreach ($categories as $category) {
        $category_array[$category->term_id] = $category->name;
    }

    return $category_array;
}

// Функция для отображения постов в сайдбаре
function themeswepkar_display_sidebar_posts() {
    $category = get_theme_mod('sidebar_category'); // Получаем выбранную категорию
    $post_count = get_theme_mod('sidebar_post_count', 5); // Получаем количество постов
    $word_count = get_theme_mod('word_count', 15); // Получаем количество слов
    $show_thumbnail = get_theme_mod('show_thumbnail', true); // Получаем настройку миниатюры
    $show_date = get_theme_mod('show_date', true); // Получаем настройку отображения даты

    $args = array(
        'posts_per_page' => $post_count,
        'cat' => $category, // Если категория не выбрана, берем все посты
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<ul class="sidebar-posts">';
        while ($query->have_posts()) {
            $query->the_post();
            echo '<li>';

            if ($show_thumbnail && has_post_thumbnail()) {
                echo '<a href="' . get_permalink() . '">' . get_the_post_thumbnail(null, 'thumbnail') . '</a>';
            }

            echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';

            // Если требуется, показываем дату
            if ($show_date) {
                echo '<span class="post-date">' . get_the_date() . '</span>';
            }

            // Обрезаем текст до нужного количества слов
            $content = wp_trim_words(get_the_excerpt(), $word_count);
            echo '<p>' . $content . '</p>';
            echo '</li>';
        }
        echo '</ul>';
        wp_reset_postdata();
    } else {
        echo '<p>' . __('No posts found.', 'themeswepkar') . '</p>';
    }
}
?>
