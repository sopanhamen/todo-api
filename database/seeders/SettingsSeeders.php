<?php

namespace Database\Seeders;

use App\Modules\Setting\Enum\Setting as EnumSetting;
use App\Modules\Setting\Enum\WatermarkPosition;
use App\Modules\Setting\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SettingsSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        $data = [
            [
                'id' => Str::uuid(),
                'setting_key' => EnumSetting::SITE_NAME,
                'setting_value' => 'MEKONGB ROKERAGE SYSTEM',
                'created_at' => $now,
            ],

            [
                'id' => Str::uuid(),
                'setting_key' => EnumSetting::APP_NAME,
                'setting_value' => 'APPA',
                'created_at' => $now,
            ],
            [
                'id' => Str::uuid(),
                'setting_key' => EnumSetting::SITE_LOGO,
                'setting_value' => null,
                'created_at' => $now,
            ],
            [
                'id' => Str::uuid(),
                'setting_key' => EnumSetting::FAVICON,
                'setting_value' => null,
                'created_at' => $now,
            ],
            [
                'id' => Str::uuid(),
                'setting_key' => EnumSetting::PROPERTY_CODE_PREFIX,
                'setting_value' => 'MK-',
                'created_at' => $now,
            ],
            [
                'id' => Str::uuid(),
                'setting_key' => EnumSetting::PROPERTY_CODE_DIGIT,
                'setting_value' => 5,
                'created_at' => $now,
            ],
            [
                'id' => Str::uuid(),
                'setting_key' => EnumSetting::WATERMARK_POSITION,
                'setting_value' => WatermarkPosition::BOTTOM_RIGHT,
                'created_at' => $now,
            ],
            [
                'id' => Str::uuid(),
                'setting_key' => EnumSetting::WATERMARK_PROPERTY,
                'setting_value' => null,
                'created_at' => $now,
            ],
            [
                'id' => Str::uuid(),
                'setting_key' => EnumSetting::WATERMARK_PROJECT,
                'setting_value' => null,
                'created_at' => $now,
            ],
            [
                'id' => Str::uuid(),
                'setting_key' => EnumSetting::WATERMARK_INDICATION,
                'setting_value' => null,
                'created_at' => $now,
            ],
            [
                'id' => Str::uuid(),
                'setting_key' => EnumSetting::WATERMARK_VALUATION_REPORT,
                'setting_value' => null,
                'created_at' => $now,
            ],

        ];

        DB::table((new Setting)->getTable())->insert($data);

        $this->call(DefaultThemeSettingSeeder::class);
    }
}
