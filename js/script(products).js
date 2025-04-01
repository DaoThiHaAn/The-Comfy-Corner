var filtersort = document.querySelector(".filter-sort");
var filtericon = document.querySelector(".filter-icon");


// toggle sort and filter screen in responsive mode
document.getElementById("filter-icon").addEventListener("click", function() {
    // Toggle visibility
    filtersort.classList.toggle("active");
    filtericon.classList.toggle("active");

    filtericon.style.left = filtersort.offsetWidth + "px";
    var img = document.querySelector(".filter-icon img");
    if (img.src.includes("funnel.png")) {
        img.src = base_url + "images/filter-close.png";
        img.style.width = "20px";
    } else {
        img.src = base_url + "images/funnel.png";
        filtericon.style.left = "0";
    }
})

