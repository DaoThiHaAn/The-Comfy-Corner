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
    if (searchInput !== "") {
        params.append("search", searchInput);
    }
    if (sortSelect !== "" && sortSelect !== "none") {
        params.append("sort", sortSelect);
    }
    categories.forEach(cat => params.append("category[]", cat));

    // Update the browser's URL without reloading the page
    const newUrl = window.location.pathname + "?page=products&" + params.toString();
    history.replaceState(null, "", newUrl);

    // Fetch products from the server
    fetch("pages/products_ajax.php?" + params.toString())
    .then(response => response.json())
    .then(data => {
        // insert html code into the show screen
        document.querySelector(".result").innerHTML = data.total_result;
        document.querySelector(".product-list").innerHTML = data.products_html;
    })
    .catch(error => {
        console.error("Error loading products:", error);
    });
}

document.addEventListener("DOMContentLoaded", function () {
    loadProducts(); // Load all products by default
});

// Live search
document.getElementById("search-input").addEventListener("input", function() {
    loadProducts(); // Load products with the current search term
});

// Live filter
document.querySelectorAll("input[name='category[]']").forEach(checkbox => {
    checkbox.addEventListener("change", function() {
        loadProducts(); // Load products with the current filter
    });
});

// Show all btn
document.querySelector(".showall-btn").addEventListener("click", function() {
    // Reset search input and filters
    document.getElementById("search-input").value = "";
    document.querySelectorAll("input[name='category[]']").forEach(checkbox => {
        checkbox.checked = false;
    });
    loadProducts(); // Load products without any filters or search terms
}
);

// Handle pagination clicks
document.addEventListener("click", function (event) {
    if (event.target.classList.contains("pagination-link")) {
        event.preventDefault(); // Prevent default link behavior
        const page = event.target.getAttribute("data-page"); // Get the page number
        loadProducts(page); // Load the selected page
    }
});





