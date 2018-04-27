@extends('layouts.app')

@section('title','Shopping Now')

@section('content')
	@if(Session::has('cart'))

	<div class="row">
		<div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
			<ul class="list-group">
				@foreach($products as $product)
					<li class="list-group-item">
						<span class="badge">{{ $product['qty'] }}</span>
						<strong>{{ $product['item']['name'] }}&nbsp&nbsp</strong>
						<span class="label label-success">$ {{ $product['price']/100 }}</span>
						<div class="btn-group pull-right">
							<button class="btn btn-primary btn-xs dropdown-toggle" data-toggle='dropdown'>Action <span class="caret"></span></button>
							<ul class="dropdown-menu">
								<li><a href="{{ route('product.reduceByOne',['id'=>$product['item']['id']]) }}">Reduce by 1</a></li>
								<li><a href="{{ route('product.removeItem',['id'=>$product['item']['id']]) }}">Reduce by all</a></li>
							</ul>
						</div>
					</li>
				@endforeach
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
			<strong>Total : $ {{ $totalPrice/100 }}</strong>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
			<a href="{{ route('checkout.index') }}" class="btn btn-success">Checkout</a>
		</div>
	</div>

	@else
	<div class="row">
		<div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
			<h2>No Items In Cart please ga <a href="{{ route('index') }}">Back</a> To Add Some Products</h2>
		</div>
	</div>

@endif
@endsection