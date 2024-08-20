<?php

namespace App\Enums\Api\V1;

enum ApiResponseMessageEnum:string
{
    case VALIDATION_ERRORS = "Validation errors";
    case TOO_MANY_LOGIN_ATTEMPTS = 'Too many login attempts. Please try again after few minutes';
    case LOGIN_USER_SUCCESS = "login success";
    case LOGIN_USER_FAILED = "invalid credentials";
    case REGISTRATION_PROCESS = "registration process";
    case SUBSCRIPTION_NOT_FOUND = 'subscription not found';
    case FORGOT_PASSWORD_OTP_SENT_TO_EMAIL = 'forgot password otp sent to your email';
    case OTP_NOT_VERIFIED = 'otp is not verified';
    case OTP_VERIFIED = 'otp verified successfully';
    case PASSWORD_RESET_SUCCESS = 'password reset successfully';
    case NOT_FOUND = 'not found';
    case SUBSCRIPTION_PLANS= 'subscription plans';
    case PROFILE_UPDATED = 'profile updated';
    case TV_SHOW_CATEGORIES = 'tv show categories';
    case TV_SHOWS = 'tv shows';
    case EPISODE = 'episode';
    case PODCASTS = 'podcasts';
    case PODCAST = 'podcast';
    case STREAMS = 'streams';

}
