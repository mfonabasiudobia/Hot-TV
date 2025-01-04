<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class VerificationDocument extends Model
{
    use HasFactory;

    protected $appends = ['disk_path'];

    protected $fillable = [ 'user_id', 'filename', 'path', 'disk'];

    public function getDiskPathAttribute()
    {
        return Storage::disk($this->disk)->url($this->path);
    }
}
