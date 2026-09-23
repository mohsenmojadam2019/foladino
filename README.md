# فولادینو

فولادینو یک پلتفرم فروش، قیمت‌گذاری و مدیریت زنجیره تأمین محصولات فولادی است. این پروژه شامل وب‌سایت عمومی فارسی و RTL، پنل مدیریت، مدیریت سفارش و پرداخت، انبار، لجستیک، CRM، گزارش‌ها و مدیریت کاربران است.

## قابلیت‌های وب‌سایت

- صفحه اصلی RTL و واکنش‌گرا با معرفی خدمات، قیمت‌های روز و محصولات منتخب
- کاتالوگ محصولات، دسته‌بندی‌ها، کارخانه‌ها و جست‌وجو
- قیمت روز محصولات، تاریخچه قیمت و مقایسه محصولات
- ثبت سفارش عمده و درخواست پیش‌فاکتور
- سبد خرید، تسویه حساب و ثبت سفارش
- ورود، ثبت‌نام، پروفایل، سفارش‌ها و فاکتورهای مشتری
- تولید فاکتور و اسناد PDF
- صفحات کارخانه‌ها، درباره ما، تماس با ما و مقالات
- نمایش وضعیت سفارش و تاریخچه پرداخت برای مشتری
- طراحی مناسب موبایل، تبلت و دسکتاپ

## قابلیت‌های پنل مدیریت

- داشبورد KPI برای فروش، سفارش‌ها، مشتریان، موجودی و پرداخت‌ها
- مدیریت محصولات، دسته‌بندی‌ها، مشخصات فنی و کارخانه‌ها
- مدیریت قیمت روز، تاریخچه تغییرات و ثبت گروهی قیمت
- مدیریت سفارش‌ها، جزئیات سفارش، اقلام، یادداشت‌ها و تغییر وضعیت
- مدیریت تراکنش‌ها، پرداخت‌ها، خروجی CSV و تاریخچه مالی
- مدیریت استرداد وجه و گردش کار تأیید/رد استرداد
- مدیریت مشتریان، شرکت‌ها و پروژه‌ها
- مدیریت موجودی و کنترل سطح موجودی
- مدیریت تأمین‌کنندگان و درخواست‌های خرید
- مدیریت نرخ حمل، خودروها، ارسال‌ها و وضعیت تحویل
- گزارش‌های فروش، سفارش، موجودی، قیمت‌گذاری و تأمین
- CRM و مدیریت سرنخ‌ها و پیش‌فاکتورها
- مدیریت محتوا، مقالات و صفحات سایت
- مدیریت کاربران، نقش‌ها و دسترسی‌ها
- مرکز اعلان‌های مدیریتی
- لاگ ممیزی تغییرات مهم مدیریتی
- جست‌وجوی سراسری در بخش‌های پنل
- صفحه‌بندی و فیلتر server-side در فهرست‌های اصلی
- تنظیمات عمومی سامانه و تنظیمات کسب‌وکار

## وضعیت‌های سفارش

سفارش‌ها از چرخه زیر پشتیبانی می‌کنند:

\`pending\`، \`payment_started\`، \`paid\`، \`processing\`، \`shipped\`، \`completed\`، \`cancelled\`

## نقش‌های پیش‌فرض

- \`super_admin\`: دسترسی کامل
- \`admin\`: مدیریت عمومی سامانه
- \`pricing\`: مدیریت قیمت‌ها و تاریخچه قیمت
- \`content\`: مدیریت محتوا و مقالات
- \`customer\`: دسترسی به پنل مشتری

## مسیرهای مهم پنل مدیریت

- \`/admin\`
- \`/admin/catalog\`
- \`/admin/pricing\`
- \`/admin/orders\`
- \`/admin/transactions\`
- \`/admin/refunds\`
- \`/admin/customers\`
- \`/admin/companies\`
- \`/admin/inventory\`
- \`/admin/suppliers\`
- \`/admin/procurement\`
- \`/admin/logistics\`
- \`/admin/reports\`
- \`/admin/quotes\`
- \`/admin/content\`
- \`/admin/permissions\`
- \`/admin/audit-logs\`
- \`/admin/notifications\`
- \`/admin/settings\`

## نیازمندی‌های اجرا

- PHP 8.4 یا بالاتر
- Composer 2
- SQLite یا MySQL
- Apache با \`mod_rewrite\` برای اجرای XAMPP
- Node.js و npm در صورت نیاز به build دارایی‌های frontend

## نصب و اجرا با XAMPP

در PowerShell:

~~~powershell
cd C:\\xampp\\htdocs\\foladino
composer install
copy .env.example .env
php artisan key:generate
New-Item database/database.sqlite -ItemType File
php artisan migrate --seed
php artisan storage:link
php artisan serve --host=127.0.0.1 --port=8009
~~~

آدرس‌های محلی:

- سایت: http://127.0.0.1:8009
- ورود مدیریت: http://127.0.0.1:8009/admin/login
- اجرای Apache از مسیر public: http://localhost/foladino/public/

برای اتصال MySQL، مقدارهای \`DB_CONNECTION\`، \`DB_HOST\`، \`DB_PORT\`، \`DB_DATABASE\`، \`DB_USERNAME\` و \`DB_PASSWORD\` را در \`.env\` تنظیم کنید و سپس migrations را اجرا کنید.

## اجرای Docker

~~~bash
docker compose up -d
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan storage:link
~~~

## پایگاه داده و migrations

برای ساخت یا به‌روزرسانی پایگاه داده:

~~~bash
php artisan migrate
php artisan db:seed
~~~

مهم‌ترین جدول‌ها شامل محصولات، دسته‌بندی‌ها، کارخانه‌ها، قیمت‌ها، تاریخچه قیمت، سفارش‌ها، اقلام سفارش، تراکنش‌ها، استردادها، مشتریان، شرکت‌ها، پروژه‌ها، موجودی، تأمین‌کنندگان، درخواست خرید، خودروها، ارسال‌ها، نرخ حمل، اعلان‌ها و لاگ‌های ممیزی است.

برای پاک‌سازی cacheها:

~~~bash
php artisan optimize:clear
~~~

## بررسی سلامت پروژه

~~~bash
php artisan route:list
php artisan view:cache
php artisan config:cache
php artisan migrate:status
~~~

## ساختار پروژه

~~~text
app/
  Http/Controllers/
  Models/
  Notifications/
database/
  migrations/
  seeders/
resources/views/
  admin/
  auth/
  cart/
  checkout/
  components/
  layouts/
  pages/
routes/
  web.php
public/
  build/
  images/
~~~

## امنیت و عملیات

- کلید برنامه فقط از طریق \`.env\` تنظیم شود و در Git قرار نگیرد.
- در محیط production مقدار \`APP_DEBUG=false\` باشد.
- قبل از migrationهای production از پایگاه داده backup تهیه شود.
- برای عملیات مدیریتی حساس، دسترسی نقش‌ها و لاگ ممیزی بررسی شود.
- فایل‌های آپلودی از مسیر \`storage\` و لینک \`public/storage\` سرو می‌شوند.

## توسعه

شاخه اصلی پروژه \`main\` است:

~~~bash
git checkout main
git pull origin main
~~~

این پروژه با Laravel 12، PHP 8.4، Blade، Tailwind CSS و SQLite/MySQL توسعه داده شده است.
