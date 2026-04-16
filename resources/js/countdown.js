function tick(el) {
    const dueStr = el.dataset.due;
    if (!dueStr) return;
    const due = new Date(dueStr).getTime();
    const now = Date.now();
    let diff = Math.max(0, due - now);
    if (diff === 0) {
        const expireText = el.dataset.expireText || '';
        el.innerHTML = `<div class="text-2xl font-heading text-pink-600">${expireText}</div>`;
        return false;
    }
    const days = Math.floor(diff / 86400000); diff -= days * 86400000;
    const hours = Math.floor(diff / 3600000); diff -= hours * 3600000;
    const minutes = Math.floor(diff / 60000); diff -= minutes * 60000;
    const seconds = Math.floor(diff / 1000);
    const pad = (n) => String(n).padStart(2, '0');
    const d = el.querySelector('.hdm-cd-days');
    const h = el.querySelector('.hdm-cd-hours');
    const m = el.querySelector('.hdm-cd-minutes');
    const s = el.querySelector('.hdm-cd-seconds');
    if (d) d.textContent = pad(days);
    if (h) h.textContent = pad(hours);
    if (m) m.textContent = pad(minutes);
    if (s) s.textContent = pad(seconds);
    return true;
}

function initCountdowns() {
    document.querySelectorAll('.hdm-countdown').forEach((el) => {
        if (!tick(el)) return;
        const handle = setInterval(() => {
            if (!tick(el)) clearInterval(handle);
        }, 1000);
    });
}

function initProgressBars() {
    if (!('IntersectionObserver' in window)) {
        document.querySelectorAll('.hdm-progress-bar').forEach((el) => {
            el.style.width = (el.dataset.target || 0) + '%';
        });
        return;
    }
    const io = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.style.width = (entry.target.dataset.target || 0) + '%';
                io.unobserve(entry.target);
            }
        });
    }, { threshold: 0.3 });
    document.querySelectorAll('.hdm-progress-bar').forEach((el) => io.observe(el));
}

function init() {
    initCountdowns();
    initProgressBars();
}

if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
else init();
