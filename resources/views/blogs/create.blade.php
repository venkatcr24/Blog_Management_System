@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
<div class="col-lg-8">

    <div class="card shadow-sm">

        <div class="card-header">
            <h4 class="mb-0">Create Blog</h4>
        </div>

        <div class="card-body">

            <form
                action="{{ route('blogs.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                <!-- Title -->
                <div class="mb-3">

                    <label
                        for="title"
                        class="form-label"
                    >
                        Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}"
                        required
                    >

                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <!-- Content -->
                <div class="mb-3">

                    <label
                        for="content"
                        class="form-label"
                    >
                        Content
                    </label>

                    <textarea
                        name="content"
                        id="content"
                        rows="10"
                        class="form-control @error('content') is-invalid @enderror"
                        required
                    >{{ old('content') }}</textarea>

                    @error('content')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <!-- Category -->
                <div class="mb-3">

                    <label
                        for="category_id"
                        class="form-label"
                    >
                        Category
                    </label>

                    <select
                        name="category_id"
                        id="category_id"
                        class="form-select @error('category_id') is-invalid @enderror"
                        required
                    >

                        <option value="">
                            Select Category
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('category_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <!-- Image -->
                <div class="mb-3">

                    <label
                        for="image"
                        class="form-label"
                    >
                        Featured Image
                    </label>

                    <input
                        type="file"
                        name="image"
                        id="image"
                        class="form-control @error('image') is-invalid @enderror"
                    >

                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <!-- Status -->
                <div class="mb-3">

                    <label
                        for="status"
                        class="form-label"
                    >
                        Status
                    </label>

                    <select
                        name="status"
                        id="status"
                        class="form-select"
                    >

                        <option
                            value="draft"
                            {{ old('status') === 'draft' ? 'selected' : '' }}
                        >
                            Save as Draft
                        </option>

                        <option
                            value="pending"
                            {{ old('status') === 'pending' ? 'selected' : '' }}
                        >
                            Submit for Approval
                        </option>

                    </select>

                </div>


                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Create Blog
                    </button>

                    <a
                        href="{{ route('blogs.index') }}"
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