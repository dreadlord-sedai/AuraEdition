/* AUTH */

function logout() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;
            if (response == "success") {
                window.location = "/Projects/AuraEdition/index.php";
            }
        }
    }
    request.open("POST", "/Projects/AuraEdition/process/logoutProcess.php", true);
    request.send();
}

/* AUTH */


/* USER FLOW */
function buyNow(id) {
    // Get quantity from input field with id 'quantity'
    var quantityInput = document.getElementById('quantity');
    var quantity = quantityInput ? parseInt(quantityInput.value) : 1;
    if (isNaN(quantity) || quantity < 1) {
        quantity = 1;
    }

    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            console.log("Response status:", request.status);
            console.log("Response text:", request.responseText);
            if (request.status == 200) {
                var response = request.responseText.trim();
                if (response === "success") {
                    window.location = "/Projects/AuraEdition/pages/checkout.php";
                } else {
                    alert("Buy Now failed: " + response);
                }
            } else {
                alert("Request failed with status " + request.status);
            }
        }
    }
    request.open("POST", "/Projects/AuraEdition/process/buyNowProcess.php", true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send("id=" + encodeURIComponent(id) + "&quantity=" + encodeURIComponent(quantity));
}

document.getElementById('cancelBtn')?.addEventListener('click', clearCheckout);

// Setup unload handler to clear cart if user leaves checkout page without cancel or pay
function setupCheckoutUnloadHandler() {
    let actionClicked = false;

    document.getElementById('cancelBtn')?.addEventListener('click', () => {
        actionClicked = true;
    });

    document.getElementById('payBtn')?.addEventListener('click', () => {
        actionClicked = true;
    });

    window.addEventListener('beforeunload', (event) => {
        // Only clear cart if navigating away, not on reload or back/forward
        if (!actionClicked) {
            if (performance.getEntriesByType('navigation')[0]?.type === 'reload') {
                console.log('Page reload detected, not clearing cart');
                return;
            }
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/Projects/AuraEdition/process/clearCartProcess.php", false);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send();
        }
    });
}

// Call the setup function on page load if on checkout page
if (window.location.pathname.endsWith('/pages/checkout.php')) {
    setupCheckoutUnloadHandler();
    setupQuantityButtons();
}

// Call the setup function on page load if on cart page
if (window.location.pathname.endsWith('/pages/cart.php')) {
    setupCartPageQuantityButtons();
}

// This function is specifically for the cart page for dynamic updates
function setupCartPageQuantityButtons() {
    document.querySelectorAll('.cart-item-row .btn-plus, .cart-item-row .btn-minus').forEach(button => {
        button.addEventListener('click', async (event) => {
            const vehicleId = event.currentTarget.dataset.vehicleId;
            const action = event.currentTarget.classList.contains('btn-plus') ? 'increment' : 'decrement';

            try {
                const response = await fetch('/Projects/AuraEdition/process/updateCartQuantity.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ vehicle_id: vehicleId, action: action })
                });

                const result = await response.json();

                if (result.success) {
                    // Update the quantity display on the page
                    const quantityElement = document.getElementById(`quantity-${vehicleId}`);
                    if (quantityElement) {
                        quantityElement.textContent = result.newQuantity;
                    }
                    // Recalculate and update the total price
                    updateCartTotal();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Failed to update quantity:', error);
                alert('An error occurred. Please try again.');
            }
        });
    });
}

function updateCartTotal() {
    const cartTotalElement = document.getElementById('cart-total-price');
    if (!cartTotalElement) return;

    let newTotal = 0;
    document.querySelectorAll('.cart-item-row').forEach(itemRow => {
        const price = parseFloat(itemRow.dataset.price);
        const quantity = parseInt(itemRow.querySelector('.quantity-display').textContent);
        if (!isNaN(price) && !isNaN(quantity)) {
            newTotal += price * quantity;
        }
    });

    cartTotalElement.textContent = '$' + newTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Clear Checkout cart
function clearCheckout() {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var response = request.responseText.trim();
                if (response === "success") {
                    window.location = "/Projects/AuraEdition/products/listings.php";
                } else {
                    alert("Clear cart failed: " + response);
                }
            } else {
                alert("Request failed with status " + request.status);
            }
        }
    }
    request.open("POST", "/Projects/AuraEdition/process/clearCartProcess.php", true);
    request.send();
}

function pay() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            console.log("Pay response status:", request.status);
            console.log("Pay response text:", request.responseText);
            if (request.status == 200) {
                var response = request.responseText.trim();
                if (response === "success") {
                    window.location = "/Projects/AuraEdition/pages/invoice.php";
                } else if (response === "Error: User not logged in") {
                    alert("You must be logged in to complete the payment.");
                    window.location = "/Projects/AuraEdition/auth/login.php";
                } else {
                    alert("Payment Failed!");
                }
            } else {
                alert("Payment request failed with status " + request.status);
            }
        }
    }
    request.open("POST", "/Projects/AuraEdition/process/purchaseProcess.php", true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send();
}

/* USER FLOW */

// Quantity buttons functionality
function setupQuantityButtons() {
    // Attach event listeners to all minus buttons
    document.querySelectorAll('.btn-minus').forEach(button => {
        button.addEventListener('click', () => {
            const vehicleId = button.dataset.vehicleId;
            const quantityElem = document.getElementById('quantity-' + vehicleId);
            let quantity = parseInt(quantityElem.textContent);
            if (quantity > 1) {
                quantity--;
                updateQuantity(cart_item_id, quantity, quantityElem);
            }
        });
    });

    // Attach event listeners to all plus buttons
    document.querySelectorAll('.btn-plus').forEach(button => {
        button.addEventListener('click', () => {
            const vehicleId = button.dataset.vehicleId;
            const quantityElem = document.getElementById('quantity-' + vehicleId);
            let quantity = parseInt(quantityElem.textContent);
            quantity++;
            updateQuantity(cart_item_id, quantity, quantityElem);
        });
    });
}

function updateQuantity(cart_item_id, quantity, quantityElem) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var response = request.responseText.trim();
                if (response === "success") {
                    quantityElem.textContent = quantity;
                    // Optionally, refresh the page or update total price dynamically here
                    location.reload();
                } else {
                    alert("Update quantity failed: " + response);
                }
            } else {
                alert("Request failed with status " + request.status);
            }
        }
    }
    request.open("POST", "/Projects/AuraEdition/process/updateQuantityProcess.php", true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send("id=" + encodeURIComponent(cart_item_id) + "&quantity=" + encodeURIComponent(quantity));
}

/* USER FLOW */



/* CART */
function removeFromCart(id) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var response = request.responseText.trim();
                if (response === "success") {
                    location.reload();
                } else {
                    alert("Remove from cart failed: " + response);
                }
            } else {
                alert("Request failed with status " + request.status);
            }
        }
    }
    request.open("POST", "/Projects/AuraEdition/process/removeFromCartProcess.php", true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send("id=" + encodeURIComponent(id));
}

function setupCartPageQuantityButtons() {
    document.querySelectorAll('.cart-item-row .btn-plus, .cart-item-row .btn-minus').forEach(button => {
        button.addEventListener('click', async (event) => {
            const vehicleId = event.currentTarget.dataset.vehicleId;
            const action = event.currentTarget.classList.contains('btn-plus') ? 'increment' : 'decrement';

            // Use FormData for compatibility with PHP $_POST
            const formData = new URLSearchParams();
            formData.append('vehicle_id', vehicleId);
            formData.append('action', action);

            try {
                const response = await fetch('/Projects/AuraEdition/process/updateCartQuantity.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    // Update the quantity display on the page
                    const quantityElement = document.getElementById(`quantity-${vehicleId}`);
                    if (quantityElement) {
                        quantityElement.textContent = result.newQuantity;
                    }
                    // Recalculate and update the total price
                    updateCartTotal();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Failed to update quantity:', error);
                alert('An error occurred. Please try again.');
            }
        });
    });
}
/* CART */
