<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\MenuSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::query()->where('email', 'admin@example.com')->delete();

        User::query()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        MenuItem::query()->delete();
        Category::query()->delete();
        MenuSetting::query()->delete();

        $img = fn (string $seed) => 'https://picsum.photos/seed/'.rawurlencode($seed).'/900/900';
        $coverImg = fn (string $seed) => 'https://picsum.photos/seed/'.rawurlencode($seed).'/1200/560';

        $menu = [
            $this->cat(
                'Breakfast',
                'الإفطار',
                'نیوەتک',
                'breakfast',
                $img('flm-cat-breakfast'),
                10,
                [
                    $this->item('Sunrise Platter', 'طبق الشروق', 'پلاتەتی بەیانی', 'Eggs any style, grilled halloumi, olives, cucumber, warm flatbread, and jam.', 'بيض على الطريقة التي تفضلها مع حلوم مشوي وزيتون وخيار وخبز دافئ ومربى.', 'هەر جۆرە هێلکە، حلومێی برژاو، زەیتون، نارنجی، نانێکی گەرم و مەمەڵ.', 12.50, $img('flm-item-sunrise')),
                    $this->item('Shakshuka', 'شكشوكة', 'شەکشوکە', 'Slow-cooked peppers and tomatoes, two baked eggs, herbs, and toasted sourdough.', 'فلفل وطماطم مطبوخة على نار هادئة مع بيضتين وأعشاب وخبز محمص.', 'فلفل و تەماتە بە ئارامی پخدراو، دوو هێلکەی چڵەکراو، گیا و نانی تۆستکراو.', 10.90, $img('flm-item-shakshuka')),
                    $this->item('Greek Yogurt Bowl', 'زبادي يوناني', 'کاسەی ماستی یۆنانی', 'Thick yogurt, seasonal fruit, honey, granola, and mint.', 'زبادي كثيف مع فواكه موسمية وعسل وجرانولا ونعناع.', 'ماستی قورس، میوەی وەرزی، هون، گرانۆلا و نەعناع.', 8.50, $img('flm-item-yogurt')),
                    $this->item('Avocado Toast', 'توست الأفوكادو', 'تۆستی ئەڤۆکادۆ', 'Smashed avocado, lime, chili flakes, poached eggs, and microgreens.', 'أفوكادو مهروس مع ليمون ورقائح فلفل حار وبيض مسلوق وخضروات صغيرة.', 'ئەڤۆکادۆی کوتکراو، لیمۆ، فلفلی سوور، هێلکەی نەرم و سەوزە بچووکەکان.', 11.00, $img('flm-item-avocado')),
                ]
            ),
            $this->cat(
                'Lunch & plates',
                'الغداء والأطباق',
                'نیوەڕۆ و پلات',
                'lunch',
                $img('flm-cat-lunch'),
                20,
                [
                    $this->item('Grilled Chicken Wrap', 'لفافة دجاج مشوي', 'ڕەپێکی مریشکی برژاو', 'Herb-marinated chicken, garlic sauce, pickles, and fries on the side.', 'دجاج متبل بالأعشاب مع صوص ثوم ومخلل وبطاطس مقلية.', 'مریشک بە بۆنەوەر، سۆسی سیر، ترشی و پەتاتەی قەلاوی.', 14.50, $img('flm-item-wrap')),
                    $this->item('Beef Kafta Plate', 'طبق كفتة لحم', 'پلاتەی کفتەی مانگ', 'Charred kafta, rice pilaf, charred onion, tahini, and salad.', 'كفتة مشوية مع أرز بالأعشاب وبصل مشوي وطحينة وسلطة.', 'کفتەی برژاو، برنجی پڵاو، پیازێکی برژاو، تەحینە و سەلات.', 17.90, $img('flm-item-kafta')),
                    $this->item('Mediterranean Bowl', 'سلة متوسطية', 'کاسەی ناوەڕاستی دەریا', 'Chickpeas, falafel bites, tabbouleh, hummus, and lemon tahini.', 'حمص، قطع فلافل، تبولة، حمص بالطحينة وليمون.', 'نۆک، فەلافێلی بچووک، تەبۆلە، حummus و تەحینەی لیمو.', 13.50, $img('flm-item-bowl')),
                    $this->item('Seafood Tagliatelle', 'تالياتيلي بحري', 'تاگلیاتێلەی دەریایی', 'Shrimp and calamari, white wine, garlic, parsley, and lemon zest.', 'جمبري وحبار مع نبيذ أبيض وثوم وبقدونس وليمون.', 'قەمچی و کەلەماری، شەرابی سپی، سیر، جعفری و پوستی لیمو.', 18.50, $img('flm-item-pasta')),
                ]
            ),
            $this->cat(
                'Drinks',
                'المشروبات',
                'خواردنەوەکان',
                'drinks',
                $img('flm-cat-drinks'),
                30,
                [
                    $this->item('Fresh Orange Juice', 'عصير برتقال طازج', 'شیری پرتەقاڵی تازە', 'Cold-pressed Valencia oranges, served over ice.', 'برتقال فالنسيا معصور على البارد، يقدم مع الثلج.', 'پرتەقاڵی ڤالێنسیا ساردکەرەوە، لەسەر سەهۆڵ.', 4.50, $img('flm-item-oj')),
                    $this->item('Mint Lemonade', 'ليمونادة بالنعناع', 'لیمۆنادەی نەعناع', 'House lemonade, crushed mint, and a touch of rose.', 'ليمونادة منزلية مع نعناع مهروس ولمسة ورد.', 'لیمۆنادەی ماڵ، نەعناعی کوتکراو، کەمێک گوڵ.', 5.00, $img('flm-item-lemonade')),
                    $this->item('Iced Latte', 'لاتيه مثلج', 'لاتەی سارد', 'Double espresso, cold milk, and vanilla optional.', 'إسبريسو مزدوج مع حليب بارد وفانيليا اختيارية.', 'ئێسپرێسۆ دوو جار، شیری سارد، ڤانیلیا ئارەزومەندانە.', 5.50, $img('flm-item-icedlatte')),
                    $this->item('Sparkling Water', 'ماء فوار', 'ئاوی گازدار', 'Chilled bottle, lime wedge.', 'زجاجة باردة مع قطعة ليمون.', 'شووشەی سارد، پارچەی لیمو.', 3.00, $img('flm-item-water')),
                ]
            ),
            $this->cat(
                'Shisha',
                'الشيشة',
                'نارگیلە',
                'shisha',
                $img('flm-cat-shisha'),
                40,
                [
                    $this->item('Double Apple Classic', 'تفاح مزدوج كلاسيكي', 'سێوەی دوو قات کلاسیک', 'Traditional sweet apple blend, smooth clouds, long session.', 'مزيج تفاح حلو تقليدي، غيوم ناعمة، جلسة طويلة.', 'تێکەڵکردنی سێوەی شیرین، هەورێکی نەرم، کاتژمێری درێژ.', 18.00, $img('flm-item-apple')),
                    $this->item('Mint Frost', 'نعناع مثلج', 'نەعناعی سارد', 'Cool mint with a light citrus finish.', 'نعناع منعش مع لمسة حمضيات خفيفة.', 'نەعناعی سارد، کۆتایی هەلسەنگاندنی سوور.', 18.00, $img('flm-item-mintsh')),
                    $this->item('Berry Mix', 'مزيج توت', 'تێکەڵی توت', 'Mixed berries with a hint of vanilla cream.', 'توت مشكل مع لمسة كريمة فانيليا.', 'تۆتی تێکەڵ، کەمێک کرێمی ڤانیلیا.', 19.50, $img('flm-item-berrysh')),
                    $this->item('Lemon & Basil', 'ليمون وريحان', 'لیمو و ڕیحان', 'Herbal, refreshing, low-sweet profile.', 'أعشاب، منعش، حلاوة خفيفة.', 'گیا، ساردکەرەوە، کەم شیرین.', 19.50, $img('flm-item-lemonsh')),
                ]
            ),
            $this->cat(
                'Coffee & tea',
                'القهوة والشاي',
                'قاوە و چا',
                'coffee-tea',
                $img('flm-cat-coffee'),
                50,
                [
                    $this->item('Turkish Coffee', 'قهوة تركية', 'قاوەی تورکی', 'Finely ground, cardamom optional, served with lokum.', 'مطحون ناعم، هال اختياري، يقدم مع لقوم.', 'بەردەوام، هیل ئارەزومەندانە، لەگەڵ لوکوم.', 4.00, $img('flm-item-turkish')),
                    $this->item('Cappuccino', 'كابتشينو', 'کاپوچینۆ', 'Espresso, steamed milk, dense microfoam.', 'إسبريسو، حليب مبخر، رغوة دقيقة.', 'ئێسپرێسۆ، شیری هەڵمژراو، فومێکی قورس.', 4.50, $img('flm-item-cap')),
                    $this->item('Moroccan Mint Tea', 'شاي مغربي بالنعناع', 'چای مەغریب بە نەعناع', 'Gunpowder green tea, fresh mint, poured from height for foam.', 'شاي أخضر، نعناع طازج، يصب من الأعلى للرغوة.', 'چای سەوز، نەعناعی تازە، لە بەرزایی بۆ فوم.', 4.00, $img('flm-item-minttea')),
                    $this->item('Masala Chai', 'شاي ماسالا', 'چای ماسالا', 'Spiced black tea, simmered milk, and honey.', 'شاي أسود بالتوابل، حليب مطبوخ ببطء وعسل.', 'چای ڕەش بە بەهارات، شیری هەڵمژراو و هون.', 4.50, $img('flm-item-chai')),
                ]
            ),
            $this->cat(
                'Desserts',
                'الحلويات',
                'شیرینی',
                'desserts',
                $img('flm-cat-dessert'),
                60,
                [
                    $this->item('Kunafa Cup', 'كنافة كوب', 'کونافەی کاسە', 'Crisp kataifi, sweet cheese, orange blossom syrup, pistachio.', 'كنافة مقرمشة، جبنة حلوة، ماء زهر، فستق.', 'کاتایفی قڕپۆش، پەنیری شیرین، شیرپۆشی پرتەقاڵ، فستق.', 7.50, $img('flm-item-kunafa')),
                    $this->item('Baklava Assortment', 'تشكيلة بقلاوة', 'باقڵاوەی تێکەڵ', 'Walnut, pistachio, and cashew layers with light syrup.', 'طبقات جوز وفستق وكاجو مع قطر خفيف.', 'چینەکانی گوێز و فستق و کاشو بە شیرپۆشی سوک.', 6.50, $img('flm-item-baklava')),
                    $this->item('Chocolate Soufflé', 'سوفليه شوكولاتة', 'سوفلێی شۆکۆلاتە', 'Warm center, vanilla bean ice cream.', 'وسط دافئ، آيس كريم فانيليا.', 'ناوەڕاستی گەرم، بستەسکانی ڤانیلیا.', 8.90, $img('flm-item-souffle')),
                    $this->item('Seasonal Fruit', 'فواكه موسمية', 'میوەی وەرزی', 'Chef’s cut fruit plate with rose water.', 'طبق فواكه مقطعة مع ماء ورد.', 'پلاتەی میوەی بڕدراو بە ئاوێکی گوڵ.', 5.50, $img('flm-item-fruit')),
                ]
            ),
        ];

        foreach ($menu as $block) {
            $items = $block['items'];
            unset($block['items']);
            $category = Category::query()->create($block);
            $order = 10;
            foreach ($items as $row) {
                MenuItem::query()->create(array_merge($row, [
                    'category_id' => $category->id,
                    'sort_order' => $order,
                    'is_active' => true,
                ]));
                $order += 10;
            }
        }

        MenuSetting::query()->create([
            'cover_image_url' => $coverImg('flm-menu-hero-cover'),
            'brand_accent_color' => '#d4a853',
            'currency_code' => 'IQD',
            'price_show_cents' => true,
            'site_name_en' => 'Fastlink Café',
            'site_name_ar' => 'مقهى فاستلينك',
            'site_name_ku' => 'فاستلینک کافێ',
            'logo_url' => null,
            'phone' => '+1 (555) 010-2030',
            'address_en' => "12 Riverfront Walk\nDemo City, DC 20001",
            'address_ar' => "١٢ شارع الواجهة النهرية\nمدينة الديمو، واشنطن ٢٠٠٠١",
            'address_ku' => "١٢ ڕێگای بەرامبەر ڕووبار\nشاری دیمۆ، DC 20001",
            'lang_en_enabled' => true,
            'lang_ar_enabled' => true,
            'lang_ku_enabled' => true,
            'social_instagram_url' => 'https://instagram.com/',
            'social_facebook_url' => 'https://facebook.com/',
            'social_twitter_url' => null,
            'social_tiktok_url' => null,
            'social_youtube_url' => null,
        ]);
    }

    /**
     * @param  list<array<string, mixed>>  $items
     * @return array<string, mixed>
     */
    private function cat(string $en, string $ar, string $ku, string $slug, string $imageUrl, int $sortOrder, array $items): array
    {
        return [
            'name_en' => $en,
            'name_ar' => $ar,
            'name_ku' => $ku,
            'slug' => $slug,
            'image_url' => $imageUrl,
            'sort_order' => $sortOrder,
            'items' => $items,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function item(
        string $nameEn,
        string $nameAr,
        string $nameKu,
        string $descEn,
        string $descAr,
        string $descKu,
        float $price,
        string $imageUrl
    ): array {
        return [
            'name_en' => $nameEn,
            'name_ar' => $nameAr,
            'name_ku' => $nameKu,
            'description_en' => $descEn,
            'description_ar' => $descAr,
            'description_ku' => $descKu,
            'price' => $price,
            'image_url' => $imageUrl,
        ];
    }
}
