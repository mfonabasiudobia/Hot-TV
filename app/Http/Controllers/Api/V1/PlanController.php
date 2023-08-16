<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PlanRepository;

class PlanController extends Controller
{

    public function index(){
        return $this->success("All Plans", PlanRepository::all());
    }

   
}
