# InfinityFree Deployment Checklist

## Pre-Deployment
- [ ] Update database credentials in config/config.infinityfree.php
- [ ] Update BASE_URL in config/config.infinityfree.php
- [ ] Test all functionality locally
- [ ] Backup current database
- [ ] Optimize images (compress if needed)

## InfinityFree Setup
- [ ] Create InfinityFree account at infinityfree.net
- [ ] Create hosting account with free subdomain
- [ ] Wait for hosting activation (5-10 minutes)
- [ ] Access File Manager in hosting control panel

## File Upload
- [ ] Upload auraedition-infinityfree.zip to File Manager
- [ ] Extract files in htdocs directory
- [ ] Delete ZIP file after extraction
- [ ] Set file permissions (755 for directories, 644 for files)

## Database Setup
- [ ] Create MySQL database in InfinityFree control panel
- [ ] Note down database credentials
- [ ] Import schema.sql to create tables
- [ ] Import auraedition_data_[timestamp].sql to add data
- [ ] Update config/config.infinityfree.php with database credentials

## Post-Deployment
- [ ] Test home page loads
- [ ] Test user registration/login
- [ ] Test product browsing
- [ ] Test shopping cart
- [ ] Test checkout process
- [ ] Test admin panel
- [ ] Verify SSL certificate (automatic)
- [ ] Test email functionality
- [ ] Check error logs

## Security
- [ ] Verify file permissions
- [ ] Test file upload restrictions
- [ ] Verify CSRF protection
- [ ] Check for exposed error messages

## Performance
- [ ] Verify Tailwind CSS is loading
- [ ] Test page load speeds
- [ ] Monitor bandwidth usage
- [ ] Optimize database queries if needed
