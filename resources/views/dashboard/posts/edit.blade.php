@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Update This Post</h1>
</div>

<div class="col-lg-8 mb-5">
  <form method="post" action="/dashboard/posts/{{ $post->slug }}" enctype="multipart/form-data">
    @method('put')
    @csrf
    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title) }}">
      @error('title')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="slug" class="form-label">Slug</label>
      <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $post->slug) }}">
      @error('slug')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="category_id" class="form-label">Category</label>
      <select class="form-select" name="category_id" id="category_id">
        <option selected disabled>Post Category</option>
        @foreach ($categories as $category)
          @if (old('category_id', $post->category_id) == $category->id)
            <option value="{{ $category->id }}" selected>{{ $category->name }}</option> 
          @else
            <option value="{{ $category->id }}">{{ $category->name }}</option> 
          @endif
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label for="image" class="form-label">Post Image</label>
      <div style="max-height: 400px; max-width: 400px;" class="overflow-hidden rounded my-3">
        <div class="prev-image">
          @if ($post->image)
            <img src="/img/{{ $post->image }}" class="card-img-top img-fluid" alt="{{ $post->category->name }}">
          @else
            <p class="fw-semibold fs-5">This post haven't image</p>
          @endif
        </div>
          <img class="card-img-top img-fluid img-preview d-none">
      </div>
      <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage()">
      @error('image')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="body" class="form-label">Body</label>
      @error('body')
        <p class="text-danger">{{ $message }}</p>
      @enderror
      <input id="body" type="hidden" name="body" value="{{ old('body', $post->body) }}">
      <trix-editor input="body"></trix-editor>
    </div>
    <a href="/dashboard/posts" class="btn btn-danger">Back</a>
    <button type="submit" class="btn btn-primary">Update post</button>
  </form>
</div>

<script>
  const title = document.querySelector('#title');
  const slug = document.querySelector('#slug');

  title.addEventListener('change', function(){
    fetch(`/dashboard/posts/createSlug?title=${title.value}`)
      .then(response => response.json())
      .then(data => slug.value = data.slug);
  })

  document.addEventListener('trix-file-accept', (e)=>e.preventDefault());

  function previewImage(){
    const inputImage = document.querySelector('#image');
    const imgPreview = document.querySelector('.img-preview');
    const prevImage = document.querySelector('.prev-image');
    if (prevImage != null) {
      prevImage.remove();
    }
    
    imgPreview.classList.remove('d-none');
    const oFReader = new FileReader();
    oFReader.readAsDataURL(inputImage.files[0]);
    
    oFReader.onload = function (oFREvent) {
      imgPreview.src = oFREvent.target.result;
    }
  }
</script>
@endsection