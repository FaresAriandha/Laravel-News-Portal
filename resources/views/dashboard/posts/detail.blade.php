@extends('dashboard.layouts.main')

@section('container')
<div class="container my-5">
  <div class="row">
    <div class="col-lg-8">
      <article>
        <h2 class="fs-1">{{ $post->title }}</h2>
        <div class="container-btn my-3">
          <a href="/dashboard/posts" class="btn btn-primary"><span data-feather="arrow-left" class="align-text-bottom"></span> Back to All My Posts</a>
          <a href="/dashboard/posts/{{ $post->slug }}/edit" class="btn btn-warning"><span data-feather="edit" class="align-text-bottom"></span> Edit</a>
          <form action="{{ route('posts.destroy', $post) }}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button class="btn btn-danger" onclick="return confirm('Are you sure??')">
              <span data-feather="x-circle" class="align-text-bottom"></span> Delete
            </button>
          </form>
        </div>

        @if ($post->image)
          <div style="max-height: 600px" class="overflow-hidden rounded mt-3 mb-5">
            <img src="/img/{{ $post->image }}" class="card-img-top img-fluid" alt="{{ $post->category->name }}">
          </div>
        @else
          <img src="https://source.unsplash.com/random/1200x600?{{ $post->category->name }}" class="card-img-top d-block mt-3 mb-5 rounded img-fluid" alt="{{ $post->category->name }}">
        @endif
        <div class="container fs-5">
          {!! $post->body !!}
        </div>
      </article>
      {{-- <a href="/posts" class="btn btn-primary mt-4">Kembali</a> --}}
    </div>
  </div>
</div>
@endsection