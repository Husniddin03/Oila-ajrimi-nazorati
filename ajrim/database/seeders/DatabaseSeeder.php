<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Test;
use App\Models\Question;
use App\Models\Recommendation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@oila.uz',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'status'   => 'active',
        ]);

        // Demo foydalanuvchi
        User::create([
            'name'     => 'Demo Foydalanuvchi',
            'email'    => 'demo@oila.uz',
            'password' => Hash::make('demo123'),
            'role'     => 'user',
            'status'   => 'active',
            'phone'    => '+998901234567',
        ]);

        // ============================================================
        // TESTLAR VA SAVOLLAR
        // ============================================================
        $testsData = [
            [
                'title'       => 'Muloqot muammolari',
                'description' => 'Oilada muloqot va fikr almashish darajasini o\'lchaydi.',
                'emoji'       => '💬',
                'color'       => '#4a7c59',
                'category'    => 'muloqot',
                'questions'   => [
                    ['Juftingiz bilan qiyin mavzularni erkin muhokama qila olasizmi?', 'emotsional'],
                    ['Juftingiz fikringizni oxirigacha eshitadimi?', 'muloqot'],
                    ['Janjal paytida o\'zingizni nazorat qila olasizmi?', 'emotsional'],
                    ['Muammolarni tinch yo\'l bilan hal qilasizmi?', 'muloqot'],
                    ['Juftingizga his-tuyg\'ularingizni aytib berishingiz osonmi?', 'emotsional'],
                    ['Bir-biringizni tanqid qilmasdan gaplasha olasizlarmi?', 'muloqot'],
                    ['Muhim qarorlarni birgalikda qabul qilasizlarmi?', 'muloqot'],
                    ['Juftingiz sizni tushunadi deb hisoblaysizmi?', 'emotsional'],
                ],
            ],
            [
                'title'       => 'Moliyaviy kelishmovchilik',
                'description' => 'Oiladagi pul masalalari va moddiy muammolarni baholaydi.',
                'emoji'       => '💰',
                'color'       => '#c87941',
                'category'    => 'moliyaviy',
                'questions'   => [
                    ['Oilaviy byudjetni birgalikda rejalashtirasizlarmi?', 'moliyaviy'],
                    ['Pul masalasida ko\'p janjal bo\'ladimi?', 'moliyaviy'],
                    ['Juftingizning xarajatlaridan rozimisiz?', 'moliyaviy'],
                    ['Ishlash va daromad taqsimotiga kelishganmisizlar?', 'moliyaviy'],
                    ['Qarzlar yoki kredit masalasi oilangizga ta\'sir qiladimi?', 'moliyaviy'],
                    ['Kelajak uchun birgalikda tejaysizlarmi?', 'moliyaviy'],
                ],
            ],
            [
                'title'       => 'Emotsional munosabat',
                'description' => 'Oila a\'zolari o\'rtasidagi emotsional aloqa va qo\'llab-quvvatlashni o\'lchaydi.',
                'emoji'       => '❤️',
                'color'       => '#e94560',
                'category'    => 'emotsional',
                'questions'   => [
                    ['Juftingiz qiyin paytda sizni qo\'llab-quvvatlaydimi?', 'emotsional'],
                    ['O\'zingizni oilada xavfsiz his qilasizmi?', 'emotsional'],
                    ['Juftingiz bilan yaqinlik his qilasizmi?', 'emotsional'],
                    ['Sevgingizni ifodalashdan qo\'rqmaysizmi?', 'emotsional'],
                    ['Juftingiz sizga e\'tibor beradimi?', 'emotsional'],
                    ['Birgalikda vaqt o\'tkazishdan zavqlanasizlarmi?', 'emotsional'],
                    ['Juftingizni hurmat qilasizmi?', 'emotsional'],
                ],
            ],
            [
                'title'       => 'Bola tarbiyasi',
                'description' => 'Farzandlar tarbiyasi borasidagi kelishuvlar va munosabatlarni baholaydi.',
                'emoji'       => '👶',
                'color'       => '#8b5cf6',
                'category'    => 'bola_tarbiyasi',
                'questions'   => [
                    ['Bola tarbiyasida yondashuvingiz bir xilmi?', 'muloqot'],
                    ['Farzandlarga intizom haqida kelishganmisizlar?', 'muloqot'],
                    ['Bolalar tarbiyasida bir-birini qo\'llab-quvvatlaysizlarmi?', 'emotsional'],
                    ['Farzandlar oldida janjal qilasizlarmi?', 'muloqot'],
                    ['Bolalar bilan vaqt o\'tkazishni rejalashtirish osonmi?', 'muloqot'],
                    ['Bolalar ta\'limi masalasida kelishasizlarmi?', 'muloqot'],
                ],
            ],
            [
                'title'       => 'Xiyonat va ishonch',
                'description' => 'Oiladagi ishonch darajasi va sadoqatni tekshiradi.',
                'emoji'       => '🔒',
                'color'       => '#e94560',
                'category'    => 'xiyonat',
                'questions'   => [
                    ['Juftingizga to\'liq ishonasizmi?', 'emotsional'],
                    ['Juftingizning boshqa odamlar bilan munosabati sizni bezovta qiladimi?', 'emotsional'],
                    ['Oilangizda sodiqlik asosiy qadriyat hisoblanadimi?', 'emotsional'],
                    ['O\'tgan xiyonat holatlarini yengib o\'tganmisiz?', 'emotsional'],
                    ['Juftingizning qayerda ekanligini bilish muhimmi?', 'emotsional'],
                    ['Ishonchsizlik muammosi oilangizda mavjudmi?', 'emotsional'],
                ],
            ],
            [
                'title'       => 'Xarakterlar muvofiqligi',
                'description' => 'Ikki tomonning xarakter, qiziqish va qadriyatlari mos kelishini baholaydi.',
                'emoji'       => '🧩',
                'color'       => '#3fb950',
                'category'    => 'xarakter',
                'questions'   => [
                    ['Juftingiz bilan umumiy qiziqishlaringiz bormi?', 'muloqot'],
                    ['Hayotiy qadriyatlaringiz bir xilmi?', 'emotsional'],
                    ['Juftingizning odatlari sizni bezovta qiladimi?', 'emotsional'],
                    ['Din va an\'anaviy qarashlarda kelishasizlarmi?', 'muloqot'],
                    ['Kelajak rejalaringiz bir yo\'nalishda ketmoqdami?', 'muloqot'],
                    ['Juftingizning xarakterini qabul qilasizmi?', 'emotsional'],
                ],
            ],
            [
                'title'       => 'Moddiy muammolar',
                'description' => 'Uy-joy, mulk va moddiy ta\'minot masalalarini baholaydi.',
                'emoji'       => '🏠',
                'color'       => '#58a6ff',
                'category'    => 'moddiy',
                'questions'   => [
                    ['Yashash joyingiz oilaga qulay ekanmi?', 'moliyaviy'],
                    ['Uy-joy masalasi janjal keltirib chiqaradimi?', 'moliyaviy'],
                    ['Mulk va mol-mulk bo\'linishi aniq belgilanganmi?', 'moliyaviy'],
                    ['Kelajakda uy sotib olish rejangiz bormi?', 'moliyaviy'],
                    ['Moddiy muammolar emotsional holatga ta\'sir qiladimi?', 'emotsional'],
                ],
            ],
            [
                'title'       => 'Zo\'ravonlik holatlari',
                'description' => 'Oiladagi zo\'ravonlik xavfini aniqlaydi va baholaydi.',
                'emoji'       => '🛡️',
                'color'       => '#d29922',
                'category'    => 'zovravonlik',
                'questions'   => [
                    ['Juftingiz ovozini ko\'tarib gapirishi sizni qo\'rqitirib qo\'yadimi?', 'emotsional'],
                    ['Jismoniy zo\'ravonlik holatlari bo\'lganmi?', 'emotsional'],
                    ['Psixologik bosim yoki haqorat bo\'ladimi?', 'emotsional'],
                    ['O\'zingizni erkin his qila olasizmi?', 'emotsional'],
                    ['Xavfsizligingiz haqida tashvishlanasizmi?', 'emotsional'],
                ],
            ],
            [
                'title'       => 'Giyohvandlik va ichkilikbozlik',
                'description' => 'Oiladagi spirtli ichimliklar va giyohvandlik muammolarini baholaydi.',
                'emoji'       => '🚫',
                'color'       => '#c87941',
                'category'    => 'ichkilik',
                'questions'   => [
                    ['Juftingiz spirtli ichimliklar iste\'mol qiladimi?', 'emotsional'],
                    ['Bu holat oilaviy hayotga ta\'sir qiladimi?', 'emotsional'],
                    ['Muammoni hal qilish uchun yordam so\'radingizmi?', 'muloqot'],
                    ['Farzandlar ushbu muammoga duchor bo\'lmoqdami?', 'emotsional'],
                    ['Ushbu muammo ustida ochiq gaplashganmisiz?', 'muloqot'],
                ],
            ],
            [
                'title'       => 'Uzoq yashash muammolari',
                'description' => 'Juftlar uzoq vaqt alohida yashaganda yuzaga keladigan muammolarni baholaydi.',
                'emoji'       => '✈️',
                'color'       => '#58a6ff',
                'category'    => 'uzoq_yashasish',
                'questions'   => [
                    ['Alohida yashash muddati qancha davom etdi?', 'muloqot'],
                    ['Uzoqda bo\'lgan payt muloqot yaxshi edi?', 'muloqot'],
                    ['Ishonch va sadoqat masalasi muammo bo\'ldimi?', 'emotsional'],
                    ['Yaqin bo\'lgandan so\'ng munosabat o\'zgarganmi?', 'emotsional'],
                    ['Alohida yashash davridagi xarajatlar muammo bo\'ldimi?', 'moliyaviy'],
                ],
            ],
            [
                'title'       => 'Qarindoshlar muammosi',
                'description' => 'Qaynona-qaynota va qarindoshlar bilan munosabatlarni baholaydi.',
                'emoji'       => '👨‍👩‍👧‍👦',
                'color'       => '#3fb950',
                'category'    => 'qarindosh',
                'questions'   => [
                    ['Qaynona-qaynota oilaviy ishlaringizga aralashadimi?', 'muloqot'],
                    ['Juftingiz sizi qarindoshlari oldida himoya qiladimi?', 'emotsional'],
                    ['Qarindoshlar bilan munosabat janjal keltirib chiqaradimi?', 'muloqot'],
                    ['Chegara va chegara belgilash masalasi hal qilinganmi?', 'muloqot'],
                    ['Qarindoshlar bilan munosabat sizni bezovta qiladimi?', 'emotsional'],
                    ['Bu masalani juftingiz bilan gaplashganmisiz?', 'muloqot'],
                ],
            ],
            [
                'title'       => 'Majburiy yoki shoshilinch nikoh',
                'description' => 'Nikohning ixtiyoriy va ongli tuzilganligini baholaydi.',
                'emoji'       => '💍',
                'color'       => '#8b5cf6',
                'category'    => 'majburiy_nikoh',
                'questions'   => [
                    ['Nikohingizdagi qarorni o\'zingiz qabul qildingizmi?', 'emotsional'],
                    ['To\'ydan oldin bir-biringizni yetarlicha bilardingizmi?', 'muloqot'],
                    ['Oila yoki jamiyat bosimi ta\'sir qildimi?', 'emotsional'],
                    ['Juftingizni tanlashda hech qanday tazyiq bo\'ldimi?', 'emotsional'],
                    ['Hozir ham ushbu nikohda bo\'lishni xohlaysizmi?', 'emotsional'],
                ],
            ],
        ];

        foreach ($testsData as $i => $testData) {
            $test = Test::create([
                'title'            => $testData['title'],
                'description'      => $testData['description'],
                'emoji'            => $testData['emoji'],
                'color'            => $testData['color'],
                'category'         => $testData['category'],
                'duration_minutes' => 15,
                'is_active'        => true,
                'order'            => $i + 1,
            ]);

            $categories = ['emotsional', 'moliyaviy', 'muloqot'];
            foreach ($testData['questions'] as $j => $q) {
                $text = is_array($q) ? $q[0] : $q;
                $tag  = is_array($q) ? $q[1] : $categories[$j % 3];

                $test->questions()->create([
                    'question_text' => $text,
                    'question_type' => 'scale',
                    'category_tag'  => $tag,
                    'order'         => $j + 1,
                    'is_active'     => true,
                ]);
            }
        }

        // ============================================================
        // TAVSIYALAR
        // ============================================================
        $recommendations = [
            [
                'title'       => 'Professional psixolog bilan maslahatlashing',
                'description' => 'Oilaviy muammolarni hal qilishda malakali mutaxassis yordam beradi. Dastlabki sessiya ko\'pincha eng muhim qadamdir.',
                'icon'        => '🧠',
                'color'       => 'qizil',
                'risk_level'  => 'high',
                'category'    => 'emotsional',
                'tags'        => ['Psixolog', 'Yordam', 'Majburiy'],
            ],
            [
                'title'       => 'Oilaviy mediatsiya xizmatidan foydalaning',
                'description' => 'Betaraf vositachi yordamida muammolarni hal qilish eng samarali usullardan biri hisoblanadi.',
                'icon'        => '🤝',
                'color'       => 'sariq',
                'risk_level'  => 'medium',
                'category'    => 'muloqot',
                'tags'        => ['Mediatsiya', 'Muloqot', 'Yechim'],
            ],
            [
                'title'       => 'Muloqot ko\'nikmalarini rivojlantiring',
                'description' => 'Aktiv tinglash, his-tuyg\'ularni ifodalash va konstruktiv muloqot oilaviy munosabatlarni mustahkamlaydi.',
                'icon'        => '💬',
                'color'       => 'yashil',
                'risk_level'  => 'low',
                'category'    => 'muloqot',
                'tags'        => ['Muloqot', 'Ko\'nikma', 'Amaliyot'],
            ],
            [
                'title'       => 'Moliyaviy rejalashtirish',
                'description' => 'Birgalikda byudjet tuzing, xarajatlarni kuzating va kelajak uchun jamg\'arma yarating.',
                'icon'        => '💳',
                'color'       => 'moviy',
                'risk_level'  => 'all',
                'category'    => 'moliyaviy',
                'tags'        => ['Moliya', 'Byudjet', 'Rejalashtirish'],
            ],
            [
                'title'       => 'Birgalikda vaqt o\'tkazing',
                'description' => 'Har hafta kamida 2-3 soat faqat juftingiz bilan ajrating. Umumiy faoliyat munosabatni mustahkamlaydi.',
                'icon'        => '🌿',
                'color'       => 'yashil',
                'risk_level'  => 'low',
                'category'    => 'emotsional',
                'tags'        => ['Vaqt', 'Munosabat', 'Sifat'],
            ],
            [
                'title'       => 'Chegara belgilang',
                'description' => 'Qarindoshlar va tashqi aralashuvdan himoyalanish uchun aniq chegara o\'rnating va uni birgalikda himoya qiling.',
                'icon'        => '🛡️',
                'color'       => 'sariq',
                'risk_level'  => 'medium',
                'category'    => 'muloqot',
                'tags'        => ['Chegara', 'Qarindoshlar', 'Himoya'],
            ],
            [
                'title'       => 'Favqulodda psixologik yordam',
                'description' => 'Zo\'ravonlik holatlari mavjud bo\'lsa, darhol 1011 (Ijtimoiy yordam) yoki mahalliy yordam markaziga murojaat qiling.',
                'icon'        => '🚨',
                'color'       => 'qizil',
                'risk_level'  => 'high',
                'category'    => 'emotsional',
                'tags'        => ['Xavfsizlik', 'Zo\'ravonlik', 'Yordam'],
            ],
        ];

        foreach ($recommendations as $i => $rec) {
            Recommendation::create([
                'title'       => $rec['title'],
                'description' => $rec['description'],
                'icon'        => $rec['icon'],
                'color'       => $rec['color'],
                'risk_level'  => $rec['risk_level'],
                'category'    => $rec['category'],
                'tags'        => $rec['tags'],
                'is_active'   => true,
                'order'       => $i + 1,
            ]);
        }
    }
}
