<form id="payment-form">
    <div id="card-element">
        <!-- placeholder for Elements -->
    </div>
    <button id="card-button">Submit Payment</button>
    <p id="payment-result">
        <!-- we'll pass the response from the server here -->
    </p>
</form>




<script>
    var stripe = Stripe('ADD_YOUR_PUBLIC_KEY_HERE');
    alert("Remember to add your stripe public key and secret key in code.stripe1 and code.stripe2. Remove this code from code.stripe1");

    var elements = stripe.elements();
    var cardElement = elements.create('card');
    cardElement.mount('#card-element');

    var form = document.getElementById('payment-form');

    var resultContainer = document.getElementById('payment-result');
    cardElement.on('change', function(event) {
        if (event.error) {
            resultContainer.textContent = event.error.message;
        } else {
            resultContainer.textContent = '';
        }
    });

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        resultContainer.textContent = "";
        stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
        }).then(handlePaymentMethodResult);
    });

    function handlePaymentMethodResult(result) {
        if (result.error) {
            // An error happened when collecting card details, show it in the payment form
            resultContainer.textContent = result.error.message;
        } else {
            // Otherwise send paymentMethod.id to your server (see Step 3)
            fetch('code.checkout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    payment_method_id: result.paymentMethod.id
                })
            }).then(function(result) {
                return result.json();
            }).then(handleServerResponse);
        }
    }

    function handleServerResponse(responseJson) {
        if (responseJson.error) {
            // An error happened when charging the card, show it in the payment form
            resultContainer.textContent = responseJson.error;
        } else {
            // Show a success message
            resultContainer.textContent = 'Success!';
        }
    }
</script>