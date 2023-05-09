@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Create New Category</h1>
</div>

<div class="col-lg-8 mb-5">
  <form method="post" action="/dashboard/categories" enctype="multipart/form-data">
    @csrf 
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" >
      @error('name')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>
    <div class="mb-3">
      <label for="slug" class="form-label">Slug</label>
      <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}" >
      @error('slug')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="image" class="form-label">Post Category</label>
      <div style="max-width: 400px; max-height: 400px;"  class="overflow-hidden rounded img-box border-0">
        <img class="card-img-top img-fluid img-preview">
      </div>
      <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage()">
      @error('image')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
      @enderror
    </div>

    <div class="mt-5">
      <a href="/dashboard/categories" class="btn btn-danger">Back</a>
      <button type="submit" class="btn btn-primary ms-2">Create category</button>
    </div>
  </form>
</div>

<script>
  const name = document.querySelector('#name');
  const slug = document.querySelector('#slug');
  
  name.addEventListener('change', function(){
    fetch(`/dashboard/categories/createSlug?name=${name.value}`)
    .then(response => response.json())
    .then(data => slug.value = data.slug);
  })
  
  function previewImage(){
    const inputImage = document.querySelector('#image');
    const imgPreview = document.querySelector('.img-preview');
    const imgBox = document.querySelector('.img-box');
    imgBox.classList.add('my-3');
    
    const oFReader = new FileReader();
    oFReader.readAsDataURL(inputImage.files[0]);
    
    oFReader.onload = function (oFREvent) {
      imgPreview.src = oFREvent.target.result;
    }
  }
</script>
@endsection