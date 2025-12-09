// Main JavaScript - site-wide helpers (kept minimal)

// If you need front-page-specific behavior, it's now in `assets/js/front-page.js`.

// Main JavaScript file

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

    // Smooth scroll for in-page anchors
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener('click', (e) => {
            const targetId = anchor.getAttribute('href');
            if (!targetId || targetId === '#') return;
            const target = document.querySelector(targetId);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Ripple effect on buttons / social icons / upload
    const rippleTargets = document.querySelectorAll('.btn-inscription, .social-icon, .btn-upload, .btn-ghost, .btn-register-primary');
    rippleTargets.forEach((el) => {
        el.style.position = el.style.position || 'relative';
        el.style.overflow = 'hidden';

        el.addEventListener('pointerdown', (e) => {
            const rect = el.getBoundingClientRect();
            const ripple = document.createElement('span');
            ripple.className = 'ripple';
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            ripple.style.width = ripple.style.height = `${size}px`;
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            el.appendChild(ripple);
            setTimeout(() => ripple.remove(), 450);
        });
    });

    // Password visibility toggles
    const toggleButtons = document.querySelectorAll('[data-toggle-password]');
    toggleButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const targetId = btn.getAttribute('data-toggle-password');
            const input = document.getElementById(targetId);
            if (!input) return;
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            btn.classList.toggle('is-active', isHidden);
        });
    });

    // Avatar preview
    const avatarInput = document.getElementById('avatar_file');
    const avatarPlaceholder = document.getElementById('avatarPlaceholder');
    const avatarPreviewImg = document.getElementById('avatarPreviewImg');
    if (avatarInput) {
        avatarInput.addEventListener('change', (e) => {
            const file = e.target.files && e.target.files[0];
            if (!file) return;
            const url = URL.createObjectURL(file);
            if (avatarPreviewImg) {
                avatarPreviewImg.src = url;
                avatarPreviewImg.style.display = 'block';
            } else if (avatarPlaceholder) {
                const img = document.createElement('img');
                img.id = 'avatarPreviewImg';
                img.src = url;
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover';
                avatarPlaceholder.replaceWith(img);
            }
        });
    }
});

