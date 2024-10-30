<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Medical Care & Physiotherapy Clinic') }}</title>

    <!-- CSS Libraries -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">


    <!-- Custom Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script> <!-- Remove defer -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>

    <!-- Custom Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
        $(document).ready(function() {
            $(".mobile-menu").on("click", function() {
                $(".menu-section").toggle(700);
            });
        });
    </script>
</head>



<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Welcome to Medical Care & Physiotherapy Clinic
                </a>
                <div class="menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </nav>


        <div class="container-fluid main-dashboard">
            <div class="row flex-nowrap">
                <div class="col-12 col-sm-3 col-md-3 col-lg-2  px-sm-2 px-0 bg-light menu-section">
                    <div class="d-flex flex-column align-items-center align-items-sm-start  text-white min-vh-100">
                        <a href="/"
                            class="d-flex align-items-center pb-2 mb-md-0 me-md-auto text-white text-decoration-none"
                            data-toggle="tooltip" title="http://127.0.0.1:8000/home">
                            <span class="fs-5 text-success pt-3">
                                <img src="{{ asset('images/logo.png') }}" class="img-fluid" width="100px"
                                    height="120px" alt="logo image">
                            </span>
                        </a>
                        <hr class="bg-success mx-0 my-0" style="width: 100%;height:1.5px">

                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 pt-2 align-items-center align-items-sm-start"
                            id="menu">

                            @if(Auth::user()->type == 'admin')


                            <li>
                                <a href="{{ route('bookings') }}" class="nav-link px-0 align-middle py-0">
                                    <i class="fs-4 bi-table"></i> <span class="ms-1  text-success"><i
                                            class="fas fa-sign-in-alt"></i>
                                        &nbsp;Appointments</span></a>
                            </li>

                            <li>
                                <a href="{{ route('medicines') }}" class="nav-link px-0 align-middle py-0">
                                    <i class="fs-4 bi-table"></i> <span class="ms-1  text-success"><i
                                            class="fas fa-sign-in-alt"></i>
                                        &nbsp;Medicines</span></a>
                            </li>
                            <li>
                                <a href="{{ route('labs') }}" class="nav-link px-0 align-middle py-0">
                                    <i class="fs-4 bi-table"></i> <span class="ms-1  text-success"><i
                                            class="fas fa-sign-in-alt"></i>
                                        &nbsp;Labs</span></a>
                            </li>
                            @endif

                            @if(Auth::user()->type == 'doctor')
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link align-middle px-0 py-0">
                                    <i class="fs-4 bi-house"></i> <span class="ms-1 text-success"><i
                                            class="fa fa-home"></i>
                                        &nbsp;Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('bookings') }}" class="nav-link px-0 align-middle py-0">
                                    <i class="fs-4 bi-table"></i> <span class="ms-1  text-success"><i
                                            class="fas fa-sign-in-alt"></i>
                                        &nbsp;Appointments</span></a>
                            </li>
                            @endif
                        </ul>
                        <hr>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-9 col-lg-10 px-0 dashboard-content">

                    @yield('content')

                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript">
    $(document).ready(function() {
        @if(Session::has('error'))
        // toastr.error('{{ Session::get('error') }}');
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: '{{ Session::get('
            error ') }}',
            timer: 5000,
            confirmButtonText: 'Ok',
        })
        @endif
        @if(Session::has('success'))
        // toastr.success('{{ Session::get('success') }}');
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: '{{ Session::get('
            success ') }}',
            timer: 5000,
            confirmButtonText: 'Ok',
        })
        @endif
        @if(session('warning'))
        // toastr.warning("{{ session('warning') }}");
        Swal.fire({
            position: 'top-end',
            icon: 'warning',
            title: '{{ Session::get('
            warning ') }}',
            showConfirmButton: false,
            timer: 5000
        })
        @endif
        @if(session('errors'))
        var errors = "";
        @foreach(array_values(session('errors') -> messages()) as $err)
        errors += "{{ $err[0] }}<br />";
        @endforeach
        // toastr.error(errors);
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: errors,
            showConfirmButton: false,
            timer: 5000
        })
        @endif
    });
</script>
<script type="text/Javascript">
    $(document).ready(function(){
        $('#entries-table').DataTable();

    })
</script>

<script>
    $(document).ready(function() {
        $('.resend-email-btn').click(function() {
            let ticketId = $(this).data('ticket-id');
            let ticketType = $(this).data('ticket-type');
            let url = "{{ route('resendEmail') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    ticketId: ticketId,
                    ticketType: ticketType,
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Email Resent!',
                        text: response.message,
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON ? xhr.responseJSON.message : 'An error occurred. Please try again.',
                    });
                }
            });
        });
    });
</script>

@yield('scripts');

</html>