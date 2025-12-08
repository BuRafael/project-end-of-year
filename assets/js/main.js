// Main JavaScript file

document.addEventListener('DOMContentLoaded', function() {
    // Theme JavaScript
});
// scroll top
const scrollBtn = document.getElementById("scrollTopBtn");

scrollBtn.addEventListener("click", () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});

