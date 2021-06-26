<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\Image;
use App\Http\Requests\GalleryRequest;
use Illuminate\Http\Request;

class GalleriesController extends Controller
{
    public function __construct() {
        //neautentifikovan user moze samo da vidi listu galerija i galeriju
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $term = $request->input('term');
        // return Gallery::search($term);
        $userId = $request->input('id'); //dovukla sam id od usera
        // dd($userId);
        //da mi dovuce userove galerije
        if($userId) {
            return Gallery::where('user_id', $userId)->with(['images', 'user'])->latest()->paginate(10);
        }
        return Gallery::with(['images', 'user'])->latest()->paginate(10);
        
    }

    // public function search() {}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GalleryRequest $request)
    {
        $gallery = new Gallery();
        $gallery->title = $request->input('title');
        $gallery->description = $request->input('description');
        $gallery->user_id = auth()->user()->id;
        $gallery->save();
        
        //u $imagesRequest stavljam slike koje je user uneo preko inputa
        $imagesRequest = $request->input('images');
        $images = []; //prazan niz $images u koji cu smestati unete slike

        //prolazimo kroz niz $imagesRequest koji je definisan kao niz u GalleryRequest.php i uzimamo svaku sliku posebno
        foreach($imagesRequest as $image) {
            $newImage = new Image($image); //pravimo instancu Image klase(modela)
            $images[] = $newImage; //i tu sliku stavljamo u prazan niz $images koji prikazujemo u galeriji
        }

        $gallery->images()->saveMany($images);
        return $gallery;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        return $gallery->load(['images', 'user', 'comments', 'comments.user']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(GalleryRequest $request, Gallery $gallery)
    {
        $gallery->update(
            $request->only('title', 'description')
        );
        return $gallery;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $gallery->delete();
        // return $gallery;
        Gallery::find($id)->delete();
        return response()->json([
            'message' => 'Your gallery is deleted!'
        ]);
    }
}
