import EmblaCarousel from 'embla-carousel'
import AutoScroll from "embla-carousel-auto-scroll";

const wrapperNode = document.querySelector('.embla')
const viewportNode = wrapperNode.querySelector('.embla__viewport')
const prevButtonNode = wrapperNode.querySelector('.embla__prev')
const nextButtonNode = wrapperNode.querySelector('.embla__next')

const emblaApi = EmblaCarousel(viewportNode, { loop: true }, [AutoScroll({
    startDelay: 0,
    speed: 1.5,
    stopOnMouseEnter: true,
    stopOnInteraction: false,
})])

document.addEventListener('DOMContentLoaded', () => {
    emblaApi.plugins().autoplay?.play()
})
