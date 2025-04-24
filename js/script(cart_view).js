function updateQuantity(productId, quantityInput) {
    const quantity = quantityInput.value;

    fetch(base_url + "pages/update_cart.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `action=update_quantity&productId=${productId}&quantity=${quantity}`,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Update the individual total price
                const item = quantityInput.closest(".cart-item");
                const itemPriceElement = item.querySelector(".item-price");
                itemPriceElement.innerText = data.individualTotal.toLocaleString() + " VND";

                // Update the total cart price
                updateCartSummary(data.totalCost);
            } else {
                alert(data.message);
            }
        })
        .catch((error) => {
            console.error("Error updating quantity:", error);
        });
}

function removeItem(productId, removeButton) {
    fetch(base_url + "pages/update_cart.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `action=remove_item&productId=${productId}`,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Remove the item from the DOM
                const item = removeButton.closest(".cart-item");
                item.remove();

                updateCartSummary(data.totalCost);
            } else {
                alert(data.message);
            }
        })
        .catch((error) => {
            console.error("Error removing item:", error);
        });
}

function updateCartSummary(totalCost) {
    const totalPriceElement = document.querySelector(".cart-summary h2 span");
    totalPriceElement.innerText = totalCost.toLocaleString() + " VND";

    // Update the data-total-price attribute
    const cartSummary = document.querySelector(".cart-summary");
    cartSummary.setAttribute("data-total-price", totalCost);
}