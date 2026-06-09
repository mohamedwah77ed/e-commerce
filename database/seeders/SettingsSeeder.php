<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $defaults = [
        'site_name'    => 'متجرنا',
        'phone'        => '01000000000',
        'email'        => 'info@store.com',
        'address'      => 'القاهرة، مصر',
        'about_us'     => 'نحن متجر إلكتروني متخصص في الإلكترونيات',
        'facebook'     => 'https://facebook.com',
        'instagram'    => 'https://instagram.com',
        'twitter'      => 'https://twitter.com',
        'footer_text'  => 'جميع الحقوق محفوظة',
    ];

    foreach ($defaults as $key => $value) {
        Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
}
