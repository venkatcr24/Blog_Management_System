@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1>Blogs</h1>

            <p class="text-muted mb-0">
                Discover our latest published blog posts.
            </p>
        </div>

        @auth
            <a
                href="{{ route('blogs.index') }}"
                class="btn btn-primary"
            >
                Manage My Blogs
            </a>
        @endauth

    </div>

    @if(session('success'))

        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert"
        >
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>

    @endif

    <div class="row">

        <div class="col-lg-3 mb-4">

            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Categories</h5>
                </div>

                <div class="list-group list-group-flush">

                    <a
                        href="{{ route('blogs.public') }}"
                        class="list-group-item list-group-item-action
                        {{ !request('category') ? 'active' : '' }}"
                    >
                        All Blogs

                        <span class="badge bg-secondary float-end">
                            {{ $categories->sum('blogs_count') }}
                        </span>
                    </a>

                    @foreach($categories as $category)

                        <a
                            href="{{ route('blogs.public', ['category' => $category->id]) }}"
                            class="list-group-item list-group-item-action
                            {{ request('category') == $category->id ? 'active' : '' }}"
                        >
                            {{ $category->name }}

                            <span class="badge bg-secondary float-end">
                                {{ $category->blogs_count }}
                            </span>
                        </a>

                    @endforeach

                </div>

            </div>

        </div>

        <div class="col-lg-9">

            @if(request('category'))

                @php
                    $selectedCategory = $categories->firstWhere(
                        'id',
                        (int) request('category')
                    );
                @endphp

                @if($selectedCategory)

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div>
                            <h3 class="mb-1">
                                {{ $selectedCategory->name }}
                            </h3>

                            <p class="text-muted mb-0">
                                Blogs in this category
                            </p>
                        </div>

                        <a
                            href="{{ route('blogs.public') }}"
                            class="btn btn-outline-secondary btn-sm"
                        >
                            View All
                        </a>

                    </div>

                @endif

            @endif

            <div class="row g-4">

                @forelse($blogs as $blog)

                    <div class="col-md-6 col-xl-4">

                        <div class="card h-100 shadow-sm">

                            @if($blog->image)

                                <img
                                    src="{{ asset('storage/' . $blog->image) }}"
                                    class="card-img-top"
                                    alt="{{ $blog->title }}"
                                    style="height: 200px; object-fit: cover;"
                                >

                            @else

                                <div
                                    class="bg-light d-flex align-items-center justify-content-center"
                                    style="height: 200px;"
                                >
                                    <span class="text-muted">
                                        No Image
                                    </span>
                                </div>

                            @endif

                            <div class="card-body d-flex flex-column">

                                <h5 class="card-title">
                                    {{ $blog->title }}
                                </h5>

                                <p class="text-muted small mb-2">

                                    By {{ $blog->user->name }}

                                    <br>

                                    Category:
                                    {{ $blog->category->name }}

                                    <br>

                                    {{ $blog->created_at->format('M d, Y') }}

                                </p>

                                <p class="card-text">
                                    {{ Str::limit($blog->content, 150) }}
                                </p>

                                <div class="mt-auto">

                                    <a
                                        href="{{ route('blogs.show', $blog) }}"
                                        class="btn btn-outline-primary btn-sm"
                                    >
                                        Read More
                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-12">

                        <div class="alert alert-info text-center">

                            @if(request('category'))
                                No published blogs available in this category.
                            @else
                                No published blogs available.
                            @endif

                        </div>

                    </div>

                @endforelse

            </div>

            @if($blogs->hasPages())

                <div class="d-flex justify-content-center mt-5">

                    {{ $blogs->withQueryString()->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection