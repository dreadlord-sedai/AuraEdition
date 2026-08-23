# Security Model

This document describes the security mechanisms that actually exist in the code, verified
against it. It also lists known gaps so nobody mistakes absence for coverage.

## Passwords

- Hashed with `password_hash($password, PASSWORD_DEFAULT)` (bcrypt), verified with
  `password_verify()`. There are no wrapper functions like `hashPassword()` - the calls are
  inline in:
  - `auth/registerProcess.php:46` (registration)
  - `auth/resetPasswordProcess.php:26` (password reset)
  - `process/updateAccount.php:93` (password change)
- No minimum-strength check beyond length in some forms; the register form validates
  client-side. Server-side enforcement is minimal.

## Sessions and login flow

`includes/session.php` is a bare `session_start()` guarded by `session_status()`. The login
flow (`auth/loginProcess.php`) is:

1. CSRF token check (`validate_csrf_token`)
2. `filter_var(..., FILTER_VALIDATE_EMAIL)` on the email
3. Prepared statement selecting `hashed_password`, `role` by email
4. `password_verify()`; identical error message for unknown email vs wrong password
5. `session_regenerate_id(true)` on success, then `$_SESSION['user_id']`,
   `fname`, `lname`, `email`, `role`

Session cookie flags (`httponly`, `secure`, `samesite`) are **not** set anywhere in PHP.
The only related hardening is `session_regenerate_id(true)` at login. There is no idle
timeout - sessions last until the browser clears them.

## Access control

- Admin pages call `authorize_admin($connection)`
  (`admin/includes/adminFunctions.php`): hydrates the user via `getUserWithAddress()`
  and redirects to `/index.php` unless `role === 'admin'`.
- User-scoped pages/handlers check `$_SESSION['user_id']` directly; there is no
  `require_login()` helper.
- **Gap:** `admin/process/getModelsByMake.php` includes only `db.php` +
  `adminFunctions.php` - no bootstrap, no session check. It leaks model names to anyone
  (low severity, but do not copy this pattern).
- Ownership checks live inside query `WHERE` clauses (e.g. cart/wishlist queries filter by
  the session user id); handlers generally pass IDs straight into those queries.

## CSRF

Helpers in `includes/auth_helpers.php`: `generate_csrf_token()`, `validate_csrf_token()`
(and `verify_csrf_token()` as an alias of it). Tokens are per-session, compared with
`hash_equals()`.

Enforcement map (handlers that actually validate):

| Handler | Validates CSRF |
|---|---|
| `auth/loginProcess.php` | yes |
| `auth/registerProcess.php` | yes |
| `auth/forgotPasswordProcess.php` | yes |
| `auth/resetPasswordProcess.php` | yes |
| `process/updateAccount.php` | yes |
| `admin/process/accountProcess.php` | yes |

Everything else - all AJAX handlers (cart, wishlist, purchase) and admin product/category
CRUD - does **not** validate CSRF. Forms embed
`<input type="hidden" name="csrf_token" value="...">` via `generate_csrf_token()`; new
HTML-form handlers should keep doing this (see `developer_guide.md`).

## SQL injection

All queries use mysqli prepared statements with bound parameters. Convention: business
functions take `$connection` as their first argument and return arrays/null. Dynamic parts
of queries are limited to `LIMIT ?/OFFSET ?` values. No string-interpolated user input was
found in SQL.

## File uploads

Vehicle images go through `uploadProductImage()`
(`admin/includes/adminFunctions.php:270`):

- Extension whitelist: `jpg`, `jpeg`, `png`, `gif`
- Renamed to `uniqid('product_{id}_', true).ext` - original filename is discarded
- Stored under `products/img/`, path recorded in `vehicle_images`

Gaps: extension check only (no MIME/`getimagesize` content validation) and no size limit
beyond PHP's defaults.

## Output escaping

Templates escape dynamic output with `htmlspecialchars()`. This is used consistently across
`pages/`, `products/`, `templates/`, and auth screens. Keep it up when editing templates.

## Transport / server-level controls

From `.htaccess`:

- Security headers: `X-Frame-Options: DENY`, `X-Content-Type-Options: nosniff`,
  `X-XSS-Protection: 1; mode=block`, `Referrer-Policy: strict-origin-if-cross-origin`.
- `<Files "config.php"> deny from all` blocks direct HTTP access to credentials.
- Front-controller rewrite and static-asset caching.

There is no CSP header. HTTPS depends on the host's TLS setup (local XAMPP is plain HTTP).

## Email

`send_email()` (`includes/auth_helpers.php`) uses bundled PHPMailer over SMTP with all
credentials from environment variables: `SMTP_HOST`, `SMTP_USER`, `SMTP_PASS`,
`SMTP_PORT`, `SMTP_FROM`, `SMTP_FROM_NAME`. Failures are logged via `error_log()` and
return false - they never leak to users. Used by password-reset only.

## Payments

Checkout builds a PayHere payload in `process/purchaseProcess.php` including an HMAC hash.
Note: `notify_url` points to `process/payhereNotify.php`, which does **not exist** - payment
confirmation relies on the client redirect, not server-to-server notification. Do not treat
PayHere status callbacks as a security boundary until that handler exists.

## Known gaps summary

For a portfolio/shared-hosting project these are accepted risks; fix before real money or
real users:

1. DB credentials committed in `config/config.php`; demo accounts with weak passwords in
   `database/seed.sql` (see README "Default Credentials").
2. No CSRF validation on AJAX/admin CRUD handlers (table above).
3. Session cookies lack `httponly`/`secure`/`samesite` flags; no idle timeout.
4. Image upload trusts file extensions.
5. Missing PayHere notify handler (see above).
6. `admin/process/getModelsByMake.php` requires no authentication.
7. No rate limiting on login or password reset. Reset tokens themselves are sound:
   64-char random hex, 1-hour expiry checked in SQL, cleared (single-use) on success
   (`auth/resetPasswordProcess.php`).
