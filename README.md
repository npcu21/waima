# Waima

## Project Overview

**Waima** is a Laravel-based web application developed using **PHP** and **MySQL**.

This README provides the basic technical information required for developers or server administrators to understand and deploy the existing Waima project.

> This document is for deploying the existing project code. It does not cover fresh Laravel installation or project development setup.

---

## Technology Stack

- **Framework:** Laravel
- **Backend:** PHP
- **Database:** MySQL / MariaDB
- **Web Server:** Apache or Nginx
- **Dependency Manager:** Composer
- **Frontend:** HTML, CSS, JavaScript (as used by the project)

---

## Basic Project Structure

```text
waima/
├── app/                 # Application logic
├── bootstrap/           # Laravel bootstrap files
├── config/              # Application configuration
├── database/            # Migrations, seeders and factories
├── public/              # Public web root
├── resources/           # Views and frontend resources
├── routes/              # Application routes
├── storage/             # Logs, cache and generated files
├── vendor/              # Composer dependencies
├── .env                 # Environment configuration
├── artisan              # Laravel command-line tool
└── composer.json        # PHP dependency configuration
```

---

## Server Requirements

Recommended production environment:

- PHP 8.0 or higher
- MySQL 5.7+ / MariaDB
- Apache or Nginx
- Composer
- SSL certificate / HTTPS

Required PHP extensions should include:

- OpenSSL
- PDO
- Mbstring
- Tokenizer
- XML
- Ctype
- JSON
- BCMath
- Fileinfo

---

## Environment Configuration

The application uses the Laravel `.env` file for environment-specific settings.

Example:

```env
APP_NAME=Waima
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

The actual `.env` file should contain the credentials and settings for the target server.

**Important:** Never expose the `.env` file publicly or commit production credentials to Git.

---

## Deployment Summary

For direct deployment of the existing Waima code:

1. Upload the complete project files to the server.
2. Configure the `.env` file.
3. Create/configure the MySQL database.
4. Import the project database if an SQL backup is provided.
5. Ensure Composer dependencies are available.
6. Point the domain/document root to:
   ```text
   /waima/public
   ```
7. Set write permissions for:
   ```text
   storage/
   bootstrap/cache/
   ```
8. Configure PHP and the web server.
9. Clear/cache Laravel configuration as required.
10. Test the application and review Laravel logs if needed.

---

## PHP Configuration

The PHP configuration should support the application's expected resource requirements.

Typical production settings:

```ini
memory_limit = 512M
upload_max_filesize = 50M
post_max_size = 50M
max_execution_time = 300
```

The exact values may be adjusted according to server capacity and application requirements.

---

## Database

Waima uses MySQL/MariaDB.

Before making the application live:

- Create the production database.
- Create a dedicated database user.
- Grant the required permissions.
- Update the database details in `.env`.
- Import the supplied database backup, if applicable.

---

## Web Root

For security, the web server should point to the Laravel `public` directory rather than the project root.

Example:

```text
/var/www/html/waima/public
```

Do not expose application directories such as `app`, `config`, `storage`, or `.env` directly through the web server.

---

## Permissions

Laravel needs write access to:

```text
storage/
bootstrap/cache/
```

Example:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

Permissions should be adjusted according to the server's web-server user and security policy.

---

## Laravel Cache

After changing the production `.env` configuration, the Laravel configuration/cache may need to be refreshed:

```bash
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

If appropriate for the project, routes and views can also be cached:

```bash
php artisan route:cache
php artisan view:cache
```

---

## Storage

If the application uses Laravel's public storage system, create the storage link:

```bash
php artisan storage:link
```

---

## Logs

Laravel application logs are normally located at:

```text
storage/logs/laravel.log
```

For a production issue, check:

- Laravel logs
- PHP error logs
- Apache/Nginx logs
- MySQL logs
- Server permissions

---

## Production Checklist

Before going live, verify:

- [ ] PHP version is compatible
- [ ] Required PHP extensions are enabled
- [ ] MySQL database is configured
- [ ] `.env` is configured
- [ ] `APP_DEBUG=false`
- [ ] `APP_KEY` is present
- [ ] Domain points to `/public`
- [ ] `storage` is writable
- [ ] `bootstrap/cache` is writable
- [ ] HTTPS is enabled
- [ ] Database backup is available
- [ ] Application loads successfully
- [ ] Login and major application functions have been tested

---

## Maintenance

For future deployments or code updates:

1. Take a database backup.
2. Upload/deploy the new code.
3. Update dependencies if required.
4. Verify `.env` is preserved.
5. Clear/rebuild Laravel caches.
6. Check permissions.
7. Test the application.
8. Review logs.

---

## Project Information

**Project:** Waima  
**Framework:** Laravel  
**Language:** PHP  
**Database:** MySQL / MariaDB  
**Deployment Type:** Existing code / production deployment

