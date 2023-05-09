@extends('templates.main')

@section('container')
    <div class="row vh-100 d-flex align-items-center justify-content-center overflow-hidden">
      <div class="col-lg-5">
        @if (session()->has('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="fw-bold">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @elseif(session()->has('loginError'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="fw-bold">{{ session('loginError') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @elseif(session()->has('not_login'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="fw-bold">{{ session('not_login') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        <main class="form-signin w-100 mb-3">
          <h1 class="h2 mb-4 fw-semibold text-center fs-2">Please Login</h1>
          <form action="/login" method="post">
            @csrf
            <div class="form-floating">
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" autofocus required>
              <label for="email">Email</label>
              @error('email')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
            </div>
            <div class="form-floating">
              <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password" required>
              <label for="password">Password</label>
              @error('password')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
            </div>
      
            <button class="w-100 btn btn-lg btn-danger mt-4" type="submit">Login</button>
          </form>
        </main>
        
        <span class="fs-5 mt-2 d-flex align-items-center justify-content-center">Login With<a href="{{ route('google.redirect') }}" class="d-inline-block ms-2"><img src="img/google.png" width="28" height="28"></a></span>
        <small class="d-block mt-3 text-center">Not registered ? <a href="/register" class="text-decoration-none">Register Now!</a></small>
      </div>
    </div>
@endsection