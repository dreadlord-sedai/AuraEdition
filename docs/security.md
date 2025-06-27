# Security Model & Best Practices

## Authentication
- Session-based login for users and admins
- Passwords hashed with bcrypt (PHP's `password_hash`)
- Role-based access checks for admin/user

## CSRF Protection
- All forms include CSRF tokens (see `auth_helpers.php`)
- Tokens validated on all POST requests

## Input Validation & Sanitization
- All user input validated and sanitized (server-side)
- Use of `filter_var`, `htmlspecialchars`, and type checks

## Session Management
- Sessions started in `includes/bootstrap.php`
- Session ID regenerated on login
- Session variables used for user state and role

## Database Security
- All queries use prepared statements (mysqli)
- No user input is directly interpolated into SQL

## Email Security
- PHPMailer uses environment variables for SMTP credentials
- Emails sent with proper escaping and validation

## Recommendations for Future Hardening
- Move DB credentials to environment variables
- Add global PHP error handler and logging
- Use HTTPS in production
- Implement rate limiting for login and API endpoints
- Regularly update dependencies 