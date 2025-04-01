// Image preview
function openLightbox(imgage) {
    document.getElementById("lightbox-img").src = imgage.src;
    document.getElementById("lightbox").style.display = "flex";
}

function closeLightbox() {
    document.getElementById("lightbox").style.display = "none";
}


// Change quantity
function plus(event) {
    event.preventDefault(); // Prevent form submission
    var item = document.getElementById("quantity");
    item.value = parseInt(item.value) + 1;
}

function minus(event) {
    event.preventDefault(); // Prevent form submission
    var item = document.getElementById("quantity");
    if (item.value > 1) {
        item.value = parseInt(item.value) - 1;
    }
}
