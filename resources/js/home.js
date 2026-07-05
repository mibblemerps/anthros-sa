import EmblaCarousel from 'embla-carousel'
import AutoScroll from "embla-carousel-auto-scroll";

let reverse = false;

function setupCarousel(el) {
    const viewportNode = el.querySelector('.embla__viewport');

    const emblaApi = EmblaCarousel(viewportNode, { loop: true }, [AutoScroll({
        startDelay: 0,
        speed: 0.5 * (reverse ? 1 : -1),
        stopOnMouseEnter: false,
        stopOnInteraction: false,
    })]);

    emblaApi.plugins().autoplay?.play()

    // reverse the next carousel
    reverse = !reverse;
}


document.addEventListener('DOMContentLoaded', () => {
    const carousels = document.getElementsByClassName('embla')
    for (const el of carousels) {
        setupCarousel(el);
    }
})
