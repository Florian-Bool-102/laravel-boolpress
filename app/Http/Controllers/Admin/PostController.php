<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller {

    public function index() {
        $posts = Post::all();

        return view("admin.posts.index", compact("posts"));
    }

    public function show($slug) {
        $post = Post::where("slug", $slug)->first(); // $post[0]

        return view("admin.posts.show", compact("post"));
    }

    public function create() {
        return view("admin.posts.create");
    }

    public function store(Request $request) {
        $data = $request->validate([
            "title" => "required|max:255",
            "body" => "required",
            "image" => "required|max:255",
        ]);

        // contatore da usare per avere un numero incrementale
        $counter = 0;

        do {
            // creo uno slug e se il counter è maggiore di 0, concateno il counter
            $slug = Str::slug($data["title"]) . ($counter > 0 ? "-" . $counter : "");

            // cerco se esiste già un elemento con questo slug
            $alreadyExists = Post::where("slug", $slug)->first();

            $counter++;
        } while ($alreadyExists); // finché esiste già un elemento con questo slug, ripeto il ciclo per creare uno slug nuovo

        $data["slug"] = $slug;

        // $post = new Post();
        // $post->fill($data);
        // $post->save()

        // Il ::create esegue il fill e il save in un unico comando
        $post = Post::create($data);

        return redirect()->route("admin.posts.show", $post->id);
    }
}
