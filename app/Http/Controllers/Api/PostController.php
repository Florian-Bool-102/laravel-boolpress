<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller {
    public function index() {
        // leggo le query string ricevute
        $queryString = request()->query();

        // recupero dati dal DB
        // $posts = Post::all();

        // recupero dati dal DB e li pagino
        $query = Post::with(["user", "category", "tags"]);

        // se queryString ha la chiave title, aggiungo questo filtro nella query
        if (array_key_exists("title", $queryString) && $queryString["title"]) {
            $query->where("title", "LIKE", "%{$queryString["title"]}%");
        }

        $posts = $query->paginate();
        // $posts = Post::with(["user", "category", "tags"])->get();

        // restituisco i dati in formato JSON
        return response()->json($posts);
    }

    public function show($slug) {
        $post = Post::where("slug", $slug)
            // recupera le informazioni delle relazioni
            ->with(["user", "category", "tags"])
            // ritorna il primo risultato
            ->first();

        if (!$post) {
            abort(404);
        }

        return response()->json($post);
    }
}
