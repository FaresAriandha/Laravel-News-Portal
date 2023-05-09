@extends('templates.main')
@section('container')
<div class="container mb-5" style="margin-top:100px">
  <h1 class="mb-5">Post Category</h1>
  <div class="row d-flex justify-content-between flex-wrap">
    @foreach($categories as $category)
    <div class="col-md-4 mb-4">
      <a href="/posts?category={{ $category->slug }}" onmouseover="this.querySelector('p span').style.transform='scale(1.3)'; this.querySelector('p span').style.backgroundColor='rgba(78, 117, 245,.7)'; this.querySelector('p span').style.transition='all 300ms ease'; this.querySelector('img').style.transform='scale(1.1)'; this.querySelector('img').style.transition='all 300ms ease';" onmouseout="this.querySelector('p span').style.backgroundColor='rgba(78, 117, 245,.5)'; this.querySelector('p span').style.transform='scale(1.2)'; this.querySelector('img').style.transform='scale(1)';">
        <div class="card text-bg-dark">
          @if ($category->image)
          <img src="/storage/{{ $category->image }}" class="card-img-top img-fluid" alt="{{ $category->name }}">
          @else
          <img src="https://source.unsplash.com/random/400x400?{{ $category->name }}" class="card-img" alt="{{ $category->name }}">
          @endif
          <div class="card-img-overlay d-flex justify-content-center align-items-center">
            <p class="text-decoration-none"><span class="badge text-light d-inline-block fs-3 text-wrap" style="background-color: rgba(78, 117, 245,.5); backdrop-filter: blur(5px); transform:scale(1.2); width: 250px;">{{ $category->name }}</span></p>
          </div>
        </div>
      </a>
    </div>
    @endforeach
  </div>
</div>
@endsection