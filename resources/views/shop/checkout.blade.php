@extends('layouts.app')

@section('title','Shopping Now')
@section('style')
	<style type="text/css">
		/**
		 * The CSS shown here will not be introduced in the Quickstart guide, but shows
		 * how you can use CSS to style your Element's container.
		 */
		.StripeElement {
		  background-color: white;
		  height: 40px;
		  padding: 10px 12px;
		  border-radius: 4px;
		  border: 1px solid transparent;
		  box-shadow: 0 1px 3px 0 #e6ebf1;
		  -webkit-transition: box-shadow 150ms ease;
		  transition: box-shadow 150ms ease;
		}

		.StripeElement--focus {
		  box-shadow: 0 1px 3px 0 #cfd7df;
		}

		.StripeElement--invalid {
		  border-color: #fa755a;
		}

		.StripeElement--webkit-autofill {
		  background-color: #fefde5 !important;
		}
	</style>
@endsection
@section('content')

<h2>Checkout</h2>
<hr>
<div class="container">
<form action="{{ route('checkout.store') }}" method="post" id="payment-form" class="col-sm-6">

	{{ csrf_field() }}

	<div class="form-group">
		<label for="name">Full Name</label>
		<input type="text" name="name" class="form-control" id="name">
	</div>
	<div class="form-group">
		<label for="address">Address</label>
		<input type="text" name="address" class="form-control" id="address">
	</div>
	<div class="form-group">
		<label for="city">City</label>
		<input type="text" name="city" class="form-control" id="city">
	</div>
	<div class="form-group">
		<label for="province">Province</label>
		<input type="text" name="province" class="form-control" id="province">
	</div>
	<div class="form-group">
		<label for="phone">Phone Number</label>
		<input type="text" name="phone" class="form-control" id="phone">
	</div>
	<div class="form-group">
		<label for="postalcode">PostalCode</label>
		<input type="text" name="postalcode" class="form-control" id="postalcode">
	</div>
	<hr>
  <div class="form-row">
    <label for="card-element">
      <h3>Credit or debit card</h3>
    </label>
    <div id="card-element">
      <!-- A Stripe Element will be inserted here. -->
    </div>

    <!-- Used to display form errors. -->
    <div id="card-errors" role="alert"></div>
  </div>
  <br>
  <button class='btn btn-success col-sm-12'>Submit Payment</button>
</form>
</div>
<br><br>


@stop
@section('scripts')
	<script src="https://js.stripe.com/v3/"></script>
	<script type="text/javascript">
		// Create a Stripe client.
		var stripe = Stripe('pk_test_7AIbYTrRafOPSsV8x8r3u6NU');

		// Create an instance of Elements.
		var elements = stripe.elements();

		// Custom styling can be passed to options when creating an Element.
		// (Note that this demo uses a wider set of styles than the guide below.)
		var style = {
		  base: {
		    color: '#32325d',
		    lineHeight: '18px',
		    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
		    fontSmoothing: 'antialiased',
		    fontSize: '16px',
		    '::placeholder': {
		      color: '#aab7c4'
		    }
		  },
		  invalid: {
		    color: '#fa755a',
		    iconColor: '#fa755a'
		  }
		};

		// Create an instance of the card Element.
		var card = elements.create('card', {
			style: style,
			hidePostalCode:true

		});

		// Add an instance of the card Element into the `card-element` <div>.
		card.mount('#card-element');

		// Handle real-time validation errors from the card Element.
		card.addEventListener('change', function(event) {
		  var displayError = document.getElementById('card-errors');
		  if (event.error) {
		    displayError.textContent = event.error.message;
		  } else {
		    displayError.textContent = '';
		  }
		});

		// Handle form submission.
		var form = document.getElementById('payment-form');
		form.addEventListener('submit', function(event) {
		  event.preventDefault();

		  var options = {
		  	name : document.getElementById('name').val,
		  	address_line1 : document.getElementById('address').val,
		  	address_city  : document.getElementById('city').val,
		  	address_state : document.getElementById('province').val,
		  	address_zip   : document.getElementById('postalcode').val

		  }

		  stripe.createToken(card , options).then(function(result) {
		    if (result.error) {
		      // Inform the user if there was an error.
		      var errorElement = document.getElementById('card-errors');
		      errorElement.textContent = result.error.message;
		    } else {
		      // Send the token to your server.
		      stripeTokenHandler(result.token);
		    }
		  });
		});
		function stripeTokenHandler(token) {
		  // Insert the token ID into the form so it gets submitted to the server
		  var form = document.getElementById('payment-form');
		  var hiddenInput = document.createElement('input');
		  hiddenInput.setAttribute('type', 'hidden');
		  hiddenInput.setAttribute('name', 'stripeToken');
		  hiddenInput.setAttribute('value', token.id);
		  form.appendChild(hiddenInput);

		  // Submit the form
		  form.submit();
		}
	</script>

@endsection