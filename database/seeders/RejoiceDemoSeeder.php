<?php

namespace Database\Seeders;

use App\Models\Button;
use App\Models\CreatorProfile;
use App\Models\Link;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RejoiceDemoSeeder extends Seeder
{
    public function run(): void
    {
        $buttonId = Button::where('name', 'custom_website')->value('id') ?? optional(Button::first())->id ?? 1;

        $demos = [
            ['slug' => 'demo-artist', 'name' => 'Demo Artist', 'type' => 'Artist',
             'verification' => 'Creator Verified', 'audio' => 'Onboarding',
             'testimony' => 'Saved by grace, I write songs to point people to Jesus.',
             'blocks' => [['Music', 'Latest Single'], ['Support', 'Support my music', 'Personal Support']]],
            ['slug' => 'demo-podcast', 'name' => 'Demo Podcast', 'type' => 'Podcaster',
             'verification' => 'Rejoice Reviewed', 'audio' => 'Coming Soon',
             'testimony' => 'Weekly conversations about faith, doubt, and the gospel.',
             'blocks' => [['Podcast', 'Listen to the latest episode'], ['Newsletter', 'Join the newsletter']]],
            ['slug' => 'demo-ministry', 'name' => 'Demo Ministry', 'type' => 'Ministry',
             'verification' => 'Ministry Verified', 'audio' => 'Coming Soon',
             'testimony' => 'Serving our city with the love of Christ.',
             'blocks' => [['Support', 'Give', 'Ministry Donation'], ['Event', 'Upcoming gathering']]],
            ['slug' => 'demo-builder', 'name' => 'Demo Builder', 'type' => 'Rejoice Builder',
             'verification' => 'Partner Verified', 'audio' => 'Coming Soon',
             'testimony' => 'Building open tools for the Church.',
             'blocks' => [['Rejoice Builder Project', 'View the project'], ['Custom Link', 'GitHub']]],
        ];

        foreach ($demos as $demo) {
            $user = User::where('littlelink_name', $demo['slug'])->first();
            if (!$user) {
                $user = User::create([
                    'name' => $demo['name'],
                    'email' => $demo['slug'] . '@example.com',
                    'password' => Hash::make(\Illuminate\Support\Str::random(32)),
                    'littlelink_name' => $demo['slug'],
                    'littlelink_description' => $demo['testimony'],
                    'email_verified_at' => now(),
                ]);
            }

            $profile = $user->profile();
            $profile->fill([
                'page_type' => $demo['type'],
                'short_bio' => $demo['testimony'],
                'testimony' => $demo['testimony'],
                'verification_status' => $demo['verification'],
                'review_status' => 'Approved',
                'rejoice_audio_status' => $demo['audio'],
                'creator_onboarding_status' => 'Published',
            ]);
            $profile->save();

            foreach ($demo['blocks'] as $i => $block) {
                $exists = Link::where('user_id', $user->id)->where('title', $block[1])->exists();
                if ($exists) {
                    continue;
                }
                Link::create([
                    'user_id' => $user->id,
                    'button_id' => $buttonId,
                    'block_type' => $block[0],
                    'title' => $block[1],
                    'link' => 'https://example.com/' . $demo['slug'] . '/' . ($i + 1),
                    'support_type' => $block[2] ?? null,
                    'order' => $i,
                    'review_status' => 'Approved',
                ]);
            }
        }
    }
}
