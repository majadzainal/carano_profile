<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Inquiry;
use App\Models\MediaFile;
use App\Models\PageSection;
use App\Models\Post;
use App\Models\RoadmapStep;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\TradeHub;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CaranoCmsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Default Super Admin Account
        $admin = User::updateOrCreate(
            ['email' => 'admin@caranologistik.co.id'],
            [
                'name' => 'Admin Carano Utama',
                'role' => 'admin',
                'password' => Hash::make('Carano2026!'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Site Settings
        $settings = [
            ['key' => 'company_name', 'group' => 'brand', 'label' => 'Nama Perusahaan Resmi', 'value_id' => 'PT. CARANO UTAMA LOGISTIK', 'value_en' => 'PT. CARANO UTAMA LOGISTIK', 'type' => 'text', 'sort_order' => 1],
            ['key' => 'company_short_name', 'group' => 'brand', 'label' => 'Nama Singkat Brand', 'value_id' => 'CARANO', 'value_en' => 'CARANO', 'type' => 'text', 'sort_order' => 2],
            ['key' => 'company_tagline', 'group' => 'brand', 'label' => 'Tagline Perusahaan', 'value_id' => 'Mitra Logistik Impor End-to-End Asia Timur ke Indonesia', 'value_en' => 'End-to-End East Asia to Indonesia Import Logistics Partner', 'type' => 'text', 'sort_order' => 3],
            ['key' => 'logo_light', 'group' => 'brand', 'label' => 'Logo Utama (Background Terang)', 'value_id' => '/images/brand/logo-carano-light.png', 'value_en' => '/images/brand/logo-carano-light.png', 'type' => 'image', 'sort_order' => 4],
            ['key' => 'logo_dark', 'group' => 'brand', 'label' => 'Logo Footer / Sidebar (Background Gelap)', 'value_id' => '/images/brand/logo-carano-dark.png', 'value_en' => '/images/brand/logo-carano-dark.png', 'type' => 'image', 'sort_order' => 5],
            ['key' => 'logo_mark', 'group' => 'brand', 'label' => 'Ikon Mark Carano', 'value_id' => '/images/brand/logo-carano-mark.png', 'value_en' => '/images/brand/logo-carano-mark.png', 'type' => 'image', 'sort_order' => 6],
            ['key' => 'brochure_pdf', 'group' => 'brand', 'label' => 'File Brosur / Road Map Shipment (PDF)', 'value_id' => '/uploads/docs/CARANO_Road_Map_Shipment.pdf', 'value_en' => '/uploads/docs/CARANO_Road_Map_Shipment.pdf', 'type' => 'file', 'sort_order' => 7],

            ['key' => 'contact_address', 'group' => 'contact', 'label' => 'Alamat Kantor', 'value_id' => 'Jl. Duta Boulevard Barat No.C-10, RT.001/RW.011, Harapan Baru, Kec. Bekasi Utara, Kota Bekasi, Jawa Barat 17123', 'value_en' => 'Jl. Duta Boulevard Barat No.C-10, RT.001/RW.011, Harapan Baru, North Bekasi, Bekasi City, West Java 17123, Indonesia', 'type' => 'textarea', 'sort_order' => 10],
            ['key' => 'contact_maps_url', 'group' => 'contact', 'label' => 'Link Google Maps Kantor', 'value_id' => 'https://maps.app.goo.gl/8u9aomAeqFG2EM7H7', 'value_en' => 'https://maps.app.goo.gl/8u9aomAeqFG2EM7H7', 'type' => 'url', 'sort_order' => 11],
            ['key' => 'contact_website', 'group' => 'contact', 'label' => 'Website Resmi', 'value_id' => 'http://www.caranoutama.co.id/', 'value_en' => 'http://www.caranoutama.co.id/', 'type' => 'url', 'sort_order' => 12],
            ['key' => 'contact_email', 'group' => 'contact', 'label' => 'Email Resmi', 'value_id' => 'info@caranoutama.co.id', 'value_en' => 'info@caranoutama.co.id', 'type' => 'email', 'sort_order' => 13],
            ['key' => 'contact_phone', 'group' => 'contact', 'label' => 'Nomor Telepon', 'value_id' => '021-38312253', 'value_en' => '+62 21 3831 2253', 'type' => 'phone', 'sort_order' => 14],
            ['key' => 'contact_whatsapp', 'group' => 'contact', 'label' => 'Nomor WhatsApp (Format 628xxx)', 'value_id' => '622138312253', 'value_en' => '622138312253', 'type' => 'phone', 'sort_order' => 15],
            ['key' => 'business_hours', 'group' => 'contact', 'label' => 'Jam Operasional', 'value_id' => 'Senin – Jumat: 08.30 – 17.30 WIB | Sabtu: 08.30 – 13.00 WIB', 'value_en' => 'Mon – Fri: 08:30 – 17:30 WIB | Sat: 08:30 – 13:00 WIB', 'type' => 'text', 'sort_order' => 16],

            ['key' => 'social_linkedin', 'group' => 'social', 'label' => 'URL LinkedIn', 'value_id' => 'https://linkedin.com', 'value_en' => 'https://linkedin.com', 'type' => 'url', 'sort_order' => 20],
            ['key' => 'social_instagram', 'group' => 'social', 'label' => 'URL Instagram', 'value_id' => 'https://instagram.com', 'value_en' => 'https://instagram.com', 'type' => 'url', 'sort_order' => 21],

            ['key' => 'seo_default_title', 'group' => 'seo', 'label' => 'Default SEO Title', 'value_id' => 'PT. CARANO UTAMA LOGISTIK — Solusi Impor & Logistik Maritim End-to-End', 'value_en' => 'PT. CARANO UTAMA LOGISTIK — End-to-End International Import & Maritime Logistics', 'type' => 'text', 'sort_order' => 30],
            ['key' => 'seo_default_description', 'group' => 'seo', 'label' => 'Default SEO Description', 'value_id' => 'Layanan logistik impor laut terintegrasi dari pabrik Jepang, China, Taiwan, Korea & Singapura menuju Tanjung Priok, Tanjung Emas, dan Tanjung Perak hingga pengiriman ke tujuan.', 'value_en' => 'Integrated sea freight import logistics from factories in Japan, China, Taiwan, Korea & Singapore to Tanjung Priok, Tanjung Emas, and Tanjung Perak through final door delivery.', 'type' => 'textarea', 'sort_order' => 31],
        ];

        foreach ($settings as $item) {
            SiteSetting::updateOrCreate(['key' => $item['key']], $item);
        }

        // 3. Page Sections (Editable via CMS Page Editor)
        $sections = [
            [
                'page_slug' => 'home',
                'section_key' => 'home_hero',
                'section_label' => 'Homepage — Hero Banner',
                'badge_id' => 'INTEGRATED IMPORT & MULTIMODAL LOGISTICS',
                'badge_en' => 'INTEGRATED IMPORT & MULTIMODAL LOGISTICS',
                'title_id' => 'Mengoptimalkan Alur Pengiriman Impor dari Pabrik Asia hingga Pintu Gudang Anda.',
                'title_en' => 'Optimizing End-to-End Import Shipments from Asian Factories to Your Warehouse.',
                'subtitle_id' => 'PT. CARANO UTAMA LOGISTIK menangani seluruh rantai pasok impor—mulai dari strapping & trucking di Jepang, China, Taiwan, Korea & Singapura, kepabeanan ekspor-impor, perjalanan laut, hingga stripping dan delivery di Indonesia.',
                'subtitle_en' => 'PT. CARANO UTAMA LOGISTIK manages your entire import supply chain—from factory strapping & trucking in Japan, China, Taiwan, Korea & Singapore, export-import customs, ocean freight, to stripping and final delivery across Indonesia.',
                'cta_label_id' => 'Konsultasi Pengiriman',
                'cta_label_en' => 'Request a Quote',
                'cta_url' => '/kontak',
                'secondary_cta_label_id' => 'Unduh Road Map PDF',
                'secondary_cta_label_en' => 'Download Road Map PDF',
                'secondary_cta_url' => '/uploads/docs/CARANO_Road_Map_Shipment.pdf',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'page_slug' => 'home',
                'section_key' => 'home_metrics',
                'section_label' => 'Homepage — Statistik Utama',
                'badge_id' => 'JEJAK OPERASIONAL',
                'badge_en' => 'OPERATIONAL FOOTPRINT',
                'title_id' => 'Jaringan Koridor Impor Terukur & Andal',
                'title_en' => 'Measurable & Reliable Import Corridor Network',
                'extra_json' => [
                    'items' => [
                        ['value' => '5', 'unit_id' => 'Negara Asal', 'unit_en' => 'Origin Countries', 'desc_id' => 'Jepang, China, Taiwan, Korea & Singapura', 'desc_en' => 'Japan, China, Taiwan, Korea & Singapore'],
                        ['value' => '3', 'unit_id' => 'Pelabuhan Utama RI', 'unit_en' => 'Major Indonesian Ports', 'desc_id' => 'Tanjung Priok, Tanjung Emas & Tanjung Perak', 'desc_en' => 'Tanjung Priok, Tanjung Emas & Tanjung Perak'],
                        ['value' => '10', 'unit_id' => 'Tahap Terkontrol', 'unit_en' => 'Controlled Stages', 'desc_id' => 'Road Map Shipment transparan dari hulu ke hilir', 'desc_en' => 'Transparent end-to-end Shipment Road Map'],
                        ['value' => '3', 'unit_id' => 'Moda Terpadu', 'unit_en' => 'Integrated Modes', 'desc_id' => 'Laut (Sea), Darat (Trucking) & Udara (Air)', 'desc_en' => 'Sea Freight, Inland Trucking & Air Support'],
                    ],
                ],
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'page_slug' => 'home',
                'section_key' => 'home_challenge',
                'section_label' => 'Homepage — Tantangan & Solusi Impor',
                'badge_id' => 'MENGAPA SISTEM TERINTEGRASI PENTING',
                'badge_en' => 'WHY INTEGRATED LOGISTICS MATTERS',
                'title_id' => 'Menghilangkan Hambatan Klasik dalam Rantai Impor Lintas Negara.',
                'title_en' => 'Eliminating Classic Bottlenecks in Cross-Border Import Chains.',
                'subtitle_id' => 'Koordinasi terpisah antara agen negara asal, pelayaran, bea cukai, dan trucking lokal sering menimbulkan biaya demurrage serta keterlambatan. CARANO menyatukan semuanya dalam satu kendali.',
                'subtitle_en' => 'Fragmented coordination across origin agents, ocean carriers, customs brokers, and local haulers triggers demurrage fees and delays. CARANO unifies every stage under one accountable team.',
                'extra_json' => [
                    'cards' => [
                        [
                            'tag_id' => 'Dokumen & Pajak Lintas Negara',
                            'tag_en' => 'Cross-Border Docs & Taxes',
                            'problem_id' => 'Kesalahan HS Code, dokumen ekspor negara asal, atau kelengkapan asuransi memicu penahanan kargo.',
                            'problem_en' => 'Mismatched HS Codes, export docs, or incomplete insurance trigger costly cargo holds.',
                            'solution_id' => 'Tim CARANO memverifikasi dokumen ekspor, pajak negara asal, asuransi, hingga Bea Cukai terminal Indonesia.',
                            'solution_en' => 'CARANO verifies origin export paperwork, origin duties, cargo insurance, and Indonesian terminal customs.',
                        ],
                        [
                            'tag_id' => 'Antrean & Sandar Pelabuhan',
                            'tag_en' => 'Port Queue & Berthing',
                            'problem_id' => 'Kurangnya visibilitas saat kapal stand by di pelabuhan menghambat perencanaan jadwal produksi.',
                            'problem_en' => 'Lack of visibility during vessel anchorage disrupts factory and warehouse receiving schedules.',
                            'solution_id' => 'Monitoring proaktif antrean kapal di Tanjung Priok, Tanjung Emas, dan Tanjung Perak hingga kontainer turun.',
                            'solution_en' => 'Proactive tracking of berthing queues across Tanjung Priok, Tanjung Emas, and Tanjung Perak through discharge.',
                        ],
                        [
                            'tag_id' => 'Handling Fisik & Last-Mile',
                            'tag_en' => 'Cargo Handling & Last-Mile',
                            'problem_id' => 'Risiko kerusakan barang saat loading/stripping dan keterlambatan armada pengiriman darat.',
                            'problem_en' => 'Cargo damage risks during strapping/stripping and unreliable inland delivery fleets.',
                            'solution_id' => 'Standar strapping ketat di pabrik asal serta proses stripping, trucking, dan delivery tepat waktu ke lokasi tujuan.',
                            'solution_en' => 'Strict origin factory strapping paired with disciplined stripping, trucking, and on-time door delivery.',
                        ],
                    ],
                ],
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'page_slug' => 'home',
                'section_key' => 'home_roadmap_intro',
                'section_label' => 'Homepage — Intro Road Map Shipment',
                'badge_id' => 'ROAD MAP SHIPMENT',
                'badge_en' => 'ROAD MAP SHIPMENT',
                'title_id' => '10 Tahap Pengiriman Terstruktur dari Pabrik Asal ke Tujuan Akhir.',
                'title_en' => '10 Structured Shipment Stages from Origin Factory to Final Destination.',
                'subtitle_id' => 'Klik setiap tahapan di bawah untuk melihat bagaimana PT. CARANO UTAMA LOGISTIK menjaga ketepatan dokumen, keamanan fisik kargo, dan kecepatan arus barang Anda.',
                'subtitle_en' => 'Select each stage below to see how PT. CARANO UTAMA LOGISTIK ensures document compliance, physical cargo safety, and smooth freight flow.',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'page_slug' => 'home',
                'section_key' => 'home_services_intro',
                'section_label' => 'Homepage — Intro Layanan Modular',
                'badge_id' => 'SOLUSI LAYANAN',
                'badge_en' => 'OUR SOLUTIONS',
                'title_id' => 'Layanan Logistik Modular Sesuai Skala Bisnis Anda.',
                'title_en' => 'Modular Logistics Solutions Tailored to Your Business Scale.',
                'subtitle_id' => 'Baik pengiriman kontainer penuh (FCL), konsolidasi (LCL), pengurusan bea cukai khusus, maupun dukungan pengiriman udara mendesak.',
                'subtitle_en' => 'Whether Full Container Load (FCL), consolidation (LCL), dedicated customs brokerage, or urgent air freight support.',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'page_slug' => 'home',
                'section_key' => 'home_network_intro',
                'section_label' => 'Homepage — Intro Jaringan Rute',
                'badge_id' => 'JARINGAN RUTE INTERNASIONAL',
                'badge_en' => 'INTERNATIONAL CORRIDOR NETWORK',
                'title_id' => 'Menghubungkan 5 Pusat Industri Asia ke 3 Gerbang Maritim Indonesia.',
                'title_en' => 'Connecting 5 Asian Manufacturing Hubs to 3 Indonesian Maritime Gateways.',
                'subtitle_id' => 'Arahkan kursor atau pilih hub negara asal dan pelabuhan tujuan pada peta untuk mengeksplorasi cakupan operasional aktif kami.',
                'subtitle_en' => 'Hover or click any origin hub or Indonesian destination port on the map to explore our active corridor coverage.',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'page_slug' => 'home',
                'section_key' => 'home_why_us',
                'section_label' => 'Homepage — Keunggulan CARANO',
                'badge_id' => 'KEUNGGULAN KAMI',
                'badge_en' => 'WHY CARANO',
                'title_id' => 'Ketelitian Operasional Berpadu dengan Dedikasi Layanan.',
                'title_en' => 'Operational Precision Paired with Dedicated Accountability.',
                'subtitle_id' => 'Sebagaimana filosofi Carano—wadah kehormatan yang menyambut dengan amanah—kami memperlakukan setiap kontainer dan dokumen klien dengan standar tertinggi.',
                'subtitle_en' => 'Inspired by the Carano—a traditional emblem of honor and trust—we safeguard every client container and document with uncompromising standards.',
                'extra_json' => [
                    'pillars' => [
                        ['title_id' => 'Satu Pintu (Single Point of Contact)', 'title_en' => 'Single Point of Contact', 'desc_id' => 'Koordinasi terpusat dari pabrik di luar negeri hingga pembongkaran di gudang Anda.', 'desc_en' => 'Unified coordination from overseas factory pickup through warehouse unloading.'],
                        ['title_id' => 'Kepatuhan Bea Cukai & Pajak', 'title_en' => 'Customs & Tax Compliance', 'desc_id' => 'Pengurusan legal dokumen ekspor, asuransi kargo, pajak, dan kepabeanan terminal Indonesia.', 'desc_en' => 'Full legal handling of export docs, cargo insurance, duties, and Indonesian terminal customs.'],
                        ['title_id' => 'Cakupan 3 Pelabuhan Strategis Jawa', 'title_en' => '3 Strategic Java Ports Coverage', 'desc_id' => 'Tim lapangan langsung di Tanjung Priok, Tanjung Emas, dan Tanjung Perak.', 'desc_en' => 'On-ground teams across Tanjung Priok, Tanjung Emas, and Tanjung Perak.'],
                        ['title_id' => 'Transparansi Status Real-Time', 'title_en' => 'Proactive Milestone Updates', 'desc_id' => 'Pembaruan berkala di tiap fase: loading, perjalanan laut, antrean sandar, hingga delivery.', 'desc_en' => 'Structured milestone updates across loading, sea transit, berthing queue, and final delivery.'],
                    ],
                ],
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'page_slug' => 'home',
                'section_key' => 'home_cta',
                'section_label' => 'Homepage — Pre-Footer CTA Banner',
                'badge_id' => 'SIAP MENGIRIM BERSAMA CARANO?',
                'badge_en' => 'READY TO SHIP WITH CARANO?',
                'title_id' => 'Diskusikan Kebutuhan Impor & Dapatkan Estimasi Rute Terbaik.',
                'title_en' => 'Discuss Your Import Plan & Receive a Tailored Route Estimate.',
                'subtitle_id' => 'Tim konsultan logistik PT. CARANO UTAMA LOGISTIK siap membantu menghitung estimasi waktu, kebutuhan dokumen, dan penawaran transparan untuk rute Asia Timur – Indonesia.',
                'subtitle_en' => 'Our logistics specialists at PT. CARANO UTAMA LOGISTIK are ready to assist with lead times, document checklists, and transparent East Asia – Indonesia quotations.',
                'cta_label_id' => 'Minta Penawaran Sekarang',
                'cta_label_en' => 'Request a Quote Now',
                'cta_url' => '/kontak',
                'secondary_cta_label_id' => 'Lihat Alur 10 Tahap',
                'secondary_cta_label_en' => 'Explore 10-Step Roadmap',
                'secondary_cta_url' => '/alur-pengiriman',
                'sort_order' => 8,
                'is_active' => true,
            ],
            [
                'page_slug' => 'about',
                'section_key' => 'about_story',
                'section_label' => 'Tentang Kami — Profil, Visi & Misi',
                'badge_id' => 'TENTANG PT. CARANO UTAMA LOGISTIK',
                'badge_en' => 'ABOUT PT. CARANO UTAMA LOGISTIK',
                'title_id' => 'Menjembatani Perdagangan Global dengan Amanah, Presisi, dan Integrasi Multimoda.',
                'title_en' => 'Bridging Global Trade with Trust, Precision, and Multimodal Integration.',
                'subtitle_id' => 'PT. CARANO UTAMA LOGISTIK adalah perusahaan jasa pengurusan transportasi dan logistik impor yang berfokus pada koridor industri Asia Timur dan Asia Tenggara menuju Indonesia.',
                'subtitle_en' => 'PT. CARANO UTAMA LOGISTIK is an international freight forwarding and import logistics company focused on East and Southeast Asian industrial corridors into Indonesia.',
                'body_id' => '<p>Berlandaskan filosofi <strong>Carano</strong>—simbol penghormatan dan ketulusan pelayanan dalam budaya Nusantara—kami hadir membawa standar baru dalam pengelolaan logistik impor. Logo kami memadukan wadah Carano yang menopang bola dunia serta tiga moda transportasi utama: <strong>Laut, Darat, dan Udara</strong>.</p><p>Dengan fokus rute dari gudang pabrik di <strong>Jepang, China, Taiwan, Korea Selatan, dan Singapura</strong> menuju <strong>Tanjung Priok, Tanjung Emas, dan Tanjung Perak</strong>, kami memastikan setiap proses mulai dari strapping, dokumen ekspor, asuransi, kepabeanan terminal, hingga pengiriman darat berjalan terukur dan bebas hambatan.</p>',
                'body_en' => '<p>Rooted in the philosophy of the <strong>Carano</strong>—a traditional emblem of honor and sincere stewardship—we deliver a modern standard in international import logistics. Our emblem unites the Carano supporting the globe alongside three integrated transport modes: <strong>Sea, Land, and Air</strong>.</p><p>Specializing in corridors from factory warehouses across <strong>Japan, China, Taiwan, South Korea, and Singapore</strong> into <strong>Tanjung Priok, Tanjung Emas, and Tanjung Perak</strong>, we ensure every milestone from origin strapping, export documentation, insurance, terminal customs clearance, to final trucking operates smoothly and transparently.</p>',
                'extra_json' => [
                    'vision_id' => 'Menjadi mitra logistik impor terpercaya dan terdepan di Indonesia yang menghadirkan rantai pasok lintas negara yang transparan, aman, dan berdaya saing global.',
                    'vision_en' => 'To be Indonesia’s most trusted import logistics partner, delivering transparent, secure, and globally competitive cross-border supply chains.',
                    'missions_id' => [
                        'Menjalankan 10 tahapan Road Map Shipment secara disiplin, tepat waktu, dan terdokumentasi.',
                        'Memastikan kepatuhan penuh terhadap regulasi pajak, bea cukai, dan proteksi asuransi kargo.',
                        'Membangun jaringan kolaborasi solid bersama mitra pelabuhan, pelayaran, dan armada darat.',
                        'Memberikan komunikasi proaktif dan konsultasi solusi biaya yang efisien bagi setiap klien.',
                    ],
                    'missions_en' => [
                        'Execute our 10-step Shipment Road Map with discipline, punctuality, and clear documentation.',
                        'Maintain full regulatory compliance across origin taxes, customs clearance, and cargo insurance.',
                        'Cultivate dependable networks across ports, ocean carriers, and domestic trucking partners.',
                        'Provide proactive status visibility and cost-efficient routing advice for every client.',
                    ],
                ],
                'sort_order' => 1,
                'is_active' => true,
            ],
        ];

        foreach ($sections as $section) {
            PageSection::updateOrCreate(['section_key' => $section['section_key']], $section);
        }

        // 4. 10-Step Road Map Shipment (Exact from CARANO_Road Map Shipment.pdf)
        $roadmapSteps = [
            [
                'step_number' => 1,
                'phase' => 'origin',
                'title_id' => 'Gudang Pabrik (Jepang, China, Taiwan, Korea & Singapura)',
                'title_en' => 'Origin Factory Warehouse (Japan, China, Taiwan, Korea & Singapore)',
                'description_id' => 'Koordinasi langsung dengan supplier atau pabrik di 5 negara asal utama untuk verifikasi kesiapan barang, pengecekan packing list, dan penjadwalan penjemputan.',
                'description_en' => 'Direct coordination with overseas suppliers across 5 key Asian manufacturing hubs to verify cargo readiness, packing lists, and pickup scheduling.',
                'highlights_id' => ['Cakupan 5 negara asal utama Asia', 'Verifikasi kuantitas & kemasan kargo', 'Penjadwalan pickup langsung di pabrik'],
                'highlights_en' => ['Coverage across 5 major Asian origin hubs', 'Cargo quantity & packaging verification', 'Direct factory pickup scheduling'],
                'icon' => 'factory',
            ],
            [
                'step_number' => 2,
                'phase' => 'origin',
                'title_id' => 'Strapping & Trucking',
                'title_en' => 'Strapping & Origin Trucking',
                'description_id' => 'Pengikatan dan pengamanan muatan (strapping) sesuai standar ekspor internasional serta pengangkutan darat menggunakan armada truk menuju pelabuhan muat.',
                'description_en' => 'Export-grade cargo strapping and securing paired with reliable inland trucking from the factory warehouse to the port of loading.',
                'highlights_id' => ['Pengamanan fisik strapping & lashing', 'Armada trucking terjadwal di negara asal', 'Dokumentasi foto kondisi muatan'],
                'highlights_en' => ['Export-grade strapping & lashing', 'Scheduled origin inland trucking', 'Photo documentation of cargo condition'],
                'icon' => 'truck',
            ],
            [
                'step_number' => 3,
                'phase' => 'origin',
                'title_id' => 'Pelabuhan Muat / Asal',
                'title_en' => 'Port of Loading (Origin Port)',
                'description_id' => 'Penerimaan kargo di kawasan pelabuhan muat asal, penimbangan VGM (Verified Gross Mass), serta konsolidasi kontainer di Container Yard (CY).',
                'description_en' => 'Cargo gate-in at the origin port of loading, VGM weighing compliance, and container staging inside the Container Yard (CY).',
                'highlights_id' => ['Gate-in Container Yard negara asal', 'Verifikasi berat kontainer (VGM)', 'Sinkronisasi jadwal closing kapal'],
                'highlights_en' => ['Origin Container Yard gate-in', 'Verified Gross Mass (VGM) compliance', 'Vessel closing schedule synchronization'],
                'icon' => 'anchor',
            ],
            [
                'step_number' => 4,
                'phase' => 'origin',
                'title_id' => 'Pengurusan Dokumen, Pajak Negara Asal & Asuransi',
                'title_en' => 'Origin Export Docs, Local Taxes & Cargo Insurance',
                'description_id' => 'Penyelesaian dokumen ekspor (Invoice, Packing List, B/L, COO/Form E/AK/IJEPA), kewajiban pajak negara asal, serta aktivasi polis asuransi kargo laut.',
                'description_en' => 'Full execution of export documentation (Invoice, Packing List, B/L, COO), origin tax clearance, and marine cargo insurance coverage.',
                'highlights_id' => ['Export customs clearance & Bill of Lading', 'Penyelesaian pajak ekspor negara asal', 'Perlindungan asuransi kargo menyeluruh'],
                'highlights_en' => ['Export clearance & Bill of Lading', 'Origin country tax settlement', 'Comprehensive marine cargo insurance'],
                'icon' => 'file-check',
            ],
            [
                'step_number' => 5,
                'phase' => 'sea',
                'title_id' => 'Kontainer Masuk ke Kapal',
                'title_en' => 'Container Loading onto Vessel',
                'description_id' => 'Proses pemuatan kontainer secara aman ke atas kapal kargo (vessel loading) disertai konfirmasi On-Board Bill of Lading resmi.',
                'description_en' => 'Safe crane loading of containers aboard the designated ocean vessel followed by official On-Board Bill of Lading confirmation.',
                'highlights_id' => ['Konfirmasi muat kapal (On-Board)', 'Validasi nomor segel & kontainer', 'Penerbitan jadwal ETD & ETA resmi'],
                'highlights_en' => ['Confirmed vessel On-Board status', 'Container & seal number validation', 'Official ETD & ETA sailing schedule'],
                'icon' => 'container',
            ],
            [
                'step_number' => 6,
                'phase' => 'sea',
                'title_id' => 'Perjalanan Laut',
                'title_en' => 'International Ocean Voyage',
                'description_id' => 'Pemantauan perjalanan kapal kargo selama transit laut internasional hingga mendekati perairan Indonesia, disertai persiapan dokumen pra-kedatangan (pre-alert).',
                'description_en' => 'Active vessel tracking throughout the international ocean voyage accompanied by pre-arrival document preparation for faster clearance.',
                'highlights_id' => ['Tracking posisi kapal & pembaruan ETA', 'Persiapan dokumen pra-kedatangan (Pre-Alert)', 'Mitigasi dini jika ada perubahan rute'],
                'highlights_en' => ['Vessel tracking & live ETA updates', 'Pre-arrival customs document readiness', 'Early mitigation for schedule shifts'],
                'icon' => 'ship',
            ],
            [
                'step_number' => 7,
                'phase' => 'destination',
                'title_id' => 'Stand By di Daerah Pelabuhan & Masuk Antrian (Tanjung Priok, Tanjung Emas, Tanjung Perak)',
                'title_en' => 'Port Anchorage & Berthing Queue (Tanjung Priok, Tanjung Emas, Tanjung Perak)',
                'description_id' => 'Koordinasi kedatangan kapal saat berada di area labuh (anchorage) dan antrean sandar di 3 pelabuhan utama Indonesia: Tanjung Priok, Tanjung Emas, dan Tanjung Perak.',
                'description_en' => 'Coordinating vessel arrival at anchorage and monitoring berthing queues across Indonesia’s 3 major ports: Tanjung Priok, Tanjung Emas, and Tanjung Perak.',
                'highlights_id' => ['Tanjung Priok (Jakarta)', 'Tanjung Emas (Semarang)', 'Tanjung Perak (Surabaya)'],
                'highlights_en' => ['Tanjung Priok (Jakarta)', 'Tanjung Emas (Semarang)', 'Tanjung Perak (Surabaya)'],
                'icon' => 'radar',
            ],
            [
                'step_number' => 8,
                'phase' => 'destination',
                'title_id' => 'Kapal Sandar, Lalu Kontainer Keluar dari Kapal',
                'title_en' => 'Vessel Berthing & Container Discharge',
                'description_id' => 'Setelah kapal bersandar di dermaga, kontainer dibongkar dari kapal (discharge) menuju lapangan penumpukan terminal secara terpantau.',
                'description_en' => 'Upon vessel berthing at the quay, containers are discharged safely from the ship to the terminal stacking yard under active monitoring.',
                'highlights_id' => ['Konfirmasi sandar dermaga (Berthing)', 'Pembongkaran kontainer (Discharge)', 'Penerbitan Delivery Order (DO) pelayaran'],
                'highlights_en' => ['Confirmed berth arrival', 'Monitored container discharge', 'Carrier Delivery Order (DO) processing'],
                'icon' => 'arrow-down-circle',
            ],
            [
                'step_number' => 9,
                'phase' => 'destination',
                'title_id' => 'Pengurusan Dokumen, Pajak & Bea Cukai di Terminal',
                'title_en' => 'Import Documentation, Taxes & Terminal Customs Clearance',
                'description_id' => 'Penyelesaian PIB (Pemberitahuan Impor Barang), pembayaran bea masuk & pajak impor, pemeriksaan kepabeanan, hingga terbitnya SPPB (Surat Persetujuan Pengeluaran Barang).',
                'description_en' => 'Execution of import customs declarations (PIB), duty & import tax settlement, customs inspection coordination, through SPPB release.',
                'highlights_id' => ['Pengajuan PIB & penyelesaian Bea Masuk/Pajak', 'Koordinasi pemeriksaan Bea Cukai terminal', 'Penerbitan SPPB & izin keluar pelabuhan'],
                'highlights_en' => ['Import declaration (PIB) & duty settlement', 'Terminal Customs clearance coordination', 'SPPB release & port gate-out permit'],
                'icon' => 'shield-check',
            ],
            [
                'step_number' => 10,
                'phase' => 'destination',
                'title_id' => 'Stripping, Trucking & Delivery ke Tujuan',
                'title_en' => 'Stripping, Domestic Trucking & Final Delivery',
                'description_id' => 'Pembongkaran muatan dari kontainer (stripping) atau pengiriman langsung via trailer/truk domestik hingga serah terima aman di gudang/lokasi tujuan klien.',
                'description_en' => 'Container deconsolidation (stripping) or direct trailer haulage and final door-to-door delivery with verified proof of receipt at your warehouse.',
                'highlights_id' => ['Proses stripping aman & terinventarisasi', 'Pengiriman trucking ke seluruh tujuan', 'Serah terima resmi (Proof of Delivery)'],
                'highlights_en' => ['Safe, inventoried container stripping', 'Domestic trucking to destination site', 'Verified Proof of Delivery (POD)'],
                'icon' => 'map-pin-check',
            ],
        ];

        foreach ($roadmapSteps as $step) {
            RoadmapStep::updateOrCreate(['step_number' => $step['step_number']], $step);
        }

        // 5. Modular Services
        $services = [
            [
                'slug' => 'sea-freight-import',
                'badge_id' => 'LAYANAN UTAMA',
                'badge_en' => 'CORE SERVICE',
                'title_id' => 'Sea Freight Impor (FCL & LCL)',
                'title_en' => 'International Sea Freight Import (FCL & LCL)',
                'short_desc_id' => 'Pengiriman kontainer penuh (20ft/40ft/HQ) dan konsolidasi LCL reguler dari Jepang, China, Taiwan, Korea, dan Singapura menuju 3 pelabuhan utama Indonesia.',
                'short_desc_en' => 'Scheduled Full Container Load (20ft/40ft/HQ) and LCL consolidation from Japan, China, Taiwan, Korea, and Singapore into Indonesia’s 3 main maritime ports.',
                'body_id' => '<p>Layanan <strong>Sea Freight Impor</strong> PT. CARANO UTAMA LOGISTIK dirancang untuk menjaga kepastian jadwal pasokan industri dan perdagangan Anda. Kami bekerja sama dengan jaringan pelayaran internasional tepercaya untuk menyediakan ruang kontainer yang stabil serta tarif kompetitif.</p><h3>Cakupan Layanan</h3><ul><li>Pengiriman <strong>FCL (Full Container Load)</strong> 20ft, 40ft, dan 40ft High Cube.</li><li>Pengiriman <strong>LCL (Less than Container Load)</strong> dengan konsolidasi mingguan yang efisien.</li><li>Pelayanan langsung ke Pelabuhan Tanjung Priok, Tanjung Emas, dan Tanjung Perak.</li><li>Pemantauan posisi kapal dan jadwal sandar secara berkala.</li></ul>',
                'body_en' => '<p>PT. CARANO UTAMA LOGISTIK’s <strong>Sea Freight Import</strong> solution is engineered to protect your industrial and commercial supply schedules. We partner with tier-one ocean carriers to secure reliable container space and competitive rates.</p><h3>Service Scope</h3><ul><li><strong>FCL (Full Container Load)</strong> in 20ft, 40ft, and 40ft High Cube equipment.</li><li><strong>LCL (Less than Container Load)</strong> weekly consolidation for flexible volumes.</li><li>Direct arrival coverage at Tanjung Priok, Tanjung Emas, and Tanjung Perak.</li><li>Proactive vessel voyage tracking and berthing queue updates.</li></ul>',
                'icon' => 'ship',
                'image_path' => '/images/illustrations/sea-freight-vessel.jpg',
                'features_id' => ['FCL 20ft / 40ft / 40HQ & LCL Konsolidasi', 'Rute reguler 5 Negara Asal Asia Timur', 'Monitoring ETA & antrean sandar kapal'],
                'features_en' => ['FCL 20ft / 40ft / 40HQ & LCL Consolidation', 'Regular sailings from 5 Asian Origin Hubs', 'Proactive ETA & berthing queue tracking'],
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'slug' => 'origin-handling-insurance',
                'badge_id' => 'ORIGIN LOGISTICS',
                'badge_en' => 'ORIGIN LOGISTICS',
                'title_id' => 'Origin Pickup, Strapping, Export Docs & Asuransi',
                'title_en' => 'Origin Pickup, Strapping, Export Docs & Insurance',
                'short_desc_id' => 'Penjemputan langsung di gudang pabrik luar negeri, pengamanan strapping, trucking ke pelabuhan muat, dokumen & pajak negara asal, hingga proteksi asuransi kargo.',
                'short_desc_en' => 'Direct factory warehouse pickup abroad, export-grade strapping, origin trucking, export documentation & local taxes, plus full marine cargo insurance.',
                'body_id' => '<p>Keberhasilan pengiriman impor dimulai sejak barang meninggalkan gudang pabrik di negara asal. Jaringan agen CARANO di <strong>Jepang, China, Taiwan, Korea Selatan, dan Singapura</strong> memastikan kargo Anda ditangani dengan prosedur keselamatan dan legalitas yang ketat.</p><h3>Yang Kami Tangani di Negara Asal</h3><ul><li>Koordinasi jadwal muat bersama pabrik/eksportir.</li><li>Pengemasan pengaman <em>strapping</em> dan pengangkutan darat menuju pelabuhan asal.</li><li>Pengurusan dokumen ekspor, kepatuhan pajak negara asal, dan Certificate of Origin.</li><li>Penerbitan polis asuransi kargo laut untuk meminimalkan risiko finansial.</li></ul>',
                'body_en' => '<p>A smooth import shipment begins the moment cargo leaves the overseas factory. Our partner network across <strong>Japan, China, Taiwan, South Korea, and Singapore</strong> handles physical security and export compliance with precision.</p><h3>Origin Handling Scope</h3><ul><li>Factory loading coordination with overseas suppliers.</li><li>Export-standard cargo strapping and inland trucking to the Port of Loading.</li><li>Export clearance, origin tax settlement, and Certificate of Origin processing.</li><li>Marine cargo insurance activation to safeguard cargo value.</li></ul>',
                'icon' => 'shield-check',
                'image_path' => '/images/illustrations/warehouse-export-strapping.jpg',
                'features_id' => ['Pickup gudang pabrik & strapping profesional', 'Dokumen ekspor & pajak negara asal', 'Proteksi asuransi kargo laut terjamin'],
                'features_en' => ['Factory pickup & export-grade strapping', 'Export paperwork & origin tax compliance', 'Comprehensive marine cargo insurance'],
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'slug' => 'customs-clearance-bea-cukai',
                'badge_id' => 'KEPABEANAN',
                'badge_en' => 'CUSTOMS BROKERAGE',
                'title_id' => 'Customs Clearance, Pajak & Bea Cukai Terminal',
                'title_en' => 'Customs Clearance, Duties & Terminal Compliance',
                'short_desc_id' => 'Pengurusan profesional PIB, klasifikasi HS Code, pembayaran bea masuk & pajak impor, serta pengeluaran barang resmi (SPPB) di pelabuhan Indonesia.',
                'short_desc_en' => 'Licensed handling of import declarations (PIB), HS Code advisory, import duty & tax settlement, and swift SPPB customs release at Indonesian terminals.',
                'body_id' => '<p>Proses kepabeanan di terminal pelabuhan membutuhkan akurasi regulasi dan kecepatan respons agar terhindar dari biaya penumpukan (<em>demurrage/detention</em>). Tim kepabeanan CARANO mendampingi penuh mulai dari pemeriksaan dokumen sebelum kapal tiba hingga kontainer keluar terminal.</p><h3>Keunggulan Kepabeanan CARANO</h3><ul><li>Audit kelengkapan dokumen pra-kedatangan (Invoice, Packing List, B/L, Form Fasilitas FTA).</li><li>Pengajuan PIB akurat dan konsultasi HS Code sesuai regulasi terbaru.</li><li>Pengurusan di Terminal Tanjung Priok, Tanjung Emas, dan Tanjung Perak.</li></ul>',
                'body_en' => '<p>Terminal customs clearance requires regulatory accuracy and rapid responsiveness to prevent unnecessary demurrage and detention costs. CARANO’s customs specialists verify paperwork pre-arrival and guide your cargo smoothly through SPPB release.</p><h3>Customs Capabilities</h3><ul><li>Pre-arrival audit of Invoice, Packing List, B/L, and FTA preference certificates.</li><li>Accurate PIB filing and HS Code compliance advisory.</li><li>Dedicated operations at Tanjung Priok, Tanjung Emas, and Tanjung Perak.</li></ul>',
                'icon' => 'file-check',
                'image_path' => '/images/illustrations/port-customs-terminal.jpg',
                'features_id' => ['Verifikasi pra-kedatangan & konsultasi HS Code', 'Pengurusan PIB, Bea Masuk & Pajak Impor', 'Proses cepat hingga terbit SPPB'],
                'features_en' => ['Pre-arrival audit & HS Code advisory', 'PIB filing, import duties & tax handling', 'Streamlined clearance to SPPB release'],
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'slug' => 'stripping-trucking-multimodal',
                'badge_id' => 'MULTIMODAL & LAST-MILE',
                'badge_en' => 'MULTIMODAL & LAST-MILE',
                'title_id' => 'Stripping, Trucking Domestik & Dukungan Air Freight',
                'title_en' => 'Stripping, Domestic Trucking & Air Freight Support',
                'short_desc_id' => 'Pembongkaran kontainer (stripping), distribusi armada truk ke gudang tujuan di seluruh Indonesia, serta opsi kargo udara cepat untuk kebutuhan mendesak.',
                'short_desc_en' => 'Safe container stripping, domestic trucking delivery directly to your warehouse, plus express air freight options for time-critical shipments.',
                'body_id' => '<p>Selaras dengan tiga moda transportasi pada logo <strong>PT. CARANO UTAMA LOGISTIK</strong> (Laut, Darat, dan Udara), kami melengkapi layanan impor laut Anda dengan proses <em>stripping</em> di gudang, pengiriman darat door-to-door, serta layanan <em>Air Freight</em> untuk pengiriman suku cadang atau komoditas berkecepatan tinggi.</p><h3>Dukungan Distribusi & Multimoda</h3><ul><li>Stripping kontainer dengan pengecekan fisik dan daftar inventaris.</li><li>Armada trailer kontainer, wingbox, CDD, hingga engkel menuju lokasi akhir.</li><li>Solusi <strong>Air Freight</strong> prioritas dari bandara hub Asia Timur ke Indonesia.</li></ul>',
                'body_en' => '<p>Reflecting all three logistics modes in the <strong>PT. CARANO UTAMA LOGISTIK</strong> emblem (Sea, Land, and Air), we complement your sea freight with careful warehouse stripping, door-to-door domestic trucking, and priority air freight for urgent industrial shipments.</p><h3>Multimodal & Last-Mile Scope</h3><ul><li>Supervised container stripping with physical tally verification.</li><li>Container trailers, wingbox, and box trucks to final warehouse sites.</li><li>Priority <strong>Air Freight</strong> support from East Asian hubs into Indonesia.</li></ul>',
                'icon' => 'truck',
                'image_path' => '/images/illustrations/hero-port-maritime.jpg',
                'features_id' => ['Stripping terawasi & laporan serah terima', 'Armada trucking domestik door-to-door', 'Opsi Air Freight untuk kargo mendesak'],
                'features_en' => ['Supervised stripping & tally reporting', 'Door-to-door domestic trucking fleet', 'Priority Air Freight for urgent cargo'],
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }

        // 6. Trade Hubs (5 Origin Countries + 3 Indonesian Destination Ports)
        $hubs = [
            ['type' => 'origin', 'code' => 'JP', 'name_id' => 'Jepang', 'name_en' => 'Japan', 'country' => 'Japan', 'description_id' => 'Penjemputan pabrik manufaktur & otomotif area Tokyo, Yokohama, Osaka, dan Kobe dengan dukungan Form IJEPA.', 'description_en' => 'Factory pickup across Tokyo, Yokohama, Osaka, and Kobe industrial zones with IJEPA documentation support.', 'map_x' => 835, 'map_y' => 118, 'sort_order' => 1],
            ['type' => 'origin', 'code' => 'KR', 'name_id' => 'Korea Selatan', 'name_en' => 'South Korea', 'country' => 'South Korea', 'description_id' => 'Akses pelabuhan utama Busan & Incheon untuk pengiriman mesin, komponen elektronik, dan bahan baku industri.', 'description_en' => 'Direct port access via Busan & Incheon for machinery, electronics, and industrial raw materials.', 'map_x' => 718, 'map_y' => 108, 'sort_order' => 2],
            ['type' => 'origin', 'code' => 'CN', 'name_id' => 'China', 'name_en' => 'China', 'country' => 'China', 'description_id' => 'Jaringan luas dari Shanghai, Ningbo, Shenzhen, Guangzhou, hingga Qingdao lengkap dengan fasilitas Form E.', 'description_en' => 'Extensive coverage from Shanghai, Ningbo, Shenzhen, Guangzhou, and Qingdao with Form E compliance.', 'map_x' => 565, 'map_y' => 152, 'sort_order' => 3],
            ['type' => 'origin', 'code' => 'TW', 'name_id' => 'Taiwan', 'name_en' => 'Taiwan', 'country' => 'Taiwan', 'description_id' => 'Koneksi cepat melalui Pelabuhan Kaohsiung & Keelung untuk peralatan presisi, manufaktur, dan suku cadang.', 'description_en' => 'Rapid ocean connections via Kaohsiung & Keelung for precision machinery, manufacturing goods, and parts.', 'map_x' => 650, 'map_y' => 240, 'sort_order' => 4],
            ['type' => 'origin', 'code' => 'SG', 'name_id' => 'Singapura', 'name_en' => 'Singapore', 'country' => 'Singapore', 'description_id' => 'Hub transshipment strategis ASEAN melalui PSA Singapore dengan frekuensi pelayaran tinggi ke Indonesia.', 'description_en' => 'Strategic ASEAN transshipment hub via PSA Singapore with high-frequency sailings into Indonesia.', 'map_x' => 388, 'map_y' => 398, 'sort_order' => 5],

            ['type' => 'destination', 'code' => 'IDJKT', 'name_id' => 'Pelabuhan Tanjung Priok', 'name_en' => 'Port of Tanjung Priok', 'country' => 'Jakarta, Indonesia', 'description_id' => 'Gerbang logistik utama Indonesia untuk melayani kawasan industri Jabodetabek, Karawang, Cikarang, dan Jawa Barat.', 'description_en' => 'Indonesia’s premier maritime gateway serving Greater Jakarta, Cikarang, Karawang, and West Java industrial estates.', 'map_x' => 448, 'map_y' => 495, 'sort_order' => 1],
            ['type' => 'destination', 'code' => 'IDSRG', 'name_id' => 'Pelabuhan Tanjung Emas', 'name_en' => 'Port of Tanjung Emas', 'country' => 'Semarang, Indonesia', 'description_id' => 'Pusat masuk kargo strategis untuk kawasan industri Jawa Tengah, Kendal, Semarang, Solo, dan Yogyakarta.', 'description_en' => 'Strategic cargo gateway for Central Java industrial parks including Semarang, Kendal, Solo, and Yogyakarta.', 'map_x' => 525, 'map_y' => 506, 'sort_order' => 2],
            ['type' => 'destination', 'code' => 'IDSUB', 'name_id' => 'Pelabuhan Tanjung Perak', 'name_en' => 'Port of Tanjung Perak', 'country' => 'Surabaya, Indonesia', 'description_id' => 'Hub maritim utama Jawa Timur & Indonesia Timur yang menghubungkan Surabaya, Gresik, Sidoarjo, dan Pasuruan.', 'description_en' => 'Primary East Java and Eastern Indonesia maritime hub serving Surabaya, Gresik, Sidoarjo, and Pasuruan.', 'map_x' => 596, 'map_y' => 514, 'sort_order' => 3],
        ];

        foreach ($hubs as $hub) {
            TradeHub::updateOrCreate(['code' => $hub['code']], $hub);
        }

        // 7. Starter Insights / Articles (WordPress-like Blog)
        $posts = [
            [
                'slug' => 'panduan-10-tahap-road-map-shipment-impor-laut',
                'title_id' => 'Memahami 10 Tahap Road Map Shipment agar Impor Laut Bebas Biaya Tak Terduga',
                'title_en' => 'Understanding the 10-Step Ocean Import Road Map to Prevent Unexpected Costs',
                'excerpt_id' => 'Pelajari bagaimana alur pengiriman terstruktur dari pabrik di Asia Timur hingga delivery di Indonesia membantu importir menekan risiko demurrage dan keterlambatan.',
                'excerpt_en' => 'Learn how a structured 10-step journey from East Asian factories to Indonesian warehouses helps importers eliminate demurrage and delays.',
                'body_id' => '<p>Dalam aktivitas impor lintas negara, ketidaksinkronan antara jadwal pabrik di negara asal, kesiapan dokumen ekspor, dan proses kepabeanan di pelabuhan tujuan merupakan penyebab utama pembengkakan biaya logistik.</p><h2>Mengapa Pemetaan 10 Tahap Penting?</h2><p>Di <strong>PT. CARANO UTAMA LOGISTIK</strong>, setiap pengiriman mengikuti standar <em>Road Map Shipment</em> yang terbagi dalam tiga fase besar: penanganan di negara asal (tahap 1–4), transportasi laut (tahap 5–6), serta kepabeanan dan pengiriman akhir di Indonesia (tahap 7–10).</p><blockquote>Transparansi dokumen sebelum kapal tiba di Tanjung Priok, Tanjung Emas, atau Tanjung Perak dapat memangkas waktu pengeluaran kontainer secara signifikan.</blockquote><h3>Checklist Kunci Sebelum Kapal Berangkat</h3><ul><li>Pastikan Commercial Invoice dan Packing List sesuai dengan HS Code aktual.</li><li>Aktifkan asuransi kargo laut sejak barang meninggalkan gudang pabrik asal.</li><li>Siapkan Certificate of Origin (Form E / IJEPA / AK) untuk mengoptimalkan tarif bea masuk.</li></ul>',
                'body_en' => '<p>In cross-border import operations, misalignment between overseas factory readiness, export paperwork, and destination customs clearance is the leading cause of unexpected logistics costs.</p><h2>Why a 10-Step Shipment Road Map Matters</h2><p>At <strong>PT. CARANO UTAMA LOGISTIK</strong>, every consignment follows a disciplined 10-step Road Map divided into three clear phases: origin handling (steps 1–4), international ocean transit (steps 5–6), and Indonesian terminal clearance & delivery (steps 7–10).</p><blockquote>Pre-arrival document readiness before vessel arrival at Tanjung Priok, Tanjung Emas, or Tanjung Perak significantly accelerates container release.</blockquote><h3>Key Pre-Departure Checklist</h3><ul><li>Align Commercial Invoice and Packing List descriptions with accurate HS Codes.</li><li>Activate marine cargo insurance prior to origin factory loading.</li><li>Prepare Certificates of Origin (Form E / IJEPA / AK) to optimize import duty rates.</li></ul>',
                'category' => 'Panduan Impor',
                'featured_image' => '/images/illustrations/hero-port-maritime.jpg',
                'meta_title' => 'Panduan 10 Tahap Road Map Shipment Impor Laut | PT. CARANO UTAMA LOGISTIK',
                'meta_description' => 'Pelajari 10 tahap pengiriman impor laut dari pabrik Jepang, China, Taiwan, Korea & Singapura menuju Indonesia.',
                'status' => 'published',
                'published_at' => now()->subDays(12),
                'author_id' => $admin->id,
            ],
            [
                'slug' => 'memilih-pelabuhan-tujuan-tanjung-priok-emas-perak',
                'title_id' => 'Strategi Memilih Pelabuhan Tujuan: Tanjung Priok, Tanjung Emas, atau Tanjung Perak?',
                'title_en' => 'Choosing the Optimal Destination Port: Tanjung Priok, Tanjung Emas, or Tanjung Perak?',
                'excerpt_id' => 'Menentukan pelabuhan bongkar yang paling dekat dengan pabrik atau gudang distribusi dapat menghemat biaya trucking domestik hingga puluhan persen.',
                'excerpt_en' => 'Selecting the discharge port closest to your manufacturing or distribution hub can substantially reduce domestic haulage costs.',
                'body_id' => '<p>Pemilihan pelabuhan tujuan di Pulau Jawa sangat menentukan efisiensi total biaya <em>landed cost</em> perusahaan Anda. Meskipun Tanjung Priok merupakan pelabuhan tersibuk, pengiriman untuk kawasan industri Jawa Tengah atau Jawa Timur sering kali jauh lebih ekonomis melalui Tanjung Emas atau Tanjung Perak.</p><h2>Pertimbangan Utama Memilih Pelabuhan</h2><ul><li><strong>Tanjung Priok (Jakarta):</strong> Ideal untuk distribusi Jabodetabek, Bekasi, Cikarang, Karawang, dan Banten dengan frekuensi kapal direct tertinggi.</li><li><strong>Tanjung Emas (Semarang):</strong> Memangkas jarak trucking darat untuk kawasan industri Kendal, Semarang, Ungaran, dan Solo.</li><li><strong>Tanjung Perak (Surabaya):</strong> Gerbang terbaik untuk Jawa Timur serta distribusi lanjutan menuju Kalimantan, Sulawesi, dan Bali.</li></ul><p>Tim konsultan <strong>PT. CARANO UTAMA LOGISTIK</strong> siap membantu melakukan simulasi rute dan biaya terbaik sebelum Anda menerbitkan Purchase Order kepada supplier luar negeri.</p>',
                'body_en' => '<p>Choosing the right Indonesian port of discharge directly affects your total landed cost. While Tanjung Priok offers the highest sailing frequency, cargo destined for Central or East Java often achieves superior cost efficiency via Tanjung Emas or Tanjung Perak.</p><h2>Key Port Selection Factors</h2><ul><li><strong>Tanjung Priok (Jakarta):</strong> Best for Greater Jakarta, Cikarang, Karawang, and West Java estates with maximum direct vessel frequency.</li><li><strong>Tanjung Emas (Semarang):</strong> Minimizes inland trucking distance for Kendal, Semarang, and Central Java factories.</li><li><strong>Tanjung Perak (Surabaya):</strong> Premier gateway for East Java and onward distribution to Eastern Indonesia.</li></ul><p>Consult with <strong>PT. CARANO UTAMA LOGISTIK</strong> to compare door-to-door landed costs before finalizing supplier shipping instructions.</p>',
                'category' => 'Strategi Rute',
                'featured_image' => '/images/illustrations/port-customs-terminal.jpg',
                'meta_title' => 'Memilih Pelabuhan Tanjung Priok, Tanjung Emas & Tanjung Perak',
                'meta_description' => 'Perbandingan efisiensi pelabuhan Tanjung Priok, Tanjung Emas, dan Tanjung Perak untuk impor laut Indonesia.',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'author_id' => $admin->id,
            ],
            [
                'slug' => 'pentingnya-strapping-dan-asuransi-kargo-impor',
                'title_id' => 'Mengapa Strapping di Pabrik Asal & Asuransi Kargo Tidak Boleh Diabaikan',
                'title_en' => 'Why Origin Factory Strapping & Marine Cargo Insurance Are Essential',
                'excerpt_id' => 'Perjalanan laut internasional menghadapi getaran, kelembapan, dan proses bongkar muat berkali-kali. Begini cara melindungi investasi kargo Anda.',
                'excerpt_en' => 'International sea voyages involve vibration, humidity, and multiple crane transfers. Here is how to protect your cargo investment.',
                'body_id' => '<p>Selama perjalanan laut dari Jepang, China, Taiwan, Korea, atau Singapura menuju Indonesia, kontainer mengalami beberapa kali pemindahan mekanis mulai dari truk pabrik, crane pelabuhan muat, tumpukan kapal, hingga proses <em>discharge</em> dan <em>stripping</em> di terminal tujuan.</p><h2>Perlindungan Fisik & Finansial</h2><p>Itulah mengapa tahap <strong>Strapping & Trucking</strong> serta <strong>Asuransi Kargo</strong> menjadi bagian tak terpisahkan dari Road Map Shipment PT. CARANO UTAMA LOGISTIK. Strapping yang tepat mencegah pergeseran palet di dalam kontainer, sementara asuransi memberikan ketenangan finansial terhadap risiko tak terduga selama transit maritim.</p>',
                'body_en' => '<p>During ocean transit from Japan, China, Taiwan, Korea, or Singapore to Indonesia, containers undergo multiple mechanical handlings from origin trucks and port cranes to vessel stacking and destination stripping.</p><h2>Physical & Financial Protection</h2><p>That is why export-grade <strong>Strapping & Trucking</strong> and <strong>Marine Cargo Insurance</strong> are built into PT. CARANO UTAMA LOGISTIK’s core Shipment Road Map—preventing cargo shift while safeguarding financial value throughout maritime transit.</p>',
                'category' => 'Keamanan Kargo',
                'featured_image' => '/images/illustrations/warehouse-export-strapping.jpg',
                'meta_title' => 'Pentingnya Strapping & Asuransi Kargo Laut Impor',
                'meta_description' => 'Standar pengamanan strapping di pabrik asal dan proteksi asuransi untuk pengiriman laut internasional.',
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'author_id' => $admin->id,
            ],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(['slug' => $post['slug']], $post);
        }

        // 8. FAQs
        $faqs = [
            [
                'question_id' => 'Negara asal mana saja yang menjadi cakupan utama pengiriman CARANO?',
                'question_en' => 'Which origin countries are covered by CARANO’s main import corridors?',
                'answer_id' => 'Cakupan koridor utama kami meliputi penjemputan langsung dari gudang pabrik di Jepang, China, Taiwan, Korea Selatan, dan Singapura menuju Indonesia.',
                'answer_en' => 'Our primary corridors cover direct factory pickup across Japan, China, Taiwan, South Korea, and Singapore into Indonesia.',
                'category' => 'Rute & Cakupan',
                'sort_order' => 1,
            ],
            [
                'question_id' => 'Pelabuhan tujuan mana saja yang dilayani di Indonesia?',
                'question_en' => 'Which Indonesian destination ports do you serve?',
                'answer_id' => 'Kami melayani bongkar muat dan kepabeanan di tiga pelabuhan utama Indonesia: Pelabuhan Tanjung Priok (Jakarta), Tanjung Emas (Semarang), dan Tanjung Perak (Surabaya), dilanjutkan pengiriman darat ke lokasi tujuan Anda.',
                'answer_en' => 'We handle port discharge and customs clearance across Indonesia’s three major ports: Tanjung Priok (Jakarta), Tanjung Emas (Semarang), and Tanjung Perak (Surabaya), followed by domestic delivery to your destination.',
                'category' => 'Rute & Cakupan',
                'sort_order' => 2,
            ],
            [
                'question_id' => 'Apakah PT. CARANO UTAMA LOGISTIK mengurus dokumen ekspor, pajak, dan Bea Cukai sekaligus?',
                'question_en' => 'Does PT. CARANO UTAMA LOGISTIK handle export docs, taxes, and Indonesian customs clearance end-to-end?',
                'answer_id' => 'Ya. Kami menyediakan layanan end-to-end mulai dari pengurusan dokumen & pajak negara asal, asuransi kargo laut, hingga penyelesaian dokumen, pajak impor, dan Bea Cukai di terminal tujuan.',
                'answer_en' => 'Yes. Our end-to-end service includes origin export documentation, origin taxes, marine cargo insurance, as well as import documentation, duties, and terminal customs clearance in Indonesia.',
                'category' => 'Dokumen & Bea Cukai',
                'sort_order' => 3,
            ],
            [
                'question_id' => 'Apakah saya bisa mengirim kargo di bawah 1 kontainer penuh (LCL)?',
                'question_en' => 'Can we ship volumes smaller than a full container (LCL)?',
                'answer_id' => 'Tentu. Selain FCL (Full Container Load 20ft/40ft), kami juga melayani pengiriman LCL dengan proses konsolidasi, stripping aman, dan trucking langsung ke alamat tujuan Anda.',
                'answer_en' => 'Certainly. Alongside FCL (20ft/40ft containers), we handle LCL consolidation complete with supervised stripping and door-to-door trucking delivery.',
                'category' => 'Layanan',
                'sort_order' => 4,
            ],
            [
                'question_id' => 'Apakah tersedia layanan pengiriman darat dan udara selain pengiriman laut?',
                'question_en' => 'Do you also provide domestic trucking and air freight support alongside sea freight?',
                'answer_id' => 'Ya. Kami mendukung pengiriman multimoda: armada trucking untuk strapping/pickup negara asal maupun stripping/delivery domestik di Indonesia, serta opsi Air Freight untuk kebutuhan kargo mendesak.',
                'answer_en' => 'Yes. We provide multimodal solutions combining origin & domestic trucking, container stripping, and priority air freight support for urgent shipments.',
                'category' => 'Layanan',
                'sort_order' => 5,
            ],
            [
                'question_id' => 'Bagaimana cara meminta estimasi biaya (quotation) pengiriman?',
                'question_en' => 'How do I request a shipping quotation?',
                'answer_id' => 'Anda cukup mengisi formulir Konsultasi / Minta Penawaran pada halaman Kontak dengan mencantumkan negara asal, pelabuhan tujuan, dan estimasi jenis/volume barang. Tim kami akan merespons cepat melalui email atau WhatsApp.',
                'answer_en' => 'Simply complete the Request a Quote form on our Contact page with your origin country, destination port, and cargo details. Our team will promptly follow up via email or WhatsApp.',
                'category' => 'Penawaran',
                'sort_order' => 6,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(['question_id' => $faq['question_id']], $faq);
        }

        // 9. Seed Media Library with Brand Assets, Maritime Illustrations & Official PDF
        $mediaAssets = [
            ['filename' => 'logo-carano-mark.png', 'original_name' => 'Logo Carano Baru (Emblem).png', 'file_path' => '/images/brand/logo-carano-mark.png', 'mime_type' => 'image/png', 'alt_text' => 'Emblem Resmi PT. CARANO UTAMA LOGISTIK'],
            ['filename' => 'logo-carano-light.png', 'original_name' => 'Logo Carano Baru (Seal Light).png', 'file_path' => '/images/brand/logo-carano-light.png', 'mime_type' => 'image/png', 'alt_text' => 'Logo Resmi PT. CARANO UTAMA LOGISTIK (Light)'],
            ['filename' => 'logo-carano-dark.png', 'original_name' => 'Logo Carano Baru (Seal Dark).png', 'file_path' => '/images/brand/logo-carano-dark.png', 'mime_type' => 'image/png', 'alt_text' => 'Logo Resmi PT. CARANO UTAMA LOGISTIK (Dark)'],
            ['filename' => 'hero-port-maritime.jpg', 'original_name' => 'Ilustrasi Pelabuhan & Kapal Kontainer.jpg', 'file_path' => '/images/illustrations/hero-port-maritime.jpg', 'mime_type' => 'image/jpeg', 'alt_text' => 'Terminal Pelabuhan Kontainer Internasional'],
            ['filename' => 'sea-freight-vessel.jpg', 'original_name' => 'Ilustrasi Sea Freight Kapal Laut.jpg', 'file_path' => '/images/illustrations/sea-freight-vessel.jpg', 'mime_type' => 'image/jpeg', 'alt_text' => 'Kapal Kontainer Sea Freight'],
            ['filename' => 'port-customs-terminal.jpg', 'original_name' => 'Ilustrasi Terminal Bea Cukai & Trucking.jpg', 'file_path' => '/images/illustrations/port-customs-terminal.jpg', 'mime_type' => 'image/jpeg', 'alt_text' => 'Terminal Kontainer dan Armada Trucking'],
            ['filename' => 'warehouse-export-strapping.jpg', 'original_name' => 'Ilustrasi Gudang Pabrik & Strapping.jpg', 'file_path' => '/images/illustrations/warehouse-export-strapping.jpg', 'mime_type' => 'image/jpeg', 'alt_text' => 'Gudang Ekspor dan Pengemasan Strapping'],
            ['filename' => 'CARANO_Road_Map_Shipment.pdf', 'original_name' => 'CARANO_Road Map Shipment.pdf', 'file_path' => '/uploads/docs/CARANO_Road_Map_Shipment.pdf', 'mime_type' => 'application/pdf', 'alt_text' => 'Dokumen Road Map Shipment PT. CARANO UTAMA LOGISTIK'],
        ];

        foreach ($mediaAssets as $asset) {
            $fullPath = public_path(ltrim($asset['file_path'], '/'));
            MediaFile::updateOrCreate(
                ['file_path' => $asset['file_path']],
                [
                    ...$asset,
                    'file_size' => file_exists($fullPath) ? filesize($fullPath) : 0,
                    'uploaded_by' => $admin->id,
                ]
            );
        }

        // 10. Sample Inquiry so Admin Dashboard looks immediately informative
        if (Inquiry::count() === 0) {
            Inquiry::create([
                'company_name' => 'PT. Nusantara Precision Manufacturing',
                'contact_name' => 'Budi Santoso',
                'email' => 'procurement@nusantaraprecision.co.id',
                'phone' => '081298765432',
                'origin_country' => 'Jepang',
                'destination_port' => 'Pelabuhan Tanjung Priok',
                'service_type' => 'Sea Freight Impor (FCL & LCL)',
                'cargo_details' => 'Estimasi 1x20ft FCL komponen mesin industri dari Osaka menuju kawasan industri Cikarang. Mohon penawaran all-in termasuk asuransi dan bea cukai.',
                'status' => 'new',
            ]);
        }
    }
}
