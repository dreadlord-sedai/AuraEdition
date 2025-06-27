# AuraEdition Architecture & Data Flow

## Overview
AuraEdition is a modular PHP web application for luxury vehicle e-commerce, with clear separation between user, admin, authentication, and core logic. It uses a MySQL database and follows best practices for security and maintainability.

## High-Level Architecture

```mermaid
graph TD;
  User[User Browser]
  Admin[Admin Browser]
  Web[Web Server (PHP)]
  DB[(MySQL Database)]
  Assets[Static Assets (CSS/JS/Images)]

  User-->|HTTP/HTTPS|Web
  Admin-->|HTTP/HTTPS|Web
  Web-->|SQL Queries|DB
  Web-->|Serves|Assets
```

## Main Flows

### User Flow
1. User visits site (`index.php`, `pages/`)
2. Authenticates via `auth/` (login/register)
3. Browses vehicles (`products/`, `pages/listings.php`)
4. Adds to cart/wishlist (`process/`)
5. Checks out (`checkout.php`, `cartCheckoutProcess.php`)
6. Views order history (`purchasedHistory.php`)

### Admin Flow
1. Admin logs in via `admin/`
2. Manages products, users, orders (`admin/pages/`, `admin/process/`)
3. Views analytics (`admin/dashboard.php`)

### Data Flow
- All data access via `includes/functions.php` and helpers
- Secure DB connection via `includes/db.php`
- Prepared statements for all queries

### Security Flow
- CSRF tokens on all forms
- Passwords hashed (bcrypt)
- Session-based authentication
- Role checks for admin/user

---

## Directory Interactions
- `includes/` – Core logic, helpers, DB, session
- `auth/` – Authentication, password reset
- `admin/` – Admin panel, management
- `pages/` – User-facing pages
- `process/` – Form/action handlers
- `products/` – Product listings/details
- `assets/` – Static files
- `config/` – Environment/config

---

## Extensibility
- Add new modules in `pages/`, `admin/pages/`, or `includes/`
- Add new DB fields and update helpers/process scripts
- Update UI via `templates/` and `assets/css/` 