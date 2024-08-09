<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Botble\SubscriptionPlan\Enums\FeatureEnum;
use Botble\SubscriptionPlan\Models\SubscriptionFeature;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            [ "name" => FeatureEnum::AD_SUPPORTED->value, "description" => "Ad-supported, all but a few movies and TV shows available, unlimited mobile games" ],
            [ "name" => FeatureEnum::UNLIMITED_AD_FREE_TV_MOBILE_GAMES->value, "description" => "Unlimited ad-free movies, TV shows, and mobile games" ],
            [ "name" => FeatureEnum::WATCH_ON_2_DEVICES->value, "description" => "Watch on 2 supported devices at a time"],
            [ "name" => FeatureEnum::WATCH_ON_4_DEVICES->value, "description" => "Watch on 4 supported devices at a time"],
            [ "name" => FeatureEnum::WATCH_IN_FULL_HD->value, "description" => "Watch in Full HD"],
            [ "name" => FeatureEnum::WATCH_IN_ULTRA_HD->value, "description" => "Watch in Ultra HD"],
            [ "name" => FeatureEnum::DOWNLOAD_ON_2_SUPPORTED_DEVICES->value, "description" => "Download on 2 supported devices at a time"],
            [ "name" => FeatureEnum::DOWNLOAD_ON_6_SUPPORTED_DEVICES->value, "description" => "Download on 6 supported devices at a time"],
            [ "name" => FeatureEnum::OPTION_TO_ADD_1_EXTRA_MEMBERS->value, "description" => "Option to add 1 extra member who doesn't live with you"],
            [ "name" => FeatureEnum::OPTION_TO_ADD_2_EXTRA_MEMBERS->value, "description" => "Option to add 2 extra member who doesn't live with you"],
            [ "name" => FeatureEnum::NETFLIX_SPACIAL_AUDIO->value, "description" => "Netflix spatial audio"],
        ];

        foreach($features as $feature) {


            SubscriptionFeature::updateOrCreate(
                [
                    'name' => $feature['name']
                ],
                [
                    'description' => $feature['description'],
                    'status' => 'published',
                ]
            );
        }
    }
}
