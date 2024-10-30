@extends('layouts.form')
@section('content')
    <style>
        #loading_overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.5);
            z-index: 1000;
        }

        .loading_spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 8px solid transparent;
            border-top-color: #007bff;
            animation: spin 1s infinite linear;
        }

        @keyframes spin {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .iti {
            width: 100% !important;
        }
    </style>
    <section class="booking-formsection">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="booking-section pb-5">
                        {{-- <h1 class="text-white text-center mt-0 mb-0 p-5" style="border-bottom: 2px solid">ENTRY PRICE
                        €100 FOR
                        THE 10 WEEKS
                    </h1> --}}
                        <div id="loading_overlay">
                            <div class="loading_spinner"></div>
                        </div>
                        <form action="{{ route('storeDinnerDanceDetails') }}" method="POST"
                            class="require-validation booking-form mt-3 pb-3" data-cc-on-file="false" id="payment-form">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="alert alert-success mb-5">
                                        <p class="text-color  mb-1 fw-semibold"> 50th Anniversary
                                            Dinner Dance.</p>
                                        <ul>
                                            <li>Saturday 2ND November 2024 Ticket: €60.</li>
                                            <li> Starts 7:30 PM sharp.</li>
                                            <li>3 course dinner plus drinks.</li>
                                            <li>Followed by music by a Few Good Men and DJ till late.</li>
                                            <li><span class="text-color fw-semibold">Address:</span> The Abbeyleix Manor
                                                Hotel, Cork Road, Abbeyleix, Co. Laois, R32 VE24.


                                            </li>

                                        </ul>

                                    </div>
                                </div>
                            </div>


                            <div class="d-flex">
                                <div class="row form-heading1 mt-3">
                                    <h3 class="mt-0 text-white mb-0 d-flex align-items-center">
                                        <span class="pe-4 ps-2"><img src="{{ asset('images/user-vector.png') }}"></span>
                                        Personal
                                        Information
                                    </h3>
                                </div>
                            </div>
                            <div class="row mt-0 pt-1">

                                <div class="col-12 col-sm-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="first_name" class="text-color mb-1 ps-1">First Name:<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                            value="{{ old('first_name') }}" id="first_name" name="first_name"
                                            placeholder="Enter First Name" required>
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="last_name" class="text-color mb-1 ps-1">Last Name:<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                            value="{{ old('last_name') }}" id="last_name" name="last_name"
                                            placeholder="Enter Last Name" required>
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label for="email1" class="text-color mb-1 ps-1">Email Address:<span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" id="email1" name="email"
                                            placeholder="Enter Email" required>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label for="phone" class="text-color mb-1 ps-1">Phone Number:<span
                                                class="text-danger">*</span></label><br>
                                        <input type="text" class="form-control" style="width:100%" name="phone"
                                            id="phone_number" placeholder="Phone Number" required pattern="[0-9+]*"
                                            inputmode="numeric" value="{{ old('phone') }}">
                                        <br>
                                        <span class="text-danger custom-error-message"
                                            style="display: none; font-size:13px">Invalid phone
                                            number. Please enter a valid phone number.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label for="phone" class="text-color mb-1 ps-1">Address:<span
                                                class="text-danger">*</span></label><br>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                                            id="address" name="address" placeholder="Address" required>
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mt-3">
                                        <label for="phone" class="text-color mb-1 ps-1">Dietary Requirements:<span
                                                class="text-danger">*</span></label><br>

                                        <textarea class="form-control" id="dietary_requirements" name="dietary_requirements" rows="3" required></textarea>
                                        @error('dietary_requirements')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="row form-heading1 mt-5">
                                    <h3 class="mt-0 text-white mb-0  d-flex align-items-center">
                                        <span class="pe-4 ps-2"><img src="{{ asset('images/Group-1.png') }}"></span>
                                        Payment Details
                                    </h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-sm-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for ="no_of_tickets" class="text-color">No of Tickets:<span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" name="no_of_tickets" id="no_of_tickets" required>
                                            <option value="" selected disabled>Please Select No Of Tickets</option>
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}" {{ $i == 1 ? 'selected' : '' }}>
                                                    {{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-6 col-md-6">
                                    <div class="form-group mb-3">
                                        <label for ="total_amount" class="text-color">Total Amount:</label>
                                        <input type="text" class="form-control" name="total_amount" id="total_amount"
                                            value="€60" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row py-2">

                                <div class=" col-12 col-sm-12 col-md-6">
                                    <div class='form-group required'>
                                        <label class="control-label text-color mt-3">Name on Card: <span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('card_name') is-invalid @enderror"
                                            value="{{ old('card_name') }}" id="card_name" name="card_name"
                                            placeholder="Cardholder Name" required>
                                        @error('card_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class=" col-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label class="control-label text-color mt-3">Card Details: <span
                                                class="text-danger">*</span></label>
                                        <div class="form-control">
                                            <div id="card-element">
                                            </div>
                                            <div id="card-errors" role="alert"></div>
                                            <!-- <input name="stripeToken" type="hidden" id="stripeToken" value="" /> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 clearfix">
                                <button type="submit" id="submit_button"
                                    class="btn  btn-lg booking-btn1 text-white float-end">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        var elements = stripe.elements();
        var card = elements.create('card', {
            hidePostalCode: true
        });
        card.mount('#card-element');

        var form = document.getElementById('payment-form');
        var submitButton = document.getElementById('submit_button');
        var loadingOverlay = document.getElementById('loading_overlay');

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            submitButton.disabled = true;
            loadingOverlay.style.display = 'block';

            // Create a payment method using the card details
            stripe.createPaymentMethod({
                type: 'card',
                card: card,
            }).then(function(result) {
                if (result.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.error.message,
                    });
                    submitButton.disabled = false;
                    loadingOverlay.style.display = 'none';
                } else {
                    // Collect form data
                    var formData = new FormData(form);
                    formData.append('payment_method', result.paymentMethod.id);

                    fetch('{{ route('storeDinnerDanceDetails') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData,
                        })
                        .then(response => response.json())
                        .then(function(serverResponse) {
                            if (serverResponse.error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: serverResponse.error,
                                });
                                submitButton.disabled = false;
                                loadingOverlay.style.display = 'none';
                            } else if (serverResponse.requires_action) {
                                stripe.confirmCardPayment(serverResponse.payment_intent_client_secret)
                                    .then(function(result) {
                                        if (result.error) {
                                            // Swal.fire({
                                            //     icon: 'error',
                                            //     title: 'Error',
                                            //     text: result.error,
                                            // });
                                            submitButton.disabled = false;
                                            loadingOverlay.style.display = 'none';
                                            window.location.href =
                                                '{{ route('dinnerDance.confirm') }}?payment_intent=' +
                                                serverResponse.payment_intent_id;
                                        } else {
                                            window.location.href =
                                                '{{ route('dinnerDance.confirm') }}?payment_intent=' +
                                                serverResponse.payment_intent_id;
                                        }
                                    });
                            } else {
                                window.location.href = '{{ route('dinnerDanceThankYouPage') }}';
                            }
                        })
                        .catch(function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: error,
                            });
                            submitButton.disabled = false;
                            loadingOverlay.style.display = 'none';
                        });
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $('form.require-validation').bind('submit', function(e) {
                var $form = $(e.target).closest('form'),
                    inputSelector = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'
                    ].join(', '),
                    $inputs = $form.find('.required').find(inputSelector),
                    $errorMessage = $form.find('div.error'),
                    valid = true;
                $errorMessage.addClass('hide');
                $('.has-error').removeClass('has-error');
                $inputs.each(function(i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault(); // cancel on first error
                    }
                });
            });
        });
    </script>
    <script>
        function appendSummaryRow(name, price) {
            let html = ` <div class="row d-flex align-items-center pt-2 me-0">
                                    <div class="col-8 col-md-8 px-4 px-md-5 py-0 py-md-2" style="word-wrap:break:word">
                                        <p class="text-color fw-semibold">${name}</p>
                                    </div>
                                    <div class="col-4 col-md-4 px-0 px-md-5 py-2">
                                        <p class="total-price float-end price-display mb-0">€${price}
                                        </p>

                                    </div>
                                     <hr>
                                </div>`;
            return html;
        }

        function calculateTotal() {
            const children = document.querySelectorAll('.child-row');
            if (children.length > 0) {
                document.querySelector('.summary-container').classList.remove('d-none');
            }
            var total = 0;
            var discount = 0;
            let summaryRow = '';
            document.querySelector('.invoice-container').innerHTML = summaryRow;
            document.getElementById('discount-amount').classList.add('d-none');
            children.forEach((child, index) => {
                const childAcademy = child.querySelector('.child-academy').value;
                const childName = child.querySelector('.child-name').value;
                if (childAcademy) {
                    if (childAcademy == 'U8 and U9 - born 2016 and above') {
                        total += 30;
                        summaryRow = appendSummaryRow(childName, 30);
                        child.querySelector('.price-display').textContent = '€30';
                    }
                    if (childAcademy == 'U10, U11 and U12 - born 2013 to 2015') {
                        total += 70;
                        summaryRow = appendSummaryRow(childName, 70);
                        child.querySelector('.price-display').textContent = '€70';
                    }
                    if (childAcademy == 'U13, U14, U15 and U16 - born 2009 to 2012') {
                        total += 80;
                        summaryRow = appendSummaryRow(childName, 80);
                        child.querySelector('.price-display').textContent = '€80';
                    }
                    if (childAcademy == 'U17 and U18 - born 2007 to 2008') {
                        total += 100;
                        summaryRow = appendSummaryRow(childName, 100);
                        child.querySelector('.price-display').textContent = '€100';
                    }
                    if (childAcademy == 'Senior (adult teams)') {
                        total += 200;
                        summaryRow = appendSummaryRow(childName, 200);
                        child.querySelector('.price-display').textContent = '€200';
                    }
                    if (children.length > 1 && index > 0) {
                        total -= 10;
                        discount += 10;
                    }
                    document.querySelector('.invoice-container').innerHTML += summaryRow;
                }
            });
            if (children.length > 1 && total > 0) {
                document.getElementById('discount-amount').classList.remove('d-none');
                document.getElementById('discount-amount').textContent = 'Discount €10 for each sibling : €' + discount;
            }
            document.getElementById('total_amount').value = total;
            document.getElementById('total-amount-p-tag').textContent = 'Total : €' + total;
            document.getElementById('total-discount').value = discount;
        }
        $(document).ready(function() {
            $('#no_of_tickets').on('change', function(e) {
                e.preventDefault();
                const value = $(this).val();
                $('#total_amount').val('€' + 60 * value);
            })
            $('body').on('click', '.add-child', function(e) {
                e.preventDefault();
                const children = document.querySelectorAll('.child-row').length;
                let row = $('.first-child').clone().first();
                row.removeClass('first-child');
                row.find('input,select').each(function() {
                    $(this).val('');
                    let newname = $(this).attr('name').replace('[0]', `[${children}]`);
                    $(this).attr('name', newname);
                });
                row.find('.price-display').empty();
                row.find('.remove-child').removeClass('d-none');
                row.find('.add-child').removeClass('d-none');
                const addButtons = document.querySelectorAll('.add-child');
                addButtons.forEach(button => {
                    button.classList.add('d-none');
                });
                $('.child-section').append(row);


            })
            $('body').on('click', '.remove-child', function(e) {
                e.preventDefault();
                $(this).parent().parent().remove();
                var addButton = document.querySelectorAll('.add-child');
                if (addButton.length > 0) {
                    addButton = addButton[addButton.length - 1]; // Get the last element
                    addButton.classList.remove('d-none');
                }
                calculateTotal();
            })
            $('body').on('change', '.child-academy', function(e) {
                e.preventDefault();
                calculateTotal();
                const summaryHeading = document.getElementById('summary-heading');
                summaryHeading.classList.remove('d-none');
                summaryHeading.classList.add('d-block');
            })
            $('body').on('blur', '.child-name', function(e) {
                e.preventDefault();
                calculateTotal();
            })
        })
    </script>
@endsection
