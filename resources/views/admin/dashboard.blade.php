@extends('layouts.app')

@section('content')

<div class="container">
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1>Admin Dashboard</h1>
        <p class="text-muted mb-0">
            Manage blogs, categories and post approvals.
        </p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="row g-4 mb-4">

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Pending Posts</h6>
                <h2 class="mb-0">
                    {{ $pendingBlogs->count() }}
                </h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Admin Actions</h6>

                <a
                    href="{{ route('blogs.index') }}"
                    class="btn btn-primary btn-sm mt-2"
                >
                    Manage Blogs
                </a>

                <a
                    href="{{ route('categories.index') }}"
                    class="btn btn-secondary btn-sm mt-2"
                >
                    Manage Categories
                </a>
            </div>
        </div>
    </div>

</div>

<div class="card shadow-sm">

    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">
            Posts Awaiting Approval
        </h4>
    </div>

    <div class="card-body">

        @forelse($pendingBlogs as $blog)

            <div class="border rounded p-3 mb-3">

                <div class="row align-items-center">

                    <div class="col-md-8">

                        <h5 class="mb-1">
                            {{ $blog->title }}
                        </h5>

                        <p class="text-muted mb-2">

                            By {{ $blog->user->name }}

                            |

                            {{ $blog->category->name }}

                            |

                            {{ $blog->created_at->format('M d, Y') }}

                        </p>

                        <p class="mb-2">
                            {{ Str::limit($blog->content, 180) }}
                        </p>

                        <span class="badge bg-warning text-dark">
                            Pending Approval
                        </span>

                    </div>

                    <div class="col-md-4">

                        <div class="d-flex flex-wrap gap-2 justify-content-md-end mt-3 mt-md-0">

                            <a
                                href="{{ route('blogs.show', $blog) }}"
                                class="btn btn-outline-primary btn-sm"
                            >
                                View
                            </a>

                            <form
                                action="{{ route('blogs.approve', $blog) }}"
                                method="POST"
                            >

                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="btn btn-success btn-sm"
                                >
                                    Approve
                                </button>

                            </form>

                            <form
                                action="{{ route('blogs.reject', $blog) }}"
                                method="POST"
                            >

                                @csrf
                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                >
                                    Reject
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="alert alert-success mb-0">
                There are no posts waiting for approval.
            </div>

        @endforelse

    </div>

</div>

</div>

@endsection