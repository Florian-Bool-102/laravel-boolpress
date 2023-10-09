@extends('layouts.app')

@section("content")

<div class="container">

  <h1>Lista dei post</h1>

  <div class="bg-light my-2">
    <a href="{{ route('admin.posts.create') }}" class="btn btn-link">Nuovo post</a>
  </div>

  <table class="table">
    <thead>
      <tr>
        <td>Titolo</td>
        <td>Immagine</td>
        <td>Data Pubblicazione</td>
        <td></td>
      </tr>
    </thead>

    <tbody>
      @foreach ($posts as $post)
      <tr>
        <td>{{ $post->title }}</td>
        <td>{{ $post->image }}</td>
        <td>{{ $post->published_at?->format("d/m/Y H:i") }}</td>
        <td>
          <a href="{{ route('admin.posts.show', $post->slug) }}" class="btn btn-info">Dettagli</a>
          <a href="{{ route('admin.posts.edit', $post->slug) }}" class="btn btn-warning">Modifica</a>

          <form action="{{route('admin.posts.destroy', $post->slug)}}" method="POST">
            @csrf()
            @method("DELETE")

            <button class="btn btn-danger">Elimina</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
