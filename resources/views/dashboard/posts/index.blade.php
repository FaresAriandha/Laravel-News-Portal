@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">My Posts</h1>
</div>

<div class="container">
  <div class="row">
    <div class="col-lg-10">
      @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="fw-bold">{{ session('success') }}</span>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      <a href="/dashboard/posts/create" class="btn btn-primary my-3">Create new post</a>
      <div class="table-responsive fs-6">
        @if ($posts->count())
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Title</th>
              <th scope="col">Category</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($posts as $post)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $post->title }}</td>
              <td>{{ $post->category->name }}</td>
              <td>
                <a href="/dashboard/posts/{{ $post->slug }}" class="badge bg-info"><span data-feather="eye" class="align-text-bottom"></span></a>
                <a href="/dashboard/posts/{{ $post->slug }}/edit" class="badge bg-warning"><span data-feather="edit" class="align-text-bottom"></span></a>
                {{-- <form action="{{ route('posts.destroy', $post) }}" method="post" class="d-inline p-0">
                  @method('delete')
                  @csrf
                  <button class="badge bg-danger border-0" onclick="return confirm('Are you sure??')">
                    <span data-feather="x-circle" class="align-text-bottom"></span>
                  </button>
                </form> --}}
                <form action="/dashboard/posts/{{ $post->slug }}" method="post" class="d-inline p-0">
                  @method('delete')
                  @csrf
                  <button class="badge bg-danger border-0" onclick="return confirm('Are you sure??')">
                    <span data-feather="x-circle" class="align-text-bottom"></span>
                  </button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @else
          <p class="fs-3 fw-bold">Haven't Post</p>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection