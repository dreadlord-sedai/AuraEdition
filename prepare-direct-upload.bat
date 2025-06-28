@echo off
REM Prepare AuraEdition for direct upload to InfinityFree
REM This script copies all necessary files and excludes development files

echo 🚀 Preparing AuraEdition for direct upload to InfinityFree
echo ========================================================

REM Create upload directory
if exist upload_to_infinityfree rmdir /s /q upload_to_infinityfree
mkdir upload_to_infinityfree

echo 📁 Copying files for upload...

REM Copy all main directories
xcopy /e /i admin upload_to_infinityfree\admin
xcopy /e /i assets upload_to_infinityfree\assets
xcopy /e /i auth upload_to_infinityfree\auth
xcopy /e /i config upload_to_infinityfree\config
xcopy /e /i docs upload_to_infinityfree\docs
xcopy /e /i includes upload_to_infinityfree\includes
xcopy /e /i pages upload_to_infinityfree\pages
xcopy /e /i process upload_to_infinityfree\process
xcopy /e /i products upload_to_infinityfree\products
xcopy /e /i templates upload_to_infinityfree\templates

REM Copy main PHP files
copy *.php upload_to_infinityfree\
copy .htaccess upload_to_infinityfree\

REM Remove development files
echo 🗑️ Removing development files...
rmdir /s /q upload_to_infinityfree\node_modules 2>nul
del upload_to_infinityfree\package*.json 2>nul
del upload_to_infinityfree\tailwind.config.js 2>nul
del upload_to_infinityfree\*.bat 2>nul
del upload_to_infinityfree\*.md 2>nul
del upload_to_infinityfree\*.sql 2>nul
del upload_to_infinityfree\*.mwb 2>nul
rmdir /s /q upload_to_infinityfree\.git 2>nul

REM Create InfinityFree config template
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
) > upload_to_infinityfree\config\config.infinityfree.php

echo.
echo ✅ Files prepared for upload!
echo.
echo 📁 Upload these files to InfinityFree:
echo - Copy everything from 'upload_to_infinityfree' folder
echo - Upload to the 'htdocs' directory in your InfinityFree File Manager
echo.
echo 🔧 After upload:
echo 1. Edit config/config.infinityfree.php with your database credentials
echo 2. Create database in InfinityFree control panel
echo 3. Import your database schema and data
echo.
echo Press any key to open the upload folder...
pause ^>nul
start upload_to_infinityfree 