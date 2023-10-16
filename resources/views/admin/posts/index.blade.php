@extends('layouts.app')

@section("content")

<div class="container">

  <h1>Lista dei post</h1>

  @if(Auth::user()->role->name === 'admin')
  <div class="bg-light my-2">
    <a href="{{ route('admin.posts.create') }}" class="btn btn-link">Nuovo post</a>
  </div>
  @endif

  <table class="table">
    <thead>
      <tr>
        <td>Titolo</td>
        <td>Immagine</td>
        <td>Categoria</td>
        <td>Data Pubblicazione</td>
        <td></td>
      </tr>
    </thead>

    <tbody>
      @foreach ($posts as $post)
      <tr>
        <td>{{ $post->title }}</td>
        <td><img src={{ asset('/storage/' . $post->image) }} class="img-thumbnail" style="width: 60px"></td>

        <td><span class="badge" style="background-color: rgb({{ $post->category->color }})">{{ $post->category->name }}</span></td>

        <td>{{ $post->published_at?->format("d/m/Y H:i") }}</td>
        <td class="text-nowrap text-end">
          <a href="{{ route('admin.posts.show', $post->slug) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>

          @if(Auth::user()->role->name === 'admin')
          <a href="{{ route('admin.posts.edit', $post->slug) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>

          <form action="{{route('admin.posts.destroy', $post->slug)}}" method="POST" class="d-inline-block">
            @csrf()
            @method("DELETE")

            <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
          </form>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="d-flex justify-content-center">
    {{ $posts->links() }}
  </div>
</div>
@endsection
