import collapse from '@alpinejs/collapse'
import focus from '@alpinejs/focus'

Alpine.plugin(collapse)
Alpine.plugin(focus)

let sliders = document.querySelectorAll('.swiper');

sliders.forEach(slider => {
    let options = slider.getAttribute('data-swiper-options');
    try {
        options = JSON.parse(options.replace(/'/g, '"'));
    } catch (e) {
        console.error('Invalid JSON in data-swiper-options:', options);
        options = { loop: true };
    }
    const swiper = new Swiper(slider, options);
});

Livewire.on('swiperReinit', () => {
    // Wait for Livewire DOM patching to finish
    setTimeout(() => {
        document.querySelectorAll('.swiper').forEach((el) => {
            if (el.swiper) {
                el.swiper.destroy(true, true);
            }
            let options = el.getAttribute('data-swiper-options');
            try {
                options = JSON.parse(options.replace(/'/g, '"'));
            } catch (e) {
                console.error('Invalid JSON in data-swiper-options:', options);
                options = { loop: true };
            }
            const swiper = new Swiper(el, options);
            // Force update in case slides changed
            swiper.update();
        });
    }, 50); // 50ms delay to ensure DOM is ready
});