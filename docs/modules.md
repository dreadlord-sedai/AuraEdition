# Module & Directory Documentation

## includes/
- **Purpose:** Core logic, helpers, DB, session, and UI components.
- **Key Files:**
  - `functions.php`: Business logic (user, cart, wishlist, order, vehicle, pagination)
  - `auth_helpers.php`: CSRF, flash, tokens, email
  - `db.php`: DB connection
  - `session.php`: Session management
  - `bootstrap.php`: Centralized include
  - `navbar.php`, `footer.php`, etc.: UI components
- **Interactions:** Used by all entry points (user, admin, process)

## auth/
- **Purpose:** User authentication (login, register, password reset)
- **Key Files:** Forms and process scripts
- **Interactions:** Uses `includes/` for helpers, DB, session

## admin/
- **Purpose:** Admin panel (dashboard, management, analytics)
- **Key Files:**
  - `dashboard.php`: Analytics
  - `pages/`: Management pages
  - `process/`: Admin actions
  - `templates/`: Layout
  - `includes/`: Admin helpers
- **Interactions:** Uses `includes/` and own helpers

## pages/
- **Purpose:** User-facing pages (account, cart, checkout, wishlist, etc.)
- **Key Files:** `account.php`, `cart.php`, `checkout.php`, etc.
- **Interactions:** Use `includes/` for logic and UI

## process/
- **Purpose:** Form and action handlers (cart, wishlist, checkout, account, etc.)
- **Key Files:** `addToCartProcess.php`, `cartCheckoutProcess.php`, etc.
- **Interactions:** Use `includes/` for logic, called by forms in `pages/`/`admin/pages/`

## products/
- **Purpose:** Product listings and details
- **Key Files:** `listings.php`, `productDetails.php`, `img/`
- **Interactions:** Use `includes/` for logic, images for display

## assets/
- **Purpose:** Static assets (CSS, JS, images, fonts, video)
- **Key Files:** `css/`, `js/`, `images/`, `fonts/`, `video/`
- **Interactions:** Linked from all pages

## config/
- **Purpose:** Centralized configuration (DB, paths, URLs)
- **Key Files:** `config.php`
- **Interactions:** Used by `includes/bootstrap.php` and all entry points

## templates/
- **Purpose:** Reusable HTML/PHP components
- **Key Files:** Layout and UI partials
- **Interactions:** Included in user/admin pages 