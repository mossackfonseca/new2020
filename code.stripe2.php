<?php
# vendor using composer
//('vendor/autoload.php');

use Stripe\Issuing\CardDetails;

require_once('stripe/init.php');

\Stripe\Stripe::setApiKey('ADD_YOUR_SECRET_KEY_HERE');

header('Content-Type: application/json');


# retrieve JSON from POST body
$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str);
try {
    // Create the PaymentIntent
    $intent = \Stripe\PaymentIntent::create([
        'amount' => $total * 100,
        'currency' => 'usd',
        'payment_method' => $json_obj->payment_method_id,

        # A PaymentIntent can be confirmed some time after creation,
        # but here we want to confirm (collect payment) immediately.
        'confirm' => true,

        # If the payment requires any follow-up actions from the
        # customer, like two-factor authentication, Stripe will error
        # and you will need to prompt them for a new payment method.
        'error_on_requires_action' => true,
    ]);
    generateResponse($intent);
} catch (\Stripe\Exception\ApiErrorException $e) {
    // Display error on client
    echo json_encode(['error' => $e->getMessage()]);
}

function generateResponse($intent)
{
    if ($intent->status == 'succeeded') {
        // Handle post-payment fulfillment
        echo json_encode(['success' => true]);
    } else {
        // Any other status would be unexpected, so error
        echo json_encode(['error' => 'Invalid PaymentIntent status']);
    }
}
