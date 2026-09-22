<?php
namespace Database\Seeders;

use App\Models\{Article,Category,Factory,PriceHistory,Product,QuoteRequest,Setting,Testimonial,User};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Morilog\Jalali\Jalalian;

class DatabaseSeeder extends Seeder
{
    private function j(string $date) { return Jalalian::fromFormat('Y/m/d H:i', $date)->toCarbon(); }

    public function run(): void
    {
        User::updateOrCreate(['email'=>'admin@fooladino.ir'], ['name'=>'مدیر ارشد فولادینو','password'=>Hash::make('Fooladino@1405'),'role'=>'super_admin','is_active'=>true]);
        User::updateOrCreate(['email'=>'pricing@fooladino.ir'], ['name'=>'مدیر قیمت‌گذاری','password'=>Hash::make('Pricing@1405'),'role'=>'pricing','is_active'=>true]);

        $cats = [
            ['میلگرد','rebar','/images/generated/rebar-bundle.png'],
            ['تیرآهن','beam','/images/generated/steel-sections.png'],
            ['ورق','sheet','/images/generated/steel-sections.png'],
            ['لوله','pipe','/images/generated/steel-sections.png'],
            ['پروفیل','profile','/images/generated/steel-sections.png'],
            ['نبشی و ناودانی','angle','/images/categories/angle.jpg'],
        ];
        foreach ($cats as $i=>$c) Category::updateOrCreate(
            ['slug'=>$c[1]],
            ['name'=>$c[0],'icon'=>$c[2],'sort_order'=>$i+1,'is_active'=>true]
        );

        $factories = [
            ['ذوب آهن اصفهان','zobahan','اصفهان','اصفهان'],
            ['فولاد مبارکه','mobarekeh','اصفهان','مبارکه'],
            ['فولاد خوزستان','khouzestan','خوزستان','اهواز'],
            ['فایکو','faico','مازندران','ساری'],
            ['مجتمع فولاد خراسان','khorasan','خراسان رضوی','نیشابور'],
            ['نورد و لوله سپاهان','sepahan','اصفهان','اصفهان'],
        ];
        foreach ($factories as $f) Factory::updateOrCreate(
            ['slug'=>$f[1]],
            ['name'=>$f[0],'province'=>$f[2],'city'=>$f[3],'logo'=>'/images/factory.svg','is_active'=>true]
        );

        $factorySlugs = array_column($factories, 1);
        $rows = [];
        $seq = 0;
        $faNum = fn($value) => strtr((string)$value, ['0'=>'۰','1'=>'۱','2'=>'۲','3'=>'۳','4'=>'۴','5'=>'۵','6'=>'۶','7'=>'۷','8'=>'۸','9'=>'۹','.'=>'٫']);
        $push = function(string $category, string $slug, string $sku, string $name, string $size, string $standard, int $basePrice) use (&$rows,&$seq,$factorySlugs) {
            $rows[] = [
                'category'=>$category,
                'slug'=>$slug,
                'sku'=>$sku,
                'name'=>$name,
                'size'=>$size,
                'standard'=>$standard,
                'factory'=>$factorySlugs[$seq % count($factorySlugs)],
                'price'=>$basePrice + (($seq % 10) * 170) + ((int) floor($seq / 10) * 35),
                'change'=>round((($seq % 11) - 5) * 0.23, 2),
                'stock'=>($seq % 19 === 0 ? 'call' : 'available'),
                'featured'=>($seq % 30 < 3),
            ];
            $seq++;
        };

        foreach ([8,10,12,14,16,18,20,22,25,28] as $size) {
            foreach (['A2','A3','A4'] as $standard) {
                $push('rebar', "rebar-{$size}-".strtolower($standard), "RB-{$size}-{$standard}", 'میلگرد آجدار '.$faNum($size).' '.$standard, $faNum($size), $standard, 28350);
            }
        }

        foreach ([12,14,16,18,20,22,24,27,30,32] as $size) {
            foreach (['IPE','IPB','INP'] as $standard) {
                $push('beam', "beam-{$size}-".strtolower($standard), "BM-{$size}-{$standard}", 'تیرآهن '.$faNum($size).' '.$standard, $faNum($size), $standard, 31800);
            }
        }

        foreach (['1.5','2','2.5','3','4','5','6','8','10','12'] as $thickness) {
            foreach (['ST37','ST52','A283'] as $standard) {
                $slugThickness = str_replace('.', '-', $thickness);
                $push('sheet', "sheet-{$slugThickness}-".strtolower($standard), "SH-{$slugThickness}-{$standard}", 'ورق فولادی '.$faNum($thickness).' میلی‌متر '.$standard, $faNum($thickness).' میلی‌متر', $standard, 29400);
            }
        }

        $pipeSizes = [
            ['0-5','۱/۲'],['0-75','۳/۴'],['1','۱'],['1-25','۱ ۱/۴'],['1-5','۱ ۱/۲'],
            ['2','۲'],['2-5','۲ ۱/۲'],['3','۳'],['4','۴'],['6','۶']
        ];
        $pipeKinds = [
            ['industrial','صنعتی'],['seamless','مانیسمان'],['galvanized','گالوانیزه']
        ];
        foreach ($pipeSizes as [$sizeSlug,$sizeName]) {
            foreach ($pipeKinds as [$kindSlug,$kindName]) {
                $push('pipe', "pipe-{$sizeSlug}-{$kindSlug}", "PI-{$sizeSlug}-".strtoupper(substr($kindSlug,0,3)), 'لوله '.$kindName.' '.$sizeName.' اینچ', $sizeName.' اینچ', $kindName, 30750);
            }
        }

        foreach (['20x20','25x25','30x30','40x40','50x50','60x60','70x70','80x80','90x90','100x100'] as $dim) {
            foreach (['1.5','2','2.5'] as $thickness) {
                [$a,$b] = explode('x',$dim);
                $slugThickness = str_replace('.', '-', $thickness);
                $push('profile', "profile-{$dim}-{$slugThickness}", "PR-{$dim}-{$slugThickness}", 'پروفیل '.$faNum($a).'×'.$faNum($b).' ضخامت '.$faNum($thickness), $faNum($a).'×'.$faNum($b), 'ST37 / '.$faNum($thickness).'mm', 27650);
            }
        }

        foreach ([30,40,50,60,70,80,90,100,120,140] as $size) {
            foreach ([['angle','نبشی مساوی','L'],['unp','ناودانی UNP','UNP'],['upe','ناودانی UPE','UPE']] as [$kindSlug,$kindName,$standard]) {
                $push('angle', "{$kindSlug}-{$size}", "AN-".strtoupper($kindSlug)."-{$size}", $kindName.' '.$faNum($size), $faNum($size), $standard, 29950);
            }
        }

        foreach ($rows as $idx=>$p) {
            $product = Product::updateOrCreate(['slug'=>$p['slug']], [
                'name'=>$p['name'],
                'sku'=>$p['sku'],
                'category_id'=>Category::whereSlug($p['category'])->value('id'),
                'factory_id'=>Factory::whereSlug($p['factory'])->value('id'),
                'size'=>$p['size'],
                'standard'=>$p['standard'],
                'unit'=>'کیلوگرم',
                'price'=>$p['price'],
                'price_change'=>$p['change'],
                'stock_status'=>$p['stock'],
                'image'=>'/images/products/'.$p['slug'].'.jpg',
                'description'=>'محصول فولادی برای فروش مستقیم و عمده؛ با کنترل مشخصات فنی، قیمت روز و امکان برنامه‌ریزی ارسال برای پروژه‌ها.',
                'is_featured'=>$p['featured'],
                'is_active'=>true,
            ]);
            PriceHistory::where('product_id',$product->id)->delete();
            foreach ([6,5,4,3,2,1,0] as $d) {
                PriceHistory::create([
                    'product_id'=>$product->id,
                    'price'=>max(1000,$p['price']-($d*95)+(($idx%7)*20)),
                    'change_percent'=>$p['change'],
                    'recorded_at'=>$this->j('1405/06/'.str_pad((string)(29-$d),2,'0',STR_PAD_LEFT).' 10:42')
                ]);
            }
        }
        Product::whereIn('slug',['hot-sheet-2','pipe-2-inch','profile-40'])->delete();

        $articles = [
            ['تحلیل روند قیمت آهن‌آلات در شهریور ۱۴۰۵','steel-price-trend','بررسی محرک‌های بازار و رفتار قیمت میلگرد، تیرآهن و ورق در آخرین روزهای شهریور.','/images/article-market.svg','1405/06/29 09:10'],
            ['۵ نکته مهم در خرید آهن برای پروژه‌های ساختمانی','buying-guide','از کنترل استاندارد و وزن تا انتخاب کارخانه و برنامه‌ریزی حمل در خرید عمده.','/images/article-project.svg','1405/06/27 12:30'],
            ['راهنمای انتخاب کارخانه مناسب برای تأمین پروژه','factory-guide','چطور بین قیمت، فاصله حمل، ظرفیت تولید و اعتبار تأمین‌کننده تصمیم بگیریم.','/images/article-factory.svg','1405/06/25 08:20'],
        ];
        foreach ($articles as $a) Article::updateOrCreate(['slug'=>$a[1]], ['title'=>$a[0],'excerpt'=>$a[2],'body'=>$a[2],'image'=>$a[3],'published_at'=>$this->j($a[4]),'is_published'=>true]);

        Testimonial::query()->delete();
        Testimonial::insert([
            ['name'=>'مهندس رضایی','role'=>'پیمانکار عمرانی','company'=>'پروژه ساختمانی تهران','quote'=>'قیمت‌ها به‌روز است و پاسخ‌گویی تیم فروش سریع انجام می‌شود. برای خرید پروژه‌ای روند شفاف و قابل پیگیری بود.','avatar'=>'/images/avatar-1.svg','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'خانم موسوی','role'=>'مدیر تدارکات','company'=>'شرکت سازه گستر','quote'=>'تأمین میلگرد پروژه در زمان کوتاه و با هماهنگی دقیق حمل انجام شد. داشبورد قیمت برای تصمیم‌گیری روزانه مفید است.','avatar'=>'/images/avatar-2.svg','is_active'=>1,'created_at'=>now(),'updated_at'=>now()],
        ]);

        QuoteRequest::query()->delete();
        QuoteRequest::insert([
            ['name'=>'شرکت عمران پارس','mobile'=>'09120000001','product_name'=>'میلگرد آجدار ۱۴','amount'=>25,'city'=>'تهران','status'=>'new','note'=>'تحویل در محل پروژه','created_at'=>$this->j('1405/06/29 11:20'),'updated_at'=>$this->j('1405/06/29 11:20')],
            ['name'=>'بازرگانی آریا','mobile'=>'09120000002','product_name'=>'ورق فولادی ۲ میلی‌متر','amount'=>12,'city'=>'کرج','status'=>'contacted','note'=>'نیاز به پیش‌فاکتور رسمی','created_at'=>$this->j('1405/06/28 15:10'),'updated_at'=>$this->j('1405/06/28 15:10')],
        ]);

        $settings = [
            'site_name'=>'فولادینو',
            'phone'=>'۰۲۱-۹۱۰۰۳۳۳۳',
            'support_phone'=>'۰۲۱-۹۱۰۰۷۰۰۰',
            'email'=>'info@fooladino.ir',
            'address'=>'تهران، دفتر مرکزی فولادینو',
            'hero_title'=>'فروش عمده|محصولات فولادینو',
            'hero_subtitle'=>'تولید و عرضه مستقیم محصولات فولادی با قیمت روز برای پروژه‌های بزرگ',
            'annual_tons'=>'۱۰۰,۰۰۰+',
            'active_customers'=>'۱۰,۰۰۰+',
            'factories_count'=>'۵۰۰+',
            'logo_image'=>'/images/logo-mark.svg',
            'hero_image'=>'/images/generated/hero-warehouse.png',
            'project_image'=>'/images/generated/construction-site.png',
            'delivery_map_image'=>'/images/iran-map.svg',
            'cta_image'=>'/images/generated/hero-warehouse.png',
            'factory_default_image'=>'/images/factory.svg'
        ];
        foreach ($settings as $k=>$v) Setting::updateOrCreate(['key'=>$k],['value'=>$v,'group'=>'general']);
    }
}
