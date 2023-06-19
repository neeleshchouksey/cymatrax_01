<!DOCTYPE html>
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
</head>
<body>
  <script src="https://www.paypal.com/sdk/js?client-id=AcKJgcQMvUirljnaVpwzQvzQt2D-9iPnOZe89upmpgp9IFQ4yS2sQZp3ZyMf4gBtOxDxOR0xWz4qENsk&vault=true&intent=subscription">
  </script>
     <div id="paypal-button-container"></div>
      <script>
       paypal.Buttons({
        createSubscription: function(data, actions) {
          return actions.subscription.create({
           'plan_id': 'P-61C47222A9199480WMR3CJTA' // Creates the subscription
           });
         },
         onApprove: function(data, actions) {
           alert('You have successfully subscribed to ' + data.subscriptionID); // Optional message given to subscriber
         }
       }).render('#paypal-button-container'); // Renders the PayPal button
      </script>
  </body>
</html>
{{-- 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="post" action="{{route('subscription')}}">
    
        <button type="submit">Pay Now</button>
    </form>
</body>
</html> --}}