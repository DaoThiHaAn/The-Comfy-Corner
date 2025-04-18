function fetchProducts(page = 1) {
    const search = document.getElementById("search").value;
    const category = document.getElementById("category").value;

    fetch(`pages/fetch_products_ajax.php?search=${encodeURIComponent(search)}&category=${category}&page=${page}`)
        .then((response) => response.json())
        .then((data) => {
            // Update the products table
            document.getElementById("products-table").innerHTML = data.html;

            // Update the pagination
            document.getElementById("pagination").innerHTML = data.pagination;

            // Add event listeners for pagination links
            document.querySelectorAll("#pagination a").forEach((link) => {
                link.addEventListener("click", (e) => {
                    e.preventDefault();
                    const page = e.target.getAttribute("data-page");
                    fetchProducts(page);
                });
            });
        })
        .catch((error) => {
            console.error("Error fetching products:", error);
        });
}

// Fetch products on page load
document.addEventListener("DOMContentLoaded", () => {
    fetchProducts();
});

// DELETE PRODUCT
function deleteProduct(event, productId) {
    event.preventDefault(); // Prevent the default link behavior

    if (confirm("Are you sure you want to delete this product?")) {
        fetch("pages/delete_product_ajax.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `product_id=${productId}`,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    alert(data.message); // Show success message
                    fetchProducts(); // Refresh the product list
                } else {
                    alert(data.message); // Show error message
                }
            })
            .catch((error) => {
                console.error("Error deleting product:", error);
                alert("An error occurred while deleting the product.");
            });
    }
}