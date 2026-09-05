@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
<div class="col-lg-9">

    <div class="card shadow-sm">

        @if($blog->image)

            <img
                src="{{ asset('storage/' . $blog->image) }}"
                class="card-img-top"
                style="max-height: 450px; object-fit: cover;"
                alt="{{ $blog->title }}"
            >

        @endif


        <div class="card-body">

            <h1 class="card-title">
                {{ $blog->title }}
            </h1>


            <div class="text-muted mb-3">

                By
                <strong>
                    {{ $blog->user->name }}
                </strong>

                |

                {{ $blog->category->name }}

                |

                {{ $blog->created_at->format('M d, Y') }}

            </div>


            @if($blog->status === 'published')

                <span class="badge bg-success">
                    Published
                </span>

            @elseif($blog->status === 'pending')

                <span class="badge bg-warning text-dark">
                    Pending Approval
                </span>

            @elseif($blog->status === 'rejected')

                <span class="badge bg-danger">
                    Rejected
                </span>

            @else

                <span class="badge bg-secondary">
                    Draft
                </span>

            @endif


            <hr>


            <div class="mt-4">

                {!! nl2br(e($blog->content)) !!}

            </div>


            <!-- Actions -->
            <div class="mt-4 d-flex gap-2">

                @can('update', $blog)

                    <a
                        href="{{ route('blogs.edit', $blog) }}"
                        class="btn btn-primary"
                    >
                        Edit
                    </a>

                @endcan


                @can('delete', $blog)

                    <form
                        action="{{ route('blogs.destroy', $blog) }}"
                        method="POST"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger"
                        >
                            Delete
                        </button>

                    </form>

                @endcan


                @can('approve', $blog)

                    @if($blog->status === 'pending')

                        <form
                            action="{{ route('blogs.approve', $blog) }}"
                            method="POST"
                        >

                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="btn btn-success"
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
                                class="btn btn-warning"
                            >
                                Reject
                            </button>

                        </form>

                    @endif

                @endcan

            </div>

        </div>

    </div>

</div>

</div>

@endsection