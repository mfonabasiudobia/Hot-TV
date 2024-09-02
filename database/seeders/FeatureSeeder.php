<?php

namespace Database\Seeders;
use Botble\SubscriptionPlan\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;
use Botble\SubscriptionPlan\Enums\FeatureEnum;
use Botble\SubscriptionPlan\Models\SubscriptionFeature;
use Botble\SubscriptionPlan\Models\Subscription;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;

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

        $plans = [
            [ 'name' => "Monthly" ],
            [ 'name' => "Annually" ]
        ];

        $subscriptions = [
            ["subscription_plan_id" => 1, "name" => "Basic", "price" => 8.99, "features" => [1, 3, 5]],
            ["subscription_plan_id" => 1, "name" => "Standard", "price" => 16.99, "features" => [2, 3, 5, 7, 9]],
            ["subscription_plan_id" => 1, "name" => "Premium", "price" => 21.99, "features" => [2, 4, 6, 8, 11]],
            ["subscription_plan_id" => 2, "name" => "Basic", "price" => 7.99, "features" => [1, 3, 5]],
            ["subscription_plan_id" => 2, "name" => "Standard", "price" => 14.99, "features" => [2, 3, 5, 7, 9]],
            ["subscription_plan_id" => 2, "name" => "Premium", "price" => 19.99, "features" => [2, 4, 6, 8, 11]],
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

        foreach($plans as $plan) {
            SubscriptionPlan::updateOrCreate(
                [
                    'name' => $plan['name'],
                    'status' => 'published',
                ]
            );
        }

        foreach($subscriptions as $subscription) {

            Stripe::setApiKey(gs()->payment_stripe_secret);
            $amount = $subscription['price'];
            $stripeProduct = Product::create([
                'name' => $subscription['name'],
                'active' => true,
            ]);

            $stripProductPrice = Price::create([
                'currency' => 'usd',
                'unit_amount' => $amount * 100,
                'recurring' =>[ 'interval' =>  $subscription['interval']],
                'product' => $stripeProduct->id
            ]);

            $provider = new PayPalClient([]);
            $token = $provider->getAccessToken();
            $provider->setAccessToken($token);

            $paypalProduct = $provider->createProduct([
                'name' => $subscription['name'],
                'description' => $subscription['name'],
                'type' => 'SERVICE',
                'category' =>   'SOFTWARE'
            ]);

            $paypalProductId = $paypalProduct['id'];



            $paypalPlan = $provider->createPlan([
                'product_id' => $paypalProductId,
                'name' => $subscription['name'],
                'description' => $subscription['name'],
                'billing_cycles' => [
                    [
                        'frequency' => [
                            'interval_unit' => $subscription['interval'],
                            'interval_count' => 1,
                        ],
                        'tenure_type' => 'REGULAR',
                        'sequence' => 1,
                        'total_cycles' => 0,
                        'pricing_scheme' => [
                            'fixed_price' => [
                                'value' => $amount,
                                'currency_code' => 'USD'
                            ],
                        ],
                    ],
                ],
                'payment_preferences' => [
                    'auto_bill_outstanding' => true,
                    'setup_fee' => [
                        'value' => 0,
                        'currency_code' => 'USD'
                    ],
                    'setup_fee_failure_action' => 'CONTINUE',
                    'payment_failure_threshold' => 3
                ],
                'plan_status' => 'ACTIVE'
            ]);
            $paypalPlanIds = [
                "without_trail" => $paypalPlan['id'],
                "7_days" => null,
                "15_days" => null,
                "13_days" => null,
                "3_months" => null,
            ];
            $paypalTenures = [
                "7_days" => ['interval_unit' => 'DAY','interval_count' => 7],
                "15_days" => ['interval_unit' => 'DAY','interval_count' => 15],
                "30_days" => ['interval_unit' => 'DAY','interval_count' => 30],
                "3_months" => ['interval_unit' => 'MONTH','interval_count' =>3],
            ];

            foreach($paypalTenures as $key => $tenure) {

                $createPlan = [
                    'product_id' => $paypalProductId,
                    'name' => $subscription['name'],
                    'description' => $subscription['name'],
                    'billing_cycles' => [
                        [
                            'frequency' => $tenure,
                            'tenure_type' => 'TRIAL',
                            'sequence' => 1,
                            'total_cycles' => 1,
                            'pricing_scheme' => [
                                'fixed_price' => [
                                    'value' => '0',
                                    'currency_code' => 'USD'
                                ]
                            ]
                        ],
                        [
                            'frequency' => [
                                'interval_unit' => $subscription['interval'],
                                'interval_count' => 1,
                            ],
                            'tenure_type' => 'REGULAR',
                            'sequence' => 2,
                            'total_cycles' => 0,
                            'pricing_scheme' => [
                                'fixed_price' => [
                                    'value' => $amount,
                                    'currency_code' => 'USD'
                                ],
                            ],
                        ],
                    ],
                    'payment_preferences' => [
                        'auto_bill_outstanding' => true,
                        'setup_fee' => [
                            'value' => 0,
                            'currency_code' => 'USD'
                        ],
                        'setup_fee_failure_action' => 'CONTINUE',
                        'payment_failure_threshold' => 3
                    ],
                    'plan_status' => 'ACTIVE'
                ];

                $paypalPlan = $provider->createPlan($createPlan);

                $paypalPlanIds[$key] = $paypalPlan["id"];
            }

            $sub = Subscription::updateOrCreate(
                [
                    'subscription_plan_id' => $subscription['subscription_plan_id'],
                    'name' => $subscription['name']
                ], [
                    'stripe_plan_id' => $stripProductPrice->id,
                    'price' => $subscription['price'],
                    'paypal_plan_id' => $paypalPlanIds,
                    'status' => 'published',
                ]
            );
            $sub->features()->detach();
            $sub->features()->attach($subscription['features']);
        }
    }
}
