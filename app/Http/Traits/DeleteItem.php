<?php

namespace App\Http\Traits;

trait DeleteItem{

    public $key = 5;

    public function trashDelete(array $detail){
        $data = (object) $detail;
        $data->model::destroy($data->id);
        toast()->success("Item has been deleted")->push(); 
        $this->key =  rand(0, 100); //refresh table by assigning new key to livewire

        $this->emit('refresh');
    }

    public function forceDelete(array $detail){
        $data = (object) $detail;
        $data->model::withTrashed()->find($data->id)->forceDelete();
        toast()->success("Item has been deleted")->push(); 
        $this->key =  rand(0, 100); //refresh table by assigning new key to livewire
    }

    public function restoreTrash(array $detail){
        $data = (object) $detail;
        $data->model::onlyTrashed()->find($data->id)->restore();
        toast()->success("Item has been deleted")->push(); 
        $this->key =  rand(0, 100); //refresh table by assigning new key to livewire
    }

    public function refreshKey(){
        $this->key = rand(0, 1000);
    }

}
