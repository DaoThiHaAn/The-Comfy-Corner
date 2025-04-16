document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelector(".slides");
    const originalSlides = slides.children;
    const totalRealSlides = originalSlides.length;

    function goToSlide(i, withTransition = true) {
        if (withTransition) {
            slides.style.transition = "transform 1s ease";
        } else {
            slides.style.transition = "none";
        }
        slides.style.transform = `translateX(-${i * 100}vw)`;
    }

    let index = 0;
    let interval;
    function startSlider() {
        interval = setInterval(() => {
            goToSlide(index);
            index++;
            if (index == totalRealSlides) {
                index = 0;
            }
        }, 5000);
    }

    startSlider();
});