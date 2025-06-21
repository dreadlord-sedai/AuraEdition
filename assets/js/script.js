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

// Clear cart
function clearCart() {
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

document.getElementById('cancelBtn')?.addEventListener('click', clearCart);

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

// Setup unload handler to clear cart if user leaves checkout page without cancel or pay
function setupCheckoutUnloadHandler() {
    let actionClicked = false;

    function setActionClicked() {
        console.log('Action button clicked');
        actionClicked = true;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const cancelBtn = document.getElementById('cancelBtn');
        const payBtn = document.getElementById('payBtn');

        if (cancelBtn) {
            cancelBtn.addEventListener('click', setActionClicked);
        }
        if (payBtn) {
            payBtn.addEventListener('click', setActionClicked);
        }
    });

    window.addEventListener('unload', (event) => {
        if (!actionClicked) {
            console.log('Page unload without action, clearing cart');
            if (navigator.sendBeacon) {
                navigator.sendBeacon("/Projects/AuraEdition/process/clearCartProcess.php");
            } else {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "/Projects/AuraEdition/process/clearCartProcess.php", false);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send();
            }
        } else {
            console.log('Page unload after action, not clearing cart');
        }
    });
}

// Call the setup function on page load if on checkout page
if (window.location.pathname.endsWith('/pages/checkout.php')) {
    setupCheckoutUnloadHandler();
}

/* USER FLOW */


/* CART */

/* CART */
