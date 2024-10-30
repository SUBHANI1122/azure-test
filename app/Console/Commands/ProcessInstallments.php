<?php

namespace App\Console\Commands;

use App\Models\Installment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class ProcessInstallments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'installments:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process due installments and charge the payment method';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Get today's date
        $today = now()->toDateString();

        // Fetch installments due today or earlier and still pending
        $installments = Installment::where('due_date', '=', $today)
            ->where('status', 'pending')
            ->with('ticket')
            ->get();

        foreach ($installments as $installment) {
            $ticket = $installment->ticket;

            if ($ticket->stripe_customer_id && $ticket->stripe_payment_method_id) {
                try {
                    $paymentIntent = PaymentIntent::create([
                        'amount' => $installment->amount * 100, // in cents
                        'currency' => 'usd', // change as needed
                        'customer' => $ticket->stripe_customer_id,
                        'payment_method' => $ticket->stripe_payment_method_id,
                        'off_session' => true,
                        'confirm' => true,
                        'metadata' => [
                            'ticket_id' => $ticket->id,
                            'type' => 'installment',
                        ],
                    ]);

                    if ($paymentIntent->status == 'succeeded') {
                        // Update installment and ticket
                        $installment->status = 'paid';
                        $installment->save();

                        $ticket->remaining_amount -= $installment->amount;
                        if ($ticket->remaining_amount <= 0) {
                            $ticket->status = 'paid';
                        }
                        $ticket->save();
                    } else {
                        // Handle other statuses if necessary
                        $installment->status = 'failed';
                        $installment->save();
                    }
                } catch (\Stripe\Exception\CardException $e) {
                    // Payment failed
                    Log::error('Installment payment failed: ' . $e->getError()->message);
                    $installment->status = 'failed';
                    $installment->save();

                    // Send email to user to update payment method
                    // Mail::to($ticket->email)->send(new InstallmentFailed($ticket, $installment));
                } catch (\Exception $e) {
                    Log::error('Error processing installment: ' . $e->getMessage());
                    // Optionally, set installment as failed
                    $installment->status = 'failed';
                    $installment->save();
                }
            }
        }
        return 0;
    }
}
