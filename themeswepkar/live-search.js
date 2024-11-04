document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const resultsContainer = document.querySelector('.search-results');

    searchInput.addEventListener('input', function () {
        const query = searchInput.value;

        if (query.length > 2) { // Начинаем поиск после ввода 3 символов
            fetch(`/wp-json/wp/v2/search?search=${query}`)
                .then(response => response.json())
                .then(data => {
                    resultsContainer.innerHTML = '';

                    if (data.length > 0) {
                        resultsContainer.classList.add('active'); // Показываем результаты
                        data.forEach(item => {
                            const link = document.createElement('a');
                            link.href = item.url; // Ссылка на результат
                            link.textContent = item.title; // Заголовок результата
                            resultsContainer.appendChild(link);
                        });
                    } else {
                        resultsContainer.classList.remove('active'); // Скрываем, если нет результатов
                    }
                });
        } else {
            resultsContainer.innerHTML = ''; // Очищаем результаты, если меньше 3 символов
            resultsContainer.classList.remove('active'); // Скрываем результаты
        }
    });

    // Закрываем результаты поиска при клике вне
    document.addEventListener('click', function (event) {
        if (!searchInput.contains(event.target) && !resultsContainer.contains(event.target)) {
            resultsContainer.classList.remove('active'); // Скрываем результаты
        }
    });
});
