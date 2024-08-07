<?php
namespace Botble\SubscriptionPlan\Enums;

enum FeatureEnum:string
{
    case UNLIMITED_AD_FREE_TV_MOBILE_GAMES = 'unlimited_ad_free_tv_mobile_games';
    case WATCH_ON_2_DEVICES =  'watch_on_2_devices';
    case WATCH_ON_4_DEVICES = 'watch_on_4_devices';
    case WATCH_IN_FULL_HD = 'watch_in_full_hd';
    case WATCH_IN_ULTRA_HD = 'watch_in_ultra_hd';
    case DOWNLOAD_ON_2_SUPPORTED_DEVICES = 'download_on_2_supported_devices';
    case DOWNLOAD_ON_6_SUPPORTED_DEVICES = 'download_on_4_supported_devices';
    case OPTION_TO_ADD_1_EXTRA_MEMBERS = 'option_to_add_1_extra_member';
    case OPTION_TO_ADD_2_EXTRA_MEMBERS = 'option_to_add_2_extra_member';
    case NETFLIX_SPACIAL_AUDIO = 'netflix_spacial_audio';
}