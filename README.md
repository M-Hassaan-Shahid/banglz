# Banglz - E-Commerce Platform

A comprehensive Laravel-based e-commerce platform for jewelry and bangles, featuring customer portal management, product catalog, shopping cart, payment integration, and more.

![Laravel](https://img.shields.io/badge/Laravel-10.x-red)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue)
![License](https://img.shields.io/badge/License-MIT-green)

## 📋 Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Running the Application](#running-the-application)
- [Project Structure](#project-structure)
- [Key Features](#key-features)
- [Testing](#testing)
- [Troubleshooting](#troubleshooting)
- [Contributing](#contributing)
- [License](#license)

## ✨ Features

### Customer Features
- **User Authentication**: Registration, login, and password management
- **Customer Portal**: 
  - Shipping address management (up to 3 addresses)
  - Password change with email notification
  - Communication preferences management
  - Subscription toggle functionality
- **Product Catalog**: Browse products by categories, collections, and tags
- **Advanced Filtering**: Filter by materials, styles, sizes, colors, and boxes
- **Product Sorting**: Sort by name (A-Z, Z-A) and price (Low to High, High to Low)
- **Shopping Cart**: Add products, manage quantities, and apply gift cards
- **Wishlist**: Save favorite products
- **Bundles**: Create product bundles with rewards
- **Banglz Box**: Custom bangle box builder
- **Gift Cards**: Purchase and redeem gift cards
- **Order Management**: Track orders and view order history
- **Product Notifications**: Get notified when products are back in stock

### Admin Features
- **Product Management**: CRUD operations for products, variations, and colors
- **Category Management**: Organize products into categories and subcategories
- **Order Management**: View and manage customer orders
- **Customer Management**: View customer information and orders
- **Blog Management**: Create and manage blog posts
- **Page Settings**: Customize homepage and other pages
- **Shipping Management**: Configure shipping options

### Payment Integration
- **Stripe**: Credit card payments
- **PayPal**: PayPal checkout integration

### Additional Features
- **Responsive Design**: Mobile-friendly interface
- **SEO Optimized**: Meta tags and structured data
- **Email Notifications**: Order confirmations, password changes, preferences updates
- **Session Management**: Secure session handling
- **CSRF Protection**: Built-in security features
- **Yotpo Integration**: Customer reviews and ratings (optional)

## 🔧 Requirements

- **PHP**: >= 8.1
- **Composer**: Latest version
- **Node.js**: >= 16.x
- **NPM**: >= 8.x
- **Database**: MySQL 5.7+ or MariaDB 10.3+
- **Web Server**: Apache or Nginx
- **PHP Extensions**:
  - BCMath
  - Ctype
  - Fileinfo
  - JSON
  - Mbstring
  - OpenSSL
  - PDO
  - PDO_MySQL
  - Tokenizer
  - XML

## 📦 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/M-Hassaan-Shahid/banglz.git
cd banglz
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the example environment file and configure it:

```bash
cp .env.example .env
```

Edit `.env` file with your configuration:

```env
APP_NAME=Banglz
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=banglz
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

MAIL_MAILER=smtp
MAIL_HOST=your_mail_host
MAIL_PORT=587
MAIL_USERNAME=your_mail_username
MAIL_PASSWORD=your_mail_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@banglz.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Build Frontend Assets

```bash
npm run build
```

For development with hot reload:

```bash
npm run dev
```

## 🗄️ Database Setup

### 1. Create Database

**For MySQL/MariaDB:**

```bash
# Login to MySQL
sudo mysql -u root -p

# Create database
CREATE DATABASE banglz CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Create user (optional but recommended)
CREATE USER 'banglz_user'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON banglz.* TO 'banglz_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 2. Run Migrations

```bash
php artisan migrate
```

This will create all necessary tables including:
- Users and authentication tables
- Products, categories, and collections
- Shopping cart and orders
- Shipping addresses
- Gift cards
- Sessions
- And more...

### 3. Seed Database (Optional)

```bash
php artisan db:seed
```

This will seed:
- Admin user account
- Sample categories
- Bangle box sizes and colors
- Appointments page settings

**Default Admin Credentials** (if seeded):
- Check `database/seeders/AdminUserSeeder.php` for credentials

### 4. Create Storage Link

```bash
php artisan storage:link
```

## 🚀 Running the Application

### Development Server

```bash
php artisan serve
```

The application will be available at: `http://127.0.0.1:8000`

### Production Deployment

For production, configure your web server (Apache/Nginx) to point to the `public` directory.

**Apache Example (.htaccess is included):**

```apache
<VirtualHost *:80>
    ServerName banglz.com
    DocumentRoot /path/to/banglz/public

    <Directory /path/to/banglz/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

**Nginx Example:**

```nginx
server {
    listen 80;
    server_name banglz.com;
    root /path/to/banglz/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## � Project Structure

```
banglz/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Application controllers
│   │   ├── Middleware/       # Custom middleware
│   │   └── Requests/         # Form request validators
│   ├── Mail/                 # Email templates
│   ├── Models/               # Eloquent models
│   └── Services/             # Business logic services
├── config/                   # Configuration files
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── public/
│   ├── assets/               # Static assets (CSS, JS, images)
│   └── index.php             # Application entry point
├── resources/
│   ├── css/                  # Source CSS files
│   ├── js/                   # Source JavaScript files
│   └── views/                # Blade templates
├── routes/
│   ├── web.php               # Web routes
│   └── api.php               # API routes
├── storage/                  # Application storage
├── tests/                    # Test files
├── .env.example              # Example environment file
├── composer.json             # PHP dependencies
├── package.json              # Node dependencies
└── README.md                 # This file
```

## 🎯 Key Features

### Customer Portal

Access the customer portal after logging in:

1. **Shipping Addresses** (`/addresses`)
   - Add up to 3 shipping addresses
   - Edit existing addresses
   - Delete addresses
   - Set default address

2. **Password Management** (`/password/edit`)
   - Change password securely
   - Receive email confirmation

3. **Communication Preferences** (`/preferences/edit`)
   - Manage email subscriptions
   - Update notification settings
   - Receive confirmation emails

4. **Subscription Toggle**
   - Quick subscribe/unsubscribe from marketing emails
   - AJAX-powered for instant updates

### Product Catalog

Browse products with advanced features:

1. **Filtering**
   - By material (gold, silver, etc.)
   - By style (traditional, modern, etc.)
   - By size (Kid, 2.4, 2.6, etc.)
   - By color
   - By box type

2. **Sorting**
   - Name (A-Z, Z-A)
   - Price (Low to High, High to Low)
   - Latest products

3. **Mobile-Friendly**
   - Slide-in filter sidebar on mobile
   - Touch-optimized interface

### Shopping Experience

1. **Cart Management**
   - Add products with variations
   - Update quantities
   - Apply gift cards
   - Calculate shipping

2. **Checkout**
   - Multiple payment options
   - Address selection
   - Order summary

3. **Order Tracking**
   - View order history
   - Track shipments
   - Download invoices

## 🧪 Testing

Run the test suite:

```bash
php artisan test
```

Or with PHPUnit directly:

```bash
./vendor/bin/phpunit
```

## 🔍 Troubleshooting

### Common Issues

#### 1. "SQLSTATE[HY000] [1698] Access denied for user 'root'@'localhost'"

**Solution**: Create a dedicated MySQL user with password authentication:

```bash
sudo mysql
CREATE USER 'banglz_user'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON banglz.* TO 'banglz_user'@'localhost';
FLUSH PRIVILEGES;
```

Update `.env`:
```env
DB_USERNAME=banglz_user
DB_PASSWORD=your_password
```

#### 2. "could not find driver"

**Solution**: Install PHP MySQL extension:

```bash
# Ubuntu/Debian
sudo apt-get install php8.1-mysql

# CentOS/RHEL
sudo yum install php81-mysqlnd
```

Restart your web server after installation.

#### 3. "The stream or file could not be opened"

**Solution**: Fix storage permissions:

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### 4. "419 Page Expired" on form submission

**Solution**: Ensure CSRF token is included in forms and AJAX requests:

```javascript
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
```

#### 5. Missing images (404 errors)

**Solution**: Ensure storage link is created and images exist:

```bash
php artisan storage:link
```

Check if images exist in `public/assets/images/` or `storage/app/public/`.

#### 6. "Table 'sessions' doesn't exist"

**Solution**: Run migrations:

```bash
php artisan migrate
```

If the migration exists but wasn't run, check migration status:

```bash
php artisan migrate:status
```

### Performance Optimization

#### 1. Cache Configuration

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### 2. Optimize Autoloader

```bash
composer install --optimize-autoloader --no-dev
```

#### 3. Enable OPcache

Edit `php.ini`:

```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=60
```

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Coding Standards

- Follow PSR-12 coding standards
- Write meaningful commit messages
- Add tests for new features
- Update documentation as needed

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🙏 Acknowledgments

- Laravel Framework
- Bootstrap CSS Framework
- Stripe Payment Gateway
- PayPal Payment Gateway
- Slick Carousel
- Swiper.js
- Font Awesome Icons

## � Support

For support, email support@banglz.com or open an issue on GitHub.

## 🔗 Links

- **Website**: [https://banglz.com](https://banglz.com)
- **Repository**: [https://github.com/M-Hassaan-Shahid/banglz](https://github.com/M-Hassaan-Shahid/banglz)
- **Documentation**: [https://docs.banglz.com](https://docs.banglz.com)

---

**Built with ❤️ by the Banglz Team**

**Powered by [Growth Tap Digital](https://growthtapdigital.com)**
