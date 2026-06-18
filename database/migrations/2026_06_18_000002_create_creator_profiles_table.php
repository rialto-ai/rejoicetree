<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * One-to-one Rejoice profile for a creator/ministry page (a LinkStack user).
     * Isolated from the core `users` table to keep upstream changes low-risk.
     */
    public function up(): void
    {
        Schema::create('creator_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();

            // Core profile
            $table->string('page_type')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('cover_image')->nullable();
            $table->text('short_bio')->nullable();
            $table->string('location')->nullable();
            $table->string('primary_category')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('management_contact')->nullable();
            $table->string('booking_contact')->nullable();

            // Christian profile
            $table->text('testimony')->nullable();
            $table->string('church_affiliation')->nullable();
            $table->string('ministry_affiliation')->nullable();
            $table->string('statement_of_faith_url')->nullable();
            $table->string('publisher_or_label')->nullable();
            $table->text('partner_organizations')->nullable();
            $table->text('supported_causes')->nullable();

            // Trust and integrity
            $table->string('verification_status')->default('Unverified');
            $table->string('review_status')->default('Draft');
            $table->string('content_review_status')->nullable();
            $table->string('support_link_review_status')->nullable();
            $table->string('affiliation_review_status')->nullable();

            // Authorship and AI-use disclosure
            $table->string('human_authorship_status')->default('Not Provided');
            $table->string('ai_use_level')->default('None Disclosed');
            $table->text('ai_use_disclosure_text')->nullable();
            $table->boolean('synthetic_voice_used')->default(false);
            $table->boolean('synthetic_persona_used')->default(false);

            // Rejoice integration
            $table->string('rejoice_audio_status')->default('Coming Soon');
            $table->string('rejoice_audio_artist_id')->nullable();
            $table->string('rejoice_audio_ministry_id')->nullable();
            $table->string('rejoice_audio_podcast_id')->nullable();
            $table->string('rejoice_audio_audiobook_id')->nullable();
            $table->string('creator_onboarding_status')->default('Not Started');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creator_profiles');
    }
};
