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

/* USER FLOW */


/* CART */

/* CART */