@extends('layouts.app')

@section('title','Shopping Now')

@section('content')

<div class="container">
	<div class="row justify-content-center">
		<form action="{{ route('storeProducts') }}" method="post" enctype="multipart/form-data" class="form-group">
			{{ csrf_field() }}
			<div class="form-group">
			    <label for="name">Product Name : </label>
			    <input type="text" name="name" id="name" class="form-control">
		    </div>
		    <div class="form-group">
			    <label for="decs">Description : </label>
			    <textarea rows="5" id="decs" name="desc" class="form-control"></textarea>
		    </div>
		    <div class="form-group">
			    <label for="price">Product Price</label>
			    <input type="text" name="price" id="price" class="form-control" placeholder="100 = 1.00 $">
		    </div>
			<div class="form-group">
			    <label for="file">Select image to upload:</label>
			    <input type="file" name="file" id="file" class="form-control">
		    </div>
		    <br>
		    <input type="submit" value="Upload Image" name="submit" class="btn btn-primary">
		</form>
	</div>
</div>

@endsection