<?php

namespace App\Http\Traits;

trait Filterable{

    public $sortByDeletedItems;
    public $sortByDate;
    public $sortByLatest;
    public $sortByImageCategory;
    public $sortByLatestWithPricePopularity;
    public $sortByYear;

    public function sort($model){
      

        if($this->sortByLatest){
            $model->orderBy("created_at",$this->sortByLatest);
        }else{
            $model->orderBy('created_at', 'desc');
        }


        if($this->sortByYear){
            $model->whereYear("created_at",$this->sortByYear);
        }

        if($this->sortByDeletedItems){
            if($this->sortByDeletedItems == "all"){
                $model->withTrashed();
            }

            if($this->sortByDeletedItems == "trash"){
                $model->onlyTrashed();
            }
        }


        if($this->sortByDate){
             $dateArray = explode("to",$this->sortByDate);

             if(isset($dateArray[0])){
                $model->whereDate("created_at",">=",$dateArray[0]);//$dateArray[0] means From i.e first selected date in the date range
             }

             if(isset($dateArray[1])){
                $model->whereDate("created_at","<=",$dateArray[1]);//$dateArray[1] means to i.e second selected date in the date range
             }
             
        }

        if($this->sortByImageCategory){
            $model->where("category",$this->sortByImageCategory);
        }


        if($this->sortByLatestWithPricePopularity == 'asc'){
            $model->orderBy("created_at",'asc');
        }

        if($this->sortByLatestWithPricePopularity == 'desc'){
            $model->orderBy("created_at",'desc');
        }

        if($this->sortByLatestWithPricePopularity == 'lh'){
            $model->orderBy("regular_price",'asc');
        }

        if($this->sortByLatestWithPricePopularity == 'hl'){
            $model->orderBy("regular_price",'desc');
        }


        


        return $model;
    }

}
