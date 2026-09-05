@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
<div class="col-md-6 col-lg-5">

    <div class="card shadow-sm">

        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Create Account</h4>
        </div>

        <div class="card-body">

            <form
                action="{{ route('register.store') }}"
                method="POST"
            >

                @csrf


                <!-- Name -->
                <div class="mb-3">

                    <label
                        for="name"
                        class="form-label"
                    >
                        Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        required
                    >

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <!-- Email -->
                <div class="mb-3">

                    <label
                        for="email"
                        class="form-label"
                    >
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        required
                    >

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <!-- Password -->
                <div class="mb-3">

                    <label
                        for="password"
                        class="form-label"
                    >
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required
                    >

                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <!-- Confirm Password -->
                <div class="mb-3">

                    <label
                        for="password_confirmation"
                        class="form-label"
                    >
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="form-control"
                        required
                    >

                </div>


                <button
                    type="submit"
                    class="btn btn-dark w-100"
                >
                    Register
                </button>

            </form>

        </div>

        <div class="card-footer text-center">

            Already have an account?

            <a href="{{ route('login') }}">
                Login
            </a>

        </div>

    </div>

</div>

</div>

@endsection