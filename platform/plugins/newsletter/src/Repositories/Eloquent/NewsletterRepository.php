<?php

namespace Botble\Newsletter\Repositories\Eloquent;

use Botble\Newsletter\Repositories\Interfaces\NewsletterInterface;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;

class NewsletterRepository extends RepositoriesAbstract implements NewsletterInterface
{

    public function subscribe($data){
        // $model = $this->model;

        // return $model::create($data);
        dd(33);
    }
}
