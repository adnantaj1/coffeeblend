@extends('layouts.app')
@section('content')
<div class="container">
    <!-- Replace "test" with your own sandbox Business account app client ID -->
    <script src="https://www.paypal.com/sdk/js?client-id=ATSuas8U_ZVfL-Fv7OdAcRLq_SXEXZn87WbS9khGDsGbxFJwO3ZmNXdTO7mX2SR2Dr0Wi4TUtXOuh8Xu&currency=DKK"></script>
    <!-- Set up a container element for the button -->
    <div id="paypal-button-container"></div>
    <script>
        paypal.Buttons({
            // Sets up the transaction when a payment button is clicked
            createOrder: (data, actions) => {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '{{Session::get('price')}}' // Can also reference a variable or function
                        }
                    }]
                });
            },
            // Finalize the transaction after payer approval
            onApprove: (data, actions) => {
                return actions.order.capture().then(function(orderData) {

                    window.location.href = 'success';
                });
            }
        }).render('#paypal-button-container');
    </script>

</div>

@endsection
