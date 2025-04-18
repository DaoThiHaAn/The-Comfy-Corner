document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelector(".slides");
    const originalSlides = slides.children;
    const totalRealSlides = originalSlides.length;

    // Duplicate the first slide and append it to the end
    const firstSlideClone = originalSlides[0].cloneNode(true);
    slides.appendChild(firstSlideClone);

    let index = 0;
    let interval;

    function goToSlide(i) {
        slides.style.transition = "transform 1s ease";
        slides.style.transform = `translateX(-${i * 100}vw)`;
    }

    function startSlider() {
        interval = setInterval(() => {
            index++;
            goToSlide(index);

            // Reset to the first slide when reaching the cloned slide
            if (index === totalRealSlides) {
                setTimeout(() => {
                    slides.style.transition = "none"; // Disable transition
                    slides.style.transform = `translateX(0)`;
                    index = 0;
                }, 1000); // Match the transition duration
            }
        }, 5000); // Change slide every 5 seconds
    }

    startSlider();
});