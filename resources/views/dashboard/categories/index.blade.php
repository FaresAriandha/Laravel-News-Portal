@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Post Categories</h1>
</div>

<div class="container">
  <div class="row">
    <div class="col-lg-6">
      @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="fw-bold">{{ session('success') }}</span>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      <a href="/dashboard/categories/create" class="btn btn-primary my-3">Create new category</a>
      <div class="table-responsive fs-6">
        <table class="table table-striped">
          <thead>
            <tr class="text-center">
              <th scope="col">#</th>
              <th scope="col">Category Name</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($categories as $category)
            <tr>
              <td class="text-center">{{ $loop->iteration }}</td>
              <td>{{ $category->name }}</td>
              <td class="text-center">
                <a href="/dashboard/categories/{{ $category->slug }}/edit" class="badge bg-warning"><span data-feather="edit" class="align-text-bottom"></span></a>
                {{-- <form action="{{ route('posts.destroy', $category) }}" method="category" class="d-inline p-0">
                  @method('delete')
                  @csrf
                  <button class="badge bg-danger border-0" onclick="return confirm('Are you sure??')">
                    <span data-feather="x-circle" class="align-text-bottom"></span>
                  </button>
                </form> --}}
                <form action="/dashboard/categories/{{ $category->slug }}" method="post" class="d-inline p-0">
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
      </div>
    </div>
  </div>
</div>
@endsection