<?php

namespace Botble\Newsletter\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;
use Botble\Newsletter\Models\Newsletter;

interface NewsletterInterface extends RepositoryInterface
{

    public function subscribe(array $data);
}
