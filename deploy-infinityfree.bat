@echo off
REM AuraEdition InfinityFree Deployment Script
REM This script prepares your application for InfinityFree hosting

echo 🚀 AuraEdition InfinityFree Deployment Preparation
echo ================================================

REM Colors for output
set "GREEN=[92m"
set "YELLOW=[93m"
set "RED=[91m"
set "NC=[0m"

REM Function to print colored output
call :print_status "Starting deployment preparation..."

REM Check if Node.js is installed
node --version >nul 2>&1
if %errorlevel% neq 0 (
    call :print_error "Node.js is not installed. Please install Node.js 14+ first."
    pause
    exit /b 1
)

call :print_status "Node.js is available"

REM Install dependencies
echo 📦 Installing Node.js dependencies...
call npm install
if %errorlevel% neq 0 (
    call :print_error "Failed to install dependencies"
    pause
    exit /b 1
)
call :print_status "Dependencies installed successfully"

REM Build Tailwind CSS
echo 🎨 Building Tailwind CSS...
call npx tailwindcss -i ./assets/css/input.css -o ./assets/css/tailwind.css --minify
if %errorlevel% neq 0 (
    call :print_error "Failed to build Tailwind CSS"
    pause
    exit /b 1
)
call :print_status "Tailwind CSS built successfully"

REM Create InfinityFree configuration template
echo ⚙️ Creating InfinityFree configuration template...
(
echo ^<?php
echo /**
echo  * InfinityFree Configuration File
echo  *
echo  * Update these values with your InfinityFree database credentials
echo  */
echo.
echo // --- Database Configuration ---
echo define^('DB_HOST', 'your-mysql-host.infinityfree.com'^);
echo define^('DB_USER', 'yourname_auraedition_user'^);
echo define^('DB_PASS', 'your-database-password'^);
echo define^('DB_NAME', 'yourname_auraedition'^);
echo.
echo // --- Path and URL Configuration ---
echo define^('BASE_PATH', $_SERVER['DOCUMENT_ROOT']^);
echo define^('BASE_URL', 'https://yourname.infinityfree.com'^);
echo.
echo // --- Production Settings ---
echo error_reporting^(0^);
echo ini_set^('display_errors', 0^);
echo ini_set^('log_errors', 1^);
echo ini_set^('error_log', 'error.log'^);
echo.
echo ?^>
) > config\config.infinityfree.php

call :print_status "InfinityFree configuration template created"

REM Create optimized .htaccess for InfinityFree
echo 🌐 Creating optimized .htaccess file...
(
echo RewriteEngine On
echo.
echo # Handle front controller pattern
echo RewriteCond %%{REQUEST_FILENAME} !-f
echo RewriteCond %%{REQUEST_FILENAME} !-d
echo RewriteRule ^(.*^)$ index.php [QSA,L]
echo.
echo # Security headers
echo Header always set X-Frame-Options DENY
echo Header always set X-Content-Type-Options nosniff
echo Header always set X-XSS-Protection "1; mode=block"
echo Header always set Referrer-Policy "strict-origin-when-cross-origin"
echo.
echo # Enable compression
echo ^<IfModule mod_deflate.c^>
echo     AddOutputFilterByType DEFLATE text/plain
echo     AddOutputFilterByType DEFLATE text/html
echo     AddOutputFilterByType DEFLATE text/xml
echo     AddOutputFilterByType DEFLATE text/css
echo     AddOutputFilterByType DEFLATE application/xml
echo     AddOutputFilterByType DEFLATE application/xhtml+xml
echo     AddOutputFilterByType DEFLATE application/rss+xml
echo     AddOutputFilterByType DEFLATE application/javascript
echo     AddOutputFilterByType DEFLATE application/x-javascript
echo ^</IfModule^>
echo.
echo # Enable caching
echo ^<IfModule mod_expires.c^>
echo     ExpiresActive On
echo     ExpiresByType text/css "access plus 1 month"
echo     ExpiresByType application/javascript "access plus 1 month"
echo     ExpiresByType image/png "access plus 1 month"
echo     ExpiresByType image/jpg "access plus 1 month"
echo     ExpiresByType image/jpeg "access plus 1 month"
echo     ExpiresByType image/gif "access plus 1 month"
echo     ExpiresByType image/svg+xml "access plus 1 month"
echo ^</IfModule^>
echo.
echo # Protect sensitive files
echo ^<Files "config.php"^>
echo     Order allow,deny
echo     Deny from all
echo ^</Files^>
echo.
echo # InfinityFree specific optimizations
echo ^<IfModule mod_headers.c^>
echo     Header set Cache-Control "public, max-age=31536000"
echo ^</IfModule^>
) > .htaccess

call :print_status ".htaccess file created"

REM Create deployment checklist
echo 📋 Creating InfinityFree deployment checklist...
(
echo # InfinityFree Deployment Checklist
echo.
echo ## Pre-Deployment
echo - [ ] Update database credentials in config/config.infinityfree.php
echo - [ ] Update BASE_URL in config/config.infinityfree.php
echo - [ ] Test all functionality locally
echo - [ ] Backup current database
echo - [ ] Optimize images ^(compress if needed^)
echo.
echo ## InfinityFree Setup
echo - [ ] Create InfinityFree account at infinityfree.net
echo - [ ] Create hosting account with free subdomain
echo - [ ] Wait for hosting activation ^(5-10 minutes^)
echo - [ ] Access File Manager in hosting control panel
echo.
echo ## File Upload
echo - [ ] Upload auraedition-infinityfree.zip to File Manager
echo - [ ] Extract files in htdocs directory
echo - [ ] Delete ZIP file after extraction
echo - [ ] Set file permissions ^(755 for directories, 644 for files^)
echo.
echo ## Database Setup
echo - [ ] Create MySQL database in InfinityFree control panel
echo - [ ] Note down database credentials
echo - [ ] Import schema.sql to create tables
echo - [ ] Import auraedition_data_[timestamp].sql to add data
echo - [ ] Update config/config.infinityfree.php with database credentials
echo.
echo ## Post-Deployment
echo - [ ] Test home page loads
echo - [ ] Test user registration/login
echo - [ ] Test product browsing
echo - [ ] Test shopping cart
echo - [ ] Test checkout process
echo - [ ] Test admin panel
echo - [ ] Verify SSL certificate ^(automatic^)
echo - [ ] Test email functionality
echo - [ ] Check error logs
echo.
echo ## Security
echo - [ ] Verify file permissions
echo - [ ] Test file upload restrictions
echo - [ ] Verify CSRF protection
echo - [ ] Check for exposed error messages
echo.
echo ## Performance
echo - [ ] Verify Tailwind CSS is loading
echo - [ ] Test page load speeds
echo - [ ] Monitor bandwidth usage
echo - [ ] Optimize database queries if needed
) > INFINITYFREE_DEPLOYMENT_CHECKLIST.md

call :print_status "Deployment checklist created"

REM Create production build directory
echo 📁 Creating InfinityFree production build...
if exist infinityfree_build rmdir /s /q infinityfree_build
mkdir infinityfree_build

REM Copy files to production build
xcopy /e /i admin infinityfree_build\admin
xcopy /e /i assets infinityfree_build\assets
xcopy /e /i auth infinityfree_build\auth
xcopy /e /i config infinityfree_build\config
xcopy /e /i docs infinityfree_build\docs
xcopy /e /i includes infinityfree_build\includes
xcopy /e /i pages infinityfree_build\pages
xcopy /e /i process infinityfree_build\process
xcopy /e /i products infinityfree_build\products
xcopy /e /i templates infinityfree_build\templates
copy *.php infinityfree_build\
copy .htaccess infinityfree_build\
copy INFINITYFREE_DEPLOYMENT_CHECKLIST.md infinityfree_build\

REM Remove development files
rmdir /s /q infinityfree_build\node_modules 2>nul
del infinityfree_build\package*.json 2>nul
del infinityfree_build\tailwind.config.js 2>nul
del infinityfree_build\deploy-infinityfree.bat 2>nul

call :print_status "Production build created"

REM Create deployment package
echo 📦 Creating deployment package...
powershell -Command "Compress-Archive -Path 'infinityfree_build\*' -DestinationPath 'auraedition-infinityfree.zip' -Force"

call :print_status "Deployment package created: auraedition-infinityfree.zip"

REM Create database export script for InfinityFree
echo 🗄️ Creating database export script...
(
echo @echo off
echo REM Database Export for InfinityFree
echo echo Exporting database for InfinityFree deployment...
echo.
echo REM Set your XAMPP MySQL path
echo set MYSQL_PATH=C:\xampp\mysql\bin
echo.
echo REM Set database credentials
echo set DB_HOST=localhost
echo set DB_USER=root
echo set DB_PASS=mysql2006
echo set DB_NAME=auraedition
echo.
echo REM Create exports directory
echo if not exist exports mkdir exports
echo.
echo REM Get timestamp
echo for /f "tokens=2 delims==" %%%%a in ^('wmic OS Get localdatetime /value'^) do set "dt=%%%%a"
echo set "YYYY=%%dt:~2,2%%"
echo set "MM=%%dt:~4,2%%"
echo set "DD=%%dt:~6,2%%"
echo set "HH=%%dt:~8,2%%"
echo set "Min=%%dt:~10,2%%"
echo set "Sec=%%dt:~12,2%%"
echo set "datestamp=%%YYYY%%-%%MM%%-%%DD%%_%%HH%%-%%Min%%-%%Sec%%"
echo.
echo REM Export schema
echo "%%MYSQL_PATH%%\mysqldump.exe" -h %%DB_HOST%% -u %%DB_USER%% -p%%DB_PASS%% --no-data --single-transaction --routines --triggers --skip-comments %%DB_NAME%% ^> exports\schema.sql
echo.
echo REM Export data
echo "%%MYSQL_PATH%%\mysqldump.exe" -h %%DB_HOST%% -u %%DB_USER%% -p%%DB_PASS%% --no-create-info --single-transaction --skip-comments %%DB_NAME%% ^> exports\auraedition_data_%%datestamp%%.sql
echo.
echo echo Database exported successfully!
echo echo Files created:
echo echo - exports\schema.sql
echo echo - exports\auraedition_data_%%datestamp%%.sql
echo pause
) > export-db-infinityfree.bat

call :print_status "Database export script created"

echo.
echo 🎉 InfinityFree deployment preparation completed!
echo.
echo Files created:
echo - auraedition-infinityfree.zip ^(Upload this to InfinityFree^)
echo - config\config.infinityfree.php ^(Update with your credentials^)
echo - INFINITYFREE_DEPLOYMENT_CHECKLIST.md ^(Follow this checklist^)
echo - export-db-infinityfree.bat ^(Export your database^)
echo.
echo Next steps:
echo 1. Run export-db-infinityfree.bat to export your database
echo 2. Sign up at infinityfree.net
echo 3. Create hosting account
echo 4. Upload auraedition-infinityfree.zip
echo 5. Follow INFINITYFREE_DEPLOYMENT_CHECKLIST.md
echo.
echo Press any key to open the build folder...
pause ^>nul
start infinityfree_build

goto :eof

:print_status
echo %GREEN%✓%NC% %~1
goto :eof

:print_error
echo %RED%✗%NC% %~1
goto :eof

:print_warning
echo %YELLOW%⚠%NC% %~1
goto :eof 