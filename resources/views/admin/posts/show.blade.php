@extends('layouts.app')

@section("content")

<div class="container">
  <h1>{{ $post->title }}</h1>
  <small>Data pubblicazione: {{ $post->published_at?->format("d/m/Y H:i") }}</small>

  <img src="{{ $post->image }}" alt="" class="img-fluid">

  <p>{{ $post->body }}</p>
</div>

@endsection
