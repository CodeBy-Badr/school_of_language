// ===========================
// UTILITY FUNCTIONS
// ===========================

const DOMElements = {
    hamburger: document.querySelector('.hamburger'),
    navMenu: document.querySelector('.nav-menu'),
    navLinks: document.querySelectorAll('.nav-link'),
    contactForm: document.getElementById('contactForm'),
    formMessage: document.getElementById('formMessage'),
};

// ===========================
// MOBILE MENU TOGGLE
// ===========================

const toggleMobileMenu = () => {
    DOMElements.navMenu.classList.toggle('active');
};

const closeMobileMenu = () => {
    DOMElements.navMenu.classList.remove('active');
};

DOMElements.hamburger?.addEventListener('click', toggleMobileMenu);

DOMElements.navLinks.forEach(link => {
    link.addEventListener('click', closeMobileMenu);
});

// ===========================
// SMOOTH SCROLLING
// ===========================

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth' });
        }
    });
});

// ===========================
// FORM VALIDATION & SUBMISSION
// ===========================

const validateEmail = (email) => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
};

const validatePhone = (phone) => {
    const phoneRegex = /^[0-9\s\-\+\(\)]{0,}$/;
    return phone === '' || phoneRegex.test(phone);
};

const showMessage = (message, isSuccess = true) => {
    DOMElements.formMessage.textContent = message;
    DOMElements.formMessage.className = `form-message ${isSuccess ? 'success' : 'error'}`;
    
    setTimeout(() => {
        DOMElements.formMessage.className = 'form-message';
    }, 5000);
};

const resetForm = () => {
    DOMElements.contactForm.reset();
};

DOMElements.contactForm?.addEventListener('submit', async function (e) {
    e.preventDefault();

    // Get form values
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const subject = document.getElementById('subject').value;
    const message = document.getElementById('message').value.trim();

    // Validation
    if (!name) {
        showMessage('Veuillez entrer votre nom', false);
        return;
    }

    if (!email || !validateEmail(email)) {
        showMessage('Veuillez entrer une adresse email valide', false);
        return;
    }

    if (!validatePhone(phone)) {
        showMessage('Numéro de téléphone invalide', false);
        return;
    }

    if (!subject) {
        showMessage('Veuillez sélectionner un sujet', false);
        return;
    }

    if (!message) {
        showMessage('Veuillez entrer votre message', false);
        return;
    }

    // Prepare FormData for submission
    const formData = new FormData();
    formData.append('name', name);
    formData.append('email', email);
    formData.append('phone', phone);
    formData.append('subject', subject);
    formData.append('message', message);

    try {
        // Submit to PHP backend
        const response = await fetch('php/send-email.php', {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();

        if (result.success) {
            showMessage('Merci! Votre message a été envoyé avec succès. Nous vous répondrons bientôt.', true);
            resetForm();
        } else {
            showMessage(result.message || 'Une erreur est survenue. Veuillez réessayer.', false);
        }
    } catch (error) {
        console.error('Error:', error);
        showMessage('Une erreur est survenue lors de l\'envoi du message. Veuillez réessayer.', false);
    }
});

// ===========================
// SCROLL EFFECTS
// ===========================

const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px',
};

const observer = new IntersectionObserver(function (entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animation = 'fadeIn 0.6s ease forwards';
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observe service cards
document.querySelectorAll('.service-card').forEach(card => {
    observer.observe(card);
});

// Observe course cards
document.querySelectorAll('.course-card').forEach(card => {
    observer.observe(card);
});

// Observe testimonial cards
document.querySelectorAll('.testimonial-card').forEach(card => {
    observer.observe(card);
});

// ===========================
// COURSE CARD CLICK HANDLER
// ===========================

document.querySelectorAll('.course-card .btn-small').forEach(button => {
    button.addEventListener('click', function (e) {
        e.preventDefault();
        const courseTitle = this.closest('.course-card').querySelector('h3').textContent;
        document.getElementById('subject').value = `Inscription - ${courseTitle}`;
        document.getElementById('contact').scrollIntoView({ behavior: 'smooth' });
        document.getElementById('name').focus();
    });
});

// ===========================
// ACTIVE NAV LINK HIGHLIGHT
// ===========================

const highlightActiveNavLink = () => {
    const sections = document.querySelectorAll('section[id]');
    
    window.addEventListener('scroll', () => {
        let current = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            
            if (scrollY >= sectionTop - 200) {
                current = section.getAttribute('id');
            }
        });

        DOMElements.navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });
};

highlightActiveNavLink();

// ===========================
// DYNAMIC COUNTER ANIMATION (OPTIONAL)
// ===========================

const animateCounters = () => {
    const stats = document.querySelectorAll('.stat h3');
    const duration = 1500;
    
    const observerCounter = new IntersectionObserver(function (entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const stat = entry.target;
                const finalValue = parseInt(stat.textContent.replace(/\D/g, ''));
                const suffix = stat.textContent.replace(/\d/g, '').trim();
                
                let currentValue = 0;
                const increment = finalValue / (duration / 16);
                
                const counter = setInterval(() => {
                    currentValue += increment;
                    if (currentValue >= finalValue) {
                        currentValue = finalValue;
                        clearInterval(counter);
                    }
                    stat.textContent = Math.floor(currentValue) + suffix;
                }, 16);
                
                observerCounter.unobserve(stat);
            }
        });
    }, observerOptions);
    
    stats.forEach(stat => {
        observerCounter.observe(stat);
    });
};

animateCounters();

// ===========================
// ACCESSIBILITY - KEYBOARD NAVIGATION
// ===========================

document.addEventListener('keydown', (e) => {
    // Close mobile menu on Escape key
    if (e.key === 'Escape') {
        closeMobileMenu();
    }
});

// ===========================
// FORM INPUT FOCUS EFFECTS
// ===========================

const formInputs = document.querySelectorAll('.form-group input, .form-group select, .form-group textarea');

formInputs.forEach(input => {
    input.addEventListener('focus', function () {
        this.style.borderColor = 'var(--primary-color)';
    });
    
    input.addEventListener('blur', function () {
        this.style.borderColor = 'var(--light-bg)';
    });
});

// ===========================
// LOADING STATE MANAGEMENT
// ===========================

const setFormLoading = (isLoading) => {
    const submitBtn = DOMElements.contactForm.querySelector('.btn-primary');
    if (isLoading) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Envoi en cours...';
    } else {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Envoyer le Message';
    }
};

// ===========================
// INITIALIZATION
// ===========================

console.log('Site École des Langues chargé avec succès');
