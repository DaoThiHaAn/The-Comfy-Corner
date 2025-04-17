const { elements } = require("chart.js");

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

// AJAX SEARCH + FILTER
function loadProducts(page = 1) {
    const searchInput = document.getElementById("search-input").value.trim();
    const sortSelect = document.querySelector("select[name='sort']").value;

    // get selected categories from checkboxes
    const categoryCheckboxes = document.querySelectorAll("input[name='category[]']:checked");
    let categories = [];
    categoryCheckboxes.forEach(checkbox => {
        categories.push(checkbox.value);
    });

    // Update URL parameters
    let params = new URLSearchParams();
    params.append("pagenum", page);
    params.append("search", searchInput);
    params.append("sort", sortSelect);
    categories.forEach(cat => params.append("category[]", cat));

    // Fetch products from the server
    fetch("pages/products_ajax.php?" + params.toString())
    .then(response => response.text())
    .then(html => {
        // insert html code into the show screen
        document.querySelector(".product-list").innerHTML = html;
    })
    .catch(error => {
        console.error("Error loading products:", error);
    });
}

// Live search
document.getElementById("search-input").addEventListener("input", function() {
    loadProducts(); // Load products with the current search term
});

// Live filter
document.querySelectorAll("input[name='category[]']").forEach(elements => {
    checkbox.addEventListener("change", function() {
        loadProducts(); // Load products with the current filter
    });
});

// Prevent default form submission and use AJAX instead:
document.getElementById("search-form").addEventListener("submit", function(e) {
    e.preventDefault();
    loadProducts();
});






