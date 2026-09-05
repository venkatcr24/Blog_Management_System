<!DOCTYPE html> <html lang="en"> <head>
<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>
    {{ $title ?? 'Blog Management System' }}
</title>

<!-- Bootstrap 5.2.3 CSS -->
<link
    rel="stylesheet"
    href="{{ asset('bootstrap/css/bootstrap.min.css') }}"
>

</head> <body class="bg-light">
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <div class="container">

        <!-- Brand -->
        <a
            class="navbar-brand"
            href="{{ route('home') }}"
        >
            Blog Management
        </a>


        <!-- Mobile Toggle Button -->
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarContent"
            aria-controls="navbarContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>


        <!-- Navbar Content -->
        <div
            class="collapse navbar-collapse"
            id="navbarContent"
        >

            <!-- Left Side -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                @auth

                    <!-- Dashboard -->
                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('dashboard') }}"
                        >
                            Dashboard
                        </a>

                    </li>


                    <!-- Blogs -->
                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('blogs.index') }}"
                        >
                            Blogs
                        </a>

                    </li>


                    <!-- Admin Dashboard -->
                    @if(auth()->user()->role === 'admin')

                        <li class="nav-item">

                            <a
                                class="nav-link"
                                href="{{ route('admin.dashboard') }}"
                            >
                                Admin Dashboard
                            </a>

                        </li>

                    @endif

                @endauth

            </ul>


            <!-- Right Side -->
            <ul class="navbar-nav">

                @auth

                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">

                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="userDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            {{ auth()->user()->name }}
                        </a>


                        <ul
                            class="dropdown-menu dropdown-menu-end"
                            aria-labelledby="userDropdown"
                        >

                            <!-- User Role -->
                            <li>

                                <span class="dropdown-item-text">

                                    Role:

                                    <strong>
                                        {{ ucfirst(auth()->user()->role) }}
                                    </strong>

                                </span>

                            </li>


                            <li>
                                <hr class="dropdown-divider">
                            </li>


                            <!-- Logout -->
                            <li>

                                <form
                                    action="{{ route('logout') }}"
                                    method="POST"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="dropdown-item"
                                    >
                                        Logout
                                    </button>

                                </form>

                            </li>

                        </ul>

                    </li>

                @else

                    <!-- Login -->
                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('login') }}"
                        >
                            Login
                        </a>

                    </li>


                    <!-- Register -->
                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('register') }}"
                        >
                            Register
                        </a>

                    </li>

                @endauth

            </ul>

        </div>

    </div>

</nav>


<!-- Main Content -->
<main class="container py-4">

    <!-- Success Message -->
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


    <!-- Error Message -->
    @if(session('error'))

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
        >

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>

        </div>

    @endif


    <!-- Validation Errors -->
    @if($errors->any())

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
        >

            <strong>
                Please fix the following errors:
            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>


            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>

        </div>

    @endif


    <!-- Page Content -->
    @yield('content')

</main>


<!-- Bootstrap 5.2.3 JavaScript -->
<script
    src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"
></script>

</body> 
</html>