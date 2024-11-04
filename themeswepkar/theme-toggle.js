document.addEventListener('DOMContentLoaded', function () {
    const lightThemeButton = document.getElementById('light-theme');
    const darkThemeButton = document.getElementById('dark-theme');

    // Проверяем, есть ли сохраненная тема в локальном хранилище
    const currentTheme = localStorage.getItem('theme') || 'light';
    document.body.classList.add(currentTheme + '-theme');
    document.querySelector('header').classList.add(currentTheme + '-theme');
    document.querySelector('footer').classList.add(currentTheme + '-theme');

    // Переключаем на светлую тему
    lightThemeButton.addEventListener('click', function () {
        document.body.classList.remove('dark-theme');
        document.body.classList.add('light-theme');
        document.querySelector('header').classList.remove('dark-theme');
        document.querySelector('header').classList.add('light-theme');
        document.querySelector('footer').classList.remove('dark-theme');
        document.querySelector('footer').classList.add('light-theme');
        localStorage.setItem('theme', 'light'); // Сохраняем тему
    });

    // Переключаем на темную тему
    darkThemeButton.addEventListener('click', function () {
        document.body.classList.remove('light-theme');
        document.body.classList.add('dark-theme');
        document.querySelector('header').classList.remove('light-theme');
        document.querySelector('header').classList.add('dark-theme');
        document.querySelector('footer').classList.remove('light-theme');
        document.querySelector('footer').classList.add('dark-theme');
        localStorage.setItem('theme', 'dark'); // Сохраняем тему
    });
});
