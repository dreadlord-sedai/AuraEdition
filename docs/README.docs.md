# AuraEdition Documentation

AuraEdition is a procedural PHP e-commerce app (no framework, no Composer) for luxury
vehicles: mysqli/MySQL backend, Tailwind CSS 4 frontend.

## Documentation Map

| Document | Contents |
|---|---|
| [architecture.md](architecture.md) | System layers, data flows, bootstrap process, function organization |
| [database.md](database.md) | Authoritative schema reference - every table, FK rule, query pattern, schema quirks (`registerd_date`, singular `model` table) |
| [modules.md](modules.md) | What each directory contains and its responsibility |
| [api.md](api.md) | Every HTTP handler and page with its request/response contract (there is **no REST API**) |
| [security.md](security.md) | Security mechanisms actually implemented, CSRF enforcement map, known gaps |
| [developer_guide.md](developer_guide.md) | Setup, coding standards, common tasks, troubleshooting |
| [deployment.md](deployment.md) | Local XAMPP/PHP-server setup, path constraints, manual production deployment |

## Navigation by task

- **Set up a dev environment**: [developer_guide.md](developer_guide.md),
  then [deployment.md](deployment.md) if `php -S` or includes misbehave
- **Add a feature**: [modules.md](modules.md) (where things go) +
  [database.md](database.md) (schema rules) + [developer_guide.md](developer_guide.md)
  (common development tasks)
- **Call or extend a handler**: [api.md](api.md) first - response formats vary per handler
- **Work on auth/payments/uploads**: [security.md](security.md) for what's enforced and what isn't
- **Deploy**: [deployment.md](deployment.md)

## Quick facts

- Serve from `<docroot>/Projects/AuraEdition` - all include paths hardcode the prefix;
  plain `php -S localhost:8000` inside the repo will not resolve includes
- Rebuild CSS after class changes:
  `npx tailwindcss -i ./assets/css/input.css -o ./assets/css/tailwind-output.css --minify`
- No test suite; verify with `php -l` plus manual browser checks
- Foreign keys use `ON DELETE RESTRICT`; handlers delete child rows before parents
- `AGENTS.md` at the repo root summarizes repo gotchas for AI coding agents

## Keeping docs current

These docs describe the code as it exists, not aspirations. When changing behavior -
handler contracts, schema, security posture, deploy flow - update the matching document in
the same change. If a doc and the code disagree, the code wins: fix the doc.
