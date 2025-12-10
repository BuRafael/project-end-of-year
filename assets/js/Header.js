// Header JavaScript

document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('.site-header');

    const handleHeaderShadow = () => {
        if (!header) return;
        if (window.scrollY > 10) {
            header.classList.add('is-scrolled');
        } else {
            header.classList.remove('is-scrolled');
        }
    };

    handleHeaderShadow();
    window.addEventListener('scroll', handleHeaderShadow, { passive: true });
});
