# AuraEdition Security Model

## 🔒 Security Overview

AuraEdition implements a comprehensive security model designed to protect against common web application vulnerabilities while maintaining usability and performance. The security architecture follows industry best practices and defense-in-depth principles.

### Security Principles
- **Defense in Depth**: Multiple layers of security controls
- **Least Privilege**: Users have minimal necessary permissions
- **Input Validation**: All user inputs are validated and sanitized
- **Secure by Default**: Security features enabled by default
- **Fail Securely**: System fails to secure state on errors

---

## 🔐 Authentication & Authorization

### User Authentication System

#### Password Security
```php
// Password hashing using bcrypt
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Password verification
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}
```

**Security Features**:
- **Bcrypt Hashing**: Industry-standard password hashing
- **Salt Generation**: Automatic salt generation for each password
- **Cost Factor**: Configurable computational cost (default: 10)
- **Timing Attack Protection**: Constant-time comparison

#### Session Management
```php
// Secure session configuration
session_start();
ini_set('session.cookie_httponly', 1);        // Prevent XSS access
ini_set('session.use_only_cookies', 1);       // Prevent session fixation
ini_set('session.cookie_secure', 1);          // HTTPS only (production)
ini_set('session.cookie_samesite', 'Strict'); // CSRF protection
```

**Session Security**:
- **HTTP-Only Cookies**: Prevent JavaScript access
- **Secure Cookies**: HTTPS-only in production
- **SameSite Policy**: CSRF protection
- **Session Timeout**: Automatic session expiration
- **Session Regeneration**: New session ID on login

#### Role-Based Access Control
```php
// Admin authorization check
function authorize_admin($connection) {
    $user = isset($_SESSION['user_id']) ? getUserWithAddress($connection, $_SESSION['user_id']) : null;
    if (!$user || $user['role'] !== 'admin') {
        header("Location: " . BASE_URL . "/index.php");
        exit;
    }
    return $user;
}

// User authentication check
function require_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: " . BASE_URL . "/auth/login.php");
        exit;
    }
}
```

**Access Control Features**:
- **Role-Based**: User and admin roles
- **Function-Level**: Individual function permissions
- **Page-Level**: Route protection
- **Automatic Redirects**: Unauthorized access handling

---

## 🛡️ Input Validation & Sanitization

### Input Validation Framework

#### Form Validation
```php
// Comprehensive input validation
function validateUserInput($data) {
    $errors = [];
    
    // Email validation
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }
    
    // Name validation
    if (empty(trim($data['fname'])) || strlen($data['fname']) > 50) {
        $errors['fname'] = 'First name is required and must be under 50 characters';
    }
    
    // Password strength validation
    if (strlen($data['password']) < 8) {
        $errors['password'] = 'Password must be at least 8 characters';
    }
    
    return $errors;
}
```

#### Data Sanitization
```php
// Input sanitization functions
function sanitizeString($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function sanitizeEmail($email) {
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}

function sanitizeInteger($input) {
    return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
}

// Usage in forms
$fname = sanitizeString($_POST['fname'] ?? '');
$email = sanitizeEmail($_POST['email'] ?? '');
$user_id = sanitizeInteger($_POST['user_id'] ?? 0);
```

### Validation Patterns

#### 1. Email Validation
```php
function validateEmail($email) {
    // Basic format validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    
    // Length validation
    if (strlen($email) > 100) {
        return false;
    }
    
    // Domain validation (optional)
    $domain = substr(strrchr($email, "@"), 1);
    if (!checkdnsrr($domain, 'MX')) {
        return false;
    }
    
    return true;
}
```

#### 2. File Upload Validation
```php
function validateFileUpload($file) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 5 * 1024 * 1024; // 5MB
    
    // Check file size
    if ($file['size'] > $max_size) {
        return ['success' => false, 'message' => 'File too large'];
    }
    
    // Check file type
    if (!in_array($file['type'], $allowed_types)) {
        return ['success' => false, 'message' => 'Invalid file type'];
    }
    
    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'Upload error'];
    }
    
    return ['success' => true];
}
```

#### 3. SQL Injection Prevention
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

// Dynamic query building (if needed)
function buildDynamicQuery($connection, $filters) {
    $sql = "SELECT * FROM vehicles WHERE 1=1";
    $types = "";
    $values = [];
    
    if (!empty($filters['make_id'])) {
        $sql .= " AND make_id = ?";
        $types .= "i";
        $values[] = (int)$filters['make_id'];
    }
    
    if (!empty($filters['price_min'])) {
        $sql .= " AND price >= ?";
        $types .= "d";
        $values[] = (float)$filters['price_min'];
    }
    
    $stmt = $connection->prepare($sql);
    if ($stmt && !empty($values)) {
        $stmt->bind_param($types, ...$values);
    }
    
    return $stmt;
}
```

---

## 🚫 CSRF Protection

### CSRF Token Implementation

#### Token Generation
```php
// Generate CSRF token
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Verify CSRF token
function verifyCSRFToken($token) {
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    
    return hash_equals($_SESSION['csrf_token'], $token);
}
```

#### Form Implementation
```php
<!-- HTML form with CSRF token -->
<form method="POST" action="/process/addToCartProcess.php">
    <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
    <input type="hidden" name="vehicle_id" value="<?= $vehicle['id'] ?>">
    <button type="submit" class="btn">Add to Cart</button>
</form>
```

#### Process Script Validation
```php
// Validate CSRF token in process scripts
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }
}
```

#### AJAX CSRF Protection
```javascript
// Include CSRF token in AJAX requests
function addToCart(vehicleId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch('/process/addToCartProcess.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'vehicle_id=' + encodeURIComponent(vehicleId) + 
              '&csrf_token=' + encodeURIComponent(csrfToken)
    })
    .then(response => response.json())
    .then(data => {
        // Handle response
    });
}
```

---

## 🔒 XSS Prevention

### Output Encoding

#### HTML Output Encoding
```php
// Always encode output
echo htmlspecialchars($user_input, ENT_QUOTES, 'UTF-8');

// In templates
<h1><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></h1>
<p><?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?></p>
```

#### JavaScript Output Encoding
```php
// For JavaScript variables
<script>
const userData = <?= json_encode($user_data) ?>;
const message = <?= json_encode($message) ?>;
</script>
```

#### URL Encoding
```php
// For URLs and links
<a href="/vehicle/<?= urlencode($vehicle_id) ?>">View Vehicle</a>
```

### Content Security Policy (CSP)

#### CSP Implementation
```php
// Set CSP headers
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' cdn.jsdelivr.net; img-src 'self' data:; font-src 'self' cdn.jsdelivr.net;");
```

#### CSP Directives
- **default-src**: Default source for resources
- **script-src**: Allowed JavaScript sources
- **style-src**: Allowed CSS sources
- **img-src**: Allowed image sources
- **font-src**: Allowed font sources

---

## 🛡️ File Upload Security

### Secure File Upload Implementation

#### Upload Validation
```php
function secureFileUpload($file, $upload_dir, $allowed_types, $max_size) {
    // Validate file
    $validation = validateFileUpload($file);
    if (!$validation['success']) {
        return $validation;
    }
    
    // Generate secure filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $filepath = $upload_dir . '/' . $filename;
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return ['success' => true, 'filename' => $filename];
    }
    
    return ['success' => false, 'message' => 'Upload failed'];
}
```

#### Image Processing
```php
function processUploadedImage($filepath) {
    // Verify it's actually an image
    $image_info = getimagesize($filepath);
    if ($image_info === false) {
        unlink($filepath);
        return false;
    }
    
    // Resize if necessary
    $max_width = 800;
    $max_height = 600;
    
    list($width, $height) = $image_info;
    if ($width > $max_width || $height > $max_height) {
        // Resize image
        resizeImage($filepath, $max_width, $max_height);
    }
    
    return true;
}
```

---

## 🔐 Database Security

### Database Connection Security

#### Secure Connection
```php
// Database connection with error handling
try {
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if (!$connection) {
        throw new Exception("Database connection failed");
    }
    
    // Set secure connection options
    mysqli_set_charset($connection, 'utf8mb4');
    
} catch (Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    die("Database connection failed. Please try again later.");
}
```

#### Query Security
```php
// Always use prepared statements
function secureQuery($connection, $sql, $params = []) {
    $stmt = $connection->prepare($sql);
    
    if (!$stmt) {
        error_log("Prepare failed: " . $connection->error);
        return false;
    }
    
    if (!empty($params)) {
        $types = str_repeat('s', count($params)); // Assume all strings for safety
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    
    return $result;
}
```

---

## 🚨 Error Handling & Logging

### Secure Error Handling

#### Error Configuration
```php
// Production error handling
error_reporting(E_ALL);
ini_set('display_errors', 0);        // Don't show errors to users
ini_set('log_errors', 1);            // Log errors
ini_set('error_log', 'error_log.txt'); // Custom error log
```

#### Exception Handling
```php
try {
    // Risky operation
    $result = performDatabaseOperation($connection);
    
    if (!$result) {
        throw new Exception("Database operation failed");
    }
    
} catch (mysqli_sql_exception $e) {
    // Log database errors
    error_log("Database error: " . $e->getMessage());
    $_SESSION['error'] = "A database error occurred";
    
} catch (Exception $e) {
    // Log general errors
    error_log("General error: " . $e->getMessage());
    $_SESSION['error'] = "An error occurred";
    
} finally {
    // Cleanup code
    if (isset($stmt)) {
        $stmt->close();
    }
}
```

#### Security Logging
```php
function logSecurityEvent($event_type, $user_id, $details) {
    $log_entry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'event_type' => $event_type,
        'user_id' => $user_id,
        'ip_address' => $_SERVER['REMOTE_ADDR'],
        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'details' => $details
    ];
    
    error_log("SECURITY: " . json_encode($log_entry));
}

// Usage
logSecurityEvent('login_failed', null, 'Invalid credentials for email: ' . $email);
logSecurityEvent('admin_action', $user_id, 'Deleted user: ' . $target_user_id);
```

---

## 🔍 Security Monitoring

### Security Headers

#### HTTP Security Headers
```php
// Set security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
```

#### Header Explanations
- **X-Content-Type-Options**: Prevents MIME type sniffing
- **X-Frame-Options**: Prevents clickjacking
- **X-XSS-Protection**: Enables browser XSS protection
- **Referrer-Policy**: Controls referrer information
- **Permissions-Policy**: Controls browser feature access

### Security Auditing

#### Regular Security Checks
```php
// Security audit function
function performSecurityAudit() {
    $audit_results = [];
    
    // Check for weak passwords
    $weak_passwords = checkWeakPasswords($connection);
    $audit_results['weak_passwords'] = $weak_passwords;
    
    // Check for inactive sessions
    $inactive_sessions = checkInactiveSessions();
    $audit_results['inactive_sessions'] = $inactive_sessions;
    
    // Check for failed login attempts
    $failed_logins = checkFailedLogins();
    $audit_results['failed_logins'] = $failed_logins;
    
    return $audit_results;
}
```

---

## 🚀 Security Best Practices

### Development Guidelines

#### 1. Input Validation Checklist
- [ ] Validate all user inputs
- [ ] Sanitize output data
- [ ] Use prepared statements
- [ ] Implement CSRF protection
- [ ] Validate file uploads

#### 2. Authentication Checklist
- [ ] Use strong password hashing
- [ ] Implement session security
- [ ] Use HTTPS in production
- [ ] Implement account lockout
- [ ] Log security events

#### 3. Authorization Checklist
- [ ] Implement role-based access
- [ ] Check permissions at function level
- [ ] Validate user ownership
- [ ] Implement least privilege
- [ ] Regular permission audits

### Security Testing

#### Penetration Testing Checklist
- [ ] SQL injection testing
- [ ] XSS vulnerability testing
- [ ] CSRF attack testing
- [ ] File upload testing
- [ ] Authentication bypass testing
- [ ] Authorization testing
- [ ] Session management testing

#### Automated Security Tools
- **Static Analysis**: PHP_CodeSniffer with security rules
- **Dynamic Testing**: OWASP ZAP, Burp Suite
- **Dependency Scanning**: Composer audit
- **Code Review**: Manual security code review

---

## 📋 Security Incident Response

### Incident Response Plan

#### 1. Detection
- Monitor error logs
- Watch for unusual activity
- Automated alerts for security events

#### 2. Assessment
- Determine scope of incident
- Identify affected systems
- Assess potential data exposure

#### 3. Containment
- Isolate affected systems
- Disable compromised accounts
- Block malicious IP addresses

#### 4. Eradication
- Remove malware/backdoors
- Patch vulnerabilities
- Update security controls

#### 5. Recovery
- Restore from clean backups
- Verify system integrity
- Monitor for recurrence

#### 6. Lessons Learned
- Document incident details
- Update security procedures
- Improve monitoring systems

---

This comprehensive security model ensures that AuraEdition maintains the highest standards of security while providing a robust and user-friendly e-commerce platform. Regular security audits, monitoring, and updates are essential to maintaining this security posture. 