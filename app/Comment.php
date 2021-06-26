<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content' , 'user_id', 'gallery_id'
    ];

    //relacije
    public function gallery() {
        return $this->belongsTo(Gallery::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
