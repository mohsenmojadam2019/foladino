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
            ['میلگرد','rebar','rebar.svg'],['تیرآهن','beam','beam.svg'],['ورق','sheet','sheet.svg'],['لوله','pipe','pipe.svg'],['پروفیل','profile','profile.svg'],['نبشی و ناودانی','angle','angle.svg']
        ];
        foreach ($cats as $i=>$c) Category::updateOrCreate(['slug'=>$c[1]], ['name'=>$c[0],'icon'=>'/images/'.$c[2],'sort_order'=>$i+1,'is_active'=>true]);

        $factories = [
            ['ذوب آهن اصفهان','zobahan','اصفهان','اصفهان'],['فولاد مبارکه','mobarekeh','اصفهان','مبارکه'],['فولاد خوزستان','khouzestan','خوزستان','اهواز'],['فایکو','faico','مازندران','ساری'],['مجتمع فولاد خراسان','khorasan','خراسان رضوی','نیشابور'],['نورد و لوله سپاهان','sepahan','اصفهان','اصفهان']
        ];
        foreach ($factories as $f) Factory::updateOrCreate(['slug'=>$f[1]], ['name'=>$f[0],'province'=>$f[2],'city'=>$f[3],'logo'=>'/images/factory.svg','is_active'=>true]);

        $products = [
            ['میلگرد آجدار ۱۴ A3','rebar-14-a3','RB-14-A3','rebar','zobahan','۱۴','A3',28400,2.3,'/images/rebar.svg'],
            ['تیرآهن ۱۶ IPE','beam-16-ipe','BM-16-IPE','beam','faico','۱۶','IPE',32100,1.1,'/images/beam.svg'],
            ['ورق گرم ۲ میلی‌متر','hot-sheet-2','SH-HOT-2','sheet','mobarekeh','۲ میلی‌متر','ST37',29750,-0.8,'/images/sheet.svg'],
            ['لوله صنعتی ۲ اینچ','pipe-2-inch','PI-2','pipe','sepahan','۲ اینچ','صنعتی',31200,1.6,'/images/pipe.svg'],
            ['پروفیل ۴۰×۴۰','profile-40','PR-4040','profile','khouzestan','۴۰×۴۰','ST37',27900,0.9,'/images/profile.svg'],
            ['نبشی ۵۰×۵۰','angle-50','AN-5050','angle','zobahan','۵۰×۵۰','L',30100,0.4,'/images/angle.svg'],
        ];
        foreach ($products as $idx=>$p) {
            $product = Product::updateOrCreate(['slug'=>$p[1]], [
                'name'=>$p[0],'sku'=>$p[2],'category_id'=>Category::whereSlug($p[3])->value('id'),'factory_id'=>Factory::whereSlug($p[4])->value('id'),
                'size'=>$p[5],'standard'=>$p[6],'unit'=>'کیلوگرم','price'=>$p[7],'price_change'=>$p[8],'stock_status'=>'available','image'=>$p[9],
                'description'=>'محصول منتخب بازار فولادینو با تأمین مستقیم از کارخانه، کنترل مشخصات فنی و امکان ارسال به سراسر کشور.','is_featured'=>true,'is_active'=>true
            ]);
            PriceHistory::where('product_id',$product->id)->delete();
            foreach ([5,4,3,2,1,0] as $d) PriceHistory::create(['product_id'=>$product->id,'price'=>max(1000,$p[7]-($d*110)+($idx*35)),'change_percent'=>$p[8],'recorded_at'=>$this->j('1405/06/'.str_pad((string)(29-$d),2,'0',STR_PAD_LEFT).' 10:42')]);
        }

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
            ['name'=>'بازرگانی آریا','mobile'=>'09120000002','product_name'=>'ورق گرم ۲ میلی‌متر','amount'=>12,'city'=>'کرج','status'=>'contacted','note'=>'نیاز به پیش‌فاکتور رسمی','created_at'=>$this->j('1405/06/28 15:10'),'updated_at'=>$this->j('1405/06/28 15:10')],
        ]);

        $settings = [
            'site_name'=>'فولادینو','phone'=>'۰۲۱-۹۱۰۰۳۳۳۳','support_phone'=>'۰۲۱-۹۱۰۰۷۰۰۰','email'=>'info@fooladino.ir','address'=>'تهران، دفتر مرکزی فولادینو',
            'hero_title'=>'بازار هوشمند|خرید آهن‌آلات','hero_subtitle'=>'فولادینو؛ پلی میان پروژه‌های بزرگ امروز و آینده‌ای محکم‌تر','annual_tons'=>'۱۰۰,۰۰۰+','active_customers'=>'۱۰,۰۰۰+','factories_count'=>'۵۰۰+',
            'logo_image'=>'/images/logo-mark.svg','hero_image'=>'/images/hero-steel.svg','project_image'=>'/images/project.svg','delivery_map_image'=>'/images/iran-map.svg','cta_image'=>'/images/coil.svg','factory_default_image'=>'/images/factory.svg'
        ];
        foreach ($settings as $k=>$v) Setting::updateOrCreate(['key'=>$k],['value'=>$v,'group'=>'general']);
    }
}
