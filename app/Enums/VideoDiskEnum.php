<?php

namespace App\Enums;

enum VideoDiskEnum:string
{
    case DISK = 'video_disk';
    case TV_SHOWS = 'tv-shows/';
    case SEASONS = 'seasons/';
    case EPISODES = 'episodes/';
    case PODCASTS = 'podcasts/';
    case SHOUDOUTS = 'shoutouts/';

}
