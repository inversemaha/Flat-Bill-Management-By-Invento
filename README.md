# Multi-Tenant Flat & Bill Management System

A comprehensive Laravel-based multi-tenant system for managing buildings, flats, and bills with role-based access control and automated email notifications.

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Configuration](#configuration)
- [Live Demo](#live-demo)
- [Multi-Tenant Architecture](#multi-tenant-architecture)
- [User Roles & Permissions](#user-roles--permissions)
- [Email Notifications](#email-notifications)
- [Contributing](#contributing)
- [License](#license)

## ✨ Features

### Core Functionality
- **Multi-tenant architecture** with complete data isolation
- **Role-based access control** (Admin, House Owner)
- **Building and Flat Management** with detailed owner information
- **Tenant Assignment** and management
- **Bill Management** with category support and due tracking
- **Automated Email Notifications** for bill creation and payments
- **Due Amount Management** with forward carrying capability

### Business Features
- **Bill Categories**: Electricity, Gas, Water, Utility Charges
- **Payment Tracking**: Paid/Unpaid status management
- **Tenant Assignment**: Admin-controlled tenant-to-building assignment
- **Multi-tenant Isolation**: House owners can only access their own data
- **Dashboard Analytics**: Overview of buildings, flats, tenants, and bills

## 🛠 Tech Stack

- **Backend**: Laravel 10.x
- **Frontend**: Tailwind CSS, Alpine.js
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Breeze
- **Email**: Laravel Mail with Queue support
- **Architecture**: Service-Repository Pattern
- **Caching**: Redis (optional)
- **Queue**: Database/Redis driver

## 📋 System Requirements

- PHP >= 8.1
- Composer >= 2.0
- Node.js >= 16.x
- MySQL >= 8.0 or PostgreSQL >= 12
- Redis (optional, for caching and queues)

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/inversemaha/Flat-Bill-Management-By-Invento.git
cd flat-bill-management
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Environment Variables

Edit `.env` file with your configuration:

```env
# Application
APP_NAME="Flat Bill Management"
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=flat_bill_management
DB_USERNAME=root
DB_PASSWORD=

# Mail Configuration (for email notifications)
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=#
MAIL_PASSWORD=#
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@flatmanager.com"
MAIL_FROM_NAME="${APP_NAME}"

# Queue (for email processing)
QUEUE_CONNECTION=database
```

## 🗄 Database Setup

### 1. Create Database

```bash
# Create database
mysql -u root -p
CREATE DATABASE flat_bill_management;
EXIT;
```

### 2. Run Migrations and Seeders

```bash
# Run migrations
php artisan migrate

# Seed the database with sample data
php artisan db:seed
```

### 3. Database Structure

The system includes the following tables:

- **users**: Admin and House Owner accounts
- **buildings**: Buildings owned by house owners
- **flats**: Individual flats within buildings
- **tenants**: Tenant information and assignments
- **bill_categories**: Categorized bill types
- **bills**: Individual bills with payment tracking

## ⚙️ Configuration

### 1. Build Assets

```bash
# Build CSS and JS assets
npm run build

# For development to build and watch for changes,
npm run dev
```

### 2. Start the Application

```bash
# Start Laravel development server
php artisan serve

# Start queue worker (for email processing)
php artisan queue:work
```

### 3. Access the Application

**Local Development:**
- **URL**: http://localhost:8000
- **Default Admin**: admin@flatmanager.com / password
- **Default House Owner**: abdullah.mamun@example.com / password

## 🌐 Live Demo

You can test the application using the live demo:

**Demo URL**: https://maha.vocalize.pro/

### Demo Credentials

**Super Admin:**
- **Email**: admin@flatmanager.com
- **Password**: password

**House Owner:**
- **Email**: abdullah.mamun@example.com
- **Password**: password

> **Note**: This is a demo environment. Data may be reset periodically.

## 🏗 Multi-Tenant Architecture

### Implementation Approach

The system uses **column-based tenancy** with the following key components:

#### 1. Tenant Isolation
- Each house owner has their own `house_owner_id`
- Global scopes automatically filter data based on authenticated user
- Middleware provides additional security layers

#### 2. Data Scoping

```php
// Automatic scoping in models
protected static function booted()
{
    static::addGlobalScope(new HouseOwnerScope);
}

// Middleware validation
public function handle(Request $request, Closure $next)
{
    if (!$this->validateTenantAccess($request)) {
        abort(403, 'Access denied');
    }
    return $next($request);
}
```

#### 3. Admin Override
- Admins can bypass tenant restrictions
- Complete system management capabilities
- Cross-tenant data access for administration

### Security Features

- **Query-level filtering**: All database queries automatically scoped
- **Middleware protection**: Route-level tenant validation
- **Model-based isolation**: Eloquent models enforce data separation
- **Admin privileges**: Super admin can manage all tenants

## 👥 User Roles & Permissions

### Admin (Super Admin)
- ✅ Create and manage House Owners
- ✅ Create and assign Tenants to buildings
- ✅ View all tenant details across buildings
- ✅ Remove tenants from any building
- ✅ System-wide analytics and reporting
- ✅ Access all buildings, flats, and bills

### House Owner
- ✅ Create and manage flats in their building
- ✅ Manage flat details (number, owner info)
- ✅ Create bill categories (Electricity, Gas, Water, Utility)
- ✅ Generate bills for flats
- ✅ Track payment status and due amounts
- ✅ Receive email notifications for bill events
- ❌ Cannot access other house owners' data

### Tenant (View-only)
- ✅ View assigned flat details
- ✅ View personal bill history
- ✅ Receive bill creation notifications
- ❌ Cannot modify any data

## 📧 Email Notifications

### Automated Notifications

The system sends automated emails for:

1. **Bill Creation**
   - Sent to: Tenant and House Owner
   - Contains: Bill details, amount, due date, payment instructions

2. **Bill Payment**
   - Sent to: House Owner and Admin
   - Contains: Payment confirmation, amount paid, date

### Email Configuration

```php
// Mail classes
App\Mail\BillCreatedMail  - New bill notification
App\Mail\BillPaidMail     - Payment confirmation

// Queue processing
php artisan queue:work    - Process email queue
```

### Template Features

- **Professional HTML templates** with responsive design
- **Bill details** including property and tenant information
- **Payment instructions** and due date reminders
- **Branding** with system logo and colors

## 🎯 Performance Optimizations

### Database Optimizations
- **Proper indexing** on frequently queried columns
- **Eager loading** to prevent N+1 query problems
- **Query scoping** for efficient data filtering
- **Connection pooling** for high-traffic scenarios

### Application Optimizations
- **Service-Repository pattern** for clean code architecture
- **Caching** for frequently accessed data
- **Queue processing** for email notifications
- **Asset optimization** with Vite

### Example Optimized Query

```php
// Optimized bill retrieval with relationships
$bills = Bill::with(['flat', 'tenant', 'billCategory'])
    ->forCurrentTenant()
    ->whereMonth('created_at', now()->month)
    ->orderBy('due_date', 'asc')
    ->paginate(15);
```

## 🏢 Multi-Tenant Design Decisions

### 1. Column-based vs Schema-based
- **Choice**: Column-based tenancy
- **Reason**: Simpler deployment, shared infrastructure, easier maintenance
- **Trade-off**: Requires careful query scoping vs complete isolation

### 2. Global Scopes vs Manual Filtering
- **Choice**: Global scopes with middleware backup
- **Reason**: Automatic protection, reduces developer error
- **Trade-off**: Less flexibility vs better security

### 3. Admin Access Pattern
- **Choice**: Conditional scope bypassing
- **Reason**: Administrative needs while maintaining security
- **Implementation**: Role-based scope disabling

## 📁 Project Structure

```
flat-bill-management/
├── app/
│   ├── Contracts/          # Repository interfaces
│   ├── Http/
│   │   ├── Controllers/    # Request handling
│   │   ├── Middleware/     # Tenant isolation
│   │   └── Requests/       # Form validation
│   ├── Mail/               # Email templates
│   ├── Models/             # Eloquent models
│   ├── Repositories/       # Data access layer
│   └── Services/           # Business logic
├── database/
│   ├── migrations/         # Database schema
│   └── seeders/           # Sample data
├── resources/
│   ├── views/             # Blade templates
│   └── js/                # Frontend assets
└── tests/                 # Test suites
```


## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

**Built with ❤️ using Laravel & Tailwind CSS**
