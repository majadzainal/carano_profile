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
            ['key' => 'company_tagline', 'group' => 'brand', 'label' => 'Tagline Perusahaan', 'value_id' => 'Mitra Logistik Ekspor & Impor End-to-End Indonesia – Asia & Global', 'value_en' => 'End-to-End Export & Import Logistics Partner Indonesia – Asia & Global', 'type' => 'text', 'sort_order' => 3],
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

            ['key' => 'seo_default_title', 'group' => 'seo', 'label' => 'Default SEO Title', 'value_id' => 'PT. CARANO UTAMA LOGISTIK — Solusi Logistik Ekspor & Impor End-to-End', 'value_en' => 'PT. CARANO UTAMA LOGISTIK — End-to-End International Export & Import Logistics', 'type' => 'text', 'sort_order' => 30],
            ['key' => 'seo_default_description', 'group' => 'seo', 'label' => 'Default SEO Description', 'value_id' => 'Layanan logistik ekspor dan impor terintegrasi (Sea Freight, Air Freight, Bea Cukai PEB/PIB, Strapping, Stuffing & Trucking) menghubungkan Tanjung Priok, Tanjung Emas & Tanjung Perak dengan Jepang, China, Taiwan, Korea, Singapura & global.', 'value_en' => 'Integrated export and import logistics (Sea Freight, Air Freight, PEB/PIB Customs Clearance, Strapping, Stuffing & Trucking) connecting Tanjung Priok, Tanjung Emas & Tanjung Perak with Japan, China, Taiwan, Korea, Singapore & worldwide.', 'type' => 'textarea', 'sort_order' => 31],
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
                'badge_id' => 'INTEGRATED EXPORT & IMPORT LOGISTICS',
                'badge_en' => 'INTEGRATED EXPORT & IMPORT LOGISTICS',
                'title_id' => 'Mengoptimalkan Alur Pengiriman Ekspor & Impor dari Pabrik hingga Pintu Tujuan.',
                'title_en' => 'Optimizing End-to-End Export & Import Shipments from Factory to Final Destination.',
                'subtitle_id' => 'PT. CARANO UTAMA LOGISTIK menangani seluruh rantai pasok ekspor dan impor dua arah—mulai dari strapping, stuffing & trucking, kepabeanan PEB/PIB & pajak, perjalanan laut & udara, hingga delivery ke Jepang, China, Taiwan, Korea, Singapura, dan seluruh Indonesia.',
                'subtitle_en' => 'PT. CARANO UTAMA LOGISTIK manages two-way export and import supply chains—from strapping, stuffing & trucking, PEB/PIB customs & duties, ocean & air freight, to final delivery connecting Indonesia with Japan, China, Taiwan, Korea, Singapore, and global markets.',
                'cta_label_id' => 'Konsultasi Ekspor / Impor',
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
                'title_id' => 'Jaringan Koridor Ekspor & Impor Terukur',
                'title_en' => 'Measurable & Reliable Export-Import Corridor Network',
                'extra_json' => [
                    'items' => [
                        ['value' => '5', 'unit_id' => 'Hub Utama Asia', 'unit_en' => 'Key Asian Hubs', 'desc_id' => 'Koridor ekspor & impor Jepang, China, Taiwan, Korea & Singapura', 'desc_en' => 'Two-way export & import across Japan, China, Taiwan, Korea & Singapore'],
                        ['value' => '3', 'unit_id' => 'Pelabuhan Utama RI', 'unit_en' => 'Major Indonesian Ports', 'desc_id' => 'Tanjung Priok, Tanjung Emas & Tanjung Perak', 'desc_en' => 'Tanjung Priok, Tanjung Emas & Tanjung Perak'],
                        ['value' => '10', 'unit_id' => 'Tahap Terkontrol', 'unit_en' => 'Controlled Stages', 'desc_id' => 'Road Map Shipment transparan dari hulu ke hilir', 'desc_en' => 'Transparent end-to-end Shipment Road Map'],
                        ['value' => '3', 'unit_id' => 'Moda Terpadu', 'unit_en' => 'Integrated Modes', 'desc_id' => 'Laut (Sea), Darat (Trucking) & Udara (Air)', 'desc_en' => 'Sea Freight, Inland Trucking & Air Freight'],
                    ],
                ],
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'page_slug' => 'home',
                'section_key' => 'home_challenge',
                'section_label' => 'Homepage — Tantangan & Solusi Ekspor-Impor',
                'badge_id' => 'MENGAPA SISTEM TERINTEGRASI PENTING',
                'badge_en' => 'WHY INTEGRATED LOGISTICS MATTERS',
                'title_id' => 'Menghilangkan Hambatan Klasik dalam Rantai Ekspor & Impor Lintas Negara.',
                'title_en' => 'Eliminating Classic Bottlenecks in Cross-Border Export & Import Chains.',
                'subtitle_id' => 'Koordinasi terpisah antara agen luar negeri, pelayaran, kepabeanan PEB/PIB, dan trucking lokal sering memicu biaya demurrage serta keterlambatan. CARANO menyatukan seluruh proses ekspor & impor dalam satu kendali.',
                'subtitle_en' => 'Fragmented coordination across overseas agents, ocean carriers, PEB/PIB customs brokers, and local haulers triggers demurrage and delays. CARANO unifies export and import workflows under one accountable team.',
                'extra_json' => [
                    'cards' => [
                        [
                            'tag_id' => 'Dokumen PEB / PIB & Pajak',
                            'tag_en' => 'PEB / PIB Docs & Taxes',
                            'problem_id' => 'Kesalahan HS Code, dokumen ekspor (PEB/SKA) atau impor (PIB), maupun asuransi memicu penahanan kargo.',
                            'problem_en' => 'Mismatched HS Codes, export (PEB/COO) or import (PIB) paperwork, or incomplete insurance trigger cargo holds.',
                            'solution_id' => 'Tim CARANO memverifikasi dokumen PEB/PIB, Certificate of Origin (Form E/IJEPA/AK), pajak, asuransi, dan Bea Cukai.',
                            'solution_en' => 'CARANO verifies PEB/PIB declarations, Certificates of Origin (Form E/IJEPA/AK), duties, cargo insurance, and customs.',
                        ],
                        [
                            'tag_id' => 'Jadwal Kapal & Antrean Pelabuhan',
                            'tag_en' => 'Vessel Cutoff & Port Queue',
                            'problem_id' => 'Tertinggal jadwal closing ekspor atau kurangnya visibilitas antrean sandar menghambat target pengiriman.',
                            'problem_en' => 'Missed export closing times or poor berthing queue visibility disrupt production and buyer schedules.',
                            'solution_id' => 'Booking space kapal terjamin & monitoring proaktif di Tanjung Priok, Tanjung Emas, Tanjung Perak, hingga pelabuhan mitra.',
                            'solution_en' => 'Secured vessel space and proactive monitoring across Tanjung Priok, Tanjung Emas, Tanjung Perak, and partner ports.',
                        ],
                        [
                            'tag_id' => 'Stuffing, Strapping & Last-Mile',
                            'tag_en' => 'Stuffing, Strapping & Delivery',
                            'problem_id' => 'Risiko kerusakan barang saat stuffing/stripping kontainer serta keterlambatan armada trucking darat.',
                            'problem_en' => 'Cargo damage risks during container stuffing/stripping and unreliable inland delivery fleets.',
                            'solution_id' => 'Standar strapping & stuffing ketat di pabrik ekspor/impor serta stripping, trucking, dan delivery tepat waktu.',
                            'solution_en' => 'Strict strapping & stuffing standards paired with disciplined stripping, trucking, and on-time door delivery.',
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
                'badge_id' => 'SOLUSI EKSPOR & IMPOR',
                'badge_en' => 'EXPORT & IMPORT SOLUTIONS',
                'title_id' => 'Layanan Logistik Ekspor & Impor Modular Sesuai Skala Bisnis Anda.',
                'title_en' => 'Modular Export & Import Logistics Solutions Tailored to Your Business.',
                'subtitle_id' => 'Melayani pengiriman kontainer penuh (FCL), konsolidasi (LCL), pengurusan kepabeanan Ekspor (PEB) & Impor (PIB), stuffing/stripping, hingga pengiriman udara (Air Freight).',
                'subtitle_en' => 'Covering Full Container Load (FCL), consolidation (LCL), Export (PEB) & Import (PIB) customs brokerage, stuffing/stripping, and priority Air Freight.',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'page_slug' => 'home',
                'section_key' => 'home_network_intro',
                'section_label' => 'Homepage — Intro Jaringan Rute',
                'badge_id' => 'JARINGAN RUTE DUA ARAH',
                'badge_en' => 'TWO-WAY CORRIDOR NETWORK',
                'title_id' => 'Menghubungkan 3 Gerbang Maritim Indonesia dengan 5 Pusat Industri Asia.',
                'title_en' => 'Connecting 3 Indonesian Maritime Gateways with 5 Asian Industrial Hubs.',
                'subtitle_id' => 'Dukungan jalur pelayaran Ekspor & Impor aktif antara Tanjung Priok, Tanjung Emas, dan Tanjung Perak dengan Jepang, China, Taiwan, Korea Selatan, dan Singapura.',
                'subtitle_en' => 'Active two-way Export & Import corridors linking Tanjung Priok, Tanjung Emas, and Tanjung Perak with Japan, China, Taiwan, South Korea, and Singapore.',
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
                'badge_id' => 'SIAP EKSPOR ATAU IMPOR BERSAMA CARANO?',
                'badge_en' => 'READY TO EXPORT OR IMPORT WITH CARANO?',
                'title_id' => 'Diskusikan Kebutuhan Ekspor & Impor Anda untuk Estimasi Rute Terbaik.',
                'title_en' => 'Discuss Your Export & Import Plan for a Tailored Route Estimate.',
                'subtitle_id' => 'Tim konsultan logistik PT. CARANO UTAMA LOGISTIK siap membantu menghitung estimasi waktu, dokumen PEB/PIB, dan penawaran transparan untuk koridor Indonesia ⇄ Asia & Global.',
                'subtitle_en' => 'Our logistics specialists at PT. CARANO UTAMA LOGISTIK are ready to assist with lead times, PEB/PIB documentation, and transparent quotations across Indonesia ⇄ Asia & global routes.',
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
                'title_id' => 'Menjembatani Perdagangan Ekspor & Impor Global dengan Amanah, Presisi, dan Integrasi Multimoda.',
                'title_en' => 'Bridging Global Export & Import Trade with Trust, Precision, and Multimodal Integration.',
                'subtitle_id' => 'PT. CARANO UTAMA LOGISTIK adalah perusahaan International Freight Forwarder yang melayani pengiriman Ekspor dan Impor dua arah pada koridor industri Asia Timur, Asia Tenggara, dan pasar global.',
                'subtitle_en' => 'PT. CARANO UTAMA LOGISTIK is an International Freight Forwarder providing two-way Export and Import logistics across East Asia, Southeast Asia, and global trade corridors.',
                'body_id' => '<p>Berlandaskan filosofi <strong>Carano</strong>—simbol penghormatan dan ketulusan pelayanan dalam budaya Nusantara—kami hadir membawa standar baru dalam pengelolaan logistik <strong>ekspor dan impor internasional</strong>. Logo kami memadukan wadah Carano yang menopang bola dunia serta tiga moda transportasi utama: <strong>Laut, Darat, dan Udara</strong>.</p><p>Menghubungkan pelabuhan utama Indonesia (<strong>Tanjung Priok, Tanjung Emas, dan Tanjung Perak</strong>) dengan jaringan pabrik dan pelabuhan di <strong>Jepang, China, Taiwan, Korea Selatan, Singapura, serta destinasi global</strong>, kami memastikan setiap tahapan—mulai dari strapping, stuffing/stripping, dokumen PEB/PIB, asuransi, kepabeanan terminal, hingga pengiriman darat—berjalan terukur dan bebas hambatan.</p>',
                'body_en' => '<p>Rooted in the philosophy of the <strong>Carano</strong>—a traditional emblem of honor and sincere stewardship—we deliver a modern standard in international <strong>export and import logistics</strong>. Our emblem unites the Carano supporting the globe alongside three integrated transport modes: <strong>Sea, Land, and Air</strong>.</p><p>Connecting Indonesia’s main maritime gateways (<strong>Tanjung Priok, Tanjung Emas, and Tanjung Perak</strong>) with partner factories and ports across <strong>Japan, China, Taiwan, South Korea, Singapore, and global markets</strong>, we ensure every milestone—from strapping, stuffing/stripping, PEB/PIB declarations, insurance, terminal customs clearance, to final trucking—operates smoothly and transparently.</p>',
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

        // 5. Modular Services (Export + Import Full Suite)
        $services = [
            [
                'slug' => 'sea-freight-import',
                'badge_id' => 'LAYANAN IMPOR',
                'badge_en' => 'IMPORT FREIGHT',
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
                'slug' => 'sea-air-freight-export',
                'badge_id' => 'LAYANAN EKSPOR',
                'badge_en' => 'EXPORT FREIGHT',
                'title_id' => 'Sea & Air Freight Ekspor (FCL, LCL & Global)',
                'title_en' => 'International Sea & Air Freight Export (FCL, LCL & Global)',
                'short_desc_id' => 'Pengiriman komoditas ekspor dari pabrik dan gudang Indonesia melalui Tanjung Priok, Tanjung Emas, dan Tanjung Perak menuju Jepang, China, Taiwan, Korea, Singapura, & pasar global.',
                'short_desc_en' => 'Export cargo shipping from Indonesian factories and warehouses via Tanjung Priok, Tanjung Emas, and Tanjung Perak to Japan, China, Taiwan, Korea, Singapore, and worldwide destinations.',
                'body_id' => '<p>Layanan <strong>Ekspor Internasional</strong> PT. CARANO UTAMA LOGISTIK membantu produsen, manufaktur, dan eksportir Indonesia menembus pasar Asia maupun global dengan jadwal kapal yang pasti serta kepatuhan dokumen ekspor yang lengkap.</p><h3>Cakupan Layanan Ekspor</h3><ul><li>Penjemputan dan <strong>Stuffing kontainer (FCL 20ft/40ft/HQ & LCL)</strong> langsung di pabrik atau gudang Indonesia.</li><li>Pengurusan lengkap <strong>PEB (Pemberitahuan Ekspor Barang)</strong>, NPE, Bill of Lading (B/L), dan <strong>SKA / Certificate of Origin (COO)</strong>.</li><li>Koordinasi fumigasi, karantina, sertifikat kesehatan/phytosanitary, serta asuransi kargo ekspor.</li><li>Opsi <strong>Air Freight Ekspor</strong> untuk pengiriman komoditas cepat dan bernilai tinggi.</li></ul>',
                'body_en' => '<p>PT. CARANO UTAMA LOGISTIK’s <strong>International Export</strong> service empowers Indonesian manufacturers and exporters to reach Asian and worldwide buyers with dependable sailing schedules and complete export compliance.</p><h3>Export Service Scope</h3><ul><li>Factory pickup and <strong>container stuffing (FCL 20ft/40ft/HQ & LCL)</strong> across Indonesia.</li><li>End-to-end processing of <strong>Export Declarations (PEB)</strong>, NPE, Bill of Lading (B/L), and <strong>Certificate of Origin (COO/SKA)</strong>.</li><li>Coordination of fumigation, quarantine/phytosanitary certificates, and marine cargo insurance.</li><li>Priority <strong>Export Air Freight</strong> options for urgent and high-value shipments.</li></ul>',
                'icon' => 'globe',
                'image_path' => '/images/illustrations/hero-port-maritime.jpg',
                'features_id' => ['Stuffing FCL/LCL & booking kapal dari 3 pelabuhan utama RI', 'Pengurusan PEB, NPE, B/L, & SKA / Certificate of Origin', 'Dukungan fumigasi, asuransi, & Air Freight Ekspor'],
                'features_en' => ['FCL/LCL stuffing & carrier booking from 3 main Indonesian ports', 'PEB, NPE, B/L & Certificate of Origin (COO) processing', 'Fumigation, cargo insurance & Export Air Freight support'],
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'slug' => 'origin-handling-insurance',
                'badge_id' => 'HANDLING & ASURANSI',
                'badge_en' => 'CARGO HANDLING & INSURANCE',
                'title_id' => 'Strapping, Stuffing, Dokumen & Asuransi Kargo',
                'title_en' => 'Strapping, Stuffing, Export Docs & Cargo Insurance',
                'short_desc_id' => 'Pengamanan fisik strapping/stuffing di gudang pabrik (baik untuk ekspor dari Indonesia maupun impor dari luar negeri), pengurusan dokumen, pajak, hingga polis asuransi kargo.',
                'short_desc_en' => 'Export-grade cargo strapping and stuffing at origin factories (both outbound from Indonesia and inbound from abroad), export paperwork, taxes, and full marine cargo insurance.',
                'body_id' => '<p>Keberhasilan pengiriman lintas negara dimulai sejak barang meninggalkan gudang pabrik. Tim lapangan kami di Indonesia dan jaringan mitra di <strong>Jepang, China, Taiwan, Korea Selatan, dan Singapura</strong> memastikan standar keamanan fisik serta legalitas ekspor-impor terpenuhi sepenuhnya.</p><h3>Yang Kami Tangani</h3><ul><li>Koordinasi jadwal muat bersama pabrik/eksportir dan supplier luar negeri.</li><li>Pengemasan pengaman <em>strapping</em>, lashing, dan <em>stuffing</em> kontainer sesuai standar ekspor internasional.</li><li>Pengurusan dokumen ekspor, pajak negara asal, serta Certificate of Origin.</li><li>Penerbitan polis asuransi kargo laut & udara untuk meminimalkan risiko finansial.</li></ul>',
                'body_en' => '<p>A smooth cross-border shipment starts the moment cargo leaves the factory floor. Our Indonesian ground teams and partner network across <strong>Japan, China, Taiwan, South Korea, and Singapore</strong> execute physical securing and trade compliance with precision.</p><h3>Handling Scope</h3><ul><li>Factory loading coordination for both Indonesian exporters and overseas suppliers.</li><li>Export-standard cargo strapping, lashing, and container stuffing.</li><li>Export clearance, origin tax settlement, and Certificate of Origin processing.</li><li>Marine & air cargo insurance activation to safeguard shipment value.</li></ul>',
                'icon' => 'shield-check',
                'image_path' => '/images/illustrations/warehouse-export-strapping.jpg',
                'features_id' => ['Strapping, lashing & stuffing standar ekspor-impor', 'Verifikasi dokumen perdagangan & pajak negara asal', 'Proteksi asuransi kargo laut & udara terjamin'],
                'features_en' => ['Export-import grade strapping, lashing & stuffing', 'Trade documentation & origin tax compliance', 'Comprehensive marine & air cargo insurance'],
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'slug' => 'customs-clearance-bea-cukai',
                'badge_id' => 'KEPABEANAN PEB & PIB',
                'badge_en' => 'CUSTOMS BROKERAGE (PEB & PIB)',
                'title_id' => 'Customs Clearance Ekspor (PEB) & Impor (PIB)',
                'title_en' => 'Export (PEB) & Import (PIB) Customs Clearance',
                'short_desc_id' => 'Pengurusan profesional kepabeanan Ekspor (PEB/NPE) dan Impor (PIB/SPPB), klasifikasi HS Code, pajak & bea cukai di terminal Tanjung Priok, Tanjung Emas, dan Tanjung Perak.',
                'short_desc_en' => 'Licensed Export (PEB/NPE) and Import (PIB/SPPB) customs declarations, HS Code advisory, duties & tax handling across Tanjung Priok, Tanjung Emas, and Tanjung Perak.',
                'body_id' => '<p>Proses kepabeanan ekspor maupun impor di terminal pelabuhan membutuhkan akurasi regulasi dan kecepatan respons agar terhindar dari biaya penumpukan (<em>demurrage/detention</em>) atau keterlambatan <em>closing</em> kapal. Tim kepabeanan CARANO mendampingi penuh mulai dari audit dokumen hingga terbitnya NPE (ekspor) atau SPPB (impor).</p><h3>Keunggulan Kepabeanan CARANO</h3><ul><li>Pengajuan <strong>PEB (Pemberitahuan Ekspor Barang)</strong> & NPE tepat waktu sebelum jadwal <em>closing</em> pelabuhan.</li><li>Pengajuan <strong>PIB (Pemberitahuan Impor Barang)</strong>, audit pra-kedatangan, dan konsultasi HS Code serta fasilitas FTA.</li><li>Tim operasional langsung di Terminal Tanjung Priok, Tanjung Emas, dan Tanjung Perak.</li></ul>',
                'body_en' => '<p>Export and import terminal customs clearance demand regulatory accuracy and rapid execution to prevent demurrage costs or missed vessel cutoffs. CARANO’s licensed customs team guides every shipment from document audit to NPE (export) or SPPB (import) release.</p><h3>Customs Capabilities</h3><ul><li>Timely <strong>Export Declaration (PEB)</strong> & NPE approval prior to port closing.</li><li>Pre-arrival audit, accurate <strong>Import Declaration (PIB)</strong> filing, HS Code & FTA advisory.</li><li>Dedicated operations at Tanjung Priok, Tanjung Emas, and Tanjung Perak.</li></ul>',
                'icon' => 'file-check',
                'image_path' => '/images/illustrations/port-customs-terminal.jpg',
                'features_id' => ['Kepabeanan Ekspor (PEB, NPE, SKA/COO)', 'Kepabeanan Impor (PIB, Bea Masuk, Pajak, SPPB)', 'Layanan langsung di 3 pelabuhan utama Indonesia'],
                'features_en' => ['Export Customs (PEB, NPE, COO/SKA)', 'Import Customs (PIB, Duties, Taxes, SPPB)', 'On-ground teams at 3 major Indonesian ports'],
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'slug' => 'stripping-trucking-multimodal',
                'badge_id' => 'MULTIMODAL & LAST-MILE',
                'badge_en' => 'MULTIMODAL & LAST-MILE',
                'title_id' => 'Stripping, Trucking Domestik & Dukungan Air Freight',
                'title_en' => 'Stripping, Domestic Trucking & Air Freight Support',
                'short_desc_id' => 'Pembongkaran kontainer (stripping), trucking penjemputan ekspor & distribusi impor door-to-door di seluruh Indonesia, serta opsi kargo udara (Air Freight) cepat.',
                'short_desc_en' => 'Supervised container stripping, domestic trucking for outbound export pickup & inbound import delivery, plus express Air Freight for time-critical shipments.',
                'body_id' => '<p>Selaras dengan tiga moda transportasi pada logo <strong>PT. CARANO UTAMA LOGISTIK</strong> (Laut, Darat, dan Udara), kami melengkapi layanan ekspor dan impor laut Anda dengan armada trucking domestik door-to-door, fasilitas <em>stripping/stuffing</em>, serta layanan <em>Air Freight</em> untuk pengiriman berkecepatan tinggi.</p><h3>Dukungan Distribusi & Multimoda</h3><ul><li>Armada trailer kontainer, wingbox, CDD, dan engkel untuk penjemputan ekspor maupun pengiriman impor ke gudang klien.</li><li>Stripping & stuffing kontainer terawasi dengan daftar inventaris lengkap.</li><li>Solusi <strong>Air Freight Ekspor & Impor</strong> melalui bandara hub internasional.</li></ul>',
                'body_en' => '<p>Reflecting all three logistics modes in the <strong>PT. CARANO UTAMA LOGISTIK</strong> emblem (Sea, Land, and Air), we complement ocean shipments with door-to-door domestic trucking, supervised stripping/stuffing, and priority export/import air freight.</p><h3>Multimodal & Last-Mile Scope</h3><ul><li>Container trailers, wingbox, and box trucks for export pickup and import warehouse delivery.</li><li>Supervised container stripping & stuffing with verified tally sheets.</li><li>Priority <strong>Export & Import Air Freight</strong> via international hub airports.</li></ul>',
                'icon' => 'truck',
                'image_path' => '/images/illustrations/port-customs-terminal.jpg',
                'features_id' => ['Trucking penjemputan ekspor & delivery impor door-to-door', 'Stripping & stuffing terawasi dengan laporan serah terima', 'Opsi Air Freight Ekspor & Impor untuk kargo mendesak'],
                'features_en' => ['Domestic trucking for export pickup & import door delivery', 'Supervised stripping & stuffing with verified POD', 'Priority Export & Import Air Freight options'],
                'sort_order' => 5,
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
            [
                'slug' => 'panduan-ekspor-indonesia-peb-ska-dan-stuffing-kontainer',
                'title_id' => 'Panduan Lengkap Ekspor dari Indonesia: Dokumen PEB, SKA/COO & Standar Stuffing Kontainer',
                'title_en' => 'Complete Guide to Exporting from Indonesia: PEB, COO/SKA & Container Stuffing Standards',
                'excerpt_id' => 'Ingin mengirim produk manufaktur atau komoditas Indonesia ke Jepang, China, Korea, Singapura, atau pasar global? Simak alur ekspor yang aman dan tepat waktu.',
                'excerpt_en' => 'Planning to ship Indonesian manufactured goods or commodities to Japan, China, Korea, Singapore, or global markets? Follow this proven export checklist.',
                'body_id' => '<p>Menembus pasar ekspor menuntut kesiapan dokumen yang akurat dan ketepatan jadwal <em>closing</em> kapal di pelabuhan muat seperti <strong>Tanjung Priok, Tanjung Emas, dan Tanjung Perak</strong>. Keterlambatan satu dokumen saja dapat membuat kontainer gagal muat (<em>shut-out</em>).</p><h2>Tahapan Kunci Pengiriman Ekspor Bersama CARANO</h2><ul><li><strong>Booking Space & Stuffing:</strong> Penentuan jenis kontainer (20ft/40ft/HQ atau LCL) serta proses stuffing & strapping yang aman di gudang pabrik.</li><li><strong>Kepabeanan Ekspor (PEB & NPE):</strong> Pengajuan Pemberitahuan Ekspor Barang secara elektronik hingga terbit Nota Pelayanan Ekspor sebelum batas <em>closing</em>.</li><li><strong>SKA / Certificate of Origin (COO):</strong> Penerbitan Form IJEPA, Form E, Form AK, atau Form D agar buyer di negara tujuan memperoleh tarif bea masuk preferensial.</li></ul><blockquote>Tim PT. CARANO UTAMA LOGISTIK mendampingi eksportir Indonesia dari tahap konsultasi HS Code hingga Bill of Lading resmi terbit.</blockquote>',
                'body_en' => '<p>Succeeding in export markets requires accurate documentation and strict adherence to vessel closing schedules at <strong>Tanjung Priok, Tanjung Emas, and Tanjung Perak</strong>. Even a minor paperwork mismatch can cause costly container shut-outs.</p><h2>Key Export Milestones With CARANO</h2><ul><li><strong>Space Booking & Stuffing:</strong> Selecting optimal FCL/LCL capacity alongside safe factory strapping and stuffing.</li><li><strong>Export Customs (PEB & NPE):</strong> Timely electronic filing of Export Declarations through NPE gate-in approval before port cutoff.</li><li><strong>Certificate of Origin (COO/SKA):</strong> Preparing Form IJEPA, Form E, Form AK, or Form D so overseas buyers benefit from preferential import tariffs.</li></ul><blockquote>PT. CARANO UTAMA LOGISTIK supports Indonesian exporters from HS Code consultation through official Bill of Lading issuance.</blockquote>',
                'category' => 'Panduan Ekspor',
                'featured_image' => '/images/illustrations/sea-freight-vessel.jpg',
                'meta_title' => 'Panduan Ekspor Indonesia: PEB, SKA/COO & Stuffing Kontainer | PT. CARANO UTAMA LOGISTIK',
                'meta_description' => 'Langkah praktis pengiriman ekspor dari Indonesia melalui Tanjung Priok, Tanjung Emas & Tanjung Perak menuju Asia dan pasar global.',
                'status' => 'published',
                'published_at' => now()->subDays(1),
                'author_id' => $admin->id,
            ],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(['slug' => $post['slug']], $post);
        }

        // 8. FAQs (Export + Import)
        $faqs = [
            [
                'question_id' => 'Apakah PT. CARANO UTAMA LOGISTIK melayani pengiriman Ekspor maupun Impor?',
                'question_en' => 'Does PT. CARANO UTAMA LOGISTIK handle both Export and Import shipments?',
                'answer_id' => 'Ya. Kami melayani pengiriman dua arah secara end-to-end: Ekspor dari Indonesia ke luar negeri (termasuk stuffing, PEB/NPE, SKA/COO, fumigasi, dan sea/air freight) serta Impor dari Jepang, China, Taiwan, Korea Selatan, dan Singapura menuju Indonesia.',
                'answer_en' => 'Yes. We manage full end-to-end two-way logistics: Outbound Exports from Indonesia (stuffing, PEB/NPE, COO/SKA, fumigation, sea/air freight) as well as Inbound Imports from Japan, China, Taiwan, South Korea, and Singapore into Indonesia.',
                'category' => 'Ekspor & Impor',
                'sort_order' => 1,
            ],
            [
                'question_id' => 'Dokumen apa saja yang diperlukan untuk memulai pengiriman Ekspor dari Indonesia?',
                'question_en' => 'What documents are required to start an Export shipment from Indonesia?',
                'answer_id' => 'Dokumen dasar ekspor meliputi Commercial Invoice, Packing List, legalitas eksportir (NIB), serta dokumen tambahan sesuai komoditas seperti SKA/COO (Form E/IJEPA/AK/D), fumigasi, atau karantina. Tim kami membantu pengajuan PEB hingga terbit NPE dan Bill of Lading.',
                'answer_en' => 'Core export documents include Commercial Invoice, Packing List, exporter registration (NIB), and commodity-specific permits such as Certificate of Origin (COO/SKA), fumigation, or quarantine certificates. Our team handles PEB filing through NPE and Bill of Lading issuance.',
                'category' => 'Dokumen & Bea Cukai',
                'sort_order' => 2,
            ],
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
