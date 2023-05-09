@extends('templates.main')

@section('container')
    <h1 class="mb-4 text-center" style="margin-top: 80px">{{ $title }}</h1>
    <div class="row justify-content-center mb-4">
      <div class="col-md-6">
        <form action="/posts" method="get">
          @if(request('category'))
            <input type="hidden" name="category" value="{{ request('category') }}">
          @endif

          @if(request('author'))
            <input type="hidden" name="author" value="{{ request('author') }}">
          @endif
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search..." name="search" value="{{ request('search') }}">
            <button class="btn btn-danger" type="submit" id="button-addon2">Search</button>
          </div>
        </form>
      </div>
    </div>
    @if ($posts->count())
    {{-- @dd($posts) --}}
    <div class="card mb-3 position-relative pb-3">
      <a href="/posts?category={{ $posts[0]->category->slug }}" class="text-decoration-none"><span class="badge text-light d-inline-block position-absolute ms-2 mt-2 fs-6" style="background-color: rgba(78, 117, 245,.5);backdrop-filter: blur(5px);" onmouseover="this.style.backgroundColor='rgba(78, 117, 245,.7)'; this.style.transition='background 300ms ease'" onmouseout="this.style.backgroundColor='rgba(78, 117, 245,.5)'">{{ $posts[0]->category->name }}</span></a>
        @if ($posts[0]->image)
          <div style="max-height: 400px" class="overflow-hidden rounded">
            <img src="/img/{{ $posts[0]->image }}" class="card-img-top img-fluid" alt="{{ $posts[0]->category->name }}">
          </div>
        @else
          <img src="https://source.unsplash.com/random/1200x400?{{ $posts[0]->category->name }}" class="card-img-top" alt="{{ $posts[0]->category->name }}">
        @endif
        <div class="card-body text-center">
          <a href="/posts/{{ $posts[0]->slug }}" class="text-decoration-none text-dark"><h3 class="card-title">{{ $posts[0]->title }}</h3></a>
          <p>
            <small class="text-muted">By <a href="/posts?author={{ $posts[0]->author->username }}" class="text-decoration-none">{{ $posts[0]->author->name }}</a> in <a href="/posts?category={{ $posts[0]->category->slug }}" class="text-decoration-none">{{ $posts[0]->category->name }}</a> {{ $posts[0]->created_at->diffForHumans() }}</small>
          </p>
          <p class="card-text">{{ $posts[0]->excerpt }}</p>
          <a href="/posts/{{ $posts[0]->slug }}" class="text-decoration-none btn btn-primary">Read More</a>
        </div>
      </div>
      
      <div class="container mt-5">
      <div class="row d-flex flex-wrap">
        @foreach ($posts->skip(1) as $post)
        <div class="col-md-4">
          <div class="card mb-3 pb-3 position-relative">
            <a href="/posts?category={{ $post->category->slug }}" class="text-decoration-none"><span class="badge text-light d-inline-block position-absolute ms-2 mt-2 fs-6" style="background-color: rgba(78, 117, 245,.5); backdrop-filter: blur(5px);" onmouseover="this.style.backgroundColor='rgba(78, 117, 245,.7)'; this.style.transition='background 300ms ease'" onmouseout="this.style.backgroundColor='rgba(78, 117, 245,.5)'">{{ $post->category->name }}</span></a>
            @if ($post->image)
            <img src="/img/{{ $post->image }}" class="card-img-top img-fluid" alt="{{ $post->category->name }}">
            
            @else
              <img src="https://source.unsplash.com/random/500x400?{{ $post->category->name }}" class="card-img-top" alt="{{ $post->category->name }}">
            @endif
            
            <div class="card-body text-center">
              <p class="text-dark"><h3 class="card-title">{{ $post->title }}</h3></p>
              <p>
                <small class="text-muted">By <a href="/posts?author={{ $post->author->username }}" class="text-decoration-none">{{ $post->author->name }}</a> {{ $post->created_at->diffForHumans() }}</small>
              </p>
              <p class="card-text">{{ $post->excerpt }}</p>
              <a href="/posts/{{ $post->slug }}" class="text-decoration-none btn btn-primary">Read More</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @else
      <p class="text-center fs-4">No post found.</p>
    @endif
    <div class="container my-4 d-flex justify-content-center">
      <div class="row">
        {{ $posts->links() }}
      </div>
    </div>
    @endsection