@extends('layouts.app')

@section("content")

<div class="container">
  <h1>Aggiorna post</h1>

  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ route('admin.posts.update', $post->slug) }}" method="POST">
    @csrf()
    @method("PATCH")

    <div class="mb-3"><label class="form-label" for="title_input">Titolo</label><input type="text" class="form-control" name="title" id="title_input" value="{{ $post->title }}"></div>
    <div class="mb-3"><label class="form-label">Immagine</label><input type="text" class="form-control" name="image" value="{{ $post->image }}"></div>
    <div class="mb-3"><label class="form-label">Contenuto</label><textarea class="form-control" name="body">{{ $post->body }}</textarea></div>
    <div class="mb-3">
      <div class="form-check">
        {{-- Barbatrucco per inviare un dato false nel caso in cui la checkbox non sia selezionata --}}
        <input type="hidden" name="is_published" value="0">
        <input class="form-check-input" type="checkbox" name="is_published" id="is_published_input" {{ $post->is_published ? 'checked' : '' }}
                value="1">
        <label class="form-check-label" for="is_published_input">
          Pubblicato
        </label>
      </div>
    </div>

    <button class="btn btn-primary">Aggiorna</button>
  </form>
</div>

@endsection
