<?php

namespace Database\Seeders;

use App\Modules\Setting\Setting;
use App\Modules\Setting\Enum\Setting as EnumSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultThemeSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultTheme = file_get_contents(base_path('database/json/default-theme.json'));
        Setting::create([
            'setting_key' => EnumSetting::WEBSITE_THEME,
            'setting_value' => $defaultTheme,
            'created_at' => now()
        ]);
    }
}
