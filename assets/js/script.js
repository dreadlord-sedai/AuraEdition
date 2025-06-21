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

document.getElementById('cancelBtn')?.addEventListener('click', clearCart);

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

function pay() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;
            if (response == "success") {
                window.location = "/Projects/AuraEdition/pages/invoice.php";
            } else {
                alert("Payment Failed!");
            }
        }
    }
    request.open("POST", "/Projects/AuraEdition/process/purchaseProcess.php", true);
    request.send();
}

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

/* USER FLOW */


/* CART */

/* CART */
