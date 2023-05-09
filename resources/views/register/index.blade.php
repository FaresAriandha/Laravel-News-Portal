@extends('templates.main')

@section('container')
    <div class="row vh-100 d-flex align-items-center justify-content-center overflow-hidden">
      <div class="col-lg-5">
        <main class="form-registration w-100">
          <h1 class="h2 mb-4 fw-semibold text-center fs-2">Register Form</h1>
          <form action="/register" method="post">
            @csrf

            <div class="form-floating">
              <input type="text" class="form-control rounded-top @error('name') is-invalid @enderror" id="name" name="name" placeholder="Your Name" value="{{ old('name') }}" required autofocus>
              <label for="name">Name</label>
              @error('name')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
            </div>
            <div class="form-floating">
              <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Your Username" value="{{ old('username') }}" required>
              <label for="username">Username</label>
              @error('username')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
            </div>
            <div class="form-floating">
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required>
              <label for="email">Email</label>
              @error('email')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
            </div>
            <div class="form-floating">
              <input type="password" class="form-control rounded-bottom @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password" required>
              <label for="password">Password</label>
              @error('password')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
            </div>
      
            <button class="w-100 btn btn-lg btn-danger mt-4" type="submit">Register</button>
          </form>
        </main>

        <small class="d-block mt-3 text-center">Already registered ? <a href="/login" class="text-decoration-none">Login</a></small>
      </div>
    </div>
@endsection