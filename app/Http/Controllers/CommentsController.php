<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    public function __construct() {
        //neautentifikovan user moze samo da vidi listu galerija i galeriju
        $this->middleware('auth:api');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request, $galleryId)
    {
        $newComment = new Comment();
        $newComment->content = $request->input('content');
        $newComment->user_id = auth()->user()->id;
        $newComment->gallery_id = $galleryId;
        $newComment->save();

        $comment = Comment::with('user')->find($newComment->id);
        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Comment::find($id)->delete();
        // $comment->delete();
        // return $comment;
        // return 'Comment has been deleted';
        return response()->json([
            'message' => 'Your comment is deleted!'
        ]);
    }
}
