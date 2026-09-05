@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
<div class="col-md-6 col-lg-5">

    <div class="card shadow-sm">

        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Login</h4>
        </div>

        <div class="card-body">

            <form
                action="{{ route('login.authenticate') }}"
                method="POST"
            >

                @csrf


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
                        autofocus
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
                        class="form-control"
                        required
                    >

                </div>


                <button
                    type="submit"
                    class="btn btn-dark w-100"
                >
                    Login
                </button>

            </form>

        </div>

        <div class="card-footer text-center">

            Don't have an account?

            <a href="{{ route('register') }}">
                Register
            </a>

        </div>

    </div>

</div>

</div>

@endsection