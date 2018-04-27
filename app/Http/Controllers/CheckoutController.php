<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Cart;
use App\Order;
use Auth;
use Stripe;
use Illuminate\Support\Str;
class CheckoutController extends Controller
{
    public function index()
    {
    	$oldCart = Session::get('cart');
        $cart    = new Cart($oldCart);
    	return view('shop.checkout',['products'=>$cart->items , 'totalPrice'=>$cart->totalPrice]);
    }

    public function store(Request $request)
    {
    	try {
    		$oldCart = Session::get('cart');
        	$cart    = new Cart($oldCart);

    		// Set your secret key: remember to change this to your live secret key in production
			// See your keys here: https://dashboard.stripe.com/account/apikeys
			\Stripe\Stripe::setApiKey("sk_test_N6I3fB8EWgRbBr2lbDV6GixX");

			// Charge the user's card:
			$charge = \Stripe\Charge::create(array(
			  "amount" => $cart->totalPrice,
			  "currency" => "usd",
			  "description" => "Order",
			  "source" => $request->stripeToken,
			  "metadata" => [

			  ]
			));
			//Successful
            $order = new Order();
            $order->order      = serialize($cart);
            $order->payment_id = $charge->id;
            $order->name       = $request->name;
            $order->address    = $request->address;
            $order->city       = $request->city;
            $order->Province   = $request->province;
            $order->phone      = $request->phone;
            $order->PostalCode = $request->postalcode;
            Auth::user()->orders()->save($order);
			Session::forget('cart');
			return redirect()->route('index')->with('success_message','Thank you! Your Payment has been Successfully accepted!');
    	} catch (Exception $e) {
    		
    	}
    }
}
