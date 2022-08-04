<?php

namespace Database\Seeders;

use App\Modules\Province\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinces')->delete();

        $now = now();
        $data = [
            ["id" => '49f46a3d-6d17-42d9-bd40-0cc4951c0045', "code" => 1, "name_km" => "បន្ទាយមានជ័យ", "name_en" => "Banteay Meanchey", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => '7706bb99-3b59-4678-9b79-14278ce016a7', "code" => 2, "name_km" => "បាត់ដំបង", "name_en" => "Battambang", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => 'b656e691-53e0-42a6-a086-233991f67d3b', "code" => 3, "name_km" => "កំពង់ចាម", "name_en" => "Kampong Cham", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => '674a67ad-5f5b-4107-9e21-9426ec2cdd90', "code" => 4, "name_km" => "កំពង់ឆ្នាំង", "name_en" => "Kampong Chhnang", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => '0ab1a69b-e930-4abe-b76d-aa4d123db93d', "code" => 5, "name_km" => "កំពង់ស្ពឺ", "name_en" => "Kampong Speu", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => 'cc2409dd-babe-4aec-885c-0ce52813cb25', "code" => 6, "name_km" => "កំពង់ធំ", "name_en" => "Kampong Thom", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => '3fe47e24-54b3-460a-aebe-afa20843d2e3', "code" => 7, "name_km" => "កំពត", "name_en" => "Kampot", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => 'ed0f1042-6c41-46b1-a599-2c6f6a541343', "code" => 8, "name_km" => "កណ្ដាល", "name_en" => "Kandal", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => '5af1a117-ab6a-4344-82b8-0d51b6bc7572', "code" => 9, "name_km" => "កោះកុង", "name_en" => "Koh Kong", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => '9c8838af-8861-4165-89f2-9c1367e0e4e3', "code" => 10, "name_km" => "ក្រចេះ", "name_en" => "Kratie", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => 'ab93bae2-a322-4c7c-8618-d91e93121bd0', "code" => 11, "name_km" => "មណ្ឌលគិរី", "name_en" => "Mondul Kiri", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => 'bc24d551-7dcb-42e7-acf5-b72e0a22a7b7', "code" => 12, "name_km" => "ភ្នំពេញ", "name_en" => "Phnom Penh", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => '84da1167-4516-412e-8e35-02b929bc69b6', "code" => 13, "name_km" => "ព្រះវិហារ", "name_en" => "Preah Vihear", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => '48de4931-8e44-446b-895d-e15797e677d2', "code" => 14, "name_km" => "ព្រៃវែង", "name_en" => "Prey Veng", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => '76291e42-2964-4f31-a00b-21dae2b77a69', "code" => 15, "name_km" => "ពោធិ៍សាត់", "name_en" => "Pursat", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => 'd48fb1f5-ac6c-431e-a4b0-5c417b6a3f05', "code" => 16, "name_km" => "រតនគិរី", "name_en" => "Ratanak Kiri", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => '9a3c2aeb-f191-468a-bd95-0a83db566dbb', "code" => 17, "name_km" => "សៀមរាប", "name_en" => "Siemreap", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => '27aa94e0-a602-458a-aa32-191b5eb4bf09', "code" => 18, "name_km" => "ព្រះសីហនុ", "name_en" => "Preah Sihanouk", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => '27475b68-10aa-4d24-bce5-7dbf380aec32', "code" => 19, "name_km" => "ស្ទឹងត្រែង", "name_en" => "Stung Treng", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => 'cb5cf2cb-967d-4689-8283-5dc6e0a129c5', "code" => 20, "name_km" => "ស្វាយរៀង", "name_en" => "Svay Rieng", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => '8450ebdf-5df2-4bc3-879a-85718d840d27', "code" => 21, "name_km" => "តាកែវ", "name_en" => "Takeo", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => '216ca1d6-b535-4f0e-98d7-43956ada6b7d', "code" => 22, "name_km" => "ឧត្ដរមានជ័យ", "name_en" => "Oddar Meanchey", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => '6100ca2e-545e-42db-bd57-df7d893eeeae', "code" => 23, "name_km" => "កែប", "name_en" => "Kep", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => 'af74c123-33c7-4abe-9e0f-60e7ce67fe5a', "code" => 24, "name_km" => "ប៉ៃលិន", "name_en" => "Pailin", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null],
            ["id" => '9127f598-5215-4aa1-80a1-c8649b79293f', "code" => 25, "name_km" => "ត្បូងឃ្មុំ", "name_en" => "Tboung Khmum", "country_id" => "bff6ddbf-2a3f-477a-bb44-8d0b42212573", "boundary" => null, "center" => null, "created_at" => $now, "updated_at" => null]
        ];

        Province::insert($data);
    }
}
