@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
<div>
    <h1>Dashboard</h1>

    <p class="text-muted mb-0">
        Welcome back, {{ auth()->user()->name }}.
    </p>
</div>

<a
    href="{{ route('blogs.create') }}"
    class="btn btn-primary"
>
    Create Blog
</a>

</div> <div class="row">
<div class="col-md-4">

    <div class="card shadow-sm">

        <div class="card-body">

            <h5 class="card-title">
                Your Account
            </h5>

            <p class="mb-1">
                <strong>Name:</strong>
                {{ auth()->user()->name }}
            </p>

            <p class="mb-0">
                <strong>Role:</strong>

                <span class="badge bg-secondary">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </p>

        </div>

    </div>

</div>


<div class="col-md-4">

    <div class="card shadow-sm">

        <div class="card-body">

            <h5 class="card-title">
                Blogs
            </h5>

            <p class="text-muted">
                Create and manage your blog posts.
            </p>

            <a
                href="{{ route('blogs.index') }}"
                class="btn btn-outline-primary"
            >
                View Blogs
            </a>

        </div>

    </div>

</div>

</div>

@endsection