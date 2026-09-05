@extends('layouts.app')

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-8">

        <div class="card shadow-sm">

            <div class="card-header bg-dark text-white">

                <h4 class="mb-0">
                    Edit Blog
                </h4>

            </div>


            <div class="card-body">

                <form
                    action="{{ route('blogs.update', $blog) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf

                    @method('PUT')


                    {{-- Title --}}

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
                            value="{{ old('title', $blog->title) }}"
                            required
                        >

                        @error('title')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Content --}}

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
                        >{{ old('content', $blog->content) }}</textarea>

                        @error('content')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Category --}}

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
                                    {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}
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


                    {{-- Current Image --}}

                    @if($blog->image)

                        <div class="mb-3">

                            <label class="form-label">
                                Current Image
                            </label>

                            <div>

                                <img
                                    src="{{ asset('storage/' . $blog->image) }}"
                                    alt="{{ $blog->title }}"
                                    class="img-thumbnail"
                                    style="max-width: 250px;"
                                >

                            </div>

                        </div>

                    @endif


                    {{-- New Image --}}

                    <div class="mb-3">

                        <label
                            for="image"
                            class="form-label"
                        >
                            Change Image
                        </label>

                        <input
                            type="file"
                            name="image"
                            id="image"
                            class="form-control @error('image') is-invalid @enderror"
                        >

                        <div class="form-text">
                            Leave empty to keep the current image.
                        </div>

                        @error('image')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Status --}}

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
                            class="form-select @error('status') is-invalid @enderror"
                        >

                            <option
                                value="draft"
                                {{ old('status', $blog->status) === 'draft' ? 'selected' : '' }}
                            >
                                Draft
                            </option>

                            <option
                                value="pending"
                                {{ old('status', $blog->status) === 'pending' ? 'selected' : '' }}
                            >
                                Submit for Approval
                            </option>


                            @if(auth()->user()->role === 'admin')

                                <option
                                    value="published"
                                    {{ old('status', $blog->status) === 'published' ? 'selected' : '' }}
                                >
                                    Published
                                </option>

                                <option
                                    value="rejected"
                                    {{ old('status', $blog->status) === 'rejected' ? 'selected' : '' }}
                                >
                                    Rejected
                                </option>

                            @endif

                        </select>

                        @error('status')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Buttons --}}

                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Update Blog
                        </button>


                        <a
                            href="{{ route('blogs.show', $blog) }}"
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