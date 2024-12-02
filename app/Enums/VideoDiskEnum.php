<?php

namespace App\Enums;

enum VideoDiskEnum:string
{
    case DISK = 's3';
    case TV_SHOWS = 'tv-shows/';
    case SEASONS = 'seasons/';
    case EPISODES = 'episodes/';
    case PODCASTS = 'podcasts/';
    case SHOUDOUTS = 'shoutouts/';

}
