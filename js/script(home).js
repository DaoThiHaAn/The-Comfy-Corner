document.addEventListener("DOMContentLoaded", function() {
    const slides = document.querySelector(".slides");
    let slideNodes = slides.children;
    const totalSlides = slideNodes.length;
    
    // Clone the first slide and append it to the end.
    const clonedSlide = slideNodes[0].cloneNode(true);
    slides.appendChild(clonedSlide);
    
    let index = 0;
    
    function changeSlide() {
        index++;
        slides.style.transition = "transform 1s linear";
        slides.style.transform = `translateX(-${index * 100}%)`;
        
        // When reaching the cloned slide, reset to the beginning:
        if (index === totalSlides) {
            setTimeout(() => {
                slides.style.transition = "none"; // Remove transition
                index = 0;
                slides.style.transform = "translateX(0)";
            }, 1000);
        }
    }
    
    setInterval(changeSlide, 5000);
});