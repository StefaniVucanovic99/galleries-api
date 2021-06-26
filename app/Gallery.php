<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\GalleryRequest;
use App\Image;

class Gallery extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'user_id'
    ];

    //relacije
    public function images() {
        return $this->hasMany(Image::class); //galerija ima vise slika
    }

    public function user() {
        return $this->belongsTo(User::class); //jedna galerija pripada jednom useru
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    // public static function search($term = '', $user = null) {
    //     // dd($term);
    //     $query = Gallery::query();
    //     $query->with(['user', 'images']);

    //     if($user) {
    //         $query->where('user_id', $user);
    //     }

    //     if($term) {

    //         $query->where('title', 'like', '%' . $term . '%')
    //             ->orWhere('description', 'like', '%' . $term . '%')
    //             ->orWhereHas('user', function($q) use ($term){  
    //                 $q->where('first_name', 'like', '%' . $term . '%')
    //                 ->orWhere('last_name', 'like', '%' . $term . '%');
    //         });
    //     }

    //     $galleries = $query->orderBy('created_at','desc')
    //         ->paginate(10);
    //     return compact("galleries");
    // }
}
