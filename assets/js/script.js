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
    request.send("id=" + encodeURIComponent(id));
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
}

// Clear cart
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
                updateQuantity(vehicleId, quantity, quantityElem);
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
            updateQuantity(vehicleId, quantity, quantityElem);
        });
    });
}

function updateQuantity(vehicleId, quantity, quantityElem) {
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
    request.send("id=" + encodeURIComponent(vehicleId) + "&quantity=" + encodeURIComponent(quantity));
}

/* USER FLOW */
