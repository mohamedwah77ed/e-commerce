# 🛒 Laravel E-Commerce Store

A full-featured e-commerce platform built with Laravel, designed for electronics retail (phones, laptops, tablets, accessories, and more).

---

## ✨ Features

- 🌐 Bilingual support (Arabic / English) with RTL/LTR switching
- 🛍️ Product catalog with categories and brands
- 🔍 Filter by category, brand, and price
- 🛒 Shopping cart (supports both guests and logged-in users)
- 💳 Online payment via **Paymob**
- 📦 Order management with status tracking
- ❌ Order cancellation support
- 🔐 Admin dashboard with full control panel
- 📱 Fully responsive (mobile-first design)
- 🌙 Dark theme frontend

---

## 🧰 Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 10+ |
| Frontend | Blade, Bootstrap 5, Tailwind (cards) |
| Database | MySQL |
| Payment | Paymob |
| Auth | Laravel Sanctum |
| Styling | Custom CSS + Bootstrap RTL/LTR |

---

## 🚀 Getting Started

### Requirements

- PHP 8.1+
- Composer
- MySQL
- Node.js (optional, for assets)

### Installation

```bash
# 1. Clone the repository
git clone (https://github.com/mohamedwah77ed/e-commerce)
cd dubai-phone

# 2. Install dependencies
composer install

# 3. Copy environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Configure your database in .env
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_password

# 6. Run migrations and seeders
php artisan migrate --seed

# 7. Start the development server
php artisan serve
```

---

## ⚙️ Environment Variables

Add these to your `.env` file:

```env
# App
APP_LOCALE=ar

# Paymob
PAYMOB_API_KEY=your_api_key
PAYMOB_INTEGRATION_ID=your_integration_id
PAYMOB_IFRAME_ID=your_iframe_id
PAYMOB_HMAC=your_hmac_secret
PAYMOB_BASE_URL=https://accept.paymob.com
```

---

## 🗂️ Project Structure

```
app/
├── Http/Controllers/
│   ├── OrderController.php       # Order creation & management
│   ├── PaymobController.php      # Payment gateway integration
│   ├── LanguageController.php    # Language switching
│   └── Admin/                    # Admin panel controllers
├── Models/
│   ├── User.php
│   ├── Order.php
│   ├── Product.php
│   ├── Category.php
│   └── Brand.php
├── Services/
│   └── Cart/
│       ├── UserCartService.php   # Cart for logged-in users
│       └── GuestCartService.php  # Cart for guests (session-based)
└── Helpers/
    └── helpers.php               # trans_lang(), trans_dir(), is_rtl()

resources/views/
├── frontend/                     # Customer-facing views
└── backend/                      # Admin panel views

database/
├── migrations/
└── seeders/
    ├── UserSeeder.php
    ├── CategorySeeder.php
    ├── BrandSeeder.php
    └── ProductSeeder.php
```

---

## 🌍 Localization

The project uses a custom `trans_lang()` helper for bilingual support:

```php
// Usage in Blade templates
{{ trans_lang('نص عربي', 'English Text') }}
```

Language switching is handled via:
```
GET /lang/{locale}   →   LanguageController@switchLocale
```

Supported locales are defined in `config/locales.php`.

---

## 💳 Payment Flow

1. Customer fills checkout form
2. Order is created in the database
3. Customer is redirected to **Paymob** payment page
4. On success, Paymob sends a callback to `/paymob/callback`
5. Order status is updated to `paid` + `processing`

---

## 👤 Default Admin Account

After running seeders:

| Field | Value |
|---|---|
| Email | admin@example.com |
| Password | password |
| Role | admin |

> ⚠️ Change the password immediately after first login.

---

## 📝 License

This project is open-sourced under the [MIT License](LICENSE).
