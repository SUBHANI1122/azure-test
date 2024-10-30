<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
    var paymentIntentId = @json($paymentIntentId);
    // Confirm the PaymentIntent
    stripe.confirmCardPayment(paymentIntentId).then(function(result) {
        if (result.error) {
            // Show error to your customer (e.g., insufficient funds)
            // window.location.href = failureUrl;
            console.error(result.error.message);
            console.log('error');
        } else {
            if (result.paymentIntent.status === 'succeeded') {
                // Payment succeeded, handle success (e.g., update UI, redirect, etc.)
                console.log('Payment succeeded!');
                // window.location.href = returnUrl;
            } else {
                // Handle other statuses (requires_payment_method, etc.)
                // window.location.href = failureUrl;
                console.log('Payment requires further action:', result.paymentIntent.status);
                console.log('error123');
            }
        }
    });
</script>
