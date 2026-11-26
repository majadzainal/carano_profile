<?php

namespace Tests\Feature;

use App\Models\Inquiry;
use App\Models\PageSection;
use App\Models\User;
use Database\Seeders\CaranoCmsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CaranoWebsiteAndCmsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CaranoCmsSeeder::class);
    }

    public function test_all_public_pages_render_successfully(): void
    {
        $routes = [
            '/',
            '/layanan',
            '/layanan/sea-freight-import',
            '/layanan/sea-air-freight-export',
            '/alur-pengiriman',
            '/jaringan-rute',
            '/tentang-kami',
            '/insight',
            '/insight/panduan-10-tahap-road-map-shipment-impor-laut',
            '/insight/panduan-ekspor-indonesia-peb-ska-dan-stuffing-kontainer',
            '/kontak',
        ];

        foreach ($routes as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);
        }
    }

    public function test_public_visitor_can_switch_locale_and_submit_rfq_inquiry(): void
    {
        $this->post('/locale/en')->assertRedirect();
        $this->assertEquals('en', session('locale'));

        $response = $this->post('/kontak/inquiry', [
            'company_name' => 'PT. Test Importer',
            'contact_name' => 'Andi Pratama',
            'email' => 'andi@testimporter.co.id',
            'phone' => '08123456789',
            'origin_country' => 'Jepang',
            'destination_port' => 'Pelabuhan Tanjung Priok',
            'service_type' => 'Sea Freight Impor (FCL & LCL)',
            'cargo_details' => '2x40ft HQ industrial equipment from Tokyo.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('inquiries', [
            'company_name' => 'PT. Test Importer',
            'status' => 'new',
        ]);
    }

    public function test_admin_routes_require_authentication_at_carano_admin(): void
    {
        $this->get('/admin')->assertStatus(404);
        $this->get('/carano-admin')->assertRedirect('/carano-admin/login');
        $this->get('/carano-admin/posts')->assertRedirect('/carano-admin/login');
        $this->get('/carano-admin/settings')->assertRedirect('/carano-admin/login');
    }

    public function test_authenticated_admin_can_access_cms_and_edit_content(): void
    {
        $admin = User::where('email', 'admin@caranologistik.co.id')->firstOrFail();

        $this->actingAs($admin)->get('/carano-admin')->assertStatus(200);
        $this->actingAs($admin)->get('/carano-admin/sections')->assertStatus(200);
        $this->actingAs($admin)->get('/carano-admin/roadmap')->assertStatus(200);
        $this->actingAs($admin)->get('/carano-admin/services')->assertStatus(200);
        $this->actingAs($admin)->get('/carano-admin/routes')->assertStatus(200);
        $this->actingAs($admin)->get('/carano-admin/posts')->assertStatus(200);
        $this->actingAs($admin)->get('/carano-admin/faqs')->assertStatus(200);
        $this->actingAs($admin)->get('/carano-admin/media')->assertStatus(200);
        $this->actingAs($admin)->get('/carano-admin/inquiries')->assertStatus(200);
        $this->actingAs($admin)->get('/carano-admin/settings')->assertStatus(200);
        $this->actingAs($admin)->get('/carano-admin/users')->assertStatus(200);

        $hero = PageSection::where('section_key', 'home_hero')->firstOrFail();
        $this->actingAs($admin)->put("/carano-admin/sections/{$hero->id}", [
            'badge_id' => 'UPDATED BADGE',
            'title_id' => 'Judul Hero Baru dari CMS',
            'is_active' => true,
        ])->assertRedirect();

        $this->assertDatabaseHas('page_sections', [
            'id' => $hero->id,
            'title_id' => 'Judul Hero Baru dari CMS',
        ]);

        $this->actingAs($admin)->post('/carano-admin/posts', [
            'title_id' => 'Artikel Uji Coba CMS Carano',
            'category' => 'Berita',
            'body_id' => '<p>Konten uji coba editor TipTap.</p>',
            'status' => 'published',
        ])->assertRedirect('/carano-admin/posts');

        $this->assertDatabaseHas('posts', [
            'title_id' => 'Artikel Uji Coba CMS Carano',
            'status' => 'published',
        ]);

        $inquiry = Inquiry::firstOrFail();
        $this->actingAs($admin)->put("/carano-admin/inquiries/{$inquiry->id}", [
            'status' => 'quoted',
            'admin_notes' => 'Quotation sent via WhatsApp.',
        ])->assertRedirect();

        $this->assertDatabaseHas('inquiries', [
            'id' => $inquiry->id,
            'status' => 'quoted',
        ]);
    }
}
