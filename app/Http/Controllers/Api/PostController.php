<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller {
    public function index() {
        // recupero dati dal DB
        // $posts = Post::all();

        // recupero dati dal DB e li pagino
        $posts = Post::with(["user", "category", "tags"])->paginate(3);

        // restituisco i dati in formato JSON
        return response()->json($posts);
    }
}
