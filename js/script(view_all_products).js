function fetchProducts(page = 1) {
    const search = document.getElementById("search").value.trim();
    const category = document.getElementById("category").value;

    // Construct the URL dynamically, excluding empty parameters
    const urlParams = new URLSearchParams();
    if (search) urlParams.append("search", search);
    if (category) urlParams.append("category", category);
    urlParams.append("pagenum", page);

    const newUrl = `${base_url}view_all_products?${urlParams.toString()}`;
    window.history.pushState(null, "", newUrl);

    // Fetch products via AJAX
    fetch(`${base_url}pages/fetch_products_ajax.php?${urlParams.toString()}`)
        .then((response) => response.json())
        .then((data) => {
            if (data.html) {
                document.getElementById("products-table").innerHTML = data.html;
                document.getElementById("pagination").innerHTML = data.pagination;

                // Re-attach event listeners for pagination links
                attachPaginationListeners();
            } else {
                alert(data.message || "Failed to fetch products.");
            }
        })
        .catch((error) => {
            console.error("Error fetching products:", error);
        });
}

function attachPaginationListeners() {
    document.querySelectorAll(".pagination-link").forEach((link) => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const page = e.target.getAttribute("data-page");
            fetchProducts(page); // Pass the correct page number to fetchProducts
        });
    });
}

document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const search = urlParams.get("search") || ""; // Default to an empty string if no search term is specified
    const category = urlParams.get("category") || "all"; // Default to "all" if no category is specified
    const page = urlParams.get("pagenum") || 1; // Default to page 1 if no page number is specified

    document.getElementById("search").value = search; // Set the search input to the current search term
    document.getElementById("category").value = category; // Set the dropdown to the correct category
    fetchProducts(page); // Fetch products with the default or current category and page

    // Attach event listeners for pagination links
    attachPaginationListeners();
});