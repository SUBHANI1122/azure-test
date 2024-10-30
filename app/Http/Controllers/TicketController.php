<?php

namespace App\Http\Controllers;

use App\Mail\InstallmentAuthenticationRequiredMail;
use App\Mail\InstallmentFailed;
use App\Models\Installment;
use App\Models\Ticket;
use App\Models\TicketDetail;
use App\Notifications\ReceiptNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Stripe\Exception\CardException;
use Stripe\Stripe;
use PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use Stripe\PaymentIntent;
use Illuminate\Support\Str;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\OAuth\InvalidRequestException;
use Stripe\PaymentMethod;
use App\Mail\InstallmentSuccess;
use App\Mail\TicketFullyPaid;
use App\Models\Appoinment;
use App\Models\User;
use App\Notifications\InvoiceFailedNotification;
use Illuminate\Support\Facades\App;
use Stripe\SetupIntent;
use Stripe\Subscription;
use Stripe\SubscriptionSchedule;


class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('bookingForm.index');
    }
    public function cloverUnitedIndex()
    {
        return view('bookingForm.clover-united-form');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function searchPatient(Request $request)
    {
        $phone = $request->get('phone');
        $patient = User::where('type', 'patient')->where('phone', $phone)->first();

        if ($patient) {
            return response()->json([
                'success' => true,
                'patient' => [
                    'name' => $patient->name,
                    'email' => $patient->email,
                    'phone' => $patient->phone,
                    'address' => $patient->address,
                    'age' => $patient->age,
                ]
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Patient not found.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
            'doctor_id' => 'required',
            'department_id' => 'required',
            'age' => 'required',
            'amount' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors());
        }

        $patient = User::firstOrCreate(
            ['phone' => $request->phone],
            [
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'type' => 'patient',
                'age' => $request->age
            ]
        );
        $procedure_amount = $request->procedure_amount ?? 0;

        $total_amount =  $procedure_amount + $request->amount;

        // Create a new appointment record
        Appoinment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'procedure_amount' =>  $procedure_amount,
            'procedure_name' => $request->procedure_name ?? 'N/A',
            'amount' => $request->amount,
            'total_amount' => $total_amount,
            'appointment_date' => now()
        ]);

        $doctor = User::findOrFail($request->doctor_id);

        // Prepare invoice data
        $invoiceData = [
            'patient_name' => $patient->name,
            'doctor_name' => User::find($request->doctor_id)->name,
            'appointment_date' => now()->toDateString(),
            'total_amount' => $total_amount,
            'amount' => $request->amount,
            'procedure_amount' =>  $procedure_amount,
            'procedure_name' => $request->procedure_name ?? 'N/A',
            'age' => $request->age,
            'department' => $request->department_id,
        ];

        // Pass data to a view for the invoice
        return view('bookingForm.thermal_invoice', compact('invoiceData'));
    }



    // Function to schedule 3 installments
    protected function scheduleInstallments($ticket, $customerId)
    {
        try {
            $productID = env('STRIPE_INSTALLMENT_PRODUCT_ID');
            $product = \Stripe\Product::retrieve($productID);

            $ticket = Ticket::find($ticket->id);

            if (!$ticket) {
                throw new Exception('Ticket not found.');
            }

            $installmentAmount = $ticket->installment_amount;

            $price = \Stripe\Price::create([
                'unit_amount' => round($installmentAmount * 100),
                'currency' => 'eur',
                'product' => $productID,
                'recurring' => [
                    'interval' => 'day',
                    'interval_count' => 1,
                ],
            ]);

            Log::info('Scheduling installments for ticket ID: ' . $ticket->id);
            $nextDay = Carbon::now()->timestamp;

            $subscription = \Stripe\SubscriptionSchedule::create([
                'customer' => $customerId,
                'start_date' => $nextDay,
                'end_behavior' => 'cancel',
                'phases' => [
                    [
                        'items' => [
                            [
                                'price' => $price->id,
                                'quantity' => 1,
                            ],
                        ],
                        'iterations' => 3,
                        'proration_behavior' => 'none',
                    ],
                ],
                'metadata' => [
                    'description' => '3 installment payments for ticket #' . $ticket->id,
                    'total_amount' => $ticket->total_amount,
                    'installment_amount' => $installmentAmount,
                    'iterations' => 3,
                    'ticket_id' => $ticket->id,
                    'product_name' => $product->name,
                ],
            ]);
            $subscriptionScheduleId = $subscription->id;
            for ($i = 1; $i <= 3; $i++) {
                $dueDate = now()->addDays($i)->toDateTimeString();
                $installment = $ticket->installments()->create([
                    'amount' => $ticket->installment_amount,
                    'due_date' => $dueDate,
                    'status' => 'pending',
                    'stripe_subscription_id' => $subscriptionScheduleId
                ]);
                Log::info('Created installment:', [
                    'installment_id' => $installment->id,
                    'amount' => $installment->amount,
                    'due_date' => $installment->due_date,
                    'status' => $installment->status,
                    'stripe_subscription_id' => $installment->stripe_subscription_id
                ]);
            }

            // $ticket->status = 'initial_paid';
            // $ticket->save();
            Log::info('Updated ticket status to initial_paid for ticket ID: ' . $ticket->id);
        } catch (ApiErrorException $e) {
            Log::error('Stripe API error: ' . $e->getMessage());
        } catch (Exception $e) {
            Log::error('Error processing ticket installments: ' . $e->getMessage());
        }
    }

    public function confirm(Request $request)
    {

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentIntentId = $request->input('payment_intent');

        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            if ($paymentIntent->status == 'succeeded') {
                $ticketId = $paymentIntent->metadata->ticket_id;
                $ticket = Ticket::find($ticketId);
                $customerId = $paymentIntent->customer;
                if ($ticket->remaining_amount > 0 || $ticket->installment_amount > 0 || $ticket->initial_payment > 0) {
                    // Ticket::where('id', $ticketId)->update(['status' => 'partially_paid']);
                    $ticket->update(['status' => 'partially_paid']);
                } else {
                    // Ticket::where('id', $ticketId)->update(['status' => 'paid']);
                    $ticket->update(['status' => 'paid']);
                }
                if ($ticket->remaining_amount > 0 || $ticket->installment_amount > 0 || $ticket->initial_payment > 0) {
                    $this->scheduleInstallments($ticket, $customerId);
                }
                $charge = Charge::retrieve($paymentIntent->latest_charge);
                if (App::environment('staging')) {
                    FacadesNotification::route('mail', 'atasam.imtiaz@moebotech.com')->notify(new ReceiptNotification($ticket, $charge->receipt_url));
                } elseif (App::environment('production')) {
                    FacadesNotification::route('mail', 'hello@cloverunited.ie')->notify(new ReceiptNotification($ticket, $charge->receipt_url));
                    FacadesNotification::route('mail', 'saqib.umair@moebotech.com')->notify(new ReceiptNotification($ticket, $charge->receipt_url));
                    FacadesNotification::route('mail', 'ronanweldon@gmail.com')->notify(new ReceiptNotification($ticket, $charge->receipt_url));
                    FacadesNotification::route('mail', 'Mauricemch@gmail.com')->notify(new ReceiptNotification($ticket, $charge->receipt_url));
                }
                FacadesNotification::route('mail', $ticket->email)->notify(new ReceiptNotification($ticket, $charge->receipt_url, 'Registration Receipt'));

                return redirect()->route('thankYou')->with('success', 'Booking and payment confirmed.');
            } else {
                return response()->json(['error' => 'Payment failed or was canceled.']);
            }
        } catch (\Exception $e) {
            Log::error('Error retrieving PaymentIntent: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to confirm payment.']);
        }
    }

    public function deleteTicket(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentIntentId = $request->input('payment_intent_id');

        try {
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

            if (isset($paymentIntent->metadata->ticket_id)) {
                $ticketId = $paymentIntent->metadata->ticket_id;
                TicketDetail::where('ticket_id', $ticketId)->delete();
                Ticket::destroy($ticketId);


                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => 'Ticket ID not found in payment intent metadata.'], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error deleting ticket: ' . $e->getMessage());

            // Return error response
            return response()->json(['error' => 'Failed to delete ticket.'], 500);
        }
    }

    public function handleWebhook(Request $request)
    {
        Log::info('Webhook works: ');
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $payload = $request->all();
        $stripeSignature = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');
        // $paymentIntentData = $request->input('data.object');
        // Log::info(['paymentIntentData' => $paymentIntentData]);
        // $paymentIntentId = $paymentIntentData['id'];

        // $ticketId = $paymentIntentData['metadata']['ticket_id'] ?? null;
        Log::info('Webhook works: ');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $request->getContent(),
                $stripeSignature,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }
        Log::info('Webhook works: ' . $event->data->object['id']);
        $subscriptionId = $event->data->object['id'];
        switch ($event->type) {
            case 'invoice.payment_succeeded':
                $invoice = $event->data->object;
                $subscription = Subscription::retrieve($invoice->subscription);
                $subscriptionSchedule = SubscriptionSchedule::retrieve($subscription->schedule);
                $ticketId = $subscriptionSchedule->metadata['ticket_id'];
                $this->handlePaymentSucceeded($event->data->object, $ticketId, $subscription->id);
                break;
            case 'invoice.payment_failed':
                Log::info('Installment paid for installment ID: ');
                $invoice = $event->data->object;
                $subscription = Subscription::retrieve($invoice->subscription);
                $subscriptionSchedule = SubscriptionSchedule::retrieve($subscription->schedule);
                $ticketId = $subscriptionSchedule->metadata['ticket_id'];
                $this->handlePaymentFailed($event->data->object, $ticketId, $subscription->id);
                break;
            case 'invoice.payment_action_required':

                Log::info('payment action required in subscription cycle event triggered');
                $invoice = $event->data->object;
                $subscription = Subscription::retrieve($invoice->subscription);
                $subscriptionSchedule = SubscriptionSchedule::retrieve($subscription->schedule);
                $ticketId = $subscriptionSchedule->metadata['ticket_id'];

                Log::info(['metadata' => $subscriptionSchedule->metadata]);
                $paymentIntent = PaymentIntent::retrieve($invoice->payment_intent);
                $url = url('/') . '/stripe/?id=' . $paymentIntent->client_secret;
                Log::info(['url' => $url]);
                Log::info(['email' => $invoice->customer_email]);
                FacadesNotification::route('mail', $invoice->customer_email)->notify(new InvoiceFailedNotification($url));
                Log::info(['error' => 'notification created']);
                break;
            case 'subscription_schedule.canceled':
                $subscriptionSchedule = $event->data->object;
                $ticketId = $subscriptionSchedule->metadata['ticket_id'];

                $this->handleSubscriptionCanceled($event->data->object, $ticketId, $subscriptionId);
                break;
            case 'invoice.upcoming':
                $invoice = $payload['data']['object'];
                $customerEmail = $invoice['customer_email'];

                Mail::to($customerEmail)->send(new \App\Mail\UpcomingInvoice($invoice));

                Log::info('Notification sent for upcoming invoice to: ' . $customerEmail);
                break;
            default:
                Log::info('Unhandled event type: ' . $event->type);
        }

        return response()->json(['status' => 'success']);
    }

    protected function handlePaymentSucceeded($invoice, $ticketId, $subscriptionId)
    {

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            Log::info('Webhook works: ' . $subscriptionId);

            $ticket = Ticket::find($ticketId);
            if (!$ticket) {
                Log::error('No ticket found with ID: ' . $ticketId);
                return;
            }

            $installment = Installment::where('stripe_subscription_id', $subscriptionId)
                ->where('ticket_id', $ticket->id)
                ->where('due_date', '<', Carbon::now())
                ->where('status', 'pending')
                ->first();

            if ($installment) {
                $installment->update(['status' => 'paid']);
                Log::info('Installment paid for installment ID: ' . $installment->id);

                Mail::to($ticket->email)->send(new InstallmentSuccess($ticket, $installment));

                $allInstallments = Installment::where('ticket_id', $ticket->id)
                    ->where('stripe_subscription_id', $subscriptionId)
                    ->get();

                $allPaid = $allInstallments->every(function ($installment) {
                    return $installment->status === 'paid';
                });

                if ($allPaid) {
                    $ticket->update(['status' => 'paid']);
                    Log::info('All installments are paid; ticket ID: ' . $ticket->id . ' marked as paid.');

                    Mail::to($ticket->email)->send(new TicketFullyPaid($ticket));
                }
            } else {
                Log::error('No pending installment found for subscription: ' . $subscriptionId);
            }
        } catch (\Exception $e) {
            Log::error('Error in handling payment success: ' . $e->getMessage());
        }
    }


    protected function handlePaymentFailed($invoice, $ticketId, $invoiceId)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        Log::info('Retrieved Invoice ID in handleSubscriptionCanceled: ' . $invoiceId);

        try {
            $ticket = Ticket::find($ticketId);
            if (!$ticket) {
                Log::error('No ticket found with ID handleSubscriptionCanceled: ' . $ticketId);
                return;
            }

            Log::info('Ticket found: ' . json_encode($ticket));

            $installment = Installment::where('stripe_subscription_id', $invoiceId)
                ->where('status', 'pending')
                ->first();

            if ($installment) {
                $installment->update(['status' => 'failed']);
                Log::info('Installment marked as failed. Installment ID handleSubscriptionCanceled: ' . $installment->id);

                $this->generateInvoice($ticket);

                Mail::to($ticket->email)->send(new InstallmentFailed($ticket, $invoice));

                $this->checkAndMarkTicketAsFailed($ticket, $invoiceId);
            } else {
                Log::error('No pending installment found for subscription handleSubscriptionCanceled: ' . $invoiceId);
            }
        } catch (\Exception $e) {
            Log::error('Error in handling failed installment handleSubscriptionCanceled: ' . $e->getMessage());
        }
    }




    protected function handleSubscriptionCanceled($invoice, $ticketId, $invoiceId)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        Log::info('Retrieved Invoice ID in handleSubscriptionCanceled: ' . $invoiceId);

        try {
            $ticket = Ticket::find($ticketId);
            if (!$ticket) {
                Log::error('No ticket found with ID handleSubscriptionCanceled: ' . $ticketId);
                return;
            }

            Log::info('Ticket found: ' . json_encode($ticket));

            $installment = Installment::where('stripe_subscription_id', $invoiceId)
                ->where('status', 'pending')
                ->first();

            if ($installment) {
                // Mark the installment as failed
                $installment->update(['status' => 'failed']);
                Log::info('Installment marked as failed. Installment ID handleSubscriptionCanceled: ' . $installment->id);

                $this->generateInvoice($ticket);

                Mail::to($ticket->email)->send(new InstallmentFailed($ticket, $invoice));

                $this->checkAndMarkTicketAsFailed($ticket, $invoiceId);
            } else {
                Log::error('No pending installment found for subscription handleSubscriptionCanceled: ' . $invoiceId);
            }
        } catch (\Exception $e) {
            Log::error('Error in handling failed installment handleSubscriptionCanceled: ' . $e->getMessage());
        }
    }


    protected function checkAndMarkTicketAsFailed($ticket, $subscriptionId)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Retrieve all installments for this ticket and subscription
        $allInstallments = Installment::where('ticket_id', $ticket->id)
            ->where('stripe_subscription_id', $subscriptionId)
            ->get();

        // Check if all installments have failed
        $allFailed = $allInstallments->every(function ($installment) {
            return $installment->status === 'failed';
        });

        // If all installments have failed, mark the ticket as failed
        if ($allFailed) {
            $ticket->update(['status' => 'failed']);
            Log::info('All installments failed. Ticket ID: ' . $ticket->id . ' marked as failed.');
        } else {
            Log::info('Not all installments have failed for ticket ID: ' . $ticket->id);
        }
    }




    protected function generateInvoice($ticket)
    {
        return [
            'ticket_id' => $ticket->id,
            'description' => 'Invoice for ticket purchase',
            'amount' => $ticket->total_amount,
            'date' => now()->toDateString(),
            'customer' => $ticket->first_name . ' ' . $ticket->last_name,
        ];
    }

    public function logsDownload()
    {
        $filePath = storage_path('logs/laravel.log');
        if (file_exists($filePath)) {
            return response()->download($filePath, 'laravel.log', ['Content-Type' => 'text/plain']);
        } else {
            abort(404, 'Log file not found');
        }
    }

    // if ($ticket) {
    //     $failureReason = 'The subscription has been canceled.';
    //     $invoiceData = $this->generateInvoice($ticket);

    //     Mail::to($ticket->email)->send(new InstallmentFailed($ticket, $invoiceData, $failureReason));

    //     $ticket->status = 'canceled';
    //     $ticket->save();

    //     // Log the cancellation event
    //     Log::info('Subscription canceled for ticket #' . $ticketId);
    // }


    // public function store(Request $request)
    // {
    //     $validation = Validator::make(
    //         $request->all(),
    //         [
    //             'first_name' => 'required',
    //             'last_name' => 'required',
    //             'email' => ['required', 'email', 'regex:/^[^@]+@[^@]+\.[^@]+$/'],
    //             'phone' => 'required',
    //             'child' => 'required|array',
    //             'child.*.name' => 'required|string|max:255',
    //             'child.*.academy' => 'required|string|max:255',
    //             'child.*.dob'=> 'required|date'
    //         ]
    //     );

    //     if ($validation->fails()) {
    //         return response()->json(['errors' => $validation->errors()], 422);
    //     }
    //     // $ticketsCount = TicketDetail::count();
    //     // $availableTieckets = 300 - $ticketsCount;
    //     // if ($request->quantity > $availableTieckets) {
    //     //     return response()->json(['status' => 'error', 'message' => 'Sorry, we have only ' . ($availableTieckets < 0 ? 0 : $availableTieckets) . ' tickets left'], 422);
    //     // }
    //     try {
    //         Stripe::setApiKey(env('STRIPE_SECRET'));
    //         $stripeCharge = \Stripe\PaymentIntent::create([
    //             'amount' => $request->total_amount * 100,
    //             'currency' => 'EUR',
    //             'description' => 'Payment from cloverunited.',
    //             'confirm' => true,
    //             'payment_method' => $request->stripeToken,
    //             'return_url' => route('paymentSuccess'),
    //             "metadata" => [
    //                 'first_name' => $request->first_name,
    //                 'last_name' => $request->last_name,
    //                 'email' => $request->email,
    //                 'phone' => $request->phone,
    //                 'card_name' => $request->card_name,
    //                 'total_amount' => $request->total_amount,
    //             ],
    //         ]);
    //         \Log::info('Payment intent created:', $stripeCharge->toArray());

    //         if (isset($stripeCharge->next_action->redirect_to_url)) {
    //             session([
    //                 'Data' => $request->all(),
    //             ]);
    //             $redirectUrl = $stripeCharge->next_action->redirect_to_url->url;
    //             return response()->json(['status' => 'redirect', 'url' => $redirectUrl]);
    //         }
    //     } catch (CardException $exception) {
    //         \Log::error('Card error processing payment: ' . $exception->getMessage());
    //         return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 422);
    //         // return response()->json(['success' => false, 'error' => $exception->getMessage()], 400);

    //     } catch (InvalidRequestException $exception) {
    //         \Log::error('Invalid request: ' . $exception->getMessage());
    //         return response()->json(['status' => 'error', 'message' => $exception->getMessage()], 422);
    //         // return response()->json(['success' => false, 'error' => $exception->getMessage()], 400);
    //     } catch (\Exception $e) {
    //         \Log::error('Error processing payment: ' . $e->getMessage());
    //         return response()->json(['status' => 'error', 'message' => $e->getMessage()], 422);
    //         // return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    //     }
    //     if ($stripeCharge->status == "succeeded") {
    //         $booking = $this->createBooking($request, $stripeCharge->id);
    //         if ($booking) {
    //             return response()->json(['status' => 'redirect', 'url' => route('thankYou')]);
    //         } else {
    //             return response()->json(['status' => 'error', 'message' => 'Booking failed']);
    //         }
    //     }
    //     return response()->json(['status' => 'redirect', 'url' => route('bookingForm'), 'message' => 'Booking Cancelled']);
    // }

    // public function paymentSuccess(Request $request)
    // {
    //     $data = Session::get('Data');
    //     $stripeCharge = $request->payment_intent;
    //     $ticket = Ticket::where('transaction_id', $stripeCharge)->first();
    //     if ($ticket) {
    //         return redirect()->route('bookingForm')->with('error', 'Booking already created');
    //     } else {
    //         Stripe::setApiKey(env('STRIPE_SECRET'));
    //         $paymentIntent = PaymentIntent::retrieve($stripeCharge);
    //         if ($paymentIntent->status == "succeeded") {
    //             $paymentMethodId = $paymentIntent->payment_method;
    //             $paymentMethod = PaymentMethod::retrieve($paymentMethodId);
    //             $cardDetails = $paymentMethod->card;
    //             $ticket = new Ticket();
    //             $ticket->first_name = $data['first_name'];
    //             $ticket->last_name = $data['last_name'];
    //             $ticket->email = $data['email'];
    //             $ticket->phone = $data['phone'];
    //             $ticket->card_name = $data['card_name'];
    //             $ticket->total_amount = $data['total_amount'];
    //             $ticket->discount = $data['discount'];
    //             $ticket->transaction_id = $stripeCharge;
    //             $ticket->status = 'paid';
    //             $ticket->card_brand = $cardDetails->brand;
    //             $ticket->last4 = $cardDetails->last4;
    //             $ticket->expiry_month = $cardDetails->exp_month;
    //             $ticket->expiry_year = $cardDetails->exp_year;
    //             $ticket->save();
    //             foreach($data['child'] as $child){
    //                 $ticketDetails = new TicketDetail();
    //                 $ticketDetails->ticket_id = $ticket->id;
    //                 $ticketDetails->name = $child['name'];
    //                 $ticketDetails->academy = $child['academy'];
    //                 $ticketDetails->dob = $child['dob'];
    //                 $ticketDetails->save();
    //             }
    //             DB::commit();
    //             // $tickets = Ticket::with('ticket_details')->find($ticket->id);
    //             // $ticketNumbers = [];
    //             // foreach ($tickets->ticket_details as $ticket) {
    //             //     array_push($ticketNumbers, $ticket->ticket_number);
    //             // }
    //             // $paymentIntent->metadata = array_merge($paymentIntent->metadata->toArray(), [
    //             //     'order_id' => $ticket->id,
    //             //     'ticket_numbers' =>  implode(',', $ticketNumbers),
    //             // ]);

    //             // $paymentIntent->save();

    //             // $ticketNumbers = implode(',', $ticketNumbers);
    //             // $data["email"] = $data['email'];
    //             // $data["title"] = "Naomh Columba Draw Tickets";
    //             // $data["ticketData"] = $tickets;
    //             // $data["ticketNumbers"] = $ticketNumbers;
    //             // $pdf = PDF::loadView('pdfmail', $data);

    //             // if (env('APP_ENV') == 'production') {
    //             //     Mail::send('mail', $data, function ($message) use ($data, $pdf) {
    //             //         $message->to([$data["email"], 'mbyrne@3dpersonnel.com'])
    //             //             ->bcc('saqib.umair@moebotech.com') // Add BCC email address
    //             //             ->subject($data["title"])
    //             //             ->attachData($pdf->output(), "tickets.pdf");
    //             //     });
    //             // } else {
    //             //     Mail::send('mail', $data, function ($message) use ($data, $pdf) {
    //             //         $message->to([$data["email"], 'atasam.imtiaz@moebotech.com'])
    //             //             ->subject($data["title"])
    //             //             ->attachData($pdf->output(), "tickets.pdf");
    //             //     });
    //             // }
    //             $charge = Charge::retrieve($paymentIntent->latest_charge);
    //             // Send email to admin
    //             FacadesNotification::route('mail','atasam.imtiaz@moebotech.com')->notify(new ReceiptNotification($ticket,$charge->receipt_url));
    //             FacadesNotification::route('mail',$ticket->email)->notify(new ReceiptNotification($ticket,$charge->receipt_url,'Registration Receipt'));
    //             return redirect()->route('thankYou');
    //         } else {
    //             DB::rollBack();
    //             return redirect()->route('bookingForm')->with('error', 'Booking cancelled');
    //         }
    //     }
    // }
    // public function createBooking(Request $request, $stripeCharge)
    // {
    //     $ticket = Ticket::where('transaction_id', $stripeCharge)->first();
    //     if ($ticket) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Booking already created'
    //         ], 400);
    //     } else {
    //         Stripe::setApiKey(env('STRIPE_SECRET'));
    //         $paymentIntent = PaymentIntent::retrieve($stripeCharge);
    //         if ($paymentIntent->status == "succeeded") {
    //             $paymentMethodId = $paymentIntent->payment_method;
    //             $paymentMethod = PaymentMethod::retrieve($paymentMethodId);
    //             $cardDetails = $paymentMethod->card;
    //             $ticket = new Ticket();
    //             $ticket->first_name = $request->first_name;
    //             $ticket->last_name = $request->last_name;
    //             $ticket->email = $request->email;
    //             $ticket->phone = $request->phone;
    //             $ticket->card_name = $request->card_name;
    //             $ticket->total_amount = $request->total_amount;
    //             $ticket->discount = $request->discount;
    //             $ticket->transaction_id = $stripeCharge;
    //             $ticket->status = 'paid';
    //             $ticket->card_brand = $cardDetails->brand;
    //             $ticket->last4 = $cardDetails->last4;
    //             $ticket->expiry_month = $cardDetails->exp_month;
    //             $ticket->expiry_year = $cardDetails->exp_year;

    //             $ticket->save();
    //             foreach($request->child as $child){
    //                 $ticketDetails = new TicketDetail();
    //                 $ticketDetails->ticket_id = $ticket->id;
    //                 $ticketDetails->name = $child['name'];
    //                 $ticketDetails->academy = $child['academy'];
    //                 $ticketDetails->dob = $child['dob'];
    //                 $ticketDetails->save();
    //             }
    //             $charge = Charge::retrieve($paymentIntent->latest_charge);
    //             // Send email to admin
    //             FacadesNotification::route('mail','atasam.imtiaz@moebotech.com')->notify(new ReceiptNotification($ticket,$charge->receipt_url));
    //             FacadesNotification::route('mail',$ticket->email)->notify(new ReceiptNotification($ticket,$charge->receipt_url,'Registration Receipt'));
    //         }
    //         DB::commit();
    //         // $tickets = Ticket::with('ticket_details')->find($ticket->id);
    //         // $ticketNumbers = [];
    //         // foreach ($tickets->ticket_details as $ticket) {
    //         //     array_push($ticketNumbers, $ticket->ticket_number);
    //         // }
    //         // $paymentIntent->metadata = array_merge($paymentIntent->metadata->toArray(), [
    //         //     'order_id' => $ticket->id,
    //         //     'ticket_numbers' =>  implode(',', $ticketNumbers),
    //         // ]);
    //         // $paymentIntent->save();
    //         // $ticketNumbers = implode(',', $ticketNumbers);
    //         // $data["email"] = $request->email;
    //         // $data["title"] = "Naomh Columba Draw Tickets";
    //         // $data["ticketData"] = $tickets;
    //         // $data["ticketNumbers"] = $ticketNumbers;
    //         // $pdf = PDF::loadView('pdfmail', $data);
    //         // if (env('APP_ENV') == 'production') {
    //         //     Mail::send('mail', $data, function ($message) use ($data, $pdf) {
    //         //         $message->to([$data["email"], 'mbyrne@3dpersonnel.com'])
    //         //             ->bcc('saqib.umair@moebotech.com') // Add BCC email address
    //         //             ->subject($data["title"])
    //         //             ->attachData($pdf->output(), "tickets.pdf");
    //         //     });
    //         // } else {
    //         //     Mail::send('mail', $data, function ($message) use ($data, $pdf) {
    //         //         $message->to([$data["email"], 'atasam.imtiaz@moebotech.com'])
    //         //             ->subject($data["title"])
    //         //             ->attachData($pdf->output(), "tickets.pdf");
    //         //     });
    //         // }
    //         return $ticket;
    //     }
    // }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    public function thankYou()
    {

        return view('thankyou');
    }
    public function sendEmail()
    {
        if (env('APP_ENV') == 'production') {

            $data = [
                'email' => 'saqib.umair@moebotech.com',
                'title' => 'Dummy Email with PDF Attachment',
                'content' => 'This is a test email with dummy data and a PDF attachment.'
            ];

            // Generate PDF (example using a simple view)
            $pdf = PDF::loadView('dummy', $data);

            // Send email with PDF attachment
            Mail::send('dummy', $data, function ($message) use ($data, $pdf) {
                $message->to([$data['email'], 'abdul.haseeb@moebotech.com'])
                    ->subject($data['title'])
                    ->attachData($pdf->output(), 'tickets.pdf');
            });
            return redirect()->route('bookingForm');
        }
        return redirect()->route('bookingForm');
    }
}
