@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
<div>
    <h1>Categories</h1>

    <p class="text-muted mb-0">
        Manage blog categories.
    </p>
</div>

<a
    href="{{ route('categories.create') }}"
    class="btn btn-primary"
>
    + Add Category
</a>

</div> <div class="card shadow-sm">
<div class="card-body">

    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead class="table-dark">

                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Blogs</th>
                    <th>Actions</th>
                </tr>

            </thead>

            <tbody>

                @forelse($categories as $category)

                    <tr>

                        <td>
                            {{ $category->id }}
                        </td>

                        <td>
                            {{ $category->name }}
                        </td>

                        <td>
                            <span class="badge bg-secondary">
                                {{ $category->blogs->count() }}
                            </span>
                        </td>

                        <td>

                            <div class="d-flex gap-2">

                                <a
                                    href="{{ route('categories.edit', $category) }}"
                                    class="btn btn-sm btn-primary"
                                >
                                    Edit
                                </a>


                                <form
                                    action="{{ route('categories.destroy', $category) }}"
                                    method="POST"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                    >
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="4"
                            class="text-center text-muted"
                        >
                            No categories found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</div>

@endsection