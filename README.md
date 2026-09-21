# فولادینو — فروش مستقیم و عمده محصولات فولادی

وب‌سایت رسمی فروش B2B محصولات خود شرکت فولادینو؛ با کاتالوگ محصول، قیمت روز، سفارش عمده، پیش‌فاکتور و پنل مدیریت.

## صفحات عمومی
- خانه: معرفی شرکت، قیمت روز، دسته‌بندی و محصولات منتخب
- محصولات: کاتالوگ و فیلتر محصولات فولادینو
- قیمت روز: داشبورد و جدول قیمت‌های جاری
- سفارش عمده: انتخاب محصول، تناژ، برآورد مبلغ و ثبت درخواست
- درباره ما
- تماس با ما

## مدل کسب‌وکار
این وب‌سایت Marketplace چندفروشنده نیست. محصولات نمایش‌داده‌شده متعلق به فولادینو هستند و خرید به‌صورت مستقیم از شرکت انجام می‌شود.

## اجرا با Docker
```bash
cp .env.example .env
touch database/database.sqlite
docker compose build
docker compose up -d
docker compose exec web php artisan key:generate --force
docker compose exec web php artisan migrate --seed --force
```

وب‌سایت: `http://SERVER_IP:8088`
پنل: `http://SERVER_IP:8088/admin`

## تکنولوژی
- Laravel 12 / PHP 8.4
- SQLite
- Blade + CSS RTL
- Docker Compose
- morilog/jalali

## مدیریت
پنل مدیریت قبلی حفظ شده است و مدیریت محصول، قیمت، سفارش/CRM، محتوا و تنظیمات را انجام می‌دهد.
