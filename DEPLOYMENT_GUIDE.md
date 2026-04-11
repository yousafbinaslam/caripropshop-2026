# CariPropShop Deployment Guide

## Pre-Deployment Checklist

### 1. Local Development Complete
- [x] All 13 custom plugins created
- [x] Custom theme with templates
- [x] WordPress REST API configured
- [x] React app built and integrated

### 2. Files Ready for Upload
All files are in the `wordpress/` directory:
- `wp-content/plugins/` - 13 custom plugins
- `wp-content/themes/cari-prop-shop/` - Custom theme
- `wp-content/uploads/` - Media files

### 3. Database Export
```bash
# Export from Podman container
podman exec caripropshop-db mysqldump -u root -pCariPropShop2026! caripropshop > ~/Desktop/caripropshop-database.sql

# Or via wp-cli
wp db export ~/Desktop/caripropshop-database.sql
```

## Live Server Deployment

### Step 1: Prepare Live Server

1. **Domain & Hosting**
   - Domain: caripropshop.com
   - Hosting: VPS or Shared hosting with SSH access
   - PHP: 8.0+
   - MySQL: 5.7+ or MariaDB 10.3+

2. **Create Database**
```sql
CREATE DATABASE caripropshop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'cps_user'@'localhost' IDENTIFIED BY 'YOUR_STRONG_PASSWORD';
GRANT ALL PRIVILEGES ON caripropshop.* TO 'cps_user'@'localhost';
FLUSH PRIVILEGES;
```

### Step 2: Upload Files

1. **Via FTP/SFTP**
   ```
   Upload entire wordpress/ directory to public_html/ or /var/www/html/
   ```

2. **Via SSH (Recommended)**
   ```bash
   # On local machine - create archive
   cd ~/caripropshop
   zip -r caripropshop-deploy.zip wordpress/

   # On server - download and extract
   cd /var/www/html
   wget https://your-backup-url/caripropshop-deploy.zip
   unzip -o caripropshop-deploy.zip
   ```

### Step 3: Configure WordPress

1. **Update wp-config.php**
```php
define('DB_NAME', 'caripropshop');
define('DB_USER', 'cps_user');
define('DB_PASSWORD', 'YOUR_STRONG_PASSWORD');
define('DB_HOST', 'localhost');

define('WP_HOME', 'https://caripropshop.com');
define('WP_SITEURL', 'https://caripropshop.com');

// Security keys (generate at https://api.wordpress.org/secret-key/1.1/salt/)
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

define('FS_METHOD', 'direct');
```

### Step 4: Update URLs in Database

After importing database, run these SQL queries:

```sql
-- Update site URLs
UPDATE wp_options SET option_value = 'https://caripropshop.com' WHERE option_name = 'home';
UPDATE wp_options SET option_value = 'https://caripropshop.com' WHERE option_name = 'siteurl';

-- Update post GUIDs
UPDATE wp_posts SET guid = REPLACE(guid, 'http://localhost:8080', 'https://caripropshop.com');

-- Update post content
UPDATE wp_posts SET post_content = REPLACE(post_content, 'http://localhost:8080', 'https://caripropshop.com');
```

Or use WP-CLI:
```bash
wp search-replace 'http://localhost:8080' 'https://caripropshop.com' --all-tables
```

### Step 5: Set File Permissions

```bash
# Directories
find /var/www/html -type d -exec chmod 755 {} \;

# Files
find /var/www/html -type f -exec chmod 644 {} \;

# wp-content
chmod 755 /var/www/html/wp-content
chmod 755 /var/www/html/wp-content/uploads
chmod 755 /var/www/html/wp-content/cache
```

### Step 6: Configure SSL

```bash
# Using Certbot (Let's Encrypt)
sudo certbot --apache -d caripropshop.com -d www.caripropshop.com
```

### Step 7: Configure Email

Option 1: SMTP Plugin (Recommended)
- Install WP Mail SMTP plugin
- Configure with SendGrid, Mailgun, or SMTP relay

Option 2: Server sendmail
```php
// In wp-config.php
define('WP_mail_FROM', 'noreply@caripropshop.com');
define('WP_MAIL_FROM_NAME', 'CariPropShop');
```

### Step 8: Clear Cache

```bash
# If using caching plugin
wp plugin install wp-super-cache
wp cache flush

# Restart PHP-FPM if needed
sudo systemctl restart php-fpm
```

## Post-Deployment Checklist

- [ ] Verify WordPress loads at https://caripropshop.com
- [ ] Test wp-admin login
- [ ] Check all plugins activated
- [ ] Test property pages
- [ ] Test search functionality
- [ ] Check Google Maps API key
- [ ] Test contact forms
- [ ] Verify SSL certificate
- [ ] Check mobile responsiveness
- [ ] Submit to Google Search Console

## Troubleshooting

### White Screen of Death
```bash
# Enable debug mode in wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

### Database Connection Error
- Verify database credentials in wp-config.php
- Check MySQL service is running
- Verify user has correct permissions

### Styles Not Loading
```bash
# Check file permissions
chmod 755 wp-content
chmod 644 wp-content/themes/cari-prop-shop/style.css
```

### Plugin Activation Issues
```bash
# Check PHP version
php -v

# Verify required extensions
php -m | grep -E 'mysql|gd|mbstring|xml|zip'
```

## Quick Commands for SSH

```bash
# Clear all caches
wp cache flush

# Regenerate .htaccess
wp rewrite flush

# Update plugins
wp plugin update --all

# Reset permalinks
wp rewrite flush

# Clear object cache (if using Redis/Memcached)
redis-cli FLUSHALL
```

## Contact

For deployment support, contact:
- Email: support@caripropshop.com
- Documentation: https://caripropshop.com/docs
