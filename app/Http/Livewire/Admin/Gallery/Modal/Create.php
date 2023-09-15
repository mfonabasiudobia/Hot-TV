<?php

namespace App\Http\Livewire\Admin\Gallery\Modal;

use Livewire\Component;
use App\Http\Traits\Filterable;
use App\Models\Gallery;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use AppHelper;

class Create extends Component
{

    public $uploadedFile, $show = false, $uniqueid;
    use Filterable, WithFileUploads, WithPagination;

    protected $listeners = ['openGallery']; 


    public function openGallery($detail = null){
        $this->show = true;
        $this->dispatchBrowserEvent('trigger-file-modal');
        $this->uniqueid = $detail;
    }

    public function removeFile(){
        $this->reset(['uploadedFile']);
    }

    public function uploadImage(){

            $this->validate(["uploadedFile" => "required"]);


            Gallery::create([
                'url' => AppHelper::uploadFile($this->uploadedFile, 'files'),
                'type' => 'external',
                'mime_type' => $this->uploadedFile->getMimeType(),
                'size' => $this->uploadedFile->getSize(),
                'name' => $this->uploadedFile->getClientOriginalName(),
                'alt' => $this->uploadedFile->getClientOriginalName(),
                'user_id' => 0
            ]);


            toast()->success("File has been uploaded")->push();

            $this->reset(['uploadedFile']);
            $this->show = true;

      }


    public function render()
    {

        $files = $this->sort(Gallery::query())->paginate(20);

        return view('livewire.admin.gallery.modal.create', ['files' => $files]);
    }
}
