@extends('templates.main')
@section('container')
    <h1>Post Category : {{ $category }}</h1>
    @foreach ($posts as $p)
        <article class="mt-5">
          <h2><a href="/posts/{{ $p->slug }}" class="text-decoration-none">{{ $p->title }}</a></h2>
          <p>By <a href="/#" class="text-decoration-none">{{ $p->user->name }}</a> in <a href="/categories/{{ $p->category->slug }}" class="text-decoration-none">{{ $p->category->name }}</a></p>
          <p>{{ $p->excerpt }}</p>
          <a href="/posts/{{ $p->slug }}" class="text-decoration-none d-block">Read More</a>
        </article>
    @endforeach
@endsection