# 🛍️ Pay - منصة تجارة إلكترونية

منصة تجارة إلكترونية احترافية مبنية بـ **Laravel 10** و **Tailwind CSS** و **Vite**

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)
![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.1+-purple.svg)

## 📋 نظرة عامة

**Pay** هي منصة تجارة إلكترونية متطورة توفر تجربة تسوق كاملة مع:
- 🛒 نظام سلة التسوق المتقدم (للمستخدمين والضيوف)
- 💳 تكامل **Paymob** للدفع الإلكتروني
- 🌍 دعم ثنائي اللغة (عربي/إنجليزي)
- 📦 إدارة شاملة للمنتجات والفئات والماركات
- 👥 نظام متقدم لإدارة المستخدمين
- 📊 لوحة تحكم إدارية احترافية
- 📱 تصميم responsive و responsive

## ✨ المميزات الرئيسية

### للعملاء
- ✅ تصفح وبحث عن المنتجات
- ✅ إضافة المنتجات للسلة بسهولة
- ✅ تتبع الطلبيات
- ✅ دفع آمن عبر Paymob
- ✅ قوائم الرغبات (في المستقبل)

### للإداريين
- ✅ إدارة المنتجات (إنشاء، تعديل، حذف)
- ✅ إدارة الفئات والماركات
- ✅ تتبع الطلبيات
- ✅ إدارة المستخدمين
- ✅ إعدادات عامة للموقع

## 🛠️ التكنولوجيا المستخدمة

- **Backend:** Laravel 10
- **Frontend:** Tailwind CSS, Alpine.js, Vite
- **Database:** MySQL/MariaDB
- **Payment Gateway:** Paymob
- **Image Processing:** Intervention Image
- **Authentication:** Laravel Sanctum

## 📋 المتطلبات

- PHP >= 8.1
- MySQL >= 5.7 أو MariaDB >= 10.3
- Node.js >= 16
- Composer >= 2.0
- npm >= 8.0

## 🚀 التثبيت والإعداد

### 1. استنساخ المستودع
```bash
git clone https://github.com/YOUR_USERNAME/pay.git
cd pay
```

### 2. تثبيت المكتبات
```bash
# تثبيت PHP dependencies
composer install

# تثبيت Node dependencies
npm install
```

### 3. إعداد البيئة
```bash
# نسخ ملف البيئة
cp .env.example .env

# توليد مفتاح التطبيق
php artisan key:generate
```

### 4. إعداد قاعدة البيانات

عدّل في `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pay_db
DB_USERNAME=root
DB_PASSWORD=
```

ثم شغّل الهجرات:
```bash
php artisan migrate --seed
```

### 5. إعداد Paymob (اختياري)

أضف في `.env`:
```env
PAYMOB_API_KEY=your_paymob_api_key
PAYMOB_BASE_URL=https://accept.paymob.com
PAYMOB_INTEGRATION_ID=your_integration_id
PAYMOB_IFRAME_ID=your_iframe_id
```

### 6. بناء الموارد الأمامية
```bash
# بناء الموارد
npm run build

# أو الوضع development مع المراقبة
npm run dev
```

### 7. تشغيل خادم التطوير
```bash
php artisan serve
```

الآن يمكنك زيارة `http://localhost:8000`

## 📖 دليل الاستخدام

### إنشاء حساب إدارة
```bash
php artisan tinker
User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
    'email_verified_at' => now()
]);
```

### تسجيل الدخول
- الرابط: `/login`
- البريد الإلكتروني: `admin@example.com`
- كلمة المرور: `password`

### لوحة التحكم الإدارية
- الرابط: `/admin/dashboard`

## 📁 هيكل المشروع

```
pay/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # متحكمات الإدارة
│   │   │   └── ...
│   │   └── Middleware/         # البرمجيات الوسيطة
│   ├── Models/                 # نماذج Eloquent
│   ├── Services/               # طبقة الخدمات
│   └── Providers/              # موفرو الخدمات
├── config/                     # ملفات الإعدادات
├── database/
│   ├── migrations/             # هجرات قاعدة البيانات
│   └── seeders/                # بيانات التمرين
├── resources/
│   ├── css/                    # ملفات الأنماط
│   ├── js/                     # ملفات JavaScript
│   └── views/                  # قوالب Blade
├── routes/                     # ملفات المسارات
├── storage/                    # ملفات التخزين
└── tests/                      # الاختبارات
```

## 🔐 الأمان

### نصائح مهمة
- ✅ تأكد من أن `APP_DEBUG=false` في بيئة الإنتاج
- ✅ استخدم متغيرات البيئة للمفاتيح السرية
- ✅ قم بتحديث المكتبات بانتظام: `composer update`, `npm update`
- ✅ قم بعمل backup منتظم لقاعدة البيانات

### التحقق من الصلاحيات
- يتم فحص الصلاحيات في Middleware `IsAdmin`
- للتحقق من الملكية، استخدم Gates و Policies

## 🧪 الاختبارات

```bash
# تشغيل جميع الاختبارات
php artisan test

# تشغيل اختبار معين
php artisan test tests/Feature/CartTest.php

# مع Coverage Report
php artisan test --coverage
```

## 📝 قواعد المساهمة

يرجى الالتزام بـ:
1. **PSR-12** Code Style
2. كتابة اختبارات للميزات الجديدة
3. تحديث التوثيق
4. رسائل commits واضحة

### خطوات المساهمة
```bash
1. Fork المشروع
2. أنشئ فرع للميزة (git checkout -b feature/AmazingFeature)
3. Commit التغييرات (git commit -m 'Add some AmazingFeature')
4. Push للفرع (git push origin feature/AmazingFeature)
5. افتح Pull Request
```

## 📞 الدعم والتواصل

- 📧 البريد الإلكتروني: support@example.com
- 💬 Discord: [رابط الخادم]
- 🐛 الإبلاغ عن المشاكل: [GitHub Issues]

## 📄 الترخيص

هذا المشروع مرخص تحت **MIT License** - اقرأ [LICENSE](LICENSE) لمزيد من التفاصيل

## 🙏 شكراً

شكراً لاستخدامك Pay! نتمنى أن تستمتع بالمنصة

---

**تم التطوير بـ ❤️ من قبل فريق التطوير**

آخر تحديث: 2024
