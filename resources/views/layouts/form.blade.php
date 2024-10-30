<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Naomh Columba') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <link href="{{ asset('css/style.css') }}?v={{ time() }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
</head>

<body>
    <div id="app" style="overflow-x: hidden">
        <main class="pb-0 pt-0" style="overflow-x: hidden">
            @include('layouts.header')
            @yield('content')
            {{-- @include('layouts.top-footer') --}}
            @include('layouts.footer')
        </main>
    </div>
    {{-- <script>
        $(document).ready(function() {
            $("#quantity").keyup(function() {
                var quantity1 = parseFloat($(this).val());
                if (!isNaN(quantity1)) {
                    var result = quantity1 * 100;

                    $("#total_amount").val(result);
                } else {
                    $("#total_amount").val("Invalid input");
                }
            });
        });
    </script> --}}
    <script type="text/javascript">
        $(document).ready(function() {
            @if (Session::has('error'))
                // toastr.error('{{ Session::get('error') }}');
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: '{{ Session::get('error') }}',
                    timer: 5000,
                    confirmButtonText: 'Ok',
                })
            @endif
            @if (Session::has('success'))
                // toastr.success('{{ Session::get('success') }}');
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ Session::get('success') }}',
                    timer: 5000,
                    confirmButtonText: 'Ok',
                })
            @endif
            @if (session('warning'))
                // toastr.warning("{{ session('warning') }}");
                Swal.fire({
                    position: 'top-end',
                    icon: 'warning',
                    title: '{{ Session::get('warning') }}',
                    showConfirmButton: false,
                    timer: 5000
                })
            @endif
            @if (session('errors'))
                var errors = "";
                @foreach (array_values(session('errors')->messages()) as $err)
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
    <script>
        $(document).ready(function() {
            const phoneInputField = $("#phone_number");
            const phoneInput = window.intlTelInput(phoneInputField[0], {
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                initialCountry: "pk", // Sets Pakistan as the default country
                onlyCountries: ["pk"],
                separateDialCode: true,
                nationalMode: false,
            });

            const customErrorMessage = $('.custom-error-message');
            const submitButton = $('#submit_button');

            $("#phone_number").on("blur", function() {
                const isValid = phoneInput.isValidNumber();
                const formattedNumber = phoneInput.getNumber(intlTelInputUtils.numberFormat.E164);
                if (!isValid) {
                    customErrorMessage.show();
                    submitButton.attr('disabled', true);
                } else {
                    customErrorMessage.hide();
                    $(this).val(formattedNumber);
                    submitButton.attr('disabled', false);
                }
            });

            const form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                const isValid = phoneInput.isValidNumber();
                if (!isValid) {
                    event.preventDefault();
                    $("#phone_number").addClass('is-invalid');
                    customErrorMessage.show();
                    submitButton.attr('disabled', true);
                }
            });
        });
        document.getElementById('quantity').addEventListener('change', function() {
            var selectedValue = this.value;
            var totalAmount = selectedValue ? selectedValue * 100 : '';
            document.getElementById('total_amount').value = totalAmount;
        });
    </script>
</body>

</html>
