<?php

namespace ArchiElite\Career\Actions;

use ArchiElite\Career\Models\Career;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class IncrementCareerViews
{
    public function __invoke(Career $career): void
    {
        $sessionKey = "career_viewed_{$career->getKey()}";

        if (Session::has($sessionKey)) {
            return;
        }

        Session::put($sessionKey, Carbon::now());

        $career->views++;
        $career->saveQuietly();
    }
}
