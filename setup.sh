#!/bin/bash

# Banglz Setup Script
# This script automates the setup process for the Banglz e-commerce platform

set -e

echo "========================================="
echo "  Banglz E-Commerce Platform Setup"
echo "========================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Function to print colored output
print_success() {
    echo -e "${GREEN}✓ $1${NC}"
}

print_error() {
    echo -e "${RED}✗ $1${NC}"
}

print_info() {
    echo -e "${YELLOW}ℹ $1${NC}"
}

# Check if running as root
if [ "$EUID" -eq 0 ]; then 
    print_error "Please do not run this script as root"
    exit 1
fi

# Check PHP version
print_info "Checking PHP version..."
PHP_VERSION=$(php -r "echo PHP_VERSION;" 2>/dev/null || echo "0")
if [ "$PHP_VERSION" == "0" ]; then
    print_error "PHP is not installed"
    exit 1
fi

PHP_MAJOR=$(echo $PHP_VERSION | cut -d. -f1)
PHP_MINOR=$(echo $PHP_VERSION | cut -d. -f2)

if [ "$PHP_MAJOR" -lt 8 ] || ([ "$PHP_MAJOR" -eq 8 ] && [ "$PHP_MINOR" -lt 1 ]); then
    print_error "PHP 8.1 or higher is required. Current version: $PHP_VERSION"
    exit 1
fi
print_success "PHP version $PHP_VERSION detected"

# Check Composer
print_info "Checking Composer..."
if ! command -v composer &> /dev/null; then
    print_error "Composer is not installed. Please install Composer first."
    exit 1
fi
print_success "Composer is installed"

# Check Node.js
print_info "Checking Node.js..."
if ! command -v node &> /dev/null; then
    print_error "Node.js is not installed. Please install Node.js first."
    exit 1
fi
NODE_VERSION=$(node -v)
print_success "Node.js $NODE_VERSION detected"

# Check NPM
print_info "Checking NPM..."
if ! command -v npm &> /dev/null; then
    print_error "NPM is not installed. Please install NPM first."
    exit 1
fi
NPM_VERSION=$(npm -v)
print_success "NPM $NPM_VERSION detected"

# Check MySQL/MariaDB
print_info "Checking MySQL/MariaDB..."
if ! command -v mysql &> /dev/null; then
    print_error "MySQL/MariaDB is not installed. Please install MySQL or MariaDB first."
    exit 1
fi
print_success "MySQL/MariaDB is installed"

echo ""
echo "========================================="
echo "  Installing Dependencies"
echo "========================================="
echo ""

# Install Composer dependencies
print_info "Installing PHP dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader
print_success "PHP dependencies installed"

# Install NPM dependencies
print_info "Installing Node.js dependencies..."
npm install
print_success "Node.js dependencies installed"

echo ""
echo "========================================="
echo "  Environment Configuration"
echo "========================================="
echo ""

# Create .env file if it doesn't exist
if [ ! -f .env ]; then
    print_info "Creating .env file..."
    cp .env.example .env
    print_success ".env file created"
else
    print_info ".env file already exists, skipping..."
fi

# Generate application key
print_info "Generating application key..."
php artisan key:generate --ansi
print_success "Application key generated"

echo ""
echo "========================================="
echo "  Database Configuration"
echo "========================================="
echo ""

# Prompt for database configuration
read -p "Enter database name [banglz]: " DB_NAME
DB_NAME=${DB_NAME:-banglz}

read -p "Enter database username [root]: " DB_USER
DB_USER=${DB_USER:-root}

read -sp "Enter database password: " DB_PASS
echo ""

read -p "Enter database host [127.0.0.1]: " DB_HOST
DB_HOST=${DB_HOST:-127.0.0.1}

read -p "Enter database port [3306]: " DB_PORT
DB_PORT=${DB_PORT:-3306}

# Update .env file
print_info "Updating .env file with database credentials..."
sed -i "s/DB_DATABASE=.*/DB_DATABASE=$DB_NAME/" .env
sed -i "s/DB_USERNAME=.*/DB_USERNAME=$DB_USER/" .env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$DB_PASS/" .env
sed -i "s/DB_HOST=.*/DB_HOST=$DB_HOST/" .env
sed -i "s/DB_PORT=.*/DB_PORT=$DB_PORT/" .env
print_success "Database credentials updated"

# Ask if user wants to create database
read -p "Do you want to create the database? (y/n) [y]: " CREATE_DB
CREATE_DB=${CREATE_DB:-y}

if [ "$CREATE_DB" == "y" ] || [ "$CREATE_DB" == "Y" ]; then
    print_info "Creating database..."
    if [ -z "$DB_PASS" ]; then
        sudo mysql -u $DB_USER -e "CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null || print_error "Failed to create database. Please create it manually."
    else
        sudo mysql -u $DB_USER -p$DB_PASS -e "CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null || print_error "Failed to create database. Please create it manually."
    fi
    print_success "Database created (if it didn't exist)"
fi

echo ""
echo "========================================="
echo "  Running Migrations"
echo "========================================="
echo ""

# Run migrations
print_info "Running database migrations..."
php artisan migrate --force
print_success "Migrations completed"

# Ask if user wants to seed database
read -p "Do you want to seed the database with sample data? (y/n) [y]: " SEED_DB
SEED_DB=${SEED_DB:-y}

if [ "$SEED_DB" == "y" ] || [ "$SEED_DB" == "Y" ]; then
    print_info "Seeding database..."
    php artisan db:seed --force
    print_success "Database seeded"
fi

echo ""
echo "========================================="
echo "  Building Assets"
echo "========================================="
echo ""

# Build frontend assets
print_info "Building frontend assets..."
npm run build
print_success "Assets built"

# Create storage link
print_info "Creating storage link..."
php artisan storage:link
print_success "Storage link created"

# Set permissions
print_info "Setting permissions..."
chmod -R 775 storage bootstrap/cache
print_success "Permissions set"

echo ""
echo "========================================="
echo "  Setup Complete!"
echo "========================================="
echo ""
print_success "Banglz has been successfully set up!"
echo ""
echo "To start the development server, run:"
echo "  php artisan serve"
echo ""
echo "Then visit: http://127.0.0.1:8000"
echo ""
echo "For production deployment, configure your web server to point to the 'public' directory."
echo ""
print_info "Check README.md for more information."
echo ""
