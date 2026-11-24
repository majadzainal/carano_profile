<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role', 30)->default('editor')->after('email');
            });
        }

        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->string('group', 50)->default('general')->index();
            $table->string('label', 150);
            $table->longText('value_id')->nullable();
            $table->longText('value_en')->nullable();
            $table->string('type', 30)->default('text'); // text, textarea, image, file, email, phone, url
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->string('page_slug', 60)->index(); // home, about, services, roadmap, network, contact
            $table->string('section_key', 80)->unique();
            $table->string('section_label', 120);
            $table->string('badge_id')->nullable();
            $table->string('badge_en')->nullable();
            $table->string('title_id')->nullable();
            $table->string('title_en')->nullable();
            $table->text('subtitle_id')->nullable();
            $table->text('subtitle_en')->nullable();
            $table->longText('body_id')->nullable();
            $table->longText('body_en')->nullable();
            $table->string('cta_label_id')->nullable();
            $table->string('cta_label_en')->nullable();
            $table->string('cta_url')->nullable();
            $table->string('secondary_cta_label_id')->nullable();
            $table->string('secondary_cta_label_en')->nullable();
            $table->string('secondary_cta_url')->nullable();
            $table->string('image_path')->nullable();
            $table->json('extra_json')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('roadmap_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('step_number')->default(1);
            $table->string('phase', 30)->default('origin'); // origin, sea, destination
            $table->string('title_id');
            $table->string('title_en');
            $table->text('description_id')->nullable();
            $table->text('description_en')->nullable();
            $table->json('highlights_id')->nullable();
            $table->json('highlights_en')->nullable();
            $table->string('icon', 50)->default('package');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 120)->unique();
            $table->string('badge_id')->nullable();
            $table->string('badge_en')->nullable();
            $table->string('title_id');
            $table->string('title_en');
            $table->text('short_desc_id')->nullable();
            $table->text('short_desc_en')->nullable();
            $table->longText('body_id')->nullable();
            $table->longText('body_en')->nullable();
            $table->string('icon', 50)->default('ship');
            $table->string('image_path')->nullable();
            $table->json('features_id')->nullable();
            $table->json('features_en')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('trade_hubs', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20)->index(); // origin, destination
            $table->string('code', 20)->nullable();
            $table->string('name_id');
            $table->string('name_en');
            $table->string('country', 80);
            $table->text('description_id')->nullable();
            $table->text('description_en')->nullable();
            $table->float('map_x')->default(50);
            $table->float('map_y')->default(50);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 160)->unique();
            $table->string('title_id');
            $table->string('title_en')->nullable();
            $table->text('excerpt_id')->nullable();
            $table->text('excerpt_en')->nullable();
            $table->longText('body_id')->nullable();
            $table->longText('body_en')->nullable();
            $table->string('category', 80)->default('Logistics');
            $table->string('featured_image')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('status', 20)->default('draft')->index(); // draft, published
            $table->timestamp('published_at')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question_id');
            $table->string('question_en')->nullable();
            $table->text('answer_id');
            $table->text('answer_en')->nullable();
            $table->string('category', 60)->default('Umum');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('media_files', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('original_name');
            $table->string('file_path');
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('file_size')->default(0);
            $table->string('alt_text')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('contact_name');
            $table->string('email');
            $table->string('phone', 50);
            $table->string('origin_country', 80)->nullable();
            $table->string('destination_port', 80)->nullable();
            $table->string('service_type', 100)->nullable();
            $table->text('cargo_details')->nullable();
            $table->string('status', 30)->default('new')->index(); // new, in_progress, quoted, closed
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
        Schema::dropIfExists('media_files');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('trade_hubs');
        Schema::dropIfExists('services');
        Schema::dropIfExists('roadmap_steps');
        Schema::dropIfExists('page_sections');
        Schema::dropIfExists('site_settings');
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }
};
