document.addEventListener('DOMContentLoaded', function () {
    // Код для аккордеона в основном меню
    const menuItems = document.querySelectorAll('.primary-menu li:has(ul) > a');
    menuItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault(); // Предотвращаем переход по ссылке
            const submenu = item.nextElementSibling;
            if (submenu) {
                submenu.classList.toggle('show'); // Переключаем класс для отображения подменю
                console.log('Toggle submenu:', submenu); // Отладка
            }
        });
    });

    // Код для открытия и закрытия бокового меню
    const burgerButton = document.getElementById('burger-button');
    const sidebarMenu = document.getElementById('sidebar-menu');
    const closeButton = document.getElementById('close-button');

    burgerButton.addEventListener('click', function () {
        sidebarMenu.classList.toggle('open'); // Добавляем/удаляем класс для открытия меню
    });

    closeButton.addEventListener('click', function () {
        sidebarMenu.classList.remove('open'); // Закрываем меню
    });

    // Закрываем боковое меню при клике вне его области
    document.addEventListener('click', function (event) {
        const isClickInsideMenu = sidebarMenu.contains(event.target);
        const isClickOnBurgerButton = burgerButton.contains(event.target);
        
        // Если клик вне меню и вне кнопки-бургера, закрываем меню
        if (!isClickInsideMenu && !isClickOnBurgerButton) {
            sidebarMenu.classList.remove('open'); // Закрываем меню
        }
    });
});
