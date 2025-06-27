# Developer Guide & Onboarding

## Setup
- See README for prerequisites and installation
- Configure `.env` for DB and SMTP
- Import database schema
- Build Tailwind CSS assets

## Coding Standards
- PHP: PSR-12, docblocks for all functions/classes
- CSS: Tailwind for layout, custom CSS for overrides
- JS: Modular, use ES6+ where possible
- Use prepared statements for all DB access

## Adding Features
- Add new pages to `pages/` or `admin/pages/`
- Add new process scripts to `process/` or `admin/process/`
- Add new helpers to `includes/functions.php`
- Update database schema as needed

## Testing
- Manual browser testing for all flows
- (Recommendation: Add automated tests for critical features)

## Contribution Workflow
1. Fork the repo
2. Create a feature branch (`git checkout -b feature/YourFeature`)
3. Commit and push your changes
4. Open a Pull Request
5. Code review and merge

## Troubleshooting
- See README for common issues
- Check PHP error logs for details 