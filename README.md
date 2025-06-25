# AuraEdition - Luxury Vehicle Marketplace

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

AuraEdition is a premium e-commerce platform for luxury vehicles, built with modern web technologies to provide a seamless shopping experience for car enthusiasts.

## 🌟 Features

- **User Authentication**
  - Secure registration and login system
  - User profile management
  - Address management with country support

- **Product Browsing**
  - Luxury vehicle listings with detailed views
  - Filter and search functionality
  - Featured and recent listings

- **Shopping Experience**
  - Shopping cart functionality
  - Checkout process
  - Order history and tracking

- **Admin Panel**
  - Product management
  - User management
  - Order processing

## 🛠️ Tech Stack

- **Frontend**
  - HTML5, CSS3, JavaScript
  - Tailwind CSS for styling
  - Responsive design for all devices
  - Interactive UI components

- **Backend**
  - PHP 7.4+
  - MySQL Database
  - MVC-like architecture

- **Dependencies**
  - Tailwind CSS v4.1.8
  - Bootstrap 5.3.6
  - Font Awesome 6.5.0

## 📦 Installation

1. **Prerequisites**
   - PHP 7.4 or higher
   - MySQL 5.7 or higher
   - Web server (Apache/Nginx)
   - Composer (for dependency management)

2. **Setup**
   ```bash
   # Clone the repository
   git clone https://github.com/yourusername/auraedition.git
   cd auraedition
   
   # Install dependencies
   npm install
   
   # Configure database
   # Copy .env.example to .env and update database credentials
   cp .env.example .env
   
   # Import database schema
   mysql -u username -p database_name < database/schema.sql
   
   # Start development server
   php -S localhost:8000
   ```

## 🚀 Usage

1. **User Registration**
   - Register a new account
   - Verify your email
   - Complete your profile

2. **Browsing Vehicles**
   - View featured vehicles on the homepage
   - Use filters to find specific models
   - View detailed vehicle information

3. **Making a Purchase**
   - Add vehicles to cart
   - Proceed to checkout
   - Complete payment (integration required)
   - Track your orders

## 📂 Project Structure

```
AuraEdition/
├── admin/               # Admin panel files
├── assets/              # Static assets (CSS, JS, images)
│   ├── css/            # Compiled CSS
│   ├── js/             # JavaScript files
│   └── images/         # Image assets
├── auth/                # Authentication related files
├── includes/            # Core PHP includes
│   ├── db.php          # Database connection
│   ├── functions.php   # Helper functions
│   ├── navbar.php      # Navigation component
│   └── session.php     # Session management
├── pages/               # Main application pages
├── process/             # Form processing scripts
├── products/            # Product related pages
├── templates/           # Reusable components
└── index.php            # Entry point
```

## 🔒 Security

- Prepared statements for database queries
- Input validation and sanitization
- CSRF protection
- Secure password hashing
- Session management

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🤝 Contributing

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📧 Contact

For any inquiries, please reach out to:
- Email: contact@auraedition.com
- Website: https://auraedition.com

---

<div align="center">
  Made with ❤️ by AuraEdition Team
</div>
