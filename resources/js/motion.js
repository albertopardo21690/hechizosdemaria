const supportsIO = 'IntersectionObserver' in window;

function apply(el) {
    const delay = parseInt(el.dataset.motionDelay || '0', 10);
    const duration = parseInt(el.dataset.motionDuration || '700', 10);
    el.style.transitionDuration = duration + 'ms';
    if (delay > 0) el.style.transitionDelay = delay + 'ms';
    el.classList.add('is-visible');
}

function init() {
    const els = document.querySelectorAll('[data-motion]');
    if (!els.length) return;
    if (!supportsIO) {
        els.forEach(apply);
        return;
    }
    const io = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                apply(entry.target);
                io.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
    els.forEach((el) => io.observe(el));
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}
