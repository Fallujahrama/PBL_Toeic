// Sidebar animation and interaction effects
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar menu item hover and click animations
    const sidebarItems = document.querySelectorAll('.navbar-nav .nav-item .nav-link');

    sidebarItems.forEach(item => {
        // Add ripple effect on click
        item.addEventListener('click', function(e) {
            const ripple = document.createElement('div');
            const rect = this.getBoundingClientRect();

            ripple.className = 'ripple';
            ripple.style.left = `${e.clientX - rect.left}px`;
            ripple.style.top = `${e.clientY - rect.top}px`;

            this.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Submenu toggle animation
    const submenuToggles = document.querySelectorAll('.has-submenu > a');
    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            const submenu = parent.querySelector('.submenu');

            if (parent.classList.contains('submenu-active')) {
                // Close submenu
                parent.classList.remove('submenu-active');
                submenu.style.maxHeight = '0px';
            } else {
                // Open submenu
                parent.classList.add('submenu-active');
                submenu.style.maxHeight = submenu.scrollHeight + 'px';
            }
        });
    });

    // Card animations
    const cards = document.querySelectorAll('.animate-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('card-hover');
        });

        card.addEventListener('mouseleave', function() {
            this.classList.remove('card-hover');
        });
    });

    // Initialize counters
    const counters = document.querySelectorAll('.counter-value');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-count'));
        const duration = 1500;
        const step = Math.ceil(target / (duration / 16)); // 60fps

        let current = 0;
        const updateCounter = () => {
            current += step;
            if (current >= target) {
                counter.textContent = target;
            } else {
                counter.textContent = current;
                requestAnimationFrame(updateCounter);
            }
        };

        const observer = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting) {
                updateCounter();
                observer.disconnect();
            }
        });

        observer.observe(counter);
    });
});