<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
    <div class="header-container">
        <div class="header-left">
            <button id="burger-button" class="burger-button">
                &#9776; <!-- Символ для бургер-меню -->
            </button>
            <div class="theme-toggle">
                <button id="light-theme" class="theme-icon">
                    <i class="fas fa-sun"></i> <!-- Иконка для светлой темы -->
                </button>
                <button id="dark-theme" class="theme-icon">
                    <i class="fas fa-moon"></i> <!-- Иконка для темной темы -->
                </button>
            </div>
        </div>
        <div class="header-center">
            <?php if (has_custom_logo()) : ?>
                <div class="custom-logo">
                    <?php the_custom_logo(); ?>
                </div>
            <?php else : ?>
                <h1><?php bloginfo('name'); ?></h1>
            <?php endif; ?>
        </div>
        <div class="header-right">
            <div class="live-search">
                <input type="text" id="search-input" placeholder="Поиск..." />
                <div class="search-results"></div> <!-- Результаты поиска -->
            </div>
        </div>
    </div>
    <div class="horizontal-menu">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary', // Используем основное меню
            'menu_class' => 'primary-menu', // Указываем класс для стилизации
            'depth' => 2, // Указываем глубину меню для поддержки подменю
        ));
        ?>
    </div>
</header>


<div class="separator"></div>

<!-- Боковое меню -->
<div id="sidebar-menu" class="sidebar-menu">
    <button id="close-button" class="close-button">×</button>
    <?php
    wp_nav_menu(array(
        'theme_location' => 'secondary', // Укажите здесь нужное меню
        'menu_class' => 'sidebar-primary-menu',
        'depth' => 2, // Указываем глубину меню для поддержки подменю
    ));
    ?>
</div>
<?php if (function_exists('custom_breadcrumbs')) custom_breadcrumbs(); ?>

<a href="#" id="scroll-to-top" class="scroll-to-top" style="display: none;">↑</a>

<?php wp_footer(); ?>
</body>
</html>
