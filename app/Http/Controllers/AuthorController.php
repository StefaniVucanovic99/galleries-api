<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AuthorController extends Controller
{
    public function show($id) {
        // dd('dfjdkj');
        //dovlacimo sve galerije autora       (, 'galleries.comments')
        return User::with(['galleries', 'galleries.images'])->find($id);
    }
}
