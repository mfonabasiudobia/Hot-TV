<?php

namespace ArchiElite\Career\Listeners;

use ArchiElite\Career\Models\Career;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Theme\Events\RenderingSiteMapEvent;
use Botble\Theme\Facades\SiteMapManager;

class AddSitemapListener
{
    public function handle(RenderingSiteMapEvent $event): void
    {
        if ($event->key === 'careers') {
            $careerLastUpdated = Career::query()
                ->where('status', BaseStatusEnum::PUBLISHED)
                ->latest('updated_at')
                ->value('updated_at');

            SiteMapManager::add(route('public.careers'), $careerLastUpdated, '0.4', 'monthly');

            $careers = Career::query()
                ->where('status', BaseStatusEnum::PUBLISHED)
                ->with('slugable')
                ->get();

            $careers->each(function ($career) {
                SiteMapManager::add($career->url, $career->updated_at, '0.6');
            });
        }

        $careerLastUpdated = Career::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->latest('updated_at')
            ->value('updated_at');

        SiteMapManager::addSitemap(SiteMapManager::route('careers'), $careerLastUpdated);
    }
}
