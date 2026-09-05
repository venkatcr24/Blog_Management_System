@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
<div class="col-md-6 col-lg-5">

    <div class="card shadow-sm">

        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Edit Category</h4>
        </div>


        <div class="card-body">

            <form
                action="{{ route('categories.update', $category) }}"
                method="POST"
            >

                @csrf

                @method('PUT')


                <!-- Category Name -->
                <div class="mb-3">

                    <label
                        for="name"
                        class="form-label"
                    >
                        Category Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $category->name) }}"
                        required
                    >

                    @error('name')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                <!-- Buttons -->
                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Update Category
                    </button>

                    <a
                        href="{{ route('categories.index') }}"
                        class="btn btn-secondary"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

</div>

@endsection