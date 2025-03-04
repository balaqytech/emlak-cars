import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import focus from '@alpinejs/focus'

Alpine.plugin(collapse)
Alpine.plugin(focus)

window.Alpine = Alpine

Alpine.start()

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