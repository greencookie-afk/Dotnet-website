// Scroll to top functionality
window.addEventListener('scroll', function() {
    var scrollToTop = document.querySelector('.scroll-to-top');
    if (scrollToTop) {
        if (window.pageYOffset > 300) {
            scrollToTop.classList.add('active');
        } else {
            scrollToTop.classList.remove('active');
        }
    }
});

// Scroll to top click event
document.addEventListener('DOMContentLoaded', function() {
    var scrollToTop = document.querySelector('.scroll-to-top');
    if (scrollToTop) {
        scrollToTop.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
});
