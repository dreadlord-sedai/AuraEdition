# Deployment Guide for AuraEdition

This guide covers multiple deployment options for your AuraEdition e-commerce platform, from shared hosting to cloud platforms.

## Table of Contents
- [Prerequisites](#prerequisites)
- [Deployment Options](#deployment-options)
- [Shared Hosting Deployment](#shared-hosting-deployment)
- [VPS/Cloud Deployment](#vpscloud-deployment)
- [Docker Deployment](#docker-deployment)
- [Environment Configuration](#environment-configuration)
- [Post-Deployment Checklist](#post-deployment-checklist)
- [Troubleshooting](#troubleshooting)

## Prerequisites

Before deploying, ensure you have:

- **PHP 7.4+** with the following extensions:
  - `mysqli`
  - `gd` (for image processing)
  - `curl` (for email functionality)
  - `openssl` (for security)
- **MySQL 5.7+** or **MariaDB 10.2+**
- **Node.js 14+** (for Tailwind CSS compilation)
- **Web Server**: Apache or Nginx
- **SSL Certificate** (recommended for production)

## Deployment Options

### 1. Shared Hosting (Easiest)
- **Best for**: Small to medium businesses
- **Providers**: HostGator, Bluehost, SiteGround, A2 Hosting
- **Pros**: Easy setup, managed hosting, affordable
- **Cons**: Limited control, shared resources

### 2. VPS/Cloud Hosting (Recommended)
- **Best for**: Growing businesses, custom requirements
- **Providers**: DigitalOcean, AWS, Google Cloud, Azure, Linode
- **Pros**: Full control, scalable, better performance
- **Cons**: Requires more technical knowledge

### 3. Docker Deployment (Advanced)
- **Best for**: Developers, microservices architecture
- **Pros**: Consistent environment, easy scaling
- **Cons**: More complex setup

## Shared Hosting Deployment

### Step 1: Prepare Your Application

1. **Build Tailwind CSS**:
   ```bash
   npm install
   npx tailwindcss -i ./assets/css/input.css -o ./assets/css/tailwind.css --minify
   ```

2. **Create Production Configuration**:
   ```php
   // config/config.php (Production)
   define('DB_HOST', 'your-db-host');
   define('DB_USER', 'your-db-username');
   define('DB_PASS', 'your-db-password');
   define('DB_NAME', 'your-db-name');
   
   // Update base URL for production
   define('BASE_URL', 'https://yourdomain.com');
   ```

3. **Optimize for Production**:
   - Remove development files (`node_modules/`, `.git/`)
   - Compress images
   - Minify CSS/JS files

### Step 2: Upload to Hosting

1. **Create a ZIP file** of your application (excluding `node_modules/` and `.git/`)
2. **Upload via cPanel File Manager** or FTP
3. **Extract** in your `public_html/` directory

### Step 3: Database Setup

1. **Create Database** in cPanel
2. **Import Schema** (if you have a SQL file)
3. **Update Configuration** with new database credentials

### Step 4: Configure Web Server

**For Apache** (usually automatic):
```apache
# .htaccess file (if needed)
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

**For Nginx**:
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/html;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## VPS/Cloud Deployment

### DigitalOcean Droplet Setup

1. **Create Droplet**:
   ```bash
   # Ubuntu 20.04 LTS recommended
   # Choose your plan (2GB RAM minimum)
   ```

2. **Initial Server Setup**:
   ```bash
   # SSH into your server
   ssh root@your-server-ip
   
   # Create new user
   adduser auraedition
   usermod -aG sudo auraedition
   
   # Switch to new user
   su - auraedition
   ```

3. **Install LAMP Stack**:
   ```bash
   # Update system
   sudo apt update && sudo apt upgrade -y
   
   # Install Apache
   sudo apt install apache2 -y
   
   # Install PHP and extensions
   sudo apt install php7.4 php7.4-mysql php7.4-gd php7.4-curl php7.4-mbstring php7.4-xml php7.4-zip -y
   
   # Install MySQL
   sudo apt install mysql-server -y
   
   # Secure MySQL
   sudo mysql_secure_installation
   ```

4. **Install Node.js**:
   ```bash
   # Install Node.js 16.x
   curl -fsSL https://deb.nodesource.com/setup_16.x | sudo -E bash -
   sudo apt-get install -y nodejs
   ```

5. **Deploy Application**:
   ```bash
   # Clone your repository
   cd /var/www
   sudo git clone https://github.com/yourusername/auraedition.git
   sudo chown -R www-data:www-data auraedition
   
   # Install dependencies and build
   cd auraedition
   npm install
   npx tailwindcss -i ./assets/css/input.css -o ./assets/css/tailwind.css --minify
   ```

6. **Configure Apache**:
   ```bash
   # Create virtual host
   sudo nano /etc/apache2/sites-available/auraedition.conf
   ```

   ```apache
   <VirtualHost *:80>
       ServerName yourdomain.com
       ServerAlias www.yourdomain.com
       DocumentRoot /var/www/auraedition
       
       <Directory /var/www/auraedition>
           AllowOverride All
           Require all granted
       </Directory>
       
       ErrorLog ${APACHE_LOG_DIR}/auraedition_error.log
       CustomLog ${APACHE_LOG_DIR}/auraedition_access.log combined
   </VirtualHost>
   ```

   ```bash
   # Enable site and modules
   sudo a2ensite auraedition.conf
   sudo a2enmod rewrite
   sudo systemctl reload apache2
   ```

7. **Setup SSL with Let's Encrypt**:
   ```bash
   # Install Certbot
   sudo apt install certbot python3-certbot-apache -y
   
   # Get SSL certificate
   sudo certbot --apache -d yourdomain.com -d www.yourdomain.com
   ```

### AWS EC2 Deployment

1. **Launch EC2 Instance**:
   - Choose Amazon Linux 2 or Ubuntu
   - Select appropriate instance type (t3.small minimum)
   - Configure security groups (HTTP:80, HTTPS:443, SSH:22)

2. **Connect and Setup**:
   ```bash
   # Connect via SSH
   ssh -i your-key.pem ec2-user@your-ec2-ip
   
   # Update system
   sudo yum update -y
   
   # Install LAMP stack
   sudo yum install -y httpd php php-mysqlnd php-gd php-curl
   sudo systemctl start httpd
   sudo systemctl enable httpd
   
   # Install MySQL
   sudo yum install -y mysql-server
   sudo systemctl start mysqld
   sudo systemctl enable mysqld
   ```

3. **Deploy Application**:
   ```bash
   # Install Git and Node.js
   sudo yum install -y git
   curl -fsSL https://rpm.nodesource.com/setup_16.x | sudo bash -
   sudo yum install -y nodejs
   
   # Clone and setup application
   cd /var/www/html
   sudo git clone https://github.com/yourusername/auraedition.git
   sudo chown -R apache:apache auraedition
   cd auraedition
   npm install
   npx tailwindcss -i ./assets/css/input.css -o ./assets/css/tailwind.css --minify
   ```

## Docker Deployment

### Create Dockerfile

```dockerfile
# Dockerfile
FROM php:7.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd mysqli

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Install Node.js dependencies and build Tailwind
RUN npm install
RUN npx tailwindcss -i ./assets/css/input.css -o ./assets/css/tailwind.css --minify

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80
```

### Create docker-compose.yml

```yaml
version: '3.8'

services:
  web:
    build: .
    ports:
      - "80:80"
    depends_on:
      - db
    environment:
      - DB_HOST=db
      - DB_USER=auraedition
      - DB_PASS=your_password
      - DB_NAME=auraedition
    volumes:
      - ./uploads:/var/www/html/products/img
      - ./admin-uploads:/var/www/html/admin/assets/images

  db:
    image: mysql:5.7
    environment:
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_DATABASE: auraedition
      MYSQL_USER: auraedition
      MYSQL_PASSWORD: your_password
    volumes:
      - mysql_data:/var/lib/mysql
      - ./database/schema.sql:/docker-entrypoint-initdb.d/schema.sql

volumes:
  mysql_data:
```

### Deploy with Docker

```bash
# Build and run
docker-compose up -d

# View logs
docker-compose logs -f

# Stop services
docker-compose down
```

## Environment Configuration

### Production Configuration Checklist

1. **Database Security**:
   ```php
   // Use strong passwords
   define('DB_PASS', 'your-very-strong-password');
   
   // Consider using environment variables
   define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
   ```

2. **Error Handling**:
   ```php
   // Disable error display in production
   error_reporting(0);
   ini_set('display_errors', 0);
   
   // Enable error logging
   ini_set('log_errors', 1);
   ini_set('error_log', '/path/to/error.log');
   ```

3. **Security Headers**:
   ```php
   // Add to your PHP files or .htaccess
   header("X-Frame-Options: DENY");
   header("X-Content-Type-Options: nosniff");
   header("X-XSS-Protection: 1; mode=block");
   header("Referrer-Policy: strict-origin-when-cross-origin");
   ```

4. **File Permissions**:
   ```bash
   # Set proper permissions
   chmod 755 /var/www/auraedition
   chmod 644 /var/www/auraedition/*.php
   chmod 755 /var/www/auraedition/products/img
   chmod 755 /var/www/auraedition/admin/assets/images
   ```

## Post-Deployment Checklist

### ✅ Basic Functionality
- [ ] Home page loads correctly
- [ ] User registration/login works
- [ ] Product browsing and search functions
- [ ] Shopping cart functionality
- [ ] Checkout process completes
- [ ] Admin panel accessible

### ✅ Security
- [ ] HTTPS enabled
- [ ] Database credentials secure
- [ ] File uploads restricted
- [ ] Error messages don't expose sensitive info
- [ ] CSRF protection working

### ✅ Performance
- [ ] Images optimized
- [ ] CSS/JS minified
- [ ] Database queries optimized
- [ ] Caching enabled (if applicable)

### ✅ Monitoring
- [ ] Error logging configured
- [ ] Backup system in place
- [ ] SSL certificate auto-renewal
- [ ] Server monitoring setup

## Troubleshooting

### Common Issues

1. **500 Internal Server Error**:
   ```bash
   # Check Apache error logs
   sudo tail -f /var/log/apache2/error.log
   
   # Check PHP error logs
   sudo tail -f /var/log/php7.4-fpm.log
   ```

2. **Database Connection Issues**:
   ```bash
   # Test database connection
   mysql -u username -p -h hostname database_name
   
   # Check MySQL status
   sudo systemctl status mysql
   ```

3. **Permission Issues**:
   ```bash
   # Fix file permissions
   sudo chown -R www-data:www-data /var/www/auraedition
   sudo chmod -R 755 /var/www/auraedition
   ```

4. **Tailwind CSS Not Loading**:
   ```bash
   # Rebuild Tailwind CSS
   cd /var/www/auraedition
   npx tailwindcss -i ./assets/css/input.css -o ./assets/css/tailwind.css --minify
   ```

### Performance Optimization

1. **Enable Apache Caching**:
   ```apache
   # Add to .htaccess
   <IfModule mod_expires.c>
       ExpiresActive On
       ExpiresByType text/css "access plus 1 month"
       ExpiresByType application/javascript "access plus 1 month"
       ExpiresByType image/png "access plus 1 month"
       ExpiresByType image/jpg "access plus 1 month"
   </IfModule>
   ```

2. **Enable Gzip Compression**:
   ```apache
   # Add to .htaccess
   <IfModule mod_deflate.c>
       AddOutputFilterByType DEFLATE text/plain
       AddOutputFilterByType DEFLATE text/html
       AddOutputFilterByType DEFLATE text/xml
       AddOutputFilterByType DEFLATE text/css
       AddOutputFilterByType DEFLATE application/xml
       AddOutputFilterByType DEFLATE application/xhtml+xml
       AddOutputFilterByType DEFLATE application/rss+xml
       AddOutputFilterByType DEFLATE application/javascript
       AddOutputFilterByType DEFLATE application/x-javascript
   </IfModule>
   ```

## Support

For deployment issues:
- Check server error logs
- Verify file permissions
- Test database connectivity
- Review configuration files
- Consult hosting provider documentation

---

**Note**: Always backup your database and files before making any deployment changes! 