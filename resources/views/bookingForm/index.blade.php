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
                    <div class="booking-section um-booking-section">
                        {{-- <h1 class="text-white text-center mt-0 mb-0 p-5" style="border-bottom: 2px solid">ENTRY PRICE
                        €100 FOR
                        THE 10 WEEKS
                    </h1> --}}
                        <div id="loading_overlay">
                            <div class="loading_spinner"></div>
                        </div>
                        <div class="booking-form mb-5">
                            <div class="banner-section1">
                                <div class="row">
                                    <div class="col-12">
                                        <h2
                                            class=" pb-1 mt-0 fw-semibold mb-0 fs-40 text-center banner-text text-uppercase">
                                            50th
                                            Anniversary </h2>
                                        <h4 class="text-center my-0 fs-32 fw-semibold fst-italic text-white">Dinner Dance
                                            Tickets
                                        </h4>
                                    </div>
                                </div>
                                <div class="row event-info">

                                    <div class="col-12  col-md-4 col-lg-4 text-center pt-3 pt-md-0">
                                        <div
                                            class="card bg-transparent border-0 rounded-0 location-info h-100 text-center pt-3">
                                            <h2 class="text-center heading-color fs-48 mt-3 mb-0 fw-bold">Saturday</h2>
                                            <h2 class="text-center heading-color fs-48 mt-3 mb-0 fw-bold">2ND</h2>
                                            <h3 class="text-white text-cnter mb-3 mt-0 fw-bold fs-32">November 2024</h3>
                                            <h2 class="text-center text-white fw-bold my-0 text-uppercase">Ticket: <span
                                                    class="fst-italic">€60</span></h2>
                                        </div>
                                    </div>
                                    <div
                                        class="col-12  col-md-4 col-lg-4 text-center ps-3 ps-md-0 pe-3 pe-md-0 pt-3 pt-md-0">
                                        <div
                                            class="card bg-transparent location-info border-0 rounded-0 h-100 text-center pt-2 pe-3">
                                            <span class="text-center"><svg xmlns="http://www.w3.org/2000/svg" width="4rem"
                                                    height="4rem" viewBox="0 0 20 20">
                                                    <path fill="#851619"
                                                        d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m-.93 5.581a.7.7 0 0 0-.698.698v5.581c0 .386.312.698.698.698h5.581a.698.698 0 1 0 0-1.395H9.767V6.279a.7.7 0 0 0-.697-.698" />
                                                </svg></span>
                                            <p class="text-center text-white fs-20 fw-normal text-uppercase mb-0 pt-3 pb-3">
                                                starts
                                            </p>

                                            <p class="text-center text-white fs-20  text-uppercase drink-info">
                                              <span class="fw-bold"> 7:30 PM</span>  Sharp<br>
                                                3 course dinner plus drinks</p>
                                                <p class=" text-center text-white  fst-italic fs-20  drink-info text-uppercase  fw-bold"><span
                                                class="fst-normal">Followed by music by a Few Good Men and DJ till late
                                        </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4 text-center pt-3 pt-md-0">
                                        <div class="card bg-transparent border-0  rounded-0 h-100 text-center">
                                            <span class="text-center"> <svg xmlns="http://www.w3.org/2000/svg"
                                                    width="5rem" height="5rem" viewBox="0 0 256 256">
                                                    <path fill="#851619"
                                                        d="M200 224h-49.46A267 267 0 0 0 174 200.25c27.45-31.57 42-64.85 42-96.25a88 88 0 0 0-176 0c0 31.4 14.51 64.68 42 96.25A267 267 0 0 0 105.46 224H56a8 8 0 0 0 0 16h144a8 8 0 0 0 0-16M56 104a72 72 0 0 1 144 0c0 57.23-55.47 105-72 118c-16.53-13-72-60.77-72-118m112 0a40 40 0 1 0-40 40a40 40 0 0 0 40-40m-64 0a24 24 0 1 1 24 24a24 24 0 0 1-24-24" />
                                                </svg></span>
                                            <p class="text-center text-white fs-20 fw-normal text-uppercase mb-0 pt-3 pb-3">
                                                Address
                                            </p>
                                            <p class="text-center text-white fs-24">The Abbeyleix Manor Hotel Cork Road,
                                                Abbeyleix, Co. Laois, R32 VE24
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center pt-5">
                                        
                                        <div class="px-5">

                                            <a href="{{ route('dinner.dance') }}" type="button"
                                                class="btn fs-20 text-danger action-btn"
                                                style="background-color: #E7F122;">Click Here to Get Dinner Dance Tickets
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="booking-form um-membership">
                            <div class="banner-section">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class=" pb-1 mt-0 fw-semibold mb-0 fs-40 text-center text-white text-uppercase">
                                            Medical Care & Physiotherapy Clinic Membership </h2>
                                        {{-- <h4 class="text-center my-0 fs-32 fw-semibold fst-italic text-white">Dinner Dance
                                            Tickets Membership
                                        </h4> --}}
                                    </div>
                                </div>
                                <div class="row event-info d-flex justify-content-center">

                                    {{-- <div class="col-12  col-md-4 col-lg-4 text-center pt-3 pt-md-0">
                                        <div
                                            class="card bg-transparent border-0 rounded-0 location-info h-100 text-center pt-3">
                                            <h2 class="text-center text-white fs-48 mt-3 mb-0 fw-bold">2ND</h2>
                                            <h3 class="text-white text-cnter mb-3 mt-0 fw-bold fs-32">November 2024</h3>
                                            <h2 class="text-center text-white fw-bold my-0 text-uppercase">Ticket: <span
                                                    class="fst-italic">€60</span></h2>
                                        </div>
                                    </div>
                                    <div
                                        class="col-12  col-md-4 col-lg-4 text-center ps-3 ps-md-0 pe-3 pe-md-0 pt-3 pt-md-0">
                                        <div
                                            class="card bg-transparent location-info border-0 rounded-0 h-100 text-center pt-2 pe-3">
                                            <span class="text-center"><svg xmlns="http://www.w3.org/2000/svg" width="4rem"
                                                    height="4rem" viewBox="0 0 20 20">
                                                    <path fill="white"
                                                        d="M10 0c5.523 0 10 4.477 10 10s-4.477 10-10 10S0 15.523 0 10S4.477 0 10 0m-.93 5.581a.7.7 0 0 0-.698.698v5.581c0 .386.312.698.698.698h5.581a.698.698 0 1 0 0-1.395H9.767V6.279a.7.7 0 0 0-.697-.698" />
                                                </svg></span>
                                            <p class="text-center text-white fs-20 fw-normal text-uppercase mb-0 pt-3 pb-3">
                                                starts
                                            </p>

                                            <p class="text-center text-white fs-20  text-uppercase drink-info">Drinks
                                                reception at <span class="fw-bold"> 6:30 PM</span> on arrival followed by a
                                                3-course dinner plus wine</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4 text-center pt-3 pt-md-0">
                                        <div class="card bg-transparent border-0  rounded-0 h-100 text-center">
                                            <span class="text-center"> <svg xmlns="http://www.w3.org/2000/svg"
                                                    width="5rem" height="5rem" viewBox="0 0 256 256">
                                                    <path fill="white"
                                                        d="M200 224h-49.46A267 267 0 0 0 174 200.25c27.45-31.57 42-64.85 42-96.25a88 88 0 0 0-176 0c0 31.4 14.51 64.68 42 96.25A267 267 0 0 0 105.46 224H56a8 8 0 0 0 0 16h144a8 8 0 0 0 0-16M56 104a72 72 0 0 1 144 0c0 57.23-55.47 105-72 118c-16.53-13-72-60.77-72-118m112 0a40 40 0 1 0-40 40a40 40 0 0 0 40-40m-64 0a24 24 0 1 1 24 24a24 24 0 0 1-24-24" />
                                                </svg></span>
                                            <p class="text-center text-white fs-20 fw-normal text-uppercase mb-0 pt-3 pb-3">
                                                Address
                                            </p>
                                            <p class="text-center text-white fs-24">Abbeyleix Manor<br>Hotel</p>
                                        </div>
                                    </div> --}}
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-8">
                                        <div class="table-responsive">
                                            <table class="table text-white table-bordered um-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="um-age-group">Age Group</th>
                                                        <th scope="col" class="um-birth-year">Birth Year</th>
                                                        <th scope="col" class="um-fee">Fee (€)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Academy (U8 and U9)</td>
                                                        <td>2016 and above</td>
                                                        <td>30</td>
                                                    </tr>
                                                    <tr>
                                                        <td>U10 - U12</td>
                                                        <td>2013 to 2015</td>
                                                        <td>70</td>
                                                    </tr>
                                                    <tr>
                                                        <td>U13 - U16</td>
                                                        <td>2009 to 2012</td>
                                                        <td>80</td>
                                                    </tr>
                                                    <tr>
                                                        <td>U17 - U18</td>
                                                        <td>2007 to 2008</td>
                                                        <td>100</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Senior</td>
                                                        <td>2006 and earlier</td>
                                                        <td>200</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center pt-5">
                                        <p class="text-white text-center fw-normal fst-italic fs-20 px-4"><span
                                                class="fw-bold fst-normal">Note: </span> There is a discount of €10 for
                                            each
                                            additional sibling registered with the club.
                                        </p>
                                        <div class="px-5 um-btn">

                                            <a href="{{ route('clover.united.registeration') }}" type="button"
                                                class="btn fs-20 text-danger action-btn"
                                                style="background-color: #E7F122;">Click here to register and pay your Medical Care & Physiotherapy Clinic Membership</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
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
                                window.location.href = '{{ route('thankYou') }}';
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
