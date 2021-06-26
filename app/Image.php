<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Gallery;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'gallery_id'
    ];

    //jedna slika pripada jednoj galeriji
    public function gallery() {
        return $this->belongsTo(Gallery::class, gallery_id);
    }
}
