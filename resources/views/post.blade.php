@extends('templates.main')
@section('container')
{{-- <h1>Halaman {{ $pageType }}</h1> --}}
  <div class="container mb-5" style="margin-top: 100px">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <article>
          <h2 class="fs-1">{{ $post->title }}</h2>
          <p>By <a href="/posts?author={{ $post->author->username }}" class="text-decoration-none">{{ $post->author->name }}</a> in <a href="/posts?category={{ $post->category->slug }}" class="text-decoration-none">{{ $post->category->name }}</a></p>
          @if ($post->image)
            <div style="max-height: 600px" class="overflow-hidden rounded mt-3 mb-5">
              <img src="/img/{{ $post->image }}" class="card-img-top img-fluid" alt="{{ $post->category->name }}">
            </div>
          @else
            <img src="https://source.unsplash.com/random/1200x600?{{ $post->category->name }}" class="card-img-top d-block mt-3 mb-5 rounded img-fluid" alt="{{ $post->category->name }}">
          @endif
          {!! $post->body !!}
        </article>
        <a href="/posts" class="btn btn-primary mt-4">Kembali</a>
      </div>
    </div>
  </div>
@endsection