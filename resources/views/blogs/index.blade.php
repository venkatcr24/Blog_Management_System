@extends('layouts.app')

@section('content')

<div class="container py-4">
{{-- Header --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

    <div>
        @if(auth()->user()->role === 'admin')
            <h1 class="mb-1">All Blogs</h1>
            <p class="text-muted mb-0">Manage all user blog posts.</p>
        @else
            <h1 class="mb-1">My Blogs</h1>
            <p class="text-muted mb-0">Manage your blog posts.</p>
        @endif
    </div>

    <div class="d-flex flex-wrap gap-2">

        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
            Public Blogs
        </a>

        <a href="{{ route('blogs.create') }}" class="btn btn-primary">
            + Create Blog
        </a>

    </div>

</div>


{{-- Success Message --}}
@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show" role="alert">

        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
        ></button>

    </div>

@endif


{{-- Error Message --}}
@if(session('error'))

    <div class="alert alert-danger alert-dismissible fade show" role="alert">

        {{ session('error') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
        ></button>

    </div>

@endif


{{-- Blog Cards --}}
<div class="row g-4">

    @forelse($blogs as $blog)

        <div class="col-12 col-md-6 col-lg-4">

            <div class="card h-100 shadow-sm border-0">

                {{-- Image --}}
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

                    {{-- Title --}}
                    <h5 class="card-title">
                        {{ $blog->title }}
                    </h5>


                    {{-- Blog Information --}}
                    <p class="text-muted small mb-2">

                        By {{ $blog->user->name }}

                        <br>

                        Category:
                        {{ $blog->category->name }}

                        <br>

                        {{ $blog->created_at->format('M d, Y') }}

                    </p>


                    {{-- Status --}}
                    <div class="mb-3">

                        @if($blog->status === 'published')

                            <span class="badge bg-success">
                                Published
                            </span>

                        @elseif($blog->status === 'pending')

                            <span class="badge bg-warning text-dark">
                                Pending Approval
                            </span>

                        @elseif($blog->status === 'draft')

                            <span class="badge bg-secondary">
                                Draft
                            </span>

                        @elseif($blog->status === 'rejected')

                            <span class="badge bg-danger">
                                Rejected
                            </span>

                        @else

                            <span class="badge bg-dark">
                                {{ ucfirst($blog->status) }}
                            </span>

                        @endif

                    </div>


                    {{-- Content --}}
                    <p class="card-text text-muted">

                        {{ Str::limit($blog->content, 150) }}

                    </p>


                    {{-- Actions --}}
                    <div class="mt-auto pt-3 border-top">

                        <div class="d-flex flex-wrap gap-2">

                            {{-- View --}}
                            <a
                                href="{{ route('blogs.show', $blog) }}"
                                class="btn btn-sm btn-outline-primary"
                            >
                                View
                            </a>


                            {{-- Edit --}}
                            @if(
                                auth()->user()->role === 'admin' ||
                                auth()->id() === $blog->user_id
                            )

                                <a
                                    href="{{ route('blogs.edit', $blog) }}"
                                    class="btn btn-sm btn-outline-warning"
                                >
                                    Edit
                                </a>


                                {{-- Delete --}}
                                <form
                                    action="{{ route('blogs.destroy', $blog) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this blog?');"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                    >
                                        Delete
                                    </button>

                                </form>

                            @endif

                        </div>


                        {{-- Admin Actions --}}
                        @if(
                            auth()->user()->role === 'admin' &&
                            $blog->status === 'pending'
                        )

                            <div class="d-flex flex-wrap gap-2 mt-2">

                                {{-- Approve --}}
                                <form
                                    action="{{ route('blogs.approve', $blog) }}"
                                    method="POST"
                                    class="d-inline"
                                >

                                    @csrf

                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-success"
                                    >
                                        Approve
                                    </button>

                                </form>


                                {{-- Reject --}}
                                <form
                                    action="{{ route('blogs.reject', $blog) }}"
                                    method="POST"
                                    class="d-inline"
                                >

                                    @csrf

                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                    >
                                        Reject
                                    </button>

                                </form>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    @empty

        {{-- Empty State --}}
        <div class="col-12">

            <div class="alert alert-info text-center py-5">

                @if(auth()->user()->role === 'admin')

                    <h5>No blogs available</h5>

                    <p class="mb-0">
                        There are currently no blogs in the system.
                    </p>

                @else

                    <h5>You have not created any blogs yet</h5>

                    <p class="mb-3">
                        Create your first blog post to get started.
                    </p>

                    <a
                        href="{{ route('blogs.create') }}"
                        class="btn btn-primary"
                    >
                        Create Blog
                    </a>

                @endif

            </div>

        </div>

    @endforelse

</div>


{{-- Pagination --}}
@if($blogs->hasPages())

    <div class="d-flex justify-content-center mt-5">

        {{ $blogs->links() }}

    </div>

@endif

</div>

@endsection