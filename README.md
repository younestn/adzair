# AdZair - MVP Advertising Platform

A production-ready, full-stack advertising platform built with Laravel 10, Blade, Alpine.js, and MySQL. AdZair enables advertisers to create campaigns, publishers to host ads, and admins to manage the ecosystem.

## 🎯 Features

### Advertiser Features
- Create and manage ad campaigns
- Upload image or text ads
- Set campaign budget and duration
- Enable/disable campaigns
- Track impressions, clicks, and CTR (Click-Through Rate)
- View earnings and campaign performance

### Publisher Features
- Register websites/pages
- Generate unique JavaScript ad snippets
- View real-time earnings
- Request manual payouts
- Track ad placements and performance

### Admin Features
- User management (advertisers and publishers)
- Campaign approval workflow
- Ad moderation and content review
- Withdrawal request management
- Platform analytics dashboard

### Ad Server & Tracking
- RESTful ad serving endpoint
- Smart budget-based ad rotation
- Impression tracking
- Click tracking with verification
- Basic deduplication (IP + User-Agent)

## 🔧 Tech Stack

- **Backend**: Laravel 10
- **Frontend**: Blade templates + Alpine.js
- **Database**: MySQL 8.0+
- **Authentication**: Laravel Breeze
- **Package Manager**: Composer, npm
- **Asset Pipeline**: Vite
- **CSS Framework**: Tailwind CSS

## 📋 System Requirements

- PHP 8.1 or higher
- MySQL 8.0 or higher
- Composer 2.x
- Node.js 16+ with npm
- Git

### Required PHP Extensions
- mbstring
- openssl
- pdo_mysql
- tokenizer
- xml
- ctype
- curl
- json

## 🚀 Installation & Setup

### 1. Clone the Repository
```bash
git clone https://github.com/younestn/adzair.git
cd adzair
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install JavaScript Dependencies
```bash
npm install
```

### 4. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and configure database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=adzair
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Database Setup

#### Create MySQL Database
```bash
mysql -u root -p
CREATE DATABASE adzair CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

#### Run Migrations
```bash
php artisan migrate
```

#### Seed Demo Data
```bash
php artisan db:seed
```

### 6. Build Frontend Assets
```bash
npm run build
```

For development with hot reload:
```bash
npm run dev
```

### 7. Start Development Server
```bash
php artisan serve
```

Access the application at `http://localhost:8000`

## 📝 Default Credentials

After running seeders, use these credentials:

### Admin Account
- **Email**: admin@adzair.test
- **Password**: password
- **Role**: Admin - Full platform access

### Sample Advertiser
- **Email**: advertiser@adzair.test
- **Password**: password
- **Role**: Advertiser - Create campaigns, manage ads

### Sample Publisher
- **Email**: publisher@adzair.test
- **Password**: password
- **Role**: Publisher - Host ads, track earnings

## 🎯 Project Structure

```
adzair/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── CampaignController.php
│   │   │   ├── AdController.php
│   │   │   ├── PublisherController.php
│   │   │   ├── AdminController.php
│   │   │   ├── TrackingController.php
│   │   │   └── AdServerController.php
│   │   └── Middleware/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Campaign.php
│   │   ├── Ad.php
│   │   ├── Website.php
│   │   ├── Impression.php
│   │   ├── Click.php
│   │   ├── Earning.php
│   │   └── Withdrawal.php
│   └── Services/
│       ├── AdServerService.php
│       ├── TrackingService.php
│       └── EarningService.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   ├── auth/
│   │   ├── advertiser/
│   │   ├── publisher/
│   │   └── admin/
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php
│   ├── api.php
│   └── auth.php
└── public/
    └── ad-server.js
```

## 🔑 Key Endpoints

### Authentication
- `POST /register` - User registration
- `POST /login` - User login
- `POST /logout` - User logout

### Advertiser Routes
- `GET /advertiser/dashboard` - Campaign overview
- `GET /advertiser/campaigns` - List campaigns
- `POST /advertiser/campaigns` - Create campaign
- `GET /advertiser/campaigns/{id}/edit` - Edit campaign
- `PATCH /advertiser/campaigns/{id}` - Update campaign
- `POST /advertiser/campaigns/{id}/toggle` - Enable/disable
- `GET /advertiser/analytics` - Performance metrics

### Publisher Routes
- `GET /publisher/dashboard` - Publisher overview
- `GET /publisher/websites` - List websites
- `POST /publisher/websites` - Register website
- `GET /publisher/earnings` - Earnings history
- `POST /publisher/withdrawals` - Request payout

### Admin Routes
- `GET /admin/dashboard` - Admin overview
- `GET /admin/users` - Manage users
- `GET /admin/campaigns` - Approve campaigns
- `GET /admin/ads` - Moderate ads
- `GET /admin/withdrawals` - Manage payouts

### Ad Server API
- `GET /api/ads/serve` - Serve ads (public)
- `POST /api/ads/track/impression` - Track impression
- `POST /api/ads/track/click` - Track click

## 🛠️ Database Schema

### Users Table
Stores all platform users with role-based access

### Campaigns Table
Advertiser campaign configurations with budget and duration

### Ads Table
Individual ad creatives linked to campaigns

### Websites Table
Publisher-registered properties for ad placement

### Impressions Table
Tracking data for ad views

### Clicks Table
Tracking data for ad interactions

### Earnings Table
Publisher earnings calculation and history

### Withdrawals Table
Payout request management

## 🚦 Workflow Examples

### Creating an Ad Campaign (Advertiser)
1. Login as advertiser
2. Navigate to "Create Campaign"
3. Set title, budget, duration
4. Upload ad image or enter text
5. Submit for approval
6. Admin reviews and approves
7. Campaign goes live

### Publishing Ads (Publisher)
1. Login as publisher
2. Register website/page
3. Get unique JavaScript snippet
4. Insert snippet into website HTML
5. Ads display automatically
6. Track earnings in real-time
7. Request withdrawal when threshold reached

### Serving Ads
1. JavaScript snippet on publisher site calls ad server
2. Ad server returns active, approved ads
3. Rotation based on remaining budget
4. Impressions tracked via pixel
5. Clicks tracked via JavaScript

## 📊 Tracking & Deduplication

- **Impression Deduplication**: Based on IP + User-Agent within 24-hour window
- **Click Tracking**: JavaScript-based click event tracking
- **Data Integrity**: Automatic duplicate removal
- **Analytics**: Real-time CTR and performance metrics

## 🔒 Security Features

- CSRF protection on all forms
- SQL injection prevention via Eloquent ORM
- XSS protection in Blade templates
- Password hashing with bcrypt
- Rate limiting on tracking endpoints
- Middleware-based role authorization

## 📦 Available Commands

```bash
# Run development server
php artisan serve

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Clear cache
php artisan cache:clear

# Generate key
php artisan key:generate

# Build frontend assets
npm run build
npm run dev

# Database reset (development only)
php artisan migrate:fresh --seed
```

## 🐛 Troubleshooting

### "SQLSTATE[HY000]: General error: 1030 Got error 28"
- Ensure MySQL is running and configured in `.env`
- Check database credentials

### "Class not found" errors
- Run `composer install`
- Run `composer dump-autoload`

### Frontend not loading
- Run `npm install`
- Run `npm run build`
- Clear cache with `php artisan cache:clear`

### Permission errors on storage
- Run `chmod -R 775 storage bootstrap/cache`

## 📄 License

MIT License - see LICENSE file for details

## 👤 Author

Younes Teniou - Full-stack Developer

## 🤝 Contributing

Contributions welcome. Please follow Laravel coding standards.

## 📞 Support

For issues and questions, open a GitHub issue.
