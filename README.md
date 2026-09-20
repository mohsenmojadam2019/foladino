# فولادینو — بازار هوشمند آهن‌آلات

پیاده‌سازی کامل وب‌سایت B2B عمده‌فروشی آهن‌آلات بر اساس طرح تأییدشده، به همراه پنل مدیریت سازمانی روشن/سفید، قیمت لحظه‌ای، استعلام، CRM، مدیریت محتوا، کارخانه‌ها و Seeder کامل.

## تکنولوژی
- Laravel 12 / PHP 8.2+
- SQLite به صورت پیش‌فرض (قابل تغییر به MySQL)
- `morilog/jalali` برای نمایش و تبدیل تاریخ‌های جلالی
- Blade + CSS سفارشی RTL و کاملاً Responsive
- تمام تصاویر و Illustrationها به‌صورت Local در `public/images`

## راه‌اندازی
```bash
composer install
cp .env.example .env
touch database/database.sqlite
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

وب‌سایت: `http://127.0.0.1:8000`

پنل: `http://127.0.0.1:8000/admin`

### حساب مدیر Seeder
- Email: `admin@fooladino.ir`
- Password: `Fooladino@1405`

> در محیط Production حتماً رمزهای Seeder را بلافاصله تغییر دهید.

## ماژول‌های پنل سازمانی
- داشبورد مدیریتی و KPI
- مدیریت کاتالوگ، دسته‌بندی و کارخانه
- قیمت‌گذاری و ثبت Price History
- CRM استعلام‌ها با مراحل فروش
- مدیریت مقاله و محتوای بازار
- تنظیمات عمومی برند
- کاربران سازمانی و نقش‌های `super_admin`, `admin`, `pricing`, `content`
- نمایش تمام تاریخ‌های رابط به صورت جلالی و ارقام فارسی

## تصاویر
تمام Assetهای مورد استفاده در طرح داخل `public/images` قرار دارند و Seeder نیز به همان مسیرهای Local اشاره می‌کند؛ هیچ تصویر Remote برای UI اصلی لازم نیست.

## دسترسی نقش‌ها
- `super_admin`: دسترسی کامل + تنظیمات و کاربران
- `admin`: کاتالوگ، قیمت، CRM و محتوا
- `pricing`: داشبورد و قیمت‌گذاری
- `content`: داشبورد و مدیریت محتوا

دسترسی‌ها در سمت سرور با Middleware کنترل می‌شوند و صرفاً مخفی‌سازی منو نیستند.

## Frontend assets
این پروژه برای رابط اصلی به Vite وابسته نیست؛ CSS و JavaScript تولیدشده مستقیماً از `public/css` و `public/js` سرو می‌شوند. مسیر تصاویر ثابت نیز از Seeder تنظیمات قابل مدیریت است.

## بررسی سلامت
```bash
php artisan route:list
php artisan view:cache
php artisan config:cache
php artisan migrate:fresh --seed
```
