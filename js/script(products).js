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

    // Get selected categories from checkboxes
    const categoryCheckboxes = document.querySelectorAll("input[name='category[]']:checked");
    let categories = [];
    categoryCheckboxes.forEach(checkbox => {
        categories.push(checkbox.value);
    });

    // Update URL parameters
    let params = new URLSearchParams(window.location.search);
    params.set("pagenum", page);
    if (searchInput !== "") {
        params.set("search", searchInput);
    }
    if (sortSelect !== "" && sortSelect !== "none") {
        params.set("sort", sortSelect);
    }
    params.delete("category[]"); // Remove existing category[] parameters
    categories.forEach(cat => params.append("category[]", cat)); // Add selected categories

    // Update the browser's URL without reloading the page
    const newUrl = window.location.pathname + "?" + params.toString();
    history.replaceState(null, "", newUrl);

    // Fetch products from the server
    fetch(base_url + "pages/products_ajax.php?" + params.toString())
        .then(response => response.json())
        .then(data => {
            // Insert HTML code into the show screen
            document.querySelector(".result").innerHTML = data.total_result;
            document.querySelector(".product-list").innerHTML = data.products_html;
        })
        .catch(error => {
            console.error("Error loading products:", error);
        });
}

document.addEventListener("DOMContentLoaded", function () {
    // Check checkboxes based on URL parameters
    const params = new URLSearchParams(window.location.search);
    const selectedCategories = params.getAll("category[]");
    document.querySelectorAll("input[name='category[]']").forEach(checkbox => {
        if (selectedCategories.includes(checkbox.value)) {
            checkbox.checked = true;
        }
    });
    loadProducts(); // Load all products by default
});

// Live search
document.getElementById("search-input").addEventListener("input", function () {
    const searchInput = this.value.trim();

    // Update URL parameters
    const params = new URLSearchParams(window.location.search);
    if (searchInput === "") {
        params.delete("search"); // Remove the search parameter if the input is empty
    } else {
        params.set("search", searchInput); // Update the search parameter
    }
    params.set("pagenum", 1); // Reset to the first page when searching
    const newUrl = `${window.location.pathname}?${params.toString()}`;
    history.replaceState(null, "", newUrl);

    // Reload products with the current search term
    loadProducts();
});

// Live filter
document.querySelectorAll("input[name='category[]']").forEach(checkbox => {
    checkbox.addEventListener("change", function() {
        loadProducts(); // Load products with the current filter
    });
});

// Show all btn
document.querySelector(".showall-btn").addEventListener("click", function (e) {
    e.preventDefault(); // Prevent default button behavior

    // Reset search input and filters
    document.getElementById("search-input").value = "";
    document.querySelectorAll("input[name='category[]']").forEach((checkbox) => {
        checkbox.checked = false;
    });

    // Reset URL parameters
    const params = new URLSearchParams();
    params.set("pagenum", 1); // Reset to the first page
    const newUrl = `${window.location.pathname}?${params.toString()}`;
    history.replaceState(null, "", newUrl);

    // Reload products with default filters
    loadProducts();
});

document.addEventListener("click", function (event) {
    if (event.target.classList.contains("pagination-link") || event.target.closest(".pagination-link")) {
        event.preventDefault(); // Prevent default link behavior
        const page = event.target.closest(".pagination-link").getAttribute("data-page"); // Get the page number
        loadProducts(page); // Load the selected page
    }
});

function addToCart(productId) {
    // Dynamically get the quantity input field based on the product ID
    const quantityInput = document.getElementById(`quantity-${productId}`);
    const quantity = quantityInput ? parseInt(quantityInput.value) : 1; // Default to 1 if input is not found

    // Validate the quantity
    if (isNaN(quantity) || quantity < 1) {
        alert("Please enter the quantity number greater than 0.");
        return;
    }

    fetch(base_url + "pages/add2cart_ajax.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `productId=${productId}&quantity=${quantity}`,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert(data.message); // Show success message
            } else {
                alert(data.message); // Show error message
            }
        })
        .catch((error) => {
            console.error("Error adding to cart:", error);
            alert("An error occurred while adding the product to the cart.");
        });
}

