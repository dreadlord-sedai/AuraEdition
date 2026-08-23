# Database Reference

The `auraedition` database runs on MySQL (tested on 8.4), InnoDB engine, `utf8mb4` charset.
The authoritative DDL is [`database/schema.sql`](../database/schema.sql), which was extracted
from `auraedition.mwb` (MySQL Workbench model). This document describes that schema as it
actually exists - not an idealized design.

## Setup

```bash
mysql -u root -p < database/schema.sql   # creates DB + tables
mysql -u root -p < database/seed.sql     # optional demo data
```

`schema.sql` creates the database if it does not exist and is safe to re-run only against a
fresh database (it uses `CREATE TABLE` without `IF NOT EXISTS`). Demo logins created by
`seed.sql`: see [Default Credentials](../README.md#default-credentials).

## Entity relationships

```
users 1--1 user_addresses        (address_user_id -> users.id)
users 1--N orders                (orders.user_id -> users.id)
users 1--1 carts                 (carts.user_id -> users.id)
users 1--N wishlist_items        (user_id -> users.id)

makes 1--N model                 (model.model_make_id -> makes.make_id)
makes 1--N vehicles              (vehicles.make_id -> makes.make_id)
model 1--N vehicles              (vehicles.model_id -> model.model_id)

vehicles 1--N vehicle_images     (image_vehicle_id -> vehicles.id)
vehicles 1--N cart_items         (vehicle_id -> vehicles.id)
vehicles 1--N order_items        (vehicle_id -> vehicles.id)
vehicles 1--N wishlist_items     (vehicle_id -> vehicles.id)

carts 1--N cart_items            (cart_id -> carts.cart_id)
orders 1--N order_items          (order_id -> orders.order_id)
```

All foreign keys use the default `RESTRICT` rule. The application deletes child rows itself
before deleting parents (e.g. `deleteProductProcess.php` removes `vehicle_images` first,
then the vehicle). Keep this pattern when adding new parent/child tables.

## Tables

### users

| Column | Type | Null | Default | Notes |
|---|---|---|---|---|
| id | INT | NO | auto_increment | PK |
| fname | VARCHAR(45) | NO | | |
| lname | VARCHAR(45) | NO | | |
| email | VARCHAR(255) | NO | | UNIQUE KEY `UNIQUE` |
| hashed_password | VARCHAR(255) | NO | | bcrypt via `password_hash()` |
| role | ENUM('user','admin') | NO | 'user' | |
| registerd_date | DATETIME | YES | NULL | [sic] column name |
| password_reset_token | VARCHAR(255) | YES | NULL | |
| password_reset_expires | DATETIME | YES | NULL | |

Note: there is no `created_at`; the misspelled `registerd_date` is the registration timestamp.
Do not rename without updating `auth/registerProcess.php`, admin user queries, and seed data.

### user_addresses

| Column | Type | Null | Default |
|---|---|---|---|
| address_id | INT | NO | auto_increment (PK) |
| address_user_id | INT | NO | |
| address | VARCHAR(255) | YES | NULL |
| city | VARCHAR(45) | YES | NULL |
| state | VARCHAR(45) | YES | NULL |
| country | VARCHAR(45) | YES | NULL |

A user may have multiple rows; checkout requires at least one (`hasUserAddresses()`).

### makes

| Column | Type | Null | Default |
|---|---|---|---|
| make_id | INT | NO | auto_increment (PK) |
| make_name | VARCHAR(100) | NO | |
| make_image | VARCHAR(255) | YES | '/Projects/AuraEdition/products/img/makes1.jpg' |

### model

Singular table name. Do not rename without updating every query in
`includes/functions.php` (`addMake/addModel/deleteMake/deleteModel/getModels`,
`get_filter_values`) and `admin/process/*`.

| Column | Type | Null | Default |
|---|---|---|---|
| model_id | INT | NO | auto_increment (PK) |
| model_name | VARCHAR(100) | NO | |
| model_make_id | INT | NO | FK -> makes.make_id |

### vehicles

Core product table.

| Column | Type | Null | Default | Notes |
|---|---|---|---|---|
| id | INT | NO | auto_increment | PK |
| title | VARCHAR(100) | NO | | |
| price | DECIMAL(10,2) | NO | | |
| make_id | INT | NO | | FK -> makes.make_id |
| model_id | INT | NO | | FK -> model.model_id |
| description | TEXT | NO | | |
| stock | INT | NO | | |
| created_at | DATETIME | NO | CURRENT_TIMESTAMP | |
| is_featured | TINYINT | YES | '0' | home page section |
| is_popular | TINYINT | YES | '0' | home page section |
| status | ENUM('ACTIVE','INACTIVE') | NO | 'ACTIVE' | most queries filter ACTIVE |

Indexes: PRIMARY(id), KEY make_id(make_id), KEY model_id(model_id).
There are no indexes on `status`, `is_featured`, or `price`.

### vehicle_images

| Column | Type | Null | Default | Notes |
|---|---|---|---|---|
| image_id | INT | NO | auto_increment | PK |
| image_vehicle_id | INT | NO | | FK -> vehicles.id |
| image_path | VARCHAR(255) | NO | | full URL path under BASE_URL |
| is_primary | TINYINT | YES | '0' | written by seeds/admin; queries just take LIMIT 1 |
| uploaded_at | TIMESTAMP | YES | NULL | |

`image_path` values are absolute URL paths such as
`/Projects/AuraEdition/products/img/product_1_....jpg`. Code fallbacks reference
`products/img/default.jpg` and `assets/images/default-car.jpg`, neither of which exists on
disk yet - add those files or every imageless listing shows a broken image.

### carts / cart_items

One row per user in `carts` (no unique constraint enforced; `cartExists()` checks in code).
Quantities live in `cart_items`.

```
carts:       cart_id INT AI PK, user_id INT NOT NULL (FK -> users.id), KEY cart_user_idx(user_id)
cart_items:  cart_item_id INT AI PK, cart_id INT NOT NULL (FK -> carts.cart_id),
             vehicle_id INT NOT NULL (FK -> vehicles.id), quantity INT NOT NULL
             KEY vehicle_idx(vehicle_id), KEY cart_id_idx(cart_id)
```

Cart handlers create the cart lazily (`createCart()` after `cartExists()` returns false).
Buy-now ("order now") bypasses carts entirely and stores items in `$_SESSION['vehicles']`.

### orders / order_items

```
orders:       order_id INT AI PK, user_id INT NOT NULL (FK -> users.id),
              total_price DECIMAL(10,2) NOT NULL,
              status ENUM('pending','shipped','delivered') NULL DEFAULT 'pending',
              orderd_at DATETIME NULL DEFAULT NULL    -- [sic] column name
              KEY user_id_idx(user_id)

order_items:  id INT AI PK, order_id INT NOT NULL (FK -> orders.order_id),
              vehicle_id INT NOT NULL (FK -> vehicles.id),
              quantity INT NOT NULL, price DECIMAL(10,2) NOT NULL
              KEY vehicle_id_idx(vehicle_id), KEY order_id_idx(order_id)
```

`order_items.price` snapshots the unit price at purchase time. Statuses are exactly
pending/shipped/delivered - no processing/cancelled states exist.

### wishlist_items

```
wishlist_items: id INT AI PK, user_id INT NOT NULL (FK -> users.id),
                vehicle_id INT NOT NULL DEFAULT '0' (FK -> vehicles.id)
                KEY wishlist_user_id(user_id), KEY wishlist_vehicle_id(vehicle_id)
```

No timestamp column, no uniqueness constraint on (user_id, vehicle_id) - duplicates are
possible at the DB level.

## Query patterns used by the app

These are the actual queries from `includes/functions.php` (simplified where noted):

```sql
-- get_featured_vehicles($connection, $limit): home page "Featured"
SELECT id, title, price FROM vehicles
WHERE is_featured = 1 AND status = 'ACTIVE' LIMIT 3;

-- getAllMakes(): categories page with per-make listing counts
SELECT m.make_id, m.make_name, m.make_image, COUNT(v.id) AS listings_count
FROM makes m LEFT JOIN vehicles v ON m.make_id = v.make_id
GROUP BY m.make_id, m.make_name, m.make_image;

-- getCartItemsByUserId($connection, $user_id): cart page
SELECT ci.cart_item_id, ci.vehicle_id, ci.quantity, v.title, v.price,
       COALESCE((SELECT vi.image_path FROM vehicle_images vi
                 WHERE vi.image_vehicle_id = v.id LIMIT 1),
                '/Projects/AuraEdition/assets/images/default-car.jpg') AS image_path
FROM cart_items ci
JOIN carts c ON ci.cart_id = c.cart_id
JOIN vehicles v ON ci.vehicle_id = v.id
WHERE c.user_id = ?;

-- fetchOrdersByUserId($connection, $user_id): purchased history
SELECT ... FROM order_items
WHERE order_id IN (SELECT order_id FROM orders WHERE user_id = ?);

-- getUserWithAddress(): login/session hydration and checkout
SELECT u.*, ua.address, ua.city, ua.state, ua.country
FROM users u LEFT JOIN user_addresses ua ON u.id = ua.address_user_id
WHERE u.id = ?;

-- admin dashboard revenue
SELECT SUM(total_price) AS total_revenue FROM orders;
```

Pagination everywhere is `LIMIT ? OFFSET ?` driven by page-size constants in the callers.

## Known dead code touching the schema

`fetchUserById()` in `includes/functions.php` selects `zip` and `phone` columns from
`users` that do not exist in the schema. The function has no callers anywhere; it will
fatal if ever invoked. Delete it rather than adding the columns.
