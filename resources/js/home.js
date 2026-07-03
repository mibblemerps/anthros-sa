import EmblaCarousel from 'embla-carousel'
import AutoScroll from "embla-carousel-auto-scroll";

function setupCarousel(el) {
    const viewportNode = el.querySelector('.embla__viewport');

    const emblaApi = EmblaCarousel(viewportNode, { loop: true }, [AutoScroll({
        startDelay: 0,
        speed: 1.5,
        stopOnMouseEnter: true,
        stopOnInteraction: false,
    })]);

    emblaApi.plugins().autoplay?.play()
}


document.addEventListener('DOMContentLoaded', () => {
    const carousels = document.getElementsByClassName('embla')
    for (const el of carousels) {
        setupCarousel(el);
    }
})
