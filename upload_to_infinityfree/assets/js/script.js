/* AUTH */

function logout() {
  var request = new XMLHttpRequest();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var response = request.responseText;
      if (response == "success") {
        window.location = "/index.php";
      }
    }
  };
  request.open("POST", "/process/logoutProcess.php", true);
  request.send();
}

/* AUTH */

/* USER FLOW */
function buyNow(id, quantity) {
  if (!quantity || isNaN(quantity) || quantity < 1) {
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
          window.location = "/pages/checkout.php";
        } else {
          alert("Buy Now failed: " + response);
        }
      } else {
        alert("Request failed with status " + request.status);
      }
    }
  };
  request.open("POST", "/process/buyNowProcess.php", true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  request.send(
    "id=" + encodeURIComponent(id) + "&quantity=" + encodeURIComponent(quantity)
  );
}

document.getElementById("cancelBtn")?.addEventListener("click", clearCheckout);

// Setup unload handler to clear cart if user leaves checkout page without cancel or pay
function setupCheckoutUnloadHandler() {
  let actionClicked = false;

  document.getElementById("cancelBtn")?.addEventListener("click", () => {
    actionClicked = true;
  });

  document.getElementById("payBtn")?.addEventListener("click", () => {
    actionClicked = true;
  });

  window.addEventListener("beforeunload", (event) => {
    // Only clear cart if navigating away, not on reload or back/forward
    if (!actionClicked) {
      if (performance.getEntriesByType("navigation")[0]?.type === "reload") {
        console.log("Page reload detected, not clearing cart");
        return;
      }
      var xhr = new XMLHttpRequest();
      xhr.open(
        "POST",
        "/process/clearCartProcess.php",
        false
      );
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.send();
    }
  });
}

// Call the setup function on page load if on checkout page
if (window.location.pathname.endsWith("/pages/checkout.php")) {
  setupCheckoutUnloadHandler();
  setupQuantityButtons();
}

// Call the setup function on page load if on cart page
if (window.location.pathname.endsWith("/pages/cart.php")) {
  setupCartPageQuantityButtons();
}

// This function is specifically for the cart page for dynamic updates
function setupCartPageQuantityButtons() {
  document
    .querySelectorAll(".cart-item-row .btn-plus, .cart-item-row .btn-minus")
    .forEach((button) => {
      button.addEventListener("click", async (event) => {
        const vehicleId = event.currentTarget.dataset.vehicleId;
        const action = event.currentTarget.classList.contains("btn-plus")
          ? "increment"
          : "decrement";

        try {
          const response = await fetch(
            "/process/updateCartQuantity.php",
            {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
              },
              body: JSON.stringify({ vehicle_id: vehicleId, action: action }),
            }
          );

          const result = await response.json();

          if (result.success) {
            // Update the quantity display on the page
            const quantityElement = document.getElementById(
              `quantity-${vehicleId}`
            );
            if (quantityElement) {
              quantityElement.textContent = result.newQuantity;
            }
            // Recalculate and update the total price
            updateCartTotal();
          } else {
            alert("Error: " + result.message);
          }
        } catch (error) {
          console.error("Failed to update quantity:", error);
          alert("An error occurred. Please try again.");
        }
      });
    });
}

function updateCartTotal() {
  const cartTotalElement = document.getElementById("cart-total-price");
  if (!cartTotalElement) return;

  let newTotal = 0;
  document.querySelectorAll(".cart-item-row").forEach((itemRow) => {
    const price = parseFloat(itemRow.dataset.price);
    const quantity = parseInt(
      itemRow.querySelector(".quantity-display").textContent
    );
    if (!isNaN(price) && !isNaN(quantity)) {
      newTotal += price * quantity;
    }
  });

  cartTotalElement.textContent =
    "$" +
    newTotal.toLocaleString("en-US", {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });
}

// Clear Checkout cart
function clearCheckout() {
  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      if (request.status == 200) {
        try {
          var obj = JSON.parse(request.responseText);
          if (obj.status === "success") {
            // Show a visual confirmation before redirect
            showCartClearedMessage();
            setTimeout(function() {
          window.location = "/products/listings.php";
            }, 1000); // 1 second delay
        } else {
            alert("Clear cart failed: " + (obj.message || "Unknown error"));
          }
        } catch (e) {
          alert("Clear cart failed: Invalid server response.");
        }
      } else {
        alert("Request failed with status " + request.status);
      }
    }
  };
  request.open(
    "POST",
    "/process/clearCartProcess.php",
    true
  );
  request.send();
}

function showCartClearedMessage() {
  // Create overlay
  var overlay = document.createElement('div');
  overlay.style.position = 'fixed';
  overlay.style.top = 0;
  overlay.style.left = 0;
  overlay.style.width = '100%';
  overlay.style.height = '100%';
  overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
  overlay.style.display = 'flex';
  overlay.style.justifyContent = 'center';
  overlay.style.alignItems = 'center';
  overlay.style.zIndex = '9999';

  // Create message box
  var messageBox = document.createElement('div');
  messageBox.style.backgroundColor = '#1f2937';
  messageBox.style.color = '#fbbf24';
  messageBox.style.padding = '2rem';
  messageBox.style.borderRadius = '0.5rem';
  messageBox.style.border = '2px solid #fbbf24';
  messageBox.style.textAlign = 'center';
  messageBox.style.fontSize = '1.25rem';
  messageBox.style.fontWeight = 'bold';

  messageBox.innerHTML = 'Cart cleared successfully!<br>Redirecting to listings...';

  overlay.appendChild(messageBox);
  document.body.appendChild(overlay);

  // Remove overlay after 1 second
  setTimeout(function() {
    document.body.removeChild(overlay);
  }, 1000);
}

function pay() {
  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      if (request.status == 200) {
        try {
          var obj = JSON.parse(request.responseText);
          if (obj.status === "success") {
            payhere.startPayment(obj.payment);
          } else if (obj.status === "login_required") {
            window.location = "/auth/login.php";
          } else if (obj.status === "profile_required") {
            window.location = "/pages/account.php";
          } else if (obj.status === "purchase_success") {
            window.location = "/pages/invoice.php";
          } else if (obj.status === "purchase_cancelled") {
            window.location = "/pages/checkout.php?status=cancel";
          } else {
            alert("Payment failed: " + (obj.message || "Unknown error"));
          }
        } catch (e) {
          alert("Payment failed: Invalid server response.");
        }
      } else {
        alert("Request failed with status " + request.status);
      }
    }
  };
  request.open("POST", "/process/purchaseProcess.php", true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  request.send();
}

/* USER FLOW */

// Quantity buttons functionality
function setupQuantityButtons() {
  document.querySelectorAll(".quantity-btn").forEach((button) => {
    button.addEventListener("click", function () {
      const vehicleId = this.dataset.vehicleId;
      const quantityElem = document.getElementById(`quantity-${vehicleId}`);
      const currentQuantity = parseInt(quantityElem.textContent);
      let newQuantity = currentQuantity;

      if (this.classList.contains("btn-plus")) {
        newQuantity = currentQuantity + 1;
      } else if (this.classList.contains("btn-minus") && currentQuantity > 1) {
        newQuantity = currentQuantity - 1;
      }

      if (newQuantity !== currentQuantity) {
        updateQuantity(vehicleId, newQuantity, quantityElem);
      }
    });
  });
}

function updateQuantity(vehicleId, quantity, quantityElem) {
  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      if (request.status == 200) {
        try {
          var obj = JSON.parse(request.responseText);
          if (obj.status === "success") {
            quantityElem.textContent = quantity;
            // Update total price if it exists
            const totalPriceElem = document.getElementById("total-price");
            if (totalPriceElem && obj.total_price) {
              totalPriceElem.textContent = "$" + parseFloat(obj.total_price).toLocaleString();
            }
          } else {
            alert("Update failed: " + (obj.message || "Unknown error"));
          }
        } catch (e) {
          alert("Update failed: Invalid server response.");
        }
      } else {
        alert("Request failed with status " + request.status);
      }
    }
  };
  request.open("POST", "/process/updateQuantityProcess.php", true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  request.send(
    "vehicle_id=" + encodeURIComponent(vehicleId) + "&quantity=" + encodeURIComponent(quantity)
  );
}

/* USER FLOW */

/* CART */
function removeFromCart(id) {
  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      if (request.status == 200) {
        try {
          var obj = JSON.parse(request.responseText);
          if (obj.status === "success") {
            // Remove the cart item from the DOM
            const cartItem = document.querySelector(`[data-cart-item-id="${id}"]`);
            if (cartItem) {
              cartItem.remove();
            }
            // Update total price if it exists
            const totalPriceElem = document.getElementById("total-price");
            if (totalPriceElem && obj.total_price) {
              totalPriceElem.textContent = "$" + parseFloat(obj.total_price).toLocaleString();
            }
          } else {
            alert("Remove failed: " + (obj.message || "Unknown error"));
          }
        } catch (e) {
          alert("Remove failed: Invalid server response.");
        }
      } else {
        alert("Request failed with status " + request.status);
      }
    }
  };
  request.open("POST", "/process/removeFromCartProcess.php", true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  request.send("id=" + encodeURIComponent(id));
}

function addToCart(vehicleId, quantity) {
  if (!quantity || isNaN(quantity) || quantity < 1) {
    quantity = 1;
  }
  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      if (request.status == 200) {
        try {
          var obj = JSON.parse(request.responseText);
          if (obj.status === "success") {
            alert("Added to cart successfully!");
          } else if (obj.status === "login_required") {
            window.location = "/auth/login.php";
          } else {
            alert("Add to cart failed: " + (obj.message || "Unknown error"));
          }
        } catch (e) {
          alert("Add to cart failed: Invalid server response.");
        }
      } else {
        alert("Request failed with status " + request.status);
      }
    }
  };
  request.open("POST", "/process/addToCartProcess.php", true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  request.send(
    "vehicle_id=" + encodeURIComponent(vehicleId) + "&quantity=" + encodeURIComponent(quantity)
  );
}

function setupCartPageQuantityButtons() {
  document
    .querySelectorAll(".cart-item-row .btn-plus, .cart-item-row .btn-minus")
    .forEach((button) => {
      button.addEventListener("click", async (event) => {
        const vehicleId = event.currentTarget.dataset.vehicleId;
        const action = event.currentTarget.classList.contains("btn-plus")
          ? "increment"
          : "decrement";

        try {
          const response = await fetch(
            "/process/updateCartQuantity.php",
            {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
              },
              body: JSON.stringify({ vehicle_id: vehicleId, action: action }),
            }
          );

          const result = await response.json();

          if (result.success) {
            // Update the quantity display on the page
            const quantityElement = document.getElementById(
              `quantity-${vehicleId}`
            );
            if (quantityElement) {
              quantityElement.textContent = result.newQuantity;
            }
            // Recalculate and update the total price
            updateCartTotal();
          } else {
            alert("Error: " + result.message);
          }
        } catch (error) {
          console.error("Failed to update quantity:", error);
          alert("An error occurred. Please try again.");
        }
      });
    });
}
/* CART */

/* WISHLIST */
function removeFromWishlist(id) {
  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      if (request.status == 200) {
        try {
          var obj = JSON.parse(request.responseText);
          if (obj.status === "success") {
            // Remove the wishlist item from the DOM
            const wishlistItem = document.querySelector(`[data-wishlist-item-id="${id}"]`);
            if (wishlistItem) {
              wishlistItem.remove();
            }
          } else {
            alert("Remove failed: " + (obj.message || "Unknown error"));
          }
        } catch (e) {
          alert("Remove failed: Invalid server response.");
        }
      } else {
        alert("Request failed with status " + request.status);
      }
    }
  };
  request.open("POST", "/process/removeFromWishlistProcess.php", true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  request.send("id=" + encodeURIComponent(id));
}

function addToWishlist(vehicleId) {
  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if (request.readyState == 4) {
      if (request.status == 200) {
        try {
          var obj = JSON.parse(request.responseText);
          if (obj.status === "success") {
            alert("Added to wishlist successfully!");
          } else if (obj.status === "login_required") {
            window.location = "/auth/login.php";
          } else {
            alert("Add to wishlist failed: " + (obj.message || "Unknown error"));
          }
        } catch (e) {
          alert("Add to wishlist failed: Invalid server response.");
        }
      } else {
        alert("Request failed with status " + request.status);
      }
    }
  };
  request.open("POST", "/process/addToWishlistProcess.php", true);
  request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  request.send("vehicle_id=" + encodeURIComponent(vehicleId));
}
/* WISHLIST */

/* ACCOUNT PAGE */
function setupAccountPage() {
  // Add event listeners for account page functionality
  const updateForm = document.getElementById('updateAccountForm');
  if (updateForm) {
    updateForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      const request = new XMLHttpRequest();
      
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          if (request.status == 200) {
            try {
              const response = JSON.parse(request.responseText);
              if (response.status === 'success') {
                alert('Account updated successfully!');
                location.reload();
              } else {
                alert('Update failed: ' + (response.message || 'Unknown error'));
              }
            } catch (e) {
              alert('Update failed: Invalid server response.');
            }
          } else {
            alert('Request failed with status ' + request.status);
          }
        }
      };
      
      request.open('POST', '/process/updateAccount.php', true);
      request.send(formData);
    });
  }
}

// Initialize account page functionality
if (window.location.pathname.endsWith('/pages/account.php')) {
  setupAccountPage();
}
