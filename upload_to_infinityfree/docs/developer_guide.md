# AuraEdition Developer Guide

## 🚀 Getting Started

### Prerequisites
- **PHP**: 7.4 or higher with mysqli extension
- **MySQL**: 5.7 or higher with InnoDB engine
- **Web Server**: Apache/Nginx (or PHP built-in server for development)
- **Node.js**: 14+ (for Tailwind CSS compilation)
- **Git**: For version control

### Development Environment Setup

#### 1. Clone and Configure
```bash
# Clone the repository
git clone https://github.com/yourusername/auraedition.git
cd auraedition

# Install Node.js dependencies
npm install

# Build Tailwind CSS
npx tailwindcss -i ./assets/css/input.css -o ./assets/css/tailwind-output.css --minify
```

#### 2. Database Setup
```bash
# Create database
mysql -u root -p
CREATE DATABASE auraedition;
USE auraedition;

# Import schema (if available)
mysql -u root -p auraedition < database/schema.sql
```

#### 3. Configuration
```php
// Edit config/config.php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'auraedition');
```

#### 4. Start Development Server
```bash
# Using PHP built-in server
php -S localhost:8000

# Or configure your web server (Apache/Nginx)
```

---

## 📋 Coding Standards

### PHP Standards

#### 1. File Structure
```php
<?php
/**
 * File Description
 * 
 * @author Your Name
 * @version 1.0
 */

// Include dependencies
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/bootstrap.php';

// Constants and configuration
define('CONSTANT_NAME', 'value');

// Function definitions
function functionName($param1, $param2) {
    // Implementation
}

// Main execution (if applicable)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process request
}
?>
```

#### 2. Function Naming
- **Use snake_case** for function names: `get_user_data()`
- **Use descriptive names**: `addToCart()` not `add()`
- **Prefix admin functions**: `admin_get_users()`

#### 3. Variable Naming
- **Use snake_case** for variables: `$user_id`, `$total_price`
- **Use descriptive names**: `$vehicle_listings` not `$vl`
- **Boolean variables**: `$is_featured`, `$has_address`

#### 4. Database Queries
```php
// Always use prepared statements
function getUserById($connection, $user_id) {
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $connection->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }
    
    return null;
}
```

#### 5. Error Handling
```php
// Use try-catch for database operations
try {
    $result = performDatabaseOperation($connection);
    return $result;
} catch (mysqli_sql_exception $e) {
    error_log("Database error: " . $e->getMessage());
    return false;
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    return false;
}
```

### HTML/CSS Standards

#### 1. HTML Structure
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Title | AuraEdition</title>
    
    <!-- Include stylesheets -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>
</head>
<body class="bg-black text-white min-h-screen">
    <!-- Navigation -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/navbar.php'; ?>
    
    <!-- Main content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Content here -->
    </main>
    
    <!-- Footer -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/footer.php'; ?>
</body>
</html>
```

#### 2. Tailwind CSS Usage
```html
<!-- Use utility classes for styling -->
<div class="bg-gray-900 rounded-xl shadow-lg p-6 border border-yellow-400/20">
    <h2 class="text-2xl font-serif text-yellow-400 mb-4">Title</h2>
    <p class="text-gray-300">Content</p>
</div>

<!-- Responsive design -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Grid items -->
</div>
```

### JavaScript Standards

#### 1. Function Structure
```javascript
// Use descriptive function names
function addToCart(vehicleId) {
    // Validate input
    if (!vehicleId) {
        console.error('Vehicle ID is required');
        return;
    }
    
    // Make AJAX request
    fetch('/Projects/AuraEdition/process/addToCartProcess.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'vehicle_id=' + encodeURIComponent(vehicleId)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccessMessage('Added to cart successfully');
        } else {
            showErrorMessage(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorMessage('An error occurred');
    });
}
```

#### 2. Event Handling
```javascript
// Use event delegation for dynamic content
document.addEventListener('click', function(event) {
    if (event.target.matches('.add-to-cart-btn')) {
        const vehicleId = event.target.dataset.vehicleId;
        addToCart(vehicleId);
    }
});

// Form submission
document.getElementById('form-id').addEventListener('submit', function(event) {
    event.preventDefault();
    // Handle form submission
});
```

---

## 🔄 Development Workflow

### 1. Feature Development

#### Planning Phase
1. **Define Requirements**: What should the feature do?
2. **Database Changes**: New tables, columns, or relationships?
3. **UI/UX Design**: How will users interact with it?
4. **Security Considerations**: Input validation, access control?

#### Implementation Phase
1. **Database Schema**: Create/modify tables
2. **Backend Functions**: Add to `includes/functions.php` or `admin/includes/adminFunctions.php`
3. **Process Handlers**: Create in `process/` or `admin/process/`
4. **Frontend Pages**: Create in `pages/` or `admin/pages/`
5. **Styling**: Use Tailwind CSS classes
6. **JavaScript**: Add interactive functionality

#### Testing Phase
1. **Unit Testing**: Test individual functions
2. **Integration Testing**: Test complete workflows
3. **Security Testing**: Validate input, check permissions
4. **UI Testing**: Test on different devices/browsers

### 2. Bug Fixes

#### Debugging Process
1. **Reproduce the Issue**: Understand when it occurs
2. **Check Error Logs**: Look in `error_log.txt`
3. **Add Debug Output**: Use `error_log()` or `var_dump()`
4. **Test Fixes**: Verify the solution works
5. **Document Changes**: Update relevant documentation

#### Common Debugging Techniques
```php
// Debug database queries
error_log("SQL Query: " . $sql);
error_log("Parameters: " . print_r($params, true));

// Debug variables
var_dump($variable);
error_log("Variable value: " . print_r($variable, true));

// Debug AJAX responses
header('Content-Type: application/json');
echo json_encode(['debug' => $variable, 'success' => true]);
```

### 3. Code Review Process

#### Before Submitting
1. **Self-Review**: Check your own code
2. **Testing**: Ensure all functionality works
3. **Documentation**: Update relevant docs
4. **Security Check**: Validate inputs, check permissions

#### Review Checklist
- [ ] Code follows naming conventions
- [ ] Database queries use prepared statements
- [ ] Input validation is implemented
- [ ] Error handling is appropriate
- [ ] Security measures are in place
- [ ] Documentation is updated
- [ ] Tests pass

---

## 🛠️ Common Development Tasks

### 1. Adding a New Database Table

```sql
-- Create new table
CREATE TABLE new_feature (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_name (name),
    INDEX idx_created_at (created_at)
);
```

### 2. Adding a New Function

```php
// Add to includes/functions.php
function getNewFeature($connection, $params = []) {
    $sql = "SELECT * FROM new_feature WHERE 1=1";
    $types = "";
    $values = [];
    
    // Add dynamic conditions
    if (!empty($params['name'])) {
        $sql .= " AND name LIKE ?";
        $types .= "s";
        $values[] = "%" . $params['name'] . "%";
    }
    
    $stmt = $connection->prepare($sql);
    if ($stmt && !empty($values)) {
        $stmt->bind_param($types, ...$values);
    }
    
    if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $data;
    }
    
    return [];
}
```

### 3. Creating a New Page

```php
<?php
// pages/newFeature.php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';

// Get page data
$data = getNewFeature($connection, $_GET);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Feature | AuraEdition</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>
</head>
<body class="bg-black text-white min-h-screen">
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/navbar.php'; ?>
    
    <div class="max-w-6xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-serif text-yellow-400 mb-8">New Feature</h1>
        
        <!-- Page content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($data as $item): ?>
                <div class="bg-gray-900 rounded-xl p-6 border border-yellow-400/20">
                    <h3 class="text-xl font-semibold text-white mb-2"><?= htmlspecialchars($item['name']) ?></h3>
                    <p class="text-gray-300"><?= htmlspecialchars($item['description']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/footer.php'; ?>
</body>
</html>
```

### 4. Creating a Process Handler

```php
<?php
// process/newFeatureProcess.php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/bootstrap.php';

// Validate request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /Projects/AuraEdition/index.php');
    exit;
}

// Validate user authentication
if (!isset($_SESSION['user_id'])) {
    header('Location: /Projects/AuraEdition/auth/login.php');
    exit;
}

// Validate input
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');

if (empty($name)) {
    $_SESSION['error'] = 'Name is required';
    header('Location: /Projects/AuraEdition/pages/newFeature.php');
    exit;
}

// Process the request
try {
    $result = addNewFeature($connection, $name, $description);
    
    if ($result) {
        $_SESSION['success'] = 'Feature added successfully';
    } else {
        $_SESSION['error'] = 'Failed to add feature';
    }
} catch (Exception $e) {
    error_log("Error adding feature: " . $e->getMessage());
    $_SESSION['error'] = 'An error occurred';
}

header('Location: /Projects/AuraEdition/pages/newFeature.php');
exit;
?>
```

### 5. Adding AJAX Functionality

```javascript
// Add to assets/js/script.js
function addNewFeature(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    
    fetch('/Projects/AuraEdition/process/newFeatureProcess.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccessMessage(data.message);
            // Reload page or update UI
            window.location.reload();
        } else {
            showErrorMessage(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorMessage('An error occurred');
    });
}

// Add event listener
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('new-feature-form');
    if (form) {
        form.addEventListener('submit', addNewFeature);
    }
});
```

---

## 🔍 Troubleshooting Guide

### Common Issues and Solutions

#### 1. Database Connection Errors
**Problem**: "Database connection failed"
```php
// Check config/config.php
define('DB_HOST', 'localhost');  // Verify host
define('DB_USER', 'username');   // Verify username
define('DB_PASS', 'password');   // Verify password
define('DB_NAME', 'auraedition'); // Verify database name
```

**Solutions**:
- Verify MySQL service is running
- Check database credentials
- Ensure database exists
- Check user permissions

#### 2. AJAX/JSON Errors
**Problem**: "Unexpected token in JSON"
```php
// Ensure process scripts return valid JSON
header('Content-Type: application/json');
echo json_encode(['success' => true, 'message' => 'Success']);
exit;
```

**Solutions**:
- Check for PHP errors before JSON output
- Ensure no whitespace before `<?php`
- Validate JSON syntax
- Check browser console for errors

#### 3. Session Issues
**Problem**: Sessions not persisting
```php
// Check session configuration
session_start();
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
```

**Solutions**:
- Verify session directory permissions
- Check session configuration
- Clear browser cookies
- Restart web server

#### 4. File Upload Issues
**Problem**: Images not uploading
```php
// Check file upload settings
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');
ini_set('max_file_uploads', 20);
```

**Solutions**:
- Check directory permissions (755)
- Verify file size limits
- Check allowed file types
- Ensure upload directory exists

#### 5. Styling Issues
**Problem**: Tailwind CSS not working
```bash
# Rebuild Tailwind CSS
npx tailwindcss -i ./assets/css/input.css -o ./assets/css/tailwind-output.css --minify
```

**Solutions**:
- Rebuild Tailwind CSS
- Clear browser cache
- Check CSS file paths
- Verify Tailwind configuration

### Debug Mode

Enable detailed error reporting for development:
```php
// Add to config/config.php for development
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../error_log.txt');
```

### Performance Optimization

#### 1. Database Optimization
```sql
-- Analyze table performance
ANALYZE TABLE vehicles, orders, users;

-- Optimize table structure
OPTIMIZE TABLE vehicles, orders, users;

-- Check slow queries
SHOW PROCESSLIST;
```

#### 2. PHP Optimization
```php
// Use opcache in production
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=4000
```

#### 3. Asset Optimization
```bash
# Minify CSS and JavaScript
npx tailwindcss -i ./assets/css/input.css -o ./assets/css/tailwind-output.css --minify

# Optimize images
# Use tools like ImageOptim or TinyPNG
```

---

## 📚 Resources and References

### Documentation
- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Font Awesome Icons](https://fontawesome.com/icons)

### Tools
- **Database**: phpMyAdmin, MySQL Workbench
- **Code Editor**: VS Code, PHPStorm, Sublime Text
- **Version Control**: Git, GitHub Desktop
- **Testing**: Browser DevTools, Postman

### Best Practices
- **Security**: Always validate and sanitize input
- **Performance**: Use prepared statements, optimize queries
- **Maintainability**: Follow naming conventions, document code
- **Testing**: Test thoroughly before deployment
- **Backup**: Regular database and code backups

---

This developer guide provides a comprehensive foundation for working with the AuraEdition codebase. Follow these standards and practices to ensure code quality, security, and maintainability. 