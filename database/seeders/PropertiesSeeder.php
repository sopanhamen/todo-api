<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Property\Property;

class PropertiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function RandomImage()
    {
        $allImages = [
            'larges' => [
                "images/dummy/1-min.jpg",
                "images/dummy/2-min.jpg",
                "images/dummy/3-min.jpg",
                "images/dummy/4-min.jpg",
                "images/dummy/5-min.jpg",
                "images/dummy/6-min.jpg",
                "images/dummy/7-min.jpg",
                "images/dummy/8-min.jpg",
                "images/dummy/9-min.jpg",
                "images/dummy/10-min.jpg",
                "images/dummy/11-min.jpg",
                "images/dummy/12-min.jpg",
                "images/dummy/13-min.jpg",
                "images/dummy/14-min.jpg",
                "images/dummy/15-min.jpg",
            ],
            'thumbnails' => [
                "thumbnails/dummy/1-min.jpg",
                "thumbnails/dummy/2-min.jpg",
                "thumbnails/dummy/3-min.jpg",
                "thumbnails/dummy/4-min.jpg",
                "thumbnails/dummy/5-min.jpg",
                "thumbnails/dummy/6-min.jpg",
                "thumbnails/dummy/7-min.jpg",
                "thumbnails/dummy/8-min.jpg",
                "thumbnails/dummy/9-min.jpg",
                "thumbnails/dummy/10-min.jpg",
                "thumbnails/dummy/11-min.jpg",
                "thumbnails/dummy/12-min.jpg",
                "thumbnails/dummy/13-min.jpg",
                "thumbnails/dummy/14-min.jpg",
                "thumbnails/dummy/15-min.jpg",
            ]
        ];

        $images = [];
        $imageLength = rand(2, 4);
        for ($i = 0; $i < $imageLength; $i++) {
            $randomImageIndex = rand(0, 14);
            $images[] =  [
                "path_large" => $allImages['larges'][$randomImageIndex],
                "path_thumbnail" => $allImages['thumbnails'][$randomImageIndex]
            ];
        }

        return $images;
    }

    public function run()
    {
        for ($i = 0; $i < 4; $i++) {
            echo "-> Inserting 500 properties...\n";
            Property::factory()->count(500)->create()->each(function ($property) {
                $property->images()->createMany($this->RandomImage());
            });

            echo "-> INSERTED \n\n";
        }
    }
}
