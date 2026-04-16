class Carousel {
    constructor(el) {
        this.el = el;
        this.slides = Array.from(el.querySelectorAll('.hdm-carousel-slide'));
        this.dots = Array.from(el.querySelectorAll('.hdm-carousel-dots button'));
        this.current = 0;
        this.timer = null;
        this.autoplay = el.dataset.autoplay === 'true';
        this.interval = parseInt(el.dataset.interval || '5000', 10);

        el.querySelector('.hdm-carousel-prev')?.addEventListener('click', () => this.go(-1));
        el.querySelector('.hdm-carousel-next')?.addEventListener('click', () => this.go(1));
        this.dots.forEach((d, i) => d.addEventListener('click', () => this.show(i)));
        el.addEventListener('mouseenter', () => this.pause());
        el.addEventListener('mouseleave', () => this.play());

        if (this.autoplay && this.slides.length > 1) this.play();
    }
    show(idx) {
        const n = this.slides.length;
        if (!n) return;
        const target = ((idx % n) + n) % n;
        this.slides.forEach((s, i) => {
            s.classList.toggle('opacity-100', i === target);
            s.classList.toggle('opacity-0', i !== target);
            s.classList.toggle('pointer-events-none', i !== target);
        });
        this.dots.forEach((d, i) => {
            d.classList.toggle('bg-white', i === target);
            d.classList.toggle('bg-white/50', i !== target);
        });
        this.current = target;
    }
    go(delta) {
        this.show(this.current + delta);
    }
    play() {
        if (!this.autoplay || this.slides.length < 2) return;
        this.pause();
        this.timer = setInterval(() => this.go(1), this.interval);
    }
    pause() {
        if (this.timer) clearInterval(this.timer);
        this.timer = null;
    }
}

function init() {
    document.querySelectorAll('.hdm-carousel').forEach((el) => {
        if (el.__hdmCarousel) return;
        el.__hdmCarousel = new Carousel(el);
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}
