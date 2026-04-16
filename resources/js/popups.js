const STORAGE_PREFIX = 'hdm-popup-';

function hasBeenShown(id, frequency) {
    if (frequency === 'always') return false;
    const key = STORAGE_PREFIX + id;
    if (frequency === 'session') {
        return sessionStorage.getItem(key) === '1';
    }
    return localStorage.getItem(key) === '1';
}

function markShown(id, frequency) {
    const key = STORAGE_PREFIX + id;
    if (frequency === 'session') {
        sessionStorage.setItem(key, '1');
    } else if (frequency === 'once') {
        localStorage.setItem(key, '1');
    }
}

function showPopup(el) {
    el.classList.remove('hidden');
    const id = el.dataset.popupId;
    const frequency = el.dataset.frequency || 'always';
    markShown(id, frequency);
    document.body.style.overflow = 'hidden';
}

function hidePopup(el) {
    el.classList.add('hidden');
    document.body.style.overflow = '';
}

function wirePopup(el) {
    const id = el.dataset.popupId;
    const trigger = el.dataset.triggerType || 'time';
    const value = parseInt(el.dataset.triggerValue || '5', 10);
    const frequency = el.dataset.frequency || 'always';

    el.querySelectorAll('.hdm-popup-close').forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            hidePopup(el);
        });
    });
    el.addEventListener('click', (e) => {
        if (e.target === el) hidePopup(el);
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !el.classList.contains('hidden')) hidePopup(el);
    });
    document.querySelectorAll(`[data-popup-trigger="${id}"]`).forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            showPopup(el);
        });
    });

    if (hasBeenShown(id, frequency)) return;
    if (trigger === 'manual') return;

    if (trigger === 'time') {
        setTimeout(() => showPopup(el), Math.max(0, value) * 1000);
        return;
    }
    if (trigger === 'scroll') {
        let fired = false;
        const pct = Math.max(1, Math.min(100, value));
        const handler = () => {
            if (fired) return;
            const scrollPct = (window.scrollY + window.innerHeight) / document.body.scrollHeight * 100;
            if (scrollPct >= pct) {
                fired = true;
                showPopup(el);
                window.removeEventListener('scroll', handler);
            }
        };
        window.addEventListener('scroll', handler, { passive: true });
        return;
    }
    if (trigger === 'exit_intent') {
        let fired = false;
        const handler = (e) => {
            if (fired) return;
            if (e.clientY < 10) {
                fired = true;
                showPopup(el);
                document.removeEventListener('mouseleave', handler);
            }
        };
        document.addEventListener('mouseleave', handler);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.hdm-popup').forEach(wirePopup);
});
