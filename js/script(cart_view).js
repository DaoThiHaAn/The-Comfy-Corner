// Update quantity
function updateQuantity(productId, quantityInput) {
    const quantity = quantityInput.value;

    fetch("pages/update_cart.php", {
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

// Remove item
function removeItem(productId, removeButton) {
    fetch("pages/update_cart.php", {
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

                // Update the total cart price
                updateCartSummary(data.totalCost);
            } else {
                alert(data.message);
            }
        })
        .catch((error) => {
            console.error("Error removing item:", error);
        });
}

// Update cart summary total
function updateCartSummary(totalCost) {
// Select the element that displays the total price
const totalPriceElement = document.querySelector(".cart-summary h2 span");

// Replace the old total price with the new one
totalPriceElement.innerText = totalCost.toLocaleString() + " VND";
}