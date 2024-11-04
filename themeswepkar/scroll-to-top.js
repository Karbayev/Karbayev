// Показываем кнопку при прокрутке
window.onscroll = function() {
    const scrollToTopButton = document.getElementById('scroll-to-top');
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        scrollToTopButton.style.display = "block";
    } else {
        scrollToTopButton.style.display = "none";
    }
};

// Плавная прокрутка при нажатии на кнопку
document.getElementById('scroll-to-top').onclick = function(e) {
    e.preventDefault();
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // Плавная прокрутка
    });
};
