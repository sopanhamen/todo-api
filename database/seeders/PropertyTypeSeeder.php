<?php

namespace Database\Seeders;

use App\Modules\Common\Enum\PropertyTypeGroup;
use App\Modules\PropertyType\PropertyType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $propertyTypes = [

            // HOMES Group
            ["name" => "Apartment", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Apartment Business Rent", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Apartment Sale", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Casino", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Condo Grand Opening Sale", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Condominium", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Flat 1 Unit", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Guest House", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Hotel", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Jasmina - Villa", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Join Units Flat", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "King-Villa", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Link House -  LC1", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Link House - LA", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Link House - LC2", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Link House-LB", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Link-House", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Prince - Villa", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Queen-Villa", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Resort", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Semi-Permanent House", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Shop-House", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Single Villa", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Twin-Villa", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Villa Queen A", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "VIP Villa", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Wooden House", "property_type_group" => PropertyTypeGroup::HOMES->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],

            // LANDS_PLOTS Group
            ["name" => "Agriculture Land", "property_type_group" => PropertyTypeGroup::LANDS_PLOTS->value, "published" => true, "created_at" => now(), 'facilities' => [61]],
            ["name" => "Commercial Land", "property_type_group" => PropertyTypeGroup::LANDS_PLOTS->value, "published" => true, "created_at" => now(), 'facilities' => [59, 60, 61, 62]],
            ["name" => "Industrial Plot", "property_type_group" => PropertyTypeGroup::LANDS_PLOTS->value, "published" => true, "created_at" => now(), 'facilities' => [59, 60, 61, 62]],
            ["name" => "Island", "property_type_group" => PropertyTypeGroup::LANDS_PLOTS->value, "published" => true, "created_at" => now(), 'facilities' => [59, 60, 61, 63, 64]],
            ["name" => "Residential Plot", "property_type_group" => PropertyTypeGroup::LANDS_PLOTS->value, "published" => true, "created_at" => now(), 'facilities' => [59, 60, 61, 62, 63, 64]],
            ["name" => "Rubber Plantation", "property_type_group" => PropertyTypeGroup::LANDS_PLOTS->value, "published" => true, "created_at" => now(), 'facilities' => [59, 60, 61, 64]],
            ["name" => "Vacant Land", "property_type_group" => PropertyTypeGroup::LANDS_PLOTS->value, "published" => true, "created_at" => now(), 'facilities' => [59, 60, 61, 62, 63, 64]],

            // COMMERCIAL Group
            ["name" => "Office Space", "property_type_group" => PropertyTypeGroup::LANDS_PLOTS->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Building", "property_type_group" => PropertyTypeGroup::LANDS_PLOTS->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],
            ["name" => "Office Building", "property_type_group" => PropertyTypeGroup::LANDS_PLOTS->value, "published" => true, "created_at" => now(), 'facilities' => [23, 32, 46, 47, 53, 54]],

            // BUSINESS Group
            ["name" => "Auto Repair Shops", "property_type_group" => PropertyTypeGroup::BUSINESS->value, "published" => true, "created_at" => now(), 'facilities' => [51, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85]],
            ["name" => "Internet Business", "property_type_group" => PropertyTypeGroup::BUSINESS->value, "published" => true, "created_at" => now(), 'facilities' => [51, 90, 91, 92, 93]],
            ["name" => "Beauty Salons", "property_type_group" => PropertyTypeGroup::BUSINESS->value, "published" => true, "created_at" => now(), 'facilities' => [51, 94, 95, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109]],
            ["name" => "Pub", "property_type_group" => PropertyTypeGroup::BUSINESS->value, "published" => true, "created_at" => now(), 'facilities' => [51, 94, 95, 110, 111, 112, 113, 119, 120, 122, 123, 124, 125, 126, 127, 128, 129, 138,]],
            ["name" => "Convenience Stores", "property_type_group" => PropertyTypeGroup::BUSINESS->value, "published" => true, "created_at" => now(), 'facilities' => [51, 114, 115, 116, 118, 120, 121, 124, 130, 134]],
            ["name" => "Bar", "property_type_group" => PropertyTypeGroup::BUSINESS->value, "published" => true, "created_at" => now(), 'facilities' => [51, 94, 95, 110, 111, 112, 113, 119, 120, 122, 123, 124, 125, 126, 127, 128, 129, 138,]],
            ["name" => "NightClubs", "property_type_group" => PropertyTypeGroup::BUSINESS->value, "published" => true, "created_at" => now(), 'facilities' => [51, 94, 95, 110, 111, 112, 113, 119, 121, 122, 123, 124, 125, 126, 127, 128, 129,]],
            ["name" => "Cafes", "property_type_group" => PropertyTypeGroup::BUSINESS->value, "published" => true, "created_at" => now(), 'facilities' => [51, 94, 95, 102, 110, 111, 112, 113, 130, 131, 132, 133, 134, 135, 136]],
            ["name" => "Restaurant", "property_type_group" => PropertyTypeGroup::BUSINESS->value, "published" => true, "created_at" => now(), 'facilities' => [51, 94, 95, 102, 110, 111, 112, 113, 114, 115, 116, 117, 120, 130, 131, 132, 133, 134, 135, 136, 137, 138, 139]],
            ["name" => "Shop", "property_type_group" => PropertyTypeGroup::BUSINESS->value, "published" => true, "created_at" => now(), 'facilities' => [51, 114, 115, 116, 118, 120, 121, 124, 130, 134]],
            ["name" => "Apartment Business", "property_type_group" => PropertyTypeGroup::BUSINESS->value, "published" => true, "created_at" => now(), 'facilities' => [1, 2, 10, 15, 24, 25, 27, 28, 29, 50, 51, 69, 70, 71, 72, 73, 74, 111, 112, 113, 139]],

            // INDUSTRIAL Group
            ["name" => "Factory", "property_type_group" => PropertyTypeGroup::INDUSTRIAL->value, "published" => true, "created_at" => now(), 'facilities' => [3, 25, 26, 28, 34, 35, 36, 51, 71, 72, 73]],
            ["name" => "Warehouse", "property_type_group" => PropertyTypeGroup::INDUSTRIAL->value, "published" => true, "created_at" => now(), 'facilities' => [3, 25, 26, 28, 34, 35, 36, 51, 71, 72, 73, 140]],

            // PETROL STATION Group
            ["name" => "Petrol Station", "property_type_group" => PropertyTypeGroup::PETROL_STATION->value, "published" => true, "created_at" => now(), 'facilities' => [26, 51, 63, 71, 141, 142, 143, 144]],
        ];

        DB::transaction(function () use ($propertyTypes) {
            foreach ($propertyTypes as $payload) {
                $data = collect($payload)->except(['facilities'])->all();
                $propertyType = PropertyType::create($data);

                if (!empty($payload['facilities'])) {
                    $propertyType->facilities()->sync($payload['facilities']);
                }
            }
        });
    }
}
