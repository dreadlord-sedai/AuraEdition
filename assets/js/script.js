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

document.getElementById('cancelBtn')?.addEventListener('click', function() {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var response = request.responseText.trim();
                if (response === "success") {
                    window.location = "/Projects/AuraEdition/pages/listings.php";
                } else {
                    alert("Cancel failed: " + response);
                }
            } else {
                alert("Request failed with status " + request.status);
            }
        }
    }
    request.open("POST", "/Projects/AuraEdition/process/clearCartProcess.php", true);
    request.send();
});

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

/* USER FLOW */


/* CART */

/* CART */