document.addEventListener("DOMContentLoaded", () => {
    // Sidebar ripple effect (click)
    const sidebarItems = document.querySelectorAll(".navbar-nav .nav-item .nav-link")
    sidebarItems.forEach((item) => {
        item.addEventListener("click", function(e) {
            const ripple = document.createElement("div")
            const rect = this.getBoundingClientRect()
            ripple.className = "ripple"
            ripple.style.left = `${e.clientX - rect.left}px`
            ripple.style.top = `${e.clientY - rect.top}px`
            this.appendChild(ripple)
            setTimeout(() => ripple.remove(), 600)
        })
    })

    // Submenu toggle
    const submenuToggles = document.querySelectorAll(".has-submenu > a")
    submenuToggles.forEach((toggle) => {
        toggle.addEventListener("click", function(e) {
            e.preventDefault()
            const parent = this.parentElement
            const submenu = parent.querySelector(".submenu")
            if (parent.classList.contains("submenu-active")) {
                parent.classList.remove("submenu-active")
                submenu.style.maxHeight = "0px"
            } else {
                parent.classList.add("submenu-active")
                submenu.style.maxHeight = submenu.scrollHeight + "px"
            }
        })
    })

    // Card hover animation
    const cards = document.querySelectorAll(".card, .animate-card")
    cards.forEach((card) => {
        card.addEventListener("mouseenter", () => card.classList.add("card-hover"))
        card.addEventListener("mouseleave", () => card.classList.remove("card-hover"))
    })

    // Counter animation
    const counters = document.querySelectorAll(".counter-value")
    counters.forEach((counter) => {
        const target = Number.parseInt(counter.getAttribute("data-count")) || 0
        const duration = 1500
        const step = Math.max(1, Math.ceil(target / (duration / 16)))
        let current = 0

        const updateCounter = () => {
            current += step
            if (current >= target) {
                counter.textContent = target.toLocaleString()
            } else {
                counter.textContent = current.toLocaleString()
                requestAnimationFrame(updateCounter)
            }
        }

        const observer = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting) {
                updateCounter()
                observer.disconnect()
            }
        })
        observer.observe(counter)
    })

    // Universal ripple effect for .btn
    const buttons = document.querySelectorAll(".btn")
    buttons.forEach((button) => {
        button.addEventListener("click", function(e) {
            const x = e.clientX - this.getBoundingClientRect().left
            const y = e.clientY - this.getBoundingClientRect().top
            const ripple = document.createElement("span")
            ripple.classList.add("ripple")
            ripple.style.left = `${x}px`
            ripple.style.top = `${y}px`
            this.appendChild(ripple)
            setTimeout(() => ripple.remove(), 600)
        })
    })

    // Tooltip initialization
    const bootstrap = window.bootstrap // Declare bootstrap variable
    if (bootstrap) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map((el) => new bootstrap.Tooltip(el))

        // Popover initialization
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        popoverTriggerList.map((el) => new bootstrap.Popover(el))

        // Auto hide alerts
        const alerts = document.querySelectorAll(".alert:not(.alert-permanent)")
        alerts.forEach((alert) => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert)
                bsAlert.close()
            }, 5000)
        })
    }

    // Set active sidebar link
    const currentPath = window.location.pathname
    const sidenavLinks = document.querySelectorAll(".sidenav .nav-link")
    sidenavLinks.forEach((link) => {
        const href = link.getAttribute("href")
        if (href && currentPath.includes(href) && href !== "/") {
            link.classList.add("active")
        }
    })

    // Fade-in animation
    const fadeElements = document.querySelectorAll(".fade-in")
    fadeElements.forEach((el, index) => {
        el.style.opacity = "0"
        setTimeout(
            () => {
                el.style.opacity = "1"
            },
            100 * (index + 1),
        )
    })

    // Fix icon centering in sidebar
    const iconShapes = document.querySelectorAll(".icon-shape")
    iconShapes.forEach((icon) => {
        icon.style.display = "flex"
        icon.style.alignItems = "center"
        icon.style.justifyContent = "center"
    })

    // Add pulse animation to notification badge
    const notificationBadge = document.querySelector(".notification-badge")
    if (notificationBadge) {
        notificationBadge.classList.add("pulse")
    }

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function(e) {
            e.preventDefault()
            const targetId = this.getAttribute("href")
            if (targetId === "#") return
            const targetElement = document.querySelector(targetId)
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                })
            }
        })
    })

    // Initialize AOS animations
    const AOS = window.AOS // Declare AOS variable
    if (AOS) {
        AOS.init({
            duration: 800,
            easing: "ease-in-out",
            once: true,
        })
    }

    // Check for flash messages and display them
    const flashMessages = window.flashMessages // Declare flashMessages variable
    if (flashMessages) {
        for (const type in flashMessages) {
            if (flashMessages[type]) {
                showToast(flashMessages[type], type)
            }
        }
    }

    // Create flash messages container if it doesn't exist
    if (!document.getElementById("flash-messages-container")) {
        const container = document.createElement("div")
        container.id = "flash-messages-container"
        container.className = "flash-container"
        document.body.appendChild(container)
    }
})

// Format date utility
function formatDate(dateString, locale = "id-ID") {
    const date = new Date(dateString)
    return date.toLocaleDateString(locale, {
        day: "2-digit",
        month: "short",
        year: "numeric",
    })
}

// SweetAlert confirmation dialog
const Swal = window.Swal // Declare Swal variable
function showConfirmation(options = {}) {
    const defaultOptions = {
        title: "Apakah Anda yakin?",
        text: "Tindakan ini tidak dapat dibatalkan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya",
        cancelButtonText: "Batal",
    }
    const mergedOptions = {...defaultOptions, ...options }
    return Swal.fire(mergedOptions)
}

// SweetAlert toast notification
function showToast(message, type = "success") {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer)
            toast.addEventListener("mouseleave", Swal.resumeTimer)
        },
        customClass: {
            container: "swal-toast-container",
            popup: "swal-toast-popup",
        },
    })

    Toast.fire({
        icon: type,
        title: message,
    })
}

// Display Bootstrap alert
function showAlert(message, type = "success") {
    const container = document.getElementById("flash-messages-container")
    if (!container) return

    const alertDiv = document.createElement("div")
    alertDiv.className = `alert alert-${type} alert-dismissible alert-floating fade show`
    alertDiv.innerHTML = `
          ${message}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      `

    container.appendChild(alertDiv)

    // Auto remove after 5 seconds
    setTimeout(() => {
        alertDiv.classList.remove("show")
        setTimeout(() => alertDiv.remove(), 300)
    }, 5000)
}