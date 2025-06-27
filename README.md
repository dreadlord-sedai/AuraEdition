# AuraEdition 🚗✨

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue.svg)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-blue.svg)](https://www.mysql.com/)
[![Tailwind CSS](https://img.shields.io/badge/TailwindCSS-4.1.8-38bdf8?logo=tailwindcss)](https://tailwindcss.com/)

> **A premium e-commerce platform for luxury vehicles.**
> 
> Modern, secure, and scalable. Built for car enthusiasts, dealers, and admins.

---

## 🌟 Features
- **User Authentication:** Secure registration, login, and profile management
- **Product Browsing:** Luxury vehicle listings, search, and filters
- **Shopping Experience:** Cart, checkout, order history
- **Admin Panel:** Product, user, and order management
- **Responsive UI:** Tailwind CSS, mobile-first, luxury design
- **Security:** CSRF, input validation, password hashing, session management

---

## 🏗️ Architecture Overview

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

---

## 🚀 Quickstart

### Prerequisites
- PHP 7.4+
- MySQL 5.7+
- Node.js & npm (for Tailwind CSS)
- Composer (optional)

### Installation
```bash
# Clone the repository
$ git clone https://github.com/yourusername/auraedition.git
$ cd auraedition

# Install Node dependencies
$ npm install

# Build Tailwind CSS
$ npx tailwindcss -i ./assets/css/input.css -o ./assets/css/tailwind-output.css --minify

# Configure environment variables
$ cp .env.example .env
# Edit .env with your DB and SMTP credentials

# Import database schema
$ mysql -u username -p database_name < database/schema.sql

# Start development server
$ php -S localhost:8000
```

---

## 📚 Full Documentation
- **[Comprehensive Docs](docs/README.docs.md)**: Architecture, modules, database, security, developer guide, and API planning.
- **[Developer Guide](docs/developer_guide.md)**: Onboarding, coding standards, workflow, troubleshooting.
- **[API Planning](docs/api.md)**: REST API endpoints and examples (future).

---

## 📂 Project Structure
```
AuraEdition/
├── admin/        # Admin panel
├── assets/       # CSS, JS, images, fonts
├── auth/         # Authentication
├── config/       # Configuration
├── docs/         # Full documentation
├── includes/     # Core helpers, DB, session
├── pages/        # User-facing pages
├── process/      # Form/action handlers
├── products/     # Product listings, images
├── templates/    # Reusable components
└── index.php     # Entry point
```

---

## 🔒 Security Highlights
- Prepared statements for all DB queries
- Input validation and sanitization
- CSRF protection on all forms
- Secure password hashing (bcrypt)
- Session management and role-based access

---

## 🤝 Contributing
1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📧 Contact
- Email: contact@auraedition.com
- Website: https://auraedition.com

<div align="center">
  Made with ❤️ by the AuraEdition Team
</div>
