<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostUpsertRequest;
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

    public function store(PostUpsertRequest $request) {
        $data = $request->validated();

        $data["slug"] = $this->generateSlug($data["title"]);

        // $post = new Post();
        // $post->title = $data["title"];
        // $post->fill($data);
        // $post->save()

        // Il ::create esegue il fill e il save in un unico comando
        $post = Post::create($data);

        return redirect()->route("admin.posts.show", $post->slug);
    }

    public function edit($slug) {
        $post = Post::where("slug", $slug)->firstOrFail();

        return view("admin.posts.edit", compact("post"));
    }

    public  function update(PostUpsertRequest $request, $slug) {
        $data = $request->validated();
        $post = Post::where("slug", $slug)->firstOrFail();

        // controllo se il titolo è cambiato. Solo in quel caso rigenero lo slug
        if ($data["title"] !== $post->title) {
            $data["slug"] = $this->generateSlug($data["title"]);
        }

        $data["is_published"] = boolval($data["is_published"]);

        // dd($data);

        // se la checkbox è spuntata, il server riceve il valore di "is_published"
        // se la checkbox non è spuntata, il server non riceve il valore di "is_published"
        // if (isset($data["is_published"])) {
        if ($data["is_published"]) {
            $post->is_published = true;
            $post->published_at = now();
            // $post->save();
        } else {
            $post->is_published = false;
            $post->published_at = null;
            // $post->save();
        }

        $post->update($data);

        return redirect()->route("admin.posts.show", $post->slug);
    }

    public function destroy($slug) {
        $post = Post::where("slug", $slug)->firstOrFail();

        $post->delete();

        return redirect()->route("admin.posts.index");
    }

    protected function generateSlug($title) {
        // contatore da usare per avere un numero incrementale
        $counter = 0;

        do {
            // creo uno slug e se il counter è maggiore di 0, concateno il counter
            $slug = Str::slug($title) . ($counter > 0 ? "-" . $counter : "");

            // cerco se esiste già un elemento con questo slug
            $alreadyExists = Post::where("slug", $slug)->first();

            $counter++;
        } while ($alreadyExists); // finché esiste già un elemento con questo slug, ripeto il ciclo per creare uno slug nuovo

        return $slug;
    }
}
