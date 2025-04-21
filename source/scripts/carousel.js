let current_slide = 0;

const slideContainer = document.querySelector('.slide-container');
const carouselWrapper = document.querySelector('.carousel-wrapper');
const slides = document.querySelectorAll('.slide');

document.getElementById("next-button").onclick = () => {
    if (current_slide < slides.length - 1) current_slide++;
    updateSlide();
};

document.getElementById("prev-button").onclick = () => {
    if (current_slide > 0) current_slide--;
    updateSlide();
};

function updateSlide() {
    const slideWidth = slides[0].offsetWidth + 15;
    slideContainer.style.transform = `translateX(-${current_slide * slideWidth}px)`;
}
