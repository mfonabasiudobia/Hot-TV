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
    case YOU_DO_NOT_HAVE_PERMISSION = 'you don\'nt have permission';
    case NO_RIDE_FOUND = 'no ride found';
    case STRIPE_PAYMENT_URL = 'stripe payment url';
    case PAYPAL_PAYMENT_URL = 'paypal payment url';
    case PRODUCTS = 'products';
    case PRODUCT = 'product';
    case INVALID_QUANTITY_SUPPLIED='invalid quantity supplied';
    case MAX_QUANTITY_REACHED = 'max quantity reached';
    case PRODUCT_ADDED_SUCCESS = 'product added to cart successfully';
    case CART = 'cart';
    case CART_UPDATED = 'cart updated';
    case ITEM_REMOVED_FROM_CART = 'item removed from the cart';
    case CHECKOUT_REDIRECT = 'checkout redirect';
    case PAYMENT_SUCCESS = 'payment success';
    case REGISTRATION_CLOSED = 'registrations are currently closed';
    case PAYMENT_METHODS = 'payment methods';

}
