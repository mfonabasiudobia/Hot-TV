<?php

namespace Botble\Base\Enums;

use Botble\Base\Facades\Html;
use Botble\Base\Supports\Enum;
use Illuminate\Support\HtmlString;

/**
 * @method static BaseDiscountTypeEnum DRAFT()
 * @method static BaseDiscountTypeEnum PUBLISHED()
 */
class BaseDiscountTypeEnum extends Enum
{
    public const PERCENT = 'percent';
    public const FIXED = 'fixed';

    public static $langPath = 'core/base::enums.statuses';

    public function toHtml(): string|HtmlString
    {
        return match ($this->value) {
            self::PERCENT => Html::tag('span', self::PERCENT()->label(), ['class' => 'label-info status-label'])
                ->toHtml(),
            self::FIXED => Html::tag('span', self::FIXED()->label(), ['class' => 'label-warning status-label'])
                ->toHtml(),
            default => parent::toHtml(),
        };
    }
}
