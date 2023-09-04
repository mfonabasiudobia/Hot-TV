<?php

use Botble\Widget\AbstractWidget;

class SiteInformationWidget extends AbstractWidget
{
    public function __construct()
    {
        parent::__construct([
            'name' => __('Contact information'),
            'description' => __('Widget display Contact information'),
            'title' => __('Contact information'),
            'logo' => null,
            'address' => '',
            'working_hours_start' => '',
            'working_hours_end' => '',
        ]);
    }
}
