# Deployment & Local Setup

## The path constraint (read first)

All includes and asset URLs hardcode `/Projects/AuraEdition` under `DOCUMENT_ROOT`
(e.g. `$_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/bootstrap.php'`,
`href="/Projects/AuraEdition/assets/css/tailwind-output.css"`). Consequences:

- The app must be served from `<docroot>/Projects/AuraEdition`. XAMPP layout:
  `htdocs/Projects/AuraEdition`, accessed at `http://localhost/Projects/AuraEdition`.
- `php -S localhost:8000` run from inside the repo will NOT resolve includes. Serve the
  parent directory instead:
  ```bash
  php -S localhost:8000 -t <parent-dir-of-repo>
  # then open http://localhost:8000/Projects/AuraEdition/
  ```
- Deploying anywhere else requires rewriting those hardcoded paths across includes,
  templates, and seed data - plan for it before changing the directory layout.

## Local setup

1. **Dependencies + CSS** (Tailwind output is gitignored):
   ```bash
   npm install
   npx tailwindcss -i ./assets/css/input.css -o ./assets/css/tailwind-output.css --minify
   ```
2. **Database**:
   ```bash
   mysql -u root -p < database/schema.sql
   mysql -u root -p < database/seed.sql
   ```
   Demo logins are listed in the root [README](../README.md#default-credentials).
3. **Config**: committed `config/config.php` holds local defaults (`127.0.0.1` / `root` /
   `mysql2006`). Edit if your MySQL differs. Password-reset email needs SMTP env vars
   (`SMTP_HOST`, `SMTP_USER`, `SMTP_PASS`, ... - see [security.md](security.md#email));
   everything else works without them.
4. **Serve** at `http://localhost/Projects/AuraEdition/` per the path constraint above.
5. Upload dirs (`products/img/`) need write permission for image uploads.

## Production (generic Apache + PHP + MySQL host)

There is no automated deploy pipeline; deployment is manual:

1. Build Tailwind (command above) - a stale build silently ships old styles.
2. Create the database from `database/schema.sql`; optionally `database/seed.sql`
   (**rotate or delete the seeded demo accounts before going public**).
3. Place the repo at `<docroot>/Projects/AuraEdition` (or adjust the hardcoded paths -
   see the path constraint).
4. Update credentials in `config/config.php` for the production DB user.
5. Ensure `products/img/` is writable by PHP.

`.htaccess` provides security headers, blocks direct HTTP access to `config.php`, and
enables static caching under Apache.

## Post-deploy checklist

Minimum: demo accounts removed, image uploads land in `products/img/`, Tailwind rebuilt,
HTTPS enabled at the host.
