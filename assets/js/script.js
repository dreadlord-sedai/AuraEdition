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

    // Check if user has Addr
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

                    alert("Payment Failed! " + response);
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

function addToCart(vehicleId, quantity) {
    // Default quantity to 1 if not provided or invalid
    if (!quantity || isNaN(quantity) || quantity < 1) {
        quantity = 1;
    }
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var response = request.responseText.trim();
                if (response === "success") {
                    alert("Vehicle added to cart.");
                } else {
                    alert("Add to cart failed: " + response);
                }
            } else {
                alert("Request failed with status " + request.status);
            }
        }
    }
    request.open("POST", "/Projects/AuraEdition/process/addToCartProcess.php", true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send("vehicle_id=" + encodeURIComponent(vehicleId) + "&quantity=" + encodeURIComponent(quantity));
}

function setupCartPageQuantityButtons() {
    document.querySelectorAll('.cart-item-row .btn-plus, .cart-item-row .btn-minus').forEach(button => {
        button.addEventListener('click', async (event) => {
            const cartItemId = event.currentTarget.dataset.cartItemId;
            const action = event.currentTarget.classList.contains('btn-plus') ? 'increment' : 'decrement';

            // Use FormData for compatibility with PHP $_POST
            const formData = new URLSearchParams();
            formData.append('cart_item_id', cartItemId);
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
                    const quantityElement = document.getElementById(`quantity-${cartItemId}`);
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


/* WISHLIST */
function removeFromWishlist(id) {
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
    request.open("POST", "/Projects/AuraEdition/process/removeFromWishlistProcess.php", true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send("id=" + encodeURIComponent(id));
}

function addToWishlist(vehicleId) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            if (request.status == 200) {
                var response = request.responseText.trim();
                if (response === "success") {
                    alert("Vehicle added to wishlist.");
                } else {
                    alert("Add to wishlist failed: " + response);
                }
            } else {
                alert("Request failed with status " + request.status);
            }
        }
    }
    request.open("POST", "/Projects/AuraEdition/process/addToWishlistProcess.php", true);
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.send("vehicle_id=" + encodeURIComponent(vehicleId));
}
/* WISHLIST */

/* ACCOUNT PAGE */
function setupAccountPage() {
    const form = document.getElementById('accountForm');
    if (!form) return;

    // Form validation
    form.addEventListener('submit', function(e) {
        let isValid = true;
        const errors = [];

        // Validate email
        const email = form.querySelector('#email');
        if (!email.value || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
            errors.push('Please enter a valid email address');
            email.classList.add('border-red-500');
            isValid = false;
        } else {
            email.classList.remove('border-red-500');
        }

        // Validate password if changing
        const currentPassword = form.querySelector('#current_password');
        const newPassword = form.querySelector('#new_password');
        const confirmPassword = form.querySelector('#confirm_password');
        
        if (newPassword.value) {
            // If changing password, current password is required
            if (!currentPassword.value) {
                errors.push('Current password is required to change your password');
                currentPassword.classList.add('border-red-500');
                isValid = false;
            } else {
                currentPassword.classList.remove('border-red-500');
            }

            if (newPassword.value.length < 8 || 
                !/[A-Z]/.test(newPassword.value) || 
                !/[0-9]/.test(newPassword.value) || 
                !/[^A-Za-z0-9]/.test(newPassword.value)) {
                errors.push('Password must be at least 8 characters with uppercase, number, and special character');
                newPassword.classList.add('border-red-500');
                isValid = false;
            } else {
                newPassword.classList.remove('border-red-500');
            }

            if (newPassword.value !== confirmPassword.value) {
                errors.push('Passwords do not match');
                confirmPassword.classList.add('border-red-500');
                isValid = false;
            } else {
                confirmPassword.classList.remove('border-red-500');
            }
        }

        // Validate required fields
        const requiredFields = ['fname', 'lname', 'email'];
        requiredFields.forEach(field => {
            const element = form.querySelector(`#${field}`);
            if (!element.value.trim()) {
                errors.push(`${field.charAt(0).toUpperCase() + field.slice(1)} is required`);
                element.classList.add('border-red-500');
                isValid = false;
            } else {
                element.classList.remove('border-red-500');
            }
        });

        // Display errors
        const errorContainer = document.getElementById('formErrors');
        if (errorContainer) {
            errorContainer.innerHTML = '';
            if (errors.length > 0) {
                errors.forEach(error => {
                    const errorElement = document.createElement('p');
                    errorElement.className = 'text-red-500 text-sm mt-1';
                    errorElement.textContent = error;
                    errorContainer.appendChild(errorElement);
                });
            }
        }

        if (!isValid) {
            e.preventDefault();
            // Scroll to first error
            const firstError = form.querySelector('.border-red-500');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });

    // Real-time password strength indicator
    const passwordInput = document.getElementById('new_password');
    const passwordStrength = document.getElementById('passwordStrength');
    
    if (passwordInput && passwordStrength) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            let messages = [];

            if (password.length >= 8) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            // Update UI based on strength
            passwordStrength.className = '';
            passwordStrength.classList.add('text-sm', 'mt-1');
            
            if (password.length === 0) {
                passwordStrength.textContent = '';
                return;
            }

            switch(strength) {
                case 0:
                case 1:
                    passwordStrength.classList.add('text-red-500');
                    passwordStrength.textContent = 'Weak - Add more characters, numbers, and symbols';
                    break;
                case 2:
                    passwordStrength.classList.add('text-yellow-500');
                    passwordStrength.textContent = 'Moderate - Try adding more complexity';
                    break;
                case 3:
                    passwordStrength.classList.add('text-blue-500');
                    passwordStrength.textContent = 'Good - Almost there!';
                    break;
                case 4:
                    passwordStrength.classList.add('text-green-500');
                    passwordStrength.textContent = 'Strong - Great job!';
                    break;
            }
        });
    }

    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let phone = this.value.replace(/\D/g, '');
            if (phone.length > 10) phone = phone.substring(0, 10);
            
            // Format as (XXX) XXX-XXXX
            let formatted = '';
            if (phone.length > 0) {
                formatted = '(' + phone.substring(0, 3);
                if (phone.length > 3) {
                    formatted += ') ' + phone.substring(3, 6);
                    if (phone.length > 6) {
                        formatted += '-' + phone.substring(6, 10);
                    }
                }
                this.value = formatted;
            }
        });
    }
}

// Initialize account page when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    setupAccountPage();
});