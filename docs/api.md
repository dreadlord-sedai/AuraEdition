# HTTP Endpoints Reference

AuraEdition has **no REST API**. It is a server-rendered PHP application: pages live in
`pages/`, `products/`, `auth/`, and `admin/pages/`, and browser forms/AJAX POST to
state-changing handlers. This document lists every handler and its contract, verified
against the code.

There is no authentication layer beyond PHP sessions. All paths below are relative to the
app root (`/Projects/AuraEdition` in the default XAMPP layout).

## Response conventions

Handlers use two different styles. Match the style of the endpoint you call or extend:

1. **Plain text** - echoes `success` on success, `Error: ...` (or `error`) on failure.
   No content-type header. Used by most cart/wishlist handlers.
2. **JSON** - sends `Content-Type: application/json`. Two sub-shapes exist:
   - `{ "status": "success" | "error", "message": ... }` (purchase/clear-cart/admin category AJAX)
   - `{ "success": true|false, "message" | "newQuantity": ... }` (cart quantity, admin make/model)
3. **Redirects** - traditional form handlers 302-redirect back to a page.

Check the specific handler before writing client code; do not assume one shape.

## Public handlers (`process/`)

| Handler | Method | Auth | Params (POST unless noted) | Response |
|---|---|---|---|---|
| addToCartProcess.php | POST | required | `vehicle_id`, `quantity?` (default 1) | plain text: `success` / `Error: ...`; creates cart row lazily |
| removeFromCartProcess.php | POST | required | `id` = cart_item_id | plain text: `success` / `error` |
| updateQuantityProcess.php | POST | required | `id` = vehicle_id, `quantity` | plain text; operates on buy-now session (`$_SESSION['vehicles']`), not DB carts |
| updateCartQuantity.php | POST | required | JSON body `{vehicle_id, action}` or form data with `id` = cart_item_id | JSON `{success, newQuantity}` / `{success:false, message}` |
| clearCartProcess.php | POST/GET | required | none | JSON `{status:"success"}`; deletes all DB cart_items for user |
| addToWishlistProcess.php | POST | required | `vehicle_id` | plain text: `success` (silent if not logged in) |
| removeFromWishlistProcess.php | POST | required | `id` = wishlist item id | plain text: `success` / `error` |
| buyNowProcess.php | POST | required* | `id` = vehicle_id, `quantity?` | plain text: `success` / `Error: ...`; stores vehicle in `$_SESSION['vehicles']` + computes `$_SESSION['total_price']` |
| purchaseProcess.php | POST | required | reads buy-now session + user address | JSON `{status:"success", ...PayHere params}` / `{status:"error", message}`; inserts orders/order_items, clears session + DB cart, builds PayHere payment payload (LKR) |
| cartCheckoutProcess.php | GET/POST | required | - | redirect only: login -> cart -> checkout page routing |
| contactProcess.php | POST | none | contact form fields | redirect to contact page with `status=success/error`; sends email via PHPMailer |
| updateAccount.php | POST | required | profile fields + `csrf_token` | redirects to account.php; CSRF enforced via `validate_csrf_token()` |
| loginProcess.php | POST | none | `email`, `password`, `csrf_token` | redirect; CSRF enforced; sets `$_SESSION['user_id']` |
| registerProcess.php | POST | none | fname, lname, email, password, `csrf_token` | redirect; CSRF enforced |
| logoutProcess.php | GET/POST | none | - | destroys session, echoes `success` |

\* `buyNowProcess.php` loads the vehicle but does not itself check login; checkout does.

Note: `process/loginProcess.php` is a logout-style stub that destroys the session
(historic naming accident). The real login handler is `auth/loginProcess.php`.

## Auth handlers (`auth/`)

| Handler | Method | Params | Response |
|---|---|---|---|
| auth/loginProcess.php | POST | email, password, `csrf_token` | redirect to index.php on success, back to login.php otherwise |
| auth/registerProcess.php | POST | fname, lname, email, password, `csrf_token` | redirect; bcrypt-hashes password; sets registerd_date = NOW() |
| auth/forgotPasswordProcess.php | POST | email, `csrf_token` | redirect; emails reset token via `send_email()` (PHPMailer) |
| auth/resetPasswordProcess.php | POST | token, new password, `csrf_token` | redirect; validates token expiry against `users.password_reset_expires` |

## Admin handlers (`admin/process/`)

All require an admin session (they hydrate the user via `getUserWithAddress()` and compare
`role != "admin"`), except where noted.

| Handler | Method | Params | Response |
|---|---|---|---|
| addProductProcess.php | POST multipart | `add_product`, title, description, price, stock, make, model + image upload (`$_FILES`) | redirect to vehicles.php; calls `addProduct()`, stores image path |
| editProductProcess.php | POST multipart | product fields + optional new image | redirect; `updateProduct()`; may replace image row |
| deleteProductProcess.php | POST | `id` = vehicle id | silent; deletes images first then vehicle (RESTRICT FK order matters) |
| deleteProduct.php | POST | `id` | redirect variant of the above |
| categoriesProcess.php | POST | `add_make`/`add_model`/`delete_make`/`delete_model` branches | redirect to categories.php; legacy non-AJAX category CRUD (AJAX variants below are what the UI uses) |
| getModelsByMake.php | GET | `make_id` | JSON array of models (no auth check) |
| addMakeProcess.php | POST | make name field | JSON `{success, message}` |
| addModelProcess.php | POST | model name + make id | JSON `{success, message}` |
| deleteMakeProcess.php | POST | make id | JSON `{success, message}` |
| deleteModelProcess.php | POST | model id | JSON `{success, message}` |
| accountProcess.php | POST | admin profile fields + `csrf_token` | redirect; CSRF enforced via `verify_csrf_token()` |

## Pages (GET)

| Path | Purpose |
|---|---|
| index.php | home: featured + popular vehicles |
| products/listings.php | paginated catalog with search/filter |
| products/productDetails.php?id= | single vehicle |
| pages/categories.php | makes overview |
| pages/makesListings.php?make= | listings filtered by make |
| pages/cart.php, pages/checkout.php, pages/invoice.php | cart flow (session + PayHere) |
| pages/purchasedHistory.php, pages/wishlist.php, pages/account.php | logged-in areas |
| pages/about.php, pages/contact.php | static/contact |
| auth/login.php, auth/register.php, auth/forgot_password.php, auth/reset_password.php | auth screens |
| admin/dashboard.php, admin/pages/* | admin panel (all behind `authorize_admin()`) |

## Conventions for new handlers

- Include bootstrap first, then functions:
  `include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/bootstrap.php';`
- Guard POST-only where it matters (`$_SERVER['REQUEST_METHOD']`).
- Check `$_SESSION['user_id']` for user-scoped actions; admin pages must call
  `authorize_admin($connection)` from `admin/includes/adminFunctions.php`.
- Add CSRF validation (`validate_csrf_token($_POST['csrf_token'] ?? '')`) to any new
  HTML-form handler - existing auth/account handlers do this; most AJAX handlers currently
  do not (see [security.md](security.md)).
- Pick one response style and match the JS that calls it.
