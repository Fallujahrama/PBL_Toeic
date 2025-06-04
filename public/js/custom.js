document.addEventListener("DOMContentLoaded", () => {
    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled', 'bg-white', 'shadow-sm');
                navbar.classList.remove('bg-transparent');
            } else {
                navbar.classList.remove('navbar-scrolled', 'bg-white', 'shadow-sm');
                navbar.classList.add('bg-transparent');
            }
        });
    }

    // Feature cards animation
    const cards = document.querySelectorAll('.features-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.classList.add('card-hover');
        });
        card.addEventListener('mouseleave', () => {
            card.classList.remove('card-hover');
        });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
